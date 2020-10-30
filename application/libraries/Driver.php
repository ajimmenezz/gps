<?php
namespace Libraries;

use Models\DataBaseVehicle;
use Libraries\Utils;

use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

class Driver{
    private $DataBaseVehicle;
    
    

    public function __construct(){
        $this->DataBaseVehicle = new DataBaseVehicle();
      
    }



    public function createDriver($data){
      
                //registra tabla conductores
                $driverID = $this->DataBaseVehicle->createDriver($data);

                return $driverID;
        
    }

 
}