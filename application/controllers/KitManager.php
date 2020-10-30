<?php
// Default imports;
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use \Exception as Exception;

use Libraries\SmartResponse;
use Libraries\Authorization;
use Libraries\Permissions;

//Custom Imports
use Libraries\Kit;


defined('BASEPATH') OR exit('No direct script access allowed');

class KitManager extends REST_Controller {
    private $authorization;
    private $permissions;
    private $kit;
    private $PERMISO_GESTION_KIT;

    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
        $this->permissions = new Permissions();

        $this->kit = new Kit();
        $this->PERMISO_GESTION_KIT = 18;
    }
    public function kit_post(){
        $response = new SmartResponse();
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $this->permissions->validatePermission($tokenData->userID, $this->PERMISO_GESTION_KIT);

            $kitData = $this->post("kit");
            $products = $this->post("products");

            $products = (object) json_decode(json_encode($products));
            
            $kitData = (object) json_decode(json_encode($kitData));
            $kitData->clientID = $tokenData->clientID;
            $kitData->products = $products;

            $kitID = $this->kit->create($kitData);

            $response->addData("kitID", $kitID);
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

    public function kit_get($kitID){
        $response = new SmartResponse();
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            if( $this->kit->isOwner($tokenData->clientID, $kitID) ){
                $data = $this->kit->get($kitID);
                $response->addData("kit", $data);
                $response->onSuccess();
            }
            else{
                throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
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
    public function kits_get(){
        $response = new SmartResponse();
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $kits = $this->kit->getKits($tokenData->clientID);
            $response->addData("kits", $kits);
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
    public function kit_put($kitID){
        $response = new SmartResponse();
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            if( $this->kit->isOwner($tokenData->clientID, $kitID) ){
                $kitData = $this->put("kit");
                $products = $this->put("products");
    
                $products = (object) json_decode(json_encode($products));
                
                $kitData = (object) json_decode(json_encode($kitData));
                $kitData->products = $products;

                $result = $this->kit->update($kitID, $kitData);
                $response->onSuccess();
            }
            else{
                throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
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
    public function kit_delete($kitID){
        $response = new SmartResponse();
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            if( $this->kit->isOwner($tokenData->clientID, $kitID) ){
                $this->kit->delete($kitID);
                $response->onSuccess();
            }
            else{
                throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
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


}//End of class