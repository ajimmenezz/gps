<?php
namespace Models;
use Libraries\Utils;

class DataBasePermissions extends DataBase{
    public function __construct() {
        parent::__construct();
    }

    public function getUserPermissions($userID){
        $query = "
        SELECT permissions.id, permissions.permiso as 'code', permissions.nombre as name 
        from t_usuarios as users
        INNER JOIN t_tipousuario_relacion_permisos as profilePermissions
        on profilePermissions.idTipoUsuario = users.idTipoUsuario
        INNER JOIN cat_usuarios_permisos as permissions
        on permissions.id = profilePermissions.idPermiso
        where users.id = ${userID}
        
        UNION
        
        SELECT permissions.id, permissions.permiso as 'code', permissions.nombre as name 
        from t_usuarios_relacion_permisos_adicionales as extraPermissions
        INNER JOIN cat_usuarios_permisos as permissions
        on permissions.id = extraPermissions.idPermiso
        where extraPermissions.idUsuario = ${userID}";

        $resultSet = $this->db->query($query); 
        $resultSet = $resultSet->result();
        return $resultSet;    
    }

    public function hasPermission($userID, $permissionID){
        $query = "
        SELECT EXISTS(SELECT permissions.id
        from t_usuarios as users
        INNER JOIN t_tipousuario_relacion_permisos as profilePermissions
        on profilePermissions.idTipoUsuario = users.idTipoUsuario
        INNER JOIN cat_usuarios_permisos as permissions
        on permissions.id = profilePermissions.idPermiso
        where users.id = ${userID} and profilePermissions.idPermiso = ${permissionID}
        
        UNION
        
        SELECT permissions.id
        from t_usuarios_relacion_permisos_adicionales as extraPermissions
        INNER JOIN cat_usuarios_permisos as permissions
        on permissions.id = extraPermissions.idPermiso
        where extraPermissions.idUsuario = ${userID} and extraPermissions.idPermiso = ${permissionID}) as 'exists'";

        $resultSet = $this->db->query($query)->result();
        $result =  $resultSet[0]->exists;

        if($result == 1){
            return true;
        }
        else{
            return false;
        }
    }
}