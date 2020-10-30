<?php
namespace Models;

class DataBase {
    protected $db;
    public function __construct(){
        $this->db = get_instance()->load->database('universal_test', true);
    }

    protected function getPartitionReportByImei($deviceImei)
    {
        $query = "select concat('p',id) as partit from t_dispositivos where imei = '${deviceImei}'";
        return $this->db->query($query)->result()[0]->partit;
    }
}