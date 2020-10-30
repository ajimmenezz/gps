<?php
namespace Libraries;

use Models\DataBaseProduct;
use Libraries\Utils;

use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Libraries\User;

class GenericProduct{
    private $dataBaseProduct;

    public function __construct(){
        $this->databaseProduct = new DataBaseProduct();
    }

    public function createProduct($data){
        return $this->databaseProduct->createProduct($data);
    }

    public function serialExists($serial){
        return $this->databaseProduct->serialExists($serial);

    }
    public function isProductOwner($clientID, $productID){
        $user = new User();

        $ownerID = $this->databaseProduct->getClientID($productID);
        $distributorID = $user->getClientOwnerID($ownerID);

        //Si el cliente del producto o el owner del cliente del producto = al clienteID
        if($ownerID == $clientID || $distributorID == $clientID){
            return true;
        }
        else{
            return false;
        }
    }

    public function getProduct($productID){
        return $this->databaseProduct->getProduct($productID);
    }

    public function getProductsByClient($clientID){
        return $this->databaseProduct->getProducts($clientID);
    }

    public function updateProduct($productID, $data){     
        $params = $this->filtersUpdateProduct($data);
        if(count($params->conditions) > 0){
            //If params contains serial variable verify that is not empty and not exists
            if(property_exists($data,"serial")){
                $exists = $this->databaseProduct->serialExists($data->serial);
                if($exists){
                    throw new HttpException("SERIAL_EXISTS","El serial ya existe",HttpStatusCode::HTTP_BAD_REQUEST);
                }
            }          
            $this->databaseProduct->updateProduct($productID, $params);
            return true;
        }

        return false;
    }
    private function filtersUpdateProduct($params){
        $conditions = [];
        $parameters = [];
        //modelID,  productStatusID, serial, description
        //Contact 
        if (property_exists($params,"model")) {
            $conditions[] = 'idModelo = ?';
            $parameters[] = $params->model;
        }


        if (property_exists($params,"productStatus")) {
            $conditions[] = 'idEstadoProducto = ?';
            $parameters[] = $params->productStatus;
        }

        if (property_exists($params,"serial") && !empty($params->serial)) {
            $conditions[] = 'serie = ?';
            $parameters[] = $params->serial;
        }

        if (property_exists($params,"notes")) {
            $conditions[] = 'descripcion = ?';
            $parameters[] = $params->notes;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    public function deleteProduct($productID){
        $this->databaseProduct->deleteProduct($productID);
        return true;
    }

    public function setOwner($clientID, $productID){
       return $this->databaseProduct->setOwner($clientID, $productID); 
    }

    public function deleteClientProducts($clientID){
        $this->databaseProduct->deleteClientProducts($clientID);
    }

    

}//End of class
    
    