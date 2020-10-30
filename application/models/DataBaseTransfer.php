<?php
namespace Models;
use Libraries\Utils;
use \Exception as Exception;

class DataBaseTransfer extends DataBase {
    public function __construct() {
        parent::__construct();
    }

    public function createTransfer($transfer){
            $this->db->trans_start();

            //Registrar transferencia
            $query = "INSERT INTO t_transferencias
            (idClienteSalida, idClienteEntrada, idTipoTransferencia, idEstadoTransferencia, fechaCreacion, notas)
            VALUES
            ({$transfer->fromClientID}, {$transfer->toClientID}, {$transfer->type}, 1, CURRENT_TIMESTAMP(), '{$transfer->notes}')";
    
            $this->db->query($query);
    
            $transferID = $this->db->insert_id();
    
            //Registrar productos involucrados en la transaccion
            $query = "INSERT INTO t_transferencia_relacion_productos
            (idTransferencia, idTipoProducto, idProducto, idEstadoTransferenciaProducto)
            VALUES ";
    
            $arrayProducts = array();
            $arrayProductsPending = array();
            foreach($transfer->products as $product){
                $arrayProducts[] = "(${transferID}, {$product->type}, {$product->id}, 1)";
                $arrayProductsPending[] = "({$product->type}, {$product->id})";
            }

            $query .= implode(',',$arrayProducts);
            $this->db->query($query);

            //Registrar productos en estado de pendiente
            // $query = "INSERT INTO t_transferencia_relacion_productos_pendientes
            // (idTipoProducto, idProducto)
            // VALUES ";
            // $query .= implode(',',$arrayProductsPending);
            // $this->db->query($query);
    
            $this->db->trans_complete();
    
            if($this->db->trans_status() == false){
                throw new Exception('error registering transfer');
            }
    
            return $transferID;     
    }

    public function recordAction($data){
        $this->db->trans_start();

            //Registrar transferencia
            $query = "INSERT INTO t_transferencia_bitacora
            (idTransferencia, idUsuario, idAccion, fechaCreacion, notas)
            VALUES
            ({$data->transferID}, {$data->userID}, {$data->actionType}, CURRENT_TIMESTAMP(), '{$data->notes}')";
    
            $this->db->query($query);
    
            $resultID = $this->db->insert_id();
    

            $this->db->trans_complete();
    
            if($this->db->trans_status() == false){
                throw new Exception('error registering bitacora transfer');
            }
    
            return $resultID;
    }

    public function getTransfers($clientID, $filters, $pagination = null){
        $query = "SELECT transfer.id, 
        transfer.idClienteSalida as fromClientID, fromClient.cuenta as fromClient,
        transfer.idClienteEntrada as toClientID, toClient.cuenta as toClient, 
        transfer.idTipoTransferencia as typeID, transferType.tipo as type,
        transfer.idEstadoTransferencia as stateID, transferState.estado as state,
        UNIX_TIMESTAMP(transfer.fechaCreacion) as creationTimestamp, transfer.notas as notes,
        CASE 
            WHEN transfer.idClienteEntrada = ${clientID} THEN
            1
            ELSE
            0
        END as isReceivedTransfer

        FROM t_transferencias as transfer
        
        INNER JOIN t_clientes as fromClient
        on fromClient.id = transfer.idClienteSalida
        
        INNER JOIN t_clientes as toClient
        on toClient.id = transfer.idClienteEntrada
        
        INNER JOIN cat_tipo_transferencia as transferType
        on transferType.id = transfer.idTipoTransferencia
        
        INNER JOIN cat_estado_transferencia as transferState
        on transferState.id = transfer.idEstadoTransferencia
        WHERE ";

        $query .= implode(" AND ", $filters->conditions);
        $query .= " ORDER BY transfer.fechaCreacion DESC";

        if( isset($pagination))
            $query .= "LIMIT {$pagination->pagination}, {$pagination->limit}";

        $result = $this->db->query($query, $filters->parameters)->result();
        return $result;
    }

