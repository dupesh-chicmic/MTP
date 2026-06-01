<?php
$pathToFiles = './data/commercial/';
$xmlStartFile = 'Audi.xml'; // zaraz po wejsciu na strone new prices

$startRangeCode = null;
$rangeName = null;

if (isset($_GET['rangecode'])) {
    $startRangeCode = $_GET['rangecode'];
}

if (isset($_GET['rangename'])) {
    $rangeName = $_GET['rangename'];
}

if (isset($_GET['make'])) {
    $make_file = $pathToFiles . urldecode($_GET['make']);
    $xmlStartFile = $_GET['make'];
} else {
    $make_file = $pathToFiles . $xmlStartFile;
}

if (!file_exists($make_file)) {
    echo 'File <b>' . $make_file . '</b> not exists.';
    die;
}
$file = $make_file;

$xml=simplexml_load_file($file) or die("Error: Cannot create object");
$manufacturer=$xml->vehicle[0]['manufacturer'];
$reader = new XMLReader();


//if (file_exists($file)) {
//    if (!$reader->open($file)) {
//        die("Failed to open " . $file);
//    }
//    $i=0;
//    while ($reader->read()) {
//        if ($reader->getAttribute('model') == '')
//            continue;
//        
//    }
//}
define("FONT_LANG", 'en');
define("DOCUMENT_FONT", 'times');

//define("DOCUMENT_DATA",$importTitle);
/* --------------- */
// override default header and footer
class MYPDF extends TCPDF {

//Page header
//    public function Header() {
//        // Logo
//        $this->Image('./images/pdflogo.png', 10, '', 37, 0, 'PNG', 'http://www.mtp.com', '', true, 300, '', false, false, 0, false, false, false);
//        // Set font
//        // Title
//        $header = 'CAR SALES GUIDE ';
//        
//        $this->SetY(15);
//        if(FONT_LANG == 'en'){ $this->SetFont('helvetica', '', 15); }
//        else{ $this->SetFont(DOCUMENT_FONT, 'B', 17); }
//        
////        $this->Cell(0, 0, $header, 0, false, 'C', 0, '', 0, true, 'M', 'M');
//        $this->Cell(0, 15,$header, 0, false, 'C', 0, '', 0, false, 'M', 'M');
//    }
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

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MTP');
$pdf->SetTitle('MTP');
//$pdf->SetSubject('MTP - ' . $maker);
$pdf->SetKeywords('MTP');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT, 0);
$pdf->SetHeaderMargin(5);
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
$pdf->setPrintFooter(true);

// add a page
$pdf->AddPage();

$html = <<<EOD
<style>

.head { font-style: italic; font-weight:bolder; font-size: medium; padding:3px 0px; text-align: left; color:black; width:100%; margin:5px 0px;}

.article_info { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver; }
.article_info_odm { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver;  }

</style>

EOD;

//<div class="head">$header</div><br />

$html .= <<<EOD
        <table id="headingTable">
        <tr>
        <td width="162" rowspan="3">
        <div class="imgDiv1"><img src="./images/logotopspace.png"></div>
        </td>
        <td rowspan="3">
        <div class="headingDiv" valign="middle">
               <h3>$manufacturer Guide</h3><br>
        </div>
        </td>
        </tr>
        </table>

   <style>
        .headingDiv {text-align:center;}

        .imgDiv1 {text-align:right;}
        .imgDiv1 img {width:60px; margin-top:20px;}
        
   </style>

EOD;
$euro = '&euro;';
$bodyW="80";
$modelW="120";
        
$html .= <<<EOD
<div style="width:100%;margin:0 auto;">
<table class="items" style="padding-bottom:-35px;padding-top:10px; text-align:center;">
    <tr style="">
    <td class="heading" width="$modelW";><b>Model</b></td>
    <td class="heading" width="$bodyW";><b>Body</b></td>
    <td class="heading" width="60";><b>GVW</b></td>
    <td class="heading" width="40";><b>CC</b></td>
    <td class="heading" width="50";><b>Cat</b></td>
    <td class="heading" width="40";><b>Co2</b></td>
    <td class="heading" width="50";><b>Drive</b></td>
    <td class="heading" width="50";><b>VRT / Band</b></td>
    <td class="heading" width="60";><b>Fuel</b></td>
    <td class="heading" width="60";><b>Tax</b></td>
    <td class="heading" width="70";><b>Retail</b></td>
</tr>

EOD;

$i = 1;
if (file_exists($file)) {
    if (!$reader->open($file)) {
        die("Failed to open " . $file);
    }
    
    while ($reader->read()) {
        if ($reader->getAttribute('model') == '')
            continue;
        if ($reader->getAttribute('rangecode') != $startRangeCode)
            continue;
$model=$reader->getAttribute('model');
$body=$reader->getAttribute('body');
$gvw=$reader->getAttribute('gvw');
$cc=$reader->getAttribute('cc');
$cat=$reader->getAttribute('cat');
$co2=$reader->getAttribute('co2');
$drive=$reader->getAttribute('drive');
$vrt=$reader->getAttribute('vrt');
$band=$reader->getAttribute('band');
$fuel=$reader->getAttribute('fuel');
$tax=$reader->getAttribute('tax');
$retail=$reader->getAttribute('retail');


$div = gmp_div_r($i, 10);
//var_dump($div);
if ($i>9 && $div==0){
    $headingString = '</table><br pagebreak="true"/><br/><br/><br/><table><tr style="padding-top:30px;"><td colspan="10" style="margin-top:20px;"></td></tr><tr style="">    <td class="heading" width="'.$modelW.'";><b>Model</b></td><td class="heading" width="'.$bodyW.'";><b>Body</b></td><td class="heading" width="60";><b>GVW</b></td><td class="heading" width="40";><b>CC</b></td><td class="heading" width="50";><b>Cat</b></td><td class="heading" width="40";><b>Co2</b></td><td class="heading" width="40";><b>Drive</b></td><td class="heading" width="50";><b>VRT / Band</b></td><td class="heading" width="60";><b>Fuel</b></td><td class="heading" width="60";><b>Tax</b></td><td class="heading" width="70";><b>Retail</b></td></tr>';

}
else{
    $headingString='';
}

if($tax != ""){
    $euroConditional='&euro; ';
}
else{
    $euroConditional="";
}


$html .= <<<EOD
        $headingString
                <tr>
                <td class="content">$model</td>
                <td class="content">$body</td>
                <td class="content">$gvw</td>
                <td class="content">$cc</td>
                <td class="content">$cat</td>
                <td class="content">$co2</td>
                <td class="content">$drive</td>
                <td class="content">$vrt<br/>$band</td>
                <td class="content">$fuel</td>
                <td class="content">$euroConditional$tax</td>
                <td class="content">$euro $retail</td>
                </tr>
   <style>
        .heading{text-align:center;background-color: #e8eae5;height:70px;}
        .content{padding:8px 0px;border-bottom:0.5px #e8eae5;height:85px;text-align:center;}
        .items{margin: 0 auto;}
   </style>

EOD;
$i++;      }
        $reader->close();
    }
$html .= <<<EOD
</table>
</div>
 
EOD;

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->lastPage();
//Close and output PDF document
//$pdf->Output('MTP_' . $maker . ' ' . $vehicle . '.pdf', 'D');
         $date = date('dmY');
        $pdf->Output('MTP_commercial-vehicles_'.$manufacturer.'_'.$rangeName.'_'.$date. '.pdf', 'D');
        //$pdf->Output('MTP_commercial-vehicles_' . "manufacturer" . '_' . "$manufacturer" . '.pdf', 'D');
?>
