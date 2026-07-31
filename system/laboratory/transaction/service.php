<?php

include_once(ROOT_PATH.'root/message.php');
include_once(ROOT_PATH.'root/library/excel/PHPExcel.php');
include_once(ROOT_PATH.'root/library/excel/PHPEXCEL/IOFactory.php');
include_once(ROOT_PATH.'root/library/phpmailer/PHPMailerAutoload.php');
include_once(ROOT_PATH.'system/laboratory/transaction/query.php');


$query = new query();

try{

    $from = isset($_POST['from']) ? $_POST['from'] : NULL;
    $action = isset($_POST['action']) ? $_POST['action'] : NULL;

    $query->Patient_id = isset($_POST['Patient_id']) ? $_POST['Patient_id'] : NULL;

    $query->Lab_transaction_id = isset($_POST['Lab_transaction_id']) ? $_POST['Lab_transaction_id'] : NULL;

    $query->Lab_test_id = isset($_POST['Lab_test_id']) ? $_POST['Lab_test_id'] : NULL;

    $query->Json = isset($_POST['Json']) ? $_POST['Json'] : NULL;

    $query->Lab_result = isset($_POST['Lab_result']) ? json_decode($_POST['Lab_result']) : NULL;

    $query->Lab_transaction_status_id = isset($_POST['Lab_transaction_status_id']) ? $_POST['Lab_transaction_status_id'] : NULL;

    $query->User_username = isset($_POST['User_username']) ? $_POST['User_username'] : NULL;

    $query->User_password = isset($_POST['User_password']) ? $_POST['User_password'] : NULL;

    $query->Lab_test_template_id = isset($_POST['lab_test_template_id']) ? $_POST['lab_test_template_id'] : NULL;
    $query->Lab_test_template_value = isset($_POST['lab_test_template_value']) ? $_POST['lab_test_template_value'] : NULL;


    $mail = new PHPMailer(TRUE);

// /* Open the try/catch block. */
// try {

// }
// catch (Exception $e)
// {
//    /* PHPMailer exception. */
//    echo $e->errorMessage();
// }
// catch (\Exception $e)
// {
//    /* PHP exception (note the backslash to select the global namespace Exception class). */
//    echo $e->getMessage();
// }


    if($from=='laboratory'){

        if($action=='accept-request'){

            echo json_encode($query->accept_request());

        }
        if($action=='release-result'){

            echo json_encode($query->releast_result());

        }

        if($action=="notify"){




            // var_dump(itexmo("09289342924", "THIS is sample message",  "TR-JOSEP342924_1JC2X", "5qv!&($@2@"));
            // var_dump(itexmo("09289342924", "THIS is sample message",  "TR-JOSEP342924_1JC2X", "5qv!&($@2@"));

            // echo json_encode(array('error'=>false, 'message' => SUCCESS));
        }
        if($action=='ready-to-pickup'){

            // $data = $query->ready_to_pickup();

            // $response = array(
            //     'error'=>false,
            //     'message' => SUCCESS,
            //     'Abbreviation' => @$data->Abbreviation,
            //     'Description' => @$data->Description,
            //     'Email_address' => @$data->Email_address,
            //     'Datetime' => date('Y-m-d H:i:s'),
            //     'Json' => @$data->Json
            // );

            // echo json_encode($response);



            $data = $query->ready_to_pickup();


            // return false;
            $object = new PHPExcel();

            $objReader = PHPExcel_IOFactory::createReader('Excel2007');

            $objPHPExcel = $objReader->load(ROOT_PATH."assets/microsoft-office/excel-template/".$data[0]->File_name);

            $objPHPExcel->setActiveSheetIndex(0);
            // Define Values
            $requirement = ["Name", "Date", "Age", "Gender", "Medtech"];
            foreach($data as $item){
                $coordinates = explode(',',$item->Coordinate);

                $date = new DateTime($item->Date_of_birth);
                $now = new DateTime();
                $interval = $now->diff($date);
                $addrow = 0;

                if($item->Abbreviation=="CBC"){
                    $addrow = 1;
                }

                if($item->Label=="Name"){
                    $item->Value = $item->First_name." ".$item->Middle_name." ".$item->Last_name;
                    $item->Coordinate = $coordinates[0].",". (string)((int)$coordinates[1]+$addrow);
                }
                if($item->Label=="Date"){
                    $item->Value = date('Y/m/d');
                    $item->Coordinate = $coordinates[0].",". (string)((int)$coordinates[1]+$addrow);
                }
                if($item->Label=="Age"){
                    $item->Value = $interval->y;
                    $item->Coordinate = $coordinates[0].",". (string)((int)$coordinates[1]+$addrow);
                }
                if($item->Label=="Gender"){
                    $item->Value = $item->Sex;
                    $item->Coordinate = $coordinates[0].",". (string)((int)$coordinates[1]+$addrow);
                }
                if($item->Label=="Medtech"){
                    $item->Value = strtoupper($_SESSION['user_data']->First_name.' '.$_SESSION['user_data']->Middle_name.' '.$_SESSION['user_data']->Last_name.', RMT');
                    $item->Coordinate = $coordinates[0].",". (string)((int)$coordinates[1]+$addrow);
                }

                $objPHPExcel->getActiveSheet()->setShowGridlines(false);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue(str_replace( ',', '', $item->Coordinate), $item->Value);
            }

            $objPHPExcel->setActiveSheetIndex(0);

            $object_writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="BPLO report '.date('Y-m-d').'.xls"');
            header('Cache-Control: max-age=0');
            ob_start();
            $object_writer->save('php://output');

            $xlsData = ob_get_contents();

            ob_end_clean();
            // echo json_encode($data[0]->Phone_number);
            // echo json_encode();
            $response =  array(
                'op' => 'ok',
                'filename' => $data[0]->File_name,
                'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData),
                'error'=>false,
                'message' => SUCCESS
            );

            $mail = new PHPMailer(TRUE);
            $mail->IsSMTP();
            $mail->Mailer = "smtp";
            $mail->SMTPDebug  = 0;
            $mail->SMTPAuth   = TRUE;
            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;
            $mail->Host       = "smtp.gmail.com";
            $mail->Username   = "clis.st.ezekiel.moreno@gmail.com";
            $mail->Password   = 'T^vYhhp$aeqOfE^6@O#7CXK$BRoCvQaSMtwdJ80nMJgKowna%!';

            $mail->IsHTML(true);
            $mail->AddAddress($data[0]->Email_address, "asd");
            $mail->SetFrom("clis.st.ezekiel.moreno@gmail.com", "LAB TEST RESULT");
            $mail->Subject = "LAB TEST RESULT";

            $content = "<b>This is a soft copy of your laboratory result.</b>";
            $mail->MsgHTML($content);
            $mail->AddStringAttachment($xlsData, date('YmdHis') . '.xls');
            if(!$mail->Send()) {
                // echo "Error while sending Email.";
                // var_dump($mail);

                return array('error'=>true, 'message' => 'Error while sending Email.');
            } else {
                // echo "Email sent successfully";
            }

            //itexmo($data[0]->Phone_number, "Your laboratory result is ready to pick up at the St. Ezekiel Moreno Health Center",  "TR-CHRIS389637_BF2EG", "@[i}t5!1yz");

            die(json_encode($response));

            return array('error'=>false, 'message' => SUCCESS);

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

function itexmo($number,$message,$apicode,$passwd){
    $ch = curl_init();
    $itexmo = array('1' => $number, '2' => $message, '3' => $apicode, 'passwd' => $passwd);
    curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
              http_build_query($itexmo));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    return curl_exec ($ch);
    curl_close ($ch);
}



?>
