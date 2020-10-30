<?php

namespace Models;

use \Exception as Exception;

class DataBaseReport extends DataBase
{
   
    public function getReportHistorical($deviceImei, $params)
    {
        $partition = $this->getPartitionReportByImei($deviceImei);

        $query = "SELECT 
        (select alias from t_dispositivos where imei = report.imei) as alias,	
        report.imei as deviceImei,
        report.fecha as 'timestamp', 
        (select nombre from cat_tiporeporte where tipoReporte = report.idTipoReporte) as reportTypeString,	        
        report.idTipoReporte as reportType,
        report.lat, report.lng, report.direccion as address, report.velocidad as speed,
        report.posicionValida as validPosition
        from t_reportes PARTITION(${partition}) as report
        
        WHERE report.deviceId = (select id from t_dispositivos where imei = '${deviceImei}') ";

        if (isset($params->fromTimestamp) == true) {
            $query .= " AND report.fecha >= {$params->fromTimestamp}";
        }

        if (isset($params->tillTimestamp) == true) {
            $query .= " AND report.fecha <= {$params->tillTimestamp}";
        }

        if (isset($params->order) == false) {
            $query .= " ORDER BY report.fecha DESC";
        } else {
            $query .= " ORDER BY report.fecha {$params->order}";
        }

        if (isset($params->limit) == true) {
            $query .= " LIMIT {$params->pagination}, {$params->limit}";
        }

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getSimpleReportHistorical($deviceImei, $params)
    {
        $partition = $this->getPartitionReportByImei($deviceImei);

        $query = "SELECT 
        report.fecha as 'timestamp', 
        reportType.nombre as reportTypeString,
        report.lat, report.lng, report.direccion as address, report.velocidad as speed
        
        from t_reportes PARTITION(${partition}) as report
        
        INNER JOIN cat_tiporeporte as reportType
        on reportType.tipoReporte = report.idTipoReporte

        INNER JOIN t_dispositivos as device
        on device.imei = report.imei
        
        WHERE report.imei = '${deviceImei}' ";

        if (isset($params->fromTimestamp) == true) {
            $query .= " AND report.fecha >= {$params->fromTimestamp}";
        }

        if (isset($params->tillTimestamp) == true) {
            $query .= " AND report.fecha <= {$params->tillTimestamp}";
        }

        if (isset($params->order) == false) {
            $query .= " ORDER BY report.fecha DESC";
        } else {
            $query .= " ORDER BY report.fecha {$params->order}";
        }

        if (isset($params->limit) == true) {
            $query .= " LIMIT {$params->pagination}, {$params->limit}";
        }

        $resultSet = $this->db->query($query)->result();
        // return $query;
        return $resultSet;
    }


    public function getGeofenceReport($deviceImei, $params)
    {
        $query = "SELECT notif.id id, notif.fecha as 'timestamp',
        behavior.id behaviorID, behavior.nombre as behaviorString,
        geofenceType.id as 'geofenceType', geofenceType.nombre as geofenceTypeString,
        geofence.id geofenceID, geofence.nombre as geofenceName,
        report.id as reportID, report.lat, report.lng, report.direccion as address,
        device.id as deviceID, device.imei as deviceImei, device.alias as deviceAlias
        
        
        FROM t_notificaciones_geocercas as notif
        
        INNER JOIN cat_geocerca_comportamiento as behavior
        on behavior.id = notif.idEstadoGeocerca
        
        INNER JOIN t_geocercas as geofence
        on geofence.id = notif.idGeocerca

        INNER JOIN cat_geocerca_tipo as geofenceType
        on geofenceType.id = geofence.idTipoGeocerca
        
        LEFT JOIN t_reportes as report
        on report.id = notif.idReporte
        
        INNER JOIN t_dispositivos as device
        on device.id = notif.idDispositivo ";

        if (isset($deviceImei) == true) {
            $query .= "WHERE device.imei = ${deviceImei}";
        } else {
            $query .= " WHERE geofence.idUsuario = {$params->userID}";
        }

        if (isset($params->fromTimestamp) == true) {
            $query .= " AND notif.fecha >= {$params->fromTimestamp}";
        }

        if (isset($params->tillTimestamp) == true) {
            $query .= " AND notif.fecha <= {$params->tillTimestamp}";
        }

        if (isset($params->geofenceID) == true) {
            $query .= " AND notif.idGeocerca = {$params->geofenceID}";
        }

        if (isset($params->behavior) == true) {
            $query .= " AND notif.idEstadoGeocerca = {$params->behavior}";
        }

        if (isset($params->order) == false) {
            $query .= " ORDER BY notif.fecha DESC";
        } else {
            $query .= " ORDER BY notif.fecha {$params->order}";
        }

        if (isset($params->limit) == true) {
            $query .= " LIMIT {$params->pagination}, {$params->limit}";
        }

        $resultSet = $this->db->query($query)->result();
        // return $query;
        return $resultSet;
    }

    public function getDistanceReport($params)
    {
        $filters = $this->getBasicReportFilters($params);

        $query = "SELECT device.alias, device.imei, 
        reportType.tipoReporte as reportTypeID, reportType.nombre as reportType, 
        report.lat, report.lng, report.direccion as address, report.fecha as timestamp, round(report.velocidad,2) as speed
        FROM t_reportes as report
        INNER JOIN t_dispositivos as device
        on device.imei = report.imei
        
        INNER JOIN cat_tiporeporte as reportType
        on reportType.tipoReporte = report.idTipoReporte
        
        WHERE ";
        $query .= implode(" AND ", $filters->conditions);

        $query .= " ORDER BY report.fecha ASC ";

        if (property_exists($params, "limit") && !empty($params->limit))
            $query .= "LIMIT {$params->pagination}, {$params->limit}";


        $result = $this->db->query($query, $filters->values)->result();
        return $result;
    }
    private function getBasicReportFilters($data)
    {
        $parameters = new \StdClass();
        $parameters->conditions = [];
        $parameters->values = [];

        $parameters->conditions[] = "device.imei = ?";
        $parameters->values[] = "{$data->imei}";

        if (property_exists($data, "fromTimestamp") && !empty($data->fromTimestamp)) {
            $parameters->conditions[] = "report.fecha >= ?";
            $parameters->values[] = $data->fromTimestamp;
        }

        if (property_exists($data, "toTimestamp") && !empty($data->toTimestamp)) {
            $parameters->conditions[] = "report.fecha <= ?";
            $parameters->values[] = $data->toTimestamp;
        }

        return $parameters;
    }

    public function getIgnitionReport($params)
    {
        $filters = $this->getBasicReportFilters($params);

        $query = "SELECT 
        device.imei, device.alias,
        reportType.tipoReporte as reportTypeID, reportType.nombre reportType,
        report.lat, report.lng, report.direccion as address,
        sensor.ignicion as ignitionState,
        report.fecha as timestamp
        from t_reportes as report
        INNER JOIN t_reportes_sensores as sensor
        on sensor.idReporte = report.id
        INNER JOIN t_dispositivos as device
        on report.imei = device.imei
        INNER JOIN cat_tiporeporte as reportType
        on reportType.tipoReporte = report.idTipoReporte
        WHERE ";

        $query .= implode(" AND ", $filters->conditions);
        $query .= " ORDER BY report.fecha ASC ";

        if (property_exists($params, "limit") && !empty($params->limit))
            $query .= "LIMIT {$params->pagination}, {$params->limit}";


        $result = $this->db->query($query, $filters->values)->result();
        return $result;
    }

    public function getRalentiReport($params)
    {
        $filters = $this->getBasicReportFilters($params);

        $query = "SELECT 
        device.imei, device.alias,
        reportType.tipoReporte as reportTypeID, reportType.nombre reportType,
        report.lat, report.lng, report.direccion as address, report.velocidad as speed, sensor.ignicion as ignition, 
        report.fecha as timestamp
        from t_reportes as report
        INNER JOIN t_reportes_sensores as sensor
        on sensor.idReporte = report.id
        INNER JOIN t_dispositivos as device
        on report.imei = device.imei
        INNER JOIN cat_tiporeporte as reportType
        on reportType.tipoReporte = report.idTipoReporte
        WHERE ";

        $query .= implode(" AND ", $filters->conditions);
        $query .= " ORDER BY report.fecha ASC ";

        if (property_exists($params, "limit") && !empty($params->limit))
            $query .= "LIMIT {$params->pagination}, {$params->limit}";

        $result = $this->db->query($query, $filters->values)->result();
        return $result;
    }


    public function getUserLoginReport($params)
    {
        $filters = $this->getUserLoginReportFilters($params);

        $query = "SELECT
        UNIX_TIMESTAMP(login.fechaIngreso) as 'timestamp' 
        FROM t_usuarios_bitacora_acceso as login
        where " . implode(" AND ", $filters->conditions) . " 
        ORDER BY login.fechaIngreso ASC";

        $result = $this->db->query($query, $filters->values)->result();
        return $result;
    }
    public function getUserLoginReportFilters($data)
    {
        $parameters = new \StdClass();
        $parameters->conditions = [];
        $parameters->values = [];

        $parameters->conditions[] = "login.idUsuario = ?";
        $parameters->values[] = "{$data->userID}";

        if (property_exists($data, "fromTimestamp") && !empty($data->fromTimestamp)) {
            $parameters->conditions[] = "login.fechaIngreso >= FROM_UNIXTIME(?)";
            $parameters->values[] = $data->fromTimestamp;
        }

        if (property_exists($data, "toTimestamp") && !empty($data->toTimestamp)) {
            $parameters->conditions[] = "login.fechaIngreso <= FROM_UNIXTIME(?)";
            $parameters->values[] = $data->toTimestamp;
        }

        return $parameters;
    }

    public function getStoppedReport($params)
    {
        $filters = $this->getBasicReportFilters($params);

        $filters->conditions[] = "report.velocidad <= ?";
        if (property_exists($params, "maxSpeed") && !empty($params->maxSpeed))
            $filters->values[] = $params->maxSpeed;
        else
            $filters->values[] = 1; //Default value


        $query = "SELECT
        ROUND(report.lat,4) as lat, ROUND(report.lng,4) as lng, report.direccion as address, report.velocidad as speed, report.fecha as timestamp
        FROM t_reportes as report
        INNER JOIN t_dispositivos as device
        on report.imei = device.imei
        where " . implode(" AND ", $filters->conditions) . " 
        ORDER BY report.fecha ASC";

        $result = $this->db->query($query, $filters->values)->result();
        return $result;
    }

    public function getWeekSpeedReport($params)
    {
        $query = "SELECT
        device.id, device.imei, device.alias,
        WEEK(FROM_UNIXTIME(report.fecha),3) as week,
        MIN(report.fecha) as fromTimestamp,
        MAX(report.fecha) as toTimestamp,
        ROUND( MAX(report.velocidad),2) as maxSpeed,
        ROUND(AVG(report.velocidad), 2) as speedAverage,
        SUM(CASE 
                    WHEN report.velocidad >= {$params->maxSpeed} 
                    THEN 1
                    ELSE 0
                END) as infractions,
        count(*) as totalReports
               
        FROM t_reportes as report
        INNER JOIN t_dispositivos as device
        on device.imei = report.imei
        
        WHERE 
        report.fecha >= {$params->fromTimestamp}
        and report.fecha <= {$params->toTimestamp}";

        switch ($params->userType) {
            case 1:
                $query .= " AND device.id IN (SELECT device.id from t_dispositivos as device
                where device.idCliente = {$params->clientID}) ";
                break;

            case 2:
                $query .= " AND device.id IN (SELECT device.id from t_dispositivos as device
                INNER JOIN t_filtro_dispositivos as deviceFilter
                on deviceFilter.idDispositivo = device.id
                where deviceFilter.idUsuario = {$params->userID}) ";
                break;

            case 3: //Admin
                break;
        }

