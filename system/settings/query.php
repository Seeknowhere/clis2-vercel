<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $User_account_id;
    public $Old_password;
    public $New_password;
    public $Retype_new_password;

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


    public function change_password(){
    

        if(empty($this->User_account_id) 
        || empty($this->Old_password) 
        || empty($this->New_password)
        || empty($this->Retype_new_password)
        ){
            return array('error'=>true, 'message' => REQUIRED_FIELD);
        }

        $query = $this->db->query("SELECT * FROM User_account WHERE `User_account`.ID='$this->User_account_id' ");

        if(!$query){
            return $this->db->error;
        }

        $query = $this->first_row($query);

        $old_password = md5($this->Old_password);
        $new_password = md5($this->New_password);

        if(!empty($this->Old_password) && $new_password==$query->Password){
            return array('error'=>true, 'message' => SAME_PASSWORD);
        }

        if(!empty($this->Old_password) && $old_password!=$query->Password){
            return array('error'=>true, 'message' => OLD_PASSWORD);
        }
        else if(!empty($this->Old_password) && $this->New_password!=$this->Retype_new_password){
            return array('error'=>true, 'message' => PASSWORD_RETYPE);
        }

  
        $query = $this->db->query("UPDATE User_account SET Password='$new_password' 
        WHERE `User_account`.ID='$this->User_account_id'");
      
        if(!$query){
        return $this->db->error;
        }

        return array('error'=>false, 'message' => SUCCESS);



    }

}


?>