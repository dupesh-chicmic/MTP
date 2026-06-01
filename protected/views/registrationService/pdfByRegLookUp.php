<?php
define("FONT_LANG", 'en');
define("DOCUMENT_FONT",'times');
//define("DOCUMENT_DATA",$importTitle);
/* --------------- */
// override default header and footer
class MYPDF extends TCPDF {

//    //Page header
//    public function Header() {
//        // Logo
////        $image_file = "./images/logopdf.png";
////        $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//
// //       $this->Image('./images/pdflogo.png', 10, '', 37, 0, 'JPG', 'http://www.mtp.com', '', true, 300, '', false, false, 0, false, false, false);
//// $this->Image('./images/logopdf.png', 15, 140, 75, 113, 'JPG', 'http://www.tcpdf.org', '', true, 150, '', false, false, 1, false, false, false);
//        //        // Set font
//        // Title
//        $header = 'MOTOR TRADE PUBLISHERS';
//
//        $this->SetY(15);
//        if(FONT_LANG == 'en'){ $this->SetFont('helvetica', '', 15); }
//        else{ $this->SetFont(DOCUMENT_FONT, 'B', 17); }
//
////        $this->Cell(0, 0, $header, 0, false, 'C', 0, '', 0, true, 'M', 'M');
////        $this->SetY(20);
////        $this->Cell(0, 0, "", 0, false, 'C', 0, '', 0, true, 'M', 'M');
//    }
//
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

// collect the data
$lvRIVehicleData = new RIVehicleData();
$vehicleData = RegistrationService::getRiDataResults($_GET['vnumber']);
$type = $_GET['type']; // depreciated


$modelData = RegistrationService::getCarCommModel("UsedCarsModel", $vehicleData['code']);
$type = "UsedCarsModel";
if(empty($modelData)) 
{    
    $modelData = RegistrationService::getCarCommModel("UsedComCarsModel", $vehicleData['code']);    
    $type = "UsedComCarsModel";
}

$registrationNumber = strtoupper($_GET['vnumber']);
$vehicleYear = $vehicleData['year'];
$make = $vehicleData['make'];
$modelVehicle = $vehicleData['model'];
$colour = $vehicleData['colour'];
$engine = $vehicleData['engine'];
$fuel = $vehicleData['fuel'];
$transmission = $vehicleData['transmission'];
$CO2 = $vehicleData['CO2'];
$roadTax = $vehicleData['roadTax'];
$importTitle = $vehicleData['importTitle'];

// ASSOCIATED CARS
$main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel($type, $modelData);
$rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel($type, $modelData);

$userGuideKm = RegistrationService::multiplyUserKm($_GET['userGuideKm']);
$changedModelVehicleData = RegistrationService::getChangeRiDataResults($modelData, $vehicleData);
$changedMake = $modelData['maker'];
$changedVehicle = $modelData['vehicle'];

$skipCalc = ($_GET['defaultKmsForYear'] == $_GET['userGuideKm'] || empty($_GET['userGuideKm'])) ? true : false;
// ASSOCIATED CARS CALCULATED
$calculatedMain_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($main_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
$calculatedRest_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($rest_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MTP');
$pdf->SetTitle('MTP');
$pdf->SetSubject('MTP - '.$make);
$pdf->SetKeywords('MTP');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setPrintHeader(false);
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
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
.head { font-style: italic; font-weight:bolder; font-size: large; padding:10px 0px; text-align: left; color: #68b5c2; width:100%; margin:5px 0px;}
.importSubtitle { color: #2D8296; }
.article_info { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver; }
.article_info_odm { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver;  }
.text { font-weight: bolder; }

.associatedCars { margin-top: 20px; padding-top: 20px; }
.headItems { background-color: #e8eae5; font-size: 41px; text-align:left; margin:20px;}
.mtpGuide { background-color: #B4DAE0; font-weight: bolder; font-size: 40px;  text-align:left; }
.mtpOption { background-color: #C3E1E7; font-weight: normal; font-size: 40px;  text-align:left; }
        
</style>

EOD;

$html .= <<<EOD
        <table id="headingTable">
        <tr>
        <td width="162" rowspan="2">
        <div class="imgDiv1"><img src="./images/pdflogo.png"></div>
        </td>
        <td>
        <div class="headingDiv">
               MOTOR TRADE PUBLISHERS<br>
               The Car Sales Guide
        </div>
        </td>
        </tr>
        </table>
        <br/>
        <br/>
        <style>
        .headingDiv {text-align:center;}

        .imgDiv1 {text-align:right;}
        .imgDiv1 img {width:60px; margin-top:20px;}

   </style>
   
   </div>
        <span class="head" style="text-align:left; font-style:normal; padding:20px 0px; text-transform:uppercase;">VEHICLE DATA FOR $registrationNumber</span>
        <span class="importSubtitle">$importTitle</span>
        <br /><br />

<table class="column1">
    <tr>
        <td><span class="text">Vehicle Year</span></td><td>$vehicleYear</td><td><span class="text">Fuel</span></td><td>$fuel</td>

    </tr>
    <tr>
        <td><span class="text">Make</span></td><td>$make</td><td><span class="text">Transmission</span></td><td>$transmission</td>

    </tr>
    <tr>
        <td><span class="text">Model</span></td><td>$modelVehicle</td><td><span class="text">Co2</span></td><td>$CO2</td>

    </tr>
    <tr>
        <td><span class="text">Colour</span></td><td>$colour</td><td><span class="text">Road Tax</span></td><td>$roadTax</td>

    </tr>

    <tr>
        <td><span class="text">Engine</span></td><td>$engine</td>
    </tr>
        
        
</table>
        
<span style="border: 1px solid #C3E1E7;"></span> 
<hr></hr>
<span style="border: 1px solid #C3E1E7;"> </span>

<span class="head" style="border-top: 1px solid #C3E1E7; font-style:normal; padding:20px 0px;">MTP ASSOCIATED VALUES FOR: $changedMake $changedVehicle</span>
<br />
<br />
<table>
    <thead>
    <tr class="headItems">
        <th ></th>
        <th width="62">Type</th>
        <th width="65">Doors</th>
        <th width="65">Body</th>
        <th width="85">Transmission</th>
        <th width="59">GRP €</th>
        <th width="75">GRP km Adjustment</th>
        <th width="50">Multiple<br />Opt.</th>
    </tr>
    </thead>
    <tbody>
EOD;


$checkedAllCheckboxes = $_GET['checkedCheckboxes'];

// ASSOCIATED CORE CARS
foreach($main_coreWithAssociatedCarsModel as $item) 
{
    if(RegistrationService::getFieldValueForYear("yr",$vehicleYear, $item) != ''){
        $titleLoopField = (empty($item['corecode'])) ? "MTP Guide" : ((empty($item['linkas'])) ? "MTP Option" : "MTP Option - ".$item['linkas'] );
        $modelLoopField = $item['vehicle'];
        $typeLoopField = $item['badgetype'];
        $doorsLoopField = $item['drs'];
        $bodyLoopField = $item['bod'];
        $transmissionLoopField = $item['transmission'];
        $grpLoopField = RegistrationService::getFieldValueForYear("GRP", $vehicleYear, $item);
//        $adjustmentLoopField = (empty($item['corecode'])) ? '' : RegistrationService::getFieldValueForYear("diff", $vehicleYear, $item);

        $adjustedGrpLoopField = RegistrationService::getCalculatedValueByCodeNumber($calculatedMain_coreWithAssociatedCars, $item['codenumber']);
        
        $guideOptionCSSClass = (empty($item['corecode'])) ? "mtpGuide" : "mtpOption";        
        
        // checkboxes
        $checkboxDisplay = (empty($item['corecode'])) ? "display: none;" : "";
        $isChecked = (strpos($checkedAllCheckboxes,'checkbox_'.$item['codenumber']) === false) ? "false" : "true";
        
$html .= <<<EOD
    <tr class="$guideOptionCSSClass">
        <td width="177">$titleLoopField</td>
        <td width="73">$typeLoopField</td>
        <td width="54"> $doorsLoopField</td>
        <td width="65">$bodyLoopField</td>
        <td width="85">$transmissionLoopField</td>
        <td width="59">$grpLoopField</td>
        <td width="75">$adjustedGrpLoopField</td>
        <td width="50"><input style="$checkboxDisplay" type="checkbox" name="checkbox" value="1" checked="$isChecked" /></td>
    </tr>
EOD;
    }
} //end foreach core cars

// ASSOCIATED REST CARS
foreach($rest_coreWithAssociatedCarsModel as $item)
{
    if($main_coreWithAssociatedCarsModel[0]['codenumber'] == $item['codenumber'] ||
       $main_coreWithAssociatedCarsModel[0]['codenumber'] == $item['corecode']) {
        continue;
    }
    
    if(RegistrationService::getFieldValueForYear("yr",$vehicleYear, $item) != '')
    {
        $titleLoopField = (empty($item['corecode'])) ? "MTP Guide" : ((empty($item['linkas'])) ? "MTP Option" : "MTP Option - ".$item['linkas'] );
        $modelLoopField = $item['vehicle'];
        $typeLoopField = $item['badgetype'];
        $doorsLoopField = $item['drs'];
        $bodyLoopField = $item['bod'];
        $transmissionLoopField = $item['transmission'];
        $grpLoopField = RegistrationService::getFieldValueForYear("GRP", $vehicleYear, $item);
//        $adjustmentLoopField = (empty($item['corecode'])) ? '' : RegistrationService::getFieldValueForYear("diff", $vehicleYear, $item);
        
        $adjustedGrpLoopField = RegistrationService::getCalculatedValueByCodeNumber($calculatedRest_coreWithAssociatedCars, $item['codenumber']);
        
        $guideOptionCSSClass = (empty($item['corecode'])) ? "mtpGuide" : "mtpOption";
        
        // checkboxes
        $checkboxDisplay = (empty($item['corecode'])) ? "display: none;" : "";
        $isChecked = (strpos($checkedAllCheckboxes,'checkbox_'.$item['codenumber']) === false) ? "false" : "true";
        
$html .= <<<EOD
    <tr class="$guideOptionCSSClass">
        <td width="177">$titleLoopField</td>
        <td width="73">$typeLoopField</td>
        <td width="54"> $doorsLoopField</td>
        <td width="65">$bodyLoopField</td>
        <td width="85">$transmissionLoopField</td>
        <td width="59">$grpLoopField</td>
        <td width="75">$adjustedGrpLoopField</td>
        <td width="50"><input style="$checkboxDisplay" type="checkbox" name="checkbox" value="1" checked="$isChecked" /></td>
    </tr>
EOD;
    }
}

// CUSTOM VALUES
if($checkedAllCheckboxes == '')
{
    $grpCustomValeResult = '';
    $calculatedCustomValue= '';
} else {
    $grpCustomValeResult = $_GET['grpCustomValeResult'];
    $calculatedCustomValue = (!empty($grpCustomValeResult)) ? RegistrationService::odometerCalculationByRegLookUpCustomValue($grpCustomValeResult, $userGuideKm, $vehicleYear, $type, $_GET['coreCodeNumber']) : "";
}
$html .= <<<EOD
    <tr style="font-size: 39px; background-color: #e8eae5; border-top: 1px solid #d0d2ce;">
        <td width="455">CUSTOM VALUE<br />For a combination of MTP Options, select "Multiple Options" for a custom value</td>
        <td width="57">$grpCustomValeResult</td>
        <td width="126">$calculatedCustomValue</td>
    </tr>
EOD;

$euro = '&euro;';

$html .= <<<EOD
    </tbody>
</table>
        
   
<div class="">
    <table class="tableCarInfo">
        
        <tr><td rowspan="20" width="325">     <div class="imgDiv">
        <img src="./images/carappraisalpic.jpg" alt="carappraisalpic image" />
</div>
</td><td width="160" class="bold">Mileage:</td><td width="400">____________________</td></tr>
        <tr><td class="bold">No. of Owners:</td><td>____________________</td></tr>
        <tr><td class="bold">Service History:</td><td>____________________</td></tr>
        <tr><td class="bold">General Desc:</td><td>____________________</td></tr>
        <tr><td class="bold">NCT Expires:</td><td>____________________</td></tr>
        <tr><td class="bold">Tax Expires:</td><td>____________________</td></tr>
 <!--       <tr><td class="bold">How was car funded:</td>
//      <td>OWN BANK &nbsp;<input type="checkbox" name="carFundedCheckbox" value="1"/>&nbsp;&nbsp;&nbsp;<br/>DEALER BANK &nbsp;<input type="checkbox" name="carFundedCheckbox" value="1"/>______________________</td></tr>
// 
//        <tr><td class="bold"></td><td class="bold">Cost Incl. VAT</td></tr>
//        <tr><td class="bold">NCT:</td><td>$euro ____________________</td></tr>
//        <tr><td class="bold">Mechanical:</td><td>$euro ____________________</td></tr>-->
        <tr><td class="bold">Service:</td><td>$euro ____________________</td></tr>
<!--//        <tr><td class="bold">T. Belt:</td><td>$euro ____________________</td></tr>-->
        <tr><td class="bold">Body Work:</td><td>$euro ____________________</td></tr>
<!--//        <tr><td class="bold">Screen:</td><td>$euro ____________________</td></tr>-->
        <tr><td class="bold">Tyres:</td><td>$euro ____________________</td></tr>
<!--//        <tr><td class="bold">Warranty:</td><td>$euro ____________________</td></tr>-->
<!--//        <tr><td class="bold">Cleaning:</td><td>$euro ____________________</td></tr>-->
        <tr><td class="bold">Other:</td><td>$euro ____________________</td></tr>
        <tr><td class="bold">TOTAL REPAIRS:</td><td>$euro ____________________</td></tr>
        <tr><td class="bold">GRP:</td><td>$euro ____________________</td></tr>
        <tr><td class="bold">TOTAL LESS REPAIRS:</td><td>$euro ____________________</td></tr>
    </table>
</div>
EOD;


$pdf->writeHTML($html, true, false, true, false, '');


$html = <<<EOD
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        td {
            padding: 30px 0;
        }
        
        .center { text-align: center; }
        .imgDiv { margin-top: 20px; text-align: center;}
        .imgDiv img { height: 260px; }
        .tableCarInfo { padding-top: 10px; }
        .bold { font-weight: bold; }
    </style>
EOD;

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();
//Close and output PDF document
$pdf->Output('MTP_'.$make.'_'.$modelVehicle.'.pdf', 'D');
?>
