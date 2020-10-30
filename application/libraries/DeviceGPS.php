<?php
namespace Libraries;

use Models\DataBaseDevice;
use Models\DataBaseUser;
use Models\DataBaseVehicle;
use Libraries\Utils;

use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

class DeviceGPS{
    private $dataBaseDevice;
    private $dataBaseUser;
    private $devices;

    public function __construct(){
        $this->dataBaseDevice = new DataBaseDevice();
        $this->dataBaseUser = new DataBaseUSer;
        $this->devices = array();
    }

    public function isDeviceSubscriber($token, $deviceID){
        switch($token->clientType){
            case 1: //Cuenta tipo Cliente
                if($token->userType == 1){ //usuario tipo cliente
                    $clientID = $this->dataBaseDevice->getDeviceClientID($deviceID);
                    if($token->clientID == $clientID)
                        return true;
                }
                else if($token->userType == 2){ //Asociado
                    $result = $this->dataBaseDevice->isDeviceSubscriber($token->userID, $deviceID);
                    return $result;
                }
            break;

            case 2: //Cuenta tipo distribuidor
                $distributorID = $this->dataBaseDevice->getDeviceDistributorID($deviceID);
                if($token->clientID == $distributorID)
                    return true;
            break;

            case 3: //cuenta tipo administrador
                //TODO: Determinar accion para este tipo de usuario
            break;
        }

        return false;
    }

    public function getDevices($userID){
        try{
            $devices = $this->dataBaseDevice->getUserDevicesInfo($userID);
            return $devices;
        }
        catch(Exception $err){
            return array();
        }
    }
    
    public function getDeviceImei($deviceID){
        return $this->dataBaseDevice->getDeviceImei($deviceID);
    }

    public function getDevicesImei($devicesImei){
        return $this->dataBaseDevice->getDevicesImei($devicesImei);
    }

    public function getDeviceInfo($deviceID) {
        return $this->dataBaseDevice->getDeviceInfo($deviceID);
    }

    public function getDevicesNear($userID, $position, $maxDistance = 1000){
        $utils = new Utils();
        $deviceList = $this->dataBaseDevice->getDevicesNear($userID, $position, $maxDistance);  
        
        $deviceFilteredList = [];

        foreach($deviceList as $device){
            $devicePosition = new \stdClass();
            $devicePosition->lat = $device->lat;
            $devicePosition->lng = $device->lng;

            $distance = 0;
            $distance = $utils->haversine($position, $devicePosition);

           

            if($distance <= $maxDistance){
                $device->distance = $distance;
                array_push($deviceFilteredList, $device);
            }
        }

        return $deviceFilteredList;
    }

    public function addUserSubcriberToDevice($userID, $devices){
        /** TODO:
         * Agregar validacion para solo agregar dispositivos a los que tenga derecho */ 
        $result =  $this->dataBaseDevice->addUserSubcriberToDevice($userID, $devices);
        $this->dataBaseUser->updateTimestampModification($userID);
        return $result;

    }

    public function unsuscribeUserFromDevice($userID, $devices){
        $result = $this->dataBaseDevice->unsuscribeUserFromDevice($userID, $devices);
        $this->dataBaseUser->updateTimestampModification($userID);
        return $result;
    }

    public function getDeviceList($userID){
        return $this->dataBaseDevice->getDeviceList($userID);
    }
    public function getDeviceListByClient($clientID){
        return $this->dataBaseDevice->getDeviceListByClient($clientID);
    }

    public function updateDevice($userID, $deviceID, $device){
        $params = $this->filtersUpdateDevice($device);
        if(count($params->conditions) > 0){
            $this->dataBaseDevice->updateDevice($deviceID, $params);
            //RecordAction
        }
    }

    public function deleteDevice($deviceID,$simID,$statuSims){
        return $this->dataBaseDevice->deleteDevice($deviceID,$simID,$statuSims);
    }
    public function updateVehicle($token, $deviceID, $vehicle){
        $dataBaseVehicle = new DataBaseVehicle();
        $hasVehicle = $this->hasVehicle($deviceID);

        if($hasVehicle){
            $params = $this->filtersUpdateVehicle($vehicle);
            if(count($params->conditions) > 0){       
                $vehicleID = $this->dataBaseDevice->getVehicleID($deviceID);      
                $dataBaseVehicle->updateVehicle($vehicleID, $params);
                //RecordAction
            }
        }
        else{
            $vehicleID = $this->createDefaultVehicle($token, $deviceID);

            $params = $this->filtersUpdateVehicle($vehicle);
            if(count($params->conditions) > 0){
                $dataBaseVehicle->updateVehicle($vehicleID, $params);
                //RecordAction
            }

        }
        //Dispositivo tiene vehiculo
            //Obtener filtros
            //actualizar datos
        //Dispositivo NO tiene vehiculo
            //crear vehiculo y asociarlo al dispositivo
    }
    public function updateDriver($token, $deviceID, $driver){
        $dataBaseVehicle = new DataBaseVehicle();
        $hasVehicle = $this->hasVehicle($deviceID);

        if($hasVehicle){
            $params = $this->filtersUpdateDriver($driver);
            if(count($params->conditions) > 0){   
                $driverID = $this->dataBaseDevice->getDriverID($deviceID);        
                $dataBaseVehicle->updateDriver($driverID, $params);
                //RecordAction
            }
        }
        else{
            $vehicleID = $this->createDefaultVehicle($token, $deviceID);    

            $params = $this->filtersUpdateDriver($driver);
            if(count($params->conditions) > 0){
                $driverID = $this->dataBaseDevice->getDriverID($deviceID);        
                $dataBaseVehicle->updateDriver($driverID, $params);
                //RecordAction
            }

        }
    }


