<?php
namespace Libraries;
use Models\DataBaseUser;
use Models\DataBasePermissions;
use Libraries\Token;
use Libraries\Email;
use Libraries\Logger;
use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use Libraries\Utils;
use Libraries\DeviceGPS;

class User{
    private $dataBaseUser;
    private $permissions;
    private $userID;
    private $logger;
    // private $email;

    public function __construct(){
        $this->dataBaseUser = new DataBaseUser();  
        $this->logger = new Logger();      
    }

    public function validateUser($username, $password){
        $this->userID = $this->dataBaseUser->getUserID($username);
        
        if($this->userID != null){
            $encryptedPassword = $this->dataBaseUser->getUserPassword($username);
            if( password_verify($password, $encryptedPassword) ){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }   
    }

    public function getDataAccess($username){
        $dataAccess = $this->dataBaseUser->getDataAccess($username);
        if($dataAccess != null){
            return $dataAccess;
        }
        else{
            throw new Exception("Data not found");
        }
    }


    function subirLogo($ruta,$idUser){
        return $this->dataBaseUser->subirLogodb($ruta,$idUser);
    }

    public function getLogo($userId){
        try{
            return $this->dataBaseUser->getLogo($userId);
        }
        catch(Exception $err){
            return false;
        }
    }

    public function getLogoUser($userId){
        try{
            return $this->dataBaseUser->getLogoUser($userId);
        }
        catch(Exception $err){
            return false;
        }
    }


    public function emailExists($email){
        try{
            return $this->dataBaseUser->emailExists($email);
        }
        catch(Exception $err){
            return false;
        }
    }

    public function updateLastLogin($userID){
        $this->dataBaseUser->updateLastLogin($userID);
    }

    public function registerLogin($userID){
        $this->dataBaseUser->registerLogin($userID);
    }

    public function recoverPassword($email){
        $userID = $this->dataBaseUser->getUserIDByEmail($email);
        $userName = $this->dataBaseUser->getUsername($userID);
        $token = new Token();
        $date = new \DateTime();
        $emailHandler = new Email();
        

        $payload = array(
            "userID" => $userID,
            "tokenType" => "RECOVER_PASSWORD",
            "exp" => $date->getTimestamp()+1800 //30min
        ); 
        $tokenStr = $token->encode($payload);

        // insertar o actualizar token de procedimiento en bd
        $this->dataBaseUser->insertOperationToken($userID, $tokenStr);

        $url = "https://gpsinfinity.mx/#/login/changePassword";

        ob_start();
        $body = file_get_contents('emailTemplates/recoverUserPassword.html', true);
        ob_flush();

        $body = str_replace('$URL',$url,$body);
        $body = str_replace('$TOKEN',$tokenStr,$body);
        $body = str_replace('$NAME',$userName,$body);
        $body = preg_replace("/[\n\r]/","",$body);
        
        $emailHandler->setSubject('Recuperacion de contraseña' );
        $emailHandler->addRecipients($email);
        $emailHandler->setBody($body, true);
        $emailHandler->send();

    }

    public function validateImmobilizerPassword($password){

    }

    public function getUserID($username){
    }

    public function setPassword($userID, $password){
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT); 
        return $this->dataBaseUser->updateUserPassword($userID, $encryptedPassword);
    }

    public function validateOperationToken($userID, $tokenString){
        $operationToken = $this->dataBaseUser->getOperationToken($userID);
        if($operationToken == $tokenString){
            return true;
        }
        else{
            return false;
        }
    }

    public function deleteOperationToken($userID){
        $this->dataBaseUser->deleteOperationToken($userID);
    }

    public function getUsername($userID){
        return $this->dataBaseUser->getUsername($userID);
    }

    public function eventPasswordExists($clientID){        
        return $this->dataBaseUser->eventPasswordExists($clientID);
    }

    public function getEventPasswordExpiration($clientID){
        return $this->dataBaseUser->getEventPasswordExpiration($clientID);
    }

    public function setEventPassword($clientID, $userID, $password){
        $emailHandler = new Email();
        $utils = new Utils();

        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT); 
        $timestampInterval = 2592000; //2592000 seg = 30 dias
        $timestampExpiration = $utils->getTimestampMidnight($timestampInterval); //2592000 seg = 30 dias
        
        $result = $this->dataBaseUser->updateEventPassword($clientID, $encryptedPassword, $timestampExpiration);

        $this->logger->recordUserAction($userID, 1, $clientID, 9);        

