<?php
include_once(ROOT_PATH.'root/message.php');
include_once(ROOT_PATH.'system/report/query.php');


$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;

    $query->Lab_test_single_id = isset($_POST['Lab_test_single_id']) ? $_POST['Lab_test_single_id'] : NULL;
    $query->Date_from = isset($_POST['Date_from']) ? $_POST['Date_from'] : NULL;
    $query->Date_to = isset($_POST['Date_to']) ? $_POST['Date_to'] : NULL;

    if($from=='report'){

        if($action=='total-sales'){

            echo json_encode($query->generate_total_sales());
            
        }

    }

   

}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>