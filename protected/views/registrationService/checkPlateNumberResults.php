<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="language" content="en" />
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE"/>
<?php
/* 
 * Prezentacja wynikow zwracanych przez RI
 */

$backgroundColorStyle = "";
$kmStyle="";
$borderStyle="";?>
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

<title>MTP</title>

</head>
<body>
<div id="content">
    <div id="width">
    
<?php
// obsluga bledow
if(!empty($RIdata['errors'])){
    echo $RIdata['errors'][0];
    return;
}else if(!empty($RIdata['matches']) && $RIdata['matches'] == '0'){
    echo 'No results found';
    return;
}
?>

<strong>Vehicle Data for <?php echo $RIdata['VehicleData']['Registration']; ?></strong>
<hr>

<strong>Make:</strong> <?php echo $RIdata['VehicleData']['Make'] ?>
<br /><strong>Model:</strong> <?php echo $RIdata['VehicleData']['Model'] ?>
<?php if(!$checksOnly) { echo "<br /><strong>Year: </strong> ".$RIdata['VehicleData']['Year_Manufacture']; } ?>
<br /><strong>Colour:</strong> <?php echo $RIdata['VehicleData']['Colour'] ?>
<?php if(!$checksOnly) { echo "<br /><strong>Doors:</strong> ".$RIdata['VehicleData']['Doors']; } ?>
<?php if(!$checksOnly) { echo "<br /><strong>Body:</strong> ".$RIdata['VehicleData']['Body_Type']; } ?>
<br /><strong>Engine:</strong> <?php echo $RIdata['VehicleData']['Engine_Size'] ?>
<br /><strong>Fuel:</strong> <?php echo $RIdata['VehicleData']['Fuel_Type'] ?>
<?php if(!$checksOnly) { 
    echo "<br /><strong>CO2 Emissions:</strong> ".$RIdata['VehicleData']['CO2_Emissions']; 
//    echo "<br /><strong>Tax band:</strong> ".$RIdata['VehicleData']['Tax_Rate_Type']; 
    echo "<br /><strong>Tax amount €:</strong> ".$RIdata['VehicleData']['Tax_Cost']; 
    echo "<br /><strong>Transmission:</strong> ".$RIdata['VehicleData']['Transmission']; 
//    echo "<br /><strong>Value:</strong> ";
//    $value = "";
//    if(is_array($RIdata['Valuation']['Value'])){
//        echo $value = $RIdata['Valuation']['Value']['@value'];
//    }else{
//        echo $value = $RIdata['Valuation']['Value']; 
//    }
//    echo "<br /><strong>Kms:</strong> ".$RIdata['Valuation']['Range']; 
    
    // odometer calculator
//    echo '<div class="carForm" '.$backgroundColorStyle.'>
//        <div class="divider2"></div>
//         <label>Enter Km\'s</label>
//        <div class="form1" '.$borderStyle.'>';
//
//    echo CHtml::beginForm('','',array('onsubmit'=>''));
//    echo CHtml::textField('km', '',array('class'=>'km', 'style'=>$kmStyle));//km usera wpisane
//    echo CHtml::hiddenField('year', $RIdata['VehicleData']['Year_Manufacture']);
//    echo CHtml::hiddenField('guide', "E".$value);//cena w euro
//    echo CHtml::hiddenField('guideKm', $RIdata['Valuation']['Range']);//km w przewodniku
//    echo CHtml::hiddenField('fuel', ($RIdata['VehicleData']['Fuel_Type']  == 'PETROL') ? "P" : "D");
//    echo CHtml::hiddenField('carOrCom', '$usedCarComModel');
//    echo CHtml::hiddenField('codenumber', '');
//    echo CHtml::hiddenField('import', $importId);
//    
//    echo CHtml::button('ADJUST', array('class'=>'button1',
//'onclick'=>CHtml::ajax(array('type'=>'POST', 'url'=>array("registrationService/ajaxCalculate"),
//'update'=>'#odometer'))
//        ));
//    echo Chtml::endForm();
//    
//    echo '</div>';
//     
//         echo '<div class="adjustedValue">
//                 <!--<img src="images/divider.png" />-->
//         <label class="fontColor"></label>
//         <span id="odometer" class="value">Adjusted value &#8364;';    
//         echo '</span></div>';
    
} ?>

<hr>

<?php // generowanie PDF z $RIdata ?>
<!--<a href="<?php echo Yii::app()->createUrl('registrationService/generatePdf',array('vnumber'=>$RIdata['VehicleData']['Registration'])) ?>"><img src="./images/pdf.png" style="width:28px; height:28px;border:none;" alt="[pdf]" /></a>-->
<br />

<!--
<span id="purchaseStyle">
    Purchase
    <ul>
        <li><a href="#">History Check and market value report <i><b>(10 tokens)</b></i></a></li>
        <li><a href="#">Finance Check report <i><b>(12 tokens)</b></i></a></li>
    </ul>
</span>
-->
</div>
    </div>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery1.7.1.js" type="text/javascript"></script>
<script>
    window.onload = function () {
        $('#km').focus();
    }
</script>
</body>
</html>