<?php

namespace Libraries;

use Models\DataBaseCatalogs as DataBaseCatalogs;

class Catalogs {

    private $dataBaseCatalogs;
    public function __construct() {
        $this->dataBaseCatalogs = new DataBaseCatalogs();
    }

    public function getTimezones(){
        return $this->dataBaseCatalogs->getTimezones();
    }

    public function getMarkers(){
        return $this->dataBaseCatalogs->getMarkers();
    }

    public function getLegalStatus(){
        return $this->dataBaseCatalogs->getLegalStatus();
    }

    public function getDeviceFactories(){
        return $this->dataBaseCatalogs->getDeviceFactories();
    }

    public function getDeviceModels($factoryID){
        return $this->dataBaseCatalogs->getDeviceModels($factoryID);
    }

    public function getSimCarriers(){
        return $this->dataBaseCatalogs->getSimCarriers();
    }

    public function getSimPlans(){
        return $this->dataBaseCatalogs->getSimPlans();
    }

    public function getPeopleTypes(){
        return $this->dataBaseCatalogs->getPeopleTypes();
    }

    public function getProductFactories($productType = null){
        if($productType == 2){
            return $this->dataBaseCatalogs->getProductFactoriesSims();
        }
        else{
            return $this->dataBaseCatalogs->getProductFactories($productType);
        }
        
    }

    public function getProductModels($factoryID, $productType = null){
        return $this->dataBaseCatalogs->getProductModels($factoryID, $productType);
    }

    public function getProductStates(){
        return $this->dataBaseCatalogs->getProductStates();
    }

    public function getProductTypes(){
        return $this->dataBaseCatalogs->getProductTypes();
    }

    public function getTransferTypes(){
        return $this->dataBaseCatalogs->getTransferTypes();
    }

    public function getDeviceReportTypes(){
        return $this->dataBaseCatalogs->getDeviceReportTypes();
    }
}