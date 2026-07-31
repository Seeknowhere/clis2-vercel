<?php
include_once(ROOT_PATH.'root/message.php');
include_once(ROOT_PATH.'system/admin/user-management/query.php');

$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;
    
    $query->User_username = isset($_POST['User_username']) ? $_POST['User_username'] : NULL;
    $query->User_password = isset($_POST['User_password']) ? $_POST['User_password'] : NULL;

    $query->User_position_id = isset($_POST['User_position']) ? $_POST['User_position'] : NULL;
    $query->User_first_name = isset($_POST['User_first_name']) ? $_POST['User_first_name'] : NULL;
    $query->User_middle_name = isset($_POST['User_middle_name']) ? $_POST['User_middle_name'] : NULL;
    $query->User_last_name = isset($_POST['User_last_name']) ? $_POST['User_last_name'] : NULL;

    $query->User_date_of_birth = isset($_POST['User_date_of_birth']) ? $_POST['User_date_of_birth'] : NULL;
    $query->User_sex = isset($_POST['User_sex']) ? $_POST['User_sex'] : NULL;

    $query->User_phone_number = isset($_POST['User_phone_number']) ? $_POST['User_phone_number'] : NULL;
    $query->User_email_address = isset($_POST['User_email_address']) ? $_POST['User_email_address'] : NULL;

    $query->Search = isset($_POST['Search']) ? $_POST['Search'] : NULL;

    $query->Add_position = isset($_POST['Add_position']) ? $_POST['Add_position'] : NULL;

    if($from=='admin-user-management'){

        if($action=='new-user'){
            echo json_encode($query->add_user());
        }
        if($action=='search-user'){
            echo json_encode($query->search_user());
        }
        if($action=='search-user-position'){
            echo json_encode($query->search_user_position());
        }
        if($action=='add-position'){
            echo json_encode($query->add_position());
        }

    }


}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>