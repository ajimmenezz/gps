<?php
namespace Libraries;

use Libraries\HttpStatusCode;
use Libraries\HttpException;
use \Exception as Exception;

use Libraries\User;
use Libraries\Email;
use Libraries\Transfer;
use Libraries\Store;


use Models\DataBaseAccount;

class Account{
    private $databaseAccount;

    public function __construct() {
        $this->databaseAccount = new DataBaseAccount();
    }

    public function createAccount($data){
        $user = new User();

        $accountExists = $this->databaseAccount->accountExists($data->name);
        if(!$user->userExists($data->name) && !$accountExists){
            if(!$user->emailExists($data->email)){
                $accountID = $this->databaseAccount->createAccount($data);

                //Enviar Correo de Bienvenida de acuerdo al tipo de cuenta creada
                $emailHandler = new Email();
                ob_start();
                switch($data->type){
                    case "1": //Cliente
                        $body = file_get_contents('emailTemplates/newClient.html', true);
                        break;

                    case "2": //Distribuidor
                        $body = file_get_contents('emailTemplates/newDistributor.html', true);
                        break;
                }             
                ob_flush();

                $body = str_replace('$NAME',$data->name, $body);
                $body = preg_replace("/[\n\r]/","",$body);
                
                $emailHandler->setSubject('Bienvenido a GPS Infinity' );
                $emailHandler->addRecipients($data->email);
                $emailHandler->setBody($body);
                $emailHandler->send();

                return $accountID;
            }
            else{
                throw new HttpException("EMAIL_EXISTS","el correo electronico ya existe",HttpStatusCode::HTTP_BAD_REQUEST);
            }
        }
        else{
            throw new HttpException("USER_EXISTS","el nombre de la cuenta ya existe",HttpStatusCode::HTTP_BAD_REQUEST);
        }
    }

    public function getAccounts($clientID, $status = null){
        return $this->databaseAccount->getAccounts($clientID, $status);
    }

    public function getAccount($clientID){
        return $this->databaseAccount->getAccount($clientID);
    }

    public function isOwner($ownerID, $clientID){
        $owner = $this->databaseAccount->getOwnerID($clientID);
        if($owner == $ownerID)
            return true;
        else
            return false;
    }

    public function getAccountType($clientID){
        return $this->databaseAccount->getAccountType($clientID);
    }

    public function updateAccount($clientID, $params){

        if(!empty($params->legal))
        {
            $legalParams = $this->updateAccountGetLegalParams($params->legal);

            if(!empty($legalParams->conditions))
                $this->databaseAccount->updateLegalInfo($clientID, $legalParams);
        }

       
    }
    private function updateAccountGetLegalParams($data){
        $conditions = [];
        $parameters = [];

        if(property_exists($data, "statusID") && !empty($data->statusID)){
            $conditions[] = "idEstatusLegal = ?";
            $parameters[] = $data->statusID;
        }

        if(property_exists($data, "name")){
            $conditions[] = "nombre = ?";
            $parameters[] = $data->name;  
        }

        if(property_exists($data, "country")){
            $conditions[] = "pais = ?";
            $parameters[] = $data->country;
        }

        if(property_exists($data, "region")){
            $conditions[] = "region = ?";
            $parameters[] = $data->region;
        }

        if(property_exists($data, "address")){
            $conditions[] = "direccion = ?";
            $parameters[] = $data->address;
        }

        if(property_exists($data, "zipCode")){
            $conditions[] = "cp = ?";
            $parameters[] = $data->zipCode;
        }

        if(property_exists($data, "notes")){
            $conditions[] = "notas = ?";
            $parameters[] = $data->notes;
        }

        if(property_exists($data, "taxID")){
            $conditions[] = "rfc = ?";
            $parameters[] = $data->taxID;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    public function updateAccountStatus($clientID, $status){
        return $this->databaseAccount->setAccountStatus($clientID, $status);
    }

    public function registerContact($clientID, $contact){
        return $this->databaseAccount->registerContact($clientID, $contact);
    }
    public function updateContact($clientID, $contact){
        return $this->databaseAccount->updateContact($clientID, $contact);
    }
    

    public function deleteContact($contactID){
        if(!empty($contactID))
            $this->databaseAccount->deleteContact($contactID);
    }

    public function getClientIDByContactID($contactID){
        if(!empty($contactID))
            return $this->databaseAccount->getClientIDByContactID($contactID);
        else
            return null;
    }

    public function deleteAccount($clientID){
        $user = new User();
        $transfer = new Transfer();
        $store = new Store();

        //Eliminar Cuenta
        $this->databaseAccount->deleteAccount($clientID);
        
        /**
         * Eliminar Usuarios, Flotillas, Geocercas
         * Eliminar relacion disp-usuario, disp-flotilla, disp-geocerca
         * Eliminar Tokens de operacion
         * */ 
        $users = $user->getUserList($clientID, 0);
        foreach ($users as $usr) {
            $user->deleteUser($usr->id);
        }

        /*Cancelar Transferencias pendientes*/
        $transfer->cancelAllTransfers($clientID);
    }

    public function transferClients($ownerID, $clients){
        $transfer = new Transfer();
        foreach ($clients as $clientID) {
            try{
                $this->databaseAccount->setAccountOwner($ownerID, $clientID);
                $transfer->cancelAllTransfers($clientID);       
            }
            catch(Exception $err){}
              
        }
    }

    //Filtra la lista de clientes y regresa solo los que son del propietario
    public function matchClients($ownerID, $clients){
        if(count($clients)>0)
            return $this->databaseAccount->matchClients($ownerID, $clients);
        else
            return [];
    }

    public function deleteClients($clientID){
        $store = new Store();
        $transfer = new Transfer();

        $clients = $this->databaseAccount->getAccounts($clientID);
        foreach ($clients as $client) {
            try{
                $this->deleteAccount($client->id);
                $transfer->cancelAllTransfers($client->id);
                $store->deleteClientStore($client->id);
            }catch(Exception $err){}
        }

    }
}