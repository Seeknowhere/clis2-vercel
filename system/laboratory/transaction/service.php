<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/clis/root/message.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/laboratory/transaction/query.php');

$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;

    $query->Patient_id = isset($_POST['Patient_id']) ? $_POST['Patient_id'] : NULL;

    $query->Lab_transaction_id = isset($_POST['Lab_transaction_id']) ? $_POST['Lab_transaction_id'] : NULL;

    $query->Lab_test_id = isset($_POST['Lab_test_id']) ? $_POST['Lab_test_id'] : NULL;

    $query->Json = isset($_POST['Json']) ? $_POST['Json'] : NULL;

    $query->Lab_transaction_status_id = isset($_POST['Lab_transaction_status_id']) ? $_POST['Lab_transaction_status_id'] : NULL;

    $query->User_username = isset($_POST['User_username']) ? $_POST['User_username'] : NULL;

    $query->User_password = isset($_POST['User_password']) ? $_POST['User_password'] : NULL;

    $query->Lab_test_template_id = isset($_POST['lab_test_template_id']) ? $_POST['lab_test_template_id'] : NULL;
    $query->Lab_test_template_value = isset($_POST['lab_test_template_value']) ? $_POST['lab_test_template_value'] : NULL;

    
    if($from=='laboratory'){

        if($action=='accept-request'){

            echo json_encode($query->accept_request());
            
        }
        if($action=='release-result'){

            echo json_encode($query->releast_result());
            
        }
        if($action=='ready-to-pickup'){

            $data = $query->ready_to_pickup(); 
            
            $response = array(
                'error'=>false, 
                'message' => SUCCESS,
                'Abbreviation' => @$data->Abbreviation,
                'Description' => @$data->Description,
                'Email_address' => @$data->Email_address,
                'Datetime' => date('Y-m-d H:i:s'),
                'Json' => @$data->Json

            );
            
            echo json_encode($response);

        }

        if($action=='lab-test-template-preview'){
            
            echo json_encode($query->lab_test_template_preview());
            
        }

        if($action=='lab-test-template'){
            
            echo json_encode($query->lab_test_template());
            
        }

        if($action=='redo-lab-test'){
            
            echo json_encode($query->redo_lab_test());
            
        }


      
    }


}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>