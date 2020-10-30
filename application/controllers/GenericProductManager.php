<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\Authorization;
use Libraries\SmartResponse;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use \Exception as Exception;


use Libraries\Permissions;
use Libraries\GenericProduct;
use Libraries\Logger;


defined('BASEPATH') OR exit('No direct script access allowed');

class GenericProductManager extends REST_Controller {
    private $authorization;
    private $permissions;
    private $product;
    private $PERMISO_GESTION_PRODUCTO_GENERICO;

    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
        $this->permissions = new Permissions();
        $this->product = new GenericProduct();
        $this->PERMISO_GESTION_PRODUCTO_GENERICO = 17;
    }

    public function products_post(){
        $response = new SmartResponse();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            //obtener lista de dispositivos de almacen
            
            $this->permissions->validatePermission($tokenData->userID, $this->PERMISO_GESTION_PRODUCTO_GENERICO);
            if($tokenData->clientType == 2){
                //Si el usuario pertenece a cliente distribuidor
               /**
                * modelID, productStatusID, serial
                * notes  
                */
                $productData = $this->post("product");
                $productData = (object) json_decode(json_encode($productData));
                $productData->distributorID = $tokenData->clientID;
                $productData->clientID =! empty($productData->clientID) ? "{$productData->clientID}" : "{$productData->distributorID}";

                if(!$this->product->serialExists($productData->serial)){
                    $productID = $this->product->createProduct($productData);
                    $response->addData("productID", $productID);
                }
                else{
                    throw new HttpException("SERIAL_EXISTS","Ya existe un registro con ese serial", HttpStatusCode::HTTP_BAD_REQUEST);
                }
                
            }
            else{
                throw new HttpException("UNAUTHORIZED","Solo las cuentas distribuidor pueden realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }
           

            $response->onSuccess();               
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function product_get($productID){
        $response = new SmartResponse();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
           
            if($this->product->isProductOwner($tokenData->clientID, $productID)){
                $productData = $this->product->getProduct($productID);
                $response->addData("product",$productData);
            }
            else{
                throw new HttpException("UNAUTHORIZED","No cuenta con privilegios necesarios para consultar este producto", HttpStatusCode::HTTP_UNAUTHORIZED);
            }       

            $response->onSuccess();               
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function products_get(){
        $response = new SmartResponse();       
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $clientID = $this->get("clientID");

            $cliente = empty($clientID) ? $tokenData->clientID : $clientID;

            $products = $this->product->getProductsByClient($cliente);
            $response->addData("products", $products);

            $response->onSuccess();               
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function product_put($productID){
        $response = new SmartResponse();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $this->permissions->validatePermission($tokenData->userID, $this->PERMISO_GESTION_PRODUCTO_GENERICO);
            if($this->product->isProductOwner($tokenData->clientID, $productID)){
                //Actuazliar
                //modelID,  productStatusID, serial, description
                $productData = $this->put("product");
                $productData = (object) json_decode(json_encode($productData));

                $result = $this->product->updateProduct($productID, $productData);
                $response->onSuccess(); 
            }
            else{
                throw new HttpException("UNAUTHORIZED","No cuenta con privilegios necesarios", HttpStatusCode::HTTP_UNAUTHORIZED);
            }                        
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function product_delete($productID){
        $response = new SmartResponse();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $this->permissions->validatePermission($tokenData->userID, $this->PERMISO_GESTION_PRODUCTO_GENERICO);
            if($this->product->isProductOwner($tokenData->clientID, $productID)){
                $result = $this->product->deleteProduct($productID);
                $response->onSuccess(); 
            }
            else{
                throw new HttpException("UNAUTHORIZED","No cuenta con privilegios necesarios", HttpStatusCode::HTTP_UNAUTHORIZED);
            }                        
        }
        catch(HttpException $err){
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        }
        catch(Exception $err){
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        }
        finally{
            $this->response($response->toJson(), $response->statusCode);
        }
    }

}//End of Class