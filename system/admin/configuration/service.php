<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/root/message.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/clis/system/admin/configuration/query.php');


$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;
    
    $query->Search = isset($_POST['Search']) ? $_POST['Search'] : NULL;

    $query->Abbreviation = isset($_POST['Abbreviation']) ? $_POST['Abbreviation'] : NULL;
    $query->Description = isset($_POST['Description']) ? $_POST['Description'] : NULL;
    $query->Price = isset($_POST['Price']) ? $_POST['Price'] : NULL;
    
    $query->Cost = isset($_POST['Cost']) ? $_POST['Cost'] : NULL;
    $query->Package_name = isset($_POST['Package_name']) ? $_POST['Package_name'] : NULL;
    $query->Discount = isset($_POST['Discount']) ? $_POST['Discount'] : NULL;
    $query->Lab_test_id = isset($_POST['Lab_test_id']) ? json_decode($_POST['Lab_test_id']) : NULL;

    if($from=='admin-configuration'){
        if($action=='search-clinic-test'){
            echo json_encode($query->search_clinic_test());
        }
        if($action=='search-clinic-package-test'){
            echo json_encode($query->search_clinic_package_test());
        }
        if($action=='add-clinic-test'){
            
            $valid_extensions = array('xlsx', 'xls'); // valid extensions
            $path = document_url() . "assets/microsoft-office/excel-template/"; // upload directory


            if(empty($_FILES['Template']['size'])){
                echo json_encode(array('error'=>true, 'message' => REQUIRED_FIELD));
                return false;
            }


            if($_FILES['Template']['error'] == 0)
            {

                $file_name = str_replace(' ','_',$_FILES['Template']['name']);
                $tmp = $_FILES['Template']['tmp_name'];
                // get uploaded file's extension
                $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // check's valid format
                if(in_array($ext, $valid_extensions)) 
                { 
                    $path = $path.strtolower($file_name); 

                    if(move_uploaded_file($tmp,$path)) 
                    {
                        $query->File_name = $file_name;
                        echo json_encode($query->add_clinic_test());
                    }
                } 

            }else{
                echo json_encode($query->add_clinic_test());
            }

        }
        if($action=='add-clinic-package-test'){
            echo json_encode($query->add_clinic_package_test());
        }
    }


}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>