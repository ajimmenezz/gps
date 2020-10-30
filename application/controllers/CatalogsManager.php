<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use Libraries\Authorization;
use Libraries\SmartResponse;
use \Exception as Exception;

use Libraries\Catalogs;


defined('BASEPATH') OR exit('No direct script access allowed');

class CatalogsManager extends REST_Controller{

    private $authorization;
 
    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
    }

    public function timezones_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $timezones = $catalogs->getTimezones();

            $response->onSuccess();
            $response->addData('timezones',$timezones);
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

    public function markers_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $markers = $catalogs->getMarkers();

            $response->onSuccess();
            $response->addData('markers',$markers);
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



    public function legalStatus_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $legalStatus = $catalogs->getLegalStatus();

            $response->onSuccess();
            $response->addData('legalStatus',$legalStatus);
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

    public function deviceFactories_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $deviceFactories = $catalogs->getDeviceFactories();

            $response->onSuccess();
            $response->addData('deviceFactories',$deviceFactories);
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

    public function deviceModels_get($factoryID){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $deviceModels = $catalogs->getDeviceModels($factoryID);

            $response->onSuccess();
            $response->addData('deviceModels',$deviceModels);
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

    public function simCarriers_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $simCarriers = $catalogs->getSimCarriers();

            $response->onSuccess();
            $response->addData('simCarriers',$simCarriers);
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

    public function simPlans_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $simPlans = $catalogs->getSimPlans();

            $response->onSuccess();
            $response->addData('simPlans',$simPlans);
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

    public function peopleTypes_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $peopleTypes = $catalogs->getPeopleTypes();

            $response->onSuccess();
            $response->addData('peopleTypes',$peopleTypes);
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

    public function productFactories_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $productType = $this->get("productType");
            $factories = $catalogs->getProductFactories($productType);

            $response->onSuccess();
            $response->addData('factories',$factories);
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
    public function productModels_get($factoryID){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $productType = $this->get("productType");
            $models = $catalogs->getProductModels($factoryID, $productType);

            $response->onSuccess();
            $response->addData('models',$models);
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

    public function productStates_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $states = $catalogs->getProductStates();

            $response->onSuccess();
            $response->addData('states',$states);
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

    public function productTypes_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $types = $catalogs->getProductTypes();

            $response->onSuccess();
            $response->addData('types',$types);
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

    public function transferTypes_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $types = $catalogs->getTransferTypes();

            $response->onSuccess();
            $response->addData('types',$types);
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

    public function deviceReportTypes_get(){
        $response = new SmartResponse();
        $catalogs = new Catalogs();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);

            $reportTypes = $catalogs->getDeviceReportTypes();

            $response->onSuccess();
            $response->addData('reportTypes',$reportTypes);
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