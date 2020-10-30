<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Libraries\User;
use Libraries\DeviceGPS;
use Libraries\Permissions;
use Libraries\Token;
use Libraries\SmartResponse;
use Libraries\Fleet;




defined('BASEPATH') OR exit('No direct script access allowed');

class IniciarSesion extends REST_Controller{

    
    public function login_get(){
        $user = new User();
        $deviceGPS = new DeviceGPS();
        $token = new Token;
        $response = new SmartResponse();
        $fleet = new Fleet();
        $permissions = new Permissions();

        // $account = $this->get('account');
        $username = $this->get('user');
        $password = $this->get('password');
        
        try{
            $isValidUser = $user->validateUser($username, $password);
            if($isValidUser){
                $userDataAccess = $user->getDataAccess($username);
                
                if(!$userDataAccess->distributorStatus || $userDataAccess->distributorStatus == -1)
                    throw new HttpException("PROVIDER_SUSPEND","El provedor del servicio se encuentra suspendido", HttpStatusCode::HTTP_UNAUTHORIZED);
                elseif (!$userDataAccess->clientStatus || $userDataAccess->clientStatus == -1)
                    throw new HttpException("ACCOUNT_SUSPEND","La cuenta se encuentra suspendida", HttpStatusCode::HTTP_UNAUTHORIZED);
                elseif(!$userDataAccess->userStatus || $userDataAccess->userStatus == -1)
                    throw new HttpException("USER_SUSPEND","El usuario se encuentra suspendido", HttpStatusCode::HTTP_UNAUTHORIZED);
                else{

                    $isFirstTimeLogin = false;
                    if($userDataAccess->lastTimestampLogin <= 0)
                        $isFirstTimeLogin = true;
                    else
                        $user->updateLastLogin($userDataAccess->userID);
                        

                    $user->registerLogin($userDataAccess->userID);
                    $permissionsList = $permissions->getUserPermissions($userDataAccess->userID);
                    $devices = $deviceGPS->getDevices($userDataAccess->userID);

                    if($userDataAccess->clientType == 2 ){ //ClientType==Distributor
                        //Obtener Flotilla Virtual
                        $fleets = $fleet->getVirtualFleets($userDataAccess->clientID);
                        foreach($devices as $device){
                            $device->fleetID = $device->clientID;
                        }
                    }else{
                        $fleets = $fleet->getFleets($userDataAccess->userID);
                    }
                                                
                    $payload = array(
                        "tokenType" => 'LOGIN',
                        "distributorID" => $userDataAccess->distributorID,
                        "clientID" =>  $userDataAccess->clientID,
                        "clientType" => $userDataAccess->clientType,
                        "userID" => $userDataAccess->userID,
                        "userType" => $userDataAccess->userType,                        
                    );

                    //TODO: Agregar tiempo de expiracion / tiempo de validez para el token?                   
                    // $tokenPayload->exp = $date->getTimestamp()+180; 
                    $tokenString = $token->encode($payload); 


                    $response->onSuccess();
                    $response->addData('session', array(
                        "isFirstTimeLogin" => $isFirstTimeLogin,
                        "timezone" => $userDataAccess->timeZone,
                        "token" => $tokenString,
                        "userType" => $userDataAccess->userType,
                        "clientType" => $userDataAccess->clientType,
                        "user" => $userDataAccess->userName,
                        "client" => $userDataAccess->clientName,
                        "permissions" => $permissionsList
                    ));
                    $response->addData('devices', $devices);
                    $response->addData('fleets',  $fleets);

                }
                
                
            }
            else{
                throw new HttpException("LOGIN_FAIL", "El usuario o la contraseña es incorrecta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson());
        }
    }

    public function getLogo_get(){
        $response = new SmartResponse();
        $user = new User();

        try{
        
            $userId = $this->get("user");
               
                $dataUserLogo = $user->getLogo($userId);

                $response->addData("user", $dataUserLogo);
                $response->onSuccess();
            
           
              
            
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function getLogoUser_get(){
        $response = new SmartResponse();
        $user = new User();

        try{
        
            $userId = $this->get("user");
               
                $dataUserLogo = $user->getLogoUser($userId);

                $response->addData("user", $dataUserLogo);
                $response->onSuccess();
            
           
              
            
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson(), $response->statusCode);
        }
    }


    public function recoverPassword_get(){
        $user = new User();
        $response = new SmartResponse();
        try{
            $email = $this->get('email');
            $emailExists = $user->emailExists($email);
            if($emailExists){
                $user->recoverPassword($email);
                $response->onSuccess();
            }
            else{
                throw new HttpException("EMAIL_NOT_EXISTS","El correo electronico no existe",HttpStatusCode::HTTP_NOT_FOUND);
            }

        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson());
        }
        
    }

    public function setPassword_put(){

        $user = new User();
        $token = new Token();
        $response = new SmartResponse();

        $tokenString = $this->input->get_request_header('Authorization');
        $password = $this->put('password');


        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                $tokenString = $token->clearToken($tokenString); 
                $tokenType = $token->getTokenType($tokenString);
                $userID = $token->getUserID($tokenString);
                
                

                if($tokenType == 'LOGIN' || $tokenType == 'RECOVER_PASSWORD'){
                    if($tokenType == 'RECOVER_PASSWORD'){
                        $validOperationToken = $user->validateOperationToken($userID, $tokenString);
                        if($validOperationToken){
                            $username = $user->getUsername($userID);
                            $response->addData('user', $username);
                        }
                        else{
                            throw new HttpException('INVALID_OPERATION_TOKEN','el token es invalido o ha expirado', HttpStatusCode::HTTP_UNAUTHORIZED);
                        }
                    }       
                    $user->setPassword($userID, $password); 
                    $user->updateLastLogin($userID);
                    $user->deleteOperationToken($userID);             
                    $response->setSuccess(true); 

                }
                else{
                    throw new HttpExeption('INVALID_TOKEN', "El token no tiene privilegios para realizar esta solicitud", HttpStatusCode::HTTP_UNAUTHORIZED);
                }
                 
            }
            else{
                throw new HttpExeption('INVALID_TOKEN', "El token es invalido o ha expirado", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson());
        }   
    }

    public function validateToken_get(){
        $user = new User();
        $token = new Token();
        $response = new SmartResponse();

        $tokenString = $this->get('token');

        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                $tokenString = $token->clearToken($tokenString); 
                $tokenType = $token->getTokenType($tokenString);
                $userID = $token->getUserID($tokenString);
                         
                if($tokenType == 'RECOVER_PASSWORD'){
                    $validOperationToken = $user->validateOperationToken($userID, $tokenString);
                    if($validOperationToken == false){
                        throw new HttpException('INVALID_OPERATION_TOKEN','el token es invalido o ha expirado', HttpStatusCode::HTTP_UNAUTHORIZED);
                    }
                } 
          
                $response->setSuccess(true);       
            }
            else{
                throw new HttpExeption('INVALID_TOKEN', "El token es invalido o ha expirado", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson());
        }

    }
}