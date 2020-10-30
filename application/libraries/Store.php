<?php
namespace Libraries;
use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Models\DataBaseStore;
use Libraries\Utils;
use Libraries\DeviceGPS;
use Libraries\GenericProduct;
use Libraries\Sims;

class Store{
    private $databaseStore;

    public function __construct(){
        $this->databaseStore = new DataBaseStore();
    }

    public function getSummary($clientID){
        return $this->databaseStore->getSummary($clientID);
    }

    public function getProducts($data){
        $params = $this->getProductsFilter($data);

        $pagination = new \stdClass();
        $pagination->pagination = $data->pagination;
        $pagination->limit = $data->limit;

        if($data->onTransfers)
            return $this->databaseStore->getProducts($data->clientID, $params, $pagination);
        else
            return $this->databaseStore->getProductsWithoutTransferring($data->clientID, $params, $pagination);
        
    }

    private function getProductsFilter($data){
        $conditions = [];
        $parameters = [];
        /**
         * id, clientID, productType, factory, model, limit, pagination
         */
        $conditions[] = "1 = ?";
        $parameters[] = "1";

        if(property_exists($data, "id") && !empty($data->id)){
            $conditions[] = "id = ?";
            $parameters[] = $data->id;
        }

        if(property_exists($data, "factory") && !empty($data->factory)){
            $conditions[] = "factoryID = ?";
            $parameters[] = $data->factory;  
        }

        if(property_exists($data, "model") && !empty($data->model)){
            $conditions[] = "modelID = ?";
            $parameters[] = $data->model;
        }

        if(property_exists($data, "productType") && !empty($data->productType)){
            $conditions[] = "productTypeID = ?";
            $parameters[] = $data->productType;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    public function isProductOwner($clientID, $productID, $productType){
        $ownerID = $this->databaseStore->getProductOwner($productID, $productType);

        if( $clientID == $ownerID)
            return true;
        else
            return false;
    }

    public function validateProductsOwner($clientID, $products){
        //Validar que todo producto le pertenece 
        foreach ($products as $product) {
            $isOwner = $this->isProductOwner($clientID, $product->id, $product->type);

            if( !$isOwner)
            throw new HttpException("UNAUTHORIZED","Uno o mas productos no pertenecen al almacen del cliente", HttpStatusCode::HTTP_UNAUTHORIZED);       
        }

        return true;
    }

    public function transferProducts($clientID, $products){
        $device = new DeviceGPS();
        $sim = new Sims();
        $genericProduct = new GenericProduct();

        foreach ($products as $product) {
            try{
                switch($product->type){
                    case 1:
                        $device->setOwner($clientID, $product->id);
                    break;

                    case 2:
                        $sim->setOwner($clientID, $product->id);
                    break;

                    case 3:
                        $genericProduct->setOwner($clientID, $product->id);
                    break;
                }

            }
            catch(Exception $err){
            }
        }
    }

    public function deleteClientStore($clientID){
        $device = new DeviceGPS();
        $sim = new Sims();
        $genericProduct = new GenericProduct();

        $genericProduct->deleteClientProducts($clientID);
        $sim->deleteClientSims($clientID);
        $device->deleteClientDevices($clientID);
    }

    
    public function matchProducts($clientID, $products){
       $filterProducts = $this->filterProducts($products);

       $filterProducts->gps = array_map( create_function('$obj','return $obj->id;'), $filterProducts->gps);
       $filterProducts->sims = array_map( create_function('$obj','return $obj->id;'), $filterProducts->sims);
       $filterProducts->products = array_map( create_function('$obj','return $obj->id;'), $filterProducts->products);

       if(count($filterProducts->gps) > 0 || count($filterProducts->sims) > 0 || count($filterProducts->products) > 0)
            $array = $this->databaseStore->matchProducts($clientID, $filterProducts);
       else
            $array = [];
          
       return $array;
    }

    /**
     * @param: Arreglo que contiene objetos producto (id y type)
     * @description: Retorna un objeto que continene arreglo de objetos divididos por tipo (gps,sims,products)
     */
    public function filterProducts($products){
        $filter = new \stdClass();
        $filter->gps = [];
        $filter->sims = [];
        $filter->products = [];
        $filter->unknow = [];

        //Filtrar los productos de acuerdo a su tipo
        foreach ($products as $product) {
            try{
                switch($product->type){
                    case 1:
                        $filter->gps[] = $product; 
                    break;
                    
                    case 2:
                        $filter->sims[] = $product;
                    break;
                    
                    case 3:
                        $filter->products[] = $product;
                    break;

                    default:
                        $filter->unknow[] = $product;
                }
            }catch(Exception $err){ 
                $filter->unknow[] = $product; 
            }
        }

        return $filter;
    }

}