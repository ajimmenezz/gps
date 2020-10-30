<?php
namespace Libraries;
use Models\DataBaseFleet;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use \Exception as Exception;

class Fleet{
    private $dataBaseFleet;

    public function __construct(){
        $this->dataBaseFleet = new DataBaseFleet();        
    }

    function getFleets($userID){
        return $this->dataBaseFleet->getFleets($userID);
    }

    function createFleet($userID, $fleet){
        return $this->dataBaseFleet->createFleet($userID, $fleet);
    }

    function getFleet($userID, $fleetID){
       
            if($this->isFleetOwner($userID, $fleetID)){
                return $this->dataBaseFleet->getFleet($fleetID);
            }
            else{
                throw new HttpException("UNAUTHORIZED", "No cuenta con privilegios suficientes", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
     
    }

    function getVirtualFleets($clientID){
        return $this->dataBaseFleet->getVirtualFleets($clientID);
    }

    function isFleetOwner($userID, $fleetID){
        return $this->dataBaseFleet->isFleetOwner($userID, $fleetID);
    }

    function deleteFleet($userID, $fleetID){
            if($this->isFleetOwner($userID, $fleetID)){
                return $this->dataBaseFleet->deleteFleet($fleetID);
            }
            else{
                throw new HttpException("UNAUTHORIZED", "No cuenta con privilegios suficientes", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
     
    }

    function updateFleet($userID, $fleetID, $fleet){
        if($this->isFleetOwner($userID, $fleetID)){
            return $this->dataBaseFleet->updateFleet($fleetID, $fleet);
        }
        else{
            throw new HttpException("UNAUTHORIZED", "No cuenta con privilegios suficientes", HttpStatusCode::HTTP_UNAUTHORIZED);
        }
    }

    function updateDeviceFleet($userID, $deviceID, $fleetID ){
        if( isset($fleetID)  && is_numeric($fleetID) && empty($fleetID) == false){
            $isFleetOwner = $this->isFleetOwner($userID, $fleetID);
        }
        else{
            $isFleetOwner = true;
        }
        

        if($isFleetOwner){
            return $this->dataBaseFleet->updateDeviceFleet($userID, $deviceID, $fleetID);
        }
        else{
            throw new HttpException("UNAUTHORIZED","No cuenta con privilegios para realizar esta accion", HttpStatusCode::UNAUTHORIZED); 
        }
       
    }
}