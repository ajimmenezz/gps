<?php
namespace Libraries;

use Models\DataBaseVehicle;
use Libraries\Utils;

use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

class Vehicle{
    private $DataBaseVehicle;
    
    

    public function __construct(){
        $this->DataBaseVehicle = new DataBaseVehicle();
      
    }



    public function createVehicle($data){
      
    

       // if(!$this->DataBaseVehicle->vinExists($data->vin)){
                //registra tabla vehiculos
        $driverID = $this->DataBaseVehicle->createVehicle($data);

        return $driverID;
        // }
        // else{
        //     throw new HttpException("VIN_EXISTS","el vin ya existe",HttpStatusCode::HTTP_BAD_REQUEST);
        // }

        
    }

 
}