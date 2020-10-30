<?php
namespace Libraries;

use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;
use Models\DataBaseReport;
use Libraries\Utils;
use Libraries\DeviceGPS;
use Carbon\Carbon;

class Report{
    private $databaseReport;

    public function __construct(){
        $this->databaseReport = new DataBaseReport();     
    }

    public function getReportHistorical($deviceImei, $params){
       return $this->databaseReport->getReportHistorical($deviceImei, $params);
    }

    public function getSimpleReportHistorical($deviceImei, $params){
      $utils = new Utils(); 
      $result = new \StdClass();
      $result->reports = $this->databaseReport->getSimpleReportHistorical($deviceImei, $params);
      $result->resume = [];

   
      if(count($result->reports) > 0){
         $tmp = $result->reports[0];
         $resume = new \StdClass();
         $resume->event = "UNKNOW";
         $resume->eventString = "UNKNOW";
         $resume->timestampStart = $tmp->timestamp;
         $resume->timestampEnd = $tmp->timestamp;
         $resume->address = $tmp->address;
         $resume->speed = $tmp->speed;
         $resume->reports[] = clone($tmp);
         $resume->totalDistance = 0;
         $resume->totalTime = 0;
         $totalDistance = 0;

         $index = 0;
         foreach ($result->reports as $report) {
            
            $distance = $utils->haversine($tmp, $report);
               
            if($distance <= 20){
               if(  strcmp($resume->event,"PARKING") == 0){
                     $resume->timestampEnd = $report->timestamp;
                     $resume->address = $report->address;
                     $resume->reports[] = clone($report);
                     $tmp = clone($report);
               }
               else{
                     if(strcmp($resume->event,"UNKNOW") != 0){

                        if(strcmp($resume->event,"MOVEMENT") == 0){
                           $totalDistance = $utils->metersToKilometers($totalDistance);
                           $totalTime = ($resume->timestampEnd - $resume->timestampStart)/60 /60;
                           
                           if($totalTime > 0)
                              $resume->speed = $totalDistance / $totalTime;
                           else
                              $resume->speed = 0;
                           
                           $resume->totalDistance = $totalDistance;                     
                           $resume->totalTime = $totalTime;
                        }

                        $result->resume[] = clone($resume);                  
                     }

                     
                     //Crear nuevo resumen
                     $resume->event = "PARKING";
                     $resume->eventString = "Detenido";
                     $resume->timestampStart = $resume->timestampEnd;
                     $resume->timestampEnd = $report->timestamp;
                     $resume->address = $report->address;
                     $resume->speed = 0;
                     $resume->reports = [];
                     $resume->reports[] = clone($report);

                     $totalDistance = 0;
                     $resume->totalDistance = 0;
                     $resume->totalTime = 0;

                     $tmp = clone($report);
               }
            }
            else{
                  if( strcmp($resume->event, "MOVEMENT") == 0){
                     $totalDistance += $distance;

                     $resume->timestampEnd = $report->timestamp;
                     $resume->speed = -5;

                     $resume->reports[] = clone($report);
                     $tmp = clone($report);
                  }
                  else{               
                     if( strcmp($resume->event,"UNKNOW") != 0){
                        $result->resume[] = clone($resume);
                     }

                     
                     //Crear nuevo resumen
                     $resume->event = "MOVEMENT";
                     $resume->eventString = "Movimiento";
                     $resume->timestampStart = $resume->timestampEnd;
                     $resume->timestampEnd = $report->timestamp;
                     $resume->address = "";
                     $resume->speed = $report->speed;
                     $totalDistance = 0;
                     $totalDistance = $distance;

                     $resume->reports = [];
                     $resume->reports[] = clone($report);
                  

                     $tmp = clone($report);
                  }

            }

            if($index+1 >= count($result->reports)){
               if(  strcmp($resume->event,"PARKING") == 0){
                  // $result->resume[] = clone($resume);
               }
               else if(strcmp($resume->event,"MOVEMENT") == 0){
                  $totalDistance = $utils->metersToKilometers($totalDistance);
                  $totalTime = ($resume->timestampEnd - $resume->timestampStart)/60 /60;

                  if($totalTime > 0)
                     $resume->speed = $totalDistance / $totalTime;
                  else
                     $resume->speed = 0;

                  $resume->totalDistance = $totalDistance;
                  $resume->totalTime = $totalTime;
               }

               
            }


            $index++;
         }

         $result->resume[] = $resume; 
         
         return $result;
      }
      else{
         $result->reports = [];
         return $result;
      }
   }

    public function getGeofenceReport($deviceImei, $params){
        return $this->databaseReport->getGeofenceReport($deviceImei, $params);
   }

   public function getAlerts($params){
      return $this->databaseReport->getAlerts($params);
   }

