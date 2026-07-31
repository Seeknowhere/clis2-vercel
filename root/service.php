<?php
include_once(ROOT_PATH.'root/message.php');
include_once(ROOT_PATH.'root/query.php');

$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;
    
    $query->Username = isset($_POST['username']) ? $_POST['username'] : NULL;
    $query->Password = isset($_POST['password']) ? $_POST['password'] : NULL;

    
    if($from=='login'){
        if($action=='login-attempt'){
            echo json_encode($query->login());
        }
    }


}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>  