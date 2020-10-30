<?php

namespace Models;
use Libraries\Utils;

class DataBaseSims extends DataBase {
    public function __construct() {
        parent::__construct();
    }

    public function createSims($params){
        $this->db->trans_start();
        
        $idDevice=!empty($params->deviceID)?"{$params->deviceID}":"NULL";
        $idCliente=!empty($params->clientID)?"{$params->clientID}":"{$params->distributorID}";


        $query = "INSERT INTO t_sims
        ( idCliente, idCompañiaTelefonica,idDispositivo,idPlan,icc,telefono, fechaCreacion,notas, estatus)
        VALUES
        ( {$idCliente}, {$params->carrier}, {$idDevice}, {$params->planID},'{$params->icc}', '{$params->phone}', UNIX_TIMESTAMP(), '{$params->notes}', 1)";
        $this->db->query($query);

        $simsID = $this->db->insert_id();
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error creating sims');
        }

        return $simsID;
    }

    public function simsTelExists($tel){
        $query = "SELECT EXISTS(
            SELECT telefono 
            FROM t_sims	
            WHERE telefono	= '${tel}') as 'exists'";
        
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }

    public function simsIccExists($icc){
        $query = "SELECT EXISTS(
            SELECT icc 
            FROM t_sims	
            WHERE icc	= '${icc}') as 'exists'";
        
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }

    public function getSimListByClient($clientID, $status=1){
        $query = "SELECT sims.id, sims.idCliente as clientID,  sims.icc, sims.telefono as phone,
        sims.fechaCreacion as creationTime, 
        carrier.id as carrierID, carrier.nombre carrierName, plan.id as planID, plan.nombre as plan,
        sims.idDispositivo as deviceID, device.imei as deviceImei
        FROM t_sims as sims
        LEFT JOIN t_dispositivos as device
        on device.id = sims.idDispositivo
        LEFT JOIN `cat_compañiastelefonicas` as carrier
        on carrier.id = sims.`idCompañiaTelefonica`
        LEFT JOIN cat_sims_planes as plan
        on plan.id = sims.idPlan
        WHERE sims.idCliente = ${clientID} AND sims.estatus=${status}";
        
        return $this->db->query($query)->result();  
    }

    public function getSims($simID, $status=1){
        $query = "SELECT sim.id,sim.icc,sim.telefono,sim.notas,sim.fechaCreacion, sim.estatus, sim.`idCompañiaTelefonica`,carrier.nombre AS 'carrier',sim.idPlan,plan.nombre AS 'plan'
        FROM t_sims AS sim
        INNER JOIN `cat_compañiastelefonicas` AS carrier ON carrier.id=sim.`idCompañiaTelefonica`
        INNER JOIN cat_sims_planes AS plan ON plan.id=sim.idPlan
        WHERE sim.id= ${simID} AND sim.estatus=${status}";
        
        return $this->db->query($query)->result();  
    }

    public function updateSims($params,$simID){
      

        if(count($params->conditions) > 0){
            $this->db->trans_start();

            $query = "UPDATE t_sims";
            $query .= " SET ".implode(" ,", $params->conditions);
            $query .= " WHERE id = ${simID}"; 
    
            $this->db->query($query, $params->parameters);
            $this->db->trans_complete();

            
            if($this->db->trans_status() == false){
                throw new Exception('error updating sims');
            }
            
            return $simID;
    
        }  

        
    }

    public function deleteSims($simID){
        $this->db->trans_start();
        
        $query = "UPDATE t_sims
        SET estatus=-1
        WHERE id= ${simID}";

        $this->db->query($query);

        
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error delete sims');
        }

        
    }

    public function setOwner($clientID, $simID){
        $this->db->trans_start();

        $query = "UPDATE t_sims
        set idCliente = ${clientID}
        where id = ${simID}";

        $this->db->query($query);

        
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error actualizar el propietario de la sim');
        }

        return true;
    }

    public function deleteClientSims($clientID){
        $this->db->trans_start();
        
        $query = "UPDATE t_sims
        SET estatus=-1
        WHERE idCliente = ${clientID}";

        $this->db->query($query);

        
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error delete sims');
        }

        
    }
    


     

}
