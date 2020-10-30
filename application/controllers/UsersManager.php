<?php
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use Libraries\Authorization;
use Libraries\SmartResponse;
use \Exception as Exception;

use Libraries\User;
use Libraries\DeviceGPS;
use Libraries\Permissions;


defined('BASEPATH') OR exit('No direct script access allowed');

class UsersManager extends REST_Controller{
    public function createUser_post(){
        $response = new SmartResponse();
        $authorization = new Authorization();
        $user = new User();
        $device = new DeviceGPS();
        $permissions = new Permissions();

        $PERMISSION_GESTION_USUARIOS_ADMINISTRADOR = 11;
        $PERMISSION_GESTION_USUARIOS_DISTRIBUIDOR = 12;
        $PERMISSION_GESTION_USUARIOS = 8;

        try{
            //Validar Token
            $tokenString = $this->input->get_request_header('Authorization');
            
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString); 

            //Obtener datos del post
            $json = $this->post('user');
            $userData = (object) json_decode(json_encode($json));

            $json = $this->post('devices');
            $userData->devices = (object) json_decode(json_encode($json));

            $userData->clientID = $tokenData->clientID;
            $userData->userType = 2;

            //Note: Todo usuario que se registre por este medio sera de tipo asociado por default
            //pero considerar que envien el userType por si en algun momento esta funcion cambia
            // switch($tokenData->clientType){
            //     case 1:
            //         //El usuario que solicita la creacion de un asociado, pertenece a una cuenta tipo cliente
            //         $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS);
            //         break;
                
            //     case 2:
            //         //El usuario que solicita la creacion de un asociado, pertenece a una cuenta tipo distribuidor
            //         $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS_DISTRIBUIDOR);
            //         break;

            //     case 3:
            //         //El usuario que solicita la creacion de un asociado, pertenece a una cuenta tipo administrador
            //         $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS_ADMINISTRADOR); 
            //         break;
                
            //     default:
            //     throw new HttpException("BAD_REQUEST","La peticion no es valida",HttpStatusCode::HTTP_BAD_REQUEST);
            // }

            $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS);
            
            $result = $user->createUser($userData);
            $response->addData("userID",$result);
            $response->onSuccess(HttpStatusCode::HTTP_CREATED);            
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

    

    public function getUser_get($userID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $user = new User();
        $device = new DeviceGPS();
        $permissions = new Permissions();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $PERMISSION_GESTION_USUARIOS = 8;
            $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS);

               //Verificar que token.userID pertenezca a la misma cuenta que se quiere consultar
               $clientID = $user->getClientID( $userID);
               if($clientID==$tokenData->clientID){                        
                   $userInfo = $user->getUserInfo($userID); //obtener la informacion del usuario
                   $devices = $device->getDeviceList($userID); //Obtener la lista de dispositivos

                   $response->addData("user", $userInfo);
                   $response->addData("devices",$devices);
               }
               else{
                   throw new HttpException("UNAUTHORIZED", "No cuenta con privilegios para consultar este usuario", HttpStatusCode::HTTP_UNAUTHORIZED);
               }

            
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

    public function getUsers_get(){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $user = new User();
        $device = new DeviceGPS();
        $permissions = new Permissions();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString); 
            
            // $PERMISSION_GESTION_USUARIOS = 8;
            // $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS);

            

            $users = $user->getUserList($tokenData->clientID); //obtener la informacion del usuario        
            $response->addData("users",$users);

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

    public function user_delete($userID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $user = new User();
        $permissions = new Permissions();
     
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString); 

            $PERMISSION_GESTION_USUARIOS = 8;
            $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS);

           
            $user->deleteUser_legacy($tokenData, $userID);
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


    public function updateUser_put($userID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $user = new User();
        $device = new DeviceGPS();
        $permissions = new Permissions();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString);

            $PERMISSION_GESTION_USUARIOS = 8;
            $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS);

           
            
            $json = $this->put('user');
            $userData = (object) json_decode(json_encode($json));
            
            $result = $user->updateUser($tokenData, $userID, $userData);
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

    public function userStatus_put($userID){
        $response = new SmartResponse();
        $authorization = new Authorization();
        $permissions = new Permissions(); 
        $user = new User();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString);

            $PERMISSION_GESTION_USUARIOS = 8;
            $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_USUARIOS);          
            
            //validar que es usuario de mi cliente
            $isOwner = $user->isOwner($tokenData->clientID, $userID);

            if($isOwner){
                $userStatus = $this->put("status");
                if(is_bool($userStatus)){
                    $user->updateStatus($userID, $userStatus);
                    $response->onSuccess();
                }
                else
                    throw new HttpException("BAD_REQUEST","param 'status' must be boolean", HttpStatusCode::HTTP_BAD_REQUEST);  
            }
            else
                throw new HttpException("UNAUTHORIZED","NO cuenta con permisos de propiedad, para realizar esta accion", HttpStatusCode::HTTP_UNAUTHORIZED);                 
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

    public function template_get(){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $user = new User();
        $permissions = new Permissions();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

           
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
    
}