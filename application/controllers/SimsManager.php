<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\Authorization;
use Libraries\SmartResponse;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use \Exception as Exception;


use Libraries\Permissions;
use Libraries\Sims;
use Libraries\Logger;


defined('BASEPATH') OR exit('No direct script access allowed');

class SimsManager extends REST_Controller {
    private $authorization;
    private $permissions;
    private $sims;

    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
        $this->permissions = new Permissions();
        $this->sims = new Sims();
    }

    public function createSims_post(){
        $response = new SmartResponse();

        $Logger = new Logger();

     

        $PERMISSION_GESTION_SIMS = 10;

       try{
            $tokenString = $this->input->get_request_header('Authorization');
            
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
            
            $simsData = $this->post("sims");

            $simsData = (object) json_decode(json_encode($simsData));

            $this->permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_SIMS);  

            switch ($tokenData->clientType) {
                case 1: //cliente
                    //$simsData->distributorID=$tokenData->distributorID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                case 2: //distribuidor
                   // idCliente=null almacen
                 

                    $simsData->distributorID=$tokenData->clientID;
                    break;
                case 3: //admin
                     //$simsData->distributorID=$tokenData->clientID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                
                default:
                throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
            }
            
            
            $simsID = $this->sims->createSims($simsData);
            

            //registrar en bitacora
            $Logger->recordUserAction($tokenData->userID, 4, $simsID, 1);



            $response->onSuccess();
            $response->addData("simsID",$simsID);
            
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

    public function getSimStore_get(){
        $response = new SmartResponse();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $tokenData = $this->authorization->getTokenData($tokenString); 
            //obtener lista de dispositivos de almacen
            if($tokenData->clientType == 2){
                //Si el usuario pertenece a cliente distribuidor
                $clientID = $this->get("clientID");

                $cliente = empty($clientID) ? $tokenData->clientID : $clientID;
                $sims = $this->sims->getSimListByClient($cliente);
            }
            else{
                throw new HttpException("UNAUTHORIZED","Solo las cuentas distribuidor pueden realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
           
            $response->addData("sims",$sims);
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

    public function getSims_get($simID){
        $response = new SmartResponse();

        $Logger = new Logger();

     

        $PERMISSION_GESTION_SIMS = 10;

       try{
            $tokenString = $this->input->get_request_header('Authorization');
            
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
            

            $this->permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_SIMS);  

            switch ($tokenData->clientType) {
                case 1: //cliente
                    //$simsData->distributorID=$tokenData->distributorID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                case 2: //distribuidor
                   // idCliente=null almacen
                    $distributorID=$tokenData->clientID;
                    break;
                case 3: //admin
                     //$simsData->distributorID=$tokenData->clientID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                
                default:
                throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
            }
            
            
            $dataSims = $this->sims->getSims($simID);
            

            //registrar en bitacora
            //$Logger->recordUserAction($tokenData->userID, 4, $simsID, 1);



            $response->onSuccess();
            $response->addData("sims",$dataSims);
            
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

    public function updateSims_put($simID){
        $response = new SmartResponse();

        $Logger = new Logger();

     

        $PERMISSION_GESTION_SIMS = 10;

       try{
            $tokenString = $this->input->get_request_header('Authorization');
            
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $simsData = $this->put("sims");

            $simsData = (object) json_decode(json_encode($simsData));
            

            $this->permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_SIMS);  

            switch ($tokenData->clientType) {
                case 1: //cliente
                    //$simsData->distributorID=$tokenData->distributorID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                case 2: //distribuidor
                   // idCliente=null almacen
                    $distributorID=$tokenData->clientID;
                    break;
                case 3: //admin
                     //$simsData->distributorID=$tokenData->clientID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                
                default:
                throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
            }
            
            
            $dataSims = $this->sims->updateSims($simsData,$simID);
            

            //registrar en bitacora
            $Logger->recordUserAction($tokenData->userID, 4, $simID, 5);



            $response->onSuccess();
            $response->addData("sims",$dataSims);
            
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

    public function deleteSims_delete($simID){
        $response = new SmartResponse();

        $Logger = new Logger();

     

        $PERMISSION_GESTION_SIMS = 10;

       try{
            $tokenString = $this->input->get_request_header('Authorization');
            
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
            

            $this->permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_SIMS);  

            switch ($tokenData->clientType) {
                case 1: //cliente
                    //$simsData->distributorID=$tokenData->distributorID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                case 2: //distribuidor
                   // idCliente=null almacen
                    $distributorID=$tokenData->clientID;
                    break;
                case 3: //admin
                     //$simsData->distributorID=$tokenData->clientID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                
                default:
                throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
            }
            
            
            $dataSims = $this->sims->deleteSims($simID);
            

            //registrar en bitacora
            $Logger->recordUserAction($tokenData->userID, 4, $simID, 2);



            $response->onSuccess();
            $response->addData("sims",$dataSims);
            
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