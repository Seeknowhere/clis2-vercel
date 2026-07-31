<?php
include_once(ROOT_PATH.'config.php');
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


        $query = $this->db->query("SELECT * FROM user_position ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

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

    public function get_clinic_test(){

        $query = $this->db->query("SELECT * FROM lab_test ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

    public function search_clinic_test(){

        $query = $this->db->query(
        "SELECT *
        FROM lab_test 
        WHERE `lab_test`.Abbreviation LIKE '%$this->Search%'");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }


    public function search_clinic_package_test(){

        $query = $this->db->query(
        "SELECT * 
        FROM lab_package_test 
        WHERE `lab_package_test`.Package_name LIKE '%$this->Search%'");

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
            FROM lab_package_list_test 
            LEFT JOIN `lab_test` ON `lab_test`.ID=`lab_package_list_test`.Lab_test_id
            WHERE `lab_package_list_test`.Lab_package_test_id = $id");
    
            if(!$query){
                return $this->db->error;
            }
    
            return $this->fetch_all($query);
    }


    public function add_clinic_test(){

        if(empty($this->Abbreviation) 
        || empty($this->Description) 
        || empty($this->Cost)
        || empty($this->File_name)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }



        $query = $this->db->query("SELECT * 
        FROM lab_test 
        WHERE `lab_test`.Abbreviation='$this->Abbreviation' AND `lab_test`.Description='$this->Description' AND `lab_test`.File_name='$this->File_name'"); 

        if(!$query){
            return $this->db->error;
        }

        $query = $this->fetch_all($query);
  
        if(!empty($query)){
            return array('error'=>true, 'message' => DUPLICATE);
        }



        $query = $this->db->query("INSERT INTO lab_test(Abbreviation, 
        Description, 
        Price, 
        File_name, 
        Datetime_created) 
        VALUES('$this->Abbreviation', 
        '$this->Description', 
        $this->Cost, 
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

        $query = $this->db->query("SELECT * FROM lab_test WHERE `lab_test`.ID IN ($lab_test_id)"); 

        $query = $this->fetch_all($query);
    
        $query = $this->db->query("INSERT INTO lab_package_test(Package_name, Price, Datetime_created) 
        VALUES('$this->Package_name', $this->Price, now())
        ");

        if(!$query){
            return $this->db->error;
        }

        $get_inserted_id = $this->db->insert_id;

        foreach($this->Lab_test_id as $ID){
            $query = $this->db->query("INSERT INTO lab_package_list_test(Lab_package_test_id, Lab_test_id) 
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