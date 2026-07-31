<?php
/**
 * Created by PhpStorm.
 * User: Hitesh
 * Date: 25-Dec-17
 * Time: 8:09 PM
 */
include_once(ROOT_PATH.'system/reception/service.php');
include_once(ROOT_PATH.'root/library/fpdf/fpdf.php');

if(empty($_GET['tran_num'])){
    header("Location:". root_url().'system/reception' );
    exit();
}
class PDF_reciept extends FPDF {
    function _construct ($orientation = 'P', $unit = 'pt', $format = 'Letter', $margin = 40) {
        $this->FPDF($orientation, $unit, $format);
        $this->SetTopMargin($margin);
        $this->SetLeftMargin($margin);
        $this->SetRightMargin($margin);
        $this->SetAutoPageBreak(true, $margin);
    }

    function Header() {
        $this->SetFont('Arial', 'B', 10);
        $this->Image(ROOT_PATH.'assets/img/company_logo.png',11,10,-200);
        $this->Cell(0, 1, "ST. EZEKIEL MORENO CLINICAL LABORATORY", 0, 1, 'C', false);
        $this->Cell(0, 7, "Prk. St. Ezekiel Moreno, Phase III, Brgy Handumanan, Bacolod City", 0, 1, 'C', false);
        $this->Cell(0, 1, "Contact #: 732-XXXX/09XXXXXXXXX", 0, 1, 'C', false);
        $this->Line(10, 30, 200, 30);
        $this->Ln(7);
    }

    function Footer() {

        $this->SetXY(0,-10);
        $this->Cell(0, 8, "This is not official receipt. This is system receipt generated.", 0, 1, 'C', false);
        $this->Line(10, 285, 200, 285);
    }

    function PriceTable($products, $quantity, $prices, $package_price=NULL) {

        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(0);
        $this->SetFillColor(238);
        $this->SetLineWidth(0.2);
        $this->Cell(8, 10, "#", 'LTR', 0, 'L', true);
        $this->Cell(62, 10, "Lab test taken", 'LTR', 0, 'C', true);
        $this->Cell(60, 10, "Quantity", 'LTR', 0, 'C', true);
        $this->Cell(60, 10, "Price", 'LTR', 1, 'C', true);

        $this->SetFont('Arial', '');
        $this->SetFillColor(238);
        $this->SetLineWidth(0.2);
        $fill = false;

        for ($i = 0; $i < count($products); $i++) {
            $this->Cell(8, 8, $i+1, 1, 0, 'L', $fill);
            $this->Cell(62, 8, $products[$i], 1, 0, 'L', $fill);
            $this->Cell(60, 8, $quantity[$i], 1, 0, 'C', $fill);
            $this->Cell(60, 8, $prices[$i], 1, 1, 'R', $fill);
            $fill = !$fill;
        }

        $this->Cell(130, 10, "Total", 1);
        if(empty($package_price)){
            $this->Cell(60, 10, array_sum($prices), 1, 1, 'R');
        }else{
            $this->Cell(60, 10, $package_price, 1, 1, 'R');
        }

    }
    
}


$pdf = new PDF_reciept();

$transaction_number = $query->lab_transaction_number($_GET['tran_num']);

// var_dump($transaction_number);

if(empty($transaction_number) || empty($_SESSION['user_data'])){
    header("Location:". root_url().'system/reception' );
    exit();
}

$pdf->AddPage();
$pdf->Ln(7);
$pdf->Cell(55, 10, 'Transaction number', 0, 0);
$pdf->Cell(58, 10, ': '.@$transaction_number[0]->Transaction_number, 0, 0);
$pdf->Cell(33, 10, 'Date', 0, 0);
$pdf->Cell(52, 10, ': '.@$transaction_number[0]->Datetime_request, 0, 1);

$pdf->Cell(55, 1, 'Name of Patient', 0, 0);
$pdf->Cell(58, 1, ': '.@$transaction_number[0]->First_name.' '.@$transaction_number[0]->Middle_name.' '.@$transaction_number[0]->Last_name, 0, 0);
$pdf->Cell(33, 1, 'Age', 0, 0);
$pdf->Cell(52, 1, ': '.@(intval(date('Y', time() - strtotime(@$transaction_number[0]->Date_of_birth))) - 1970), 0, 1);
$pdf->Line(10, 50, 200, 50);


// echo json_encode($transaction_number);

$product = array();

$quantity = array();

$price = array();

foreach($transaction_number as $item){
    array_push($product, $item->Abbreviation);
    array_push($quantity, 1);
    
    if(empty($item->Package_price)){
        array_push($price, $item->Price);
    }else{
        array_push($price, "");
    }
    

}

if(!empty(@$transaction_number[0]->Package_price)){
    $package_price = @$transaction_number[0]->Package_price;
}else{
    $package_price = NULL;
}

$pdf->Ln(8);
$pdf->PriceTable($product,$quantity, $price, $package_price);

$pdf->SetXY(10,245);
$pdf->Cell(80, 10, 'Paid by', 0, 0);
$pdf->SetXY(120,245);
$pdf->Cell(80, 10, ': '.@$transaction_number[0]->First_name.' '.@$transaction_number[0]->Middle_name.' '.@$transaction_number[0]->Last_name, 0, 1);



$pdf->Ln();
$pdf->SetXY(10,260);
$pdf->Cell(80, 10, 'Authorized '.$_SESSION['user_data']->Position, 0, 0);

// $pdf->Cell(0, 10, 'Name and Signature',1, 1, 'C');
$pdf->SetXY(122, 260);
$pdf->Cell(80, 10, $_SESSION['user_data']->First_name.' '.$_SESSION['user_data']->Middle_name.' '.$_SESSION['user_data']->Last_name, 0, 1);

$pdf->SetXY(120, 260);
$pdf->Cell(80, 10, ': _________________________', 0, 1);

$pdf->SetXY(120, 266);
$pdf->Cell(65, 10, 'Name and Signature', 0, 1, 'C');
$pdf->Ln();
$pdf->Output();

?>