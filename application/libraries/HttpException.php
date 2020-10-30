<?php
namespace Libraries;
use \Exception;

//Clase para crear exepciones personalizadas
class HTTPException extends Exception{
    private $title;
    private $statusCode;

    public function __construct($title, $description = "", $httpStatusCode = 400, $code = 0, Exception $previous = null){
        parent::__construct($description, $code, $previous);
        $this->title = $title;
        $this->statusCode = $httpStatusCode;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getStatusCode(){
        return $this->statusCode;
    }

}
