<?php
namespace Models;
use Libraries\Utils;
use \Exception as Exception;

class DataBaseTransaction extends DataBase {
    public function __construct() {
        parent::__construct();
    }

    public function registerTransaction($data){
        $this->db->trans_start();

        //Registrar transaccion
        $query = "INSERT INTO t_transaccion
        (idClienteSalida, idClienteEntrada, idTipoTransaccion)
        VALUES
        ({$data->fromClientID}, {$data->toClientID}, {$data->transactionType})";

        $this->db->query($query);

        $transactionID = $this->db->insert_id();

        //Registrar productos involucrados en la transaccion
        $query = "INSERT INTO t_transaccion_relacion_productos
        (idTransaccion, idTipoProducto, idProducto, idKit)
        VALUES ";

        $values = array();
        foreach($data->products as $product){
            if(!isset($product->kitID) || empty($product->kitID))
                $product->kitID = 'NULL';

            $values[] = "(${transactionID}, {$product->type}, {$product->id}, {$product->kitID})";
        }

        $query .= implode(',',$values);


        $this->db->query($query);

        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error creating product');
        }

        return $transactionID;


    }

    public function getTransactions($filters){
        $query = "SELECT trans.id,
        clientA.id as fromClientID, clientA.cuenta as fromClient,
        clientB.id as toClientID, clientB.cuenta as toClient, 
        transactionType.id transactionTypeID, transactionType.tipo as transactionType,
        UNIX_TIMESTAMP(trans.fechaTransaccion) as timestampTransaction
        
        FROM t_transaccion as trans
        
        INNER JOIN cat_tipo_transaccion as transactionType
        on transactionType.id = trans.idTipoTransaccion
        
        INNER JOIN t_clientes as clientA
        on clientA.id = trans.idClienteSalida
        
        INNER JOIN t_clientes as clientB
        on clientB.id = trans.idClienteEntrada
        
        WHERE 1=1 AND ";

        $query .= implode(" AND ", $filters->conditions);

        $query .= " ORDER BY trans.fechaTransaccion";

        $result = $this->db->query($query, $filters->parameters)->result();
        return $result;

    }

    public function getTransaction($transactionID){
        $query = "SELECT trans.id,
        clientA.id as fromClientID, clientA.cuenta as fromClient,
        clientB.id as toClientID, clientB.cuenta as toClient, 
        transactionType.id transactionTypeID, transactionType.tipo as transactionType,
        UNIX_TIMESTAMP(trans.fechaTransaccion) as timestampTransaction
        
        FROM t_transaccion as trans
        
        INNER JOIN cat_tipo_transaccion as transactionType
        on transactionType.id = trans.idTipoTransaccion
        
        INNER JOIN t_clientes as clientA
        on clientA.id = trans.idClienteSalida
        
        INNER JOIN t_clientes as clientB
        on clientB.id = trans.idClienteEntrada
        
        WHERE trans.id = ${transactionID}";

        $result = $this->db->query($query)->result()[0];

        $query = "SELECT productTypeID, productType, productID, product, factoryID, factory, modelID, model, kitID, kitName
        FROM 
        (
        /*Dispositivos*/
        SELECT productTransaction.idTransaccion as transactionID,
        productType.id as productTypeID, productType.tipo as productType,
        device.id as productID, device.imei as product,
        factory.id as factoryID, factory.marca as factory,
        model.id as modelID, model.modelo as model,
        kit.id as kitID, kit.nombre as kitName
        
        FROM t_dispositivos as device
        
        INNER JOIN t_transaccion_relacion_productos as productTransaction
        on productTransaction.idProducto = device.id
        
        INNER JOIN cat_tipo_producto as productType
        on productType.id = productTransaction.idTipoProducto
        
        INNER JOIN cat_modelo_producto as model
        on model.id = device.idModelo
        
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        
        LEFT JOIN t_kit as kit
        on kit.id = productTransaction.idKit
        
        where productTransaction.idTipoProducto = 1
        
        /*SIMS*/
        UNION
        SELECT productTransaction.idTransaccion as transactionID,
        productType.id as productTypeID, productType.tipo as productType,
        sims.id as productID, sims.telefono as product,
        carrier.id as factoryID, carrier.nombre as factory,
        null as modelID, null as model,
        kit.id as kitID, kit.nombre as kitName
        
        FROM t_sims as sims
        
        INNER JOIN t_transaccion_relacion_productos as productTransaction
        on productTransaction.idProducto = sims.id
        
        INNER JOIN cat_tipo_producto as productType
        on productType.id = productTransaction.idTipoProducto
        
        INNER JOIN `cat_compañiastelefonicas` as carrier
        on carrier.id = sims.`idCompañiaTelefonica`
        
        LEFT JOIN t_kit as kit
        on kit.id = productTransaction.idKit
        
        where productTransaction.idTipoProducto = 2
        
        /*Productos Genericos*/
        UNION
        SELECT productTransaction.idTransaccion as transactionID,
        productType.id as productTypeID, productType.tipo as productType,
        product.id as productID, product.serie as product,
        factory.id as factoryID, factory.marca as factory,
        model.id as modelID, model.modelo as model,
        kit.id as kitID, kit.nombre as kitName
        
        FROM t_producto_generico as product
        
        INNER JOIN t_transaccion_relacion_productos as productTransaction
        on productTransaction.idProducto = product.id
        
        INNER JOIN cat_tipo_producto as productType
        on productType.id = productTransaction.idTipoProducto
        
        INNER JOIN cat_modelo_producto as model
        on model.id = product.idModelo
        
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        
        LEFT JOIN t_kit as kit
        on kit.id = productTransaction.idKit
        
        where productTransaction.idTipoProducto = 3
        ) as result
        
        where transactionID = ${transactionID}";

        $result->products = $this->db->query($query)->result();

        return $result;
    }
}