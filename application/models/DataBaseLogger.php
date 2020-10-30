<?php

namespace Models;
class DataBaseLogger extends DataBase {
    public function __construct() {
        parent::__construct();
    }

    public function recordUserAction($userID, $entityType, $entityID, $actionType){
        $query = "INSERT into t_bitacora_usuario
        (idUsuario, idTipoEntidad,  idTipoAccion, idEntidad, fecha)
        VALUES (${userID}, ${entityType}, ${actionType}, ${entityID},  current_timestamp())";
        $this->db->trans_start();
        $this->db->query($query);
    
        if($this->db->trans_status() == false){
            $this->db->trans_complete();
            throw new Exception("Error al guardar usuario");
        } 

    }
}
