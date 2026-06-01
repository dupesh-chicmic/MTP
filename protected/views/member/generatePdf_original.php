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
        $header = 'CAR SALES GUIDE ';
        
        $this->SetY(15);
        if(FONT_LANG == 'en'){ $this->SetFont('helvetica', '', 15); }
        else{ $this->SetFont(DOCUMENT_FONT, 'B', 17); }
        
        $this->Cell(0, 0, $header, 0, false, 'C', 0, '', 0, true, 'M', 'M');
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


    if($_GET['m']=='UsedCarsModel'){
        $with='usedCarsModels';
    }else{
        $with='usedComCarsModels';
    }
    
$lrpCrp = substr($model[$with][0]['price'],0,3);
$price = substr($model[$with][0]['price'],4);
$yearFromTo = $model[$with][0]['years'];

//dane
$maker=$model[$with][0]['maker'];
$vehicle=$model[$with][0]['vehicle'];
$body=$model[$with][0]['body'];
$badge=$model[$with][0]['badge'];

$spec1=$model[$with][0]['spec1'];
$spec2=$model[$with][0]['spec2'];
$spec3=$model[$with][0]['spec3'];
$spec4=$model[$with][0]['spec4'];

$intro1=$model[$with][0]['intro1'];
$intro2=$model[$with][0]['intro2'];
$intro3=$model[$with][0]['intro3'];
$intro4=$model[$with][0]['intro4'];
$intro5=$model[$with][0]['intro5'];

$note1=$model[$with][0]['note1'];
$note2=$model[$with][0]['note2'];
$note3=$model[$with][0]['note3'];
$note4=$model[$with][0]['note4'];
$note5=$model[$with][0]['note5'];


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MTP');
$pdf->SetTitle('MTP');
$pdf->SetSubject('MTP - '.$maker);
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

.head { font-style: italic; font-weight:bolder; font-size: medium; padding:3px 0px; text-align: left; color:black; width:100%; margin:5px 0px;}

.article_info { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver; }
.article_info_odm { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver;  }

</style>

EOD;

//<div class="head">$header</div><br />

$html .= <<<EOD

        <br />
        <span class="head" style="text-align:center; font-style:normal; padding:20px 0px;">Mileage/Kilometre adjustment</span>
        <br /><br />

<table>
    
    <tr><td class="">Make:</td><td>$maker $vehicle</td></tr>
    <tr><td class="">Body:</td><td>$body</td></tr>
    <tr><td class="">Type:</td><td>$badge</td></tr>
    <tr><td class="">LRP/CRP:</td><td>$lrpCrp</td></tr>
    <tr><td class="">Price:</td><td>$price</td></tr>
    <tr><td class="">Year From/To:</td><td>$yearFromTo</td></tr>

</table>    

<hr></hr>
        
        <span class="head">Guide Prices</span>
        <br />
<table>
    <tr><td class="">Year:</td><td>Miles</td><td>Kms</td><td>&#8364;</td></tr>
EOD;

for($i=0;$i<15;$i++){
    $year = 'yr'.$i;
    $kms = 'kms'.$i;
    $grp = 'GRP'.$i;
    $year = $model[$with][0][$year];
    if($year == '')
        continue;
  
    $kms = $model[$with][0][$kms];
    $grp = $model[$with][0][$grp];
    
$html .= <<<EOD

   <tr><td class="">$year</td><td></td><td>$kms</td><td>$grp</td></tr>
   
EOD;

}

$html .= <<<EOD
</table>

        
<hr></hr>
        
        <span class="head">Engine</span>
        <br />  
<table>
    <tr><td class="">$spec1</td></tr>
    <tr><td class="">$spec2</td></tr>
    <tr><td class="">$spec3</td></tr>
    <tr><td class="">$spec4</td></tr>
</table>


<hr></hr>
      
        <span class="head">Introduced/modified</span>
        <br />  
<table>
    <tr><td class="">$intro1</td></tr>
    <tr><td class="">$intro2</td></tr>
    <tr><td class="">$intro3</td></tr>
    <tr><td class="">$intro4</td></tr>
    <tr><td class="">$intro5</td></tr>
</table>


<hr></hr>
      
        <span class="head">Notes</span>
        <br />
<table>
    <tr><td class="">$note1</td></tr>
    <tr><td class="">$note2</td></tr>
    <tr><td class="">$note3</td></tr>
    <tr><td class="">$note4</td></tr>
    <tr><td class="">$note5</td></tr>
</table>

<hr></hr>
        
        <span class="head">Guide Adjusted Value</span>
        <br />

<table>
    <tr><td class="">Year:</td><td>$userYear</td></tr>
    <tr><td class="">Mileage:</td><td>$userKms Kms</td></tr>
    <tr><td class="">Value:</td><td>$userValue</td></tr>
</table>

EOD;

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->AddPage();

$euro = '&euro;';

$html = <<<EOD
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        td {
            padding: 15px 0;
        }
        
        .center { text-align: center; }
        .imgDiv { margin-top: 20px; text-align: center;}
        .imgDiv img { height: 260px; }
        .tableCarInfo { padding-top: 10px; }
        .bold { font-weight: bold; }
    </style>
EOD;

$html .= <<<EOD
        
<div class="imgDiv">
        <img src="./images/carappraisalpic.jpg" alt="carappraisalpic image" />
</div>

<div class="">
    <table class="tableCarInfo">
        <tr><td width="200" class="bold">Mileage:</td><td width="600">_______________________________________________________</td></tr>
        <tr><td class="bold">No. of Owners:</td><td>_______________________________________________________</td></tr>
        <tr><td class="bold">Service History:</td><td>_______________________________________________________</td></tr>
        <tr><td class="bold">General Desc:</td><td>_______________________________________________________</td></tr>
        <tr><td class="bold">NCT Expires:</td><td>_______________________________________________________</td></tr>
        <tr><td class="bold">Tax Expires:</td><td>_______________________________________________________</td></tr>
        <tr><td class="bold">How was car funded:</td><td>OWN BANK &nbsp;<input type="checkbox" name="carFundedCheckbox" value="1"/>&nbsp;&nbsp;&nbsp;DEALER BANK &nbsp;<input type="checkbox" name="carFundedCheckbox" value="1"/>______________________</td></tr>
 
        <tr><td class="bold"></td><td class="bold">Cost Incl. VAT</td></tr>
        <tr><td class="bold">NCT:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">Mechanical:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">Service:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">T. Belt:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">Body Work:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">Screen:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">Tyres:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">Warranty:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">Cleaning:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">TOTAL REPAIRS:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">GRP:</td><td>$euro ______________________________________________________</td></tr>
        <tr><td class="bold">TOTAL LESS REPAIRS:</td><td>$euro ______________________________________________________</td></tr>
    </table>
</div>
EOD;


$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();
//Close and output PDF document
$pdf->Output('MTP_'.$maker.' '.$vehicle.'.pdf', 'D');
?>
