<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $User_ID;
    public $User_position_id;
    public $User_first_name;
    public $User_middle_name;
    public $User_last_name;
    public $User_date_of_birth;
    public $User_sex;
    public $User_phone_number;

    public $Search;
    public $Add_position;

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

    public function add_user(){


        if(
           empty($this->User_first_name) 
        || empty($this->User_middle_name) 
        || empty($this->User_last_name)
        || empty($this->User_username)
        || empty($this->User_password)
        || empty($this->User_sex)
        || empty($this->User_date_of_birth)
        || empty($this->User_phone_number)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $query = $this->db->query("SELECT * FROM user_account 
        WHERE `user_account`.Username='$this->User_username'");

        if(!$query){
            return $this->db->error;
        }

        $query = $this->first_row($query);

        if(!empty(count((array)$query))){
            return array('error'=>true, 'message' => EXIST_USER);
        }

        $encrypted_password = md5($this->User_password);

        $query = $this->db->query(
            "INSERT INTO 
            user_account(
                User_position_id, 
                First_name, 
                Middle_name, 
                Last_name, 
                Username, 
                Password, 
                Date_of_birth, 
                Sex, 
                Phone_number,   
                Datetime_created ) 
            VALUES(
                $this->User_position_id,
                '$this->User_first_name',
                '$this->User_middle_name', 
                '$this->User_last_name', 
                '$this->User_username', 
                '$encrypted_password', 
                '$this->User_date_of_birth', 
                '$this->User_sex', 
                '$this->User_phone_number', 
                now() )");

        if(!$query){
            return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);

    }


    public function search_user(){

        $query = $this->db->query(
        "SELECT 
        user_position.*,
        user_account.*
        FROM user_account 
        LEFT JOIN `user_position` ON `user_position`.ID=`user_account`.User_position_id
        WHERE `user_account`.Username LIKE '%$this->Search%'");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

    public function search_user_position(){

        $query = $this->db->query(
        "SELECT * 
        FROM user_position 
        WHERE `user_position`.Position LIKE '%$this->Search%'");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

    public function add_position(){

        if(empty($this->Add_position) ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $query = $this->db->query("INSERT INTO user_position(Position) VALUES('$this->Add_position')");

        if(!$query){
            return $this->db->error;
        }

        $query = $this->db->query("SELECT * FROM user_position");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

}


?>