    private function filtersUpdateDevice($params){
        $conditions = [];
        $parameters = [];
        
        //Contact 
        if (property_exists($params,"modelo")) {
            $conditions[] = 'idModelo = ?';
            $parameters[] = $params->modelo;
        }

        

        if (property_exists($params,"marker")) {
            $conditions[] = 'idTipoMarcador = ?';
            $parameters[] = $params->marker;
        }

        if (property_exists($params,"alias")) {
            $conditions[] = 'alias = ?';
            $parameters[] = $params->alias;
        }

        if (property_exists($params,"notes")) {
            $conditions[] = 'notas = ?';
            $parameters[] = $params->notes;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    private function filtersUpdateVehicle($params){
        $conditions = [];
        $parameters = [];
        
        //Contact 
        if (property_exists($params,"brand")) {
            $conditions[] = 'marca = ?';
            $parameters[] = $params->brand;
        }

        if (property_exists($params,"model")) {
            $conditions[] = 'modelo = ?';
            $parameters[] = $params->model;
        }

        if (property_exists($params,"year")) {
            $conditions[] = 'año = ?';
            $parameters[] = $params->year;
        }

        if (property_exists($params,"vin")) {
            $conditions[] = 'vin = ?';
            $parameters[] = $params->vin;
        }

        if (property_exists($params,"colour")) {
            $conditions[] = 'color = ?';
            $parameters[] = $params->colour;
        }

        if (property_exists($params,"carPlate")) {
            $conditions[] = 'placas = ?';
            $parameters[] = $params->carPlate;
        }

        if (property_exists($params,"country")) {
            $conditions[] = 'pais = ?';
            $parameters[] = $params->country;
        }

        if (property_exists($params,"region")) {
            $conditions[] = 'region = ?';
            $parameters[] = $params->region;
        }

        if (property_exists($params,"insurance")) {
            $conditions[] = 'seguro = ?';
            $parameters[] = $params->insurance;
        }
        
        if (property_exists($params,"insuranceID")) {
            $conditions[] = 'numeroSeguro = ?';
            $parameters[] = $params->insuranceID;
        }

        if (property_exists($params,"notes")) {
            $conditions[] = 'notas = ?';
            $parameters[] = $params->notes;
        }


        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    private function filtersUpdateDriver($params){
        $conditions = [];
        $parameters = [];
        
        //Contact 
        if (property_exists($params,"name")) {
            $conditions[] = 'nombre = ?';
            $parameters[] = $params->name;
        }

        if (property_exists($params,"phone")) {
            $conditions[] = 'telefono = ?';
            $parameters[] = $params->phone;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    private function hasVehicle($deviceID){
        return $this->dataBaseDevice->hasVehicle($deviceID);
    }

    private function createDefaultVehicle($token, $deviceID){
        $dataBaseVehicle = new DataBaseVehicle();

        $driver = new \stdClass();
        $driver->clientID = $token->clientID;
        $driver->name = "";
        $driver->phone = "";

        $driverID =  $dataBaseVehicle->createDriver($driver);

        $vehicleData = new \stdClass();
        $vehicleData->clientID = $token->clientID;
        $vehicleData->deviceID = $deviceID;
        $vehicleData->driverID = $driverID;
        $vehicleData->brand = "";
        $vehicleData->model = "";
        $vehicleData->year = 0;
        $vehicleData->vin = "";
        $vehicleData->colour = "";
        $vehicleData->carPlate = "";
        $vehicleData->country = "";
        $vehicleData->region = "";
        $vehicleData->insurance = "";
        $vehicleData->insuranceID = "";
        $vehicleData->notes = "";

        return $dataBaseVehicle->createVehicle($vehicleData);
    }

    public function createDevice($data){
        // $dataBaseAccount = new DataBaseAccount();
        // $user = new User();

        
            if(!$this->dataBaseDevice->imeiExists($data->imei)){
                //registra tabla dispositivos
                $deviceID = $this->dataBaseDevice->createDevice($data);

                return $deviceID;
            }
            else{
                throw new HttpException("IMEI_EXISTS","el imei ya existe",HttpStatusCode::HTTP_BAD_REQUEST);
            }
        
    }

    public function getSimsDevice($device){
        return $this->dataBaseDevice->getSimsDevice($device);

    }

    public function setOwner($clientID, $deviceID){
        return $this->dataBaseDevice->setOwner($clientID, $deviceID);
    }

    public function deleteClientDevices($clientID){
        $this->dataBaseDevice->deleteClientDevices($clientID);
    }

    public function getAlias($deviceID){
        return $this->dataBaseDevice->getAlias($deviceID);
    }
 
}