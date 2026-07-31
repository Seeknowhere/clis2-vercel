<?php
include_once(ROOT_PATH.'root/message.php');
include_once(ROOT_PATH.'system/laboratory/test-supply/query.php');

$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;

    $query->Lab_test_id = isset($_POST['Lab_test_id']) ? $_POST['Lab_test_id'] : NULL;
    $query->Available = isset($_POST['Available']) ? $_POST['Available'] : NULL;

    if($from=='laboratory'){

        if($action=='supply-status'){
            echo json_encode($query->supply_status());
        }
      
    }


}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>