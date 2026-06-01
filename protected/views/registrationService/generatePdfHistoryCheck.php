<?php
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

if(!empty($RIdata)) {
    // create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('MTP');
$pdf->SetTitle('MTP');
$pdf->SetSubject('MTP - Vehicle Registration ' . $RIdata['VehicleData']['Registration']);
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
$pdf->SetFont(DOCUMENT_FONT, '', 16);

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// add a page
$pdf->AddPage();

$htmlPdf = '<div>
    <br/>
    <table cellpadding="6" style="line-height:3.5px;  width:100%">
        <thead style="line-height:3.5px; color: #243845;  font-size: 60px;  text-align: left;">
            <tr class="tablePadding">
                <th style="line-height:3.5px;  background-color: #77BDC8;" colspan="4">Vehicle Data for Registration ' . $RIdata['VehicleData']['Registration'] . '</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Vehicle Year</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Year_Manufacture'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Wheelbase</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Wheelbase'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Make</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Make'] .'</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Net Power</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Net_Power'] .'</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Model</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Model'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Gross Vehicle Weight</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Gross_Vehicle_Weight']['@value'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Doors</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Doors'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Unladen Weight</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Unladen_Weight']['@value'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Body</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Body_Type'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Gross Combined Weight</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Gross_Combined_Weight']['@value'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Colour</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Colour'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Number of Axles</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Number_Axles']['@value'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Number of Colour Changes</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Number_Colour_Changes'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; "></td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Windows</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Windows'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Chassis Number</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Chassis_Number'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Seats</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Number_Seats'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Engine Number</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Engine_Number'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Engine</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Engine_Size'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; "></td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">CC</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Engine_CC'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">MTP Value</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Fuel</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Fuel_Type'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">MTP Kms</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';

                    
                    if(is_array($RIdata['Mileages']['Mileage'])) { 
                        $totalMillage = 0;
                        foreach($RIdata['Mileages']['Mileage'] as $key=>$val) {
                            $totalMillage += $val['@attributes']['mileage'];
                        }

                        $htmlPdf .= $totalMillage;
                    }

                    else {
                        $htmlPdf .= $RIdata['Mileages']['Mileage'];
                    }

                $htmlPdf .='</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Transmission</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Transmission'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; "></td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Co2</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['CO2_Emissions'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; "></td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>
        </tbody>
    </table>
    

    <br/><br/>
    

    <table cellpadding="10" style="line-height:3.5px;  width:100%">
        <thead style="line-height:3.5px; color: #243845;  font-size: 60px;  text-align: left;">
            <tr class="tablePadding">
                <th style="line-height:3.5px;  background-color: #77BDC8;" colspan="4">Vehicle Registration</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Registration Certificate Number</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Reg_Cert_Number'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Date of 1 st Registration</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Date_1st_Registration'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Status</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Status']. '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Date of 1 st Registration IE</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Date_1st_Registration_IE'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Registration Status</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Registration_Status'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Previous Registration</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Previous_Registration'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Category</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Category'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Date of Sale</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Date_Of_Sale'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Imported from outside IRE/UK</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">';

                    if ($RIdata['VehicleData']['Imported_Outside_UKIE'] == false) {
                        $htmlPdf .= 'Yes';
                    }

                    else {
                        $htmlPdf .= 'No';
                    }

                    $htmlPdf .= 
                '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; "></td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Country Of Origin</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Country_Of_Origin'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; "></td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Country Previously Registered</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; border-right: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Country_Previous_Registration'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; "></td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>
        </tbody>
    </table>


    <br pagebreak="true" />
    <span>&nbsp;</span><br/>
    

    <table cellpadding="10" style="line-height:3.5px;  width: 50%;">
        <thead style="line-height:3.5px; color: #243845;  font-size: 60px;  text-align: left;">
            <tr class="tablePadding">
                <th style="line-height:3.5px;  background-color: #77BDC8;" colspan="2">Motor Tax</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Motor Tax Class</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Motor_Tax_Class'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Tax</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Tax_Cost'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Tax Rate Type</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Registration_Status'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Next Tax Expiry Date</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';


                    $warning = '';

                    if ($RIdata['VehicleData']['Next_Tax_Expiry_Date']['@attributes']['warning'] > 0) {
                        $warning = ' Warning: ' . $RIdata['VehicleData']['Next_Tax_Expiry_Date']['@attributes']['warning'];
                    }

                    $htmlPdf .= $RIdata['VehicleData']['Next_Tax_Expiry_Date']['@value'] . $warning . '
                    
                </td>
            </tr>

            <tr class="verticalAligntop">
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Tax Expiry History</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
                    
                        foreach($RIdata['VehicleData']['Tax_Expiry_History']['tax_expiry'] as $key=>$val) {
                            $htmlPdf .=  $val['@attributes']['date'] . '<br/>';
                        }
                $htmlPdf .= '</td>
            </tr>
        </tbody>
    </table>';
    
    if (sizeof($RIdata['VehicleData']['Tax_Expiry_History']['tax_expiry']) > 9) {
        $htmlPdf .= '<br pagebreak="true" /><span>&nbsp;</span><br/>';
    }
    
    else {
        $htmlPdf .= '<br/><br/>';
    }
    
    $htmlPdf .= '
    <table cellpadding="10" style="line-height:3.5px;  width:50%">
        <thead style="line-height:3.5px; color: #243845;  font-size: 60px;  text-align: left;">
            <tr class="tablePadding">
                <th style="line-height:3.5px;  background-color: #77BDC8;" colspan="2">NCT</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">NCT Certificate Number</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' 
                        . $RIdata['VehicleData']['NCT_Cert_Number_Masked'] . '
                 </td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">NCT Expiry Date</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['NCT_Expiry_date'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">NCT Pass Date</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
                    
                        if(is_array($RIdata['VehicleData']['NCT_Pass_Date'])) { 
                            $htmlPdf .= $RIdata['VehicleData']['NCT_Pass_Date']['@value'];
                        }
                        
                        else { 
                            $htmlPdf .= $RIdata['VehicleData']['NCT_Pass_Date'];
                        }
                
                        $htmlPdf .='</td>
                        
            </tr>

            <tr class="verticalAligntop">
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">NCT Expiry History</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
        
                        if (!empty($RIdata['VehicleData']['NCT_Expiry_History']['nct_expiry'])) {
                            foreach($RIdata['VehicleData']['NCT_Expiry_History']['nct_expiry'] as $key=>$val) {
                                $htmlPdf .= $val['@attributes']['date'] . '<br/>';
                            }
                        }
                        
                        else {
                            $htmlPdf .= $RIdata['VehicleData']['NCT_Expiry_History']['@value'];
                        }
            $htmlPdf .=    '</td>
            </tr>
        </tbody>
    </table>';
   
    if (!empty($RIdata['VehicleData']['NCT_Expiry_History']['nct_expiry'])) {
        if (sizeof($RIdata['VehicleData']['NCT_Expiry_History']['nct_expiry']) > 9) {
            $htmlPdf .= '<br pagebreak="true" /><span>&nbsp;</span><br/>';
        }

        else {
            $htmlPdf .= '<br/><br/>';
        }
    }
    
    else {
            $htmlPdf .= '<br/><br/>';
        }

    $htmlPdf .= '
    <table cellpadding="10" style="line-height:3.5px; width: 50%">
        <thead style="line-height:3.5px; color: #243845;  font-size: 60px;  text-align: left;">
            <tr class="tablePadding">
                <th style="line-height:3.5px;  background-color: #77BDC8;" colspan="2">Sale History</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Owner Category</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Owner_Category_Desc'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Number of Previous Owners</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Number_Previous_Owners'] . '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Sale History</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>

            '; 
                    if(!empty($RIdata['VehicleData']['Sale_History']['owner_history'])) {
                        if (sizeof($RIdata['VehicleData']['Sale_History']['owner_history']) > 2) {
                            foreach($RIdata['VehicleData']['Sale_History']['owner_history'] as $key=>$val) {
                                $htmlPdf .= '<table cellpadding="10" style="line-height:3.5px; width: 50%; background-color: #EBEDE8; ">
                                    <tbody>
                                        <tr>
                                            <td style="line-height:3.5px; font-size: 44px; font-weight: bold;">Date of Sale</td>
                                            <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $val['@attributes']['date_of_sale'] . '</td>
                                        </tr>

                                        <tr>
                                            <td style="line-height:3.5px; font-size: 44px; font-weight: bold;">Recorded Date of Sale</td>
                                            <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $val['@attributes']['recorded_date'] . '</td>
                                        </tr>

                                        <tr>
                                            <td style="line-height:3.5px; font-size: 44px; font-weight: bold;">Number of Previous Owners</td>
                                            <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $val['@attributes']['previous_owners'] . '</td>
                                        </tr>

                                        <tr>
                                            <td style="line-height:3.5px; font-size: 44px; font-weight: bold;">Owner Category</td>
                                            <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $val['@attributes']['owner_category_desc'] . '</td>
                                        </tr>
                                    </tbody>
                                </table><br/>';
                            }
                        }

                        else {
                            
                            $htmlPdf .= '<table cellpadding="10" style="line-height:3.5px; width: 50%; background-color: #EBEDE8; ">
                                <tbody>
                                    <tr>
                                        <td style="line-height:3.5px; font-size: 44px; font-weight: bold;">Date of Sale</td>
                                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['date_of_sale'] . '</td>
                                    </tr>

                                    <tr>
                                        <td style="line-height:3.5px; font-size: 44px; font-weight: bold;">Recorded Date of Sale</td>
                                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' .  $RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['recorded_date'] . '</td>
                                    </tr>

                                    <tr>
                                        <td style="line-height:3.5px; font-size: 44px; font-weight: bold;">Number of Previous Owners</td>
                                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['previous_owners'] . '</td>
                                    </tr>

                                    <tr>
                                        <td style="line-height:3.5px;font-size: 44px; font-weight: bold;">Owner Category</td>
                                        <td style="line-height:3.5px;font-size: 44px;">' . $RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['owner_category_desc'] . '</td>
                                    </tr>
                                </tbody>
                            </table>';
                    }
                }
                    
                $htmlPdf .=  '
            
        </tbody>
    </table>';

    if (sizeof($RIdata['VehicleData']['Sale_History']['owner_history']) > 3) {
        
        $htmlPdf .= '<br pagebreak="true" /><span>&nbsp;</span><br/>';
        
        if (sizeof($RIdata['VehicleData']['Sale_History']['owner_history']) > 7) {
            $htmlPdf .= '<br pagebreak="true" /><span>&nbsp;</span><br/>';
        }
    }
    
    $htmlPdf .= '
    <br pagebreak="true" /><span>&nbsp;</span><br/>
        
    <table cellpadding="10" style="line-height:3.5px;  width:100%">
        <thead style="line-height:3.5px; color: #243845;  font-size: 60px;  text-align: left;">
            <tr class="tablePadding">
                <th style="line-height:3.5px;  background-color: #77BDC8;" colspan="4">Risk Indicators</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">History Status</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['VehicleData']['History_Status']['Warning_Level'] . '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Taxi</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
                
                if ($RIdata['Risk_Indicators']['Taxi_Currently'] == false) {
                    $htmlPdf .= 'Yes';
                }
                
                else {
                    $htmlPdf .= 'No';
                }
                
                $htmlPdf .= '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Scrapped Vehicle</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
           
                if ($RIdata['Risk_Indicators']['Scrapped_Vehicle_Destroyed'] == false) {
                         $htmlPdf .= 'Yes';
                     }

                     else {
                         $htmlPdf .= 'No';
                     }

                $htmlPdf .= '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Taxi Previously</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
           
                    if($RIdata['Risk_Indicators']['Taxi_Previously'] == false) {
                        $htmlPdf .= 'Yes';
                    }

                    else {
                        $htmlPdf .= 'No';
                    }

                    $htmlPdf .= '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Written Off by Insurer</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
           
                    if($RIdata['Risk_Indicators']['Written_Off_By_Insurer'] == false) {
                        $htmlPdf .= 'Yes';
                    }

                    else {
                        $htmlPdf .= 'No';
                    }

                    $htmlPdf .= '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Hackney</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
           
                    if($RIdata['Risk_Indicators']['Hackney_Currently'] == false) {
                        $htmlPdf .= 'Yes';
                    }

                    else {
                        $htmlPdf .= 'No';
                    }

                    $htmlPdf .= '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Change in Engine Number</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
           
                    if($RIdata['Risk_Indicators']['Change_In_Engine_Number'] == false) {
                        $htmlPdf .= 'Yes';
                    }

                    else {
                        $htmlPdf .= 'No';
                    }

                    $htmlPdf .= '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Hackney Previously</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
           
                    if($RIdata['Risk_Indicators']['Hackney_Previously'] == false) {
                        $htmlPdf .= 'Yes';
                    }

                    else {
                        $htmlPdf .= 'No';
                    }

                    $htmlPdf .= '</td>
            </tr>

            <tr>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Change in Colour</td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">';
           
                    if($RIdata['Risk_Indicators']['Change_In_Colour'] == false) {
                        $htmlPdf .= 'Yes';
                    }

                    else {
                        $htmlPdf .= 'No';
                    }

                    $htmlPdf .= '</td>
                <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; "></td>
                <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; "></td>
            </tr>
        </tbody>
    </table><br/><br/>';

    
    if(!empty($RIdata['NCAP']['Post_2009'])) {
            
            $htmlPdf .= '<table cellpadding="10" style="line-height:3.5px;  width:50%">
                <thead style="line-height:3.5px; color: #243845;  font-size: 60px;  text-align: left;">
                    <tr class="tablePadding">
                        <th style="line-height:3.5px;  background-color: #77BDC8;" colspan="2">NCAP (Post_2009)</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Overall</td>
                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['NCAP']['Post_2009']['Overall'] . '</td>
                    </tr>

                    <tr>
                        <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Adult</td>
                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['NCAP']['Post_2009']['Adult'] . '</td>
                    </tr>

                    <tr>
                        <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Child</td>
                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['NCAP']['Post_2009']['Child'] . '</td>
                    </tr>

                    <tr>
                        <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Pedestrian</td>
                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['NCAP']['Post_2009']['Pedestrian'] . '</td>
                    </tr>

                    <tr>
                        <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Safety Assist</td>
                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['NCAP']['Post_2009']['Safety_Assist'] . '</td>
                    </tr>
                </tbody>
            </table>';

    }

    else { 
            $htmlPdf .=   '<table cellpadding="10" style="line-height:3.5px;  width:50%">
                <thead style="line-height:3.5px; color: #243845;  font-size: 60px;  text-align: left;">
                    <tr class="tablePadding">
                        <th style="line-height:3.5px;  background-color: #77BDC8;" colspan="2">NCAP (Pre_2009)</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Adult</td>
                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['NCAP']['Pre_2009']['Adult'] . '</td>
                    </tr>

                    <tr>
                        <td style="line-height:3.5px; font-size: 44px; color: #398D9F;  font-weight: bold; border-bottom: 1px solid #EBEDE8; ">Pedestrian</td>
                        <td style="line-height:3.5px; font-size: 44px; border-bottom: 1px solid #EBEDE8; ">' . $RIdata['NCAP']['Pre_2009']['Pedestrian'] . '</td>
                    </tr>
                </tbody>
            </table>';
    }

$html = <<<EOD
    $htmlPdf
EOD;



$pdf->writeHTML($html, true, false, true, false, '');

$pdf->lastPage();
//Close and output PDF document
$date = date('d-m-Y');
$pdf->Output('MTP_Registration_History_Check_' . $RIdata['VehicleData']['Registration'] .'__'. $date . '.pdf', 'D');
}


?>
