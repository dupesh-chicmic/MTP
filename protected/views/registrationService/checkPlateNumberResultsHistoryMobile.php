<?php echo CHtml::beginForm(Yii::app()->createUrl('registrationService/historyCheckMobile'), 'POST', array('autocomplete'=>'off')); ?>
  
<div class="checkPlateForm">
    <div >
        <?php echo CHtml::textField('VehicleRegNumber', '', array('id'=>'registation_no','maxlength'=>12)); ?>
    </div>
</div>

<div class="buttonCheckHistoryMobile">
    <?php echo CHtml::submitButton('Get Vehicle Details',
            array(
                    'class'=>'button1',
                    'id'=>'registation_no_button',
                    'style'=>'width:150px')); ?>
</div>


    <?php echo CHtml::endForm(); ?>
    <!-- reg number field END-->
    <?php if(!empty($RIdata)): ?>
    <?php
    /* 
     * Prezentacja wynikow zwracanych przez RI
     */

    $backgroundColorStyle = "";
    $kmStyle="";
    $borderStyle="";?>
    <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation.css" />-->
    <?php if(Yii::app()->mobileDetect->isMobile() || Yii::app()->mobileDetect->isTablet()): 
        $backgroundColorStyle = "style=\"background-color:#eeeeee !important;\""; 
        $kmStyle = "width:45% !important;";
        $borderStyle="style=\"border:2px solid #d2d4d3;\"";
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mobile.css" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
    <?php else:?>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/registrationService.css" />
    <?php endif; ?>

