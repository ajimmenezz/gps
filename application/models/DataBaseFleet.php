<?php
namespace Models;
use Libraries\Utils;

class DataBaseFleet extends DataBase{
    public function getFleets($userID){
        $query = "SELECT fleet.id, fleet.nombre as 'name', COUNT(fleet.id) as totalDevices, 
        UNIX_TIMESTAMP(fleet.fechaCreacion) as creationTimestamp
        FROM t_flotillas as fleet
        LEFT JOIN t_flotilla_relacion_dispositivo as filterFleet
        on filterFleet.idFlotilla = fleet.id 
        INNER JOIN t_dispositivos AS device
        ON device.id=filterFleet.idDispositivo
        WHERE fleet.idUsuario = ${userID} AND device.estatus=1 
        GROUP BY fleet.id ";

        $resultSet = $this->db->query($query)->result();     
        return $resultSet;
    }

    public function createFleet($userID, $fleet){
        $this->db->trans_start();
        $query = "INSERT INTO t_flotillas
        (idUsuario, nombre)
        VALUES
        (${userID}, '{$fleet->name}')";
        $this->db->query($query);

        $fleetID =  $this->db->insert_id();

        foreach ($fleet->devices as $deviceID) {
            $query = "INSERT INTO t_flotilla_relacion_dispositivo
            (idFlotilla, idDispositivo)
            SELECT ${fleetID}, ${deviceID}
            WHERE NOT EXISTS (
                SELECT fleetFilter.idFlotilla, fleetFilter.idDispositivo
                FROM t_flotilla_relacion_dispositivo as fleetFilter
                INNER JOIN t_flotillas as fleets
                on fleets.id = fleetFilter.idFlotilla
                WHERE fleets.idUsuario = ${userID} and fleetFilter.idDispositivo = ${deviceID}
            )";
            $this->db->query($query);
        }
        $this->db->trans_complete();
        
        if($this->db->trans_status() == false){
            throw new Exception('error updating event password');
        }

        return $fleetID;
    }


    public function getFleet($fleetID, $userID = null){
        $fleet = new \StdClass();
        $fleet->id = null;
        $fleet->name = null;
        $fleet->devices = [];

          
        $query = "SELECT fleet.id, fleet.nombre as 'name', UNIX_TIMESTAMP(fleet.fechaCreacion) as creationTimestamp
        FROM t_flotillas as fleet
        WHERE id=${fleetID} ";
        $resultSet = $this->db->query($query)->result();  

        if( count($resultSet) > 0){
            $fleet->id = $resultSet[0]->id;
            $fleet->name = $resultSet[0]->name;
            $fleet->creationTimestamp = $resultSet[0]->creationTimestamp;
        }


        $query = "SELECT fleetFilter.idDispositivo as devices
        FROM t_flotilla_relacion_dispositivo as fleetFilter
        INNER JOIN t_flotillas as fleet
        on fleet.id = fleetFilter.idFlotilla
        WHERE fleet.id = ${fleetID}";
        $resultSet = $this->db->query($query)->result();  
            

        foreach ($resultSet as $row)
        {
            $fleet->devices[] = $row->devices; 
        }

        return $fleet;
    }

    public function isFleetOwner($userID, $fleetID){
        $query = "SELECT EXISTS (SELECT id FROM t_flotillas WHERE id = ${fleetID} and idUsuario = ${userID}) as 'exists'";
        $result = $this->db->query($query)->result(); 
        if($result[0]->exists == 1){
            return true;
        }
        else{
            return false;
        }
    }

    public function deleteFleet($fleetID){
        $this->db->trans_start();

        $query = "DELETE FROM t_flotilla_relacion_dispositivo
        WHERE idFlotilla = ${fleetID}";
        $this->db->query($query);

      
        $query = "DELETE FROM t_flotillas
        WHERE id = ${fleetID}";
        $this->db->query($query);

        $this->db->trans_complete();
        
        if($this->db->trans_status() == false){
            throw new Exception('error deleting fleet');
        }
    }

