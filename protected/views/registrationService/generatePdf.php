<?php
define("FONT_LANG", 'en');
define("DOCUMENT_FONT",'times');
//define("DOCUMENT_DATA",$importTitle);
/* --------------- */
// override default header and footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        //$this->Image('./images/lg.jpg', 10, '', 37, 0, 'JPG', 'http://www.mtp.com', '', true, 300, '', false, false, 0, false, false, false);
        // Set font
        // Title
        $header = 'MOTOR TRADE PUBLISHERS';

        $this->SetY(15);
        if(FONT_LANG == 'en'){ $this->SetFont('helvetica', '', 15); }
        else{ $this->SetFont(DOCUMENT_FONT, 'B', 17); }

        $this->Cell(0, 0, $header, 0, false, 'C', 0, '', 0, true, 'M', 'M');
        $this->SetY(20);
        $this->Cell(0, 0, "The Car Sales Guide", 0, false, 'C', 0, '', 0, true, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        if(FONT_LANG == 'en'){ $this->SetFont('helvetica', '', 8); }
        else{ $this->SetFont(DOCUMENT_FONT, '', 8); }
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        $this->Cell(0, 40, 'www.mtp.ie', 0, false, 'R', 0, '', 0, true, 'M', 'M');
    }

}

$lvRIVehicleData = new RIVehicleData();
$checksOnly = true;// Yii::app()->user->getIsCheckOnly(); //@todo: płatny/nie płatny zależy od wyboru użytkownika (czy chce pełne dane pojazdu czy podstawowe), nie jest to cecha samego użytkownika.
$model = ($checksOnly) ? $lvRIVehicleData->vehicleFreeReport($_GET['vnumber']) : $lvRIVehicleData->queryVehicle($_GET['vnumber']);
// zebranie danych
$make = $model['VehicleData']['Make'];
$modelVehicle = $model['VehicleData']['Model'];
$colour = $model['VehicleData']['Colour'];
$fuelType = $model['VehicleData']['Fuel_Type'];
$engineSize = $model['VehicleData']['Engine_Size'];
$registrationNumber = $model['VehicleData']['Registration']; //olek: dopisałem bo brakuje tej zmiennej przy free checks w linii 128
if(!$checksOnly){
    $doors = $model['VehicleData']['Doors'];
    $bodyType = $model['VehicleData']['Body_Type'];
    $yearManufactured = $model['VehicleData']['Year_Manufacture'];
    $coTwoEmission = $model['VehicleData']['CO2_Emissions'];
//    $taxRateType = $model['VehicleData']['Tax_Rate_Type'];
    $taxCost = $model['VehicleData']['Tax_Cost'];
    $transmission = $model['VehicleData']['Transmission'];
//    if(is_array($model['Valuation']['Value'])){
//        $value = $model['Valuation']['Value']['@value'];
//    }else{
//        $value = $model['Valuation']['Value'];
//    }

//    $range = $model['Valuation']['Range'];
    $registrationNumber = $model['VehicleData']['Registration'];
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MTP');
$pdf->SetTitle('MTP');
$pdf->SetSubject('MTP - '.$make);
$pdf->SetKeywords('MTP');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
//$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont(DOCUMENT_FONT, '', 12);

// add a page
$pdf->AddPage();

$html = <<<EOD
<style>

.head { font-style: italic; font-weight:bolder; font-size: medium; padding:10px 0px; text-align: left; color:black; width:100%; margin:5px 0px;}

.article_info { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver; }
.article_info_odm { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver;  }

</style>

EOD;

//<div class="head">$header</div><br />

if($checksOnly){ // free

$html .= <<<EOD
        <br />
        <span class="head" style="text-align:center; font-style:normal; padding:20px 0px;">Vehicle Data for $registrationNumber</span>
        <br /><br />

<table>

    <tr><td class="">Make:</td><td>$make</td></tr>
    <tr><td class="">Model:</td><td>$modelVehicle</td></tr>
    <tr><td class="">Colour:</td><td>$colour</td></tr>
    <tr><td class="">Fuel:</td><td>$fuelType</td></tr>
    <tr><td class="">Engine:</td><td>$engineSize</td></tr>

</table>

<hr></hr>
EOD;

} else { // paid

$html .= <<<EOD
        <br />
        <span class="head" style="text-align:center; font-style:normal; padding:20px 0px;">Vehicle Data for $registrationNumber</span>
        <br /><br />

<table>

    <tr><td class="">Make:</td><td>$make</td></tr>
    <tr><td class="">Model:</td><td>$modelVehicle</td></tr>
    <tr><td class="">Year:</td><td>$yearManufactured</td></tr>
    <tr><td class="">Colour:</td><td>$colour</td></tr>
    <tr><td class="">Doors:</td><td>$doors</td></tr>
    <tr><td class="">Body:</td><td>$bodyType</td></tr>
    <tr><td class="">Engine:</td><td>$engineSize</td></tr>
    <tr><td class="">Fuel:</td><td>$fuelType</td></tr>

        <tr><td class="">CO2 Emissions:</td><td>$coTwoEmission</td></tr>

        <tr><td class="">Tax amount €:</td><td>$taxCost</td></tr>
        <tr><td class="">Transmission:</td><td>$transmission</td></tr>



</table>

<hr></hr>
EOD;

}


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();
//Close and output PDF document
$pdf->Output('MTP_'.$make.'_'.$modelVehicle.'.pdf', 'D');
?>
