<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $Lab_test_id;
    public $Available;

	public function __construct(){
		$db = new config();
        $this->db = $db->getConnection();
        if(!isset($_SESSION)) { session_start(); } 
    }

    private function fetch_all($query){
        $data = [];
        while($row = $query->fetch_assoc()){
            array_push($data,(object) $row);
        }
        return $data;
    }

    private function first_row($query){
        $data = (object) $query->fetch_assoc();
        return $data;   
    }

    public function get_template(){
        $query = $this->db->query("SELECT Json
        FROM lab_test_template ");

        if(!$query){
            return $this->db->error;
        }

        return $this->first_row($query);
    }

    public function get_request_lab_transaction(){
        $query = $this->db->query("SELECT 
        `lab_transaction`.ID AS Lab_transaction_id,
        `lab_transaction`.*,
        `lab_transaction_status`.*,
        `lab_test`.*,
        `patient`.*,
        `mode_of_test`.*,
        `lab_package_test`.*
        FROM lab_transaction 
        LEFT JOIN `lab_package_test` ON `lab_package_test`.ID=`lab_transaction`.Lab_package_test_id
        LEFT JOIN `patient` ON `patient`.ID=`lab_transaction`.Patient_id
        LEFT JOIN `mode_of_test` ON `mode_of_test`.ID=`lab_transaction`.Mode_of_test_id
        LEFT JOIN `lab_transaction_status` ON `lab_transaction_status`.ID=`lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `lab_test` ON `lab_test`.ID=`lab_transaction`.Lab_test_id
        WHERE `lab_transaction`.Lab_transaction_status_id=1 ORDER BY `lab_transaction`.Mode_of_test_id ASC ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }

    public function get_ongoing_lab_transaction(){
        $query = $this->db->query("SELECT 
        `lab_transaction`.ID AS Lab_transaction_id,
        `lab_transaction`.*,
        `lab_transaction_status`.*,
        `lab_test`.*,
        `patient`.*,
        `mode_of_test`.*,
        `lab_package_test`.*
        FROM lab_transaction 
        LEFT JOIN `lab_package_test` ON `lab_package_test`.ID=`lab_transaction`.Lab_package_test_id
        LEFT JOIN `patient` ON `patient`.ID=`lab_transaction`.Patient_id
        LEFT JOIN `mode_of_test` ON `mode_of_test`.ID=`lab_transaction`.Mode_of_test_id
        LEFT JOIN `lab_transaction_status` ON `lab_transaction_status`.ID=`lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `lab_test` ON `lab_test`.ID=`lab_transaction`.Lab_test_id
        WHERE `lab_transaction`.Lab_transaction_status_id=2 ORDER BY `lab_transaction`.Mode_of_test_id ASC ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

    public function get_release_lab_transaction(){
        $query = $this->db->query("SELECT 
        `lab_transaction`.ID AS Lab_transaction_id,
        `lab_transaction`.*,
        `lab_transaction_status`.*,
        `lab_test`.*,
        `patient`.*,
        `mode_of_test`.*,
        `lab_package_test`.*
        FROM lab_transaction 
        LEFT JOIN `lab_package_test` ON `lab_package_test`.ID=`lab_transaction`.Lab_package_test_id
        LEFT JOIN `patient` ON `patient`.ID=`lab_transaction`.Patient_id
        LEFT JOIN `mode_of_test` ON `mode_of_test`.ID=`lab_transaction`.Mode_of_test_id
        LEFT JOIN `lab_transaction_status` ON `lab_transaction_status`.ID=`lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `lab_test` ON `lab_test`.ID=`lab_transaction`.Lab_test_id
        WHERE `lab_transaction`.Lab_transaction_status_id=3 ORDER BY `lab_transaction`.Mode_of_test_id ASC ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

    public function get_pickup_lab_transaction(){
        $query = $this->db->query("SELECT 
        `lab_transaction`.ID AS Lab_transaction_id,
        `lab_transaction`.*,
        `lab_transaction_status`.*,
        `lab_test`.*,
        `patient`.*,
        `mode_of_test`.*,
        `lab_package_test`.*
        FROM lab_transaction 
        LEFT JOIN `lab_package_test` ON `lab_package_test`.ID=`lab_transaction`.Lab_package_test_id
        LEFT JOIN `patient` ON `patient`.ID=`lab_transaction`.Patient_id
        LEFT JOIN `mode_of_test` ON `mode_of_test`.ID=`lab_transaction`.Mode_of_test_id
        LEFT JOIN `lab_transaction_status` ON `lab_transaction_status`.ID=`lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `lab_test` ON `lab_test`.ID=`lab_transaction`.Lab_test_id
        WHERE `lab_transaction`.Lab_transaction_status_id=4 ORDER BY `lab_transaction`.Mode_of_test_id ASC ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

     
    public function get_lab_test(){

        $query = $this->db->query("SELECT * FROM lab_test ");
        
        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }


    public function supply_status(){


        $supply_status = ($this->Available==1)? 0  : 1  ;

        $query = $this->db->query("UPDATE lab_test SET Available=$supply_status
        WHERE `lab_test`.ID='$this->Lab_test_id'");

        if(!$query){
        return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);

    }








}


?>