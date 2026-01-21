<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/root/message.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/admin/configuration/edit-lab-test/query.php');


$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;
    

    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $lab_test_id = isset($_POST['lab_test_id']) ? $_POST['lab_test_id'] : NULL;
    $label = isset($_POST['label']) ? $_POST['label'] : NULL;
    $coordinate = isset($_POST['coordinate']) ? $_POST['coordinate'] : NULL;
    $show_field = isset($_POST['show_field']) ? $_POST['show_field'] : NULL;
    $search = isset($_POST['search']) ? $_POST['search'] : NULL;

    if($from=='edit-lab-test'){

        if($action=='add-label'){

            $query->ID = $id;
            $query->Label = $label;
            $query->Coordinate = $coordinate;

            echo json_encode($query->add_label());
        }

        if($action=='update-label'){

            $query->ID = $id;
            $query->Lab_test_id = $lab_test_id;
            $query->Label = $label;
            $query->Coordinate = $coordinate;

            echo json_encode($query->update_label());
        }

        if($action=='delete-label'){

            $query->ID = $id;
            $query->Lab_test_id = $lab_test_id;

            echo json_encode($query->delete_label());
        }

        if($action=='search-label'){

            $query->ID = $id;
            $query->Search = $search;

            echo json_encode($query->search_label());
        }

        if($action=='update-displays'){
            $query->ID = $id;
            $query->Show_field = $show_field;
            echo json_encode($query->update_display_label());
        }

    }


    
}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>