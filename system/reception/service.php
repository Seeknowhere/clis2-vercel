<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/root/message.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/reception/query.php');


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

    $query->Search_patient = isset($_POST['Search_patient']) ? $_POST['Search_patient'] : NULL;

    $query->Lab_single_test_id = isset($_POST['Lab_single_test_id']) ? json_decode($_POST['Lab_single_test_id']) : NULL;

    $query->Lab_package_test_id = isset($_POST['Lab_package_test_id']) ? json_decode($_POST['Lab_package_test_id']) : NULL;


    $query->Lab_test_name = isset($_POST['lab_test_name']) ? $_POST['lab_test_name'] : NULL;

    $query->Clinic_lab = isset($_POST['clinic_lab']) ? $_POST['clinic_lab'] : NULL;

    $query->Clinic_location = isset($_POST['clinic_location']) ? $_POST['clinic_location'] : NULL;

    $query->Clinic_price = isset($_POST['clinic_price']) ? $_POST['clinic_price'] : NULL;

    $query->User_id = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;

    if($from=='reception'){

        if($action=='new-patient'){
            echo json_encode($query->add_patient());
        }

        if($action=='search-patient'){
            echo json_encode($query->search_patient());
        }

        if($action=='patient-request'){
            echo json_encode($query->patient_request());    
        }

        if($action=='patient-request-send-out'){
            echo json_encode($query->patient_request_sent_out());    
        }

        if($action=='patient-send-out'){
            echo json_encode($query->patient_send_out());    
        }

        
    }

   

}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>