<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Libraries\Route;
use Libraries\Authorization;
use Libraries\SmartResponse;


defined('BASEPATH') OR exit('No direct script access allowed');

class RoutesManager extends REST_Controller{
    public function routes_post(){
        $route = new Route();
        $authorization = new Authorization(); 
        $response = new SmartResponse();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $routeData = $this->post("route");

            $route->createRoute($tokenData->userID, $routeData);

            $response->onSuccess(HttpStatusCode::HTTP_CREATED); 
            $response->addData("route", $routeData);      
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