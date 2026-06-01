<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/layout.css" />

<div class="checkHistoryWrapper" style="float: right ">
    <?php echo CHtml::beginForm(Yii::app()->createUrl('registrationService/HistoryCheck'), 'POST', array('autocomplete'=>'off')); ?>
    <div class="searchFieldHistory">
        <div class="checkPlateForm">
            <div class="checkPlateNumber">
                <?php echo CHtml::textField('VehicleRegNumber', '', array('id'=>'registation_no','maxlength'=>12)); ?>
            </div>
        </div>

        <div class="buttonCheckHistory">
            <?php echo CHtml::submitButton('Get Vehicle Details',
                    array(
                            'class'=>'button1',
                            'id'=>'registation_no_button')); ?>
        </div>
    </div>


    <?php echo CHtml::endForm(); ?>
    
</div>
    <!-- reg number field END-->
    <?php if(!empty($RIdata)): ?>
    <?php
    //var_dump($RIdata);
    //exit;
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
    <table class="vehicleDataTable marginBottom">
        <thead class="tbHead">
            <tr class="tablePadding">
                <th colspan="4">
                    Vehicle Data for Registration <?php echo displayResults($RIdata['VehicleData']['Registration']); ?>
                </th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td class="tdLabel">Vehicle Year</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Year_Manufacture']); ?></td>
                <td class="tdLabel">Wheelbase</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Wheelbase']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Make</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Make']); ?></td>
                <td class="tdLabel">Net Power</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Net_Power']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Model</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Model']); ?></td>
                <td class="tdLabel">Gross Vehicle Weight</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Gross_Vehicle_Weight']['@value']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Doors</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Doors']); ?></td>
                <td class="tdLabel">Unladen Weight</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Unladen_Weight']['@value']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Body</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Body_Type']); ?></td>
                <td class="tdLabel">Gross Combined Weight</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Gross_Combined_Weight']['@value']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Colour</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Colour']); ?></td>
                <td class="tdLabel">Number of Axles</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Number_Axles']['@value']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Number of Colour Changes</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Number_Colour_Changes']); ?></td>
                <td class="tdLabel"></td>
                <td class="tdInfo"></td>
            </tr>

            <tr>
                <td class="tdLabel">Windows</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Windows']); ?></td>
                <td class="tdLabel">Chassis Number</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Chassis_Number']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Seats</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Number_Seats']); ?></td>
                <td class="tdLabel">Engine Number</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Engine_Number']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Engine</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Engine_Size']); ?></td>
                <td class="tdLabel"></td>
                <td class="tdInfo"></td>
            </tr>

            <?php //TODO: dynamic MTP value?>
            <tr>
                <td class="tdLabel">CC</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Engine_CC']); ?></td>
                <?php 
                if(RegistrationService::isValidYear(null,$RIdata['VehicleData']['Registration'])){
                ?>
                    <td class="tdLabel">MTP Value</td>
                    <td class="tdInfo"><?php echo displayResults($RIdata['Valuation']['Value'], '&euro;'); ?></td>
                <?php }else {?>
                    <td class="tdLabel">MTP Value</td>
                    <td class="tdInfo"><?php echo displayResults(null);?></td>    
                <?php }?>    
            </tr>

            <tr>
                <td class="tdLabel">Fuel</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Fuel_Type']); ?></td>
                <?php 
                if(RegistrationService::isValidYear(null,$RIdata['VehicleData']['Registration'])){
                ?>
                    <td class="tdLabel">MTP Kms</td>
                    <td class="tdInfo">
                        <?php
                        //var_dump($RIdata['Mileages']['Mileage']);
                            if(is_array($RIdata['Mileages']['Mileage'])) { 
                                $totalMillage = 0;
                                foreach($RIdata['Mileages']['Mileage'] as $key=>$val) {
                                    //echo 
                                    //$totalMillage += $val['@attributes']['mileage'];
                                }
                                var_dump($RIdata['Mileages']['Mileage']);
                            }else {
                                echo $RIdata['Mileages']['Mileage'];
                            }
                        ?>
                    </td>
                <?php }else {?>
                    <td class="tdLabel">MTP Kms</td>
                    <td class="tdInfo"><?php echo displayResults(null);?></td>    
                <?php }?>
            </tr>

            <tr>
                <td class="tdLabel">Transmission</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Transmission']); ?></td>
                <td class="tdLabel"></td>
                <td class="tdInfo"></td>
            </tr>

            <tr>
                <td class="tdLabel">Co2 Emissions</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['CO2_Emissions']); ?></td>
                <td class="tdLabel"></td>
                <td class="tdInfo"></td>
            </tr>
        </tbody>
    </table>

    <table class="vehicleRegistrationTable marginBottom">
        <thead class="tbHead">
            <tr class="tablePadding">
                <th colspan="4">Vehicle Registration</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="tdLabel">Registration Certificate Number</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Reg_Cert_Number']); ?></td>
                <td class="tdLabel">Date of 1 st Registration</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Date_1st_Registration']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Status</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Status']); ?></td>
                <td class="tdLabel">Date of 1 st Registration IE</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Date_1st_Registration_IE']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Registration Status</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Registration_Status']); ?></td>
                <td class="tdLabel">Previous Registration</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Previous_Registration']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Category</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Category']); ?></td>
                <td class="tdLabel">Date of Sale</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Date_Of_Sale']); ?></td>
            </tr>

            <!--<tr>
                <td class="tdLabel">Imported from outside IRE/UK</td>
                <td class="tdInfo borderRight"><?php echo ($RIdata['VehicleData']['Imported_Outside_UKIE'] == false) ? 'Yes' : 'No'; ?></td>
                <td class="tdLabel"></td>
                <td class="tdInfo"></td>
            </tr>-->

            <tr>
                <td class="tdLabel">Country of Assembly</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Country_Of_Origin']); ?></td>
                <td class="tdLabel"></td>
                <td class="tdInfo"></td>
            </tr>

            <tr>
                <td class="tdLabel">Country Previously Registered</td>
                <td class="tdInfo borderRight"><?php echo displayResults($RIdata['VehicleData']['Country_Previous_Registration']); ?></td>
                <td class="tdLabel"></td>
                <td class="tdInfo"></td>
            </tr>
        </tbody>
    </table>


    <table class="motorTaxTable marginBottom">
        <thead class="tbHead">
            <tr class="tablePadding">
                <th colspan="2">Motor Tax</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="tdLabel">Motor Tax Class</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Motor_Tax_Class']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Tax</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Tax_Cost'], '&euro;'); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Tax Rate Type</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Registration_Status']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Next Tax Expiry Date</td>
                <td class="tdInfo">
                    <?php 
                        $warning = '';
                        if ($RIdata['VehicleData']['Next_Tax_Expiry_Date']['@attributes']['warning'] > 0) {
                            $warning = ' Warning: ' . $RIdata['VehicleData']['Next_Tax_Expiry_Date']['@attributes']['warning'];
                        }

                        echo displayResults($RIdata['VehicleData']['Next_Tax_Expiry_Date']['@value']) . $warning;
                    ?>
                </td>
            </tr>

            <tr class="verticalAligntop">
                <td class="tdLabel">Tax Expiry History</td>
                <td class="tdInfo">
                    <?php
                    if(!empty($RIdata['VehicleData']['Tax_Expiry_History']['tax_expiry'])){
                        foreach($RIdata['VehicleData']['Tax_Expiry_History']['tax_expiry'] as $key=>$val) {
                            echo $val['@attributes']['date'] . '<br/>';
                        }
                    }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="nctTable marginBottom">
        <thead class="tbHead">
            <tr class="tablePadding">
                <th colspan="2">NCT</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="tdLabel">NCT Certificate Number</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['NCT_Cert_Number_Masked']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">NCT Expiry Date</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['NCT_Expiry_date']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">NCT Pass Date</td>
                <td class="tdInfo">
                    <?php
                        if(is_array($RIdata['VehicleData']['NCT_Pass_Date'])) { 
                            echo displayResults($RIdata['VehicleData']['NCT_Pass_Date']['@value']);
                        ?>
                        <?php }
                        
                        else { 
                            echo displayResults($RIdata['VehicleData']['NCT_Pass_Date']); ?>
                        <?php }
                            ?>
                
                </td>
                        
            </tr>

            <tr class="verticalAligntop">
                <td class="tdLabel">NCT Expiry History</td>
            </td>
                <td class="tdInfo">
                    <?php
                        if (!empty($RIdata['VehicleData']['NCT_Expiry_History']['nct_expiry'])) {
                            foreach($RIdata['VehicleData']['NCT_Expiry_History']['nct_expiry'] as $key=>$val) {
                                echo displayResults($val['@attributes']['date']) . '<br/>';
                            }
                        }
                        
                        else {
                            echo displayResults($RIdata['VehicleData']['NCT_Expiry_History']['@value']);
                        }
                    ?>
                </td>
            </tr>
        </tbody>
    </table>


    <table class="saleHistoryTable">
        <thead class="tbHead">
            <tr class="tablePadding">
                <th colspan="2">Sale History</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="tdLabel">Owner Category</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Owner_Category_Desc']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Number of Previous Owners</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['Number_Previous_Owners']); ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Sale History</td>
                <td class="tdInfo"></td>
            </tr>

            <tr class="marginBottom">
                <?php 
                    if(!empty($RIdata['VehicleData']['Sale_History']['owner_history'])) {
                        if (sizeof($RIdata['VehicleData']['Sale_History']['owner_history']) > 2) {
                            foreach($RIdata['VehicleData']['Sale_History']['owner_history'] as $key=>$val) { ?>
                                <table class="subTable subTableMarginBottom">
                                    <tbody>
                                        <tr>
                                            <td class="tdLabelSubTable">Date of Sale</td>
                                            <td class="tdInfoSubTable"><?php echo displayResults($val['@attributes']['date_of_sale']); ?></td>
                                        </tr>

                                        <tr>
                                            <td class="tdLabelSubTable">Recorded Date of Sale</td>
                                            <td class="tdInfoSubTable"><?php echo displayResults($val['@attributes']['recorded_date']); ?></td>
                                        </tr>

                                        <tr>
                                            <td class="tdLabelSubTable">Number of Previous Owners</td>
                                            <td class="tdInfoSubTable"><?php echo displayResults($val['@attributes']['previous_owners']); ?></td>
                                        </tr>

                                        <tr>
                                            <td class="tdLabelSubTable">Owner Category</td>
                                            <td class="tdInfoSubTable"><?php echo displayResults($val['@attributes']['owner_category_desc']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                     <?php } 
                        }

                        else { ?>
                            <table class="subTable subTableMarginBottom">
                                <tbody>
                                    <tr>
                                        <td class="tdLabelSubTable">Date of Sale</td>
                                        <td class="tdInfoSubTable"><?php echo displayResults($RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['date_of_sale']); ?></td>
                                    </tr>

                                    <tr>
                                        <td class="tdLabelSubTable">Recorded Date of Sale</td>
                                        <td class="tdInfoSubTable"><?php echo displayResults($RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['recorded_date']); ?></td>
                                    </tr>

                                    <tr>
                                        <td class="tdLabelSubTable">Number of Previous Owners</td>
                                        <td class="tdInfoSubTable"><?php echo displayResults($RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['previous_owners']); ?></td>
                                    </tr>

                                    <tr>
                                        <td class="tdLabelSubTable">Owner Category</td>
                                        <td class="tdInfoSubTable"><?php echo displayResults($RIdata['VehicleData']['Sale_History']['owner_history']['@attributes']['owner_category_desc']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                    <?php    }
                    }?>
                    
                <table class="subTableMarginBottom"></table>
            </tr>
        </tbody>
    </table>


    <table class="riskIndicatorsTable marginBottom">
        <thead class="tbHead">
            <tr class="tablePadding">
                <th colspan="4">Risk Indicators</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td class="tdLabel">History Status</td>
                <td class="tdInfo"><?php echo displayResults($RIdata['VehicleData']['History_Status']['Warning_Level']); ?></td>
                <td class="tdLabel">Taxi</td>
                <td class="tdInfo"><?php echo ($RIdata['Risk_Indicators']['Taxi_Currently'] == false) ? 'Yes' : 'No'; ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Scrapped Vehicle</td>
                <td class="tdInfo"><?php echo ($RIdata['Risk_Indicators']['Scrapped_Vehicle_Destroyed'] == false) ? 'Yes' : 'No'; ?></td>
                <td class="tdLabel">Taxi Previously</td>
                <td class="tdInfo"><?php echo ($RIdata['Risk_Indicators']['Taxi_Previously'] == false) ? 'Yes' : 'No'; ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Written Off by Insurer</td>
                <td class="tdInfo"><?php echo ($RIdata['Risk_Indicators']['Written_Off_By_Insurer'] == false) ? 'Yes' : 'No'; ?></td>
                <td class="tdLabel">Hackney</td>
                <td class="tdInfo"><?php echo ($RIdata['Risk_Indicators']['Hackney_Currently'] == false) ? 'Yes' : 'No'; ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Change in Engine Number</td>
                <td class="tdInfo"><?php echo ($RIdata['Risk_Indicators']['Change_In_Engine_Number'] == false) ? 'Yes' : 'No'; ?></td>
                <td class="tdLabel">Hackney Previously</td>
                <td class="tdInfo"><?php echo ($RIdata['Risk_Indicators']['Hackney_Previously'] == false) ? 'Yes' : 'No'; ?></td>
            </tr>

            <tr>
                <td class="tdLabel">Change in Colour</td>
                <td class="tdInfo"><?php echo ($RIdata['Risk_Indicators']['Change_In_Colour'] == false) ? 'Yes' : 'No'; ?></td>
                <td class="tdLabel"></td>
                <td class="tdInfo"></td>
            </tr>
        </tbody>
    </table>

    <?php 
    
        if(!empty($RIdata['NCAP']['Post_2009'])) { ?>
            
            <table class="ncapTable marginBottom">
                <thead class="tbHead">
                    <tr class="tablePadding">
                        <th colspan="2">NCAP (Post_2009)
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="tdLabel">Overall</td>
                        <td class="tdInfo"><?php echo displayResults($RIdata['NCAP']['Post_2009']['Overall']); ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabel">Adult</td>
                        <td class="tdInfo"><?php echo displayResults($RIdata['NCAP']['Post_2009']['Adult']); ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabel">Child</td>
                        <td class="tdInfo"><?php echo displayResults($RIdata['NCAP']['Post_2009']['Child']); ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabel">Pedestrian</td>
                        <td class="tdInfo"><?php echo displayResults($RIdata['NCAP']['Post_2009']['Pedestrian']); ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabel">Safety Assist</td>
                        <td class="tdInfo"><?php echo displayResults($RIdata['NCAP']['Post_2009']['Safety_Assist']); ?></td>
                    </tr>
                </tbody>
            </table>

    <?php     }

    else { 
        var_dump($RIdata['NCAP']['Pre_2009']);
        ?>
                <table class="ncapTable marginBottom">
                <thead class="tbHead">
                    <tr class="tablePadding">
                        <th colspan="2">NCAP (Pre_2009)
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="tdLabel">Overall</td>
                        <td class="tdInfo"><?php echo displayResults(null); ?></td>
                    </tr>
                    
                    <tr>
                        <td class="tdLabel">Adult</td>
                        <td class="tdInfo"><?php echo displayResults($RIdata['NCAP']['Pre_2009']['Adult']);  ?></td>
                    </tr>
                    
                     <tr>
                        <td class="tdLabel">Child</td>
                        <td class="tdInfo"><?php echo displayResults($RIdata['NCAP']['Pre_2009']['Child']);  ?></td>
                    </tr>

                    <tr>
                        <td class="tdLabel">Pedestrian</td>
                        <td class="tdInfo"><?php echo displayResults($RIdata['NCAP']['Pre_2009']['Pedestrian']); ?></td>
                    </tr>
                    <tr>
                        <td class="tdLabel">Safety_Assist</td>
                        <td class="tdInfo"><?php echo displayResults(null); ?></td>
                    </tr>
                </tbody>
            </table>
    <?php }
    ?>
    
    <div class="generatePdfDiv">
        <a target="_blank" href="<?php echo $this->createUrl('/registrationService/generatePdfHistoryCheck', array('reg'=>$RIdata['VehicleData']['Registration'])); ?>">Generate PDF 
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
//    echo $RIdata['errors'][0]);
//    return;
//}else if(!empty($RIdata['matches']) && $RIdata['matches'] == '0'){
//    echo 'No results found';
//    return;
//}
?>

<!--<strong>Vehicle Data for <?php echo displayResults($RIdata['VehicleData']['Registration']); ?></strong>
<hr>-->

<!-- <strong>Make:</strong> <?php //echo displayResults($RIdata['VehicleData']['Make'] ?> -->
<!-- <br /><strong>Model:</strong> <?php //echo displayResults($RIdata['VehicleData']['Model'] ?> -->
<?php //if(!$checksOnly) { echo "<br /><strong>Year: </strong> ".$RIdata['VehicleData']['Year_Manufacture']; } ?>
<!-- <br /><strong>Colour:</strong> <?php //echo displayResults($RIdata['VehicleData']['Colour'] ?> -->
<?php //if(!$checksOnly) { echo "<br /><strong>Doors:</strong> ".$RIdata['VehicleData']['Doors']; } ?>
<?php //echo "<br /><strong>Body:</strong> ".$RIdata['VehicleData']['Body_Type']; ?>
<!-- <br /><strong>Engine:</strong> <?php echo displayResults($RIdata['VehicleData']['Engine_Size']); ?> -->
<!-- <br /><strong>Fuel:</strong> <?php echo displayResults($RIdata['VehicleData']['Fuel_Type']); ?> -->

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
<?php 

function displayResults($value, $prefix=''){
    if(empty($value)){
        return 'Not Available';
    }else {
        if(is_array($value)){
           // return implode($value);
           if(!empty($value['@value'])){
               if(empty($prefix)){
                    return $value['@value'];
               }else {
                   return $prefix.' '.$value['@value'];
               }
           }else {
               return 'Not Available';
           }
           //var_dump($value);
        }else {
            if(empty($prefix)){
                    return $value;
               }else {
                   return $prefix.' '.$value;
               }
           // return $value;
        }
    }
}
var_dump($RIdata);
?>
