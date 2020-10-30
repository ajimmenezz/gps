<?php

namespace Libraries;

use Models\DataBaseGeofence as DataBaseGeofence;

class Geofence {

    private $dataBaseGeofence;
    private $logger;
    public function __construct() {
        $this->dataBaseGeofence = new DataBaseGeofence();
        $this->logger = new Logger();
    }

    public function validateData($geofenceData){
        //TODO: Validar si que los datos son correctos
    }

    public function createGeofence($userID, $geofenceData){
       $geofenceID = $this->dataBaseGeofence->createGeofence($userID, $geofenceData);
        $this->recordGeofenceAction("create", $userID, $geofenceID, $geofenceData);

       return $geofenceID;
    }

    public function updateGeofence($userID, $geofenceID, $geofenceData){
        $this->dataBaseGeofence->updateGeofence($geofenceID, $geofenceData);

        $geofenceData->geofenceType = $this->dataBaseGeofence->getGeofenceType($geofenceID);
        $this->recordGeofenceAction("update", $userID, $geofenceID, $geofenceData);
    }

    public function deleteGeofence($userID, $geofenceID){
        $this->dataBaseGeofence->deleteGeofence($geofenceID);

        $geofenceType = $this->dataBaseGeofence->getGeofenceType($geofenceID);
        $geofenceData = new \stdClass();
        $geofenceData->geofenceType = $geofenceType;

        $this->recordGeofenceAction("delete", $userID, $geofenceID, $geofenceData);
    }

    public function exists($geofenceID){
        return $this->dataBaseGeofence->geofenceExists($geofenceID);
    }

    public function isOWner($userID, $geofenceID){
        $ownerID =  $this->dataBaseGeofence->getOwnerID($geofenceID);
        if($ownerID == $userID){
            return true;
        }
        return false;
    }

    private function recordGeofenceAction($action, $userID, $geofenceID, $geofenceData){
        try{
            $entityType;
            $actionType;
            switch($geofenceData->geofenceType){
                case 1: //Normal
                $entityType = 7; //cat_bitacora_tipoentidad
                break;
    
                case 2: //POI
                $entityType = 8; 
                break;
            }
    
            switch($action){
                case "create":
                    $actionType = 1; //cat_bitacora_tipoAccion
                    break;
    
                case "update":
                    $actionType = 5;
                    break;
                
                case "delete":
                    $actionType = 2;
                    break;
            }
    
            $this->logger->recordUserAction($userID, $entityType, $geofenceID, $actionType);

        }
        catch(Exception $err){

        }  
    }

    public function getGeofenceList($userID, $geofenceType, $status = 1){
        return $this->dataBaseGeofence->getGeofenceList($userID, $geofenceType, $status);
    }

    public function getGeofence($geofenceID){
        return $this->dataBaseGeofence->getGeofence($geofenceID);
    }

    public function getGeofencePosition($geofenceID){
        $geofence = $this->dataBaseGeofence->getGeofence($geofenceID);
        return $geofence->coords;
    }

    public function bindDeviceToGeofence($geofenceID, $deviceID){
        return $this->dataBaseGeofence->bindDeviceToGeofence($geofenceID, $deviceID); 
    }

    public function unbindDeviceFromGeofence($geofenceID, $deviceID){
        return $this->dataBaseGeofence->unbindDeviceFromGeofence($geofenceID, $deviceID); 
    }

    public function getGeofenceDevices($geofenceID){
        return $this->dataBaseGeofence->getGeofenceDevices($geofenceID);
    }

    public function updateGeofenceBehavior($geofenceID, $behavior){
        return $this->dataBaseGeofence->updateGeofenceBehavior($geofenceID, $behavior);
    }


    public function addEmailSubscriber($geofenceID, $email){
        return $this->dataBaseGeofence->insertGeofenceEmailSubscriber($geofenceID, $email);
    }

    public function removeEmailSubscriber($subscriberID){
        return $this->dataBaseGeofence->deleteGeofenceEmailSubscriber($subscriberID);
    }

    public function getEmailSubscribers($geofenceID){
        return $this->dataBaseGeofence->getGeofenceEmailSubscribers($geofenceID);
    }

}
