<?php
namespace Models;

use Libraries\Utils;
use \Exception as Exception;

class DataBaseUser extends DataBase
{

    public function subirLogodb($ruta, $idUser)
    {


        $query = "SELECT cliente.cuenta FROM
        t_clientes AS cliente
       
       WHERE cliente.id='${idUser}' ";

        $nameCuenta = $this->db->query($query)->result();

        $cuenta = $nameCuenta[0]->cuenta;


        $consulta = "SELECT *
                FROM t_clientes_logo
            WHERE t_clientes_logo.idCliente='${idUser}'";

        $resultadoC = $this->db->query($consulta)->result();

        if (sizeof($resultadoC) <= 0) {

            // print_r($query);
            // print_r("es");
            // print_r($idUser);
            // print_r("me");

            $querydb = "INSERT INTO t_clientes_logo (logo,idCliente,usuario)
                            VALUES ('${ruta}',$idUser,'${cuenta}')";
            //print_r($querydb);



            $this->db->trans_start();
            $this->db->query($querydb);
            $this->db->trans_complete();
        }





        return  $cuenta;
    }


    public function getLogo($username)
    {
        $query = "SELECT client.id, client.idTipoCliente, client.cuenta,logo.logo 
        FROM 
        t_clientes AS client
                INNER JOIN t_clientes_logo as logo
                        ON client.id=logo.idCliente
                        
                WHERE client.cuenta= '${username}'";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }



    public function getLogoUser($username)
    {
        $query = "SELECT client.id, client.idTipoCliente, client.cuenta,user.id as 'idUser', user.usuario,user.idTipoUsuario, logo.logo FROM t_usuarios AS user INNER JOIN t_clientes AS client ON 
        user.idCliente=client.id
        INNER JOIN t_clientes_logo as logo ON client.id=logo.idCliente
        WHERE user.usuario= '${username}'";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getUserID($username)
    {
        $query = "SELECT users.id 
        from t_usuarios as users
        where users.usuario = '${username}'";

        $resultSet = $this->db->query($query)->result();

        if (sizeof($resultSet) <= 0) {
            return null;
        } else {
            return $resultSet[0]->id;
        }
    }
    public function getUserIDByEmail($email)
    {
        $query = "SELECT id 
        FROM t_usuarios
        WHERE correo = '${email}' and estatus = 1";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->id;
    }

    public function getInmmobilizerPassword($userID)
    {
    }

    public function updateUserPassword($userID, $passwordEncrypted)
    {
        $query = "UPDATE t_usuarios
        set contrasena = '${passwordEncrypted}'
        where id = ${userID}";

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();

        return $this->db->trans_status();

        // if($this->db->trans_status() == false){
        //     throw new Exception('error updating password');
        // }

    }

    public function getUserPassword($username)
    {
        $query = "Select users.contrasena 
        from t_usuarios as users 
        where users.usuario = '${username}'";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->contrasena;
    }

    public function getStatus($userID)
    {
        $query = "SELECT distributors.estatus distributorStatus, 
        clients.estatus clientStatus, 
        users.estatus userStatus
        FROM t_usuarios as users
        
        INNER JOIN t_clientes as clients
        on clients.id = users.idCliente
        
        LEFT JOIN t_clientes as distributors
        on distributors.id = clients.idPropietario
        
        where users.id = ${userID}";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0];
    }

    public function setStatus($userID, $status)
    {
        try {

            if ($status)
                $status = 1;
            else
                $status = 0;
            //Crear la cuenta
            $query = "UPDATE t_usuarios SET
            estatus = ${status}
            WHERE id = ${userID} ";

            $this->db->trans_start();
            $this->db->query($query);

            $this->db->trans_complete();
            if ($this->db->trans_status() == false) {
                throw new Exception('error on al actualizar el estado del usuario');
            }
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }


    public function getDataAccess($username)
    {
        try {
            $query = "select distributors.id distributorID, distributors.estatus distributorStatus,
            clients.id clientID, clients.idTipoCliente clientType, clients.cuenta clientName, clients.estatus clientStatus, 
            users.id userID, users.usuario userName, users.contrasena userPassword, users.idTipoUsuario userType,
            users.estatus userStatus, users.fechaUltimoIngreso lastTimestampLogin,
            timezones.zonahoraria timeZone 
            from t_usuarios as users
            INNER JOIN timezones
            on timezones.id = users.idTimezone
            INNER JOIN t_clientes as clients
            on clients.id = users.idCliente
            LEFT JOIN t_clientes as distributors
            on distributors.id = clients.idPropietario
            where users.usuario = '${username}'";

            $statment = $this->db->query($query)->result();

            if (sizeof($statment) <= 0) {
                return null;
            } else {
                return $statment[0];
            }
        } catch (Exception $err) {
            throw new Exception("El usuario no existe");
        }
    }


    public function getUserType($userID)
    {
        $query = "Select idTipoUsuario userType
        from t_usuarios
        where id = ${userID}";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->userType;
    }

    public function emailExists($email)
    {
        $query = "SELECT EXISTS(
            SELECT correo 
            FROM t_usuarios 
            WHERE correo = '${email}' and estatus = 1) as 'exists'";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }

    public function userExists($username)
    {
        $query = "SELECT EXISTS(
            SELECT usuario 
            FROM t_usuarios 
            WHERE usuario = '${username}') as 'exists'";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }


    public function insertOperationToken($userID, $tokenString)
    {
        $query = "INSERT INTO t_usuarios_token_operacion
        (idUsuario, token, fechaCreacion) 
        VALUES (${userID}, '${tokenString}', UNIX_TIMESTAMP())
        ON DUPLICATE KEY
        UPDATE
        token = '${tokenString}',
        fechaCreacion = UNIX_TIMESTAMP()";

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error inserting operation token');
        }
    }

    public function getOperationToken($userID)
    {
        $query = "Select token
        from t_usuarios_token_operacion
        where idUsuario = ${userID}";


        $resultSet = $this->db->query($query)->result();
        if (sizeof($resultSet) > 0) {
            return $resultSet[0]->token;
        } else {
            return '';
        }
    }

    public function deleteOperationToken($userID)
    {
        $query = "DELETE FROM t_usuarios_token_operacion
        WHERE idUsuario = ${userID}";

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error deleting operation token');
        }
    }

    public function updateLastLogin($userID)
    {
        $query = "UPDATE t_usuarios
        SET fechaUltimoIngreso = UNIX_TIMESTAMP()
        WHERE id = ${userID}";

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();
    }

    public function registerLogin($userID)
    {
        $query = "INSERT INTO t_usuarios_bitacora_acceso
            (idUsuario)
            values
            (${userID})";

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();
    }


    public function getUsername($userID)
    {
        $query = "Select usuario
        from t_usuarios
        where id = ${userID}";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->usuario;
    }

    public function eventPasswordExists($clientID)
    {
        $query = "SELECT EXISTS(
            SELECT idCliente 
            FROM t_clientes_contrasena_eventos 
            WHERE idCliente = ${clientID})
			as 'exists'";

        $resultSet = $this->db->query($query)->result();

        $exists = $resultSet[0]->exists;

        if ($exists >= 1) {
            return true;
        }

        return false;
    }