        $query .= "GROUP BY 
            device.id,
            WEEK(FROM_UNIXTIME(report.fecha),3)
        ORDER BY report.fecha ASC";

        $result = $this->db->query($query)->result();
        return $result;
    }

    public function getMonthSpeedReport($params)
    {
        $query = "SELECT
        device.id, device.imei, device.alias,
        MONTH(FROM_UNIXTIME(report.fecha)) as month,
        MIN(report.fecha) as fromTimestamp,
        MAX(report.fecha) as toTimestamp,
        ROUND( MAX(report.velocidad),2) as maxSpeed,
        ROUND(AVG(report.velocidad), 2) as speedAverage,
        SUM(CASE 
                    WHEN report.velocidad >= {$params->maxSpeed} 
                    THEN 1
                    ELSE 0
                END) as infractions,
        count(*) as totalReports
               
        FROM t_reportes as report
        INNER JOIN t_dispositivos as device
        on device.imei = report.imei
        
        WHERE 
        report.fecha >= {$params->fromTimestamp}
        and report.fecha <= {$params->toTimestamp}";

        switch ($params->userType) {
            case 1:
                $query .= " AND device.id IN (SELECT device.id from t_dispositivos as device
                where device.idCliente = {$params->clientID}) ";
                break;

            case 2:
                $query .= " AND device.id IN (SELECT device.id from t_dispositivos as device
                INNER JOIN t_filtro_dispositivos as deviceFilter
                on deviceFilter.idDispositivo = device.id
                where deviceFilter.idUsuario = {$params->userID}) ";
                break;

            case 3: //Admin
                break;
        }

        $query .= "GROUP BY 
            device.id,
            YEAR (FROM_UNIXTIME(report.fecha)),
            MONTH (FROM_UNIXTIME(report.fecha))
        ORDER BY report.fecha ASC";

        $result = $this->db->query($query)->result();
        return $result;
    }

    public function getBatteryReport($params)
    {
        $parameters = new \StdClass();
        $parameters->conditions = [];
        $parameters->values = [];

        $parameters->conditions[] = "report.imei = ?";
        $parameters->values[] = "{$params->imei}";

        if (property_exists($params, "fromTimestamp") && !empty($params->fromTimestamp)) {
            $parameters->conditions[] = "report.fecha >= ?";
            $parameters->values[] = $params->fromTimestamp;
        }

        if (property_exists($params, "toTimestamp") && !empty($params->toTimestamp)) {
            $parameters->conditions[] = "report.fecha <= ?";
            $parameters->values[] = $params->toTimestamp;
        }


        $query = "SELECT
        report.fecha as timestamp,
        YEAR(FROM_UNIXTIME(report.fecha)) as year,
        MONTH(FROM_UNIXTIME(report.fecha)) as month,
        WEEK(FROM_UNIXTIME(report.fecha),3) as week,
        YEARWEEK(FROM_UNIXTIME(report.fecha),3) as weekKey,
        DATE_FORMAT(FROM_UNIXTIME(report.fecha),'%m-%Y') as monthKey,
        sensor.bateria as hasBattery, 
        sensor.voltajeBateria as batteryVolt,
        sensor.corrienteExterna as hasPowerSupply, 
        sensor.voltajeCorrienteExterna powerSupplyVolt
        FROM t_reportes as report
        INNER JOIN t_reportes_sensores as sensor
        on sensor.idReporte = report.id
        
        WHERE " . implode("AND ", $parameters->conditions) . "
        ORDER BY report.fecha ASC";

        $result = $this->db->query($query, $parameters->values)->result();
        return $result;
    }


    public function getNoReportReport($params)
    {
        $parameters = new \StdClass();
        $parameters->conditions = [];
        $parameters->values = [];

        $parameters->conditions[] = "report.imei = ?";
        $parameters->values[] = "{$params->imei}";

        if (property_exists($params, "fromTimestamp") && !empty($params->fromTimestamp)) {
            $parameters->conditions[] = "report.fecha >= ?";
            $parameters->values[] = $params->fromTimestamp;
        }

        if (property_exists($params, "toTimestamp") && !empty($params->toTimestamp)) {
            $parameters->conditions[] = "report.fecha <= ?";
            $parameters->values[] = $params->toTimestamp;
        }


        $query = "SELECT
        report.fecha as timestamp,
        YEAR(FROM_UNIXTIME(report.fecha)) as year,
        MONTH(FROM_UNIXTIME(report.fecha)) as month,
        WEEK(FROM_UNIXTIME(report.fecha),3) as week,
        YEARWEEK(FROM_UNIXTIME(report.fecha),3) as weekKey,
        DATE_FORMAT(FROM_UNIXTIME(report.fecha),'%m-%Y') as monthKey
        FROM t_reportes as report
    
        WHERE " . implode("AND ", $parameters->conditions) . "
        ORDER BY report.fecha ASC";

        $result = $this->db->query($query, $parameters->values)->result();
        return $result;
    }

    public function getAlerts($params)
    {
        $query = "SELECT
        report.id as reportID,
        CASE 
            WHEN geofenceNotification.idEstadoGeocerca = 1 THEN 3017
            WHEN geofenceNotification.idEstadoGeocerca = 2 THEN 3018
        END as reportTypeID,
        CASE
            WHEN geofenceNotification.idEstadoGeocerca = 1 THEN 'Entrando a geocerca'
            WHEN geofenceNotification.idEstadoGeocerca = 2 THEN 'Saliendo de geocerca'
        END as reportType,
        device.imei,
        device.alias,
        report.lat,
        report.lng,
        '' AS adress,
        report.fecha as timestamp,
        geofence.id as geofenceID,
        geofence.nombre as geofenceName,
        device.idCliente
        FROM t_notificaciones_geocercas as geofenceNotification
        INNER JOIN t_geocercas as geofence
        on geofence.id = geofenceNotification.idGeocerca
        INNER JOIN t_dispositivos as device
        on device.id = geofenceNotification.idDispositivo
        INNER JOIN t_reportes as report
        on report.id = geofenceNotification.idReporte
        WHERE geofence.idUsuario = @userID
        AND geofenceNotification.fecha >= @fromTimestamp
        AND geofenceNotification.fecha <= @toTimestamp
        
        UNION
        
        (Select 
        report.id as reportID,
        reportType.tipoReporte as reportTypeID,
        reportType.nombre as reportType,
        device.imei,
        device.alias,
        report.lat,
        report.lng,
        report.direccion as adress,
        report.fecha as timestamp,
        null as geofenceID,
        null as geofenceName,
        device.idCliente
        FROM t_dispositivos as device
        INNER JOIN t_reportes as report
        on report.imei = device.imei
        INNER JOIN cat_tiporeporte as reportType
        on reportType.tipoReporte = report.idTipoReporte

        INNER_JOIN_DEVICE_FILTER 

        WHERE 
        WHERE_USER_OR_ACCOUNT
        AND report.fecha >= @fromTimestamp
        AND report.fecha <= @toTimestamp
        AND report.idTipoReporte >= 2000)
        ORDER BY timestamp DESC";

        if ($params->userType == 1) {
            $sentence = "";
            $query = str_replace("INNER_JOIN_DEVICE_FILTER", $sentence, $query);

            $sentence = "device.idCliente = @clientID ";
            $query = str_replace("WHERE_USER_OR_ACCOUNT", $sentence, $query);
        } else {
            $sentence = "INNER JOIN t_filtro_dispositivos as deviceFilter
            on deviceFilter.idDispositivo = device.id ";
            $query = str_replace("INNER_JOIN_DEVICE_FILTER", $sentence, $query);

            $sentence = "deviceFilter.idUsuario = @userID ";
            $query = str_replace("WHERE_USER_OR_ACCOUNT", $sentence, $query);
        }

        $query = str_replace("@userID", $params->userID, $query);
        $query = str_replace("@clientID", $params->clientID, $query);
        $query = str_replace("@fromTimestamp", $params->fromTimestamp, $query);
        $query = str_replace("@toTimestamp", $params->toTimestamp, $query);

        $result = $this->db->query($query)->result();
        return $result;
    }
}