   public function getDistanceReport($params){
      //TODO: Get Reports
      $device = new DeviceGPS();
      $utils = new Utils();
      $date = new \DateTime();
      $date->setTimezone(new \DateTimeZone($params->timezone));
    
      $params->imei = $device->getDeviceImei($params->deviceID);
      $alias = $device->getAlias($params->deviceID);

      $report = (object)[
         "device" => (object)[
            "imei" => $params->imei,
            "alias" => $alias,
         ],
         "timezone" => $params->timezone,
         "from" => (object)[
            "date" => "",
            "timestamp" => $params->fromTimestamp
         ],
         "to" => (object)[
            "date" => "",
            "timestamp" => $params->toTimestamp
         ],
         "distanceTraveledAverage" => 0,
         "distanceTraveled" => 0,
         "monthPeriods" => [],
         "weekPeriods"=>[],
         "totalReports" => 0,
         "daysOnPeriod" => 0
      ];

      $date->setTimestamp($report->from->timestamp);
      $report->from->date = $date->format('d-m-y');
      $date->setTimestamp($report->to->timestamp);
      $report->to->date = $date->format('d-m-y');


      $auxCurrentMonth = (object) [
         "reportsCounter" => 0,
         "distance" => 0,
         "reports" => []
      ];

      $auxCurrentWeek = (object) [
         "reportsCounter" => 0,
         "distance" => 0,
         "reports" => []
      ];


      //Obtener reportes de la base de datos
      $dataSet = $this->databaseReport->getDistanceReport($params);
      if(count($dataSet) <= 0)
         return $report; //Si no hay reportes, regresar reporte en blanco

      $lastRow = $dataSet[0];       
      foreach ($dataSet as $row) {
         $date->setTimestamp($row->timestamp);
         $distance = $utils->haversine($lastRow, $row);

         //Calcular datos globales
         $report->distanceTraveled += $distance;
       
         //Calcular Datos del MES
         if(!array_key_exists($date->format('m-yy'), $report->monthPeriods)){
            //No existe 
            $report->monthPeriods[$date->format('m-yy')] = (object)[
               "from" => (object)[
                  "date" => $date->format('d-m-yy'),
                  "timestamp" => $row->timestamp
               ],
               "to" => (object)[
                  "date" => "",
                  "timestamp" => 0
               ],
               "distanceTraveledAverage" => 0,
               "distanceTraveled" => 0,
               "totalReports" => 0
            ];

            $auxCurrentMonth->reportsCounter = 0;
            $auxCurrentMonth->distance = 0;
            $auxCurrentMonth->reports = [];

            $auxCurrentMonth->from = new \DateTime();
            $auxCurrentMonth->from->setTimezone(new \DateTimeZone($params->timezone));
            $auxCurrentMonth->from->setTimestamp($row->timestamp);
         }

         $auxCurrentMonth->reportsCounter += 1;
         $auxCurrentMonth->distance += $distance;
            
         $currentMonth = $report->monthPeriods[$date->format('m-yy')];
         $currentMonth->to->date = $date->format('d-m-yy');
         $currentMonth->to->timestamp = $row->timestamp;

         
         $auxCurrentMonth->to = new \DateTime();
         $auxCurrentMonth->to->setTimezone(new \DateTimeZone($params->timezone));
         $auxCurrentMonth->to->setTimestamp($row->timestamp);

         $currentMonth->daysOnPeriod = $auxCurrentMonth->to->diff($auxCurrentMonth->from)->d;
         
         if($currentMonth->daysOnPeriod > 0)
            $currentMonth->distanceTraveledAverage = $auxCurrentMonth->distance / $currentMonth->daysOnPeriod;
         else
            $currentMonth->distanceTraveledAverage = 0;


         $currentMonth->distanceTraveled = round( $utils->metersToKilometers($auxCurrentMonth->distance),2);
         $currentMonth->totalReports = $auxCurrentMonth->reportsCounter;
         $currentMonth->distanceTraveledAverage = round( $utils->metersToKilometers($currentMonth->distanceTraveledAverage),2);
         

         //Calculo del periodo
         if(!array_key_exists($date->format('W-yy'), $report->weekPeriods)){
            //No existe 
            $report->weekPeriods[$date->format('W-yy')] = (object)[
               "from" => (object)[
                  "date" => $date->format('d-m-yy'),
                  "timestamp" => $row->timestamp
               ],
               "to" => (object)[
                  "date" => "",
                  "timestamp" => 0
               ],
               "distanceTraveledAverage" => 0,
               "distanceTraveled" => 0,
               "daysOnPeriod" => 0,
               "totalReports" => 0
            ];

            $auxCurrentWeek->reportsCounter = 0;
            $auxCurrentWeek->distance = 0;

            $auxCurrentWeek->from = new \DateTime();
            $auxCurrentWeek->from->setTimezone(new \DateTimeZone($params->timezone));
            $auxCurrentWeek->from->setTimestamp($row->timestamp);
         }

         $auxCurrentWeek->reportsCounter += 1;
         $auxCurrentWeek->distance += $distance;
            
         $currentWeek = $report->weekPeriods[$date->format('W-yy')];
         $currentWeek->to->date = $date->format('d-m-yy');
         $currentWeek->to->timestamp = $row->timestamp;

        
         $auxCurrentWeek->to = new \DateTime();
         $auxCurrentWeek->to->setTimezone(new \DateTimeZone($params->timezone));
         $auxCurrentWeek->to->setTimestamp($row->timestamp);

         $currentWeek->daysOnPeriod = $auxCurrentWeek->to->diff($auxCurrentWeek->from)->d;
         
         if($currentWeek->daysOnPeriod > 0)
            $currentWeek->distanceTraveledAverage = $auxCurrentWeek->distance / $currentWeek->daysOnPeriod;
         else
            $currentWeek->distanceTraveledAverage = 0;

         $currentWeek->distanceTraveled = round( $utils->metersToKilometers($auxCurrentWeek->distance),2);
         $currentWeek->distanceTraveledAverage = round( $utils->metersToKilometers( $currentWeek->distanceTraveledAverage), 2);
         $currentWeek->totalReports = $auxCurrentWeek->reportsCounter;


         $lastRow = $row;
      };

       //Fix and calculate global data
      $fromPeriod = new \DateTime();
      $fromPeriod->setTimezone(new \DateTimeZone($params->timezone));
      $fromPeriod->setTimestamp($report->from->timestamp);

      $toPeriod = new \DateTime();
      $toPeriod->setTimezone(new \DateTimeZone($params->timezone));
      $toPeriod->setTimestamp($report->to->timestamp);

      $report->daysOnPeriod = $toPeriod->diff($fromPeriod)->d;
      if($report->daysOnPeriod > 0)
         $report->distanceTraveledAverage = $report->distanceTraveled / $report->daysOnPeriod;
      else
         $report->distanceTraveledAverage = 0;


      $report->totalReports = count($dataSet);
      $report->distanceTraveled = round( $utils->metersToKilometers($report->distanceTraveled), 2);
      $report->distanceTraveledAverage = round( $utils->metersToKilometers($report->distanceTraveledAverage),2);
      
      return $report;
   }
   public function getDistanceReportPDF($params){
      $report = $this->getDistanceReport($params);

      //PDF Format
      $pdf = new LetterFPDF('L');
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',14);
      $pdf->Cell(0,6,'REPORTE DE DISTANCIA RECORRIDA');
      $pdf->LN();
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(70,7,"PERIODO DEL {$report->from->date} AL {$report->to->date}");
      $pdf->LN(10);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"NOMBRE DE LA UNIDAD:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,$report->device->alias);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(80,7,"DISTANCIA RECORRIDA:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,$report->distanceTraveled." Km");
      $pdf->LN();
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"IMEI:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,$report->device->imei);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(80,7,"PROM. DE DISTANCIA RECORRIDA:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,$report->distanceTraveledAverage." km");
      $pdf->LN(15);

      $pdf->SetFont('Arial','B',10);
      
      $headers = array('IMEI','ALIAS','DESDE','HASTA','DISTANCIA RECORRIDA','PROM. DISTANCIA RECORRIDA');
      $colWidths = array(35,65,25,25,50,60);
      
      $pdf->setFillColor(63,77,103);
      $pdf->setTextColor(255,255,255);
      for ($i=0; $i < count($headers) ; $i++) { 
         $pdf->cell($colWidths[$i],7, $headers[$i], 1, 0,'C',1);
      }
      $pdf->LN();

      $pdf->SetFont('Arial','',9);
      $pdf->setTextColor(0,0,0);
    
      $weeks = array_keys($report->weekPeriods);
      for ($i=0; $i < count($weeks); $i++) {
         $week = $report->weekPeriods[ $weeks[$i]];
      
         if($i%2==0)
            $pdf->setFillColor(255,255,255);  
         else
            $pdf->setFillColor(245,245,245);
            
         $pdf->cell($colWidths[0], 7, $report->device->imei, 1,0,'C',1);
         $pdf->cell($colWidths[1], 7, $report->device->alias, 1,0,'C',1);
         $pdf->cell($colWidths[2], 7, $week->from->date, 1,0,'C',1);
         $pdf->cell($colWidths[3], 7, $week->to->date, 1,0,'C',1);
         $pdf->cell($colWidths[4], 7, $week->distanceTraveled." Km", 1,0,'C',1);
         $pdf->cell($colWidths[5], 7, $week->distanceTraveledAverage." Km", 1,0,'C',1);
         $pdf->LN();
      }

      return $pdf;
   }

   public function getMotorHoursReport($params){
      $device = new DeviceGPS();
      $utils = new Utils();

      $date = Carbon::now();
      $date->setTimezone($params->timezone);
      $params->imei = $device->getDeviceImei($params->deviceID);
      $alias = $device->getAlias($params->deviceID);

      $report= (object)[
         "device" => (object)[
            "imei" => $params->imei,
            "alias" => $alias,
         ],
         "timezone" => $params->timezone,
         "from" => (object)[
            "date" => $date->setTimestamp($params->fromTimestamp)->format('d-m-y'),
            "timestamp" => $params->fromTimestamp
         ],
         "to" => (object)[
            "date" =>  $date->setTimestamp($params->toTimestamp)->format('d-m-y'),
            "timestamp" => $params->toTimestamp
         ],
         "engineRunningTime" => (object)[
            "days"=> 0,
            "hours"=> 0,
            "minutes"=> 0,
            "seconds"=> 0,
            "totalSeconds"=> 0
         ],
         "engineOffTime" => (object)[
            "days"=> 0,
            "hours"=> 0,
            "minutes"=> 0,
            "seconds"=> 0,
            "totalSeconds"=> 0
         ],
         "monthPeriods" =>[],
         "weekPeriods" => [],
         "totalReports" => 0
      ];

      //Obtener datos de la bd
      $dataSet = $this->databaseReport->getIgnitionReport($params);

      if(count($dataSet) <= 0)
         return $report; //Si no hay reportes, regresar reporte en blanco

      //Obtener periodo total y periodo semanal
      $lastRow = $dataSet[0]; 
      foreach ($dataSet as $row) {
         if($lastRow->ignitionState != $row->ignitionState){
            $diff = $row->timestamp - $lastRow->timestamp;
         
            $currentReport = (object)[
               "fromTimestamp"=>(int)$lastRow->timestamp,
               "fromTime"=>$date->setTimestamp($lastRow->timestamp)->format("d-m-y H:i"),
               "toTimestamp"=>$row->timestamp,
               "toTime"=>$date->setTimestamp($row->timestamp)->format("d-m-y H:i"),
               "engineRunningTime" => 0,
               "engineOffTime" => 0
            ];

            if($lastRow->ignitionState == 1){
               $currentReport->engineRunningTime = $diff;
               $report->engineRunningTime->totalSeconds += $diff;
            }          
            else{
               $currentReport->engineOffTime = $diff;
               $report->engineOffTime->totalSeconds += $diff;           
            }
          
            //Si el reporte abarca varios dias recorrer dia por dia
            $repeat = false;
            $fromTimestamp = (int) $lastRow->timestamp;
            $toTimestamp = $row->timestamp;
            $dailyReports = [];       
            do {
               $date->setTimestamp($fromTimestamp);
               $endOfDay = $date->copy()->endOfDay();
               $dayReport = (object)[
                  "fromTimestamp"=>0,
                  "toTimestamp"=>0,
                  "diff"=>0,
                  "engineRunningTime"=>0,
                  "engineOffTime"=>0,
               ];

               if($toTimestamp > $endOfDay->getTimestamp()){
                  $dayReport->fromTimestamp = $fromTimestamp;
                  $dayReport->toTimestamp = $endOfDay->getTimestamp();
                  $dayReport->diff = $endOfDay->getTimestamp() - $fromTimestamp;
                  $fromTimestamp = $endOfDay->getTimestamp()+1;
                  $repeat = true;
               }
               else{
                  $dayReport->fromTimestamp = $fromTimestamp;
                  $dayReport->toTimestamp = $toTimestamp;
                  $dayReport->diff = $toTimestamp - $fromTimestamp;
                  $repeat = false;
               }

               if($lastRow->ignitionState == 1)
                  $dayReport->engineRunningTime = $dayReport->diff;        
               else
                  $dayReport->engineOffTime = $dayReport->diff;


               $dayReport->day = $date->setTimestamp($dayReport->fromTimestamp)->format("d-m"); 
               $currentWeekKey = $date->setTimestamp($dayReport->fromTimestamp)->format('W-yy');
               //Obtener Calculo Semanal
               if(!array_key_exists($currentWeekKey, $report->weekPeriods)){
                  $report->weekPeriods[$currentWeekKey] = (object)[
                     "from"=>(object)[
                        "timestamp" => $dayReport->fromTimestamp,
                        "date" => $date->setTimestamp($dayReport->fromTimestamp)->format('d-m-y H:i')
                     ],
                     "to"=>(object)[
                        "timestamp"=> 0,
                        "date"=> ""
                     ],
                     "engineRunningTime"=>(object)[
                        "days"=> 0,
                        "hours"=> 0,
                        "minutes"=> 0,
                        "seconds"=> 0,
                        "totalSeconds"=> 0
                     ],
                     "engineOffTime"=>(object)[
                        "days"=> 0,
                        "hours"=> 0,
                        "minutes"=> 0,
                        "seconds"=> 0,
                        "totalSeconds"=> 0
                     ]
                  ];
               }
               
               $currentWeek = $report->weekPeriods[$currentWeekKey];
               $engineRunningTime =  $currentWeek->engineRunningTime->totalSeconds + $dayReport->engineRunningTime;
               $engineOffTime = $currentWeek->engineOffTime->totalSeconds + $dayReport->engineOffTime;

               $currentWeek->to->timestamp = $dayReport->toTimestamp;
               $currentWeek->to->date = $date->setTimestamp($dayReport->toTimestamp)->format('d-m-y H:i');
               $currentWeek->engineRunningTime = $utils->secondsToTimeLapse($engineRunningTime);
               $currentWeek->engineOffTime = $utils->secondsToTimeLapse($engineOffTime);             
            } while ($repeat);

            $lastRow = $row;
         }
        
      }

      //Obtener Calculo Mensual
      foreach ($report->weekPeriods as $week) {
         $currentMonthKey = $date->setTimestamp($week->from->timestamp)->format('m-yy');
         if(!array_key_exists($currentMonthKey, $report->monthPeriods)){
            $report->monthPeriods[$currentMonthKey] = (object)[
               "from"=>(object)[
                  "timestamp" => $week->from->timestamp,
                  "date" => $date->setTimestamp($week->from->timestamp)->format('d-m-y H:i')
               ],
               "to"=>(object)[
                  "timestamp"=> 0,
                  "date"=> ""
               ],
               "engineRunningTime"=>(object)[
                  "days"=> 0,
                  "hours"=> 0,
                  "minutes"=> 0,
                  "seconds"=> 0,
                  "totalSeconds"=> 0
               ],
               "engineOffTime"=>(object)[
                  "days"=> 0,
                  "hours"=> 0,
                  "minutes"=> 0,
                  "seconds"=> 0,
                  "totalSeconds"=> 0
               ]
            ];
         }

         $currentMonth = $report->monthPeriods[$currentMonthKey];
         $engineRunningTime =  $currentMonth->engineRunningTime->totalSeconds + $week->engineRunningTime->totalSeconds;
         $engineOffTime = $currentMonth->engineOffTime->totalSeconds + $week->engineOffTime->totalSeconds;


         $currentMonth->to->timestamp = $week->to->timestamp;
         $currentMonth->to->date = $date->setTimestamp($week->to->timestamp)->format('d-m-y H:i');
         $currentMonth->engineRunningTime = $utils->secondsToTimeLapse($engineRunningTime);
         $currentMonth->engineOffTime = $utils->secondsToTimeLapse($engineOffTime);               
      }

      $report->engineRunningTime = $utils->secondsToTimeLapse($report->engineRunningTime->totalSeconds);
      $report->engineOffTime = $utils->secondsToTimeLapse($report->engineOffTime->totalSeconds);
      $report->totalReports = count($dataSet);
      return $report;   
   }
   public function getMotorHoursReportPDF($params){
      $report = $this->getMotorHoursReport($params);

      //PDF Format
      $pdf = new LetterFPDF('L');
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',14);
      $pdf->Cell(0,6,'REPORTE DE USO DE MOTOR');
      $pdf->LN();
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(70,7,"PERIODO DEL {$report->from->date} AL {$report->to->date}");
      $pdf->LN(10);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"NOMBRE DE LA UNIDAD:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->device->alias);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(60,7,"TIEMPO EN OPERACION:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,"{$report->engineRunningTime->days} dias {$report->engineRunningTime->hours} horas {$report->engineRunningTime->minutes} minutos");
      $pdf->LN();
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"IMEI:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->device->imei);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(60,7,"TIEMPO DETENIDO:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,"{$report->engineOffTime->days} dias {$report->engineOffTime->hours} horas {$report->engineOffTime->minutes} minutos");
      $pdf->LN(15);

      $pdf->SetFont('Arial','B',10);
      
      $headers = array('IMEI','ALIAS','DESDE','HASTA','TIEMPO ENCENDIDO','TIEMPO APAGADO');
      $colWidths = array(35,65,25,25,55,55);
      
      $pdf->setFillColor(63,77,103);
      $pdf->setTextColor(255,255,255);
      for ($i=0; $i < count($headers) ; $i++) { 
         $pdf->cell($colWidths[$i],7, $headers[$i], 1, 0,'C',1);
      }
      $pdf->LN();

      $pdf->SetFont('Arial','',9);
      $pdf->setTextColor(0,0,0);
    
      $weeks = array_keys($report->weekPeriods);
      for ($i=0; $i < count($weeks); $i++) {
         $week = $report->weekPeriods[ $weeks[$i]];
      
         if($i%2==0)
            $pdf->setFillColor(255,255,255);  
         else
            $pdf->setFillColor(245,245,245);
            
         $pdf->cell($colWidths[0], 7, $report->device->imei, 1,0,'C',1);
         $pdf->cell($colWidths[1], 7, $report->device->alias, 1,0,'C',1);
         $pdf->cell($colWidths[2], 7, $week->from->date, 1,0,'C',1);
         $pdf->cell($colWidths[3], 7, $week->to->date, 1,0,'C',1);
         $pdf->cell($colWidths[4], 7, "{$week->engineRunningTime->days} dias {$week->engineRunningTime->hours} horas {$week->engineRunningTime->minutes} minutos", 1,0,'C',1);
         $pdf->cell($colWidths[5], 7, "{$week->engineOffTime->days} dias {$week->engineOffTime->hours} horas {$week->engineOffTime->minutes} minutos", 1,0,'C',1);
         $pdf->LN();
      }

      return $pdf;
   }

   public function getRalentiReport($params){
      $device = new DeviceGPS();
      $utils = new Utils();

      $date = Carbon::now();
      $date->setTimezone($params->timezone);
      $params->imei = $device->getDeviceImei($params->deviceID);
      $alias = $device->getAlias($params->deviceID);

      $report= (object)[
         "device" => (object)[
            "imei" => $params->imei,
            "alias" => $alias,
         ],
         "timezone" => $params->timezone,
         "from" => (object)[
            "date" => $date->setTimestamp($params->fromTimestamp)->format('d-m-y'),
            "timestamp" => $params->fromTimestamp
         ],
         "to" => (object)[
            "date" =>  $date->setTimestamp($params->toTimestamp)->format('d-m-y'),
            "timestamp" => $params->toTimestamp
         ],
         "ralentiTime" => (object)[
            "days"=> 0,
            "hours"=> 0,
            "minutes"=> 0,
            "seconds"=> 0,
            "totalSeconds"=> 0
         ],
         "maxRalentiTime" => (object)[
            "days"=> 0,
            "hours"=> 0,
            "minutes"=> 0,
            "seconds"=> 0,
            "totalSeconds"=> 0
         ],
         "monthPeriods" =>[],
         "weekPeriods" => []
      ];

      //Obtener datos de la bd
      $dataSet = $this->databaseReport->getRalentiReport($params);

      if(count($dataSet) <= 0)
         return $report; //Si no hay reportes, regresar reporte en blanco

      //Buscar el primer reporte con ignicion 1 y velocidad <= umbral
      $speedUmbral = 0.6;
      $minTime = 180;
   
      $maxRalentiTime = 0;
      $period = null;
      foreach ($dataSet as $row) { 
         if($row->ignition != 1 || $row->ignition == 1 && $row->speed >= $speedUmbral){
            if(!is_null($period)){
               //Existe periodo en curso, terminarlo.
               $period->to->timestamp = $row->timestamp;
               $period->to->date =  $date->setTimestamp($row->timestamp)->format('d-m-y H:i');
               $period->time->totalSeconds = $period->to->timestamp - $period->from->timestamp;
               $period->time = $utils->secondsToTimeLapse($period->time->totalSeconds);

               $period->address = $row->address;

               if($period->time->totalSeconds >= $minTime){
                  $report->ralentiTime->totalSeconds += $period->time->totalSeconds;

                  if($period->time->totalSeconds > $report->maxRalentiTime->totalSeconds)
                     $report->maxRalentiTime->totalSeconds = $period->time->totalSeconds;
               
                  //Agregar al periodo Semanal
                  $weekKey = $date->setTimestamp($period->from->timestamp)->format('W-yy');
                  if(!array_key_exists($weekKey, $report->weekPeriods)){
                     //No existe la semana
                     $report->weekPeriods[$weekKey] = (object)[
                        "from" => (object)[
                           "timestamp" => $period->from->timestamp,
                           "date" => $date->setTimestamp($period->from->timestamp)->format('d-m-y H:i')
                        ],
                        "to" => (object)[
                           "timestamp"=>0,
                           "date"=>""
                        ],
                        "ralentiTime" => (object)[
                           "days"=> 0,
                           "hours"=> 0,
                           "minutes"=> 0,
                           "seconds"=> 0,
                           "totalSeconds"=> 0
                        ],
                        "maxRalentiTime" => (object)[
                           "days"=> 0,
                           "hours"=> 0,
                           "minutes"=> 0,
                           "seconds"=> 0,
                           "totalSeconds"=> 0
                        ]
                     ];            
                  }

                  $week = $report->weekPeriods[$weekKey];
                  $week->to->timestamp = $row->timestamp;
                  $week->to->date = $date->setTimestamp($row->timestamp)->format('d-m-y H:i');
                  $week->ralentiTime->totalSeconds += $period->time->totalSeconds;
                  $week->ralentiTime = $utils->secondsToTimeLapse($week->ralentiTime->totalSeconds);
                  
                  if($period->time->totalSeconds > $week->maxRalentiTime->totalSeconds)
                     $week->maxRalentiTime->totalSeconds = $period->time->totalSeconds;
                  
                  $week->maxRalentiTime = $utils->secondsToTimeLapse($week->maxRalentiTime->totalSeconds);

                  $report->reports[] = $period;                 
               }
              
            }

            $period = null;
         }
         else{
            if(is_null($period)){
               //No existe periodo en curso, iniciar
               $period = (object)[
                  "from" => (object)[
                     "timestamp" => $row->timestamp,
                     "date" => $date->setTimestamp($row->timestamp)->format('d-m-y H:i')
                  ],
                  "to" => (object)[
                     "timestamp"=>0,
                     "date"=>""
                  ],
                  "time" => (object)[
                     "days"=> 0,
                     "hours"=> 0,
                     "minutes"=> 0,
                     "seconds"=> 0,
                     "totalSeconds" => 0
                  ],
                  "address" => "",
               ];            
            }       
         }

      }

      //Obtener Calculo Mensual
      foreach ($report->weekPeriods as $week) {
         $monthKey = $date->setTimestamp($week->from->timestamp)->format('m-yy');
         if(!array_key_exists($monthKey, $report->monthPeriods)){
            $report->monthPeriods[$monthKey] = (object)[
               "from"=>(object)[
                  "timestamp" => $week->from->timestamp,
                  "date" => $date->setTimestamp($week->from->timestamp)->format('d-m-y H:i')
               ],
               "to"=>(object)[
                  "timestamp"=> 0,
                  "date"=> ""
               ],
               "ralentiTime" => (object)[
                  "days"=> 0,
                  "hours"=> 0,
                  "minutes"=> 0,
                  "seconds"=> 0,
                  "totalSeconds"=> 0
               ],
               "maxRalentiTime" => (object)[
                  "days"=> 0,
                  "hours"=> 0,
                  "minutes"=> 0,
                  "seconds"=> 0,
                  "totalSeconds"=> 0
               ],
            ];
         }


         $month = $report->monthPeriods[$monthKey];
         $month->to->timestamp = $week->to->timestamp;
         $month->to->date = $date->setTimestamp($week->to->timestamp)->format('d-m-y H:i');
         $month->ralentiTime->totalSeconds += $week->ralentiTime->totalSeconds;
         $month->ralentiTime = $utils->secondsToTimeLapse($month->ralentiTime->totalSeconds);
         
         if($week->maxRalentiTime->totalSeconds > $month->maxRalentiTime->totalSeconds)
            $month->maxRalentiTime->totalSeconds = $week->maxRalentiTime->totalSeconds;
         
         $month->maxRalentiTime = $utils->secondsToTimeLapse($month->maxRalentiTime->totalSeconds);           
      }

      $report->ralentiTime = $utils->secondsToTimeLapse($report->ralentiTime->totalSeconds);
      $report->maxRalentiTime = $utils->secondsToTimeLapse($report->maxRalentiTime->totalSeconds);


      return $report;
   }
   public function getRalentiReportFilePDF($params){
      $report = $this->getRalentiReport($params);
      
      //PDF Format
      $pdf = new LetterFPDF('L');
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',14);
      $pdf->Cell(0,6,'REPORTE DE RALENTI');
      $pdf->LN();
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(70,7,"PERIODO DEL {$report->from->date} AL {$report->to->date}");
      $pdf->LN(10);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"NOMBRE DE LA UNIDAD:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->device->alias);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"TIEMPO EN RALENTI:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,"{$report->ralentiTime->days} dias {$report->ralentiTime->hours} horas {$report->ralentiTime->minutes} minutos");
      $pdf->LN();
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"IMEI:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->device->imei);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"MAXIMO TIEMPO EN RALENTI:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,"{$report->maxRalentiTime->days} dias {$report->maxRalentiTime->hours} horas {$report->maxRalentiTime->minutes} minutos");
      $pdf->LN(15);

      $pdf->SetFont('Arial','B',10);
      
      $headers = array('IMEI','ALIAS','DESDE','HASTA','TIEMPO RALENTI','DIRECCION');
      $colWidths = array(35,65,25,25,35,80);
      
      $pdf->setFillColor(63,77,103);
      $pdf->setTextColor(255,255,255);
      for ($i=0; $i < count($headers) ; $i++) { 
         $pdf->cell($colWidths[$i],7, $headers[$i], 1, 0,'C',1);
      }
      $pdf->LN();

      $pdf->SetFont('Arial','',9);
      $pdf->setTextColor(0,0,0);
    
      foreach ($report->reports as $row) {
         if($i%2==0)
            $pdf->setFillColor(255,255,255);  
         else
            $pdf->setFillColor(245,245,245);
            
         $rowHeight = $pdf->GetMultiCellHeight($colWidths[5], 5, "{$row->address}", 1, 'J');

         $pdf->cell($colWidths[0], $rowHeight, $report->device->imei, 1,0,'C',1);
         $pdf->cell($colWidths[1], $rowHeight, $report->device->alias, 1,0,'C',1);
         $pdf->cell($colWidths[2], $rowHeight, $row->from->date, 1,0,'C',1);
         $pdf->cell($colWidths[3], $rowHeight, $row->to->date, 1,0,'C',1);
         $pdf->cell($colWidths[4], $rowHeight, "{$row->time->hours} horas {$row->time->minutes} minutos", 1,0,'C',1);
         $pdf->MultiCell($colWidths[5], 5, "{$row->address}", 1,'J',1);
      }

      return $pdf;
   }

   public function getUserLoginReport($params){
      $user = new User();
      $utils = new Utils();

      $date = Carbon::now();
      $date->setTimezone($params->timezone);
      $alias = $user->getUsername($params->userID);

      $report= (object)[
         "user" => (object)[
            "id" => $params->userID,
            "alias" => $alias,
         ],
         "timezone" => $params->timezone,
         "from" => (object)[
            "date" => $date->setTimestamp($params->fromTimestamp)->format('d-m-y'),
            "timestamp" => $params->fromTimestamp
         ],
         "to" => (object)[
            "date" =>  $date->setTimestamp($params->toTimestamp)->format('d-m-y'),
            "timestamp" => $params->toTimestamp
         ],
         "totalAccess" => 0,
         "accessAverage" => 0,
         "monthPeriods" =>[],
         "weekPeriods" => [],
         "reports" => []
      ];

      

      // //Obtener datos de la bd
      $dataSet = $this->databaseReport->getUserLoginReport($params);

      if(count($dataSet) <= 0)
         return $report; //Si no hay reportes, regresar reporte en blanco


      foreach ($dataSet as $row) { 
         $weekKey = $date->setTimestamp($row->timestamp)->format('W-y');
         if(!array_key_exists($weekKey, $report->weekPeriods)){
               //Crear semana
            $report->weekPeriods[$weekKey] = (object)[
               "from" => (object)[
                  "timestamp" => $row->timestamp,
                  "date" => $date->setTimestamp($row->timestamp)->format('d-m-y H:i'),
                  ],
               "to" => (object)[
                  "timestamp"=>0,
                  "date"=>""
                  ],
                  "totalAccess"=>0
               ];            
         }

         $week = $report->weekPeriods[$weekKey];
         $week->to->timestamp = $row->timestamp;
         $week->to->date = $date->setTimestamp($row->timestamp)->format('d-m-y H:i');
         $week->totalAccess += 1;

         $row->date = $date->setTimestamp($row->timestamp)->format('d-m-y H:i');
         $report->reports[] = $row;


         //Calculo Mensual
         $monthKey = $date->setTimestamp($row->timestamp)->format('m-y');
         if(!array_key_exists($monthKey, $report->monthPeriods)){
            $report->monthPeriods[$monthKey] = (object)[
               "from" => (object)[
                  "timestamp" => $row->timestamp,
                  "date" => $date->setTimestamp($row->timestamp)->format('d-m-y H:i'),
                  ],
               "to" => (object)[
                  "timestamp"=>0,
                  "date"=>""
                  ],
                  "totalAccess"=>0
               ];            
         }

         $month = $report->monthPeriods[$monthKey];
         $month->to->timestamp = $row->timestamp;
         $month->to->date = $date->setTimestamp($row->timestamp)->format('d-m-y H:i');
         $month->totalAccess += 1;

         $report->totalAccess +=1;
      }

      return $report;
   }
   public function getUserLoginReportFilePDF($params){
      $report = $this->getUserLoginReport($params);
      
      //PDF Format
      $pdf = new LetterFPDF('P');
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',14);
      $pdf->Cell(0,6,'REPORTE DE ACCESOS AL SISTEMA');
      $pdf->LN();
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(70,7,"PERIODO DEL {$report->from->date} AL {$report->to->date}");
      $pdf->LN(10);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"NOMBRE DE USUARIO:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->user->alias);
      $pdf->LN();
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"TOTAL DE ACCESOS:");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(70,7,"{$report->totalAccess}");
      $pdf->LN(15);

      $pdf->SetFont('Arial','B',10);
      
      $headers = array('USUARIO','FECHA DE INGRESO');
      $colWidths = array(100,100);
      
      $pdf->setFillColor(63,77,103);
      $pdf->setTextColor(255,255,255);
      for ($i=0; $i < count($headers) ; $i++) { 
         $pdf->cell($colWidths[$i],7, $headers[$i], 1, 0,'C',1);
      }
      $pdf->LN();

      $pdf->SetFont('Arial','',9);
      $pdf->setTextColor(0,0,0);
    
      foreach ($report->reports as $row) {
         if($i%2==0)
            $pdf->setFillColor(255,255,255);  
         else
            $pdf->setFillColor(245,245,245);
            

         $pdf->cell($colWidths[0], 7, $report->user->alias, 1,0,'C',1);
         $pdf->cell($colWidths[1], 7, $row->date, 1,0,'C',1);
         $pdf->LN();
      }

      return $pdf;
   }

   public function getStoppedReport($params){
      $device = new DeviceGPS();
      $utils = new Utils();

      $date = Carbon::now();
      $date->setTimezone($params->timezone);
      $params->imei = $device->getDeviceImei($params->deviceID);
      $alias = $device->getAlias($params->deviceID);

      $report= (object)[
         "device" => (object)[
            "imei" => $params->imei,
            "alias" => $alias,
         ],
         "timezone" => $params->timezone,
         "from" => (object)[
            "date" => $date->setTimestamp($params->fromTimestamp)->format('d-m-y'),
            "timestamp" => $params->fromTimestamp
         ],
         "to" => (object)[
            "date" =>  $date->setTimestamp($params->toTimestamp)->format('d-m-y'),
            "timestamp" => $params->toTimestamp
         ],
         "reports" => []
      ];

      // //Obtener datos de la bd
      $dataSet = $this->databaseReport->getStoppedReport($params);

      if(count($dataSet) <= 0)
         return $report; //Si no hay reportes, regresar reporte en blanco


      $lastRow = $dataSet[0];
      $counter = 0;
      $period = null;
      foreach ($dataSet as $row) {
         $distance = $utils->haversine($lastRow, $row);
         if($distance <= $params->maxDistance && $row->speed <= $params->maxSpeed){
            if(is_null($period)){
               $period = (object)[
                  "from"=>(object)[
                     "timestamp" => $lastRow->timestamp,
                     "date" => $date->setTimestamp($lastRow->timestamp)->format('d-m-y H:i')
                  ],
                  "to"=>(object)[
                     "timestamp" => 0,
                     "date" =>""
                  ],
                  "position" => (object)[
                     "lat" => $row->lat,
                     "lng" => $row->lng,
                     "address" => $row->address
                  ],
                  "time" => (object)[
                     "days"=> 0,
                     "hours"=> 0,
                     "minutes"=> 0,
                     "seconds"=> 0,
                     "totalSeconds" => 0
                  ],
                  "totalReports"=>0,
               ];               
            }

            $totalSeconds = $row->timestamp - $period->from->timestamp;

            $period->to->timestamp = $row->timestamp;
            $period->to->date = $date->setTimestamp($row->timestamp)->format('d-m-y H:i');
            $period->time = $utils->secondsToTimeLapse($totalSeconds);
            $period->totalReports++;
         }
         else{
            //Fuera de la distancia
               //Si hay periodo activo, terminarlo
            if(!is_null($period)){
               if($period->time->totalSeconds >= ($params->minTime*60) && $period->time->totalSeconds <= ($params->maxTime*60)){
                  $report->reports[] = clone $period;
               }

               $period = null;
            }
         }

         $lastRow = $row;
       }

       return $report;



   }
   public function getStoppedReportFilePDF($params){
      $report = $this->getStoppedReport($params);
     
      
       //PDF Format
       $pdf = new LetterFPDF('L');
       $pdf->AddPage();
       $pdf->SetFont('Arial','B',14);
       $pdf->Cell(0,6,'REPORTE DE PARADAS');
       $pdf->LN();
       $pdf->SetFont('Arial','',10);
       $pdf->Cell(70,7,"PERIODO DEL {$report->from->date} AL {$report->to->date}");
       $pdf->LN(10);
       $pdf->SetFont('Arial','',12);
       $pdf->Cell(60,7,"NOMBRE DE LA UNIDAD:");
       $pdf->SetFont('Arial','B',12);
       $pdf->Cell(60,7,$report->device->alias);
       $pdf->LN();
       $pdf->SetFont('Arial','',12);
       $pdf->Cell(60,7,"IMEI:");
       $pdf->SetFont('Arial','B',12);
       $pdf->Cell(60,7,$report->device->imei);
       $pdf->LN(15);
 
       $pdf->SetFont('Arial','B',10);
       
       $headers = array('DESDE','HASTA','POSICION','DIRECCION', "TIEMPO");
       $colWidths = array(30,30,50,80,60);
       
       $pdf->setFillColor(63,77,103);
       $pdf->setTextColor(255,255,255);
       for ($i=0; $i < count($headers) ; $i++) { 
          $pdf->cell($colWidths[$i],7, $headers[$i], 1, 0,'C',1);
       }
       $pdf->LN();
 
       $pdf->SetFont('Arial','',9);
       $pdf->setTextColor(0,0,0);
     
       foreach ($report->reports as $row) {
          if($i%2==0)
             $pdf->setFillColor(255,255,255);  
          else
             $pdf->setFillColor(245,245,245);
             
          $rowHeight = $pdf->GetMultiCellHeight($colWidths[3], 5, "{$row->position->address}", 1, 'J');
 
          $pdf->cell($colWidths[0], $rowHeight, $row->from->date, 1,0,'C',1);
          $pdf->cell($colWidths[1], $rowHeight, $row->to->date, 1,0,'C',1);
          $pdf->cell($colWidths[2], $rowHeight, "{$row->position->lat},{$row->position->lng}", 1,0,'C',1);
          $pdf->MultiCell($colWidths[3], 5, "{$row->position->address}", 1,'J',1);
          $pdf->cell($colWidths[4], $rowHeight, "{$row->time->hours} horas {$row->time->minutes} minutos", 1,0,'C',1);
          $pdf->LN();
       }
 
       return $pdf;
   }

   public function getSpeedReport($params){
      $device = new DeviceGPS();
      $utils = new Utils();
      $user = new User();

      $date = Carbon::now();
      $date->setTimezone($params->timezone);

      $alias = $user->getUsername($params->userID);

      $report = (object)[
         "user" => (object)[
            "id" => $params->userID,
            "alias" => $alias,
         ],
         "timezone" => $params->timezone,
         "from" => (object)[
            "date" => "",
            "timestamp" => $params->fromTimestamp
         ],
         "to" => (object)[
            "date" => "",
            "timestamp" => $params->toTimestamp
         ],
         "resume"=>(object)[
            "maxSpeedReached" => 0,
            "speedAverage" => 0,
            "infractions" => 0,
            "totalReports" => 0
         ],
         "monthPeriods" => [],
         "weekPeriods"=>[]
      ];

      $date->setTimestamp($report->from->timestamp);
      $report->from->date = $date->format('d-m-y');

      $date->setTimestamp($report->to->timestamp);
      $report->to->date = $date->format('d-m-y');

      //Obtener reportes de la base de datos
      $dataSet = $this->databaseReport->getWeekSpeedReport($params);

      if(count($dataSet) <= 0)
         return $report; //Si no hay reportes, regresar reporte en blanco
     

      //CALCULO SEMANAL
      $auxCounter = 0;
      $auxSum = 0;
      foreach ($dataSet as $row) {
         //Calculo del periodo
         $weekKey = $date->setTimestamp($row->fromTimestamp)->format('W-yy');

         if(!array_key_exists($weekKey, $report->weekPeriods)){
            //No existe
            $report->weekPeriods[$weekKey] = (object)[
               "from" => (object)[
                  "date" => $date->setTimestamp($row->fromTimestamp)->format('d-m-y'),
                  "timestamp" => $row->fromTimestamp
               ],
               "to" => (object)[
                  "date" => $date->setTimestamp($row->toTimestamp)->format('d-m-y'),
                  "timestamp" => $row->toTimestamp
               ],
               "resume"=>(object)[
                  "maxSpeedReached" => 0,
                  "speedAverage" => 0,
                  "infractions" => 0,
                  "totalReports" => 0
               ],
               "devices"=>[]
            ];

            $auxCounter = 0;
            $auxSum = 0;
         }
         $auxCounter +=1;
         $auxSum += $row->speedAverage;

         $week =  $report->weekPeriods[$weekKey];
         $week->to->date = $date->setTimestamp($row->toTimestamp)->format('d-m-y');
         $week->to->timestamp = $row->toTimestamp;
         $week->resume->infractions += $row->infractions;
         $week->resume->speedAverage = round($auxSum / $auxCounter,2);
         $week->resume->totalReports += $row->totalReports;

         if($row->maxSpeed > $week->resume->maxSpeedReached)
            $week->resume->maxSpeedReached = $row->maxSpeed;

         if(!array_key_exists($row->imei, $week->devices)){
            //No Existe
            $week->devices[$row->imei] = (object)[
               "imei" => $row->imei,
               "alias" => $row->alias,
               "maxSpeedReached" => $row->maxSpeed,
               "speedAverage" => $row->speedAverage,
               "infractions" => $row->infractions,
               "totalReports" => $row->totalReports
            ];
         }        
      };


      //CALCULO MENSUAL
      $auxCounter = 0;
      $auxSum = 0;
      $dataSet = $this->databaseReport->getMonthSpeedReport($params);
      foreach ($dataSet as $row) {
         $monthKey = $date->setTimestamp($row->fromTimestamp)->format('m-yy');
         if(!array_key_exists($monthKey, $report->monthPeriods)){
            //No existe
            $report->monthPeriods[$monthKey] = (object)[
               "from" => (object)[
                  "date" => $date->setTimestamp($row->fromTimestamp)->format('d-m-y'),
                  "timestamp" => $row->fromTimestamp
               ],
               "to" => (object)[
                  "date" => $date->setTimestamp($row->toTimestamp)->format('d-m-y'),
                  "timestamp" => $row->toTimestamp
               ],
               "resume"=>(object)[
                  "maxSpeedReached" => 0,
                  "speedAverage" => 0,
                  "infractions" => 0,
                  "totalReports" => 0
               ],
               "devices"=>[]
            ];
            $auxCounter = 0;
            $auxSum = 0;
         }

         $auxCounter +=1;
         $auxSum += $row->speedAverage;

         $month =  $report->monthPeriods[$monthKey];
         $month->to->date = $date->setTimestamp($row->toTimestamp)->format('d-m-y');
         $month->to->timestamp = $row->toTimestamp;
         $month->resume->infractions += $row->infractions;
         $month->resume->speedAverage = round($auxSum / $auxCounter, 2);
         $month->resume->totalReports += $row->totalReports;

         if($row->maxSpeed > $month->resume->maxSpeedReached)
            $month->resume->maxSpeedReached = $row->maxSpeed;

         if(!array_key_exists($row->imei, $month->devices)){
            //No Existe
            $month->devices[$row->imei] = (object)[
               "imei" => $row->imei,
               "alias" => $row->alias,
               "maxSpeedReached" => $row->maxSpeed,
               "speedAverage" => $row->speedAverage,
               "infractions" => $row->infractions,
               "totalReports" => $row->totalReports
            ];
         }    
         
         $report->resume->infractions += $row->infractions;
         $report->resume->totalReports += $row->totalReports;
         if($row->maxSpeed > $report->resume->maxSpeedReached)
            $report->resume->maxSpeedReached = $row->maxSpeed;
      };

      foreach ($report->monthPeriods as $period) {
         $report->resume->speedAverage += $period->resume->speedAverage;
      }

      if(count($report->monthPeriods) > 0)
         $report->resume->speedAverage = round($report->resume->speedAverage / count($report->monthPeriods),2);  
      else
      $report->resume->speedAverage = 0;

      return $report;
   }
   public function getSpeedReportFilePDF($params){
      $report = $this->getSpeedReport($params);
     
      
      //PDF Format
      $pdf = new LetterFPDF('L');
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',14);
      $pdf->Cell(0,6,'REPORTE DE VELOCIDAD');
      $pdf->LN();
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(70,7,"PERIODO DEL {$report->from->date} AL {$report->to->date}");
      $pdf->LN(10);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(30,7,"USUARIO: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(100,7,$report->user->alias);

      $pdf->SetFont('Arial','',12);
      $pdf->Cell(80,7,"VELOCIDAD PROMEDIO: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->resume->speedAverage." Km/h");
      $pdf->LN();

      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"VELOCIDAD MAXIMA DEFINIDA: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$params->maxSpeed." Km/h");
      
      
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(80,7,"MAXIMA VELOCIDAD ALCANZADA: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->resume->maxSpeedReached." Km/h");
      $pdf->LN();
      $pdf->Cell(130,7,"");
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(80,7,"EXCESOS DE VELOCIDAD: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->resume->infractions);
      $pdf->LN(15);

      $pdf->SetFont('Arial','B',10);
      
      $headers = array('IMEI','ALIAS','DESDE', 'HASTA', 'VEL. PROMEDIO','MAX. VELOCIDAD', "EXCESO DE VEL.");
      $colWidths = array(30,60,30,30,35,35,35);
      
      $pdf->setFillColor(63,77,103);
      $pdf->setTextColor(255,255,255);

      for ($i=0; $i < count($headers) ; $i++) { 
        $pdf->cell($colWidths[$i], 7, $headers[$i], 1,0,'C',1);    
      }

  
      $pdf->LN();

      $pdf->SetFont('Arial','',9);
      $pdf->setTextColor(0,0,0);
    

      $colorIter = 0;
      foreach ($report->weekPeriods as $week) {
         $fromDate = $week->from->date;
         $toDate = $week->to->date;

         foreach ($week->devices as $row) {

            if($colorIter%2==0)
               $pdf->setFillColor(255,255,255);  
            else
               $pdf->setFillColor(245,245,245);
               
            // $rowHeight = $pdf->GetMultiCellHeight($colWidths[3], 5, "{$row->position->address}", 1, 'J');
            $rowHeight = 7;

            $pdf->cell($colWidths[0], $rowHeight, $row->imei, 1,0,'C',1);
            $pdf->cell($colWidths[1], $rowHeight, $row->alias, 1,0,'C',1);
            $pdf->cell($colWidths[2], $rowHeight, $fromDate, 1,0,'C',1);
            $pdf->cell($colWidths[3], $rowHeight, $toDate, 1,0,'C',1);
            $pdf->cell($colWidths[4], $rowHeight, $row->speedAverage, 1,0,'C',1);
            $pdf->cell($colWidths[5], $rowHeight, $row->maxSpeedReached, 1,0,'C',1);
            $pdf->cell($colWidths[6], $rowHeight, $row->infractions, 1,0,'C',1);
            // $pdf->MultiCell($colWidths[3], 5, "{$row->position->address}", 1,'J',1);
         
            $pdf->LN();
            $colorIter ++;
         }
      }

      return $pdf;
   }

   public function getBatteryReport($params){
      $device = new DeviceGPS();
      $utils = new Utils();

     
      $date = Carbon::now();
      $date->setTimezone($params->timezone);

      $params->imei = $device->getDeviceImei($params->deviceID);
      $alias = $device->getAlias($params->deviceID);

      $report = (object)[
         "device" => (object)[
            "imei" => $params->imei,
            "alias" => $alias,
         ],
         "timezone" => $params->timezone,
         "from" => (object)[
            "date" => $date->setTimestamp($params->fromTimestamp)->format('d-m-y'),
            "timestamp" => $params->fromTimestamp
         ],
         "to" => (object)[
            "date" => $date->setTimestamp($params->toTimestamp)->format('d-m-y'),
            "timestamp" => $params->toTimestamp
         ],
         "resume"=>(object)[
            "batteryAverage" => 0,
            "powerSupplyAverage" => 0
         ],
         "monthPeriods" => [],
         "weekPeriods"=>[],
         "reports"=>[]
      ];

      //Obtener reportes de la base de datos
      $dataSet = $this->databaseReport->getBatteryReport($params);

      if(count($dataSet) <= 0)
         return $report; //Si no hay reportes, regresar reporte en blanco
     

      //CALCULO SEMANAL
      $totalAvgBattery = 0;
      $totalAvgPowerSupply = 0;

      $avgBattery = 0;
      $avgPowerSupply = 0;
      $counter = 0;

      $monthAvgBattery = 0;
      $monthAvgPowerSupply = 0;
      $monthCounter=0;
      foreach ($dataSet as $row) {

         $row->date = $date->setTimestamp($row->timestamp)->format('d-m-y H:i');
         if($row->week <= 9)
            $row->weekKey = "0".$row->week."-".$row->year;
         else
            $row->weekKey = $row->week."-".$row->year;


         if(!array_key_exists($row->weekKey, $report->weekPeriods)){
            $report->weekPeriods[$row->weekKey] = (object)[
               "from"=>(object)[
                  "timestamp" => $row->timestamp,
                  "date" =>  $date->setTimestamp($row->timestamp)->format('d-m-y'),
               ],
               "to"=>(object)[
                  "timestamp" => 0,
                  "date" =>  "",
               ],
               "batteryAverage" => 0,
               "powerSupplyAverage" => 0
            ];
            //Crear periodo
            $avgBattery = 0;
            $avgPowerSupply = 0;
            $counter=0;
         }

         $counter++;

         if($row->powerSupplyVolt > 0){
            $avgPowerSupply += $row->powerSupplyVolt;
            $totalAvgPowerSupply += $row->powerSupplyVolt;
         }
            
         if($row->batteryVolt > 0){
            $avgBattery += $row->batteryVolt;
            $totalAvgBattery+= $row->batteryVolt;
         }


         $week = $report->weekPeriods[$row->weekKey];
         $week->to->timestamp = $row->timestamp;
         $week->to->date = $date->setTimestamp($row->timestamp)->format('d-m-y');
         $week->batteryAverage = round($avgBattery / $counter, 2);
         $week->powerSupplyAverage = round($avgPowerSupply / $counter, 2);


         //Calcular Mes
         if(!array_key_exists($row->monthKey, $report->monthPeriods)){
            $report->monthPeriods[$row->monthKey] = (object)[
               "from"=>(object)[
                  "timestamp" => $row->timestamp,
                  "date" =>  $date->setTimestamp($row->timestamp)->format('d-m-y'),
               ],
               "to"=>(object)[
                  "timestamp" => 0,
                  "date" =>  "",
               ],
               "batteryAverage" => 0,
               "powerSupplyAverage" => 0
            ];
            //Crear periodo
            $monthAvgBattery = 0;
            $monthAvgPowerSupply = 0;
            $monthCounter=0;
         }

         $monthCounter++;
         if($row->powerSupplyVolt > 0)
            $monthAvgPowerSupply += $row->powerSupplyVolt;
            
         if($row->batteryVolt > 0)
            $monthAvgBattery += $row->batteryVolt;

         $month = $report->monthPeriods[$row->monthKey];
         $month->to->timestamp = $row->timestamp;
         $month->to->date = $date->setTimestamp($row->timestamp)->format('d-m-y');
         $month->batteryAverage = round($avgBattery / $counter, 2);
         $month->powerSupplyAverage = round($avgPowerSupply / $counter, 2);
      }

      $report->resume->batteryAverage = round($totalAvgBattery / count($dataSet), 2);
      $report->resume->powerSupplyAverage = round($totalAvgPowerSupply / count($dataSet), 2);
      $report->reports = $dataSet;
      return $report;

   }
   public function getBatteryReportFilePDF($params){
      $report = $this->getBatteryReport($params);
        
      //PDF Format
      $pdf = new LetterFPDF('L');
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',14);
      $pdf->Cell(0,6,'REPORTE DE BATERIA');
      $pdf->LN();
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(70,7,"PERIODO DEL {$report->from->date} AL {$report->to->date}");
      
      $pdf->LN(10);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(30,7,"DISPOSITIVO: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(100,7,$report->device->alias);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(80,7,"Promedio de bateria: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->resume->batteryAverage." V");
      $pdf->LN();
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(30,7,"IMEI: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(100,7,$report->device->imei);
      $pdf->SetFont('Arial','',12);
      $pdf->Cell(70,7,"Promedio de corriente externa: ");
      $pdf->SetFont('Arial','B',12);
      $pdf->Cell(60,7,$report->resume->powerSupplyAverage." V");
      $pdf->LN(15);

      $pdf->SetFont('Arial','B',10);
      $headers = array('IMEI','ALIAS','FECHA','Bateria','Corriente Externa');
      $colWidths = array(30,60,40,60,60);
      
      $pdf->setFillColor(63,77,103);
      $pdf->setTextColor(255,255,255);

      for ($i=0; $i < count($headers) ; $i++) { 
        $pdf->cell($colWidths[$i], 7, $headers[$i], 1,0,'C',1);    
      }

  
      $pdf->LN();

      $pdf->SetFont('Arial','',9);
      $pdf->setTextColor(0,0,0);
    

      $colorIter = 0;
      foreach ($report->reports as $row) {
            if($colorIter%2==0)
               $pdf->setFillColor(255,255,255);  
            else
               $pdf->setFillColor(245,245,245);
               
            // $rowHeight = $pdf->GetMultiCellHeight($colWidths[3], 5, "{$row->position->address}", 1, 'J');
            $rowHeight = 7;

            $pdf->cell($colWidths[0], $rowHeight, $report->device->imei, 1,0,'C',1);
            $pdf->cell($colWidths[1], $rowHeight, $report->device->alias, 1,0,'C',1);
            $pdf->cell($colWidths[2], $rowHeight, $row->date, 1,0,'C',1);
            $pdf->cell($colWidths[3], $rowHeight, $row->batteryVolt, 1,0,'C',1);
            $pdf->cell($colWidths[4], $rowHeight, $row->powerSupplyVolt, 1,0,'C',1);
          
           
         
            $pdf->LN();
            $colorIter ++;
         
      }

      return $pdf;
   }

   public function getNoReportReport($params){
      $device = new DeviceGPS();
      $utils = new Utils();

      $date = Carbon::now();
      $date->setTimezone($params->timezone);

      $params->imei = $device->getDeviceImei($params->deviceID);
      $alias = $device->getAlias($params->deviceID);

      $report = (object)[
         "device" => (object)[
            "imei" => $params->imei,
            "alias" => $alias,
         ],
         "timezone" => $params->timezone,
         "from" => (object)[
            "date" => $date->setTimestamp($params->fromTimestamp)->format('d-m-y'),
            "timestamp" => $params->fromTimestamp
         ],
         "to" => (object)[
            "date" => $date->setTimestamp($params->toTimestamp)->format('d-m-y'),
            "timestamp" => $params->toTimestamp
         ],
         "resume"=>(object)[
            "average" => (object)[
               "tracking" => 50,
               "notracking" => 50 
            ],
            "totalTime" => (object)[
               "days"=> 0,
               "hours"=> 0,
               "minutes"=> 0,
               "seconds"=> 0,
               "totalSeconds" => 0
            ],
            "maxTime" => (object)[
               "days"=> 0,
               "hours"=> 0,
               "minutes"=> 0,
               "seconds"=> 0,
               "totalSeconds" => 0
            ]
         ],
         "monthPeriods" => [],
         "weekPeriods"=>[],
      ];

    
      //Obtener reportes de la base de datos
      
      $dataSet = $this->databaseReport->getNoReportReport($params);

      if(count($dataSet) <= 0)
         return $report; //Si no hay reportes, regresar reporte en blanco
     
    
      $lastRow = $dataSet[0];
      $fromTimestamp = $lastRow->timestamp;
      $auxWeekTimestamp = 0;
      $auxMonthTimestamp = 0;
      foreach ($dataSet as $row) {
         $row->date = $date->setTimestamp($row->timestamp)->format('d-m-y H:i');
         
         if($row->week <= 9)
            $row->weekKey = "0".$row->week."-".$row->year;
         else
            $row->weekKey = $row->week."-".$row->year;
         

         $date->setTimestamp($row->timestamp);
         $diff = $row->timestamp - $lastRow->timestamp;

        
         if($diff >= $params->minTimestamp)
         {
            $report->resume->totalTime->totalSeconds += $diff;

            if($diff > $report->resume->maxTime->totalSeconds)
            $report->resume->maxTime->totalSeconds = $diff;

            //Agregar a week period
            if(!array_key_exists($row->weekKey, $report->weekPeriods)){
               $report->weekPeriods[$row->weekKey] = (object)[
                  "from"=>(object)[
                     "timestamp" => $row->timestamp,
                     "date" =>  $date->setTimestamp($row->timestamp)->format('d-m-y'),
                  ],
                  "to"=>(object)[
                     "timestamp" => 0,
                     "date" =>  "",
                  ],
                  "totalTime" => (object)[
                     "days"=> 0,
                     "hours"=> 0,
                     "minutes"=> 0,
                     "seconds"=> 0,
                     "totalSeconds" => 0
                  ],
               ];

               $auxWeekTimestamp = 0;
            }
            
            $auxWeekTimestamp += $diff;
            $week = $report->weekPeriods[$row->weekKey];
            $week->to->timestamp = $row->timestamp;
            $week->to->date = $date->setTimestamp($row->timestamp)->format('d-m-y');
            $week->totalTime = $utils->secondsToTimeLapse($auxWeekTimestamp);


            //Month Period
            if(!array_key_exists($row->monthKey, $report->monthPeriods)){
               $report->monthPeriods[$row->monthKey] = (object)[
                  "from"=>(object)[
                     "timestamp" => $row->timestamp,
                     "date" =>  $date->setTimestamp($row->timestamp)->format('d-m-y'),
                  ],
                  "to"=>(object)[
                     "timestamp" => 0,
                     "date" =>  "",
                  ],
                  "totalTime" => (object)[
                     "days"=> 0,
                     "hours"=> 0,
                     "minutes"=> 0,
                     "seconds"=> 0,
                     "totalSeconds" => 0
                  ],
               ];
               //Crear periodo
               $auxMonthTimestamp = 0;
            }
   
            $auxMonthTimestamp += $diff;
          
            $month = $report->monthPeriods[$row->monthKey];
            $month->to->timestamp = $row->timestamp;
            $month->to->date = $date->setTimestamp($row->timestamp)->format('d-m-y');
            $month->totalTime = $utils->secondsToTimeLapse($auxMonthTimestamp);
          
         }

        
         $lastRow = $row;
      }

      // $report->resume->batteryAverage = round($totalAvgBattery / count($dataSet), 2);
      // $report->resume->powerSupplyAverage = round($totalAvgPowerSupply / count($dataSet), 2);
      // $report->reports = $dataSet;

      $totalTimeReports = $lastRow->timestamp - $fromTimestamp;
      $report->resume->average->notracking =  round((($report->resume->totalTime->totalSeconds) *100) / $totalTimeReports, 2);
      $report->resume->average->tracking =  round((($totalTimeReports - $report->resume->totalTime->totalSeconds) *100) / $totalTimeReports, 2);

      $report->resume->maxTime = $utils->secondsToTimeLapse($report->resume->maxTime->totalSeconds);
      $report->resume->totalTime = $utils->secondsToTimeLapse($report->resume->totalTime->totalSeconds);
      return $report;

   }
}
