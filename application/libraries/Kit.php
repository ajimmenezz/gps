<?php
namespace Libraries;
use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Models\DataBaseKit;
use Libraries\Utils;
use Libraries\User;

class Kit{
    private $databaseKit;

    public function __construct(){
        $this->databaseKit = new DataBaseKit();
    }

    public function create($data){
        return $this->databaseKit->createKit($data);
    }

    public function isOwner($clientID, $kitID){
        return $this->databaseKit->isOwner($clientID, $kitID);
    }


    public function update($kitID, $data){
        $params = $this->updateParamBuilder($data);
        if(count($params) > 0)
            $this->databaseKit->update($kitID, $params);

        $this->removeAllProducts($kitID);
        $this->addProducts($kitID, $data->products);
        
        return $params;
       
    }
    // $data->key = value
    private function updateParamBuilder($data){
        $conditions = [];
        $parameters = [];
        //modelID,  productStatusID, serial, description
        //Contact 
        if (property_exists($data,"name")) {
            $conditions[] = 'nombre = ?';
            $parameters[] = $data->name;
        }


        if (property_exists($data,"notes")) {
            $conditions[] = 'notas = ?';
            $parameters[] = $data->notes;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    } 

    public function addProducts($kitID, $products){
        return $this->databaseKit->addProducts($kitID, $products);
    }
    public function removeAllProducts($kitID){
        return $this->databaseKit->removeAllProducts($kitID);
    }


    public function get($kitID){
        return $this->databaseKit->getKit($kitID);
    }

    public function getKits($clientID){
        return $this->databaseKit->getKits($clientID);
    }

    public function delete($kitID){
        return $this->databaseKit->delete($kitID);
    }


}//End of class