    public function getTransfer($transferID, $clientID){
        $transfer = new \stdClass();
        
        //Obtener datos de la transferencia
        $query = "SELECT transfer.id, 
        transfer.idClienteSalida as fromClientID, fromClient.cuenta as fromClient,
        transfer.idClienteEntrada as toClientID, toClient.cuenta as toClient,
        transfer.idTipoTransferencia as typeID, transferType.tipo as type,
        transfer.idEstadoTransferencia as stateID, transferState.estado as state,UNIX_TIMESTAMP(transfer.fechaCreacion) as creationTimestamp,
        transfer.notas as notes,
        CASE 
            WHEN transfer.idClienteEntrada = ${clientID} THEN
            1
            ELSE
            0
        END as isReceivedTransfer
        
        FROM t_transferencias as transfer
                
        INNER JOIN t_clientes as fromClient
        on fromClient.id = transfer.idClienteSalida
                
        INNER JOIN t_clientes as toClient
        on toClient.id = transfer.idClienteEntrada
                
        INNER JOIN cat_tipo_transferencia as transferType
        on transferType.id = transfer.idTipoTransferencia
                
        INNER JOIN cat_estado_transferencia as transferState
        on transferState.id = transfer.idEstadoTransferencia 
        WHERE transfer.id = ${transferID} ";

        if(!empty($clientID))
            $query .= "AND (transfer.idClienteSalida = ${clientID} or transfer.idClienteEntrada = ${clientID})";

        $result = $this->db->query($query)->result();
        
        if(count($result) > 0){
            $transfer = $result[0];

            //Obtener productos de la transferencia
            $query = "SELECT transferID, typeID, type, stateID, state, productID, serie, factoryID, factory, modelID, model
            FROM
            (
                SELECT products.idTransferencia as transferID,
            productType.id as typeID, productType.tipo as type,
            productState.id as stateID, productState.estado as state,
            device.id as productID, device.imei as serie,
            factory.id as factoryID, factory.marca as factory,
            model.id as modelID, model.modelo as model
            
                FROM t_transferencia_relacion_productos as products
                INNER JOIN cat_tipo_producto as productType
                on productType.id = products.idTipoProducto
                INNER JOIN cat_estado_transferencia_producto as productState
                on productState.id = products.idEstadoTransferenciaProducto
                INNER JOIN t_dispositivos as device
                on device.id = products.idProducto
                INNER JOIN cat_modelo_producto as model
                on model.id = device.idModelo
                INNER JOIN cat_marca_producto as factory
                on factory.id = model.idMarca
                WHERE products.idTipoProducto = 1
                
            UNION
                
                SELECT products.idTransferencia as transferID,
            productType.id as typeID, productType.tipo as type,
            productState.id as stateID, productState.estado as state,
            sim.id as productID, sim.telefono as serie,
            carrier.id as factoryID, carrier.nombre as factory,
            NULL as modelID, NULL as model
            
                FROM t_transferencia_relacion_productos as products
                INNER JOIN cat_tipo_producto as productType
                on productType.id = products.idTipoProducto
                INNER JOIN cat_estado_transferencia_producto as productState
                on productState.id = products.idEstadoTransferenciaProducto
                INNER JOIN t_sims as sim
                on sim.id = products.idProducto
                INNER JOIN cat_compañiastelefonicas as carrier
                on carrier.id = sim.idCompañiaTelefonica
            
                WHERE products.idTipoProducto = 2
                
            UNION
                
                SELECT products.idTransferencia as transferID,
            productType.id as typeID, productType.tipo as type,
            productState.id as stateID, productState.estado as state,
            generic.id as productID, generic.serie as serie,
            factory.id as factoryID, factory.marca as factory,
            model.id as modelID, model.modelo as model
            
                FROM t_transferencia_relacion_productos as products
                INNER JOIN cat_tipo_producto as productType
                on productType.id = products.idTipoProducto
                INNER JOIN cat_estado_transferencia_producto as productState
                on productState.id = products.idEstadoTransferenciaProducto
                INNER JOIN t_producto_generico as generic
                on generic.id = products.idProducto
                INNER JOIN cat_modelo_producto as model
                on model.id = generic.idModelo
                INNER JOIN cat_marca_producto as factory
                on factory.id = model.idMarca
                WHERE products.idTipoProducto = 3
            ) AS result
            where transferID = ${transferID}
            ORDER BY typeID";
            
            $transfer->products = (array) $this->db->query($query)->result();

            return $transfer;
        }
        else
            return null;    
    }

