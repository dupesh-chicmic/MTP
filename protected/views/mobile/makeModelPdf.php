<?php define("FONT_LANG", 'en');
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




//dane
$maker = isset($modelPageTableData['maker'])?$modelPageTableData['maker']:'';

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
.desktopCls{display:none;}
.mobileCls{display:inline-block;}
.mobileCls{display:inline-block;}

</style>

EOD;
$archMonth = isset($regPageTableData['archMonth'])?$regPageTableData['archMonth']:'__';
$transmission = isset($regPageTableData['transmission'])?$regPageTableData['transmission']:'__';
$VehicleYear = isset($regPageTableData['year'])?$regPageTableData['year']:'__';
$make = isset($regPageTableData['maker'])?$regPageTableData['maker']:'__';
$model = isset($regPageTableData['vehicle'])?$regPageTableData['vehicle']:'__';
$Type = isset($regPageTableData['badge'])?$regPageTableData['badge']:'__';
$engine = isset($regPageTableData['engine'])?$regPageTableData['engine']:'__';
$fuel = isset($regPageTableData['fuel'])?$regPageTableData['fuel']:'__';
$body = isset($regPageTableData['bod'])?$regPageTableData['bod']:'__';
$Doors = isset($regPageTableData['drs'])?$regPageTableData['drs']:'__';
$veriskCode = isset($regPageTableData['veriskCode'])?$regPageTableData['veriskCode']:'__';
$GUIDEPrice = isset($regPageTableData['GuidePrice'])?$regPageTableData['GuidePrice']:'__';
$kmss = isset($regPageTableData['kmsString'])?$regPageTableData['kmsString']:'__';
$backurl = isset($regPageTableData['backurl'])?$regPageTableData['backurl']:'__';
$useragent=$_SERVER['HTTP_USER_AGENT'];

/*
*	Mobile device detection
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
			<table class="$mcls">
			   <tr>
					<td width="100%">
						<table>
						 <tr style="width: 100%; text-align: right;"><td><b><!-- <a href="$backurl" style="color: #000;font-size:65px !important;">Back</a> --></b></td>
						 </tr> 
						</table>
					</td>
				</tr>
			</table>      
			<table>
			   <tr>
					<td width="100%">
						<table>
						 <tr><td><b>VEHICLE DATA FOR ... <span style="text-decoration: underline;">($archMonth)</span></b></td></tr>
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
								<td class=""><strong>Transmission</strong></td><td>$transmission</td>
							</tr>							
							<tr>
								<td class=""><strong>Make</strong></td><td>$make</td>
								<td class=""><strong>Body</strong></td><td>$body</td>
							</tr>
							<tr>
								<td class=""><strong>Model</strong></td><td>$model</td>
								<td class=""><strong>Doors</strong></td><td>$Doors</td>
							</tr>							
							<tr>
								<td class=""><strong>Type</strong></td><td>$Type</td>
								<td class=""><strong> </strong></td><td> </td>
							</tr>
							<tr>
								<td class=""><strong>Fuel</strong></td><td>$fuel</td>
								<td class="grey_bg"><strong>GUIDE PRICE</strong></td><td class="grey_bg">$GUIDEPrice </td>
							</tr>
							<tr>
								<td class=""><strong></strong></td><td></td>
								<td class="grey_bg"><strong>Kms</strong></td><td class="grey_bg">$kmss</td>
							</tr>
						</table>
					</td>
			   </tr>
			</table>
				<table style="width: 100%; text-align: center">
				 <tr><td></td></tr>
						<tr style="width: 100%; text-align: left"><td><b></b></td></tr>
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

//Close and output PDF document
$date = date('d-m-Y');

// $pdf->Output('MTP1_' . $maker . ' ' . $vehicle .'__'. $date . '.pdf', 'D');
if($chkcls !=1) {
	$pdf->Output('MTP1_' . $maker . ' ' . $vehicle .'__'. $date . '.pdf', 'I'); 
}
else {
$base64PdfString = $pdf->Output('MTP1_' . $maker . ' ' . $vehicle .'__'. $date . '.pdf', 'E');
$base64PdfArray  = explode("\r\n", $base64PdfString);
$base64          = '';
for($i = 5; $i < count($base64PdfArray); $i++){
    $base64 .= $base64PdfArray[$i];
}
// $pdfUrl = 'data:application/pdf;base64,'.$base64EncodedString;
?>
<style>
#the-canvas {
  border: 1px solid black;
  direction: ltr;
}
#text-layer { 
   position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    overflow: hidden;
    opacity: 0.2;
    line-height: 1.0;
}

#text-layer > div {
    color: transparent;
    position: absolute;
    white-space: pre;
    cursor: text;
    transform-origin: 0% 0%;
}

button#pdf-prev {
    position: relative;
    float: right;
    right: 125px;
    background: #FFF;
    border: 0px;
    top: 175px;
    font-family: inherit;
    font-size: 22px;
}
</style>
<div class="pdf-main">
	<div id="pdf-buttons">
		<button id="pdf-prev"><a href="<?php echo $backurl; ?>" style="color: #000;" classs="backlink">Back</a></button>
	</div>
	<canvas id="the-canvas"></canvas>
</div>
<!-- <script src="//mozilla.github.io/pdf.js/build/pdf.js"></script> -->
<script src="https://theguide.ie/dev/pdf/build/pdf.js"></script>
<script src="https://theguide.ie/dev/pdf/build/pdf.worker.js"></script>
<script>
	var pdfData = atob('<?php echo $base64; ?>');
	var pdfjsLib = window['pdfjs-dist/build/pdf'];
	// The workerSrc property shall be specified.
	// pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';
	pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://theguide.ie/dev/pdf/build/pdf.worker.js';
	 // Using DocumentInitParameters object to load binary data.
	const loadingTask = pdfjsLib.getDocument({data:pdfData});
		loadingTask.promise.then(function(pdf) {
	 // Fetch the first page
	 	var pageNumber = 1;
	 	pdf.getPage(pageNumber).then(function(page) {
	 		// var scale 		= 1.0;
	 		var scale 		= 1.6;		
	 		// var viewport = page.getViewport({scale: scale});
	 		var viewport = page.getViewport({scale: scale});
	 		// Prepare canvas using PDF page dimensions
	 		var canvas = document.getElementById('the-canvas');
	 		// var viewport 	= page.getViewport(canvas.width / page.getViewport(1.0).width);
	 		var context = canvas.getContext('2d');
	 		canvas.height = viewport.height;
	 		canvas.width = viewport.width;
	 		// Render PDF page into canvas context
	 		var renderContext = {
	 							canvasContext: context,
	 							viewport: viewport
	 						};
	 		var renderTask = page.render(renderContext);
	 		renderTask.promise.then(function () {
	 		});
	 	});
	}, function (reason) {
	 	// PDF loading error
	 	console.error(reason);
	});
</script>
<?php 
}
?>