    public function updateFleet($fleetID, $fleet){
        $this->db->trans_start();

        if(property_exists($fleet, "name")){
            $query = "UPDATE t_flotillas
            SET nombre = '{$fleet->name}'
            WHERE id = ${fleetID}";
            $this->db->query($query);
        }

        if(property_exists($fleet, "devices")){
            //Eliminar asociaciones dispositivo-flotilla.ID
            $query = "DELETE FROM t_flotilla_relacion_dispositivo
            WHERE idFlotilla = '{$fleetID}' ";
            $this->db->query($query);

            //Obtener el owner id de la flotilla
            $query = "SELECT idUsuario as id  FROM t_flotillas
            WHERE id = '{$fleetID}' ";

            $result = $this->db->query($query)->result();
            $userID = $result[0]->id; 

            //Agregar si no existe en las flotillas del usuario
            foreach ($fleet->devices as $deviceID) {
                $query = "INSERT INTO t_flotilla_relacion_dispositivo
                (idFlotilla, idDispositivo)
                SELECT ${fleetID}, ${deviceID}
                WHERE NOT EXISTS (
                    SELECT fleetFilter.idFlotilla, fleetFilter.idDispositivo
                    FROM t_flotilla_relacion_dispositivo as fleetFilter
                    INNER JOIN t_flotillas as fleets
                    on fleets.id = fleetFilter.idFlotilla
                    WHERE fleets.idUsuario = ${userID} and fleetFilter.idDispositivo = ${deviceID}
                )";
                $this->db->query($query);
            }

        }

       
        $this->db->trans_complete();
        
        if($this->db->trans_status() == false){
            throw new Exception('error deleting fleet');
        }
    }


    public function updateDeviceFleet($userID, $deviceID, $fleetID){
        $this->db->trans_start();
    
        $query = "DELETE fleetFilter FROM t_flotilla_relacion_dispositivo as fleetFilter
        INNER JOIN t_flotillas as fleet
        on fleetFilter.idFlotilla = fleet.id
        WHERE fleet.idUsuario = ${userID} and fleetFilter.idDispositivo = ${deviceID}";
        $this->db->query($query);

       if( isset($fleetID) && empty($fleetID) == false && is_numeric($fleetID)){
            $query = "INSERT INTO t_flotilla_relacion_dispositivo
            (idFlotilla, idDispositivo)
            SELECT ${fleetID}, ${deviceID}
            WHERE NOT EXISTS (
                SELECT fleetFilter.idFlotilla, fleetFilter.idDispositivo
                FROM t_flotilla_relacion_dispositivo as fleetFilter
                INNER JOIN t_flotillas as fleets
                on fleets.id = fleetFilter.idFlotilla
                WHERE fleets.idUsuario = ${userID} and fleetFilter.idDispositivo = ${deviceID}
            )";
            $this->db->query($query);
        }
      
     

        $this->db->trans_complete();
        
        if($this->db->trans_status() == false){
            throw new Exception('error update device fleet');
        }
    }


    public function deviceHasFleet($userID, $deviceID){
        $query = "SELECT EXISTS (SELECT fleetFilter.idFlotilla, fleetFilter.idDispositivo
        FROM t_flotilla_relacion_dispositivo as fleetFilter
        INNER JOIN t_flotillas as fleets
        on fleets.id = fleetFilter.idFlotilla
        WHERE fleets.idUsuario = ${userID} and fleetFilter.idDispositivo = ${deviceID}) as 'exists'";
 
         $resultSet = $this->db->query($query); 
         $resultSet = $resultSet->result();

         if($resultSet[0]->exists >= 1)
            return true;
         else
            return false;  

    }


    public function getVirtualFleets($clientID){
        $query = "SELECT client.id as id, client.cuenta as name,
        count(devices.idCliente) as totalDevices, unix_timestamp() as creationTimestamp
        FROM t_clientes as client
        INNER JOIN t_dispositivos as devices
        on devices.idCliente = client.id
        
        where client.idPropietario = ${clientID} GROUP BY client.id ";

        $resultSet = $this->db->query($query)->result();     
        return $resultSet;
    }



}