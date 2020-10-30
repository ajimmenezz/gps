<?php

namespace Models;

use Models\DataBaseUser;
use Libraries\Utils;

class DataBaseDevice extends DataBase
{

    private $dataBaseUser;

    public function __construct()
    {
        parent::__construct();
        $this->dataBaseUser = new DataBaseUser();
    }

    private function getPartitionByUser($userID, $deviceStatus = 1)
    {
        $clientID = $this->dataBaseUser->getClientID($userID);
        $clientType = $this->dataBaseUser->getClientType($clientID);
        $userType = $this->dataBaseUser->getUserType($userID);

        switch ($clientType) {
            case 1: //Cliente
                if ($userType == 1) { //Cliente
                    $query = "
                    select 
                    td.id,
                    concat('p',td.id) as partit
                    from t_usuarios tu
                    inner join t_dispositivos td on tu.idCliente = td.idCliente
                    where tu.id = '${userID}' and td.estatus = ${deviceStatus}
                    
                    union 

                    select 
                    td.id,
                    concat('p',td.id) as partit
                    from t_flotilla_relacion_dispositivo tfrd
                    inner join t_dispositivos td on td.id = tfrd.idDispositivo
                    where idFlotilla in (select id from t_flotillas where idUsuario = '${userID}')
                    and td.estatus = ${deviceStatus}";
                } else if ($userType == 2) { //Asociado
                    $query = "select 
                    td.id,
                    concat('p',td.id) as partit
                    from t_dispositivos td 
                    inner join t_filtro_dispositivos tfd on td.id = tfd.idDispositivo
                    where tfd.idUsuario = '${userID}' and td.estatus = ${deviceStatus}

                    union 

                    select
                    td.id,
                    concat('p',td.id) as partit
                    from t_dispositivos td
                    inner join t_filtro_dispositivos tfd on td.id = tfd.idDispositivo
                    inner join t_flotilla_relacion_dispositivo tfrd on td.id = tfrd.idDispositivo
                    inner join t_flotillas tf on tfrd.idFlotilla = tf.id
                    where tf.idUsuario = '${userID}' and td.estatus = ${deviceStatus}";                    
                }
                break;

            case 2: //Distribuidor
                $query = "select 
                    td.id,
                    concat('p',td.id) as partit
                    from t_dispositivos td 
                    inner join t_clientes tc on tc.id = td.idCliente
                    inner join t_usuarios tu on tu.idCliente = tc.idPropietario
                    where td.estatus = ${deviceStatus}
                    and tu.id = '${userID}'
                    
                    union

                    select 
                    td.id,
                    concat('p',td.id) as partit
                    from t_dispositivos td 
                    inner join t_flotilla_relacion_dispositivo tfrd on td.id = tfrd.idDispositivo
                    inner join t_flotillas tf on tfrd.idFlotilla = tf.id
                    where td.estatus = ${deviceStatus}
                    and tf.idUsuario = '${userID}'
                    ";
                break;
        }

        $query = "select group_concat(id) as ids, group_concat(partit) as partits
        from (" . $query . ") as tf";

        return $this->db->query($query)->result();
    }

    public function getUserDevicesInfo($userID, $deviceStatus = 1)
    {

        $partitions = $this->getPartitionByUser($userID, $deviceStatus)[0];

        $query = "
        select 
            devices.id,
            devices.idCliente clientID,
            marker.id markerType,
            marker.nombre markerName,
            devices.imei,
            devices.alias,
            devices.estatus STATUS,
            devices.fechaCreacion AS creationTimestamp,
            reports.lat,
            reports.lng,
            reports.direccion address,
            reports.fecha timestampReport,
            (select idFlotilla from t_flotilla_relacion_dispositivo where idDispositivo = devices.id) as fleetID,
            deviceConfig.reporteMovimiento AS deviceDrivingInterval,
            deviceConfig.reporteDetenido AS deviceParkingInterval,
            76 AS gsmStrength            
        from t_dispositivos devices
        LEFT JOIN cat_tipomarcador AS marker ON marker.id = devices.idTipoMarcador
        LEFT JOIN t_reportes PARTITION (" . $partitions->partits . ") AS reports ON reports.id in (select MAX(id) as id from t_reportes PARTITION(" . $partitions->partits . ") group by deviceId)
        LEFT JOIN t_dispositivos_configuracion AS deviceConfig ON deviceConfig.imei = devices.imei
        where devices.id in (" . $partitions->ids . ")
        group by devices.id;
        ";         

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();
        return $resultSet;
    }