    public function getActions($transferID){
        $query = "SELECT client.id as clientID, client.cuenta as client, 
        users.id as userID, users.usuario as user,
        action.id as actionID, action.accion as action,
        bitacora.notas as notes,
        UNIX_TIMESTAMP(bitacora.fechaCreacion) as creationTimestamp
        FROM t_transferencia_bitacora as bitacora
        INNER JOIN cat_bitactora_tranferencia_tipoaccion as action
        on action.id = bitacora.idAccion
        INNER JOIN t_usuarios as users
        on users.id = bitacora.idUsuario
        INNER JOIN t_clientes as client
        on client.id = users.idCliente
        WHERE idTransferencia = ${transferID}
        ORDER BY bitacora.fechaCreacion DESC";

        return $this->db->query($query)->result();

    }

    public function getOwnerID($transferID){
        $query = "SELECT idClienteSalida  FROM t_transferencias
        WHERE id = ${transferID}";

        $result = $this->db->query($query)->result();
        if(count($result) > 0)
            return $result[0]->idClienteSalida;
        else
            return null;
    }

    public function getTransferState($transferID){
        $query = "SELECT idEstadoTransferencia  FROM t_transferencias
        WHERE id = ${transferID}";

        $result = $this->db->query($query)->result();
        if(count($result) > 0)
            return $result[0]->idEstadoTransferencia;
        else
            return null;
    }

    public function setTransferState($transferID, $state){
        $this->db->trans_start();

        $query = "UPDATE t_transferencias 
        SET idEstadoTransferencia = ${state} 
        WHERE id = ${transferID}";

        $this->db->query($query);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error update transfer state');
        }
    }

    public function setStateAllProducts($transferID, $state){
        $this->db->trans_start();

        $query = "UPDATE t_transferencia_relacion_productos
        SET idEstadoTransferenciaProducto = ${state}
        WHERE idTransferencia = ${transferID}";

        $this->db->query($query);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error update transfer state');
        }
    }

    public function setTransferProductState($transferID, $products){
        $this->db->trans_start();

        foreach ($products as $product) {
            $query = "UPDATE t_transferencia_relacion_productos
            SET idEstadoTransferenciaProducto = {$product->state}
            WHERE idTransferencia = ${transferID} 
            and idTipoProducto = {$product->type}
            and idProducto = {$product->id}";

            $this->db->query($query);
        }

        
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error update transfer state');
        }
    }

    public function getTargetClient($transferID){
        $query = "SELECT idClienteEntrada  FROM t_transferencias
        WHERE id = ${transferID}";

        $result = $this->db->query($query)->result();
        if(count($result) > 0)
            return $result[0]->idClienteEntrada;
        else
            return null;
    }

    public function getAcceptedProducts($transferID){
        $query = "SELECT idProducto as id, idTipoProducto as type 
        FROM t_transferencia_relacion_productos
        where idTransferencia = ${transferID} and idEstadoTransferenciaProducto = 2";

        return $this->db->query($query)->result();
    }

    public function closeTransfer($transferID){
        $this->db->trans_start();

        //Establecer transferencia como cerrada
        $query = "UPDATE t_transferencias 
        SET idEstadoTransferencia = 2
        WHERE id = ${transferID}";

        $this->db->query($query);

        //Marcar todo producto como cancelado, por si algo llega a fallar
        $query = "UPDATE t_transferencia_relacion_productos
        SET idEstadoTransferenciaProducto = 3
        WHERE idTransferencia = ${transferID}";

        $this->db->query($query);
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error update transfer state');
        }

    }
}