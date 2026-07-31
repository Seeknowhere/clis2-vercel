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
    public $Image_file;

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


        $query = $this->db->query("SELECT * FROM User_position ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }

    public function get_user($id){

        $query = $this->db->query("SELECT * FROM User_account WHERE ID = '$id' ");

        if(!$query){
            return $this->db->error;
        }

        return $this->first_row($query);

    }

    public function update_user_details(){

        if(
            empty($this->User_first_name) 
         || empty($this->User_middle_name) 
         || empty($this->User_last_name)
         || empty($this->User_sex)
         || empty($this->User_date_of_birth)
         || empty($this->User_phone_number)
         ){
             return array('error'=>true, 'message' => REQUIRED_FIELD);
         }
 
         $query = $this->db->query("UPDATE User_account 
            SET
            User_position_id='$this->User_position_id',
            First_name='$this->User_first_name',
            Middle_name='$this->User_middle_name',
            Last_name='$this->User_last_name',
            Date_of_birth='$this->User_date_of_birth',
            Sex='$this->User_sex',
            Phone_number='$this->User_phone_number'
            WHERE `User_account`.ID='$this->User_ID'
            ");
         if(!$query){
             return $this->db->error;
         }
 
         return array('error'=>false, 'message' => SUCCESS);
    }

    public function update_user_status(){
       

        if(
            empty($this->User_ID) 
        ||  empty($this->User_status) 

        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $this->User_status = ($this->User_status=="ACTIVE") ? 0 : 1;

        $query = $this->db->query("UPDATE User_account 
        SET
        Active='$this->User_status',
        Datetime_deactivated=now()
        WHERE `User_account`.ID='$this->User_ID'
        ");
        
    if(!$query){
        return $this->db->error;
    }

        return array('error'=>false, 'message' => SUCCESS);
    }
    
    public function update_user_picture(){
        if(
            empty($this->User_ID)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        } 

        $query = $this->db->query("UPDATE User_account 
        SET
        Image_file='$this->Image_file'
        WHERE `User_account`.ID='$this->User_ID'
        ");

        if(!$query){
            return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);
        
    }


}


?>