    //getDevicesInfoByClient
    //getDevicesInfoByDistributor
    //getDevicesInfoByFilter

    public function getDeviceInfo($deviceID)
    {
        $query = "SELECT 
        devices.id as deviceID, devices.idCliente as clientID,
        devices.idTipoMarcador as markerType, devices.imei, devices.alias, devices.fechaCreacion as creationTimestamp, devices.idModelo as deviceModelID,
        deviceModel.modelo as deviceModel, deviceModel.idMarca as deviceBrandID, deviceBrand.marca as deviceBrand, devices.notas,
        
        sims.id as simID, sims.icc as simICC, sims.telefono as simNumber, carrier.id as carrierID, 
        carrier.nombre as carrierName,

        driver.id as driverID, driver.nombre as driver, driver.telefono as driverPhone,
        
        vehicles.id as vehicleID, vehicles.`año` as vehicleYear, vehicles.color as vehicleColor,
        vehicles.marca as vehicleBrand, vehicles.modelo as vehicleModel,
        vehicles.placas as carplate, vehicles.vin as vehicleVIN,
        vehicles.pais as country, vehicles.region as region, vehicles.seguro as insurance,
        vehicles.numeroSeguro as insuranceID, vehicles.notas as vehicleNotes,
          
        reports.id as reportsID, reports.lat, reports.lng, 
        reports.direccion as address, reports.posicionValida as positionValid, 
        reports.historico as isHistoric, reports.fecha as `timestamp`, reports.velocidad as speed,
        sensors.bateria as hasBattery, sensors.corrienteExterna as hasPowerSupply, sensors.ignicion as ignition,
        sensors.in1, sensors.in2, sensors.in3, sensors.in4, sensors.in5, sensors.in6,
        sensors.ou1, sensors.ou2, sensors.ou3, sensors.ou4, sensors.ou5, sensors.ou6, 
        sensors.porcentajeBateria as batteryLevel, sensors.voltajeBateria as batteryVoltage,
        sensors.voltajeCorrienteExterna as powerSupplyVoltage
        FROM t_dispositivos as devices
        
        LEFT JOIN cat_modelo_producto as deviceModel
        on deviceModel.id = devices.idModelo

        LEFT JOIN cat_marca_producto as deviceBrand
        on deviceBrand.id = deviceModel.idMarca
        
        LEFT JOIN t_sims as sims
        on sims.idDispositivo = devices.id

        LEFT JOIN cat_compañiastelefonicas as carrier
        on carrier.id = sims.`idCompañiaTelefonica`
        
        LEFT JOIN t_vehiculos as vehicles
        on vehicles.idDispositivo = devices.id

        LEFT JOIN t_conductores as driver
        on driver.id = vehicles.idConductor
        
        LEFT JOIN t_reportes_ultimo as lastreport
        on lastreport.imei = devices.imei

        LEFT JOIN t_reportes as reports
        on reports.id = lastReport.idReporte

        LEFT JOIN t_reportes_sensores as sensors
        on sensors.idReporte = reports.id 
        
        WHERE devices.id = ${deviceID}";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getDeviceLastPosition(string $deviceID)
    {
        $query = "SELECT disp.id AS 'idDisp',disp.idCliente,disp.notas AS 'notasDisp',disp.imei,disp.alias,disp.fechaCreacion AS 'fecCreacionDisp',
             disp.idCliente AS 'idCliente',cli.cuenta, disp.idModelo AS 'idModelo', dispMod.modelo AS 'modeloDisp',
             dispMod.idMarca AS 'idMarca',dispMarca.marca AS 'marcaDisp',disp.idTipoMarcador AS 'idmarcador',
             disMarcador.nombre AS 'marcadorDisp',sim.id AS 'idsim',sim.telefono,sim.icc,compT.nombre AS 'compañiaTel',
             sim.notas AS 'notasSims',veh.id AS 'idVehiculo', veh.marca AS 'marcaVeh', veh.modelo AS 'modeloVeh',
            veh.año AS 'añoVeh',veh.vin AS 'vinVeh',veh.color AS 'colorVeh',veh.placas AS 'placasVeh',veh.pais AS 'paisVeh',
            veh.region AS 'regionVeh',veh.seguro AS 'seguroVeh',veh.numeroSeguro AS 'numsegVeh',
            veh.notas AS 'notasVeh',
            driver.id as driverID, driver.nombre as conductorVeh, driver.telefono as telconductorVeh
             FROM t_dispositivos AS disp
            LEFT JOIN t_clientes AS cli ON cli.id=disp.idCliente
            INNER JOIN cat_modelo_producto AS dispMod ON disp.idModelo=dispMod.id
            INNER JOIN cat_marca_producto AS dispMarca ON dispMod.idMarca=dispMarca.id
            INNER JOIN cat_tipomarcador AS disMarcador ON disp.idTipoMarcador=disMarcador.id
            LEFT JOIN t_sims AS sim ON disp.id=sim.idDispositivo
            LEFT JOIN cat_compañiastelefonicas AS compT ON sim.idCompañiaTelefonica=compT.id
            LEFT JOIN t_vehiculos AS veh ON disp.id=veh.idDispositivo
            LEFT JOIN t_conductores as driver
            on driver.id = veh.idConductor
            WHERE  disp.id={$deviceID}";

        $resultSet = $this->db->query($query)->result();

        return $resultSet;
    }

    public function verifyClientDistributorDevice(string $userID)
    {
        $query = "SELECT disp.id, disp.idCliente, cli.idPropietario as idDistribuidor,
         cli.idPropietario, disp.imei
         FROM t_dispositivos AS disp 
         
         LEFT JOIN t_clientes AS cli 
         ON disp.idCliente=cli.id
         
         LEFT JOIN t_usuarios AS tu 
         ON cli.id = tu.IdCliente
         
         WHERE tu.id = ${userID}";

        $resultSet = $this->db->query($query)->result();

        return $resultSet;
    }

    //TODO:

    //getDevicesNearByClient
    //getDevicesNearByFilter
    //getDevicesNearByDistributor
    public function getDevicesNear($userID, $position, $maxDistance)
    {
        $utils = new Utils();

        //Obtener datos de latitud y longitud maximo y minino
        $maxDistance = $utils->metersToDecimalDegrees($maxDistance);
        $minLat = $position->lat - $maxDistance;
        $maxLat = $position->lat + $maxDistance;

        $minLng = $position->lng - $maxDistance / cos($minLat * pi() / 180);
        $maxLng = $position->lng + $maxDistance / cos($minLat * pi() / 180);


        //Obtener datos del usuario
        $clientID = $this->dataBaseUser->getClientID($userID);
        $clientType = $this->dataBaseUser->getClientType($clientID);
        $userType = $this->dataBaseUser->getUserType($userID);



        $query = "SELECT devices.id, devices.idCliente clientID, marker.id markerType,
        marker.nombre markerName, devices.imei, devices.alias,  
        reports.lat, reports.lng, reports.direccion address, reports.fecha timestampReport
        
        FROM t_dispositivos as devices
        
        LEFT JOIN t_reportes_ultimo as lastReport
        on lastReport.imei = devices.imei
        
        LEFT JOIN t_reportes as reports
        on reports.id = lastReport.idReporte
        
        LEFT JOIN cat_tipomarcador as marker
        on marker.id = devices.idTipoMarcador ";

        switch ($clientType) {
            case 1: //Cliente
                if ($userType == 1) { //Cliente
                    $query = $query . "INNER JOIN t_usuarios as users
                    on devices.idCliente = users.idCliente
                    where users.id = ${userID} and devices.estatus = 1";
                } else if ($userType == 2) { //Asociado
                    $query = $query . "INNER JOIN t_filtro_dispositivos as deviceFilter
                    on deviceFilter.idDispositivo = devices.id
                    where deviceFilter.idUsuario = ${userID} and devices.estatus = 1";
                }
                break;

            case 2: //Distribuidor
                $query = $query . "
                INNER JOIN t_clientes as client
                ON client.id = devices.idCliente

                WHERE devices.estatus = 1 AND
                client.idPropietario = (SELECT usuario.idCliente 
										FROM t_usuarios as usuario
                                        WHERE usuario.id = ${userID}) ";
                break;

            case 3: //Administrador
                //TODO: Determinar una accion para este tipo de cliente
                $query = $query . " where 1=1 ";
                break;
        }

        $query = $query . " AND ( 
            reports.lat BETWEEN ({$minLat} ) 
            AND ({$maxLat}) 
        )
        AND ( 
            reports.lng BETWEEN ({$minLng}) 
            AND ({$maxLng})
        )";

        $resultSet = $this->db->query($query)->result();

        return $resultSet;
    }


