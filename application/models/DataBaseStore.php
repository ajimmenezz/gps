<?php
namespace Models;
use Libraries\Utils;
use \Exception as Exception;

class DataBaseStore extends DataBase {
    public function __construct() {
        parent::__construct();
    }

    public function getSummary($clientID, $status = 1){
        $query = "SELECT productTypeID, productType, factoryID, factory, modelID, model, quantity
        FROM
        (Select productType.id as productTypeID, productType.tipo as 'productType', 
        factory.id as factoryID, factory.marca as factory,
        model.id as modelID, model.modelo as model, 
        count(device.idModelo) as quantity
        
        FROM t_dispositivos as device
        
        INNER JOIN cat_modelo_producto as model
        on model.id = device.idModelo
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 1
        
        where device.idCliente = ${clientID} AND device.estatus = ${status}
        GROUP BY device.idModelo
        
        UNION 
        
        SELECT productType.id as productTypeID, productType.tipo as 'productType', 
        carrier.id as factoryID, carrier.nombre as factory, 
        null as modelID, null as model, 
        count(sim.idCompañiaTelefonica) as quantity
        
        FROM t_sims as sim
        INNER JOIN cat_compañiastelefonicas as carrier
        on carrier.id = sim.idCompañiaTelefonica
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 2
        where sim.idCliente = ${clientID} and sim.estatus = ${status}
        GROUP BY sim.idCompañiaTelefonica
        
        UNION
        
        Select productType.id as productTypeID, productType.tipo as 'productType',
        factory.id as factoryID, factory.marca as factory,
        model.id as modelID, model.modelo as model, 
        count(product.idModelo) as quantity
        from t_producto_generico as product
        
        INNER JOIN cat_modelo_producto as model
        on model.id = product.idModelo
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 3
        
        where product.idCliente = ${clientID} and product.estatus = ${status}
        GROUP BY product.idModelo
        ) as result
        ORDER BY productType";
        
        $result = $this->db->query($query)->result();
        return $result;
    }

    public function getProducts($clientID, $params, $pagination){
        $status = 1;

        $query = "SELECT id, productID, productTypeID, productType, factoryID, factory, modelID, model
        FROM
        (Select device.imei as id, device.id as productID, productType.id as productTypeID, productType.tipo as 'productType', 
        factory.id as factoryID, factory.marca as factory,
        model.id as modelID, model.modelo as model
        
        FROM t_dispositivos as device
        
        INNER JOIN cat_modelo_producto as model
        on model.id = device.idModelo
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 1
        
        where device.idCliente = ${clientID} AND device.estatus = ${status}
        
        UNION 
        
        SELECT sim.telefono as id, sim.id as productID, productType.id as productTypeID, productType.tipo as 'productType', 
        carrier.id as factoryID, carrier.nombre as factory, 
        null as modelID, null as model
        
        FROM t_sims as sim
        INNER JOIN cat_compañiastelefonicas as carrier
        on carrier.id = sim.idCompañiaTelefonica
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 2
        where sim.idCliente = ${clientID} and sim.estatus = ${status}
        
        UNION
        
        Select product.serie as id, product.id as productID, productType.id as productTypeID, productType.tipo as 'productType',
        factory.id as factoryID, factory.marca as factory,
        model.id as modelID, model.modelo as model
        from t_producto_generico as product
        
        INNER JOIN cat_modelo_producto as model
        on model.id = product.idModelo
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 3
        
        where product.idCliente = ${clientID} and product.estatus = ${status}
        ) as result
        WHERE ".implode(" AND ", $params->conditions)." 
        ORDER BY productType ";

        if( isset($pagination->limit) == true ){
            $query .= " LIMIT {$pagination->pagination}, {$pagination->limit}";
        }

       return $this->db->query($query, $params->parameters)->result();
    }

