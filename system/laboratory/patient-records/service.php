<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/root/message.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/reception/patient-details/query.php');

$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;

    $query->Patient_ID = isset($_POST['Patient_id']) ? $_POST['Patient_id'] : NULL;
    $query->Patient_first_name = isset($_POST['Patient_first_name']) ? $_POST['Patient_first_name'] : NULL;
    $query->Patient_middle_name = isset($_POST['Patient_middle_name']) ? $_POST['Patient_middle_name'] : NULL;
    $query->Patient_last_name = isset($_POST['Patient_last_name']) ? $_POST['Patient_last_name'] : NULL;
    $query->Patient_date_of_birth = isset($_POST['Patient_date_of_birth']) ? $_POST['Patient_date_of_birth'] : NULL;
    $query->Patient_sex = isset($_POST['Patient_sex']) ? $_POST['Patient_sex'] : NULL;
    $query->Patient_phone_number = isset($_POST['Patient_phone_number']) ? $_POST['Patient_phone_number'] : NULL;
    $query->Patient_email_address = isset($_POST['Patient_email_address']) ? $_POST['Patient_email_address'] : NULL;


    if($from=='reception-patient-record'){
        if($action=='update-patient-details'){
            echo json_encode($query->update_patient_details());
        }

    }

}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>