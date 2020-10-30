<?php

// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use Libraries\SmartResponse;
use Libraries\Token;
use Libraries\Authorization;
use Libraries\DeviceGPS;

defined('BASEPATH') OR exit('No direct script access allowed');

class LocateDevices extends REST_Controller {

    public function getDeviceInfo_get($deviceID){
        $token = new Token();
        $response = new SmartResponse();
        $deviceGPS = new DeviceGPS();
        
        $tokenString = $this->input->get_request_header('Authorization');

        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                $userID = $token->getUserID($tokenString);
                //TODO: Agregar condicion validar si es suscriptor del dispositivo
                $deviceInfo = $deviceGPS->getDeviceInfo($deviceID);

                if($deviceInfo){
                    $response->setSuccess(true);
                    $response->addData('device', $deviceInfo[0]);
                }
                else{
                    throw new HttpException('UNAUTHORIZED','No cuenta con privilegios para consultar el dispositivo o el dispositivo no existe', HttpStatusCode::HTTP_UNAUTHORIZED);
                }
            }
            else{
                throw new HttpException('INVALID_TOKEN','Token invalido o expirado',HttpStatusCode::HTTP_UNAHUTORIZED);
            }

        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->response($response->toJson());
    }

    public function getDeviceList_get(){
        $authorization = new Authorization();
        $response = new SmartResponse();
        $deviceGPS = new DeviceGPS();
        
        $tokenString = $this->input->get_request_header('Authorization');

        try{
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString); 

            $devices = $deviceGPS->getDevices($tokenData->userID);

            if($tokenData->clientType == 2 ){
                foreach($devices as $device){
                    $device->fleetID = $device->clientID;
                }
            }

            $response->setSuccess(true);
            $response->addData('devices', $devices);
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->response($response->toJson());
    }

}
