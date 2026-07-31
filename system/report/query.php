<?php
include_once(ROOT_PATH.'config.php');
class query{

    public $Lab_test_single_id;
    public $Date_from;
    public $Date_to;


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


        $query = $this->db->query("SELECT * FROM Lab_test ");

        if(!$query){
            return $this->db->error;
        }

        return $this->fetch_all($query);

    }


    public function get_lab_test_list(){

        $query = $this->db->query(
            "SELECT * 
            FROM Lab_test ");
    
            if(!$query){
                return $this->db->error;
            }
    
            return $this->fetch_all($query);
    }

    public function generate_total_sales(){

        $query = null;

        $from =  (!empty($this->Date_from))?date('Y-m-d', strtotime($this->Date_from)):NULL;
        $to =  (!empty($this->Date_to))?date('Y-m-d', strtotime($this->Date_to)):NULL;

        if(empty($this->Lab_test_single_id)){

            $query = $this->db->query(
                "SELECT 
                Lab_test.ID,
                Lab_test.Abbreviation,
                Lab_test.Price,
                Lab_transaction.Datetime_request
                FROM Lab_transaction
                LEFT JOIN Lab_test ON Lab_test.ID=Lab_transaction.Lab_test_id
                WHERE Mode_of_test_id=1 
                AND DATE(Lab_transaction.Datetime_request) >= '$from' 
                AND DATE(Lab_transaction.Datetime_request) <= '$to' GROUP BY Lab_test_id");

        }else{

            $query = $this->db->query(
                "SELECT 
                Lab_test.ID,
                Lab_test.Abbreviation,
                Lab_test.Price,
                Lab_transaction.Datetime_request 
                FROM Lab_transaction
                LEFT JOIN Lab_test ON Lab_test.ID=Lab_transaction.Lab_test_id
                WHERE Mode_of_test_id=1 AND Lab_test_id='$this->Lab_test_single_id' AND Lab_transaction.Datetime_request
                BETWEEN '$this->Date_from' AND '$this->Date_to'GROUP BY Lab_test_id"  );
        }

        if(!$query){
            return $this->db->error; 
        }

        $query = $this->fetch_all($query);

        foreach($query as $item ){
            $item->Price = $this->cost_calculation($item->ID);
            $item->Qty = $this->get_qty($item->ID);
        }

        return $query;
    }


    private function cost_calculation($id){

        $sum_up = 0;

        $query = $this->db->query(
            "SELECT 
            Lab_test.ID,
            Lab_test.Price
            FROM Lab_transaction
            LEFT JOIN Lab_test ON Lab_test.ID=Lab_transaction.Lab_test_id
            WHERE Mode_of_test_id=1 AND Lab_test_id='$id'"
            );

        $query = $this->fetch_all($query);

        foreach($query as $key => $item ){

            $sum_up += $item->Price;
            
        }

        return $sum_up;


    }

    private function get_qty($id){

        $qty = 0;

        $query = $this->db->query(
            "SELECT 
            Lab_test.ID,
            Lab_test.Price
            FROM Lab_transaction
            LEFT JOIN Lab_test ON Lab_test.ID=Lab_transaction.Lab_test_id
            WHERE Mode_of_test_id=1 AND Lab_test_id='$id' GROUP BY Lab_transaction.Transaction_number"
            );

        $query = $this->fetch_all($query);

        foreach($query as $key => $item ){

            $qty++;
            
        }

        return $qty;


    }


}


?>