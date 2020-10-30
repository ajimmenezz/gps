<?php
namespace Models;
use Libraries\Utils;

class DataBaseAccount extends DataBase{
    public function __construct() {
        parent::__construct();
    }

    public function accountExists($accountName){
        $query = "SELECT EXISTS(
            SELECT cuenta 
            FROM t_clientes 
            WHERE cuenta = '${accountName}') as 'exists'";
        
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }


    public function createAccount($data){
          try{
              //Crear la cuenta
            $query = "INSERT INTO t_clientes
            (idPropietario, idTipoCliente, cuenta, estatus, fechaCreacion, fechaSuscripcion)
            VALUES
            ({$data->ownerID}, {$data->type}, '{$data->name}', 1, UNIX_TIMESTAMP(), 0)";
    
            
            $this->db->trans_start();
            $this->db->query($query);
    
            $clientID =  $this->db->insert_id();

            //Crear datos legales
            $query = "INSERT INTO t_datoslegales
            (idCliente, idEstatusLegal, nombre, pais, region, direccion, cp, notas, rfc)
            VALUES
            ({$clientID},{$data->legal->statusID},'{$data->legal->name}', '{$data->legal->country}', '{$data->legal->region}',
            '{$data->legal->address}', '{$data->legal->zipCode}', '{$data->legal->notes}', '{$data->legal->id}')";
            
            $this->db->query($query);


            //Crear datos de clientes
            foreach ($data->contacts as $contact) {
                $query = "INSERT INTO t_personas
                (idCliente, idTipoPersona, nombre, telefono, celular, correo, fechaCreacion, notas)
                VALUES
                (${clientID}, {$contact->type}, '{$contact->name}', '{$contact->phone}', '{$contact->cel}',
                '{$contact->email}', UNIX_TIMESTAMP(),'{$contact->notes}')";
                
                $this->db->query($query);
            }
           
           
            $this->db->trans_complete();
            if($this->db->trans_status() == false){
                throw new Exception('error on create user');
            }

            return $clientID;
    
            
        }
        catch(Exception $err){
            throw new Exception($err->getMessage());
        }
    }

    public function getAccounts($clientID, $status = null){
        $whereStatus = "0";
        // if (empty($status) && $status !== '0')
        //     $whereStatus = "1";
        // else 
        //     $whereStatus = $status;

        $query  = "SELECT client.id, idTipoCliente as clientTypeID, clientType.nombre as clientType, 
        cuenta as 'name', fechaCreacion as creationTimestamp, client.estatus as active 
        FROM t_clientes as client

        INNER JOIN cat_tipocliente as clientType
        on clientType.id = client.idTipoCliente

        where client.idPropietario = ${clientID} and client.estatus >= ${whereStatus} and client.idTipoCliente != 3";

         $resultSet = $this->db->query($query); 
         $resultSet = $resultSet->result();
         return $resultSet; 
    }
    
    public function getAccount($clientID){
        $account = new \stdClass();

        $query = "SELECT 
        client.id, client.idPropietario as ownerID, 
        clientType.id as clientTypeID, clientType.nombre as clientType,
        client.cuenta as account, client.fechaCreacion as creationTimestamp,
        client.estatus as active
        from t_clientes as client
        INNER JOIN cat_tipocliente as clientType
        on clientType.id = client.idTipoCliente
        
        INNER JOIN t_datoslegales as legal
        on legal.idCliente = client.id
        
        where client.id = ${clientID} and client.estatus >= 0";

        $account = $this->db->query($query)->result()[0];

        if(!empty($account)){
            $query = "SELECT legalStatus.id as statusID, legalStatus.nombre as status, 
            legal.nombre as name, legal.pais as country, legal.region, legal.direccion as address,
            legal.cp as zipCode, legal.notas as notes,
            legal.rfc as taxID
            from t_datoslegales as legal
            INNER JOIN cat_estatuslegal as legalStatus
            on legalStatus.id = legal.idEstatusLegal
            where legal.idCliente = ${clientID}";
            
            $account->legal = $this->db->query($query)->result()[0];
    
            $query = "SELECT contact.id, 
            contactType.id contactTypeID, contactType.nombre as contactType,
            contact.nombre as name, contact.telefono as phone, contact.celular as cel, contact.correo as email,
            contact.fechaCreacion as creationTimestamp,
            contact.notas as notes
            from t_personas as contact
            INNER JOIN cat_tipopersona as contactType
            on contactType.id = contact.idTipoPersona
            where contact.idCliente = ${clientID}";
    
            $account->contacts = $this->db->query($query)->result();
    
        }
        
        
       
        return $account;
    }

    public function getOwnerID($clientID){
        $query = "SELECT 
        client.idPropietario as ownerID
        from t_clientes as client
        where client.id = ${clientID}";

        $result = $this->db->query($query)->result(); 
        if(count($result) > 0 )
            return $result[0]->ownerID;
        else
            return null;
    }

    public function updateLegalInfo($clientID, $params){
        try{
            //Crear la cuenta
          $query = "UPDATE t_datoslegales SET "; 
          $query .= implode(",",$params->conditions);
          $query .= " WHERE idCliente = ${clientID}";
  
          
          $this->db->trans_start();

          $this->db->query($query, $params->parameters);

          $this->db->trans_complete();
          if($this->db->trans_status() == false){
              throw new Exception('error on al actualizar datos legales');
          }   
      }
      catch(Exception $err){
          throw new Exception($err->getMessage());
      }
    }

    public function setAccountStatus($clientID, $status){
        try{

            if($status)
                $status = 1;
            else
                $status = 0;
            //Crear la cuenta
            $query = "UPDATE t_clientes SET
            estatus = ${status}
            WHERE id = ${clientID} "; 

            $this->db->trans_start();
            $this->db->query($query);

            $this->db->trans_complete();
            if($this->db->trans_status() == false){
                throw new Exception('error on al actualizar el estado del cliente');
            }   
      }
      catch(Exception $err){
          throw new Exception($err->getMessage());
      }
    }

    public function registerContact($clientID, $contact){
        try{
          $query = "INSERT INTO t_personas
          (idCliente, idTipoPersona, nombre, telefono, celular, correo, fechaCreacion, notas)
          VALUES
          (${clientID}, {$contact->contactType}, '{$contact->name}', '{$contact->phone}', '{$contact->cel}', '{$contact->email}', UNIX_TIMESTAMP(),'{$contact->notes}')"; 
       
          $this->db->trans_start();

          $this->db->query($query);
          $contactID =  $this->db->insert_id();

          $this->db->trans_complete();
          if($this->db->trans_status() == false){
              throw new Exception('error al eliminar contacto');
          }

          return $contactID;
        }
        catch(Exception $err){
            throw new Exception($err->getMessage());
        }
    }

    public function updateContact($clientID, $contact){
        try{
          $query = "UPDATE  t_personas 
           SET idTipoPersona= {$contact->contactType}, nombre='{$contact->name}', telefono='{$contact->phone}',
            celular='{$contact->cel}',  correo='{$contact->email}', notas='{$contact->notes}' 
             WHERE id=${clientID} "; 

           
       
          $this->db->trans_start();

          $this->db->query($query);
         

          $this->db->trans_complete();
          if($this->db->trans_status() == false){
              throw new Exception('error al actualizar contacto');
          }

          return $clientID;
        }
        catch(Exception $err){
            throw new Exception($err->getMessage());
        }
    }

    public function deleteContact($contactID){
        try{
          $query = "DELETE FROM t_personas
          where id = ${contactID}"; 
       
          $this->db->trans_start();

          $this->db->query($query);

          $this->db->trans_complete();
          if($this->db->trans_status() == false){
              throw new Exception('error al eliminar contacto');
          }
        }
        catch(Exception $err){
            throw new Exception($err->getMessage());
        }
    }


    public function getClientIDByContactID($contactID){
        $query = "SELECT idCliente
        from t_personas
        where id = ${contactID}";

        $result = $this->db->query($query)->result(); 
        if(count($result) > 0 )
            return $result[0]->idCliente;
        else
            return null;
    }

    public function getAccountType($clientID){
        $query = "SELECT  idTipoCliente 
        From t_clientes 
        where id = ${clientID}";

        $result = $this->db->query($query)->result(); 
        if(count($result) > 0 )
            return $result[0]->idTipoCliente;
        else
            return null;
    }

    public function deleteAccount($clientID){
        try{
            $this->db->trans_start();

            //Eliminar cliente
            $query = "UPDATE t_clientes
            SET estatus = -1
            where id = ${clientID}"; 
            $this->db->query($query);

            $this->db->trans_complete();
            if($this->db->trans_status() == false){
                throw new Exception('error al eliminar contacto');
            }
          }
          catch(Exception $err){
              throw new Exception($err->getMessage());
          }
    }

    public function setAccountOwner($ownerID, $clientID){
        $this->db->trans_start();

        $query = "UPDATE t_clientes
        set idPropietario = ${ownerID}
        where id = ${clientID} and estatus >= 0";

        $this->db->query($query);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error actualizar el propietario del cliente');
        }

        return true;
    }

    public function matchClients($ownerID, $clients){
        $query = "SELECT id 
        FROM  t_clientes
        WHERE  idPropietario = ${ownerID} and  id IN (".implode(", ", $clients).")";

        $result =  $this->db->query($query)->result();
        return array_map( create_function('$obj','return (int) $obj->id;'), $result);  
    }
}