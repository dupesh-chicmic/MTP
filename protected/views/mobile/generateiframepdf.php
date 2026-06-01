<?php
define("FONT_LANG", 'en');
define("DOCUMENT_FONT", 'times');

//define("DOCUMENT_DATA",$importTitle);
/* --------------- */
// override default header and footer
class MYPDF extends TCPDF {
	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		if (FONT_LANG == 'en') {
			$this->SetFont('helvetica', '', 8);
		} else {
			$this->SetFont(DOCUMENT_FONT, '', 8);
		}
		// Page number
		$this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		$this->Cell(0, 40, 'www.mtp.ie', 0, false, 'R', 0, '', 0, true, 'M', 'M');
	}
}

if ($_GET['m'] == 'UsedCarsModel') {
	$with = 'usedCarsModels';
} else {
	$with = 'usedComCarsModels';
}

$lrpCrp = substr($model['price'], 0, 3);
$price = substr($model['price'], 4);
$yearFromTo = $model['years'];

//dane
$maker = $model['maker'];

$vehicle = $model['vehicle'];
$body = $model['body'];
$badge = $model['badge'];

$spec1 = $model['spec1'];
$spec2 = $model['spec2'];
$spec3 = $model['spec3'];
$spec4 = $model['spec4'];

$intro1 = $model['intro1'];
$intro2 = $model['intro2'];
$intro3 = $model['intro3'];
$intro4 = $model['intro4'];
$intro5 = $model['intro5'];

$note1 = $model['note1'];
$note2 = $model['note2'];
$note3 = $model['note3'];
$note4 = $model['note4'];
$note5 = $model['note5'];


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MTP');
$pdf->SetTitle('MTP');
$pdf->SetSubject('MTP - ' . $maker);
$pdf->SetKeywords('MTP');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 3, PDF_MARGIN_RIGHT);
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


$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$html = <<<EOD
<style>

.head { font-style: italic; font-weight:bolder; font-size: medium; padding:3px 0px; text-align: left; color:black; width:100%; margin:5px 0px;}

.article_info { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver; }
.article_info_odm { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver;  }

</style>

EOD;
// add a page
$pdf->AddPage();
$euro = '&euro;';

$html = <<<EOD
<style>
 .headingDiv {text-align:center;}
