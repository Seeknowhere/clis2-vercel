<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $Patient_ID;
    public $Patient_first_name;
    public $Patient_middle_name;
    public $Patient_last_name;
    public $Patient_date_of_birth;
    public $Patient_sex;
    public $Patient_phone_number;
    public $Patient_email_address;

    public $Search_patient;

    public $Lab_single_test_id;
    public $Lab_package_test_id;

    public $lab_test_name;
    public $Clinic_lab;
    public $Clinic_location;
    public $Clinic_price;

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

    public function get_lab_transaction_single_test(){


        $query = $this->db->query("SELECT * FROM Lab_test WHERE Available=1");

        if(!$query){

            return $this->db->error;
            
        }

        return $this->fetch_all($query);

    }

    public function get_lab_transaction_single_package(){

        $query = $this->db->query("SELECT * FROM Lab_package_test");
    
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
 

    public function add_patient(){

        if(empty($this->Patient_first_name) 
        || empty($this->Patient_middle_name) 
        || empty($this->Patient_last_name)
        || empty($this->Patient_date_of_birth)
        || empty($this->Patient_sex)
        || empty($this->Patient_phone_number)
        || empty($this->Patient_email_address)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $query = $this->db->query("SELECT * 
        FROM Patient 
        WHERE Phone_number = '$this->Patient_phone_number' AND Email_address = '$this->Patient_email_address' ");

        if(!$query){
            return $this->db->error;
        }

        if(!empty($this->fetch_all($query))){
            return array('error'=>true, 'message' => DUPLICATE);
        }
        
        $query = $this->db->query(
            "INSERT INTO Patient(
                First_name, 
                Middle_name, 
                Last_name, 
                Date_of_birth, 
                Sex, 
                Phone_number, 
                Email_address, 
                Datetime_created ) 
            VALUES(
                '$this->Patient_first_name',
                '$this->Patient_middle_name', 
                '$this->Patient_last_name', 
                '$this->Patient_date_of_birth', 
                '$this->Patient_sex', 
                '$this->Patient_phone_number', 
                '$this->Patient_email_address', 
                now() )");

        if(!$query){
            return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);

    }


    public function search_patient(){


        // if(empty($this->Patient_first_name) || empty($this->Patient_middle_name) 
        // || empty($this->Patient_last_name)
        // || empty($this->Patient_sex) || empty($this->Patient_phone_number)){
        //     return array('error'=>true, 'message' => REQUIRED_FIELD);
        // }


        $query = $this->db->query("SELECT * 
        FROM Patient 
        WHERE CONCAT_WS('', First_name, Middle_name, Last_name) LIKE '%$this->Search_patient%' LIMIT 10");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

    public function patient_request(){


        if(empty($this->Patient_ID) || empty($this->Lab_package_test_id) && empty($this->Lab_single_test_id)){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $lab_package_test_id = implode(',', $this->Lab_package_test_id);
        $lab_single_test_id = implode(',', $this->Lab_single_test_id);
        $has_duplicate_lab_list = false;
        $last_lab_transaction_id = null;

        $user = $_SESSION['user_data'];


        if(!empty($lab_package_test_id)){

            // searching duplicate single lab test to package lab test

            $package_lab_list = $this->db->query("SELECT * FROM Lab_package_list_test WHERE Lab_package_test_id IN ($lab_package_test_id)");
         
            if(!$package_lab_list){
                return $this->db->error;
            }
    
            $package_lab_list = $this->fetch_all($package_lab_list);
      
            foreach($package_lab_list as $item1){
                foreach($this->Lab_single_test_id as $ID){
                    if($item1->Lab_test_id==$ID){
                        return array('error'=>true, 'message' => DUPLICATE);
                    }
                }
            }
            // end searching duplicate single lab test to package lab test

            // search duplicate package lab test
            $lab_transaction = $this->db->query("SELECT * FROM Lab_transaction 
                                                WHERE Patient_id=$this->Patient_ID 
                                                AND Mode_of_test_id=2 
                                                AND Lab_package_test_id IN ($lab_package_test_id)");


            if(!$lab_transaction){
                return $this->db->error;
            }

            $lab_transaction = $this->fetch_all($lab_transaction);
            // var_dump($this->Patient_ID );
            if(!empty($lab_transaction)){
                return array('error'=>true, 'message' => DUPLICATE);
            }

            // end searching duplicate lab test
        }   

        // return false;

        if(!empty($this->Lab_single_test_id)){  

            // search duplicate lab test
            $lab_transaction = $this->db->query("SELECT * FROM Lab_transaction WHERE Patient_id=$this->Patient_ID AND Mode_of_test_id=1 AND Lab_test_id IN ($lab_single_test_id)");


            if(!$lab_transaction){
                return $this->db->error;
            }

            $lab_transaction = $this->fetch_all($lab_transaction);
     
            if(!empty($lab_transaction)){
                return array('error'=>true, 'message' => DUPLICATE);
            }
            // end searching duplicate lab test

        }
        
        $lab_transaction_number = $this->db->query("SELECT Transaction_number FROM Lab_transaction ORDER BY id DESC LIMIT 1");

        if(!$lab_transaction_number){
            return $this->db->error;
        }

        $lab_transaction_number = $this->first_row($lab_transaction_number);

        $transaction_number = @$lab_transaction_number->Transaction_number + 1;


        if(!empty($this->Lab_package_test_id)){

            $package_test_per_transaction = 
            $this->db->query("SELECT 
            Lab_package_list_test.Lab_package_test_id, 
            Lab_package_list_test.Lab_test_id 
            FROM Lab_package_test 
            LEFT JOIN `Lab_package_list_test` ON `Lab_package_list_test`.Lab_package_test_id=`Lab_package_test`.ID
            WHERE Lab_package_test.ID IN ($lab_package_test_id) ");

            if(!$package_test_per_transaction){
                return $this->db->error;
            }

            $package_test_per_transaction = $this->fetch_all($package_test_per_transaction);


            foreach($package_test_per_transaction as $key=>$item){
                
                $query = $this->db->query(
                        "INSERT INTO Lab_transaction(
                                Transaction_number,
                                Mode_of_test_id, 
                                Lab_package_test_id, 
                                Lab_test_id, 
                                Lab_transaction_status_id, 
                                Patient_id, 
                                Datetime_request ) 
                            VALUES(
                                $transaction_number,
                                2,
                                $item->Lab_package_test_id, 
                                $item->Lab_test_id, 
                                1 , 
                                $this->Patient_ID, 
                                now() )");

            }
            
            $last_lab_transaction_id = $this->db->insert_id;

            $lab_test_template = $this->db->query("SELECT * 
            FROM Lab_package_test 
            LEFT JOIN `Lab_package_list_test` ON `Lab_package_list_test`.Lab_package_test_id=`Lab_package_test`.ID
            LEFT JOIN `Lab_test_template_config` ON `Lab_test_template_config`.Lab_test_id=`Lab_package_list_test`.Lab_test_id
            WHERE Lab_package_test.ID IN ($lab_package_test_id) ");
    
            if(!$lab_test_template){
                return $this->db->error;
            }
            
            $lab_test_template = $this->fetch_all($lab_test_template);
        }

        if(!empty($this->Lab_single_test_id)){

            foreach($this->Lab_single_test_id as $key=>$ID){
                $query = $this->db->query(
                        "INSERT INTO Lab_transaction(
                                Transaction_number,
                                Mode_of_test_id, 
                                Lab_test_id, 
                                Lab_transaction_status_id, 
                                Patient_id, 
                                Datetime_request ) 
                            VALUES(
                                $transaction_number,
                                1,
                                $ID,
                                1, 
                                $this->Patient_ID, 
                                now() )");


            }
            $last_lab_transaction_id = $this->db->insert_id;
            
            $lab_test_template = $this->db->query("SELECT * FROM Lab_test_template_config WHERE Lab_test_id IN ($lab_single_test_id) ");
    

            if(!$lab_test_template){
                return $this->db->error;
            }
    
            $lab_test_template = $this->fetch_all($lab_test_template);
        }
        
        $lab_transaction_request = $this->db->query("SELECT ID, Lab_test_id FROM 
        Lab_transaction WHERE Lab_transaction_status_id=1 AND Patient_id=$this->Patient_ID 
        AND Datetime_ongoing IS NULL AND Datetime_release IS NULL AND Datetime_pickup IS NULL ");
        
        if(!$lab_transaction_request){
            return $this->db->error;
        }

        $lab_transaction_request = $this->fetch_all($lab_transaction_request);

        foreach($lab_test_template as $item){

            foreach($lab_transaction_request as $item2){
                
                if($item->Lab_test_id == $item2->Lab_test_id){
                    $query = $this->db->query(
                        "INSERT INTO Lab_test_template(
                                Lab_transaction_id, 
                                Lab_test_id, 
                                Label, 
                                Coordinate,
                                Datetime_created 
                                ) 
                            VALUES(
                                $item2->ID,
                                '$item->Lab_test_id', 
                                '$item->Label', 
                                '$item->Coordinate',
                                now()
                                )");
                }

                if(!$query){
                    return $this->db->error;
                }

            }
           
        }

        foreach($lab_transaction_request as $item){
            $query = $this->db->query(
                "INSERT INTO User_transaction(
                        Lab_transaction_id,
                        Lab_transaction_status_id, 
                        Patient_id, 
                        User_account_id, 
                        Datetime_created
                        ) 
                    VALUES(
                        $item->ID,
                        1,
                        $this->Patient_ID,
                        $user->ID,
                        now() 
                        )");

        }

        $get_lab_transaction_number = $this->db->query("SELECT Transaction_number FROM Lab_transaction WHERE `Lab_transaction`.ID=$last_lab_transaction_id");
        
        if(!$get_lab_transaction_number){
            return $this->db->error;
        }
     
        $get_lab_transaction_number = $this->first_row($get_lab_transaction_number);

        return array('error'=>false, 'message' => SUCCESS, 'tran_number'=>$get_lab_transaction_number->Transaction_number);
    }


    public function patient_request_sent_out(){


        if(empty($this->Patient_ID) || empty($this->Lab_package_test_id) && empty($this->Lab_single_test_id)){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $lab_package_test_id = implode(',', $this->Lab_package_test_id);
        $lab_single_test_id = implode(',', $this->Lab_single_test_id);
        $has_duplicate_lab_list = false;
        $last_lab_transaction_id = null;

        $user = $_SESSION['user_data'];


        if(!empty($lab_package_test_id)){

            // searching duplicate single lab test to package lab test

            $package_lab_list = $this->db->query("SELECT * FROM Lab_package_list_test WHERE Lab_package_test_id IN ($lab_package_test_id)");

            if(!$package_lab_list){
                return $this->db->error;
            }
    
            $package_lab_list = $this->fetch_all($package_lab_list);
    
            foreach($package_lab_list as $item1){
                foreach($this->Lab_single_test_id as $ID){
                    if($item1->Lab_test_id==$ID){
                        return array('error'=>true, 'message' => DUPLICATE);
                    }
                }
            }
            // end searching duplicate single lab test to package lab test

            // search duplicate package lab test
            $lab_transaction = $this->db->query("SELECT * FROM Lab_transaction 
                                                WHERE Patient_id=$this->Patient_ID 
                                                AND Mode_of_test_id=2 
                                                AND Lab_test_id IN ($lab_package_test_id)");


            if(!$lab_transaction){
                return $this->db->error;
            }

            $lab_transaction = $this->fetch_all($lab_transaction);
     
            if(!empty($lab_transaction)){
                return array('error'=>true, 'message' => DUPLICATE);
            }

            // end searching duplicate lab test
        }   


        if(!empty($this->Lab_single_test_id)){  

            // search duplicate lab test
            $lab_transaction = $this->db->query("SELECT * FROM Lab_transaction WHERE Patient_id=$this->Patient_ID AND Mode_of_test_id=1 AND Lab_test_id IN ($lab_single_test_id)");


            if(!$lab_transaction){
                return $this->db->error;
            }

            $lab_transaction = $this->fetch_all($lab_transaction);
     
            if(!empty($lab_transaction)){
                return array('error'=>true, 'message' => DUPLICATE);
            }
            // end searching duplicate lab test

        }
        
        $lab_transaction_number = $this->db->query("SELECT Transaction_number FROM Lab_transaction ORDER BY id DESC LIMIT 1");

        if(!$lab_transaction_number){
            return $this->db->error;
        }

        $lab_transaction_number = $this->first_row($lab_transaction_number);

        $transaction_number = @$lab_transaction_number->Transaction_number + 1;


        if(!empty($this->Lab_package_test_id)){

            $package_test_per_transaction = 
            $this->db->query("SELECT 
            Lab_package_list_test.Lab_package_test_id, 
            Lab_package_list_test.Lab_test_id 
            FROM Lab_package_test 
            LEFT JOIN `Lab_package_list_test` ON `Lab_package_list_test`.Lab_package_test_id=`Lab_package_test`.ID
            WHERE Lab_package_test.ID IN ($lab_package_test_id) ");

            if(!$package_test_per_transaction){
                return $this->db->error;
            }

            $package_test_per_transaction = $this->fetch_all($package_test_per_transaction);


            foreach($package_test_per_transaction as $key=>$item){
                
                $query = $this->db->query(
                        "INSERT INTO Lab_transaction(
                                Transaction_number,
                                Mode_of_test_id, 
                                Lab_package_test_id, 
                                Lab_test_id, 
                                Lab_transaction_status_id, 
                                Patient_id, 
                                Datetime_request ) 
                            VALUES(
                                $transaction_number,
                                2,
                                $item->Lab_package_test_id, 
                                $item->Lab_test_id, 
                                5, 
                                $this->Patient_ID, 
                                now() )");

            }
            
            $last_lab_transaction_id = $this->db->insert_id;

            $lab_test_template = $this->db->query("SELECT * 
            FROM Lab_package_test 
            LEFT JOIN `Lab_package_list_test` ON `Lab_package_list_test`.Lab_package_test_id=`Lab_package_test`.ID
            LEFT JOIN `Lab_test_template_config` ON `Lab_test_template_config`.Lab_test_id=`Lab_package_list_test`.Lab_test_id
            WHERE Lab_package_test.ID IN ($lab_package_test_id) ");
    
            if(!$lab_test_template){
                return $this->db->error;
            }
            
            $lab_test_template = $this->fetch_all($lab_test_template);
        }

        if(!empty($this->Lab_single_test_id)){

            foreach($this->Lab_single_test_id as $key=>$ID){
                $query = $this->db->query(
                        "INSERT INTO Lab_transaction(
                                Transaction_number,
                                Mode_of_test_id, 
                                Lab_test_id, 
                                Lab_transaction_status_id, 
                                Patient_id, 
                                Datetime_request ) 
                            VALUES(
                                $transaction_number,
                                1,
                                $ID,
                                5, 
                                $this->Patient_ID, 
                                now() )");


            }
            $last_lab_transaction_id = $this->db->insert_id;
            
            $lab_test_template = $this->db->query("SELECT * FROM Lab_test_template_config WHERE Lab_test_id IN ($lab_single_test_id) ");
    

            if(!$lab_test_template){
                return $this->db->error;
            }
    
            $lab_test_template = $this->fetch_all($lab_test_template);
        }
        
        $lab_transaction_request = $this->db->query("SELECT ID, Lab_test_id FROM 
        Lab_transaction WHERE Lab_transaction_status_id=1 AND Patient_id=$this->Patient_ID 
        AND Datetime_ongoing IS NULL AND Datetime_release IS NULL AND Datetime_pickup IS NULL ");
        
        if(!$lab_transaction_request){
            return $this->db->error;
        }

        $lab_transaction_request = $this->fetch_all($lab_transaction_request);

        foreach($lab_test_template as $item){

            foreach($lab_transaction_request as $item2){
                
                if($item->Lab_test_id == $item2->Lab_test_id){
                    $query = $this->db->query(
                        "INSERT INTO Lab_test_template(
                                Lab_transaction_id, 
                                Lab_test_id, 
                                Label, 
                                Coordinate,
                                Datetime_created 
                                ) 
                            VALUES(
                                $item2->ID,
                                '$item->Lab_test_id', 
                                '$item->Label', 
                                '$item->Coordinate',
                                now()
                                )");
                }

                if(!$query){
                    return $this->db->error;
                }

            }
           
        }

        foreach($lab_transaction_request as $item){
            $query = $this->db->query(
                "INSERT INTO User_transaction(
                        Lab_transaction_id,
                        Lab_transaction_status_id, 
                        Patient_id, 
                        User_account_id, 
                        Datetime_created
                        ) 
                    VALUES(
                        $item->ID,
                        1,
                        $this->Patient_ID,
                        $user->ID,
                        now() 
                        )");

        }

        $get_lab_transaction_number = $this->db->query("SELECT Transaction_number FROM Lab_transaction WHERE `Lab_transaction`.ID=$last_lab_transaction_id");
        
        if(!$get_lab_transaction_number){
            return $this->db->error;
        }
     
        $get_lab_transaction_number = $this->first_row($get_lab_transaction_number);

        return array('error'=>false, 'message' => SUCCESS, 'tran_number'=>$get_lab_transaction_number->Transaction_number);
    }


    public function lab_transaction_number($transaction_number){
        $query = $this->db->query("SELECT 
        `Lab_transaction`.*,
        `Lab_transaction_status`.*,
        `Lab_test`.*,
        `Lab_package_test`.Price AS Package_price,
        `Patient`.*,
        `Mode_of_test`.*
        FROM Lab_transaction 
        LEFT JOIN `Lab_package_test` ON `Lab_package_test`.ID=`Lab_transaction`.Lab_package_test_id
        LEFT JOIN `Patient` ON `Patient`.ID=`Lab_transaction`.Patient_id
        LEFT JOIN `Mode_of_test` ON `Mode_of_test`.ID=`Lab_transaction`.Mode_of_test_id
        LEFT JOIN `Lab_transaction_status` ON `Lab_transaction_status`.ID=`Lab_transaction`.Lab_transaction_status_id
        LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_transaction`.Lab_test_id
        WHERE `Lab_transaction`.Transaction_number=$transaction_number ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }


    public function patient_send_out(){

        if(empty($this->Lab_test_name) 
        || empty($this->Clinic_lab) 
        || empty($this->Clinic_location)
        || empty($this->Clinic_price)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $lab_transaction_number = $this->db->query("SELECT Transaction_number FROM Lab_transaction_sent_out ORDER BY id DESC LIMIT 1");

        if(!$lab_transaction_number){
            return $this->db->error;
        }
        
        $lab_transaction_number = $this->first_row($lab_transaction_number);

        $transaction_number = @$lab_transaction_number->Transaction_number + 1;

        $query = $this->db->query(
            "INSERT INTO Lab_transaction_sent_out(
                    Transaction_number,
                    Lab_test, 
                    Clinic_name, 
                    Clinic_location, 
                    Price, 
                    Lab_transaction_status_id, 
                    Patient_id, 
                    User_id,
                    Datetime_created 
                    ) 
                VALUES(
                    $transaction_number,
                    '$this->Lab_test_name',
                    '$this->Clinic_lab', 
                    '$this->Clinic_location', 
                    '$this->Clinic_price', 
                    5, 
                    '$this->Patient_ID', 
                    '$this->User_id',
                    now() 
                    )"); 
            

        if(!$query){
            return $this->db->error;
        }

        $get_inserted_id = $this->db->insert_id;

        $get_lab_transaction_number = $this->db->query("SELECT Transaction_number FROM Lab_transaction_sent_out WHERE `Lab_transaction_sent_out`.ID=$get_inserted_id");
        
        if(!$get_lab_transaction_number){
            return $this->db->error;
        }
     
        $get_lab_transaction_number = $this->first_row($get_lab_transaction_number);

    
        return array('error'=>false, 'message' => SUCCESS, 'tran_number'=>$get_lab_transaction_number->Transaction_number);

    }

}


?>