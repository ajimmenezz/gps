<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Libraries\Authorization;
use Libraries\SmartResponse;
use Libraries\User;

defined('BASEPATH') OR exit('No direct script access allowed');

class ConfigurationController extends REST_Controller{

    private $authorization;
    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
    }

    public function eventPasswordExists_get(){
        $response = new SmartResponse();
        $user = new User();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
        
            $passwordExists = $user->eventPasswordExists($tokenData->clientID);

            $response->onSuccess();
            $response->addData('eventPasswordExists',$passwordExists);
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

    public function eventPasswordExpiration_get(){
        $response = new SmartResponse();
        $user = new User();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
        
            $timestampExpiration =  $user->getEventPasswordExpiration($tokenData->clientID);
            $response->onSuccess();
            $response->addData('timestampExpiration',$timestampExpiration);

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

    public function validateEventPassword_get(){
        $response = new SmartResponse();
        $user = new User();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
            $password = $this->get("password");
            $isValidEventPassword = $user->validateEventPassword($tokenData->clientID, $password);

            $response->onSuccess();
            $response->addData('isValidEventPassword',$isValidEventPassword);
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

    public function eventPassword_put(){
        $response = new SmartResponse();
        $user = new User();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
            if($tokenData->userType == "1" || $tokenData->userType == "3"){
                $password = $this->put("password");
                $user->setEventPassword($tokenData->clientID, $tokenData->userID, $password);
                $response->onSuccess();
            }
            else{
                $response->onError("UNAUTHORIZED", "No cuentas con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);
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
}