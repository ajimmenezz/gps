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
use Libraries\Account;
use Libraries\Transfer;

defined('BASEPATH') OR exit('No direct script access allowed');

class TransferManager extends REST_Controller {
    private $authorization;
    private $permissions;
    private $token;

    private $TRANSFER_PERMISSION = 20;

    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
        $this->permissions = new Permissions();
        $this->transfer = new Transfer();

        //Validate Token
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $this->token = $this->authorization->getTokenData($tokenString); 
        }
        catch(HttpException $err){
            $response = new SmartResponse();
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
            $this->response($response->toJson(), $response->statusCode);
        }
        catch(Exception $err){
            $response = new SmartResponse();
            $response->onError("TOKEN_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            $this->response($response->toJson(), $response->statusCode);
        }
        
    }

    public function transfer_post(){
        $response = new SmartResponse();
        $account = new Account();

        try{ 
            $this->permissions->validatePermission($this->token->userID, $this->TRANSFER_PERMISSION);

            $transferData = $this->post("transfer");
            $transferData = (object) json_decode(json_encode($transferData));

            $transferData->products = $this->post("products");
            $transferData->products = (array) json_decode(json_encode($transferData->products));

            $transferData->fromClientID = $this->token->clientID;


            if(!isset($transferData->clientID) || empty($transferData->clientID))
            {
                $transferData->toClientID = $this->token->distributorID; //Devolucion
                $transferData->type = 2; //Devolucion
            }             
            else
            {
                $transferData->type = 1; //Transferencia Normal
                $transferData->toClientID = $transferData->clientID; 
                if(!$account->isOwner($this->token->clientID, $transferData->toClientID) )
                    throw new HttpException("UNAUTHORIZED", "No Cuenta con privilegios para transferir productos al cliente", HttpStatusCode::HTTP_UNAUTHORIZED);
            }

                
            
            if( count($transferData->products) <= 0 )
                throw new HttpException("PRODUCTS_MISSING","Se requiere de 1 o mas productos para poder realizar la transferencia",HttpStatusCode::HTTP_BAD_REQUEST);

            $transferID = $this->transfer->createTransfer($transferData);

            //Record Action
            $bitacora = new \StdClass();
            $bitacora->transferID = $transferID;
            $bitacora->userID = $this->token->userID;
            $bitacora->actionType = 1; //Registrar
            $bitacora->notes = "";
            $this->transfer->recordAction($bitacora);

            $response->addData("transferID", $transferID);
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

    public function transfers_get(){
        $response = new SmartResponse();
        $transfer = new Transfer();

        try{ 
            $this->permissions->validatePermission($this->token->userID, $this->TRANSFER_PERMISSION);

            $params = new \stdClass();
            $paginationToken = $this->get("paginationToken");
            if( isset($paginationToken) && !empty($paginationToken)){
                //Token de paginacion encontrado
                $b64 = base64_decode($paginationToken);
                $params = unserialize($b64);
            }
            else{
                $clientID = $this->get("clientID");
                if( isset($clientID) && !empty($clientID)){
                   $params->clientIDA = $this->token->clientID;
                   $params->clientIDB = $clientID;
                }
                else
                {
                    $params->clientIDA = $this->token->clientID;
                    $params->clientIDB = null;
                }
                    

                $params->fromTimestamp = $this->get("fromTimestamp");
                $params->toTimestamp = $this->get("toTimestamp"); 

                $params->transferStates = $this->get("transferStates");
                $params->transferStates = (array) json_decode(json_encode($params->transferStates));

                $params->transferTypes = $this->get("transferTypes");
                $params->transferTypes = (array) json_decode(json_encode($params->transferTypes));

                $params->limit = $this->get("limit");
                $params->pagination = 0; 
            }

            if( !isset($params->limit) || !is_numeric($params->limit) || $params->limit <= 0)
                $params->limit = null;


            $transfers = $this->transfer->getTransfers($params);;
            $response->addData("transfers",$transfers);
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
    public function transfer_get($transferID){
        $response = new SmartResponse();
        $transfer = new Transfer();

        try{ 
            $this->permissions->validatePermission($this->token->userID, $this->TRANSFER_PERMISSION);

            $transfer = $this->transfer->getTransfer($transferID, $this->token->clientID);
            $response->addData("transfer",$transfer);
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
    public function finalizeTransfer_put($transferID){
        $response = new SmartResponse();
        $transfer = new Transfer();
        try{ 
            $this->permissions->validatePermission($this->token->userID, $this->TRANSFER_PERMISSION);

            $toClient = $this->transfer->getTargetClient($transferID);
            if($toClient != $this->token->clientID)
                throw new HttpException("UNAUTHORZED", "La trasferencia no le pertence al cliente", HttpStatusCode::HTTP_UNAUTHORIZED);
            
            $transferState = $this->transfer->getTransferState($transferID);
            if($transferState != 1)
                throw new HttpException("INVALID_TRANSFER","Solo puede finalizar transferencias que se encuentren en estado de pendiente", HttpStatusCode::HTTP_BAD_REQUEST);
            
 
            $products = $this->put("products");
            $products = (array) json_decode(json_encode($products));

            $bitacora = new \stdClass();
            $bitacora->transferID = $transferID;
            $bitacora->userID = $this->token->userID;
            $bitacora->actionType = 2; //finalizar
            $bitacora->notes = $this->put("notes");
                
            $this->transfer->closeTransfer($transferID, $products);
            $this->transfer->recordAction($bitacora);

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
    public function transfer_delete($transferID){ 
        $response = new SmartResponse();
        $transfer = new Transfer();

        try{ 
            $this->permissions->validatePermission($this->token->userID, $this->TRANSFER_PERMISSION);

            $isOwner = $this->transfer->isOwner($transferID, $this->token->clientID);
            if(!$isOwner)
                throw new HttpException("UNAUTHORIZED", "No esta autorizado para cancelar esta transferencia", HttpStatusCode::HTTP_UNAUTHORIZED);

            $transferState = $this->transfer->getTransferState($transferID);
            if($transferState != 1) // !pendiente
                throw new HttpException("BAD_REQUEST","Solo se pueden cancelar transferencias que se encuentren pendientes",HttpStatusCode::HTTP_BAD_REQUEST);
            
               
            $bitacora = new \stdClass();
            $bitacora->transferID = $transferID;
            $bitacora->userID = $this->token->userID;
            $bitacora->actionType = 3;
            $bitacora->notes = $this->input->get("notes");
            
            $this->transfer->cancelTransfer($transferID);
            $this->transfer->recordAction($bitacora);

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