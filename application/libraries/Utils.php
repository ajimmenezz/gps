<?php
namespace Libraries;

class Utils {
    //Obtiene la distancia (en metros) entre 2 coordenadas
    function haversine($positionX, $positionY, $earthMeanRadius = 6371)
    {
        $deltaLatitude = deg2rad($positionY->lat - $positionX->lat);
        $deltaLongitude = deg2rad($positionY->lng - $positionX->lng);
        
        $a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) +
            cos(deg2rad($positionX->lat)) * cos(deg2rad($positionY->lat)) *
            sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    
        $result = $earthMeanRadius * $c; //En km
    
        return  $this->kilometersToMeters($result);
    }
  
  function kilometersToMeters($kilometers){
    return round ($kilometers / 0.001, 2);
  }
  
  function metersToKilometers($meters){
    return round ($meters / 1000.0, 2);
  }

  function metersToDecimalDegrees($meters, $earthMeanRadius = 6371){
    $earthMeanRadius = 6378.137;  //radius of the earth in kilometer
    $meterDegree = (1 / ((2 * pi() / 360) * $earthMeanRadius)) / 1000;  //1 meter in degree
    return $meters * $meterDegree; 
    //Existe una variacion del +- 4%  sobre los metros dados.
  }


  function getTimestampMidnight($extraSeconds = 0){
    $fecha = new \DateTime();
    $timestamp = $fecha->getTimestamp(); //86400s = 1 dia * 30 dias;
    $timestamp = strtotime("midnight", $timestamp+$extraSeconds );
      
    return $timestamp;

  }

  function getRandomNumericPassword(){
    $noDigits = 4;
    return substr(str_shuffle("0123456789"), 0, $noDigits);
  }

  function getRandomStringPassword(){
    $noDigits = 5;
    return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTVWXYZ"), 0, $noDigits);
  }

  function secondsToTimeLapse($s)
  {
    $seconds = $s;

    $days = floor($seconds / 86400);
    $seconds -= $days *86400;

    $hours = floor($seconds / 3600);
    $seconds -= $hours*3600;
    
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60; 

    return (object)[
        "days" => $days,
        "hours" =>  $hours,
        "minutes" => $minutes,
        "seconds" =>  $seconds,
        "totalSeconds" => $s
    ];
  }
  
}
