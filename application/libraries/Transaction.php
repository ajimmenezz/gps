<?php
namespace Libraries;

use Models\DataBaseTransaction;
use Libraries\Utils;

use \Exception as Exception;
use Libraries\HttpStatusCode;
use Libraries\HttpException;

class Transaction{
    private $databaseTransaction;

    public function __construct(){
        $this->databaseTransaction = new DataBaseTransaction();
    }

    public function registerTransaction($data){
        return $this->databaseTransaction->registerTransaction($data);
    }

    public function getTransactions($params){
        $filters = $this->buildTransactionFilter($params);

        return $this->databaseTransaction->getTransactions($filters);

    }
    private function buildTransactionFilter($data){
        $conditions = [];
        $parameters = [];
        /**
         * id, clientID, productType, factory, model, limit, pagination
         */
        
         if(property_exists($data, "clientID") && !empty($data->clientID)){
            $conditions[] = "(idClienteSalida = ? OR idClienteEntrada = ?)";
            $parameters[] = $data->clientID;
            $parameters[] = $data->clientID;  
        }

        if(property_exists($data, "type") && !empty($data->type)){
            $conditions[] = "idTipoTransaccion = ?";
            $parameters[] = $data->type;  
        }

        if(property_exists($data, "fromTimestamp") && !empty($data->fromTimestamp)){
            $conditions[] = "fechaTransaccion >= FROM_UNIXTIME(?)";
            $parameters[] = $data->fromTimestamp;
        }

        if(property_exists($data, "tillTimestamp") && !empty($data->tillTimestamp)){
            $conditions[] = "fechaTransaccion <= FROM_UNIXTIME(?)";
            $parameters[] = $data->tillTimestamp;
        }

        $result = new \StdClass();
        $result->conditions = $conditions;
        $result->parameters = $parameters;
        return $result;
    }

    public function getTransaction($transactionID){
        return $this->databaseTransaction->getTransaction($transactionID);
    }
}