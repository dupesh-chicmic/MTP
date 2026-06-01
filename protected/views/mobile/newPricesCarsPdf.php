<?php

// If we wish to use a GET request.
$pathToFiles = './data/cars/';
$xmlStartFile = 'Alfa Romeo.xml'; // zaraz po wejsciu na strone new prices

$startRangeCode = null;
$rangeName = null;
$seriesName = '';

if (isset($_GET['rangecode'])) {
    $startRangeCode = $_GET['rangecode'];
}

if (isset($_GET['rangename'])) {
    $rangeName = $_GET['rangename'];
}

if (isset($_GET['seriesname']) && $_GET['seriesname']) {
    $seriesName = $_GET['seriesname'] . ' - ';
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
$useragent=$_SERVER['HTTP_USER_AGENT'];
$backurl = $_GET['backurl'];
/*
*   Mobile device detection
*/
if( !function_exists('mobile_user_agent_switch') ){
    function mobile_user_agent_switch(){
        $device = '';
        
        if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') ) {
            $device = "ipad";
        } else if( stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') ) {
            $device = "iphone";
        } else if( stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') ) {
            $device = "blackberry";
        } else if( stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
            $device = "android";
        }
        
        return  $device;
    }
}
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)) || mobile_user_agent_switch() !='') {
    $mcls = "mobileCls";
    $chkcls = 1;
} else {
    $mcls = "desktopCls";
    $chkcls = 0;
}


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
      //  if (FONT_LANG == 'en') {
        //    $this->SetFont('helvetica', '', 8);
       // } else {
      //      $this->SetFont(DOCUMENT_FONT, '', 8);
       // }
		 
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
$pdf->SetMargins(PDF_MARGIN_LEFT, 3, PDF_MARGIN_RIGHT, 3);
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
$pdf->AddPage('L');

$html = <<<EOD
<style>

.head { font-style: italic; font-weight:bolder; font-size: medium; padding:3px 0px; text-align: left; color:black; width:100%; margin:5px 0px; }

