<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/config.php');
class query{


    public $Search;
    public $Add_position;
    public $Abbreviation;
    public $Description;
    public $Price;
    public $File_name;

    public $Package_name;
    public $Discount;
    public $Lab_test_id;

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

    public function get_position(){


        $query = $this->db->query("SELECT * FROM User_position ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }


    public function get_request_lab_transaction(){
        $query = $this->db->query("SELECT 
        `Lab_transaction`.ID AS Lab_transaction_id,
        `Lab_transaction`.*,
        `Lab_transaction_status`.*,
        `Lab_test`.*,
        `Patient`.*,
        `Mode_of_test`.*,
        `Lab_package_test`.*
        FROM Lab_transaction 
        LEFT JOIN `Lab_package_test` ON `Lab_package_test`.ID=`Lab_transaction`.Lab_package_test_id
        LEFT JOIN `Patient` ON `Patient`.ID=`Lab_transaction`.Patient_id
        LEFT JOIN `Mode_of_test` ON `Mode_of_test`.ID=`Lab_transaction`.Mode_of_test_id
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction_status`.ID=`Lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_transaction`.Lab_test_id
        WHERE `Lab_transaction`.Lab_transaction_status_id=1 ORDER BY `Lab_transaction`.Mode_of_test_id ASC ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }

    public function get_ongoing_lab_transaction(){
        $query = $this->db->query("SELECT 
        `Lab_transaction`.ID AS Lab_transaction_id,
        `Lab_transaction`.*,
        `Lab_transaction_status`.*,
        `Lab_test`.*,
        `Patient`.*,
        `Mode_of_test`.*,
        `Lab_package_test`.*
        FROM Lab_transaction 
        LEFT JOIN `Lab_package_test` ON `Lab_package_test`.ID=`Lab_transaction`.Lab_package_test_id
        LEFT JOIN `Patient` ON `Patient`.ID=`Lab_transaction`.Patient_id
        LEFT JOIN `Mode_of_test` ON `Mode_of_test`.ID=`Lab_transaction`.Mode_of_test_id
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction_status`.ID=`Lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_transaction`.Lab_test_id
        WHERE `Lab_transaction`.Lab_transaction_status_id=2 ORDER BY `Lab_transaction`.Mode_of_test_id ASC ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

    public function get_release_lab_transaction(){
        $query = $this->db->query("SELECT 
        `Lab_transaction`.ID AS Lab_transaction_id,
        `Lab_transaction`.*,
        `Lab_transaction_status`.*,
        `Lab_test`.*,
        `Patient`.*,
        `Mode_of_test`.*,
        `Lab_package_test`.*
        FROM Lab_transaction 
        LEFT JOIN `Lab_package_test` ON `Lab_package_test`.ID=`Lab_transaction`.Lab_package_test_id
        LEFT JOIN `Patient` ON `Patient`.ID=`Lab_transaction`.Patient_id
        LEFT JOIN `Mode_of_test` ON `Mode_of_test`.ID=`Lab_transaction`.Mode_of_test_id
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction_status`.ID=`Lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_transaction`.Lab_test_id
        WHERE `Lab_transaction`.Lab_transaction_status_id=3 ORDER BY `Lab_transaction`.Mode_of_test_id ASC ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

    public function get_pickup_lab_transaction(){
        $query = $this->db->query("SELECT 
        `Lab_transaction`.ID AS Lab_transaction_id,
        `Lab_transaction`.*,
        `Lab_transaction_status`.*,
        `Lab_test`.*,
        `Patient`.*,
        `Mode_of_test`.*,
        `Lab_package_test`.*
        FROM Lab_transaction 
        LEFT JOIN `Lab_package_test` ON `Lab_package_test`.ID=`Lab_transaction`.Lab_package_test_id
        LEFT JOIN `Patient` ON `Patient`.ID=`Lab_transaction`.Patient_id
        LEFT JOIN `Mode_of_test` ON `Mode_of_test`.ID=`Lab_transaction`.Mode_of_test_id
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction_status`.ID=`Lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_transaction`.Lab_test_id
        WHERE `Lab_transaction`.Lab_transaction_status_id=4 ORDER BY `Lab_transaction`.Mode_of_test_id ASC ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

    public function get_clinic_test(){

        $query = $this->db->query("SELECT * FROM Lab_test ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

    public function search_clinic_test(){

        $query = $this->db->query(
        "SELECT *
        FROM Lab_test 
        WHERE `Lab_test`.Abbreviation LIKE '%$this->Search%'");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }


    public function search_clinic_package_test(){

        $query = $this->db->query(
        "SELECT * 
        FROM Lab_package_test 
        WHERE `Lab_package_test`.Package_name LIKE '%$this->Search%'");

        if(!$query){
            return $this->db->error;
        }


        $query =  $this->fetch_all($query);
        
        foreach($query as $item){
            $item->Package_list_test = $this->clinic_package_list_test($item->ID);
        } 

        return $query;

    }

    private function clinic_package_list_test($id){

        $query = $this->db->query(
            "SELECT * 
            FROM Lab_package_list_test 
            LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_package_list_test`.Lab_test_id
            WHERE `Lab_package_list_test`.Lab_package_test_id = $id");
    
            if(!$query){
                return $this->db->error;
            }
    
            return $this->fetch_all($query);
    }


    public function add_clinic_test(){


        if(empty($this->Abbreviation) 
        || empty($this->Description) 
        || empty($this->Price)
        || empty($this->File_name)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }


        $query = $this->db->query("SELECT * 
        FROM Lab_test 
        WHERE `Lab_test`.Abbreviation='$this->Abbreviation' AND `Lab_test`.Description='$this->Description' AND `Lab_test`.File_name='$this->File_name'"); 

        if(!$query){
            return $this->db->error;
        }

        $query = $this->fetch_all($query);
  
        if(!empty($query)){
            return array('error'=>true, 'message' => DUPLICATE);
        }



        $query = $this->db->query("INSERT INTO Lab_test(Abbreviation, 
        Description, 
        Cost, 
        File_name, 
        Datetime_created) 
        VALUES('$this->Abbreviation', 
        '$this->Description', 
        $this->Price, 
        '$this->File_name',
        now())
        ");

        if(!$query){
            return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);

    }

    public function add_clinic_package_test(){

        if(empty($this->Package_name) 
        || empty($this->Price) 
        || empty($this->Lab_test_id)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $lab_test_id = implode(',',$this->Lab_test_id);

        $query = $this->db->query("SELECT * FROM Lab_test WHERE `Lab_test`.ID IN ($lab_test_id)"); 

        $query = $this->fetch_all($query);
    
        $query = $this->db->query("INSERT INTO Lab_package_test(Package_name, Price, Datetime_created) 
        VALUES('$this->Package_name', $this->Price, now())
        ");

        if(!$query){
            return $this->db->error;
        }

        $get_inserted_id = $this->db->insert_id;

        foreach($this->Lab_test_id as $ID){
            $query = $this->db->query("INSERT INTO Lab_package_list_test(Lab_package_test_id, Lab_test_id) 
            VALUES($get_inserted_id, $ID)
            ");
        }

        if(!$query){
            return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);
    }

}


?>