<?php
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use Libraries\Authorization;
use Libraries\SmartResponse;
use \Exception as Exception;

use Libraries\DeviceGPS;
use Libraries\Driver;
use Libraries\Vehicle;
use Libraries\User;
use Libraries\Fleet;

use Libraries\Logger;

use Libraries\Permissions;


defined('BASEPATH') OR exit('No direct script access allowed');

class DeviceManager extends REST_Controller{
    public function suscribeUserToDevices_post($userID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $device = new DeviceGPS();
        $user = new User();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 
            $devices = $this->post('devices');

            $userType = $user->getUserType($userID);
            if($userType == 2) //Asociado
            {
                //No permitir agregar dispositivos a usuario tipo cliente
                $device->addUserSubcriberToDevice($userID, $devices);
            }
            else{
                $response->addData("WARN", "solo se pueden vincular dispositivos a usuarios tipo asociado, de otro tipo tienen asinacion automatica" );
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

    public function unsuscribeUserFromDevices_delete($userID, $deviceID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $device = new DeviceGPS();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $devices[] = $deviceID;
            $result =  $device->unsuscribeUserFromDevice($userID, $devices);
            $response->addData("user",$userID);
            $response->addData("device",$deviceID);
            $response->addData("result",$result);
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
    
    public function devices_post(){
        $response = new SmartResponse();
        // $account = new Account();
        // $user = new User();
        $device = new DeviceGPS();
        $driver = new Driver();
        $vehicle = new Vehicle();

        $Logger = new Logger();

        $authorization = new Authorization();
        $permissions = new Permissions();

        $PERMISSION_GESTION_GPS = 9;
        // $PERMISSION_GESTION_CLIENTES = 14;
        // $ACCOUNT_DISTRIBUTOR = 2;
        // $ACCOUNT_CLIENT = 1;

       try{
            $tokenString = $this->input->get_request_header('Authorization');
            
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString); 
            
            $deviceData = $this->post("device");
            $vehicleData = $this->post("vehicle");
            $driverData = $this->post("driver");

            $deviceData = (object) json_decode(json_encode($deviceData));
            $vehicleData = (object) json_decode(json_encode($vehicleData));
            $driverData = (object) json_decode(json_encode($driverData));

            $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_GPS);  

            switch ($tokenData->clientType) {
                case 1: //cliente
                    //$deviceData->distributorID=$tokenData->distributorID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                case 2: //distribuidor
                   // idCliente=null almacen
                   $clientID = $deviceData->clientID;

                   $deviceData->distributorID = empty($clientID) ? $tokenData->clientID : $clientID; 
                    //$deviceData->distributorID=$tokenData->clientID;
                    break;
                case 3: //admin
                     //$deviceData->distributorID=$tokenData->clientID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                
                default:
                throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
            }
            
            $deviceData->alias=$deviceData->imei;
            $deviceID = $device->createDevice($deviceData);
            
            $driverData->clientID=null;
            $driverID = $driver->createDriver($driverData);
            
            
            $vehicleData->deviceID=$deviceID;
            $vehicleData->driverID=$driverID;
            $vehicle->createVehicle($vehicleData);

            //registrar en bitacora
            $Logger->recordUserAction($tokenData->userID, 3, $deviceID, 1);



            $response->onSuccess();
            $response->addData("deviceID",$deviceID);
            
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

    public function updateDevice_put($deviceID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $device = new DeviceGPS();
        $user = new User();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $hasPemission = $user->hasPermission($tokenData->userID, 6);
            $hasPemissionGPS = $user->hasPermission($tokenData->userID, 9);
    
            if($hasPemission || $hasPemissionGPS){
                $isDeviceSuscriber = $device->isDeviceSubscriber($tokenData, $deviceID);

                if($isDeviceSuscriber){
                    $deviceData = $this->put("device");
                    $vehicleData = $this->put("vehicle");
                    $driverData = $this->put("driver");

                    $deviceData = (object) json_decode(json_encode($deviceData));
                    $vehicleData = (object) json_decode(json_encode($vehicleData));
                    $driverData = (object) json_decode(json_encode($driverData));

                    $device->updateDevice($tokenData->userID, $deviceID, $deviceData);                    
                    $device->updateVehicle($tokenData, $deviceID, $vehicleData);
                    $result =$device->updateDriver($tokenData, $deviceID, $driverData);

                    $response->addData("result",$result);
                }
                else{
                    throw new HttpException("UNAUTHORIZED","No cuenta con permisos suficientes para realizar esta solicitud", HttpStatusCode::HTTP_UNAUTHORIZED);
                }
            }
            else{
                throw new HttpException("UNAUTHORIZED","No cuenta con permisos suficientes para realizar esta solicitud", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
            //Verificar si el usuario tiene permiso de edicion
            //Verificar si el usuario le pertenece este dispositivo
            
                //crear filter para actualizar datos de dispositivo
                //contiene datos de vehiculo?
                    //si dispositivo no tiene vehiculo vinculado - crear
                    //dispositivo tiene vehiculo vinculado
                        //llenar filtro
                        //actualizar vehiculo
                //contiene datos de contuctor
                    //si dispositivo no tiene conductor asignado -crear
                    //dispositivo tiene vehiculo
                        //llenar filtro
                        //actualizar contacto
 
            
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

    public function updateDeviceFleet_put($deviceID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $fleet = new Fleet();
        $device = new DeviceGPS();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $isDeviceSuscriber = $device->isDeviceSubscriber($tokenData, $deviceID);

            if($isDeviceSuscriber){
                $fleetID = $this->put("fleetID");
                $fleet->updateDeviceFleet($tokenData->userID, $deviceID, $fleetID);                 
            }
            else{
                  throw new HttpException("UNAUTHORIZED","No cuenta con permisos suficientes para realizar esta solicitud", HttpStatusCode::HTTP_UNAUTHORIZED);
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

    public function getDeviceStore_get(){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $device = new DeviceGPS();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 
            //obtener lista de dispositivos de almacen
            if($tokenData->clientType == 2){
                //Si el usuario pertenece a cliente distribuidor
                $clientID = $this->get("clientID");

                $cliente = empty($clientID) ? $tokenData->clientID : $clientID; 
                $devices = $device->getDeviceListByClient($cliente);
            }
            elseif($tokenData->clientType == 1){
                $devices = $device->getDeviceListByClient($tokenData->clientID);
            }
            else{
                throw new HttpException("UNAUTHORIZED","Solo las cuentas distribuidor pueden realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
           
            $response->addData("devices",$devices);
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

    public function deleteDevice_delete($deviceID,$simIDGet,$statusSimsGet){
        $response = new SmartResponse();
        // $account = new Account();
        // $user = new User();
        $device = new DeviceGPS();
      
        $Logger = new Logger();

        $authorization = new Authorization();
        $permissions = new Permissions();

        $PERMISSION_GESTION_GPS = 9;
        // $PERMISSION_GESTION_CLIENTES = 14;
        // $ACCOUNT_DISTRIBUTOR = 2;
        // $ACCOUNT_CLIENT = 1;

       try{
            $tokenString = $this->input->get_request_header('Authorization');
            
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString); 
            

            $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_GPS);  

            switch ($tokenData->clientType) {
                case 1: //cliente
                    //$deviceData->distributorID=$tokenData->distributorID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                case 2: //distribuidor
                   // idCliente=null almacen
                    $distributorID=$tokenData->clientID;
                    break;
                case 3: //admin
                     //$deviceData->distributorID=$tokenData->clientID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                
                default:
                throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
            }
            // $statusSimsGet = $this->delete("StatusSims");
            // $simIDGet = $this->delete("simID");

          //  $statusSimsGet=empty($statusSimsGet)? $statusSimsGet :"null";
            if($statusSimsGet==0){
                $statusSimsGet=null;
            }
            if($simIDGet==0){
                $simIDGet=null;
            }
           // $simIDGet=empty($simIDGet)? $simIDGet :"null";
            

            $device->deleteDevice($deviceID,$simIDGet,$statusSimsGet);

            //registrar en bitacora
            $Logger->recordUserAction($tokenData->userID, 3, $deviceID, 2);



            $response->onSuccess();
            $response->addData("deviceID",$simIDGet);
            
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

    public function getSimsDevice_get($deviceID){
        $response = new SmartResponse();
        // $account = new Account();
        // $user = new User();
        $device = new DeviceGPS();
      
        $Logger = new Logger();

        $authorization = new Authorization();
        $permissions = new Permissions();

        $PERMISSION_GESTION_GPS = 9;
        // $PERMISSION_GESTION_CLIENTES = 14;
        // $ACCOUNT_DISTRIBUTOR = 2;
        // $ACCOUNT_CLIENT = 1;

       try{
            $tokenString = $this->input->get_request_header('Authorization');
            
            $authorization->validateToken($tokenString);
            $tokenData = $authorization->getTokenData($tokenString); 
            

            $permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_GPS);  

            switch ($tokenData->clientType) {
                case 1: //cliente
                    //$deviceData->distributorID=$tokenData->distributorID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                case 2: //distribuidor
                   // idCliente=null almacen
                    $distributorID=$tokenData->clientID;
                    break;
                case 3: //admin
                     //$deviceData->distributorID=$tokenData->clientID;
                    throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
                
                default:
                throw new HttpException("UNAUTHORIZED","No cuenta con los permisos",HttpStatusCode::HTTP_UNAUTHORIZED);
                    break;
            }
            
            $value=$device->getSimsDevice($deviceID);

           
            //registrar en bitacora
            //$Logger->recordUserAction($tokenData->userID, 3, $deviceID, 2);



            $response->onSuccess();
            $response->addData("sims",$value);
            
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