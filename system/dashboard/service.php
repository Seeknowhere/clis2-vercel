<?php
include_once(ROOT_PATH.'root/message.php');
include_once(ROOT_PATH.'system/dashboard/query.php');

$query = new query();

try{

    // $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    // $action = isset($_POST['action']) ? $_POST['action'] : NULL;

    // if($from=='dashboard'){
    //     if($action=='none'){
    //         // echo json_encode($query->accept_request());
    //     }
    // }


}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>