<div class="checkHistoryWrapper">
    <!-- ****************************** START NEW DISPLAY ****************************** -->

    <div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
        <div data-role="collapsible">
            <h3 style="text-align:center;">Vehicle Data for Registration <?php echo $RIdata['VehicleData']['Registration']; ?></h3>       
            <table class="vehicleDataTableMobile marginBottom">
                <tbody>
                    <tr>
                        <td class="tdLabelMobile">Vehicle Year</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Year_Manufacture'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Make</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Make'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Model</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Model'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Doors</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Doors'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Body</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Body_Type'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Colour</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Colour'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Number of Colour Changes</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Number_Colour_Changes'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Windows</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Windows'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Seats</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Number_Seats'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Engine</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Engine_Size'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">CC</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Engine_CC'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Fuel</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Fuel_Type'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Transmission</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Transmission'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Co2</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['CO2_Emissions'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Wheelbase</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Wheelbase'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Net Power</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Net_Power'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Gross Vehicle Weight</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Gross_Vehicle_Weight']['@value']; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Unladen Weight</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Unladen_Weight']['@value']; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Gross Combined Weight</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Gross_Combined_Weight']['@value'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Number of Axles</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Number_Axles']['@value'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Chassis Number</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Chassis_Number'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Engine Number</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Engine_Number'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">MTP Value</td>
                        <td class="tdInfoMobile"><?php //echo $RIdata['Valuation']['Value'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">MTP Kms</td>
                        <td class="tdInfoMobile">
                            <?php
                                if(is_array($RIdata['Mileages']['Mileage'])) {
                                    $totalMillage = 0;
                                    foreach($RIdata['Mileages']['Mileage'] as $key=>$val) {
                                        $totalMillage += $val['@attributes']['mileage'];
                                    }

                                    echo $totalMillage;
                                ?>
                                <?php }

                                else {
                                    echo$RIdata['Mileages']['Mileage'];
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>    
            
<div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
        <div data-role="collapsible">
            <h3 style="text-align:center;">Vehicle Registration</h3>  
            <table class="vehicleRegistrationTableMobile marginBottom">
                <tbody>
                    <tr>
                        <td class="tdLabelMobile">Registration Certificate Number</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Reg_Cert_Number'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Status</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Status'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Registration Status</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Registration_Status'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Category</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Category'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Imported from outside IRE/UK</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['VehicleData']['Imported_Outside_UKIE'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Country Of Origin</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Country_Of_Origin'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Country Previously Registered</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Country_Previous_Registration'] ?></td>
                    </tr>


                    <tr>
                        <td class="tdLabelMobile">Date of 1 st Registration</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Date_1st_Registration'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Date of 1 st Registration IE</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Date_1st_Registration_IE'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Previous Registration</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Previous_Registration']; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Date of Sale</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Date_Of_Sale']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
        <div data-role="collapsible">
            <h3 style="text-align:center;">Motor Tax</h3>  
            <table class="motorTaxTableMobile marginBottom">
                <tbody>
                    <tr>
                        <td class="tdLabelMobile">Motor Tax Class</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Motor_Tax_Class'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Tax</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Tax_Cost'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Tax Rate Type</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Registration_Status'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Next Tax Expiry Date</td>
                        <td class="tdInfoMobile">
                            <?php 
                                $warning = '';
                                if ($RIdata['VehicleData']['Next_Tax_Expiry_Date']['@attributes']['warning'] > 0) {
                                    $warning = ' Warning: ' . $RIdata['VehicleData']['Next_Tax_Expiry_Date']['@attributes']['warning'];
                                }

                                echo $RIdata['VehicleData']['Next_Tax_Expiry_Date']['@value'] . $warning;
                            ?>
                        </td>
                    </tr>

                    <tr class="verticalAligntop">
                        <td class="tdLabelMobile">Tax Expiry History</td>
                        <td class="tdInfoMobile">
                            <?php
                                foreach($RIdata['VehicleData']['Tax_Expiry_History']['tax_expiry'] as $key=>$val) {
                                    echo $val['@attributes']['date'] . '<br/>';
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    
    <div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
        <div data-role="collapsible">
            <h3 style="text-align:center;">NCT</h3>  
            <table class="nctTableMobile marginBottom">
                <tbody>
                    <tr>
                        <td class="tdLabelMobile">NCT Certificate Number</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['NCT_Cert_Number_Masked'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">NCT Expiry Date</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['NCT_Expiry_date'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">NCT Pass Date</td>
                        <td class="tdInfoMobile">
                            <?php
                                if(is_array($RIdata['VehicleData']['NCT_Pass_Date'])) { 
                                    $RIdata['VehicleData']['NCT_Pass_Date']['@value']
                                ?>
                                <?php }

                                else { 
                                    echo $RIdata['VehicleData']['NCT_Pass_Date']; ?>
                                <?php }
                                    ?>
                        </td>
                    </tr>

                    <tr class="verticalAligntop">
                        <td class="tdLabelMobile">NCT Expiry History</td>
                    </td>
                        <td class="tdInfoMobile">
                            <?php
                                if (!empty($RIdata['VehicleData']['NCT_Expiry_History']['nct_expiry'])) {
                                    foreach($RIdata['VehicleData']['NCT_Expiry_History']['nct_expiry'] as $key=>$val) {
                                        echo $val['@attributes']['date'] . '<br/>';
                                    }
                                }

                                else {
                                    echo $RIdata['VehicleData']['NCT_Expiry_History']['@value'];
                                }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
        <div data-role="collapsible">
            <h3 style="text-align:center;">Sale History</h3>  
            <table class="saleHistoryTableMobile">
                <tbody>
                    <tr>
                        <td class="tdLabelMobile">Owner Category</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Owner_Category_Desc'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Number of Previous Owners</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['Number_Previous_Owners'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Sale History</td>
                        <td class="tdInfoMobile"></td>
                    </tr>

                    <tr class="marginBottom">
                        <?php 
                            if(!empty($RIdata['VehicleData']['Sale_History']['owner_history'])) {
                                if (sizeof($RIdata['VehicleData']['Sale_History']['owner_history']) > 2) {
                                    foreach($RIdata['VehicleData']['Sale_History']['owner_history'] as $key=>$val) { ?>
                                        <table class="subTableMobile subTableMarginBottom">
                                            <tbody>
                                                <tr>
                                                    <td class="tdLabelSubTableMobile">Date of Sale</td>
                                                    <td class="tdInfoSubTableMobile"><?php echo $val['@attributes']['date_of_sale'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td class="tdLabelSubTableMobile">Recorded Date of Sale</td>
                                                    <td class="tdInfoSubTableMobile"><?php echo $val['@attributes']['recorded_date'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td class="tdLabelSubTableMobile">Number of Previous Owners</td>
                                                    <td class="tdInfoSubTableMobile"><?php echo $val['@attributes']['previous_owners'] ?></td>
                                                </tr>

                                                <tr>
                                                    <td class="tdLabelSubTableMobile">Owner Category</td>
                                                    <td class="tdInfoSubTableMobile"><?php echo $val['@attributes']['owner_category_desc'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                             <?php } 
                                }

                                else { ?>
                                    <table class="subTableMobile subTableMarginBottom">
                                        <tbody>
                                            <tr>
                                                <td class="tdLabelSubTableMobile">Date of Sale</td>
                                                <td class="tdInfoSubTableMobile"><?php echo $RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['date_of_sale'] ?></td>
                                            </tr>

                                            <tr>
                                                <td class="tdLabelSubTableMobile">Recorded Date of Sale</td>
                                                <td class="tdInfoSubTableMobile"><?php echo $RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['recorded_date'] ?></td>
                                            </tr>

                                            <tr>
                                                <td class="tdLabelSubTableMobile">Number of Previous Owners</td>
                                                <td class="tdInfoSubTableMobile"><?php echo $RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['previous_owners'] ?></td>
                                            </tr>

                                            <tr>
                                                <td class="tdLabelSubTableMobile">Owner Category</td>
                                                <td class="tdInfoSubTableMobile"><?php echo $RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['owner_category_desc'] ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                            <?php    }
                            }?>

                        <table class="subTableMarginBottom"></table>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    
    <div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
        <div data-role="collapsible">
            <h3 style="text-align:center;">Risk Indicators</h3>  
            <table class="riskIndicatorsTableMobile marginBottom">
                <tbody>
                    <tr>
                        <td class="tdLabelMobile">History Status</td>
                        <td class="tdInfoMobile"><?php echo $RIdata['VehicleData']['History_Status']['Warning_Level'] ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Scrapped Vehicle</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['Risk_Indicators']['Scrapped_Vehicle_Destroyed'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Written Off by Insurer</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['Risk_Indicators']['Written_Off_By_Insurer'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Change in Engine Number</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['Risk_Indicators']['Change_In_Engine_Number'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Change in Colour</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['Risk_Indicators']['Change_In_Colour'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>



                    <tr>
                        <td class="tdLabelMobile">Taxi</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['Risk_Indicators']['Taxi_Currently'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Taxi Previously</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['Risk_Indicators']['Taxi_Previously'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Hackney</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['Risk_Indicators']['Hackney_Currently'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabelMobile">Hackney Previously</td>
                        <td class="tdInfoMobile"><?php echo ($RIdata['Risk_Indicators']['Hackney_Previously'] == false) ? 'Yes' : 'No'; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php 
        if(!empty($RIdata['NCAP']['Post_2009'])) { ?>
            <div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
                <div data-role="collapsible">
                    <h3 style="text-align:center;">NCAP (Post_2009)</h3> 
                    <table class="ncapTableMobile marginBottom">
                        <tbody>
                            <tr>
                                <td class="tdLabelMobile">Overall</td>
                                <td class="tdInfoMobile"><?php echo $RIdata['NCAP']['Post_2009']['Overall'] ?></td>
                            </tr>

                            <tr>
                                <td class="tdLabelMobile">Adult</td>
                                <td class="tdInfoMobile"><?php echo $RIdata['NCAP']['Post_2009']['Adult']  ?></td>
                            </tr>

                            <tr>
                                <td class="tdLabelMobile">Child</td>
                                <td class="tdInfoMobile"><?php echo $RIdata['NCAP']['Post_2009']['Child']  ?></td>
                            </tr>

                            <tr>
                                <td class="tdLabelMobile">Pedestrian</td>
                                <td class="tdInfoMobile"><?php echo $RIdata['NCAP']['Post_2009']['Pedestrian']  ?></td>
                            </tr>

                            <tr>
                                <td class="tdLabelMobile">Safety Assist</td>
                                <td class="tdInfoMobile"><?php echo $RIdata['NCAP']['Post_2009']['Safety_Assist'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    <?php     }

    else { ?>
        <div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
            <div data-role="collapsible">
                <h3 style="text-align:center;">NCAP (Pre_2009)</h3> 
                    <table class="ncapTableMobile marginBottom">
                    <tbody>
                        <tr>
                            <td class="tdLabelMobile">Adult</td>
                            <td class="tdInfoMobile"><?php echo $RIdata['NCAP']['Pre_2009']['Adult']  ?></td>
                        </tr>

                        <tr>
                            <td class="tdLabelMobile">Pedestrian</td>
                            <td class="tdInfoMobile"><?php echo $RIdata['NCAP']['Pre_2009']['Pedestrian']  ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    
    <div class="generatePdfDivMobile">
        <a target="_blank" href="<?php echo $this->createUrl('/registrationService/generatePdfHistoryCheck', ['reg'=>$RIdata['VehicleData']['Registration']]); ?>">Generate PDF 
            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/pdf.png" style="width:28px; height:28px;" alt="[pdf]">
        </a>
    </div>
</div>

<!-- ****************************** END NEW DISPLAY ****************************** -->    
    
    
<!--<div id="content">
    <div id="width">-->
    
<?php
// obsluga bledow
//if(!empty($RIdata['errors'])){
//    echo $RIdata['errors'][0];
//    return;
//}else if(!empty($RIdata['matches']) && $RIdata['matches'] == '0'){
//    echo 'No results found';
//    return;
//}
?>

<!--<strong>Vehicle Data for <?php echo $RIdata['VehicleData']['Registration']; ?></strong>
<hr>-->

<!-- <strong>Make:</strong> <?php //echo $RIdata['VehicleData']['Make'] ?> -->
<!-- <br /><strong>Model:</strong> <?php //echo $RIdata['VehicleData']['Model'] ?> -->
<?php //if(!$checksOnly) { echo "<br /><strong>Year: </strong> ".$RIdata['VehicleData']['Year_Manufacture']; } ?>
<!-- <br /><strong>Colour:</strong> <?php //echo $RIdata['VehicleData']['Colour'] ?> -->
<?php //if(!$checksOnly) { echo "<br /><strong>Doors:</strong> ".$RIdata['VehicleData']['Doors']; } ?>
<?php //echo "<br /><strong>Body:</strong> ".$RIdata['VehicleData']['Body_Type']; ?>
<!-- <br /><strong>Engine:</strong> <?php echo $RIdata['VehicleData']['Engine_Size'] ?> -->
<!-- <br /><strong>Fuel:</strong> <?php echo $RIdata['VehicleData']['Fuel_Type'] ?> -->

<?php 
//echo "<br /><strong>Transmission:</strong> ".$RIdata['VehicleData']['Transmission'];
//echo "<br /><strong>Tax amount €:</strong> ".$RIdata['VehicleData']['Tax_Cost']; 
//
//if($RIdata['VehicleData']['Imported_Outside_UKIE']==true)
//{$imp = 'YES';}
//else {$imp = 'NO';}
//
//echo "<br /><strong>Imported from UK:</strong> ".$imp; 
//echo "<br /><strong>Previous registration:</strong> ".$RIdata['VehicleData']['Previous_Registration']; 
//if(!$checksOnly) { 
//    echo "<br /><strong>CO2 Emissions:</strong> ".$RIdata['VehicleData']['CO2_Emissions']; 
////    echo "<br /><strong>Tax band:</strong> ".$RIdata['VehicleData']['Tax_Rate_Type']; 
//    echo "<br /><strong>Tax amount €:</strong> ".$RIdata['VehicleData']['Tax_Cost']; 
//    //echo "<br /><strong>Transmission:</strong> ".$RIdata['VehicleData']['Transmission']; 
////    echo "<br /><strong>Value:</strong> ";
////    $value = "";
////    if(is_array($RIdata['Valuation']['Value'])){
////        echo $value = $RIdata['Valuation']['Value']['@value'];
////    }else{
////        echo $value = $RIdata['Valuation']['Value']; 
////    }
////    echo "<br /><strong>Kms:</strong> ".$RIdata['Valuation']['Range']; 
//    
//    // odometer calculator
////    echo '<div class="carForm" '.$backgroundColorStyle.'>
////        <div class="divider2"></div>
////         <label>Enter Km\'s</label>
////        <div class="form1" '.$borderStyle.'>';
////
////    echo CHtml::beginForm('','',array('onsubmit'=>''));
////    echo CHtml::textField('km', '',array('class'=>'km', 'style'=>$kmStyle));//km usera wpisane
////    echo CHtml::hiddenField('year', $RIdata['VehicleData']['Year_Manufacture']);
////    echo CHtml::hiddenField('guide', "E".$value);//cena w euro
////    echo CHtml::hiddenField('guideKm', $RIdata['Valuation']['Range']);//km w przewodniku
////    echo CHtml::hiddenField('fuel', ($RIdata['VehicleData']['Fuel_Type']  == 'PETROL') ? "P" : "D");
////    echo CHtml::hiddenField('carOrCom', '$usedCarComModel');
////    echo CHtml::hiddenField('codenumber', '');
////    echo CHtml::hiddenField('import', $importId);
////    
////    echo CHtml::button('ADJUST', array('class'=>'button1',
////'onclick'=>CHtml::ajax(array('type'=>'POST', 'url'=>array("registrationService/ajaxCalculate"),
////'update'=>'#odometer'))
////        ));
////    echo Chtml::endForm();
////    
////    echo '</div>';
////     
////         echo '<div class="adjustedValue">
////                 <!--<img src="images/divider.png" />-->
////         <label class="fontColor"></label>
////         <span id="odometer" class="value">Adjusted value &#8364;';    
////         echo '</span></div>';
//    
//} ?>

<!--<hr>-->
 <?php //RIVehicleData::displayRIData(1, $RIdata); ?>
<?php // generowanie PDF z $RIdata ?>
<!--<a href="<?php echo Yii::app()->createUrl('registrationService/generatePdf',array('vnumber'=>$RIdata['VehicleData']['Registration'])) ?>"><img src="./images/pdf.png" style="width:28px; height:28px;border:none;" alt="[pdf]" /></a>-->
<!--<br />-->

<!--
<span id="purchaseStyle">
    Purchase
    <ul>
        <li><a href="#">History Check and market value report <i><b>(10 tokens)</b></i></a></li>
        <li><a href="#">Finance Check report <i><b>(12 tokens)</b></i></a></li>
    </ul>
</span>
-->
<!--</div>
    </div>-->
<?php endif; ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery1.7.1.js" type="text/javascript"></script>
