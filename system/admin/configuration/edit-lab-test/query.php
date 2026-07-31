<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $Search;

    public $ID;
    public $Lab_test_id;
    public $Label;
    public $Coordinate;

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
    

    public function get_clinic_test_single($id){

        $query = $this->db->query("SELECT * FROM 
        lab_test WHERE ID='$id'  " );

        if(!$query){
            return $this->db->error;
        }

        return $this->first_row($query);

    }

    public function add_label(){


        if(
            empty($this->ID)
        ||  empty($this->Label)
        ||  empty($this->Coordinate)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        } 
        
        //checker for label
        $query_label = $this->db->query("SELECT * 
        FROM lab_test_template_config 
        WHERE `lab_test_template_config`.ID='$this->ID' AND `lab_test_template_config`.Label='$this->Label'"); 

        if(!$query_label){
            return $this->db->error;
        }

        $query_label = $this->fetch_all($query_label);
  
        if(!empty($query_label)){
            return array('error'=>true, 'message' => LABEL_EXIST);
        }
        // end checker for label


        // checker for coordinate
        
        $query_coordinate = $this->db->query("SELECT * 
        FROM lab_test_template_config 
        WHERE `lab_test_template_config`.ID='$this->ID' AND `lab_test_template_config`.Coordinate='$this->Coordinate'"); 

        if(!$query_coordinate){
            return $this->db->error;
        }

        $query_coordinate = $this->fetch_all($query_coordinate);
  
        if(!empty($query_coordinate)){
            return array('error'=>true, 'message' => COORDINATES_EXIST);
        }

        // end checker for coordinate

        // checker for max and min coordinate
        if(strlen($this->Coordinate)>=5){
            return array('error'=>true, 'message' => REACH_MAX_COORDINATES);
        }
        if(strlen($this->Coordinate)<=1){
            return array('error'=>true, 'message' => REACH_MIN_COORDINATES);
        }
        // end checker for max and min coordinate

        // checker for format coordinate
        $coordinate = explode(',', $this->Coordinate);
        $coordinate_3rd_value = !empty($coordinate[2])? !is_numeric($coordinate[2]) : false ;

        // if(!is_numeric($coordinate[0]) || !is_numeric($coordinate[1]) || $coordinate_3rd_value ){
        //     return array('error'=>true, 'message' => INVALID_COORDINATES);
        // }
        // end checker for format coordinate.


        $query = $this->db->query("INSERT INTO lab_test_template_config(    
        Lab_test_id, 
        Label, 
        Coordinate, 
        Datetime_created) 
        VALUES('$this->ID', 
        '$this->Label', 
        '$this->Coordinate', 
        now())
        ");

        if(!$query){
            return $this->db->error;
        }


        return array('error'=>false, 'message' => SUCCESS);

    }


    public function update_display_label(){
        
        $request = ($this->Show_field==1) ? 0 : 1;

        $query = $this->db->query("UPDATE lab_test_template_config SET Show_field='$request'
        WHERE `lab_test_template_config`.ID='$this->ID' ");
        
        if(!$query){
            return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);
    }

    public function update_label(){


        if(
            empty($this->ID)
        ||  empty($this->Label)
        ||  empty($this->Coordinate)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        } 
        
        // //checker for coordinate POSTPONE
        // $query_label = $this->db->query("SELECT * 
        // FROM lab_test_template_config 
        // WHERE `lab_test_template_config`.Coordinate='$this->Coordinate'"); 

        // if(!$query_label){
        //     return $this->db->error;
        // }

        // $query_label = $this->fetch_all($query_label);
        
        // if(empty($query_label)){
        //     return array('error'=>true, 'message' => COORDINATE_EXIST_ON_UPDATE);
        // }
        // // end checker for coordinate

        // checker for max and min coordinate
        if(strlen($this->Coordinate)>=5){
            return array('error'=>true, 'message' => REACH_MAX_COORDINATES);
        }
        if(strlen($this->Coordinate)<=1){
            return array('error'=>true, 'message' => REACH_MIN_COORDINATES);
        }
        // end checker for max and min coordinate

        // checker for format coordinate
        $coordinate = explode (",", $this->Coordinate);
        // $coordinate_3rd_value = !empty($coordinate[2])? !is_numeric($coordinate[2]) : false 

        // if(!is_numeric($coordinate[0]) || !is_numeric($coordinate[1]) ){
        //     return array('error'=>true, 'message' => INVALID_COORDINATES);
        // }

        // end checker for format coordinate.
    

        $query = $this->db->query("UPDATE lab_test_template_config 
        SET
        Label='$this->Label',
        Coordinate='$this->Coordinate',
        Datetime_created=now() 
        WHERE `lab_test_template_config`.ID='$this->ID'");

        if(!$query){
            return $this->db->error;
        }

        $query = $this->db->query("SELECT * 
        FROM lab_test_template_config 
        WHERE `lab_test_template_config`.Lab_test_id='$this->Lab_test_id'"); 

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }


    public function delete_label(){



        $query = $this->db->query("DELETE FROM lab_test_template_config WHERE `lab_test_template_config`.ID='$this->ID'");


        if(!$query){
            return $this->db->error;
        }


        $query = $this->db->query("SELECT * 
        FROM lab_test_template_config 
        WHERE `lab_test_template_config`.Lab_test_id='$this->Lab_test_id'"); 

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }


    public function search_label(){
    
        $query = $this->db->query("SELECT * 
        FROM lab_test_template_config 
        WHERE `lab_test_template_config`.Lab_test_id='$this->ID' AND `lab_test_template_config`.Label 
        LIKE '%$this->Search%' ORDER BY lab_test_template_config.Label ASC ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }


}


?>