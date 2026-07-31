<?php
include_once(ROOT_PATH.'config.php');
class query{

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
        WHERE `Lab_transaction`.Lab_transaction_status_id=1 ORDER BY `Lab_transaction`.Mode_of_test_id DESC ");

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
        WHERE `Lab_transaction`.Lab_transaction_status_id=2 ORDER BY `Lab_transaction`.Mode_of_test_id DESC ");

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
        WHERE `Lab_transaction`.Lab_transaction_status_id=3 ORDER BY `Lab_transaction`.Mode_of_test_id DESC ");

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
        WHERE `Lab_transaction`.Lab_transaction_status_id=4 ORDER BY `Lab_transaction`.Mode_of_test_id DESC ");

        if(!$query){
            return $this->db->error;
        }
        return $this->fetch_all($query);
    }



    public function generate_total_sales_daily(){

        $query = null;

        // $from =strtotime('today');
        // $to =strtotime('today');

        $from = (date('Y-m-d 00:00:00'));
        $to = (date('Y-m-d 23:23:59'));

        $query = $this->db->query(
            "SELECT
            Lab_test.ID,
            Lab_test.Abbreviation,
            Lab_test.Description,
            Lab_test.Price,
            Lab_transaction.Datetime_request
            FROM Lab_transaction
            LEFT JOIN Lab_test ON Lab_test.ID=Lab_transaction.Lab_test_id
            WHERE Mode_of_test_id=1
            AND DATE(Lab_transaction.Datetime_request) >= '$from'
						AND DATE(Lab_transaction.Datetime_request) <= '$to'
            GROUP BY Lab_test_id");

        // $query = $this->db->query(
        //     "SELECT
        //     Lab_test.ID,
        //     Lab_test.Abbreviation,
        //     Lab_test.Description,
        //     Lab_test.Cost,
        //     Lab_transaction.Datetime_request
        //     FROM Lab_transaction
        //     LEFT JOIN Lab_test ON Lab_test.ID=Lab_transaction.Lab_test_id
        //     WHERE Mode_of_test_id=1 GROUP BY Lab_test_id");

        if(!$query){
            return $this->db->error;
        }

        $query = $this->fetch_all($query);

        foreach($query as $item ){
            $item->Income = $this->cost_calculation($item->ID, 'Income');
            $item->Quantity = $this->cost_calculation($item->ID, 'Quantity');
        }

        return $query;
    }


    private function cost_calculation($id, $request){

        $sum_up = 0;
        $quantity = 0;

        $query = $this->db->query(
            "SELECT
            Lab_test.ID,
            Lab_test.Price
            FROM Lab_transaction
            LEFT JOIN Lab_test ON Lab_test.ID=Lab_transaction.Lab_test_id
            WHERE Mode_of_test_id=1 AND Lab_test_id='$id'");

        $query = $this->fetch_all($query);


        if($request=='Income'){
            foreach($query as $key => $item ){
                $sum_up += $item->Price;

            }
            return $sum_up;
        }else{
            foreach($query as $key => $item ){
                $quantity++;
            }
            return $quantity;
        }






    }


}


?>
