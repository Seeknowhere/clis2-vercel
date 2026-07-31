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
    

    public function get_clinic_test_package($id){

        $query = $this->db->query("SELECT * 
        FROM 
        Lab_package_list_test 
        LEFT JOIN `Lab_test` ON `Lab_test`.ID=`Lab_package_list_test`.Lab_test_id
        WHERE Lab_package_list_test.Lab_package_test_id='$id'" 
        );

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

    public function get_clinic_test_package_detail($id){

        $query = $this->db->query("SELECT * 
        FROM 
        Lab_package_test 
        WHERE ID='$id'" 
        );

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
        FROM Lab_test_template_config 
        WHERE `Lab_test_template_config`.ID='$this->ID' AND `Lab_test_template_config`.Label='$this->Label'"); 

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
        FROM Lab_test_template_config 
        WHERE `Lab_test_template_config`.ID='$this->ID' AND `Lab_test_template_config`.Coordinate='$this->Coordinate'"); 

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


        $query = $this->db->query("INSERT INTO Lab_test_template_config(    
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

        $query = $this->db->query("UPDATE Lab_test_template_config SET Show_field='$request'
        WHERE `Lab_test_template_config`.ID='$this->ID' ");
        
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
        // FROM Lab_test_template_config 
        // WHERE `Lab_test_template_config`.Coordinate='$this->Coordinate'"); 

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
    

        $query = $this->db->query("UPDATE Lab_test_template_config 
        SET
        Label='$this->Label',
        Coordinate='$this->Coordinate',
        Datetime_created=now() 
        WHERE `Lab_test_template_config`.ID='$this->ID'");

        if(!$query){
            return $this->db->error;
        }

        $query = $this->db->query("SELECT * 
        FROM Lab_test_template_config 
        WHERE `Lab_test_template_config`.Lab_test_id='$this->Lab_test_id'"); 

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }


    public function delete_label(){



        $query = $this->db->query("DELETE FROM Lab_test_template_config WHERE `Lab_test_template_config`.ID='$this->ID'");


        if(!$query){
            return $this->db->error;
        }


        $query = $this->db->query("SELECT * 
        FROM Lab_test_template_config 
        WHERE `Lab_test_template_config`.Lab_test_id='$this->Lab_test_id'"); 

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }


    public function search_label(){
    
        $query = $this->db->query("SELECT * 
        FROM Lab_test_template_config 
        WHERE `Lab_test_template_config`.Lab_test_id='$this->ID' AND `Lab_test_template_config`.Label 
        LIKE '%$this->Search%' ORDER BY Lab_test_template_config.Label ASC ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);
    }


}


?>