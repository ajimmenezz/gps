<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\Authorization;
use Libraries\SmartResponse;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use \Exception as Exception;

use Libraries\Permissions;
use Libraries\Store;

defined('BASEPATH') OR exit('No direct script access allowed');

class StoreManager extends REST_Controller {
    private $authorization;
    private $permissions;
    private $store;

    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
        $this->permissions = new Permissions();
        $this->store = new Store();
    }

    public function summary_get(){
        $response = new SmartResponse();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
            
            $clientID = $this->get("clientID");

            $cliente = empty($clientID) ? $tokenData->clientID : $clientID;

            $summary = $this->store->getSummary($cliente);
            $response->addData("summary", $summary);
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

    public function products_get(){
        $response = new SmartResponse();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $params = new \stdClass();
            $paginationToken = $this->get("paginationToken");
            if( isset($paginationToken) && !empty($paginationToken)){
                //Token de paginacion encontrado
                $b64 = base64_decode($paginationToken);
                $params = unserialize($b64);
            }
            else{
                $clientID = $this->get("clientID");

                $params->clientID = empty($clientID) ? $tokenData->clientID : $clientID; 

                //TODO: SI clientID != tokenData->clientID, verificar si ese cliente le pertenece a tokenData->clientID
                
                $params->id = $this->get("id");
                $params->productType = $this->get("productType");
                $params->factory = $this->get("factory");
                $params->model = $this->get("model");
                $params->onTransfers = $this->get("onTransfers"); 
                $params->limit = $this->get("limit");
                $params->pagination = 0; 
            }

            if( !isset($params->onTransfers)){
                $params->onTransfers = true;
            }
            else
            {
                if($params->onTransfers == 'false')
                    $params->onTransfers = false;
                else //true o cualquier otro valor
                    $params->onTransfers = true;
            }

            if( isset($params->limit) == false || is_numeric($params->limit) == false){
                $params->limit = 1000;
            }
            else if($params->limit == 0){
                $params->limit = null;
            }


            $result = $this->store->getProducts($params);
            $response->addData("products", $result);


            if( isset($params->limit) ){
                //****** PAGINATION
                $response->setPaginationSelf($params);
            
                $nextPage = clone $params;
                $nextPage->pagination += $params->limit;
                if( count($result) >= $params->limit){
                    $response->setPaginationNext($nextPage);
                }
           
                $prevPage = clone $params;
                $prevPage->pagination -= $params->limit;
                if($prevPage->pagination >= 0 ){
                    $response->setPaginationPrev($prevPage);
                }
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

}