    public function getDeviceClientID($deviceID)
    {
        $query = "SELECT idCliente from t_dispositivos
       WHERE id = ${deviceID}";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();
        return $resultSet[0]->idCliente;
    }

    public function getDeviceDistributorID($deviceID)
    {
        $query = "SELECT client.idTipoCliente as clientType, client.id clientID,
        client.idPropietario distributorID,
        CASE WHEN client.idTipoCliente > 1 
        THEN client.id
        ELSE client.idPropietario
        END AS ownerID
        FROM t_clientes as client
        INNER JOIN t_dispositivos as device
        ON device.idCliente = client.id
        WHERE device.id =  ${deviceID}";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();

        return $resultSet[0]->ownerID;
    }

    public function isDeviceSubscriber($userID, $deviceID)
    {
        $query = "SELECT EXISTS(Select filter.idUsuario from  t_filtro_dispositivos as filter
        WHERE filter.idDispositivo = ${deviceID} and filter.idUsuario = ${userID}) as 'exists'";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();

        if ($resultSet[0]->exists >= 1)
            return true;
        else
            return false;
    }

    public function addUserSubcriberToDevice($userID, $devices)
    {
        $this->db->trans_start();
        foreach ($devices as $device) {
            $query = "INSERT INTO t_filtro_dispositivos (idDispositivo, idUsuario, fechaCreacion)
            select ${device}, ${userID}, UNIX_TIMESTAMP() WHERE NOT EXISTS
            ( SELECT idDispositivo, idUsuario 
            FROM t_filtro_dispositivos 
            WHERE idDispositivo = ${device} and idUsuario = ${userID} )";
            $this->db->query($query);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error on add user subscriber to devices');
        }
    }


    //getDeviceListByClient
    //getDeviceListByFilter
    //getDeviceLIstByDistributor
    public function getDeviceList($userID)
    {
        $clientID = $this->dataBaseUser->getClientID($userID);
        $clientType = $this->dataBaseUser->getClientType($clientID);
        $userType = $this->dataBaseUser->getUserType($userID);

        $query = "SELECT device.id, device.idCliente as clientID,
         device.imei, device.alias,
         sim.id as simID, sim.telefono as phone, carrier.id as carrierID, carrier.nombre as carrier,
         reportTime.reporteDetenido as onParkingMode, reportTime.reporteMovimiento as onDrivingMode, device.fechaCreacion as creationTimestamp
         FROM t_dispositivos as device 
         LEFT JOIN t_sims as sim
		 on sim.idDispositivo = device.id
        
         LEFT JOIN `cat_compañiastelefonicas` as carrier
         on carrier.id = sim.`idCompañiaTelefonica`
         
         LEFT JOIN t_dispositivos_configuracion as reportTime
		 on reportTime.imei = device.imei";

        switch ($clientType) {
            case 1: //cliente
                if ($userType == 1) {
                    $query = $query . " 
                    WHERE device.estatus = 1 AND
                    device.idCliente = (SELECT usuario.idCliente 
                                            FROM t_usuarios as usuario
                                            WHERE usuario.id = $userID)";
                    //cliente
                } else if ($userType == 2) {
                    //asociado
                    $query = $query . "
                    INNER JOIN t_filtro_dispositivos as deviceFilter
                    ON deviceFilter.idDispositivo = device.id

                    WHERE device.estatus = 1 AND deviceFilter.idUsuario = ${userID}";
                }
                break;

            case 2: //Distribuidor
                $query = $query . " 
                INNER JOIN t_clientes as client
                ON client.id = device.idCliente
                
                WHERE device.estatus = 1 AND
                client.idPropietario = (SELECT usuario.idCliente 
										FROM t_usuarios as usuario
										WHERE usuario.id = ${userID})";
                break;
        }

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();
        return $resultSet;
    }

    public function unsuscribeUserFromDevice($userID, $devices)
    {
        $this->db->trans_start();
        foreach ($devices as $device) {

            //Eliminar Relacion de dispositivo-geocercas y Actualizar Geocerca
            $query = "UPDATE t_geocerca_relaciondispositivos as geofenceFilter
                INNER JOIN t_geocercas as geofence
                on geofence.id = geofenceFilter.idGeocerca
                INNER JOIN t_usuarios as user
                on geofence.idUsuario = user.id
                SET geofence.fechaUltimaModificacion = CURRENT_TIMESTAMP(), geofenceFilter.estatus = 0
                WHERE user.id = ${userID} and geofenceFilter.idDispositivo = ${device}";
            $this->db->query($query);

            //Eliminar de relacion flotillas
            $query = "DELETE fleetList FROM t_flotilla_relacion_dispositivo as fleetList
                INNER JOIN t_flotillas as fleets
                on fleets.id = fleetList.idFlotilla
                WHERE fleets.idUsuario = {$userID}  AND fleetList.idDispositivo = ${device}";
            $this->db->query($query);

            //Eliminar de filtro de dispositivos
            $query = "DELETE FROM t_filtro_dispositivos
                WHERE idUsuario = {$userID} AND idDispositivo = ${device}";
            $this->db->query($query);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error on unsuscribe user from Device');
        }
    }

    public function updateDevice($deviceID, $params)
    {
        if (count($params->conditions) > 0) {
            $this->db->trans_start();

            $query = "UPDATE t_dispositivos";
            $query .= " SET " . implode(" ,", $params->conditions);
            $query .= " WHERE id = ${deviceID}";

            $this->db->query($query, $params->parameters);
            $this->db->trans_complete();

            if ($this->db->trans_status() == false) {
                throw new Exception('error updating device');
            }
        }
    }


    public function hasVehicle($deviceID)
    {
        $query = "SELECT EXISTS(Select id from t_vehiculos
        WHERE idDispositivo = ${deviceID} ) as 'exists'";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();

        if ($resultSet[0]->exists >= 1)
            return true;
        else
            return false;
    }


    public function getVehicleID($deviceID)
    {
        $query = "SELECT id from t_vehiculos
        WHERE idDispositivo = ${deviceID}";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();
        return $resultSet[0]->id;
    }

    public function getDriverID($deviceID)
    {
        $query = "SELECT idConductor as id from t_vehiculos
        WHERE idDispositivo = ${deviceID}";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();

        return $resultSet[0]->id;
    }

    public function getDeviceImei($deviceID)
    {
        $query = "SELECT imei from t_dispositivos
        WHERE id = ${deviceID}";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();

        return $resultSet[0]->imei;
    }

    public function getDevicesImei($devicesID)
    {
        $query = "SELECT imei from t_dispositivos
        WHERE id IN ?";

        $queryParams[] = $devicesID;
        $resultSet = $this->db->query($query, $queryParams);

        $devices = [];
        foreach ($resultSet->result() as $row) {
            $devices[] = $row->imei;
        }

        return $devices;
    }

    public function getAlias($deviceID)
    {
        $query = "SELECT alias from t_dispositivos
        WHERE id = ${deviceID}";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();

        return $resultSet[0]->alias;
    }

    public function imeiExists($imei)
    {
        $query = "SELECT EXISTS(
            SELECT imei 
            FROM t_dispositivos 
            WHERE imei	= '${imei}') as 'exists'";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }

    public function createDevice($data)
    {
        try {
            // $idCliente=!empty($data->clientID)?"{$data->clientID}":"{$data->distributorID}";
            $query = "INSERT INTO t_dispositivos
          (idModelo, idCliente, idTipoMarcador, imei, alias,fechaCreacion,notas)
          VALUES
          ({$data->modelID}, {$data->distributorID},  {$data->markerTypeID}, '{$data->imei}', '{$data->alias}', UNIX_TIMESTAMP(), '{$data->notes}')";


            $this->db->trans_start();
            $this->db->query($query);

            $deviceID =  $this->db->insert_id();

            $queryPartition = "ALTER TABLE t_reportes ADD PARTITION (PARTITION p{$deviceID} VALUES IN ({$deviceID}))";
            $this->db->query($queryPartition);



            $this->db->trans_complete();
            if ($this->db->trans_status() == false) {
                throw new Exception('error on create device');
            }

            return $deviceID;
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }

    public function getDeviceListByClient($clientID)
    {
        $query = "SELECT device.id, device.idCliente as clientID,
        device.imei, device.alias, device.fechaCreacion,
        sim.id as simID, sim.telefono as phone, carrier.id as carrierID, carrier.nombre	as carrier,
        reportTime.reporteDetenido as onParkingMode, reportTime.reporteMovimiento as onDrivingMode, device.fechaCreacion as creationTimestamp
        FROM t_dispositivos as device 
        
        LEFT JOIN t_sims as sim
		on sim.idDispositivo = device.id
        
        LEFT JOIN `cat_compañiastelefonicas` as carrier
		on carrier.id = sim.`idCompañiaTelefonica`

        LEFT JOIN t_dispositivos_configuracion as reportTime
		 on reportTime.imei = device.imei
        
        WHERE device.estatus = 1 AND device.idCliente = ${clientID}";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();
        return $resultSet;
    }

    public function deleteDevice($deviceID, $simID, $statuSims)
    {

        $queryFiltrosDevice = "DELETE FROM t_filtro_dispositivos
        WHERE idDispositivo = ${deviceID}";


        $queryRelacionFlotilla = "DELETE FROM t_flotilla_relacion_dispositivo
        WHERE idDispositivo = ${deviceID}";

        $queryRelacionGeocerca = "UPDATE t_geocerca_relaciondispositivos 
        SET estatus = 0
        where idDispositivo = ${deviceID}";

        $queryDevice = "UPDATE t_dispositivos
        SET estatus=-1
        WHERE id= ${deviceID}";

        if ($simID != null) { //tiene sims asignada
            if ($statuSims == 1) { //eliminar
                $queryDeleteSims = "UPDATE t_sims
                SET estatus = -1
                where id = ${simID}";

                $this->db->query($queryDeleteSims);
            }
            if ($statuSims == 2) { //almacen
                $queryAlmacenSims = "UPDATE t_sims
                SET idDispositivo = null
                where id = ${simID}";

                $this->db->query($queryAlmacenSims);
            }
        }

        $this->db->trans_start();
        $this->db->query($queryFiltrosDevice);
        $this->db->query($queryRelacionFlotilla);
        $this->db->query($queryRelacionGeocerca);
        $this->db->query($queryDevice);


        $this->db->trans_complete();




        if ($this->db->trans_status() == false) {
            throw new Exception('error deleting device');
        }
    }

    public function getSimsDevice($deviceID)
    {
        // $query = "SELECT EXISTS(
        //     SELECT idDispositivo 
        //     FROM t_sims
        //     WHERE idDispositivo	= ${deviceID}) as 'exists'";

        $query = "SELECT id,idDispositivo 
        FROM t_sims
        WHERE idDispositivo	=${deviceID}";

        $resultSet = $this->db->query($query);
        $resultSet = $resultSet->result();
        return $resultSet;
    }

    public function setOwner($clientID, $deviceID)
    {
        $this->db->trans_start();

        //Eliminar de relacion geocercas
        $query = "UPDATE t_geocerca_relaciondispositivos as geofenceFilter
        INNER JOIN t_geocercas as geofence
        on geofence.id = geofenceFilter.idGeocerca
        SET geofence.fechaUltimaModificacion = CURRENT_TIMESTAMP(), geofenceFilter.estatus = 0
        WHERE geofenceFilter.idDispositivo = ${deviceID}";
        $this->db->query($query);

        //Eliminar de relacion flotillas
        $query = "DELETE fleetList FROM t_flotilla_relacion_dispositivo as fleetList
        INNER JOIN t_flotillas as fleets
        on fleets.id = fleetList.idFlotilla
        WHERE fleetList.idDispositivo = ${deviceID}";
        $this->db->query($query);

        //Eliminar de filtro de dispositivos
        $query = "DELETE FROM t_filtro_dispositivos
        WHERE idDispositivo = ${deviceID}";
        $this->db->query($query);

        //Cambiar el owner del dispositivo
        $query = "UPDATE t_dispositivos
        set idCliente = ${clientID}
        where id = ${deviceID}";

        $this->db->query($query);


        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error actualizar el propietario de la sim');
        }

        return true;
    }

    private function removeFromUserFilter($deviceID)
    {
    }
    private function removeFromGeofences($deviceID)
    {
    }
    private function removeFromFleets($deviceID)
    {
    }


    public function deleteClientDevices($clientID)
    {

        //Eliminado virtual del dispositivo, remover de relacion geocercas
        $query = "UPDATE t_dispositivos as devices
        LEFT JOIN t_geocerca_relaciondispositivos as geofenceFilter
        ON devices.id = geofenceFilter.idDispositivo
        
        LEFT JOIN t_geocercas as geofence
        on geofenceFilter.idGeocerca = geofence.id

        SET
            devices.estatus = -1,
            geofenceFilter.estatus = 0,
            geofence.fechaUltimaModificacion = CURRENT_TIMESTAMP()
        WHERE devices.idCliente = ${clientID}";
        $this->db->query($query);


        //Eliminar de relaciones user-disp, flotilla-disp
        $query = "DELETE deviceFilter, fleetFilter
        FROM t_dispositivos as devices
        
        LEFT JOIN t_filtro_dispositivos as deviceFilter
        on devices.id = deviceFilter.idDispositivo
        
        LEFT JOIN t_flotilla_relacion_dispositivo as fleetFilter
        on devices.id = fleetFilter.idDispositivo
        
        WHERE devices.idCliente = ${clientID}";
        $this->db->query($query);


        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error deleting product');
        }
    }
}
