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
        WHERE `lab_transaction`.Lab_transaction_status_id=1 ORDER BY `lab_transaction`.Mode_of_test_id DESC ");

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
        WHERE `lab_transaction`.Lab_transaction_status_id=2 ORDER BY `lab_transaction`.Mode_of_test_id DESC ");

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
        WHERE `lab_transaction`.Lab_transaction_status_id=3 ORDER BY `lab_transaction`.Mode_of_test_id DESC ");

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
        WHERE `lab_transaction`.Lab_transaction_status_id=4 ORDER BY `lab_transaction`.Mode_of_test_id DESC ");

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
            lab_test.ID,
            lab_test.Abbreviation,
            lab_test.Description,
            lab_test.Price,
            lab_transaction.Datetime_request
            FROM lab_transaction
            LEFT JOIN lab_test ON lab_test.ID=lab_transaction.Lab_test_id
            WHERE Mode_of_test_id=1
            AND DATE(lab_transaction.Datetime_request) >= '$from'
						AND DATE(lab_transaction.Datetime_request) <= '$to'
            GROUP BY Lab_test_id");

        // $query = $this->db->query(
        //     "SELECT
        //     lab_test.ID,
        //     lab_test.Abbreviation,
        //     lab_test.Description,
        //     lab_test.Cost,
        //     lab_transaction.Datetime_request
        //     FROM lab_transaction
        //     LEFT JOIN lab_test ON lab_test.ID=lab_transaction.Lab_test_id
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
            lab_test.ID,
            lab_test.Price
            FROM lab_transaction
            LEFT JOIN lab_test ON lab_test.ID=lab_transaction.Lab_test_id
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
