<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Libraries\Permissions;
use Libraries\Authorization;
use Libraries\SmartResponse;


defined('BASEPATH') OR exit('No direct script access allowed');

class PermissionsManager extends REST_Controller{
    public function permissions_get(){
        $permissions = new Permissions();
        $authorization = new Authorization(); 
        $response = new SmartResponse();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 


            $permissionsList = $permissions->getUserPermissions($tokenData->userID);

            $response->onSuccess(HttpStatusCode::HTTP_OK); 
            $response->addData("permissions", $permissionsList);      
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