        try{
            $username = $this->getUsername($userID);
            $email = $this->getEmail($userID);

            ob_start();
            $body = file_get_contents('emailTemplates/eventPassword.html', true);
            ob_flush();
            $body = str_replace('$PASSWORD',$password,$body);
            $body = str_replace('$NAME',$username, $body);
            $body = preg_replace("/[\n\r]/","",$body);
            
            $emailHandler->setSubject('Notificaciones Infinity GPS' );
            $emailHandler->addRecipients($email);
            $emailHandler->setBody($body);
            $emailHandler->send();
        }
        catch(Exception $err){}
        
    }

    function getEmail($userID){
        return $this->dataBaseUser->getEmail($userID);
    }

    function userExists($username){
        return $this->dataBaseUser->userExists($username);
    }

    function validateEventPassword($clientID, $password){
        $encryptedPassword = $this->dataBaseUser->getEventPassword($clientID);
        $date = new \DateTime();

        if( password_verify($password, $encryptedPassword->password) && ($date->getTimestamp() <= $encryptedPassword->timestampExpiration) ){
            return true;
        }
        else{
            return false;
        }

    }

    function createUser($data){
      
        $utils = new Utils;
       
        $data->password = $utils->getRandomNumericPassword(); //Generar Contraseña numerica aleatoria
        $data->passwordEncrypted = password_hash($data->password, PASSWORD_DEFAULT);
        
        
        $device = new DeviceGPS();

        $userExists = $this->userExists($data->username);
        if(!$userExists){
            $emailExists = $this->emailExists($data->email);
            if(!$emailExists){              
                $userID = $this->dataBaseUser->createUser($data);
              

                //TODO: Solo agregar dispositivos que le pertenecen?
                $totalDevices = count($data->devices);
                if($totalDevices > 0 && $data->userType==2){
                    //Agregar dispositivos al filtro solo cuando el usuario es de tipo asociado
                    $device->addUserSubcriberToDevice($userID, $data->devices);
                }
                        
                $this->sendNewUserEmail($data->email, $data->username, $data->password);
                //Esta accion debe ser registrada despues de la funcion, por quien realiza la accion
                // $this->logger->recordUserAction($token->userID, 9, $userID, 1); 
                return $userID;
            }
            else{
                throw new HttpException("EMAIL_EXISTS", "El correo electronico ya se encuentra registrado", HttpStatusCode::HTTP_BAD_REQUEST);
            }
        }
        else{
            throw new HttpException("USER_EXISTS", "El nombre de usuario ya se encuentra en uso", HttpStatusCode::HTTP_BAD_REQUEST);
        } 
    }

    function updateUser($token, $userID, $userData){
        $device = new DeviceGPS();

        $updateUser = false;
        
          //Verificar que token.userID pertenezca a la misma cuenta que se quiere consultar
          $clientID = $this->getClientID($userID);
          if($clientID==$token->clientID){                        
             $updateUser=true;
          }
          else{
              throw new HttpException("UNAUTHORIZED", "No cuenta con privilegios para consultar este usuario", HttpStatusCode::HTTP_UNAUTHORIZED);
          }


        if($updateUser){
            if (property_exists($userData, "username")) {
                $userExists = $this->userExists($userData->username);
                if($userExists){
                    throw new HttpException("USER_EXISTS", "El nombre de usuario ya se encuentra en uso", HttpStatusCode::HTTP_BAD_REQUEST);
                }
            }

            if (property_exists($userData, "email")) {
                $emailExists = $this->emailExists($userData->email);
                if($emailExists){
                    throw new HttpException("EMAIL_EXISTS", "El correo electronico ya se encuentra registrado", HttpStatusCode::HTTP_BAD_REQUEST);
                }
            }

            $userFilter = $this->getUserFilters( $userData );
            $userContactFilter = $this->getUserContactFilters( $userData );

            
            if( count($userFilter->conditions) > 0 ){
                //Actualizar datos de usuario
                $this->dataBaseUser->updateUser($userID, $userFilter);
            }

            if( count($userContactFilter->conditions) > 0){
                $this->dataBaseUser->updateUserContact($userID, $userContactFilter);
            }

            if (property_exists($userData, "permissions")) {
                $this->dataBaseUser->removePermissons($userID);
                $this->dataBaseUser->addPermissions($userID, $userData->permissions);
            }

          
            $this->logger->recordUserAction($token->userID, 9, $userID, 5); 
            
        }
    }



    function sendNewUserEmail($email, $username, $password){
        $emailHandler = new Email();

        ob_start();
            $body = file_get_contents('emailTemplates/newUser.html', true);
            ob_flush();

            $body = str_replace('$PASSWORD',$password,$body);
            $body = str_replace('$NAME',$username, $body);
            $body = preg_replace("/[\n\r]/","",$body);
            
            $emailHandler->setSubject('Bienvenido a GPS Infinity' );
            $emailHandler->addRecipients($email);
            $emailHandler->setBody($body);
            $emailHandler->send();
    }

    function isUserOwner($token, $userID){
        switch($token->userType){
            case "1": //Cliente
                //Verificar que el usuario a consultar le pertenece
                $ownerID = $this->dataBaseUser->getClientID($userID); //Obtener el owner de dicho usuario
                if($token->clientID == $ownerID)
                {
                    return true;
                }
                else{
                    return false;
                }
                break;

            case "2": //Asociado
                //Verificar que tiene el permiso y obtener la lista
                return false;
                break;

            case "3": //Distribuidor
                //Verificar que el usuario le pertenece al distribuidor
                $distributorID = $this->dataBaseUser->getClientID($userID); //Obtener el distributor de dicho usuario
                if($token->clientID == $distributorID)
                {
                    return true;
                }
                else{
                    return false;
                }
                break;
        }

    }

    function isOwner($clientID, $userID){
        $ownerID = $this->dataBaseUser->getClientID($userID);

        if($clientID == $ownerID)
            return true;
        else
            return false;
    }


    function getClientID($userID){
        return $this->dataBaseUser->getClientID($userID);
    }

    function getUserInfo($userID){
        $databasePermissions = new DataBasePermissions();
        $user =  $this->dataBaseUser->getUserInfo($userID);
        $user->permissions = $databasePermissions->getUserPermissions($userID);
        return $user;
    }

    function getUserList($clientID, $userType = 2, $status = 0){
        return $this->dataBaseUser->getUserList($clientID, $userType, $status);
    }

    function hasPermission($userID, $permissionID){
        return $this->dataBaseUser->hasPermission($userID, $permissionID);
    }

    function deleteUser_legacy($token, $userID){
        //Verificar que token.userID pertenezca a la misma cuenta que se quiere consultar
        $clientID = $this->getClientID($userID);
        if($clientID==$token->clientID){                        
            $this->dataBaseUser->deleteUser($userID);
            $this->logger->recordUserAction($token->userID, 9, $userID, 2);
        }
        else{
            throw new HttpException("UNAUTHORIZED", "No cuenta con privilegios para consultar este usuario", HttpStatusCode::HTTP_UNAUTHORIZED);
        }

    }

    public function deleteUser($userID){
        $this->dataBaseUser->deleteUser($userID);
    }

    private function getUserFilters($params){
        $conditions = [];
        $parameters = [];

        //User Data
        if (property_exists($params, "timezone")) {
            $conditions[] = 'idTimezone = ?';
            $parameters[] = $params->timezone;
        }


        if (property_exists($params,"username")) {
            $conditions[] = 'usuario = ?';
            $parameters[] = $params->username;
        }

        if (property_exists($params,"email")) {
            $conditions[] = 'correo = ?';
            $parameters[] = $params->email;
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

    private function getUserContactFilters($params){
        $conditions = [];
        $parameters = [];
        
        //Contact 
        if (property_exists($params,"name")) {
            $conditions[] = 'nombre = ?';
            $parameters[] = $params->name;
        }

        if (property_exists($params,"paternalSurname")) {
            $conditions[] = 'apellidoPaterno = ?';
            $parameters[] = $params->paternalSurname;
        }

        if (property_exists($params,"maternalSurname")) {
            $conditions[] = 'apellidoMaterno = ?';
            $parameters[] = $params->maternalSurname;
        }

        if (property_exists($params,"phone")) {
            $conditions[] = 'telefono = ?';
            $parameters[] = $params->phone;
        }

        if (property_exists($params,"address")) {
            $conditions[] = 'direccion = ?';
            $parameters[] = $params->address;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    function getUserType($userID){
        return $this->dataBaseUser->getUserType($userID);
    }

    function getClientType($clientID){
        return $this->dataBaseUser->getClientType($clientID);
    }

    function getClientOwnerID($clientID){
        return $this->dataBaseUser->getClientOwnerID($clientID);
    }

    public function updateStatus($userID, $status){
        return $this->dataBaseUser->setStatus($userID, $status);
    }




}