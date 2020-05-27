<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/config.php');
class query{

    public $Patient_id;
    public $Lab_transaction_id;
    public $Json;
    public $Lab_test_id;
    public $Lab_test_template_id;
    public $Lab_test_template_value;
    public $Lab_transaction_status_id;
    public $User_username;
    public $User_password;

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
        `Lab_package_test`.*,
        `Lab_test_template`.Json
        FROM Lab_transaction 
        LEFT JOIN `Lab_package_test` ON `Lab_package_test`.ID=`Lab_transaction`.Lab_package_test_id
        LEFT JOIN `Patient` ON `Patient`.ID=`Lab_transaction`.Patient_id
        LEFT JOIN `Mode_of_test` ON `Mode_of_test`.ID=`Lab_transaction`.Mode_of_test_id
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction_status`.ID=`Lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_transaction`.Lab_test_id
        LEFT JOIN `Lab_test_template` ON `Lab_test_template`.Lab_transaction_id=`Lab_transaction`.ID
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

    public function lab_test_template(){

        $query = $this->db->query("SELECT *
        FROM Lab_transaction 
        LEFT JOIN `Patient` ON `Patient`.ID=`Lab_transaction`.Patient_id
        LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_transaction`.Lab_test_id
        LEFT JOIN `Lab_test_template_config` ON `Lab_test_template_config`.Lab_test_id=`Lab_test`.ID
        WHERE `Lab_transaction`.ID='$this->Lab_transaction_id'");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

