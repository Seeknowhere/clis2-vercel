<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/root/message.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/settings/query.php');


$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;

    $query->User_account_id = isset($_POST['User_account_id']) ? $_POST['User_account_id'] : NULL;
    $query->Old_password = isset($_POST['Old_password']) ? $_POST['Old_password'] : NULL;
    $query->New_password = isset($_POST['New_password']) ? $_POST['New_password'] : NULL;
    $query->Retype_new_password = isset($_POST['Retype_new_password']) ? $_POST['Retype_new_password'] : NULL;

    if($from=='settings'){

        if($action=='change-password'){
            echo json_encode($query->change_password());
        }

        
    }

   

}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>