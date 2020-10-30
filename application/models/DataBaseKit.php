<?php
namespace Models;
use Libraries\Utils;
use \Exception as Exception;

class DataBaseKit extends DataBase {
    public function __construct() {
        parent::__construct();
    }

    public function createKit($data){
        $this->db->trans_start();

        //CREATE KIT TEMPLATE
        $query = "INSERT INTO t_kit
        (idCliente, nombre, notas, estatus)
        VALUES
        ({$data->clientID}, '{$data->name}', '{$data->notes}', 1)";
        $this->db->query($query);

        $kitID = $this->db->insert_id();

        // ADD PRODUCTS TO KIT TEMPLATE
        $query = "INSERT INTO t_plantilla_kit
        (idKit, idTipoProducto, idModeloProducto, cantidad)
        VALUES ";

        $values = array();
        foreach($data->products as $row){
            $values[] = "(${kitID}, {$row->productType}, {$row->model}, {$row->quantity})";
        }

        $query .= implode(',',$values);

        
        $this->db->query($query);

        
        
        $this->db->trans_complete();
        if($this->db->trans_status() == false){
            throw new Exception('error creating kit');
        }

        return $kitID;
    }

    public function isOwner($clientID, $kitID){
        $query = "SELECT EXISTS (SELECT id FROM t_kit WHERE id = ${kitID} and idCliente = ${clientID}) as 'exists'";
        $result = $this->db->query($query)->result(); 
        if($result[0]->exists == 1)
            return true;
        else
            return false;
    }

    public function getKit($kitID){
        $kit = new \StdClass();

        $query = "SELECT kit.id, kit.nombre as kitName, kit.idCliente as clientID, 
        UNIX_TIMESTAMP(kit.fechaCreacion) as creationTimestamp,
        kit.notas as notes
        FROM t_kit as kit
        WHERE kit.id = ${kitID} and estatus = 1";
        
        $result = $this->db->query($query)->result();
        if(count($result) > 0)
        {
            $kit = $result[0];

            $query = "SELECT kit.id, 
            product.id as productTypeID, product.tipo as productType,
            model.id as modelID, model.modelo as model,
            factory.id as factoryID, factory.marca as factory,
            kit.cantidad as quantity
            FROM t_plantilla_kit as kit
            INNER JOIN cat_tipo_producto as product
            on product.id = kit.idTipoProducto
            INNER JOIN cat_modelo_producto as model
            on model.id = kit.idModeloProducto
            INNER JOIN cat_marca_producto as factory
            on factory.id = model.idMarca
            WHERE kit.idKit = ${kitID}";

            $kit->products = $this->db->query($query)->result();
            
            return $kit;
        }
        else   
            throw new Exception("Kit not exists");

    }

    public function getKits($clientID){
        $kit = new \StdClass();

        $query = "SELECT kit.id, kit.nombre as kitName, kit.idCliente as clientID, 
        UNIX_TIMESTAMP(kit.fechaCreacion) as creationTimestamp,
        kit.notas as notes
        FROM t_kit as kit
        WHERE kit.idCliente = ${clientID} and estatus = 1";
        
        $result = $this->db->query($query)->result();
        return $result;
    }

    public function delete($kitID){
        $this->db->trans_start();

        //CREATE KIT TEMPLATE
        $query = "UPDATE t_kit
        SET estatus = 0
        WHERE id = ${kitID}";

        $this->db->query($query);

        $this->db->trans_complete();
        if($this->db->trans_status() == false){
            throw new Exception('error updating kit');
        }

        return true;
    }

    public function removeAllProducts($kitID){
        $this->db->trans_start();

        //CREATE KIT TEMPLATE
        $query = "DELETE FROM t_plantilla_kit
        WHERE idKit = ${kitID}";

        $this->db->query($query);

        $this->db->trans_complete();
        if($this->db->trans_status() == false){
            throw new Exception('error updating kit');
        }

        return true;
    }

    public function addProducts($kitID, $products){
        $this->db->trans_start();

        // ADD PRODUCTS TO KIT TEMPLATE
        $query = "INSERT INTO t_plantilla_kit
        (idKit, idTipoProducto, idModeloProducto, cantidad)
        VALUES ";

        $values = array();
        foreach($products as $row){
            $values[] = "(${kitID}, {$row->productType}, {$row->model}, {$row->quantity})";
        }

        $query .= implode(',',$values);

        
        $this->db->query($query);

        
        
        $this->db->trans_complete();
        if($this->db->trans_status() == false){
            throw new Exception('error creating kit');
        }
    }

    public function update($kitID, $params){
        if(count($params->conditions) > 0){
            $this->db->trans_start();

            $query = "UPDATE t_kit";
            $query .= " SET ".implode(" ,", $params->conditions);
            $query .= " WHERE id = ${kitID}"; 
    
            $this->db->query($query, $params->parameters);
            $this->db->trans_complete();
    
            if($this->db->trans_status() == false){
                throw new Exception('error updating product');
            }
        }   
    }

}//End of class