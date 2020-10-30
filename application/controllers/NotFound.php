<?php
//si se establece un namespace a controller en routes no logra encontrarlo
// namespace Controllers; 

use Libraries\REST_Controller;
use Libraries\SmartResponse;

defined('BASEPATH') OR exit('No direct script access allowed');

class NotFound extends REST_Controller{
    public function index(){
        $response = new SmartResponse();
        $response->onError('NOT_FOUND', 'Recurso no encontrado', 404);
        $this->response($response->toJson());
    }

}
