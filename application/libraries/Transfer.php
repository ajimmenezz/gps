<?php
namespace Libraries;

use Models\DataBaseTransfer;
use Libraries\Utils;

use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

use Libraries\Store;

class Transfer{
    private $databaseTransfer;

    public function __construct(){
        $this->databaseTransfer = new DataBaseTransfer();
    }

    public function createTransfer($transfer){
        return $this->databaseTransfer->createTransfer($transfer);
    }

    public function recordAction($data){
        try{
            $this->databaseTransfer->recordAction($data);
        }
        catch(Exception $err){}
    }

    public function getTransfers($data){
        $params = $this->getTransfersFilter($data);
        // return $params;
    
        $pagination = new \stdClass();
        if(!isset($data->pagination) || !is_numeric($data->pagination))
            $pagination->pagination = 0;
        else
            $pagination->pagination = $data->pagination;
        

        if(!isset($data->limit) || !is_numeric($data->limit))
            $pagination = null;
        else
            $pagination->limit = $data->limit;


        return $this->databaseTransfer->getTransfers($data->clientIDA, $params, $pagination);
    }
    private function getTransfersFilter($data){
        $conditions = [];
        $parameters = [];

        $conditions[] = "1 = ?";
        $parameters[] = "1";

        if(property_exists($data, "clientIDA") && !empty($data->clientIDA)){
            $conditions[] = "(idClienteSalida = ? or idClienteEntrada = ?)";
            $parameters[] = $data->clientIDA;
            $parameters[] = $data->clientIDA;
        }

        if(property_exists($data, "clientIDB") && !empty($data->clientIDB)){
            $conditions[] = "(idClienteSalida = ? or idClienteEntrada = ?)";
            $parameters[] = $data->clientIDB;
            $parameters[] = $data->clientIDB;
        }

        if(property_exists($data, "fromTimestamp") && !empty($data->fromTimestamp)){
            $conditions[] = "fechaCreacion >= ?";
            $parameters[] = $data->fromTimestamp;
        }

        if(property_exists($data, "toTimestamp") && !empty($data->toTimestamp)){
            $conditions[] = "fechaCreacion <= ?";
            $parameters[] = $data->toTimestamp;  
        }

        if(property_exists($data, "transferTypes") && !empty($data->transferTypes)){
            $conditions[] = "idTipoTransferencia IN ?";
            $parameters[] = $data->transferTypes;
        }

        if(property_exists($data, "transferStates") && !empty($data->transferStates)){
            $conditions[] = "idEstadoTransferencia IN ?";
            $parameters[] = $data->transferStates;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    public function getTransfer($transferID, $clientID = null){
        $transfer = new \stdClass();
        $transfer = $this->databaseTransfer->getTransfer($transferID, $clientID);

        if(empty($transfer))
            throw new Exception("Tranferencia Invalida");
        
        
        $transfer->bitacora = $this->databaseTransfer->getActions($transferID);
        return $transfer;
    }

    public function isOwner($transferID, $clientID){
        $ownerID = $this->databaseTransfer->getOwnerID($transferID);

        if($ownerID == $clientID)
            return true;
        else
            return false;
    }

    public function getTargetClient($transferID){
        return $this->databaseTransfer->getTargetClient($transferID);
    }

    public function getTransferState($transferID){
        return $this->databaseTransfer->getTransferState($transferID);
    }

    public function cancelTransfer($transferID){
       $this->databaseTransfer->setTransferState($transferID, 3);
       $this->databaseTransfer->setStateAllProducts($transferID, 4);
    }

    public function cancelAllTransfers($clientID){
        $params = new \stdClass();
        $params->clientIDA = $clientID;
        $params->transferStates = [1];
        $transfers = $this->getTransfers($params);
        
        foreach ($transfers as $transfer) {
            $this->cancelTransfer($transfer->id);
        }
        return $transfers;
    }

    public function closeTransfer($transferID, $products){
        $store = new Store();

        $toClient = $this->getTargetClient($transferID);
        $this->databaseTransfer->closeTransfer($transferID);

        if(count($products)>0)
        {
            foreach ($products as $product) {
                if(!isset($product->state) || !is_numeric($product->state) || empty($product->state) || ($product->state != 2 && $product->state != 3))
                    $product->state = 3;
            }
    
            //Cambiamos el estado de transferencia de los productos que si fueron aceptados
            $this->databaseTransfer->setTransferProductState($transferID, $products);
            
            $acceptedProducts = $this->databaseTransfer->getAcceptedProducts($transferID);
            if(count($acceptedProducts)>0)
                $store->transferProducts($toClient, $acceptedProducts);
        }
        
    }

}
