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

    public $Search;
    public $Patient_id;

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

    public function get_labtest($id){

        // var_dump($id);

        $query = $this->db->query("SELECT 
        lab_transaction.ID AS lab_id,
        lab_test.Abbreviation, 
        lab_test.ID
        FROM lab_transaction 
        LEFT JOIN `lab_test` ON `lab_transaction`.Lab_test_id=`lab_test`.ID
        WHERE lab_transaction.Patient_id = '$id' "
        );

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

    public function lab_logs(){
        
        $split = explode(',', $this->Search);
        
        $lab_id = $split[0];
        $lab_transact_id = $split[1];

        $query = $this->db->query("SELECT *
        FROM lab_transaction 
        LEFT JOIN `lab_test` ON `lab_transaction`.Lab_test_id=`lab_test`.ID
        LEFT JOIN `lab_test_template` ON `lab_transaction`.ID=`lab_test_template`.Lab_transaction_id
        WHERE lab_transaction.Patient_id = '$this->Patient_id' 
        AND lab_transaction.ID = '$lab_transact_id' AND lab_transaction.Lab_test_id = '$lab_id'  "
        );

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }


    public function get_patient_record($id){

        $query = $this->db->query("SELECT * FROM patient WHERE ID = '$id' ");

        if(!$query){
            return $this->db->error;
        }

        return $this->first_row($query);

    }
    
    public function get_patient_medical_history($id){

        $query = $this->db->query("SELECT * 
        FROM lab_transaction 
        LEFT JOIN `lab_test` ON `lab_transaction`.Lab_test_id=`lab_test`.ID
        LEFT JOIN `mode_of_test` ON `lab_transaction`.Mode_of_test_id=`mode_of_test`.ID
        LEFT JOIN `lab_transaction_status` ON `lab_transaction`.Lab_transaction_status_id=`lab_transaction_status`.ID
        LEFT JOIN `lab_test_template` ON `lab_transaction`.ID=`lab_test_template`.Lab_transaction_id
       
        WHERE lab_transaction.Patient_id = '$id' GROUP BY  `lab_transaction`.Lab_test_id"
        );

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }

    public function get_patient_transaction_logs($id){
        
        $query = $this->db->query("SELECT * 
        FROM user_transaction 
        LEFT JOIN `lab_transaction` ON `lab_transaction`.ID=`user_transaction`.Lab_transaction_id
        LEFT JOIN `user_account` ON `user_account`.ID=`user_transaction`.User_account_id
        LEFT JOIN `user_position` ON `user_position`.ID=`user_account`.User_position_id
        LEFT JOIN `lab_test` ON `lab_transaction`.Lab_test_id=`lab_test`.ID
        LEFT JOIN `mode_of_test` ON `lab_transaction`.Mode_of_test_id=`mode_of_test`.ID
        LEFT JOIN `lab_transaction_status` ON `lab_transaction`.Lab_transaction_status_id=`lab_transaction_status`.ID
        WHERE lab_transaction.Patient_id = '$id' "
        );

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }

    public function get_patient_sent_out_logs($id){
        
        $query = $this->db->query("SELECT * 
        FROM lab_transaction_sent_out 
        LEFT JOIN `user_account` ON `user_account`.ID=`lab_transaction_sent_out`.User_id
        LEFT JOIN `lab_transaction_status` ON `lab_transaction_sent_out`.Lab_transaction_status_id=`lab_transaction_status`.ID
        WHERE lab_transaction_sent_out.Patient_id = '$id' "
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
 
         $query = $this->db->query("UPDATE patient 
            SET
            First_name='$this->Patient_first_name',
            Middle_name='$this->Patient_middle_name',
            Last_name='$this->Patient_last_name',
            Date_of_birth='$this->Patient_date_of_birth',
            Sex='$this->Patient_sex',
            Phone_number='$this->Patient_phone_number',
            Email_address='$this->Patient_email_address'
            WHERE `patient`.ID='$this->Patient_ID'
            ");
         if(!$query){
             return $this->db->error;
         }
 
         return array('error'=>false, 'message' => SUCCESS);
    }

    
}


?>