<?php
namespace Models;
use Libraries\Utils;

class DataBaseProduct extends DataBase {
    public function __construct() {
        parent::__construct();
    }

    public function createProduct($data){
        $this->db->trans_start();

        $query = "INSERT INTO t_producto_generico
        (idCliente, idModelo, idEstadoProducto, serie, fechaCreacion, descripcion, estatus)
        VALUES
        ({$data->clientID},{$data->model},{$data->productStatus}, '{$data->serial}', CURRENT_TIMESTAMP(), '{$data->notes}', 1)";
       
        $this->db->query($query);

        $productID = $this->db->insert_id();
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error creating product');
        }

        return $productID;

    }

    public function serialExists($serial){
        $query = "SELECT EXISTS(
            SELECT serie 
            FROM t_producto_generico 
            WHERE serie	= '${serial}') as 'exists'";
        
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0]->exists;
    }

    public function getClientID($productID){
        $query = "SELECT 
        product.idCliente
        FROM t_producto_generico as product
        WHERE product.id = ${productID}";
        
        $resultSet = $this->db->query($query)->result();
        if(count($resultSet) > 0)
            return $resultSet[0]->idCliente;
        else   
            throw new Exception("ProductID Not exists");
    }

    public function getProduct($productID){
        $query = "SELECT 
        product.id, product.idCliente as clientID, product.serie as 'serial',
        factory.id as factoryID, product.idModelo as modelID, 
        factory.marca as factoryName, model.modelo as modelName, 
        product.idEstadoProducto as productStatusID, productStatus.estado as productStatusName, product.descripcion as notes,
        TRUNCATE(UNIX_TIMESTAMP(product.fechaCreacion),0) as creationTimestamp
        FROM t_producto_generico as product
        
        INNER JOIN cat_modelo_producto as model
        on model.id = product.idModelo
        
        INNER JOIN cat_producto_estado as productStatus
        on productStatus.id = product.idEstadoProducto
        
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        
        WHERE product.id = ${productID}";
        
        $resultSet = $this->db->query($query)->result();
        return $resultSet[0];
    }

    public function getProducts($clientID){
        $query = "SELECT 
        product.id, product.idCliente as clientID, product.serie as 'serial',
        factory.id as factoryID, product.idModelo as modelID, 
        factory.marca as factoryName, model.modelo as modelName, 
        product.idEstadoProducto as productStatusID, productStatus.estado as productStatusName, product.descripcion as notes,
        TRUNCATE(UNIX_TIMESTAMP(product.fechaCreacion),0) as creationTimestamp
        FROM t_producto_generico as product
        
        INNER JOIN cat_modelo_producto as model
        on model.id = product.idModelo
        
        INNER JOIN cat_producto_estado as productStatus
        on productStatus.id = product.idEstadoProducto
        
        INNER JOIN cat_marca_producto as factory
        on factory.id = model.idMarca
        
        WHERE product.idCliente = ${clientID} and product.estatus = 1";
        
        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function updateProduct($productID, $params){
        if(count($params->conditions) > 0){
            $this->db->trans_start();

            $query = "UPDATE t_producto_generico";
            $query .= " SET ".implode(" ,", $params->conditions);
            $query .= " WHERE id = ${productID}"; 
    
            $this->db->query($query, $params->parameters);
            $this->db->trans_complete();
    
            if($this->db->trans_status() == false){
                throw new Exception('error updating product');
            }
        }   

    }

    public function deleteProduct($productID){
        $query = "UPDATE t_producto_generico
        SET estatus = -1
        WHERE id = ${productID}";
      
        $this->db->query($query);
        $this->db->trans_complete();
    
        if($this->db->trans_status() == false){
            throw new Exception('error deleting product');
        }
    }

    public function setOwner($clientID, $productID){
        $this->db->trans_start();

        $query = "UPDATE t_producto_generico
        set idCliente = ${clientID}
        where id = ${productID}";

        $this->db->query($query);

        
        $this->db->trans_complete();

        if($this->db->trans_status() == false){
            throw new Exception('error actualizar el propietario del producto');
        }

        return true;
    }

    public function deleteClientProducts($clientID){
        $query = "UPDATE t_producto_generico
        SET estatus = -1
        WHERE idCliente = ${clientID}";
      
        $this->db->query($query);
        $this->db->trans_complete();
    
        if($this->db->trans_status() == false){
            throw new Exception('error deleting product');
        }
    }

    
}//End of class
