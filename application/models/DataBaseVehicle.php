<?php

namespace Models;
use Libraries\Utils;

class DataBaseVehicle extends DataBase {
    public function __construct() {
        parent::__construct();
    }

    public function createDriver($params){
        $this->db->trans_start();

        $query = "INSERT INTO t_conductores
        ( nombre, telefono, fechaCreacion, estatus)
        VALUES
        ( '{$params->name}', '{$params->phone}', UNIX_TIMESTAMP(), 1)";
        $this->db->query($query);

        $driverID = $this->db->insert_id();
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error creating driver');
        }

        return $driverID;
    }

    public function vinExists($vin){
        $query = "SELECT EXISTS(
            SELECT vin 
            FROM t_vehiculos 
            WHERE vin	= '${vin}') as 'exists'";
        
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }

    public function createVehicle($params){
        $this->db->trans_start();

        $query = "INSERT INTO t_vehiculos
        ( idDispositivo, idConductor, marca, modelo, año, vin, color, placas, pais,
         region, seguro, numeroSeguro, notas, estatus, fechaCreacion )
        VALUES
        ( {$params->deviceID}, {$params->driverID}, '{$params->brand}',
        '{$params->model}', {$params->year}, '{$params->vin}', '{$params->colour}', '{$params->carPlate}',
        '{$params->country}', '{$params->region}', '{$params->insurance}', '{$params->insuranceID}',
        '{$params->notes}', 1, UNIX_TIMESTAMP())";

        $this->db->query($query);
        $vehicleID = $this->db->insert_id();
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error creating vehicle');
        }

        return $vehicleID;

    }

    public function updateVehicle($vehicleID, $params){
        if(count($params->conditions) > 0){
            $this->db->trans_start();

            $query = "UPDATE t_vehiculos";
            $query .= " SET ".implode(" ,", $params->conditions);
            $query .= " WHERE id = ${vehicleID}"; 
    
            $this->db->query($query, $params->parameters);
            $this->db->trans_complete();
    
            if($this->db->trans_status() == false){
                throw new Exception('error updating vehicle');
            }
        }   
     }

     public function updateDriver($driverID, $params){
        if(count($params->conditions) > 0){
            $this->db->trans_start();

            $query = "UPDATE t_conductores";
            $query .= " SET ".implode(" ,", $params->conditions);
            $query .= " WHERE id = ${driverID}"; 
    
            $this->db->query($query, $params->parameters);
            $this->db->trans_complete();
    
            if($this->db->trans_status() == false){
                throw new Exception('error updating driver');
            }
        }   
     }

     

}
