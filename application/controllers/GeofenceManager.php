<?php
// namespace Controllers;
use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Libraries\Geofence;
use Libraries\Token;
use Libraries\SmartResponse;
use Libraries\DeviceGPS;
use Libraries\Utils;
use Libraries\Authorization;

defined('BASEPATH') OR exit('No direct script access allowed');

class GeofenceManager extends REST_Controller{
    public function geofences_get(){
        $geofence = new Geofence();
        $token = new Token();
        $response = new SmartResponse();

        $tokenString = $this->input->get_request_header('Authorization');
        
        $geofenceType = $this->get('geofenceType');


        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                $userID = $token->getUserID($tokenString);
              
                $geofenceList = $geofence->getGeofenceList($userID, $geofenceType);

                $response->setSuccess(true);
                $response->setStatusCode(HttpStatusCode::HTTP_OK); 
                $response->addData("geofences", $geofenceList);                      
            }
            else{
                throw new HttpException('INVALID_TOKEN','Token invalido o expirado',HttpStatusCode::HTTP_UNAHUTORIZED);
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

    public function geofence_get($geofenceID){
        $geofence = new Geofence();
        $token = new Token();
        $response = new SmartResponse();

        $tokenString = $this->input->get_request_header('Authorization');
        
        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                $userID = $token->getUserID($tokenString);

                //GeofenceExists

              
                $geofenceData = $geofence->getGeofence($geofenceID);

                $response->setSuccess(true);
                $response->setStatusCode(HttpStatusCode::HTTP_OK); 
                $response->addData("geofence", $geofenceData);                      
            }
            else{
                throw new HttpException('INVALID_TOKEN','Token invalido o expirado',HttpStatusCode::HTTP_UNAHUTORIZED);
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

    public function geofence_post(){
        $geofence = new Geofence();
        $token = new Token();
        $response = new SmartResponse();

        $tokenString = $this->input->get_request_header('Authorization');
        
        $json = $this->post('geofence');

        $geofenceData = json_decode(json_encode($json));

        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                $userID = $token->getUserID($tokenString);
                $geofence->validateData($geofenceData);
                $result = $geofence->createGeofence($userID, $geofenceData);

                $response->setSuccess(true);
                $response->addData("geofenceID",$result);
                $response->setStatusCode(HttpStatusCode::HTTP_CREATED);                       
            }
            else{
                throw new HttpException('INVALID_TOKEN','Token invalido o expirado',HttpStatusCode::HTTP_UNAHUTORIZED);
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

    public function geofence_put($geofenceID){
        $geofence = new Geofence();
        $token = new Token();
        $response = new SmartResponse();

        $tokenString = $this->input->get_request_header('Authorization');
        
        $json = $this->put('geofence');
        $geofenceData = json_decode(json_encode($json));

        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                //Geocerca Existe?
                $geofenceExists = $geofence->exists($geofenceID);
                if($geofenceExists){
                     //Es administrador de la geocerca?
                     $userID = $token->getUserID($tokenString);
                     $isGeofenceOwner =$geofence->isOwner($userID, $geofenceID);

                     if($isGeofenceOwner){
                         //verificar datos de la geocerca
                        //actualizar la geocerca
                        $geofence->validateData($geofenceData);
                        $result = $geofence->updateGeofence($userID, $geofenceID, $geofenceData);

                        $response->setSuccess(true);
                        $response->setStatusCode(HttpStatusCode::HTTP_OK); 
                     }
                     else{
                        throw new HttpException('UNAUTHORIZED','No cuentas con privilegios para realizar la consulta',HttpStatusCode::HTTP_UNAUTHORIZED);
                    }
                           
                }
                else{
                    throw new HttpException('GEOFENCE_NOT_FOUND',"la geocerca no exists",HttpStatusCode::HTTP_NOT_FOUND);
                }

                              
            }
            else{
                throw new HttpException('INVALID_TOKEN','Token invalido o expirado',HttpStatusCode::HTTP_UNAHUTORIZED);
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

    public function geofence_delete($geofenceID){
        $geofence = new Geofence();
        $token = new Token();
        $response = new SmartResponse();

        $tokenString = $this->input->get_request_header('Authorization');
        
        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                //Geocerca Existe?
                $geofenceExists = $geofence->exists($geofenceID);
                if($geofenceExists){
                     //Es administrador de la geocerca?
                     $userID = $token->getUserID($tokenString);
                     $isGeofenceOwner =$geofence->isOwner($userID, $geofenceID);

                     if($isGeofenceOwner){
                         //verificar datos de la geocerca
                        //actualizar la geocerca
                        
                        $geofence->deleteGeofence($userID, $geofenceID);

                        $response->setSuccess(true);
                        $response->setStatusCode(HttpStatusCode::HTTP_OK);
                     }
                     else{
                        throw new HttpException('UNAUTHORIZED','No cuentas con privilegios para realizar la consulta',HttpStatusCode::HTTP_UNAUTHORIZED);
                    }
                           
                }
                else{
                    throw new HttpException('GEOFENCE_NOT_FOUND',"la geocerca no exists",HttpStatusCode::HTTP_NOT_FOUND);
                }

                              
            }
            else{
                throw new HttpException('INVALID_TOKEN','Token invalido o expirado',HttpStatusCode::HTTP_UNAHUTORIZED);
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

    public function geofenceDevicesNear_get($geofenceID){
        $geofence = new Geofence();
        $token = new Token();
        $response = new SmartResponse();
        $deviceGPS = new DeviceGPS();
        $utils = new Utils();

        $tokenString = $this->input->get_request_header('Authorization');
        $maxDistance = $this->get('maxDistance');
        
        try{
            $isValidToken = $token->validateToken($tokenString);
            if($isValidToken){
                $userID = $token->getUserID($tokenString);
                $geofenceExists = $geofence->exists($geofenceID);
                if($geofenceExists){
                    $geofencePosition = $geofence->getGeofencePosition($geofenceID);

                    $deviceList = $deviceGPS->getDevicesNear($userID, $geofencePosition[0], $maxDistance);
                                  
                    $response->setSuccess(true);
                    $response->setStatusCode(HttpStatusCode::HTTP_OK); 
                    $response->addData("position", $geofencePosition[0]);
                    $response->addData("devices", $deviceList);            
                }
                else{
                    throw new HttpException('GEOFENCE_NOT_FOUND',"la geocerca no exists",HttpStatusCode::HTTP_NOT_FOUND);
                }

                              
            }
            else{
                throw new HttpException('INVALID_TOKEN','Token invalido o expirado',HttpStatusCode::HTTP_UNAHUTORIZED);
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

    public function geofenceBehavior_put($geofenceID, $behavior){
        
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $geofence = new Geofence();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $isOwner = $geofence->isOwner($tokenData->userID, $geofenceID);

            if($isOwner){
               $devices = $geofence->updateGeofenceBehavior($geofenceID, $behavior);
               $response->onSuccess();
            }
            else{
                throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);
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

    public function deviceToGeofence_post($geofenceID, $deviceID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $geofence = new Geofence();
        $device = new DeviceGPS();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $isOwner = $geofence->isOwner($tokenData->userID, $geofenceID);

            if($isOwner){
                $isDeviceSubscriber = $device->isDeviceSubscriber($tokenData, $deviceID);
                if($isDeviceSubscriber){
                    $geofence->bindDeviceToGeofence($geofenceID, $deviceID);
                    $response->onSuccess(HttpStatusCode::HTTP_CREATED); 
                }
                else{
                    throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);  
                }
            }
            else{
                throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);
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
    public function devicesFromGeofence_get($geofenceID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $geofence = new Geofence();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $isOwner = $geofence->isOwner($tokenData->userID, $geofenceID);

            if($isOwner){
               $devices = $geofence->getGeofenceDevices($geofenceID);
               $response->onSuccess();
               $response->addData("devices", $devices);

            }
            else{
                throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);
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
    public function deviceFromGeofence_delete($geofenceID, $deviceID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $geofence = new Geofence();
        $device = new DeviceGPS();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $isOwner = $geofence->isOwner($tokenData->userID, $geofenceID);

            if($isOwner){
                $isDeviceSubscriber = $device->isDeviceSubscriber($tokenData, $deviceID);
                if($isDeviceSubscriber){
                    $geofence->unbindDeviceFromGeofence($geofenceID, $deviceID);
                    $response->onSuccess(); 
                }
                else{
                    throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);  
                }
            }
            else{
                throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);
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

    public function geofenceEmailSubscribers_post($geofenceID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $geofence = new Geofence();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $isOwner = $geofence->isOwner($tokenData->userID, $geofenceID);

            if($isOwner){
                $email = $this->post('email');
                $emailID = $geofence->addEmailSubscriber($geofenceID, $email);

                $response->addData("email", $email);
                $response->addData("emailID", $emailID); 
                $response->onSuccess(HttpStatusCode::HTTP_CREATED);               
            }
            else{
                throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);
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

    public function geofenceEmailSubscribers_delete($geofenceID, $emailID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $geofence = new Geofence();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $isOwner = $geofence->isOwner($tokenData->userID, $geofenceID);

            if($isOwner){
                $geofence->removeEmailSubscriber($emailID);
                $response->onSuccess();               
            }
            else{
                throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);
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

    public function geofenceEmailSubscribers_get($geofenceID){
        $response = new SmartResponse();
        $authorization = new Authorization(); 
        $geofence = new Geofence();
        
        try{
            $tokenString = $this->input->get_request_header('Authorization');
            $authorization->validateToken($tokenString);

            $tokenData = $authorization->getTokenData($tokenString); 

            $isOwner = $geofence->isOwner($tokenData->userID, $geofenceID);

            if($isOwner){
                $emails = $geofence->getEmailSubscribers($geofenceID);
                
                $response->addData("geofenceID", $geofenceID);
                $response->addData("emailSubscribers", $emails);
                $response->onSuccess();               
            }
            else{
                throw new HttpException('UNAUTHORIZED',"No cuenta con privilegios para realizar esta operacion", HttpStatusCode::HTTP_UNAUTHORIZED);
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

    

}