<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $Patient_ID;
    public $Patient_position_id;
    public $Patient_first_name;
    public $Patient_middle_name;
    public $Patient_last_name;
    public $Patient_date_of_birth;
    public $Patient_sex;
    public $Patient_phone_number;

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

    public function get_patient_record($id){

        $query = $this->db->query("SELECT * FROM Patient WHERE ID = '$id' ");

        if(!$query){
            return $this->db->error;
        }

        return $this->first_row($query);

    }
    
    public function get_patient_medical_history($id){

        $query = $this->db->query("SELECT * 
        FROM Lab_transaction 
        LEFT JOIN `Lab_test` ON `Lab_transaction`.Lab_test_id=`Lab_test`.ID
        LEFT JOIN `Mode_of_test` ON `Lab_transaction`.Mode_of_test_id=`Mode_of_test`.ID
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction`.Lab_transaction_status_id=`Lab_transaction_status`.ID
        LEFT JOIN `Lab_test_template` ON `Lab_transaction`.ID=`Lab_test_template`.Lab_transaction_id
       
        WHERE Lab_transaction.Patient_id = '$id' GROUP BY  `Lab_transaction`.Lab_test_id"
        );

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }

    public function get_patient_transaction_logs($id){
        
        $query = $this->db->query("SELECT * 
        FROM User_transaction 
        LEFT JOIN `Lab_transaction` ON `Lab_transaction`.ID=`User_transaction`.Lab_transaction_id
        LEFT JOIN `User_account` ON `User_account`.ID=`User_transaction`.User_account_id
        LEFT JOIN `User_position` ON `User_position`.ID=`User_account`.User_position_id
        LEFT JOIN `Lab_test` ON `Lab_transaction`.Lab_test_id=`Lab_test`.ID
        LEFT JOIN `Mode_of_test` ON `Lab_transaction`.Mode_of_test_id=`Mode_of_test`.ID
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction`.Lab_transaction_status_id=`Lab_transaction_status`.ID
        WHERE Lab_transaction.Patient_id = '$id' "
        );

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }

    public function get_patient_sent_out_logs($id){
        
        $query = $this->db->query("SELECT * 
        FROM Lab_transaction_sent_out 
        LEFT JOIN `User_account` ON `User_account`.ID=`Lab_transaction_sent_out`.User_id
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction_sent_out`.Lab_transaction_status_id=`Lab_transaction_status`.ID
        WHERE Lab_transaction_sent_out.Patient_id = '$id' "
        );

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }

    public function update_patient_details(){

        if(
            empty($this->Patient_first_name) 
         || empty($this->Patient_middle_name) 
         || empty($this->Patient_last_name)
         || empty($this->Patient_sex)
         || empty($this->Patient_date_of_birth)
         || empty($this->Patient_phone_number)
         || empty($this->Patient_email_address)
         ){
             return array('error'=>true, 'message' => REQUIRED_FIELD);
         }
 
         $query = $this->db->query("UPDATE Patient 
            SET
            First_name='$this->Patient_first_name',
            Middle_name='$this->Patient_middle_name',
            Last_name='$this->Patient_last_name',
            Date_of_birth='$this->Patient_date_of_birth',
            Sex='$this->Patient_sex',
            Phone_number='$this->Patient_phone_number',
            Email_address='$this->Patient_email_address'
            WHERE `Patient`.ID='$this->Patient_ID'
            ");
         if(!$query){
             return $this->db->error;
         }
 
         return array('error'=>false, 'message' => SUCCESS);
    }
    
}


?>