    public function getEventPasswordExpiration($clientID)
    {
        $query = "SELECT fechaExpiracion as timestampExpiration
        from t_clientes_contrasena_eventos
        where idCliente = ${clientID}";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->timestampExpiration;
    }

    public function updateEventPassword($clientID, $passwordEncrypted, $timestampExpiration)
    {

        $query = "INSERT INTO t_clientes_contrasena_eventos
        (idCliente, contrasena, fechaCreacion, fechaExpiracion) 
        VALUES (${clientID}, '${passwordEncrypted}', UNIX_TIMESTAMP(), ${timestampExpiration} )
        ON DUPLICATE KEY
        UPDATE
        contrasena = '${passwordEncrypted}',
        fechaExpiracion = ${timestampExpiration}";

        $this->db->trans_start();
        $this->db->query($query);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error updating event password');
        }
    }

    public function getEventPassword($clientID)
    {
        $query = "SELECT contrasena as password, fechaExpiracion as timestampExpiration
        from t_clientes_contrasena_eventos
        where idCliente = ${clientID}";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0];
    }

    public function getEmail($userID)
    {
        $query = "SELECT correo 
        FROM t_usuarios
        WHERE id = '${userID}'";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->correo;
    }

    public function getClientID($userID)
    {
        try {
            $query = "SELECT idCliente 
            FROM t_usuarios
            WHERE id = ${userID}";

            $resultSet = $this->db->query($query)->result();

            if (count($resultSet) > 0) {
                return $resultSet[0]->idCliente;
            } else {
                return [];
            }
        } catch (Exception $err) {
            return [];
        }
    }

    public function createUser($userData)
    {
        try {
            $query = "INSERT INTO t_usuarios
            (idCliente, idTipoUsuario, idTimezone, usuario, contrasena, correo, fechaCreacion, notas, estatus)
            VALUES
            ({$userData->clientID},{$userData->userType},{$userData->timezone}, '{$userData->username}', '{$userData->passwordEncrypted}', '{$userData->email}', CURRENT_TIMESTAMP(), '{$userData->notes}', 1)";


            $this->db->trans_start();
            $this->db->query($query);

            $userID =  $this->db->insert_id();

            $query = "INSERT INTO t_usuarios_datos_contacto
            (idUsuario, nombre, apellidoPaterno, apellidoMaterno, telefono, direccion)
            VALUES
            (${userID}, '{$userData->name}', '{$userData->paternalSurname}','{$userData->maternalSurname}',{$userData->phone}, '{$userData->address}')";

            $this->db->query($query);

            $totalPermissions = count($userData->permissions);
            if ($totalPermissions > 0) {
                $queryPermissions = "INSERT INTO t_usuarios_relacion_permisos_adicionales
                (idUsuario, idPermiso)
                VALUES ";

                $i = 0;
                foreach ($userData->permissions as $permission) {
                    if ($i != 0) {
                        $queryPermissions = $queryPermissions . ",";
                    }
                    $queryPermissions = $queryPermissions . "(${userID}, ${permission}) ";
                    $i++;
                }

                $this->db->query($queryPermissions);
            }

            $this->db->trans_complete();

            if ($this->db->trans_status() == false) {
                throw new Exception('error on create user');
            }

            return $userID;
        } catch (Exception $err) {
            throw new Exception($err->getMessage());
        }
    }


    public function getDistributorID($userID)
    {
        $query = "SELECT idPropietario as distributorID 
        FROM t_usuarios
        INNER JOIN t_clientes
        on t_clientes.id = t_usuarios.idCliente
        WHERE t_usuarios.id = '${userID}'";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->getDistributorID;
    }

    public function getUserInfo($userID, $status = 0)
    {
        $query = "SELECT user.id, user.idTipoUsuario as userType, user.idTimezone as timezoneID,
        user.usuario as username, user.correo as email, user.fechaCreacion as creationTimestamp, 
        user.notas as notes, contact.nombre as name, contact.apellidoPaterno as paternalSurname,
        contact.apellidoMaterno as maternalSurname, contact.telefono as phone, contact.direccion as address,
        user.estatus as active
        FROM t_usuarios as user
        LEFT JOIN  t_usuarios_datos_contacto as contact
        on contact.idUsuario = user.id
        WHERE user.id = '${userID}' and user.estatus >= ${status}";

        $statment = $this->db->query($query)->result();
        return $statment[0];
    }


    public function getUserList($clientID, $userType = 0, $status = 0)
    {

        $query = "SELECT user.id, user.idTipoUsuario as userType, user.usuario as username,
        user.correo as email, user.fechaCreacion as creationTimestamp,
        contact.nombre as name, contact.apellidoPaterno as paternalSurname,
        user.estatus as active
        FROM t_usuarios as user
        LEFT JOIN  t_usuarios_datos_contacto as contact
        on contact.idUsuario = user.id
        WHERE user.idCliente = '${clientID}' and user.estatus >= ${status}";

        if ($userType != 0) {
            $query = $query . " and idTipoUsuario = ${userType}";
        }

        $statment = $this->db->query($query)->result();
        return $statment;
    }

    public function hasPermission($userID, $permissionID)
    {
        try {
            $query = "SELECT EXISTS(
                SELECT permissions.idPermiso
                FROM t_usuarios as user
                INNER JOIN t_tipousuario_relacion_permisos as permissions
                on permissions.idTipoUsuario = user.idTipoUsuario
                WHERE user.id = {$userID} AND permissions.idPermiso = {$permissionID}
                UNION
                SELECT extraPermissions.idPermiso
                FROM t_usuarios as user
                INNER JOIN t_usuarios_relacion_permisos_adicionales as extraPermissions
                on extraPermissions.idUsuario = user.id
                WHERE user.id = {$userID} AND extraPermissions.idPermiso = {$permissionID}
                ) as 'exists'";


            $statment = $this->db->query($query)->result();

            if ($statment[0]->exists == '1') {
                return true;
            } else {
                return false;
            }
        } catch (Exception $err) {
            return false;
        }
    }

    public function updateTimestampModification($userID)
    {
        $this->db->trans_start();

        //Eliminado virtual del usuario
        $query = "UPDATE t_usuarios
        SET fechaUltimaModificacion = CURRENT_TIMESTAMP()
        WHERE id = {$userID}";
        $this->db->query($query);

        $this->db->trans_complete();
    }

    public function deleteUser($userID)
    {
        $this->db->trans_start();

        //Eliminado virtual del usuario
        $query = "UPDATE t_usuarios
        SET estatus = -1
        WHERE id = {$userID}";
        $this->db->query($query);

        //Eliminar permisos adicionales
        $query = "DELETE FROM t_usuarios_relacion_permisos_adicionales
        WHERE idUsuario = {$userID}";
        $this->db->query($query);

        //Eliminado virtual de la geocerca
        $query = "UPDATE t_geocercas
        SET estatus = 0
        WHERE idUsuario = {$userID}";
        $this->db->query($query);

        //Eliminar virtual relacion geocerca-dispositivo
        $query = "UPDATE t_geocerca_relaciondispositivos as geofenceFilter
        INNER JOIN t_geocercas as geofences
        on geofences.id = geofenceFilter.idGeocerca
        SET geofenceFilter.estatus = 0
        WHERE geofences.idUsuario = {$userID}";
        $this->db->query($query);


        //Eliminar token de operacion
        $query = "DELETE FROM t_usuarios_token_operacion
        WHERE idUsuario = {$userID}";
        $this->db->query($query);

        //Eliminar relacion dispositivo-flotillas
        $query = "DELETE fleetList FROM t_flotilla_relacion_dispositivo as fleetList
        INNER JOIN t_flotillas as fleets
        on fleets.id = fleetList.idFlotilla
        WHERE fleets.idUsuario = {$userID}";
        $this->db->query($query);

        //Eliminar Flotillas
        $query = "DELETE FROM t_flotillas
        WHERE idUsuario = {$userID}";
        $this->db->query($query);

        //Eliminar relacion usuario-dispositivo
        $query = "DELETE FROM t_filtro_dispositivos
        WHERE idUsuario = {$userID}";
        $this->db->query($query);


        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error updating event password');
        }
    }


    public function updateUser($userID, $params)
    {
        $this->db->trans_start();

        $query = "UPDATE t_usuarios";
        if ($params->conditions) {
            $query .= " SET " . implode(" ,", $params->conditions);
        }
        $query .= " WHERE id = ${userID}";

        $this->db->query($query, $params->parameters);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error updating user');
        }
    }

    public function updateUserContact($userID, $params)
    {
        $this->db->trans_start();

        $query = "UPDATE t_usuarios_datos_contacto";
        if ($params->conditions) {
            $query .= " SET " . implode(" ,", $params->conditions);
        }
        $query .= " WHERE idUsuario = ${userID}";

        $this->db->query($query, $params->parameters);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error updating user');
        }
    }

    public function removePermissons($userID)
    {
        $this->db->trans_start();

        $query = "DELETE from t_usuarios_relacion_permisos_adicionales
        WHERE idUsuario = ${userID}";

        $this->db->query($query);
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {
            throw new Exception('error deleting Permissons user');
        }
    }

    public function addPermissions($userID, $permissions)
    {
        if (count($permissions) > 0) {
            $this->db->trans_start();
            $query = "INSERT INTO t_usuarios_relacion_permisos_adicionales
                (idUsuario, idPermiso)
                VALUES ";

            $i = 0;
            foreach ($permissions as $permission) {
                if ($i != 0) {
                    $query .= ",";
                }
                $query .= "(${userID}, ${permission}) ";
                $i++;
            }

            $this->db->query($query);
            $this->db->trans_complete();

            if ($this->db->trans_status() == false) {
                throw new Exception('error updating user');
            }
        }
    }

    public function getClientType($clientID)
    {
        try {
            $query = "SELECT idTipoCliente 
            FROM t_clientes
            WHERE id = ${clientID}";

            $resultSet = $this->db->query($query)->result();

            if (count($resultSet) > 0) {
                return $resultSet[0]->idTipoCliente;
            } else {
                return [];
            }
        } catch (Exception $err) {
            return [];
        }
    }

    public function getClientOwnerID($clientID)
    {
        $query = "SELECT idPropietario 
        FROM t_clientes
        WHERE id = ${clientID}";

        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->idPropietario;
    }
}
