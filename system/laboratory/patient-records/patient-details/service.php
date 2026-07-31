<?php
include_once(ROOT_PATH.'root/message.php');
include_once(ROOT_PATH.'system/laboratory/patient-records/patient-details/query.php');

$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;

    $query->Search = isset($_POST['search']) ? $_POST['search'] : NULL;
    $query->Patient_id = isset($_POST['patient_id']) ? $_POST['patient_id'] : NULL;

    if($from=='lab-logs'){
        if($action=='search-lab-logs'){
            echo json_encode($query->lab_logs());
        }
        

    }

}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>