.imgDiv1 {text-align:left;}
.imgDiv1 img {width:60px;}
table{width: 100%;}
.publisher_row td{width: 50%;}
.publisher_row td, .publisher_row th {border: 1px solid #000;text-align: left; font-size: 30px;vertical-align:middle; line-height: 7px; font-family: inherit;}
.publisher_row td:first-child{font-weight: bold; text-align: left !important;}
.grey_bg{background-color: #d9d9d9;}
</style>

EOD;
$registerVehicleNumber = isset($regPageContent['vehicle']['registerVehicleNumber'])?strtoupper($regPageContent['vehicle']['registerVehicleNumber']):'__';
$archMonth = isset($regPageContent['archMonth'])?$regPageContent['archMonth']:'__';
$VehicleYear = isset($regPageTableData['Year'])?$regPageTableData['Year']:'__';
$make = isset($regPageTableData['make'])?$regPageTableData['make']:'__';
$model = isset($regPageTableData['model'])?$regPageTableData['model']:'__';
$colour = isset($regPageTableData['colour'])?$regPageTableData['colour']:'__';
$engine = isset($regPageTableData['engine'])?$regPageTableData['engine']:'__';
$fuel = isset($regPageTableData['fuel'])?$regPageTableData['fuel']:'__';
$body = isset($regPageTableData['body'])?$regPageTableData['body']:'__';
$CO2 = isset($regPageTableData['Co2'])?$regPageTableData['Co2']:'__';
$roadTax = isset($regPageTableData['roadTax'])?$regPageTableData['roadTax']:'__';
$veriskCode = isset($regPageTableData['veriskCode'])?$regPageTableData['veriskCode']:'__';

$GUIDEPrice = '__';
if(isset($_GET['gPrice']) && !empty($_GET['gPrice'])){
	$GUIDEPrice = $euro . base64_decode($_GET['gPrice']);
}

$kmss = '__';
if(isset($_GET['gkms']) && !empty($_GET['gkms'])){
	$kmss = base64_decode($_GET['gkms']) . ' Kms';
}

$gdate = '__';
if(isset($_GET['gdate']) && !empty($_GET['gdate'])){
	$gdate = base64_decode($_GET['gdate']);
}
// $GUIDEPrice = isset($regPageTableData['GUIDEPrice'])?$regPageTableData['GUIDEPrice']:'__';
// $kmss = isset($regPageTableData['kmss'])?$regPageTableData['kmss']:'__';
$html .= <<<EOD
			<table id="headingTable" style="width: 100%;">
				<tr>
					<td width="162" rowspan="3">
						<div class="imgDiv1"><img src="./images/logotopspace.png"></div>
					</td>
					<td rowspan="3">
						<div class="headingDiv" valign="middle">
							   <h3>MOTOR TRADE PUBLISHERS<br><span>The Guide</span></h3>
						</div>
					</td>
				</tr>
			</table>
			       
			<table>
			   <tr>
					<td width="100%">
						<table>
						 <tr><td><b>VEHICLE DATA FOR $registerVehicleNumber <span style="text-decoration: underline;">($gdate)</span></b></td></tr>
						 <tr><td></td></tr>
						</table>
					</td>
				</tr>
			</table>
					
			<table>
			   <tr>
					<td width="100%">
						<table class="publisher_row">
							<tr>
								<td class=""><strong>Vehicle Year</strong></td><td>$VehicleYear</td>
								<td class=""><strong>Transmission</strong></td><td>Manual</td>
							</tr>							
							<tr>
								<td class=""><strong>Make</strong></td><td>$make</td>
								<td class=""><strong>Body</strong></td><td>$body</td>
							</tr>
							<tr>
								<td class=""><strong>Model</strong></td><td>$model</td>
								<td class=""><strong>Co2</strong></td><td>$CO2</td>
							</tr>							
							<tr>
								<td class=""><strong>Colour</strong></td><td>$colour</td>
								<td class=""><strong>Road Tax</strong></td><td>$roadTax</td>
							</tr>
							<tr>
								<td class=""><strong>Engine</strong></td><td>$engine</td>
								<td class="grey_bg"><strong>GUIDE PRICE</strong></td><td class="grey_bg">$GUIDEPrice </td>
							</tr>
							<tr>
								<td class=""><strong>Fuel</strong></td><td>$fuel</td>
								<td class="grey_bg"><strong>Kms</strong></td><td class="grey_bg">$kmss</td>
							</tr>
						</table>
					</td>
			   </tr>
			</table>
				<table style="width: 100%; text-align: center">
				 <tr><td></td></tr>
						<tr style="width: 100%; text-align: left"><td><b>Previous Reg:</b></td></tr>
						 <tr><td></td></tr>
					   <tr>
							<td width="100%" style="text-align: center">
							 <img src="./images/carappraisalpic.jpg" alt="carappraisalpic image" class="image-fluid"/>
							</td>
					   </tr>
						 <tr><td></td></tr>
						 <tr><td></td></tr>
				</table>
			<table style="width: 100%">
			   <tr>
					<td width="20%">
						<table class="publisher_row">							
						</table>
					</td>
					<td width="60%">
						<table class="tablemotorInfo publisher_row" >
							<tr><td class="bold"><strong>Mileage (kms)</strong></td><td></td></tr>
							<tr><td class="bold"><strong>No. of Owners</strong></td><td></td></tr>
							<tr><td class="bold"><strong>Service History</strong></td><td></td></tr>
							<tr><td class="bold"><strong>General Description</strong></td><td></td></tr>
							<tr><td class="bold"><strong>NCT Expires</strong></td><td></td></tr>
							<tr><td class="bold"><strong>Tax Expires</strong></td><td></td></tr>
							<tr><td class="bold"><strong>Service</strong></td><td>$euro</td></tr>
							<tr><td class="bold"><strong>Body Work</strong></td><td>$euro</td></tr>
							<tr><td class="bold"><strong>Tyres</strong></td><td>$euro</td></tr>
							<tr><td class="bold"><strong>Other</strong></td><td>$euro</td></tr>
							<tr><td class="bold"><strong>TOTAL REPAIRS</strong></td><td>$euro</td></tr>
							<tr><td class="bold"><strong>GRP: </strong></td><td>$euro</td></tr>
							<tr><td class="bold"><strong>TOTAL LESS REPAIRS </strong></td><td>$euro</td></tr>
						</table>
					</td>
					<td width="20%">
						<table class="publisher_row">							
						</table>
					</td>
			   </tr>
			</table>
			<table style="width: 100%; text-align: center">
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>
				<tr><td></td></tr>					
				<tr style="width: 100%; text-align: center;"><td><b><a href="https://www.theguide.ie/" style="color: #000;">theGuide.ie</a></b></td></tr>
				<tr><td></td></tr>
			</table>
EOD;

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();
// echo "<pre>";
// print_r($pdf);
// die("called");
// Close and output PDF document
$date = date('d-m-Y');
// $pdf->Output('MTP1_' . $maker . ' ' . $vehicle .'__'. $date . '.pdf', 'D');


if($requestFrom == 'mobile'){
	$strData = $pdf->Output('', 'S');
	file_put_contents("/data/mtpintegration/dev/images/test.text","Hello World. Testing!");
	// echo "<pre>";
	// print_r($_SERVER);
	// die;
	// $pdf->Output('MTP1_' . $maker . ' ' . $vehicle .'__'. $date . '.pdf', 'F');
	// $pdf->Output('D','/data/mtpintegration/dev/images/test'.'.pdf', false);
	//$pdf->Output($filePath, 'F');
}else{
	$pdf->Output('MTP1_' . $maker . ' ' . $vehicle .'__'. $date . '.pdf', 'I');
}
?> 