<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\Authorization;
use Libraries\SmartResponse;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use \Exception as Exception;


use Libraries\Permissions;
use Libraries\Account;
use Libraries\User;
use Libraries\Store;


defined('BASEPATH') OR exit('No direct script access allowed');

class AccountManager extends REST_Controller {
    private $authorization;
    private $permissions;
    private $token;

    private $PERMISSION_GESTION_DISTRIBUIDORES = 13;
    private $PERMISSION_GESTION_CLIENTES = 14;

    public function __construct(){
        parent::__construct();
        $this->authorization = new Authorization();
        $this->permissions = new Permissions();

         //Validate Token
         try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $this->token = $this->authorization->getTokenData($tokenString); 
        }
        catch(HttpException $err){
            $response = new SmartResponse();
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
            $this->response($response->toJson(), $response->statusCode);
        }
        catch(Exception $err){
            $response = new SmartResponse();
            $response->onError("TOKEN_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function uploadFile_post(){
        $response = new SmartResponse();

        $idClienteID = $this->post("idClienteID");
        
        $name_server=$_SERVER['SERVER_NAME'];

       if($name_server!='gpsinfinity.mx'){
            $directory = '../vue/platform/public/img/storage/Distribuidores/'.$idClienteID.'/logotipo';
        }else{
           $directory = './img/storage/Distribuidores/'.$idClienteID.'/logotipo';
        }

       
        $filename = "logo.png";
        $filename2 = "isotipo.png";


        $files = $_FILES['files']['tmp_name'];
        $filesize = $_FILES['files']["size"]; //tamaño
        $fileExtension=$_FILES['files']['type'];

        


        $Extencion=false;
         $size=false;
        

            // if(($filesize<=2000000)){ ///menos igula a 2 mg
            //     $size=true;



              
            //  }
          


            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

  
        
            foreach($files as $file){
        
                        move_uploaded_file($file, $directory.'/'.$filename);
                        // move_uploaded_file($file, $directory.'/'.$filename2);
                        copy($directory.'/'.$filename, $directory.'/'.$filename2);
            }


           
            $response->onSuccess();
            $response->addData("userID",$idClienteID);
            $response->addData("size",$filesize);
            $response->addData("ext",$fileExtension);
            $response->addData("extB",$directory);
            $response->addData("sizeB",$size);
            $response->addData("server",$name_server);
            $response->addData("url",$directory);
            
       
        $this->response($response->toJson(), $response->statusCode);
    }

    public function logo_post(){
        $response = new SmartResponse();
        $user = new User();

        try{
        
            $userId = $this->post("iduser");
    


            $ruta='img/storage/Distribuidores/'.$userId.'/logotipo/';
               
                $data = $user->subirLogo($ruta,$userId);
                
                
                $response->onSuccess();
            $response->addData("user",$userId);
            $response->addData("url",$ruta);
            $response->addData("cuenta",$data);

            
                
               
            
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

    public function createAccount_post(){
        $response = new SmartResponse();
        $account = new Account();
        $user = new User();

        $PERMISSION_GESTION_DISTRIBUIDORES = 13;
        $PERMISSION_GESTION_CLIENTES = 14;
        $ACCOUNT_DISTRIBUTOR = 2;
        $ACCOUNT_CLIENT = 1;



       try{
            $tokenString = $this->input->get_request_header('Authorization');
            
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 
            
            $accountData = $this->post("account");
            $accountData = (object) json_decode(json_encode($accountData));
            
            $tmp = $this->post("legal");
            $accountData->legal = (object) json_decode(json_encode($tmp));

            $tmp = $this->post("contacts");
            $accountData->contacts = (object) json_decode(json_encode($tmp));

            if($accountData->type == $ACCOUNT_DISTRIBUTOR){
               $this->permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_DISTRIBUIDORES);                
               $userType = 3; //USUARIO tipo distribuidor
            }
            elseif ($accountData->type == $ACCOUNT_CLIENT) {
                $this->permissions->validatePermission($tokenData->userID, $PERMISSION_GESTION_CLIENTES);
                $userType = 1; //USUARIO tipo cliente
            }
            else{
                throw new HttpException("BAD_REQUEST","La peticion no es valida",HttpStatusCode::HTTP_BAD_REQUEST);
            }


            $accountData->ownerID = $tokenData->clientID;
            $accountID = $account->createAccount($accountData);

            $userData = (object) array(
                "clientID" => $accountID,
                "userType" => $userType,
                "timezone" => $accountData->timezone,
                "username" =>$accountData->name,
                "email" => $accountData->email,
                "notes" => "",
                "name" => $accountData->name,
                "paternalSurname" => "",
                "maternalSurname" => "",
                "phone" => 0,
                "address" => "",
                "permissions" => [],
                "devices" => []
            );
            
            // $this->logger->recordUserAction($token->userID, 9, $userID, 1);
            $userID = $user->createUser($userData);

            $response->onSuccess();
            $response->addData("accountID",$accountID);
            $response->addData("userID",$userID);
            
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

    public function accounts_get(){
        $response = new SmartResponse();
        $account = new Account();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $DISTRIBUTOR_CLIENT_TYPE = 2;
            $ADMINISTRATOR_CLIENT_TYPE = 3;
            if( $tokenData->clientType == $DISTRIBUTOR_CLIENT_TYPE || $tokenData->clientType == $ADMINISTRATOR_CLIENT_TYPE ){
                if($tokenData->clientType == $ADMINISTRATOR_CLIENT_TYPE)
                {
                    $clientID = $this->get("clientID");
                    if(!isset($clientID) || empty($clientID) || !is_numeric($clientID))
                        $clientID = $tokenData->clientID;
                }
                else
                 $clientID = $tokenData->clientID;
                
                $clientStatus = $this->get("status");
                $clients = $account->getAccounts($clientID, $clientStatus);

                $response->addData("customers", $clients);
                $response->onSuccess();
            }
            else{
                throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
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

    public function account_get($clientID = null){
        $response = new SmartResponse();
        $account = new Account();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            if(empty($clientID))
                //Consultarse a si mismo
                $clientID = $tokenData->clientID;
            else{
                //Consultar a un cliente
                $DISTRIBUTOR_CLIENT_TYPE = 2;
                $ADMINISTRATOR_CLIENT_TYPE = 3;
                if( $tokenData->clientType == $DISTRIBUTOR_CLIENT_TYPE || $tokenData->clientType == $ADMINISTRATOR_CLIENT_TYPE ){
                    $isOwner = $account->isOwner($tokenData->clientID, $clientID);
                    if(!$isOwner)
                        throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
                }
                else
                    throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }


            $account = $account->getAccount($clientID);
            $response->addData("customer", $account);
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

    public function account_put($clientID = null){
        $response = new SmartResponse();
        $account = new Account();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            if(empty($clientID))
                //Editarse a si mismo
                $clientID = $tokenData->clientID;
            else{
                //Editar a un cliente
                $DISTRIBUTOR_CLIENT_TYPE = 2;
                $ADMINISTRATOR_CLIENT_TYPE = 3;
                if( $tokenData->clientType == $DISTRIBUTOR_CLIENT_TYPE || $tokenData->clientType == $ADMINISTRATOR_CLIENT_TYPE ){
                    $isOwner = $account->isOwner($tokenData->clientID, $clientID);
                    if(!$isOwner)
                        throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
                }
                else
                    throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }


            //Recolectar params
            $params = $this->put("customer");
            $params = (object) json_decode(json_encode($params));

            $account->updateAccount($clientID, $params);
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

    


    public function accountStatus_put($clientID){
        $response = new SmartResponse();
        $account = new Account();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $isOwner = $account->isOwner($tokenData->clientID, $clientID);
            if(!$isOwner)
                throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            

            $clientStatus = $this->put("status");

            if(is_bool($clientStatus)){
                $account->updateAccountStatus($clientID, $clientStatus);
                $response->onSuccess();
            }
            else{
                throw new HttpException("BAD_REQUEST","param 'status' must be boolean", HttpStatusCode::HTTP_BAD_REQUEST);
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

    public function contact_post($clientID = null){
        $response = new SmartResponse();
        $account = new Account();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            if(empty($clientID))
                //Agregar contacto a si mismo
                $clientID = $tokenData->clientID;
            else{
                //Agregar contacto a un cliente cliente
                $DISTRIBUTOR_CLIENT_TYPE = 2;
                $ADMINISTRATOR_CLIENT_TYPE = 3;
                if( $tokenData->clientType == $DISTRIBUTOR_CLIENT_TYPE || $tokenData->clientType == $ADMINISTRATOR_CLIENT_TYPE ){
                    $isOwner = $account->isOwner($tokenData->clientID, $clientID);
                    if(!$isOwner)
                        throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
                }
                else
                    throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }


            //Recolectar params
            $params = $this->post("contact");
            $params = (object) json_decode(json_encode($params));

            $contactID = $account->registerContact($clientID, $params);
            $response->addData("contactID", $contactID);
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

    public function contact_put($clientID = null){
        $response = new SmartResponse();
        $account = new Account();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            // if(empty($clientID))
            //     //Agregar contacto a si mismo
            //     $clientID = $tokenData->clientID;
            // else{
            //     //Agregar contacto a un cliente cliente
            //     $DISTRIBUTOR_CLIENT_TYPE = 2;
            //     $ADMINISTRATOR_CLIENT_TYPE = 3;
            //     if( $tokenData->clientType == $DISTRIBUTOR_CLIENT_TYPE || $tokenData->clientType == $ADMINISTRATOR_CLIENT_TYPE ){
            //         $isOwner = $account->isOwner($tokenData->clientID, $clientID);
            //         if(!$isOwner)
            //             throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            //     }
            //     else
            //         throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            // }


            //Recolectar params
            $params = $this->put("contact");
            $params = (object) json_decode(json_encode($params));

            $contactID = $account->updateContact($clientID, $params);
            $response->addData("contactID", $contactID);
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


    public function contact_delete($contactID){
        $response = new SmartResponse();
        $account = new Account();

        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $tokenData = $this->authorization->getTokenData($tokenString); 

            $clientID = $account->getClientIDByContactID($contactID);

            if($clientID != $tokenData->clientID){
                $isOwner = $account->isOwner($tokenData->clientID, $clientID);
                if(!$isOwner)
                    throw new HttpException("UNAUTHORIZED","No esta autorizado para realizar esta consulta", HttpStatusCode::HTTP_UNAUTHORIZED);
            }

            $account->deleteContact($contactID);
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

    public function account_delete($accountID){
        $response = new SmartResponse();
        $account = new Account();
        $store = new Store();

        //TODO: Validar que se manden las variables y que contengan informacion para prevenir excepciones.

        try{ 

            //VALIDACION DE PERMISOS
            //Validar si es propietario de la cuenta
            $isOwner = $account->isOwner($this->token->clientID, $accountID);
            if(!$isOwner)
                throw new HttpException("UNAUTHORIZED","No es propietario de la cuenta",HttpStatusCode::HTTP_UNAUTHORIZED);
            
            //Validar si el usuario tiene permiso para eliminar ese tipo de cuenta (accountType)
            $accountType = $account->getAccountType($accountID);
            if($accountType == 1)
                $this->permissions->validatePermission($this->token->userID, $this->PERMISSION_GESTION_CLIENTES);
            elseif($accountType == 2)
                $this->permissions->validatePermission($this->token->userID, $this->PERMISSION_GESTION_DISTRIBUIDORES);
            elseif($accountType == 3)
                throw new HttpException("UNAUTHORIZED","No se puede eliminar la cuenta maestra",HttpStatusCode::HTTP_UNAUTHORIZED);

            
            //ELIMINAR CUENTA
            $account->deleteAccount($accountID);
            $response->addData("EliminarCliente",$accountID);
            $response->addData("TipoDeCliente",$accountType);

            //TRANSFERIR PRODUCTOS
            $requestBody = (object) json_decode($this->input->raw_input_stream, false);
            if(isset($requestBody->transfers) && !empty($requestBody->transfers) && is_array($requestBody->transfers)){
                $products =  $store->matchProducts($accountID, $requestBody->transfers);
                $store->transferProducts($this->token->clientID, $products);
                $response->addData("ProductosTransferidos", $products);
            }
            else
                $response->addData("TransferProducts","No se realizo ninguna transferencia de producto. (parametro sin definir, vacio o no es un array)");
            //Eliminar productos que no fueron transferidos
            $store->deleteClientStore($accountID);
            

            //TRANSFERENCIA DE CLIENTES (EN CASO DE ELIMINAR UN DISTRIBUIDOR)
            if($accountType == 2){
                try{
 
                    if( !isset($requestBody->transferClients->distributorID) || empty($requestBody->transferClients->distributorID) || !is_numeric($requestBody->transferClients->distributorID))
                        throw new Exception("Distribuidor de destino no esta definido, esta vacio o no es un id valido");                   
                    else{
                         //TODO: ELSE: Validar que el distribuidor existe y no esta eliminado
                        $distributorID = $requestBody->transferClients->distributorID;
                    }
                    
                    if(!isset($requestBody->transferClients->clients) || empty($requestBody->transferClients->clients) || !is_array($requestBody->transferClients->clients))
                        throw new Exception("Clientes no definido, vacio o no es un arreglo");
                    else
                        $clients = $requestBody->transferClients->clients;

                    //Migracion de clientes
                    $clients = $account->matchClients($accountID, $clients);
                    $account->transferClients($distributorID, $clients);
                    $response->addData("TransferirClientesAlCliente", $distributorID);
                    $response->addData("ClientesTransferidos", $clients);

                }catch(Exception $err){
                    $response->addData("WarnTransferClients","No se realizo transferencia de clientes: ".$err->getMessage());
                }

                //Eliminar clientes que no fueron migrados        
                $account->deleteClients($accountID);  
            }

            
            $response->addData("result","Exito al elimiar cliente");
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
}