.article_info { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver; }
.article_info_odm { color: #000000; padding-left:5px; background-color: #ffffff; text-align: right; border-top:1px solid silver;  }
 .desktopCls{display:none;}
.mobileCls{display:inline-block;}
.mobileCls{display:inline-block;}

</style>

EOD;

//<div class="head">$header</div><br />
$date = date('d-m-Y');
$html .= <<<EOD
        <table id="headingTable" width="100%">
			<tr>
				<td style="text-align:center; font-size:150%; font-family:sans-serif">
					$manufacturer - $seriesName$rangeName <br/>Guide ($date)			 
				</td>
                
			</tr>
			<tr>
				<td style="text-align:center">
					<div class="imgDiv1"><img src="./images/logotopspace.png"></div><br/>
				</td>
			</tr>
            <tr class="$mcls" style="text-align:right;">
                <td><b><a href="$backurl" style="color: #000;font-size:70px !important;">Back</a></b></td>
            </tr>
        </table>
        <br/>
   <style>
        .headingDiv {text-align:center;}
        .imgDiv1 {text-align:center;}
        .imgDiv1 img {width:80px; margin-bottom:20px; }                
   </style>

EOD;
$euro = '&euro;';
        
$html .= <<<EOD
        
<table class="items" style="padding-bottom:-35px;padding-top:10px; text-align:center; font-family:sans-serif" width="100%">
    <tr style="">
	   <td class="heading" width="70"><b>Model</b></td>	
		<td class="heading" width="220"><b>Variant</b></td>
		<td class="heading text-right" width="50"><b>Drs</b></td>
		<td class="heading" width="70"><b>Body</b></td>
		<td class="heading text-right" width="60"><b>Fuel</b></td>
		<td class="heading text-right" width="110"><b>Transmission</b></td>
		<td class="heading" width="50"><b>cc</b></td>
		<td class="heading" width="50"><b>Bhp</b></td>
		<td class="heading" width="50"><b>Co2</b></td>
		<td class="heading" width="60"><b>Band</b></td>
		<td class="heading" width="60"><b>Tax</b></td>   
		<td class="heading" width="100"><b>Retail</b></td>
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
			$model= $rangeName; 
			$varient=$reader->getAttribute('variant');
			$doors=$reader->getAttribute('doors');
			$body=$reader->getAttribute('body');
			$engine=$reader->getAttribute('cc');
			$bhp=$reader->getAttribute('bhp');
			$co2=$reader->getAttribute('co2');
			$vrt=$reader->getAttribute('vrt');
			$band=$reader->getAttribute('band');
			$tax=$reader->getAttribute('tax');
			$fuel=$reader->getAttribute('fuel');
			$retail=$reader->getAttribute('retail');
			$transmission=$reader->getAttribute('transmission');

//$div = gmp_div_r($i, 12);
$div = $i%12;
//var_dump($div);
if ($i>11 && $div==0){
    $headingString1 = '<tr>
	<td colspan="12"></td></tr> 
	<br pagebreak="true"/>
	<tr style="">
 <td class="heading" width="70"><b>Model</b></td>	
		<td class="heading" width="220"><b>Variant</b></td>
		<td class="heading text-right" width="50"><b>Drs</b></td>
		<td class="heading" width="70"><b>Body</b></td>
		<td class="heading text-right" width="60"><b>Fuel</b></td>
		<td class="heading text-right" width="110"><b>Transmission</b></td>
		<td class="heading" width="50"><b>cc</b></td>
		<td class="heading" width="50"><b>Bhp</b></td>
		<td class="heading" width="50"><b>Co2</b></td>
		<td class="heading" width="60"><b>Band</b></td>
		<td class="heading" width="60"><b>Tax</b></td>   
		<td class="heading" width="100"><b>Retail</b></td>
	</tr>';

}
else{
    $headingString='';
}


$html .= <<<EOD
        $headingString
                <tr>
                <td class="content">$model</td>
                <td class="content">$varient</td>                
                <td class="content text-right">$doors</td>
                <td class="content">$body</td>
				<td class="content text-right">$fuel</td>
				<td class="content text-right">$transmission</td>				
				<td class="content">$engine</td>
                <td class="content">$bhp</td>
                <td class="content">$co2</td>
                <td class="content">$band</td>
                <td class="content">$tax</td>                
                <td class="content">$euro $retail</td>
                </tr>
   <style>
   table{border: 0px solid #fff;}
     .heading{text-align:left;background-color: #313131;height:46px;color: #fff;}
        .items{margin: 0 auto;}
        .content{padding:5px; height:60px; color: #313131; text-align: left;}
        .items{margin: 0 auto;}
		.items th{color: #fff;}
		.items td{border: 1px solid #313131;}
		.items td.text-right{text-align: right;}
   </style>

EOD;
$i++;      }
        $reader->close();
    }
$html .= <<<EOD
</table>
EOD;

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->lastPage();
        $date = date('dmY');
//Close and output PDF document
//$pdf->Output('MTP_' . $maker . ' ' . $vehicle . '.pdf', 'D');
if($chkcls !=1) {
$pdf->Output('MTP_'.$manufacturer.'_'.$rangeName.'_'.$date. '.pdf', 'D');
}
else {
$base64PdfString = $pdf->Output('MTP_'.$manufacturer.'_'.$rangeName.'_'.$date. '.pdf', 'E');
$base64PdfArray  = explode("\r\n", $base64PdfString);
$base64          = '';
for($i = 5; $i < count($base64PdfArray); $i++){
    $base64 .= $base64PdfArray[$i];
}
$pdfUrl = 'data:application/pdf;base64,'.$base64EncodedString;
?>  
<doctype html>
<html>
    <head>
        <script>
            var base64String = '<?php echo $base64; ?>';
            var binStr = atob( base64String);
            var len = binStr.length;
            var arr = new Uint8Array(len);
            for (var i = 0; i < len; i++) {
            arr[ i ] = binStr.charCodeAt( i );
            }

            var blob = new Blob( [ arr ], { type: "application/pdf" } )
            var url = URL.createObjectURL( blob );



var obj = document.createElement('iframe');
obj.style.width = '100%';
obj.style.height = '100%';
obj.type = 'application/pdf';
obj.data = 'data:application/pdf;base64,' + url ;
obj.src = "https://theguide.ie/dev/pdf/web/viewer.html?file="+url;
obj.allowfullscreen = "allowfullscreen";
document.body.appendChild(obj);
</script>
</head>

</html>
<?php } ?>

