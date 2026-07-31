<?php
include_once(ROOT_PATH.'root/message.php');
include_once(ROOT_PATH.'system/admin/user-management/profile/query.php');

$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;
    
    $query->User_status = isset($_POST['User_status']) ? $_POST['User_status'] : NULL;

    $query->User_ID = isset($_POST['User_id']) ? $_POST['User_id'] : NULL;
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

    $valid_extensions = array('jpeg', 'jpg', 'png'); // valid extensions
    $path = document_url() . "assets/img/user/"; // upload directory

    if($from=='admin-user-management-profile'){
        if($action=='update-user-details'){
            echo json_encode($query->update_user_details());
        }
        if($action=='update-user-status'){
            echo json_encode($query->update_user_status());
        }
        if($action=='update-user-picture'){

            $fileinfo = @getimagesize($_FILES["user_picture"]["tmp_name"]);
            $width = $fileinfo[0];
            $height = $fileinfo[1];

            if ($width != "600" || $height != "600") {
                throw new Exception('Image dimension should be 600X600');
            }
            else if (($_FILES["user_picture"]["size"] > 5000000)) { // 5MB
                throw new Exception('Image size exceeds 5MB');
            }   
            else if($_FILES['user_picture']['error'] == 0)
            {
                $img = $_FILES['user_picture']['name'];
                $tmp = $_FILES['user_picture']['tmp_name'];
                
                // get uploaded file's extension
                $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
                // can upload same image using rand function
                $final_image = 'user_profile_'.rand(1000,1000000).'_'.str_replace(' ','_',$img);
                // check's valid format
                if(in_array($ext, $valid_extensions)) 
                { 
                    $path = $path.strtolower($final_image); 
                    
                    if(move_uploaded_file($tmp,$path)) 
                    {
                        $query->Image_file = $final_image;
                        echo json_encode($query->update_user_picture());
                    }
                } 
            }else{
                echo json_encode($query->update_user_picture());
            }
         
        }
    }
}catch(Exception $e){
    echo json_encode(array('error'=>true, 'message' => (string)$e->getMessage()));
}




?>