    public function lab_test_template_preview(){


        $query = $this->db->query("SELECT Lab_test_template.Json
        FROM Lab_transaction 
        LEFT JOIN `Lab_test_template` ON `Lab_transaction`.ID=`Lab_test_template`.Lab_transaction_id
        WHERE `Lab_transaction`.Patient_id='$this->Patient_id' AND `Lab_transaction`.Lab_test_id='$this->Lab_test_id' ");

        if(!$query){
            return $this->db->error;
        }
        return $this->first_row($query);
    }

    public function accept_request(){

        $user = $_SESSION['user_data'];

        $query = $this->db->query("UPDATE Lab_transaction SET Lab_transaction_status_id=2, Datetime_ongoing=now() 
        WHERE `Lab_transaction`.ID='$this->Lab_transaction_id' AND `Lab_transaction`.Patient_id='$this->Patient_id'");

        if(!$query){
        return $this->db->error;
        }

        $query = $this->db->query(
            "INSERT INTO User_transaction(
                    Lab_transaction_id,
                    Lab_transaction_status_id, 
                    Patient_id, 
                    User_account_id, 
                    Datetime_created
                    ) 
                VALUES(
                    $this->Lab_transaction_id,
                    2,
                    $this->Patient_id,
                    $user->ID,
                    now() 
                    )");

        if(!$query){
            return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);

    }

    public function get_template(){
        $query = $this->db->query("SELECT Json
        FROM Lab_test_template");

        if(!$query){
            return $this->db->error;
        }

        return $this->first_row($query);
    }

    public function releast_result(){


        $user = $_SESSION['user_data'];

        
        $new_json = $this->db->escape_string($this->Json);

        $query = $this->db->query("SELECT *
        FROM Lab_test_template 
        WHERE `Lab_test_template`.Lab_test_id='$this->Lab_test_id' AND `Lab_test_template`.Lab_transaction_id='$this->Lab_transaction_id' ");

        $query = $this->fetch_all($query);
        
        
        if(empty($query)){
            $query = $this->db->query(
                "INSERT INTO Lab_test_template(
                        Lab_transaction_id,
                        Lab_test_id, 
                        Json, 
                        Datetime_created
                        ) 
                    VALUES(
                        $this->Lab_transaction_id,
                        $this->Lab_test_id,
                        '$new_json',
                        now() 
                    )");
        }else{

            $query = 
            $this->db->query("UPDATE 
            Lab_test_template 
            SET 
            Json='$new_json', 
            Datetime_created=now() 
            WHERE 
            `Lab_test_template`.Lab_transaction_id='$this->Lab_transaction_id' AND 
            `Lab_test_template`.Lab_test_id='$this->Lab_test_id'");

        }
        

        if(!$query){
            return $this->db->error;
        }


        $query = $this->db->query("UPDATE Lab_transaction SET Lab_transaction_status_id=3, Datetime_release=now() 
        WHERE `Lab_transaction`.ID='$this->Lab_transaction_id' AND `Lab_transaction`.Patient_id='$this->Patient_id'");
      
        if(!$query){
            return $this->db->error;
        }

        $query = $this->db->query(
            "INSERT INTO User_transaction(
                    Lab_transaction_id,
                    Lab_transaction_status_id, 
                    Patient_id, 
                    User_account_id, 
                    Datetime_created
                    ) 
                VALUES(
                    $this->Lab_transaction_id,
                    3,
                    $this->Patient_id,
                    $user->ID,
                    now() 
                    )");

        if(!$query){
            return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);

    }


    public function ready_to_pickup(){

        $user = $_SESSION['user_data'];
        
        $query = $this->db->query("UPDATE Lab_transaction SET Lab_transaction_status_id=4, Datetime_pickup=now()
        WHERE `Lab_transaction`.ID='$this->Lab_transaction_id' AND `Lab_transaction`.Patient_id='$this->Patient_id'");

        $query = $this->db->query("SELECT 
        Lab_test.Abbreviation,
        Lab_test.Description,
        Patient.Email_address, 
        Lab_test_template.Json
        FROM Lab_transaction 
        LEFT JOIN `Patient` ON `Lab_transaction`.Patient_id=`Patient`.ID
        LEFT JOIN `Lab_test` ON `Lab_transaction`.Lab_test_id=`Lab_test`.ID
        LEFT JOIN `Lab_test_template` ON `Lab_transaction`.ID=`Lab_test_template`.Lab_transaction_id
        WHERE `Lab_transaction`.Patient_id='$this->Patient_id' AND `Lab_transaction`.Lab_test_id='$this->Lab_test_id' ");

        if(!$query){
            return $this->db->error;
        }

        $query_transaction = $this->db->query(
            "INSERT INTO User_transaction(
                    Lab_transaction_id,
                    Lab_transaction_status_id, 
                    Patient_id, 
                    User_account_id, 
                    Datetime_created
                    ) 
                VALUES(
                    $this->Lab_transaction_id,
                    4,
                    $this->Patient_id,
                    $user->ID,
                    now() 
                    )");

        if(!$query_transaction){
            return $this->db->error;
        }

        return $this->first_row($query);

    }

    public function redo_lab_test(){

        if(
            empty($this->Lab_transaction_status_id) 
         || empty($this->Lab_transaction_id) 
         || empty($this->Patient_id)
         || empty($this->User_username)
         || empty($this->User_password)
         ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }
        $query = null;
        $encrypted_password = md5($this->User_password);
        $query1 = $this->db->query(
            "SELECT * FROM `User_account`
            WHERE `User_account`.Username='$this->User_username' AND `User_account`.Password='$encrypted_password' AND Active = 1 AND User_position_id = 1"
            );

        if(!$query1){
            return $this->db->error;
        }

        if(mysqli_num_rows($query1)){
            if($this->Lab_transaction_status_id==1){
                $query = $this->db->query("UPDATE Lab_transaction 
                SET Lab_transaction_status_id=$this->Lab_transaction_status_id, Datetime_ongoing=null
                WHERE 
                `Lab_transaction`.ID='$this->Lab_transaction_id' AND 
                `Lab_transaction`.Patient_id='$this->Patient_id'");
            }
            else if ($this->Lab_transaction_status_id==2){
                $query = $this->db->query("UPDATE Lab_transaction 
                SET Lab_transaction_status_id=$this->Lab_transaction_status_id, Datetime_release=null
                WHERE 
                `Lab_transaction`.ID='$this->Lab_transaction_id' AND 
                `Lab_transaction`.Patient_id='$this->Patient_id'");
            }
        }else{
            return array('error'=>true, 'message' => NOT_AUTHORIZE);
        }

        if(!$query){
            return $this->db->error;
        }
        return array('error'=>false, 'message' => SUCCESS);
    }
     



}


?>