    public function getProductsWithoutTransferring($clientID, $params, $pagination){
        $status = 1;

        $query = "SELECT id, productID, productTypeID, productType, factoryID, factory, modelID, model
        FROM
        (Select device.imei as id, device.id as productID, productType.id as productTypeID, productType.tipo as 'productType', 
        factory.id as factoryID, factory.marca as factory,
        model.id as modelID, model.modelo as model
        
        FROM t_dispositivos as device
        
        INNER JOIN cat_modelo_producto as model
        on model.id = device.idModelo
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 1
        
        where device.idCliente = ${clientID} AND device.estatus = ${status}
        and device.id NOT IN (
					SELECT idProducto FROM t_transferencia_relacion_productos
					WHERE idTipoProducto = 1 and idEstadoTransferenciaProducto = 1
				)
        
        UNION 
        
        SELECT sim.telefono as id, sim.id as productID, productType.id as productTypeID, productType.tipo as 'productType', 
        carrier.id as factoryID, carrier.nombre as factory, 
        null as modelID, null as model
        
        FROM t_sims as sim
        INNER JOIN cat_compañiastelefonicas as carrier
        on carrier.id = sim.idCompañiaTelefonica
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 2
        where sim.idCliente = ${clientID} and sim.estatus = ${status}
        and sim.id NOT IN (
					SELECT idProducto FROM t_transferencia_relacion_productos
					WHERE idTipoProducto = 2 and idEstadoTransferenciaProducto = 1
				)
        
        UNION
        
        Select product.serie as id, product.id as productID, productType.id as productTypeID, productType.tipo as 'productType',
        factory.id as factoryID, factory.marca as factory,
        model.id as modelID, model.modelo as model
        from t_producto_generico as product
        
        INNER JOIN cat_modelo_producto as model
        on model.id = product.idModelo
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        INNER JOIN cat_tipo_producto as productType
        on productType.id = 3
        
        where product.idCliente = ${clientID} and product.estatus = ${status}
        and product.id NOT IN (
					SELECT idProducto FROM t_transferencia_relacion_productos
					WHERE idTipoProducto = 3 and idEstadoTransferenciaProducto = 1
				)

        ) as result
        WHERE ".implode(" AND ", $params->conditions)." 
        ORDER BY productType ";

        if( isset($pagination->limit) == true ){
            $query .= " LIMIT {$pagination->pagination}, {$pagination->limit}";
        }

       return $this->db->query($query, $params->parameters)->result();
    }

    public function getProductOwner($productID, $productType){
        switch($productType){
            case 1: //GPS 
            $query = "SELECT idCliente FROM t_dispositivos WHERE id = ${productID}";
            break;

            case 2: //SIMS
                $query = "SELECT idCliente FROM t_sims WHERE id = ${productID}";
            break;

            case 3: //PRODUCTO GENERICO
                $query = "SELECT idCliente FROM t_producto_generico WHERE id = ${productID}";
            break;
        }


        $result = $this->db->query($query)->result();
        if(count($result) > 0){
            return $result[0]->idCliente;
        }
        else
            return null;
        
    }

    public function matchProducts($clientID, $products){

        //Agregar un item por default si array vacio, para evitar exception de where..IN() (es decir IN vacio / sin ningun dato)
        if(count($products->gps) == 0)
            $products->gps[] = -1;

        if(count($products->sims) == 0)
            $products->sims[] = -1;

        if(count($products->products) == 0)
            $products->products[] = -1;


        $query = "SELECT id, type, clientID
        FROM (
            SELECT device.id, 1 as type, device.idCliente as clientID
            FROM t_dispositivos as device
            WHERE device.id IN (".implode(", ", $products->gps ).")
            
            UNION
            
            SELECT sims.id, 2 as type, sims.idCliente as clientID
            FROM t_sims as sims
            WHERE sims.id IN (".implode(", ", $products->sims ).")
            
            UNION
            
            SELECT generic.id, 3 as type, generic.idCliente as clientID
            FROM t_producto_generico as generic
            WHERE generic.id IN (".implode(", ", $products->products ).")
        ) as result
        
        WHERE clientID = ${clientID}";

        return $this->db->query($query)->result();
    }
}