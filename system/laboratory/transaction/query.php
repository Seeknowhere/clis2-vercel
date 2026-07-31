<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $Patient_id;
    public $Lab_transaction_id;
    public $Json;
    public $Lab_test_id;
    public $Lab_result;
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
        // $query = $this->db->query("SELECT 
        // `lab_transaction`.ID AS Lab_transaction_id,
        // `lab_transaction`.*,
        // `lab_transaction_status`.*,
        // `lab_test`.*,
        // `patient`.*,
        // `mode_of_test`.*,
        // `lab_package_test`.*
        // FROM lab_transaction
        // LEFT JOIN `lab_package_test` ON `lab_package_test`.ID=`lab_transaction`.Lab_package_test_id
        // LEFT JOIN `patient` ON `patient`.ID=`lab_transaction`.Patient_id
        // LEFT JOIN `mode_of_test` ON `mode_of_test`.ID=`lab_transaction`.Mode_of_test_id
        // LEFT JOIN `lab_transaction_status` ON `lab_transaction_status`.ID=`lab_transaction`.Lab_transaction_status_id
        // LEFT JOIN `lab_test` ON `lab_test`.ID=`lab_transaction`.Lab_test_id
        // LEFT JOIN `lab_test_template` ON `lab_test_template`.Lab_transaction_id=`lab_transaction`.ID
        // WHERE `lab_transaction`.Lab_transaction_status_id=3 GROUP BY lab_transaction.Lab_test_id ORDER BY `lab_transaction`.Mode_of_test_id ASC ");
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

    public function lab_test_template(){

        $query = $this->db->query("SELECT *
        FROM lab_transaction 
        LEFT JOIN `patient` ON `patient`.ID=`lab_transaction`.Patient_id
        LEFT JOIN `lab_test` ON `lab_test`.ID=`lab_transaction`.Lab_test_id
        LEFT JOIN `lab_test_template_config` ON `lab_test_template_config`.Lab_test_id=`lab_test`.ID
        WHERE `lab_transaction`.ID='$this->Lab_transaction_id' AND `lab_test_template_config`.Show_field=1");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

    public function lab_test_template_preview(){


        $query = $this->db->query("SELECT *
        FROM lab_transaction 
        LEFT JOIN `patient` ON `patient`.ID=`lab_transaction`.Patient_id
        LEFT JOIN `lab_test_template` ON `lab_transaction`.ID=`lab_test_template`.Lab_transaction_id
        LEFT JOIN `lab_test` ON `lab_test`.ID=`lab_test_template`.Lab_test_id
        WHERE `lab_transaction`.Patient_id='$this->Patient_id' AND `lab_transaction`.Lab_test_id='$this->Lab_test_id' ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }

    public function accept_request(){

        $user = $_SESSION['user_data'];

        $query = $this->db->query("UPDATE lab_transaction SET Lab_transaction_status_id=2, Datetime_ongoing=now() 
        WHERE `lab_transaction`.ID='$this->Lab_transaction_id' AND `lab_transaction`.Patient_id='$this->Patient_id'");

        if(!$query){
        return $this->db->error;
        }

        $query = $this->db->query(
            "INSERT INTO user_transaction(
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
        FROM lab_test_template");

        if(!$query){
            return $this->db->error;
        }

        return $this->first_row($query);
    }

    public function releast_result(){


        $user = $_SESSION['user_data'];

        
        // $new_json = $this->db->escape_string($this->Json);

        $query = $this->db->query("SELECT *
        FROM lab_test_template 
        WHERE `lab_test_template`.Lab_test_id='$this->Lab_test_id' AND `lab_test_template`.Lab_transaction_id='$this->Lab_transaction_id' ");

        $query = $this->fetch_all($query);
        
        $array_keys = ['ID', 'Value'];

      
        
        foreach($this->Lab_result as $key=> $value){

            $data = (object)array_combine(
                ['coordinate', 'value'],
                array_values($value)
            );

            // var_dump($data->value);

            $query = $this->db->query("UPDATE lab_test_template 
            SET Value='$data->value'
            WHERE `lab_test_template`.Lab_transaction_id=$this->Lab_transaction_id AND `lab_test_template`.Coordinate='$data->coordinate'");
            if(!$query){
                return $this->db->error;
            }
        }

        // return false;
    
        if(!$query){
            return $this->db->error;
        }


        $query = $this->db->query("UPDATE lab_transaction SET Lab_transaction_status_id=3, Datetime_release=now() 
        WHERE `lab_transaction`.ID='$this->Lab_transaction_id' AND `lab_transaction`.Patient_id='$this->Patient_id'");
      
        if(!$query){
            return $this->db->error;
        }

        $query = $this->db->query(
            "INSERT INTO user_transaction(
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


        // return false;

        // $user = $_SESSION['user_data'];
        
        // $query = $this->db->query("UPDATE lab_transaction SET Lab_transaction_status_id=4, Datetime_pickup=now()
        // WHERE `lab_transaction`.ID='$this->Lab_transaction_id' AND `lab_transaction`.Patient_id='$this->Patient_id'");

        // $query = $this->db->query("SELECT 
        // lab_test.Abbreviation,
        // lab_test.Description,
        // patient.Email_address, 
        // lab_test_template.Json
        // FROM lab_transaction 
        // LEFT JOIN `patient` ON `lab_transaction`.Patient_id=`patient`.ID
        // LEFT JOIN `lab_test` ON `lab_transaction`.Lab_test_id=`lab_test`.ID
        // LEFT JOIN `lab_test_template` ON `lab_transaction`.ID=`lab_test_template`.Lab_transaction_id
        // WHERE `lab_transaction`.Patient_id='$this->Patient_id' AND `lab_transaction`.Lab_test_id='$this->Lab_test_id' ");

        // if(!$query){
        //     return $this->db->error;
        // }

        // $query_transaction = $this->db->query(
        //     "INSERT INTO user_transaction(
        //             Lab_transaction_id,
        //             Lab_transaction_status_id, 
        //             Patient_id, 
        //             User_account_id, 
        //             Datetime_created
        //             ) 
        //         VALUES(
        //             $this->Lab_transaction_id,
        //             4,
        //             $this->Patient_id,
        //             $user->ID,
        //             now() 
        //             )");

        // if(!$query_transaction){
        //     return $this->db->error;
        // }

        // return $this->first_row($query);
        // $user = $_SESSION['user_data'];
 
        // // $query = $this->db->query("UPDATE lab_transaction SET Lab_transaction_status_id=4, Datetime_ongoing=now() 
        // // WHERE `lab_transaction`.ID='$this->Lab_transaction_id' AND `lab_transaction`.Patient_id='$this->Patient_id'");

        // $query = $this->db->query("SELECT *
        // FROM lab_test 
        // LEFT JOIN `lab_test_template` ON `lab_test_template`.Lab_test_id=`lab_test`.ID
        // WHERE `lab_test_template`.Lab_transaction_id='$this->Lab_transaction_id' 
        // AND `lab_test_template`.Lab_test_id='$this->Lab_test_id'");

        // // user logs
        // // $query_transaction = $this->db->query(
        // //     "INSERT INTO user_transaction(
        // //             Lab_transaction_id,
        // //             Lab_transaction_status_id, 
        // //             Patient_id, 
        // //             User_account_id, 
        // //             Datetime_created
        // //             ) 
        // //         VALUES(
        // //             $this->Lab_transaction_id,
        // //             4,
        // //             $this->Patient_id,
        // //             $user->ID,
        // //             now() 
        // //             )");

        // if(!$query){
        //     return $this->db->error;
        // }

        // return $this->fetch_all($query);

        $user = $_SESSION['user_data'];
        
        $query = $this->db->query("UPDATE lab_transaction SET Lab_transaction_status_id=4, Datetime_pickup=now()
        WHERE `lab_transaction`.ID='$this->Lab_transaction_id' AND `lab_transaction`.Patient_id='$this->Patient_id'");

        $query = $this->db->query("SELECT *
        FROM lab_test 
        LEFT JOIN `lab_test_template` ON `lab_test_template`.Lab_test_id=`lab_test`.ID
        LEFT JOIN `lab_transaction` ON `lab_transaction`.ID=`lab_test_template`.Lab_transaction_id
        LEFT JOIN `patient` ON `patient`.ID=`lab_transaction`.Patient_id
        WHERE `lab_test_template`.Lab_transaction_id='$this->Lab_transaction_id' 
        AND `lab_test_template`.Lab_test_id='$this->Lab_test_id'");

        if(!$query){
            return $this->db->error;
        }

        $query_transaction = $this->db->query(
            "INSERT INTO user_transaction(
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

        return $this->fetch_all($query);

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
            "SELECT * FROM `user_account`
            WHERE `user_account`.Username='$this->User_username' AND `user_account`.Password='$encrypted_password' AND Active = 1 AND User_position_id = 1"
            );

        if(!$query1){
            return $this->db->error;
        }

        if(mysqli_num_rows($query1)){
            if($this->Lab_transaction_status_id==1){
                $query = $this->db->query("UPDATE lab_transaction 
                SET Lab_transaction_status_id=$this->Lab_transaction_status_id, Datetime_ongoing=null
                WHERE 
                `lab_transaction`.ID='$this->Lab_transaction_id' AND 
                `lab_transaction`.Patient_id='$this->Patient_id'");
            }
            else if ($this->Lab_transaction_status_id==2){
                $query = $this->db->query("UPDATE lab_transaction 
                SET Lab_transaction_status_id=$this->Lab_transaction_status_id, Datetime_release=null
                WHERE 
                `lab_transaction`.ID='$this->Lab_transaction_id' AND 
                `lab_transaction`.Patient_id='$this->Patient_id'");
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