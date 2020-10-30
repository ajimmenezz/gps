<?php
namespace Libraries;
use Models\DataBaseRoute;


class Route{
    private $dataBaseRoute;

    public function __construct(){
        $this->dataBaseRoute = new DataBaseRoute();        
    }

    public function createRoute($userID, $routeData){
        $this->dataBaseRoute->createRoute($userID, $routeData);
    }
}