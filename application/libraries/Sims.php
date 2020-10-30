<?php
namespace Libraries;

use Models\DataBaseSims;
use Libraries\Utils;

use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

class Sims{
    private $dataBaseSims;
    
    

    public function __construct(){
        $this->dataBaseSims = new DataBaseSims();
      
    }


    public function createSims($data){
       if(!$this->dataBaseSims->simsTelExists($data->phone)){
            $simsID = $this->dataBaseSims->createSims($data);
            return $simsID;
        }
        else{
            throw new HttpException("SIMS_EXISTS","el número de sims ya existe",HttpStatusCode::HTTP_BAD_REQUEST);
        }  
    }

    public function getSimListByClient($clientID){
        return $this->dataBaseSims->getSimListByClient($clientID);
    }

    public function getSims($simID){
       
             $sims= $this->dataBaseSims->getSims($simID);
             return $sims;
           
     }

     public function updateSims($data,$idSims){

     
        if( property_exists($data,"phone")){
            if($this->dataBaseSims->simsTelExists($data->phone) ){
             
                throw new HttpException("SIMS_EXISTS","el número de sims ya existe",HttpStatusCode::HTTP_BAD_REQUEST);
            }
        }

        if( property_exists($data,"icc")){
            if($this->dataBaseSims->simsIccExists($data->icc) ){
             
                throw new HttpException("ICC_EXISTS","el ICC de la sims ya existe",HttpStatusCode::HTTP_BAD_REQUEST);
            }
        }
        
        $params = $this->filtersUpdateSims($data);
        if(count($params->conditions) > 0){
            $this->dataBaseSims->updateSims($params,$idSims);
            //RecordAction
        }

        return $idSims;
        

      
    }

   

      public function deleteSims($simID){
       
        return $this->dataBaseSims->deleteSims($simID);
             
     }

     private function filtersUpdateSims($params){
        $conditions = [];
        $parameters = [];

        

        //Contact 
        if (property_exists($params,"carrier")) {
            $conditions[] = 'idCompañiaTelefonica = ?';
            $parameters[] = $params->carrier;
        }


        if (property_exists($params,"planID")) {
            $conditions[] = 'idPlan = ?';
            $parameters[] = $params->planID;
        }

        if (property_exists($params,"icc")) {
            $conditions[] = 'icc = ?';
            $parameters[] = $params->icc;
        }

        if (property_exists($params,"phone")) {
            $conditions[] = 'telefono = ?';
            $parameters[] = $params->phone;
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

 
    public function setOwner($clientID, $simID){
        return $this->dataBaseSims->setOwner($clientID, $simID);
    }

    public function deleteClientSims($clientID){
        $this->dataBaseSims->deleteClientSims($clientID);
    }
}