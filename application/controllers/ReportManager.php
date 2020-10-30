<?php

use Libraries\REST_Controller;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use Libraries\Authorization;
use Libraries\SmartResponse;
use \Exception as Exception;

use Libraries\Permissions;
use Libraries\User;
use Libraries\Report;
use Libraries\DeviceGPS;
use Libraries\LetterFPDF;


defined('BASEPATH') or exit('No direct script access allowed');

class ReportManager extends REST_Controller
{
    private $authorization;
    private $permissions;
    private $token;
    private $report;

    private $TRANSFER_PERMISSION = 20;

    public function __construct()
    {
        parent::__construct();
        $this->authorization = new Authorization();
        $this->permissions = new Permissions();
        $this->report = new Report();

        //Validate Token
        try {
            $tokenString = $this->input->get_request_header('Authorization');
            $this->authorization->validateToken($tokenString);
            $this->token = $this->authorization->getTokenData($tokenString);
        } catch (HttpException $err) {
            $response = new SmartResponse();
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
            $this->response($response->toJson(), $response->statusCode);
        } catch (Exception $err) {
            $response = new SmartResponse();
            $response->onError("TOKEN_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function reportHistorical_get()
    {
        $response = new SmartResponse();
        $user = new User();
        $device = new DeviceGPS();
        
        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            $params = new \stdClass();
            $paginationToken = $this->get("paginationToken");

            if (isset($paginationToken) && empty($paginationToken) == false) {
                $b64 = base64_decode($paginationToken);
                $params = unserialize($b64);
                $deviceImei = $params->deviceImei;
            } else {
                $deviceID = $this->get("deviceID");
                $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
                if ($isDeviceSubscriber) {
                    $deviceImei = $device->getDeviceImei($deviceID);
                    $params->deviceImei = $deviceImei;
                    $params->fromTimestamp = $this->get("fromTimestamp");
                    $params->tillTimestamp = $this->get("tillTimestamp");
                    $params->order = $this->get("order");
                    $params->limit = $this->get("limit");
                    $params->pagination = 0;
                } else
                    throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para realizar esta consultar (no device owner)', HttpStatusCode::HTTP_UNAUTHORIZED);
            }

            if (isset($params->limit) == false || is_numeric($params->limit) == false)
                $params->limit = 1000;
            else if ($params->limit == 0)
                $params->limit = null;


            if (isset($params->fromTimestamp) == false || is_numeric($params->fromTimestamp) == false)
                $params->fromTimestamp = strtotime('today midnight');            
            $result = $this->report->getReportHistorical($deviceImei, $params);
            $response->addData("reports", $result);
            $response->setPagination($params, count($result));
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function geofenceReport_get()
    {
        $response = new SmartResponse();

        $user = new User();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);
            $params = new \stdClass();
            $paginationToken = $this->get("paginationToken");

            if (isset($paginationToken) && empty($paginationToken) == false) {
                $b64 = base64_decode($paginationToken);
                $params = unserialize($b64);
                $deviceImei = $params->deviceImei;
            } else {
                $deviceID = $this->get("deviceID");

                $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
                if ($isDeviceSubscriber) {
                    $deviceImei = $device->getDeviceImei($deviceID);
                    $params->deviceImei = $deviceImei;
                    $params->fromTimestamp = $this->get("fromTimestamp");
                    $params->tillTimestamp = $this->get("tillTimestamp");
                    $params->order = $this->get("order");
                    $params->limit = $this->get("limit");
                    $params->behavior = $this->get("behavior");
                    $params->geofenceID = $this->get("geofenceID");
                    $params->pagination = 0;
                } else
                    throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para realizar esta consultar', HttpStatusCode::HTTP_UNAUTHORIZED);
            }

            //Filtro Comportamiento
            if (isset($params->behavior) == false || is_numeric($params->behavior) == false)
                $params->behavior = null;
            else if ($params->behavior < 1 || $params->behavior > 2)
                $params->behavior = null;  //Si es menor 1 o mayor a 2 (-1,0, 3,4)


            //Filtro Limit
            if (isset($params->limit) == false || is_numeric($params->limit) == false)
                $params->limit = 1000;
            else if ($params->limit == 0)
                $params->limit = null;

            //Filtro ID Geocerca
            if (isset($params->geofenceID) == false || is_numeric($params->geofenceID) == false)
                $params->geofenceID = null;


            //Filtro From Timestamp
            if (isset($params->fromTimestamp) == false || is_numeric($params->fromTimestamp) == false)
                $params->fromTimestamp = strtotime('today midnight');


            $result = $this->report->getGeofenceReport($deviceImei, $params);
            $response->addData("reports", $result);
            $response->setPagination($params, count($result));

            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function alertReport_get()
    {
        $response = new SmartResponse();
        $user = new User();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);
            $params = new \stdClass();
            $paginationToken = $this->get("paginationToken");

            if (isset($paginationToken) && empty($paginationToken) == false) {
                $b64 = base64_decode($paginationToken);
                $params = unserialize($b64);
                $deviceImei = $params->deviceImei;
            } else {
                $params->fromTimestamp = $this->get("fromTimestamp");
                $params->toTimestamp = $this->get("toTimestamp");
                $params->pagination = 0;
                $params->userID = $this->token->userID;
                $params->clientID = $this->token->clientID;
                $params->userType = $this->token->userType;
            }


            //Filtro From Timestamp
            if (isset($params->fromTimestamp) == false || is_numeric($params->fromTimestamp) == false)
                $params->fromTimestamp = strtotime('today midnight');

            if (isset($params->toTimestamp) == false || is_numeric($params->toTimestamp) == false)
                $params->toTimestamp = strtotime('tomorrow midnight');


            $result = $this->report->getAlerts($params);
            $response->addData("params", $params);
            $response->addData("reports", $result);

            $response->setPagination($params, count($result));

            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function basicRouteReport_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $params = new \stdClass();
            $paginationToken = $this->get("paginationToken");

            if (isset($paginationToken) && empty($paginationToken) == false) {
                //Token de paginacion encontrado
                $b64 = base64_decode($paginationToken);
                $params = unserialize($b64);
                $deviceImei = $params->deviceImei;
            } else {
                $deviceID = $this->get("deviceID");

                $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
                if ($isDeviceSubscriber) {
                    $deviceImei = $device->getDeviceImei($deviceID);
                    $params->deviceImei = $deviceImei;
                    $params->fromTimestamp = $this->get("fromTimestamp");
                    $params->tillTimestamp = $this->get("tillTimestamp");
                    $params->order = $this->get("order");
                    $params->limit = $this->get("limit");
                    $params->pagination = 0;
                } else {
                    throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para realizar esta consultar', HttpStatusCode::HTTP_UNAUTHORIZED);
                }
            }

            if (isset($params->limit) == false || is_numeric($params->limit) == false) {
                $params->limit = 1000;
            } else if ($params->limit == 0) {
                $params->limit = null;
            }

            if (isset($params->fromTimestamp) == false || is_numeric($params->fromTimestamp) == false) {
                $params->fromTimestamp = strtotime('today midnight');
            }

            $result = $this->report->getSimpleReportHistorical($deviceImei, $params);
            $response->addData("reports", $result->resume);
            // $response->setPagination($params, count($result->resume));
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function distanceReport_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $deviceID = $this->get("deviceID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");


            //Otras Validaciones
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            $result = $this->report->getDistanceReport($params);
            $response->addData("device", $result->device);
            $response->addData("from", $result->from);
            $response->addData("to", $result->to);
            $response->addData("timezone", $result->timezone);
            $response->addData("distanceTraveledAverage", $result->distanceTraveledAverage);
            $response->addData("distanceTraveled", $result->distanceTraveled);
            $response->addData("monthPeriods", $result->monthPeriods);
            $response->addData("weekPeriods", $result->weekPeriods);
            $response->addData("totalReports", $result->totalReports);
            $response->addData("daysOnPeriod", $result->daysOnPeriod);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function distanceReportFile_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $deviceID = $this->get("deviceID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $format = $this->get("format");


            //Otras Validaciones
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            switch ($format) {
                case "pdf":
                    $pdf = $this->report->getDistanceReportPDF($params);
                    $pdf->Output();
                    break;

                default:
                    throw new HttpException('BAD_REQUEST', 'formato no soportado', HttpStatusCode::HTTP_BAD_REQUEST);
            }
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
            $this->response($response->toJson(), $response->statusCode);
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
            $this->response($response->toJson(), $response->statusCode);
        }
    }



    public function engineHoursReport_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $deviceID = $this->get("deviceID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");


            //Otras Validaciones
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            $result = $this->report->getMotorHoursReport($params);
            $response->addData("device", $result->device);
            $response->addData("from", $result->from);
            $response->addData("to", $result->to);
            $response->addData("timezone", $result->timezone);
            $response->addData("engineRunningTime", $result->engineRunningTime);
            $response->addData("engineOffTime", $result->engineOffTime);
            // $response->addData("maxEngineRunningTime", $result->maxEngineRunningTime);
            // $response->addData("maxEngineOffTime", $result->maxEngineOffTime);
            $response->addData("monthPeriods", $result->monthPeriods);
            $response->addData("weekPeriods", $result->weekPeriods);
            $response->addData("totalReports", $result->totalReports);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function engineHoursReportFile_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $deviceID = $this->get("deviceID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $format = $this->get("format");


            //Otras Validaciones
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            switch ($format) {
                case "pdf":
                    $pdf = $this->report->getMotorHoursReportPDF($params);
                    $pdf->Output();
                    break;

                default:
                    throw new HttpException('BAD_REQUEST', 'formato no soportado', HttpStatusCode::HTTP_BAD_REQUEST);
            }
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function ralentiReport_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $deviceID = $this->get("deviceID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $umbralSpeed = $this->get("speedUmbral");


            //Otras Validaciones
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            $result = $this->report->getRalentiReport($params);
            $response->addData("device", $result->device);
            $response->addData("from", $result->from);
            $response->addData("to", $result->to);
            $response->addData("timezone", $result->timezone);
            $response->addData("ralentiTime", $result->ralentiTime);
            $response->addData("maxRalentiTime", $result->maxRalentiTime);
            $response->addData("monthPeriods", $result->monthPeriods);
            $response->addData("weekPeriods", $result->weekPeriods);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function ralentiReportFile_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $deviceID = $this->get("deviceID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $umbralSpeed = $this->get("speedUmbral");
            $format = $this->get("format");
            $umbralSpeed = $this->get("speedUmbral");


            //Otras Validaciones
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            // $pdf = $this->report->getRalentiReportFilePDF($params);      
            // $response->addData("result",$pdf);
            switch ($format) {
                case "pdf":
                    $pdf = $this->report->getRalentiReportFilePDF($params);
                    $pdf->Output();
                    break;

                default:
                    throw new HttpException('BAD_REQUEST', 'formato no soportado', HttpStatusCode::HTTP_BAD_REQUEST);
            }
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }


    public function userLoginReport_get()
    {
        $response = new SmartResponse();
        $user = new User();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $userID = $this->get("userID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");

            //Otras Validaciones
            $isUserSubscriber = $user->isOwner($this->token->clientID, $userID);
            if (!$isUserSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar este usuario', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $params = new \stdClass();
            $params->userID = $userID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            $result = $this->report->getuserLoginReport($params);
            $response->addData("result", $result);
            // $response->addData("user",$result->user);  
            // $response->addData("from",$result->from);        
            // $response->addData("to",$result->to);
            // $response->addData("timezone",$result->timezone);
            // $response->addData("totalAccess",$result->totalAccess);
            // $response->addData("monthPeriods", $result->monthPeriods);
            // $response->addData("weekPeriods", $result->weekPeriods);
            // $response->addData("reports", $result->reports);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function userLoginReportFile_get()
    {
        $response = new SmartResponse();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $userID = $this->get("userID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $format = $this->get("format");

            //Otras Validaciones
            // $isUserSubscriber = $user->isOwner($this->token->clientID, $userID);
            // if( !$isUserSubscriber)
            //     throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $params = new \stdClass();
            $params->userID = $userID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            // $pdf = $this->report->getRalentiReportFilePDF($params);      
            // $response->addData("result",$pdf);
            switch ($format) {
                case "pdf":
                    $pdf = $this->report->getuserLoginReportFilePDF($params);
                    $pdf->Output();
                    break;

                default:
                    throw new HttpException('BAD_REQUEST', 'formato no soportado', HttpStatusCode::HTTP_BAD_REQUEST);
            }
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function stoppedReport_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $deviceID = $this->get("deviceID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $maxDistance = $this->get("maxDistance");  //50
            $timeStopped = $this->get("timeStopped");
            $maxSpeed = $this->get("maxSpeed");     //0.1
            $tolerance = $this->get("timeTolerance");    //0.2



            //Otras Validaciones
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)

            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;
            $params->maxSpeed = $maxSpeed;
            $params->maxDistance = $maxDistance;
            $params->minTime = $timeStopped - ($timeStopped * $tolerance);
            $params->maxTime = $timeStopped + ($timeStopped * $tolerance);

            $result = $this->report->getStoppedReport($params);
            $response->addData("device", $result->device);
            $response->addData("from", $result->from);
            $response->addData("to", $result->to);
            $response->addData("timezone", $result->timezone);
            $response->addData("reports", $result->reports);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function stoppedReportFile_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $deviceID = $this->get("deviceID");
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $maxDistance = $this->get("maxDistance");  //50
            $timeStopped = $this->get("timeStopped");
            $maxSpeed = $this->get("maxSpeed");     //0.1
            $tolerance = $this->get("timeTolerance");    //0.2
            $format = $this->get("format");

            //Otras Validaciones
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)

            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;


            $result = $this->report->getBatteryReport($params);
            $response->addData("result", $result);
            // $response->addData("from",$result->from);        
            // $response->addData("to",$result->to);
            // $response->addData("timezone",$result->timezone);
            // $response->addData("monthPeriods", $result->monthPeriods);
            // $response->addData("weekPeriods", $result->weekPeriods);
            // $response->addData("totalReports", $result->totalReports);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function speedReport_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $maxSpeed = $this->get("maxSpeed");  //50

            //TODO: Validar parametros recibidos (not nulls, numerics, etc)

            $params = new \stdClass();
            $params->clientID = $this->token->clientID;
            $params->userID = $this->token->userID;
            $params->userType = $this->token->userType;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;
            $params->maxSpeed = $maxSpeed;

            $result = $this->report->getSpeedReport($params);
            $response->addData("user", $result->user);
            $response->addData("from", $result->from);
            $response->addData("to", $result->to);
            $response->addData("timezone", $result->timezone);
            $response->addData("resume", $result->resume);
            $response->addData("monthPeriods", $result->monthPeriods);
            $response->addData("weekPeriods", $result->weekPeriods);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function speedReportFile_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $maxSpeed = $this->get("maxSpeed");  //50
            $format = $this->get("format");

            //TODO: Validar parametros recibidos (not nulls, numerics, etc)

            $params = new \stdClass();
            $params->clientID = $this->token->clientID;
            $params->userID = $this->token->userID;
            $params->userType = $this->token->userType;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;
            $params->maxSpeed = $maxSpeed;

            switch ($format) {
                case "pdf":
                    $pdf = $this->report->getSpeedReportFilePDF($params);
                    $pdf->Output();
                    break;

                default:
                    throw new HttpException('BAD_REQUEST', 'formato no soportado', HttpStatusCode::HTTP_BAD_REQUEST);
            }
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function batteryReport_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $deviceID = $this->get("deviceID");
            $timezone = $this->get("timezone");


            //TODO: Validar parametros recibidos (not nulls, numerics, etc)
            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);


            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;

            $result = $this->report->getBatteryReport($params);
            $response->addData("device", $result->device);
            $response->addData("from", $result->from);
            $response->addData("to", $result->to);
            $response->addData("timezone", $result->timezone);
            $response->addData("resume", $result->resume);
            $response->addData("monthPeriods", $result->monthPeriods);
            $response->addData("weekPeriods", $result->weekPeriods);
            $response->addData("reports", $result->reports);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function batteryReportFile_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $deviceID = $this->get("deviceID");
            $timezone = $this->get("timezone");
            $format = $this->get("format");

            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);




            $params = new \stdClass();
            $params->deviceID = $deviceID;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;
            $params->format = $format;

            switch ($format) {
                case "pdf":
                    $pdf = $this->report->getBatteryReportFilePDF($params);
                    $pdf->Output();
                    break;

                default:
                    throw new HttpException('BAD_REQUEST', 'formato no soportado', HttpStatusCode::HTTP_BAD_REQUEST);
            }
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }

    public function noReportReport_get()
    {
        $response = new SmartResponse();
        $device = new DeviceGPS();

        try {
            $this->permissions->validatePermission($this->token->userID, 2);

            //Recibir parametros
            $fromTimestamp = $this->get("fromTimestamp");
            $toTimestamp = $this->get("toTimestamp");
            $timezone = $this->get("timezone");
            $minTimestamp = $this->get("minTimestamp");
            $deviceID = $this->get("deviceID");

            $isDeviceSubscriber = $device->isDeviceSubscriber($this->token, $deviceID);
            if (!$isDeviceSubscriber)
                throw new HttpException('UNAUTHORIZED', 'No cuenta con privilegios para consultar uno o varios de los dispositivos solicitados', HttpStatusCode::HTTP_UNAUTHORIZED);



            $params = new \stdClass();
            $params->clientID = $this->token->clientID;
            $params->userID = $this->token->userID;
            $params->userType = $this->token->userType;
            $params->fromTimestamp = $fromTimestamp;
            $params->toTimestamp = $toTimestamp;
            $params->timezone = $timezone;
            $params->minTimestamp = $minTimestamp;
            $params->deviceID  = $deviceID;

            $result = $this->report->getNoReportReport($params);
            $response->addData("device", $result->device);
            $response->addData("timezone", $result->timezone);
            $response->addData("from", $result->from);
            $response->addData("to", $result->to);
            $response->addData("resume", $result->resume);
            $response->addData("monthPeriods", $result->monthPeriods);
            $response->addData("weekPeriods", $result->weekPeriods);
            $response->onSuccess();
        } catch (HttpException $err) {
            $response->onError($err->getTitle(), $err->getMessage(), $err->getStatusCode());
        } catch (Exception $err) {
            $response->onError("INTERNAL_ERROR", $err->getMessage(), HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR);
        } finally {
            $this->response($response->toJson(), $response->statusCode);
        }
    }
    public function noReportReportFile_get()
    {
    }
}
