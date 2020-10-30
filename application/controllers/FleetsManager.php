<?php
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use Libraries\Authorization;
use Libraries\SmartResponse;
use \Exception as Exception;

use Libraries\Fleet;

defined('BASEPATH') OR exit('No direct script access allowed');

class FleetsManager extends REST_Controller{
    public function fleets_get(){
        $fleet = new Fleet();
        $authorization = new Authorization(); 
        $response = new SmartResponse();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            if($tokenData->clientType == 2){
                //Distributor
                $fleets = $fleet->getVirtualFleets($tokenData->clientID);
            }
            else{
                $fleets = $fleet->getFleets($tokenData->userID);
            }
            

            $response->onSuccess();
            $response->addData('fleets',  $fleets);        
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

    public function fleets_post(){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $fleet = new Fleet();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $fleetData = (object) json_decode(json_encode($this->post("fleet")));
            
            $result = $fleet->createFleet($tokenData->userID, $fleetData);
            $response->addData("fleetID", $result);          
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

    public function fleet_get($fleetID){
        $fleet = new Fleet();
        $authorization = new Authorization(); 
        $response = new SmartResponse();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $fleet = $fleet->getFleet($tokenData->userID, $fleetID);

            $response->onSuccess();
            $response->addData('fleet',  $fleet);        
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

    public function fleet_delete($fleetID){
        $fleet = new Fleet();
        $authorization = new Authorization(); 
        $response = new SmartResponse();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $fleet->deleteFleet($tokenData->userID, $fleetID);
            
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
    
    public function fleet_put($fleetID){
        $fleet = new Fleet();
        $authorization = new Authorization(); 
        $response = new SmartResponse();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $fleetData = (object) json_decode(json_encode($this->put("fleet")));
     
            $fleet->updateFleet($tokenData->userID, $fleetID, $fleetData);
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