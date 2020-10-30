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
use Libraries\Transaction;
use Libraries\Store;


defined('BASEPATH') OR exit('No direct script access allowed');

class TransactionManager extends REST_Controller {
    private $authorization;
    private $permissions;
    private $transaction;
    private $PERMISO_TRANSACCION;
    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
        $this->permissions = new Permissions();

        $this->transaction = new Transaction();
        $this->PERMISO_TRANSACCION = 19;
    }

    public function transaction_post(){
        $response = new SmartResponse();
        $store = new Store();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            //obtener lista de dispositivos de almacen
            
            $this->permissions->validatePermission($tokenData->userID, $this->PERMISO_TRANSACCION);
            
            $transactionData = $this->post("transaction");
            $transactionData = (object) json_decode(json_encode($transactionData));

            $transactionData->products = $this->post("products"); 
            $transactionData->products = (object) json_decode(json_encode($transactionData->products));
            
            $transactionID = 0;

            

            switch($transactionData->transactionType){
                case 1: //VENTA
                    $transactionData->fromClientID = $tokenData->clientID;
                    $transactionData->toClientID = $transactionData->clientID;
                    $transactionID = $store->validateProductsOwner($transactionData->fromClientID, $transactionData->products);
                    $transactionID = $this->transaction->registerTransaction($transactionData);

                    $store->transferProducts($transactionData->toClientID, $transactionData->products);
                break;
                
                case 2: //DEVOLUCION
                    $transactionData->fromClientID = $transactionData->clientID;
                    $transactionData->toClientID = $tokenData->clientID;
                    $transactionID = $store->validateProductsOwner($transactionData->fromClientID, $transactionData->products);
                    $transactionID = $this->transaction->registerTransaction($transactionData);
                    
                    $store->transferProducts($transactionData->toClientID, $transactionData->products);
                break;

                default:
                    throw new HtppException("BAD_REQUEST","Error al realizar la transaccion", HttpStatusCode::HTTP_BAD_REQUEST );
            }

            $response->addData("transactionID", $transactionID);
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
    public function transactions_get(){
        $response = new SmartResponse();
        $store = new Store();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $this->permissions->validatePermission($tokenData->userID, $this->PERMISO_TRANSACCION);
            
            $params = new \stdClass();
            $params->type = $this->get("type");
            $params->fromTimestamp = $this->get("fromTimestamp");
            $params->tillTimestamp = $this->get("tillTimestamp");

            $params->clientID = $this->get("clientID");
            if( !isset($params->clientID) || empty($params->clientID) )
                $params->clientID = $tokenData->clientID;
           
            $transactions = $this->transaction->getTransactions( $params);

            $response->addData("transactions", $transactions);
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
    
    public function transaction_get($transactionID){
        $response = new SmartResponse();
        $store = new Store();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $this->permissions->validatePermission($tokenData->userID, $this->PERMISO_TRANSACCION);
            
            $transactionData = $this->transaction->getTransaction($transactionID);

            $response->addData("transaction", $transactionData);
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