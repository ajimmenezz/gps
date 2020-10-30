<?php

namespace Models;

class DataBaseGeofence extends DataBase {
    public function createGeofence($userID, $geofence){
        //REGISTRAR GEOCERCA
        $query = "INSERT into t_geocercas
        (idUsuario, idTipoGeocerca, idComportamientoGeocerca, idTipoFigura, nombre, fechaCreacion, estatus)
        VALUES (${userID}, {$geofence->geofenceType}, {$geofence->behavior},
        {$geofence->figureType}, '{$geofence->name}', CURRENT_TIMESTAMP, 1)";

        $this->db->trans_start();
        $this->db->query($query);

  
        $geofenceID = $this->db->insert_id();

        $queryGeofenceData = "";
        switch($geofence->figureType){
            case 1: //Circular
                $queryGeofenceData = "INSERT into t_geocerca_circular
                (idGeocerca, radio, latitud, longitud)
                values(${geofenceID}, {$geofence->radio}, {$geofence->coords[0]->lat}, {$geofence->coords[0]->lng})
                ";
                break;

            case 2: //Polygon
                $queryValues = '';
                $size = sizeof($geofence->coords,0);
                
                for($i=0; $i<$size; $i++){
                    $queryValues = $queryValues."(${geofenceID},  {$geofence->coords[$i]->lat}, {$geofence->coords[$i]->lng})";
                    
                    if($i+1 < $size){
                        $queryValues = $queryValues.", ";                   
                    }
                }

                $queryGeofenceData = "INSERT into t_geocerca_poligonal
                (idGeocerca, latitud, longitud)
                values
                ${queryValues}";
                break;
        }
        $this->db->query($queryGeofenceData);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error creating geofence');
        }
        else{
            return $geofenceID;
        }
    }

    private function getFigureTypeID($geofenceID){
        $query = "SELECT idTipoFigura From t_geocercas where id = ${geofenceID}";
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->idTipoFigura;
    }

    public function getGeofenceType($geofenceID){
        $query = "SELECT idTipoGeocerca From t_geocercas where id = ${geofenceID}";
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->idTipoGeocerca;
    }

    public function updateGeofence($geofenceID, $geofence){
        //ACTUALIZAR LA GEOCERCA 
        $query = "UPDATE t_geocercas
        SET idComportamientoGeocerca = {$geofence->behavior}, nombre = '{$geofence->name}', fechaUltimaModificacion = CURRENT_TIMESTAMP
        WHERE id = ${geofenceID}";

        $this->db->trans_start();
        $this->db->query($query);

        //GetGeofenceType
        $figureType = $this->getFigureTypeID($geofenceID);

        $queryGeofenceData = "";
        switch($figureType){
            case 1: //Circular
                //Solo actualizar datos
                $queryGeofenceData = "UPDATE t_geocerca_circular
                SET radio = {$geofence->radio}, latitud = {$geofence->coords[0]->lat}, longitud = {$geofence->coords[0]->lng}
                WHERE idGeocerca = ${geofenceID}";
                break;

            case 2: //Polygon
                //Borrar datos y volverlos a crear
                $queryDeletePrevCoords = "DELETE FROM t_geocerca_poligonal
                where idGeocerca = {$geofenceID}";
                $this->db->query($queryDeletePrevCoords);

                
                $queryValues = '';
                $size = sizeof($geofence->coords,0);
                
                for($i=0; $i<$size; $i++){
                    $queryValues = $queryValues."(${geofenceID},  {$geofence->coords[$i]->lat}, {$geofence->coords[$i]->lng})";
                    
                    if($i+1 < $size){
                        $queryValues = $queryValues.", ";                   
                    }
                }

                $queryGeofenceData = "INSERT into t_geocerca_poligonal
                (idGeocerca, latitud, longitud)
                values
                ${queryValues}";
                break;
        }
        $this->db->query($queryGeofenceData);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error creating geofence');
        }
    }

    public function setGeofenceStatus($geofenceID, $status){
        $query = "UPDATE t_geocercas
        SET estatus = {$status}, fechaUltimaModificacion = CURRENT_TIMESTAMP
        WHERE id = ${geofenceID}";

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error delete geofence');
        }
    }

    public function geofenceExists($geofenceID){
        $query = "SELECT EXISTS (SELECT id from t_geocercas where id = ${geofenceID}) as 'exists'";
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }

    public function getOwnerID($geofenceID){
        $query = "SELECT idUsuario from t_geocercas where id = ${geofenceID}";
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->idUsuario;
    }

    public function getGeofenceList($userID, $geofenceType, $status = 1){

        $filterGeofenceType = "";
        if( !empty($geofenceType) )
        {
            $filterGeofenceType = "and idTipoGeocerca = ${geofenceType}";
        }

        $query = "SELECT id, idTipoGeocerca as geofenceType,  idComportamientoGeocerca as 'behavior', 
        idTipoFigura as figureType, nombre as 'name' 
        from t_geocercas 
        WHERE idUsuario = ${userID} ${filterGeofenceType} and estatus = ${status}";
        $resultSet = $this->db->query($query)->result();

        return $resultSet;
    }

    public function getGeofence($geofenceID){
        $query = "SELECT id, idUsuario as userID,   idTipoGeocerca as geofenceType,
        idComportamientoGeocerca as 'behavior', idTipoFigura as figureType,
        nombre as 'name', UNIX_TIMESTAMP(fechaCreacion) as timestampCreation
        from t_geocercas
        WHERE id = ${geofenceID}";

        $resultSet = $this->db->query($query)->result();
        $geofenceData = $resultSet[0];
        $geofenceData->coords = [];

        switch($geofenceData->figureType){
            case 1:
                $query = "SELECT radio, latitud as lat, longitud as lng from t_geocerca_circular
                WHERE idGeocerca = ${geofenceID}";

                $resultSet = $this->db->query($query)->result();
                $geofenceData->radio = $resultSet[0]->radio;

                $coords = new \stdClass();
                $coords->lat = $resultSet[0]->lat;
                $coords->lng = $resultSet[0]->lng;

                $geofenceData->coords = array($coords);
                break;

            case 2:
                $query = "SELECT latitud as lat, longitud as lng from t_geocerca_poligonal
                WHERE idGeocerca = ${geofenceID}";

                $resultSet = $this->db->query($query)->result();

                foreach($resultSet as $row){
                    $coords = new \stdClass();
                    $coords->lat = $row->lat;
                    $coords->lng = $row->lng;
                    array_push($geofenceData->coords, $coords);
                }
                break;
        }

        return $geofenceData;

    }

    public function bindDeviceToGeofence($geofenceID, $deviceID){
        $query = "SELECT EXISTS ( SELECT idGeocerca from t_geocerca_relaciondispositivos
        WHERE idGeocerca = ${geofenceID} AND idDispositivo = ${deviceID}) as 'exists'";

        $resultSet = $this->db->query($query)->result();
        $exists = $resultSet[0]->exists;

        if($exists >= 1){
            $query = "UPDATE t_geocerca_relaciondispositivos
            set estatus = 1, estatusGeocerca = -1
            WHERE idGeocerca = ${geofenceID} and idDispositivo = ${deviceID}";
        }
        else{
            $query = "INSERT INTO t_geocerca_relaciondispositivos
            (idGeocerca, idDispositivo, estatus, estatusGeocerca)
            VALUES
            (${geofenceID}, ${deviceID}, 1,-1)";
        }



        $this->db->trans_start();
        $this->db->query($query);


        $query = "UPDATE t_geocercas
        SET fechaUltimaModificacion = CURRENT_TIMESTAMP()
        WHERE id = ${geofenceID}";

        $this->db->query($query);

        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error binding device to geofence');
        }
    }

    public function unbindDeviceFromGeofence($geofenceID, $deviceID){
        $query = "UPDATE t_geocerca_relaciondispositivos 
        SET estatus = 0
        where idGeocerca = ${geofenceID} and idDispositivo = ${deviceID}";

        $this->db->trans_start();
        $this->db->query($query);

        $query = "UPDATE t_geocercas
        SET fechaUltimaModificacion = CURRENT_TIMESTAMP()
        WHERE id = ${geofenceID}";
        
        $this->db->query($query);

        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error unbinding device to geofence');
        }
    }

    public function getGeofenceDevices($geofenceID, $status = 1){
        $query = "SELECT geofenceFilter.idGeocerca as geofenceID, device.id as deviceID, 
        device.imei as deviceImei, device.alias as deviceAlias
        FROM t_geocerca_relaciondispositivos as geofenceFilter
        INNER JOIN t_dispositivos as device
        on device.id = geofenceFilter.idDispositivo
        WHERE geofenceFilter.idGeocerca = ${geofenceID} and geofenceFilter.estatus = ${status}";

        $resultSet = $this->db->query($query)->result();
        return  $resultSet;
    }

    public function updateGeofenceBehavior($geofenceID, $behavior){
        $query = "UPDATE t_geocercas
        SET idComportamientoGeocerca = ${behavior}
        WHERE id = ${geofenceID}";
    

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error binding device to geofence');
        }
    }


    public function insertGeofenceEmailSubscriber($geofenceID, $email){
        $query = "INSERT INTO t_geocerca_correo
        (idGeocerca, correo, estatus)
        VALUES
        (${geofenceID},'${email}', 1)";

        $this->db->trans_start();
        $this->db->query($query);

        $subscriberID = $this->db->insert_id();

        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error adding geofence email susbscriber');
        }
        else{
            return $subscriberID;
        }
        
    }
    public function deleteGeofenceEmailSubscriber($subscriberID){
        $query = "DELETE FROM t_geocerca_correo
        WHERE id = ${subscriberID}";

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error removing geofence email susbscriber');
        }
    }
    public function getGeofenceEmailSubscribers($geofenceID, $estatus = 1){
        $query= "SELECT id, correo FROM t_geocerca_correo
        WHERE idGeocerca = ${geofenceID} AND estatus = ${estatus}";

        $resultSet = $this->db->query($query)->result();
        return  $resultSet;
    }
   

    public function deleteGeofence($geofenceID){
        $querySetGeofenceStatus = "UPDATE t_geocercas
        SET estatus = 0, fechaUltimaModificacion = CURRENT_TIMESTAMP
        WHERE id = ${geofenceID}";


        $queryUnbindDevicesFromGeofence = "UPDATE t_geocerca_relaciondispositivos 
        SET estatus = 0
        where idGeocerca = ${geofenceID}";

        $queryDeleteEmailSubscribers = "DELETE FROM t_geocerca_correo
        WHERE idGeocerca = ${geofenceID}";
    
        $this->db->trans_start();
        $this->db->query($querySetGeofenceStatus);
        $this->db->query($queryUnbindDevicesFromGeofence);
        $this->db->query($queryDeleteEmailSubscribers);
        $this->db->trans_complete();
    
        if($this->db->trans_status() == false){
            throw new Exception('error deleting geofence email susbscriber');
        }
    }
}
