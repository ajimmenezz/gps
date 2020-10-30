<?php
namespace Models;
use \Exception as Exception;

class DataBaseCatalogs extends DataBase{

    public function getTimezones(){
        $query = "SELECT id, nombre as name, zonahoraria as timezone from timezones order by nombre desc";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getMarkers(){
        $query = "SELECT id, nombre as name from cat_tipomarcador
        WHERE estatus = 1
        order by nombre asc";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }


    public function getLegalStatus(){
        $query = "SELECT id, nombre as name from cat_estatuslegal
        WHERE estatus = 1
        order by nombre asc";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getDeviceFactories(){
        $query = "SELECT marca.id, marca.marca as factory FROM cat_marca_producto as marca
        INNER JOIN cat_modelo_producto as modelo
        on modelo.idMarca = marca.id
        where modelo.idTipoProducto = 1 and marca.estatus = 1 and modelo.estatus = 1
        GROUP BY marca.marca ORDER BY marca.marca asc";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getDeviceModels($factoryID){
        $query = "SELECT id, modelo.modelo as model FROM cat_modelo_producto as modelo
        where modelo.idTipoProducto = 1 and modelo.estatus = 1 and modelo.idMarca = {$factoryID}
        GROUP BY modelo.modelo ORDER BY modelo.modelo asc";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getSimCarriers(){
        $query = "SELECT id, nombre as name from cat_compañiastelefonicas
        WHERE estatus = 1
        order by nombre asc";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }


    public function getPeopleTypes(){
        $query = "SELECT id, nombre as name from cat_tipopersona
        WHERE estatus = 1
        order by nombre asc";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getSimPlans(){
        $query = "SELECT id, nombre as name from cat_sims_planes
        WHERE estatus = 1
        order by nombre asc";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getProductFactories($productType = null){

        $whereProductType = "";
        if(empty($productType))
            $whereProductType = "ANY (SELECT id from cat_tipo_producto)";
        else
            $whereProductType = $productType;


        $query = "SELECT factory.id, factory.marca as 'name', 
        model.idTipoProducto as productType, productType.tipo as productTypeName
        FROM cat_marca_producto as factory
        
        INNER JOIN cat_modelo_producto as model
        ON factory.id = model.idMarca
        
        INNER JOIN cat_tipo_producto as productType
        on productType.id = model.idTipoProducto
        
        WHERE factory.estatus = 1 AND model.idTipoProducto = ${whereProductType}
        GROUP BY factory.id
        ORDER BY factory.marca";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    //Esta funcion es temporal, la intencion sera migrar el catalogo de sims a la de marcas generales
    public function getProductFactoriesSims(){
        $query = "select id, nombre as name from cat_compañiastelefonicas
        where estatus = 1 
        ORDER BY nombre";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getProductModels($factoryID, $productType = null){
        $whereProductType = "";
        if(empty($productType))
            $whereProductType = "ANY (SELECT id from cat_tipo_producto)";
        else
            $whereProductType = $productType;

        $query = "SELECT model.id, model.modelo as 'name'
        FROM cat_modelo_producto as model
        WHERE model.estatus = 1 and model.idMarca = ${factoryID} and model.idTipoProducto = ${whereProductType}
        ORDER BY model.modelo ASC";

        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getProductStates(){
        $query = "Select id, estado as state from cat_producto_estado";
    
        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getProductTypes(){
        $query = "Select id, tipo as type from cat_tipo_producto
        where estatus = 1
        ORDER BY tipo";
    
        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getTransferTypes(){
        $query = "Select id, tipo as type from cat_tipo_transferencia
        where estatus = 1
        ORDER BY tipo";
    
        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

    public function getDeviceReportTypes(){
        $query = "Select tipoReporte as id, nombre as name 
        from cat_tiporeporte
        ORDER BY id";
    
        $resultSet = $this->db->query($query)->result();
        return $resultSet;
    }

}