<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $Username;
    public $Password;


	public function __construct(){
		$db = new config();
        $this->db = $db->getConnection();
        session_start();
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

    public function login(){

        if(empty($this->Username) || empty($this->Password)){
            return array('error'=>true, 'message' => NO_USER);
        }
        
        $encrypted_password = md5($this->Password);
        

        $query1 = $this->db->query(
            "SELECT * FROM `user_account`
            LEFT JOIN user_position ON user_position.ID=user_account.User_position_id
            WHERE `user_account`.Username='$this->Username' AND `user_account`.Password='$encrypted_password' AND Active = 1 ");

        if(!$query1){
            return $this->db->error;
        }
        // var_dump($this->first_row($query1));
        // var_dump(mysqli_num_rows($query1));
        if(mysqli_num_rows($query1)){
            $_SESSION["user_data"] = $this->first_row($query1);
            return array('error'=>false, 'message' => LOGIN_SUCCESSFULLY);
        }else{
            return array('error'=>true, 'message' => NO_USER);
        }
    }

}


?>