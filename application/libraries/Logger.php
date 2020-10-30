<?php
namespace Libraries;

use Models\DataBaseLogger as DataBaseLogger;
use \Exception;

class Logger{
    private $dataBaseLogger;
    public function __construct() {
        $this->dataBaseLogger = new DataBaseLogger();
    }

    public function recordUserAction($userID, $entityType, $entityID, $actionType){
        try{
            if($userID != null){
                $this->dataBaseLogger->recordUserAction($userID, $entityType, $entityID, $actionType);
            }
            
        }
        catch(Exception $err){

        }
        
    }

}