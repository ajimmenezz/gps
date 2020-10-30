<?php
namespace Libraries;
use Models\DataBasePermissions;

use \Exception;
use Libraries\HttpException;
use Libraries\HttpStatusCode;


class Permissions{
    private $dataBasePermissions;

    public function __construct(){
        $this->dataBasePermissions = new DataBasePermissions();        
    }

    public function getUserPermissions($userID){
       return $this->dataBasePermissions->getUserPermissions($userID);
    }


    public function validatePermission($userID, $permissionID){  
        $result = $this->dataBasePermissions->hasPermission($userID, $permissionID);
        if(!$result){
            throw new HttpException("UNAUTHORIZED","No cuenta con el permiso requerido", HttpStatusCode::HTTP_UNAUTHORIZED);
        }  
    }
}