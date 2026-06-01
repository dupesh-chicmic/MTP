<?php
if (Yii::app()->user->hasFlash('errorMsg')) {
    echo '<div class="flash-error" role="alert">';
    echo Yii::app()->user->getFlash('errorMsg');
    echo '</div>';
}
?>
<?php
echo '<a href="'.Yii::app()->createUrl('mobile/mainMenu').'" data-role="button" data-theme="b" data-corners="false">Back to login menu</a>';

if($type!='UsedComCarsModel'){
    ?>
<?php

    echo $this->renderPartial('//mobile/_usedCarsMobileMenu', 
            array(//'model'=>$model,
                  'usedCarsMark'=>Mobile::getUsedCarsMark(),                  
                )); 

}else {

    echo $this->renderPartial('//mobile/_usedCommsMobileMenu', 
            array(//'model'=>$model,
                  'usedCommercialMark'=>Mobile::getUsedCommercialMark(),                  
                )); 
    }
   
if (!empty($vehicle)): ?>

    <?php
//echo var_dump($vehicle);'MTP (codenumber)='.$model['codenumber'] .' RI (code)='.$vehicle['code']; 
//var_dump($model);
//echo '<br/>';
//var_dump($vehicle);
    ?>

    <div class="WrapperPadding">
    <h1 class="upper_case">Vehicle Data for <?php echo $vehicle['registerVehicleNumber']; ?>
        <br /><span style="font-size:9px;">powered by <a target="_blank" href="http://www.mywheels.ie">MyWheels.ie</a></span></h1>

    <table class="column1 gray_back">
        <tr>
            <td><span class="text">Vehicle Year</span></td><td><?php echo $vehicle['year']; ?></td>
        </tr>
        <tr>
            <td><span class="text">Make</span></td><td><?php echo $vehicle['make']; ?></td>
        </tr>
        <tr>
            <td><span class="text">Model</span></td><td><?php echo $vehicle['model']; ?></td>
        </tr>
        <tr>
            <td><span class="text">Colour</span></td><td><?php echo $vehicle['colour']; ?></td>
        </tr>

        <tr>
            <td><span class="text">Engine</span></td><td><?php echo $vehicle['engine']; ?></td>
        </tr>
        <tr>
            <td><span class="text">Fuel</span></td><td><?php echo $vehicle['fuel']; ?></td>
        </tr>
        <tr>
            <td><span class="text">Transmission</span></td><td><?php echo $vehicle['transmission']; ?></td>
        </tr>
        <tr>
            <td><span class="text">Co2</span></td><td><?php echo $vehicle['CO2']; ?></td>
        </tr>
        <tr>
            <td><span class="text">Motor Tax</span></td><td>&euro;<?php echo $vehicle['roadTax']; ?></td>
        </tr>
    </table>

    <?php if (!empty($model)): ?>

        
        <a id="foundValues"/>
        <div class="associatedContainer"><br />
        <?php $changedModelVehicleData = RegistrationService::getChangeRiDataResults($model, $vehicle); 
        if (isset($_POST['search'])) {
            ?>
            <div><h2 class="upper_case"><u>MTP Associated Values for:</u></h2>
                
                
                <span class="text bold v-space"><?php echo $changedModelVehicleData['make'] . ' ' . $changedModelVehicleData['model']; ?></span>
            
            </div>

            
            <span style="font-size:9px;">
        <?php echo $vehicle['importTitle']; ?>
            </span>
            <br /><br />
            
            <?php //Avg. Km Reading was here 09-2016
            ?>
            
            
        <?php }//if post search ?>

        <div id="associatedCarTable" style="width:100%;">
            
        <?php
        
        $this->renderPartial('_associatedValuesByRegLookUpMobile', array(
            'model' => $model,
            'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
            'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
            'calculatedMain_coreWithAssociatedCars' => $calculatedMain_coreWithAssociatedCars,
            'calculatedRest_coreWithAssociatedCars' => $calculatedRest_coreWithAssociatedCars,
            'vehicleYear' => $vehicle['year'],                             
            
            'checkedAllCheckboxes' => $checkedAllCheckboxes,
            'grpCustomValeResult' => $grpCustomValeResult,
            'calculatedCustomValue' => $calculatedCustomValue,
        ));
        
        
        ?>
        </div>
        
        <?php // generowanie PDF z $RIdata 
        // uncomment lines 34-36 and others in mpt.js in mtp.js to dynamicaly replace the link.?>
        
        <!--<div style="width:100%; float:left; padding-bottom:5px;">
            <a style="float:left; text-decoration: none; color:#2D8296; font-weight: bolder;" id="pdfByRegLookup" href="<?php echo Yii::app()->createUrl('registrationService/pdfByRegLookUp', array('vnumber' => $vehicle['registerVehicleNumber'], 'type' => $type, 'defaultKmsForYear' => ($vehicle['kmsForYear']*1000 / 1000), 'userGuideKm' => $vehicle['kmsForYear']*1000 / 1000, 'grpCustomValeResult' => '', 'coreCodeNumber' => '', 'checkedCheckboxes' => '', 'end' => 1)) ?>">Download PDF <img src="./images/pdf.png" style="    vertical-align: middle; width:28px; height:28px; border: none;" alt="[pdf]" /></a>
            
        </div>-->
<?php //associated car data were here - now back after feedback 09-2016
?>
        <?php
        if (isset($_POST['search'])) {
            ?>
                    <center>
                        <br/>
        Avg. Km Reading <span id="defaultUserGuideKm" class="text"><b><?php echo $vehicle['kmsForYear']*1000 / 1000; ?></b></span> km (x1000).
            <br />
            <script type="text/javascript">
                $("#adjustKmByRegLookup").keypress(function (e) {
                    var key = e.which;
                    if (key == 13) {
                        $("#adjustRegLookupBtn").click();
                        return false;
                    }
                });
            </script>
        <?php
        //echo CHtml::beginForm('', '', array('onsubmit' => 'return valid();'));
        echo '<form id="searchForm" method="POST" action="'.$this->createUrl('checkPlateNumberByRegLookUpMobile').'">';
        echo '<br/>Adj. Km Reading';
        echo '<div class="form1">' . CHtml::textField('userGuideKm', '', array('class' => 'km', 'id' => 'adjustKmByRegLookup', 'maxlength' => '3', 'autocomplete' => 'off')) . '</div>';
        echo '<b>km (x1000)</b>';
        echo CHtml::hiddenField('VehicleRegNumber', $vehicle['registerVehicleNumber']);
        echo CHtml::hiddenField('vehicleYear', $vehicle['year']);
        echo CHtml::hiddenField('usedCarComModel', $type);
        echo CHtml::hiddenField('defaultKmsForYear', ($vehicle['kmsForYear']*1000 / 1000));
        echo CHtml::hiddenField('checkedAllCheckboxes', '');
        echo CHtml::hiddenField('customValueGrp', '');
        echo CHtml::hiddenField('search', 1);
        echo CHtml::hiddenField('useAjax', 1);
        echo CHtml::hiddenField('coreCodenumberForCustomValue', '');
        
        if(!empty($_POST['dropListDoors'])){$dropListDoors=$_POST['dropListDoors'];}else {$dropListDoors=null;}
        if(!empty($_POST['dropListBodies'])){$dropListBodies=$_POST['dropListBodies'];}else {$dropListBodies=null;}
        if(!empty($_POST['dropListTransmissions'])){$dropListTransmissions=$_POST['dropListTransmissions'];}else {$dropListTransmissions=null;}
        if(!empty($_POST['dropListTypes'])){$dropListTypes=$_POST['dropListTypes'];}else {$dropListTypes=null;}
        if(!empty($_POST['importId'])){$importId=$_POST['importId'];}else {$dropListTypes=null; $importId=null;}
        
        echo CHtml::hiddenField('dropListDoors', $dropListDoors);
        echo CHtml::hiddenField('dropListBodies', $dropListBodies);
        echo CHtml::hiddenField('dropListTransmissions', $dropListTransmissions);
        echo CHtml::hiddenField('dropListTypes', $dropListTypes);
        echo CHtml::hiddenField('importId', $importId);
        
        echo CHtml::hiddenField('YII_CSRF_TOKEN', Yii::app()->request->csrfToken);
        echo CHtml::submitButton('ADJUST', array('name'=>'search', 'class'=>'button'));
//        echo CHtml::button('ADJUST', array('class' => 'button1',
//            'id' => 'adjustRegLookupBtn',
//            //'onclick' => CHtml::ajax(array('type' => 'POST', 'url' => array("registrationService/ajaxCalculateByRegLookUpMobile"),
//            'onclick' => CHtml::ajax(array('type' => 'POST', 'url' => array("registrationService/ajaxCalculateByRegLookUpMobile"),
//                'update' => '#associatedCarTable',
//               // 'beforeSend' => 'doActionsBeforeSend()',
//                'complete' => 'updateKmsAdjustResults()',
//            ))
//        ));
        //echo Chtml::endForm();
        ?>
                    </form>
            </center>
           
        </div>
<?php }
?>
        <!--<div style="display: none;" id="odometerError" class="flash-error" role="alert">Please enter the correct Kms number.</div>-->

        
        
        
   
        </div>
            <?php $searchByMakeModelLink = ($type == 'UsedCarsModel') ? 'mobile/selectCars' : 'mobile/selectCommercials'; ?>
     
        <!--<div class="custom WrapperPadding" style="text-transform: none; height: 50px; display:block;">Not your vehicle? <br />Search <a class="buttonImitation" href="<?php echo Yii::app()->createUrl($searchByMakeModelLink); ?>">By Make/Model</a></div>-->
        <?php else: // empty model ?>
        

        <div class="associatedContainer" style="padding-bottom: 40px;">
            <div>MTP valuation unavailable at this time. This may be due to:</div>
            <ol type="a">
                <li>Insufficient market activity.</li>
                <li>The age of the vehicle falls outside our normal parameters.</li>
            </ol>
            <span class="text">Please contact our office for a valuation on this vehicle. Phone 01 8775460</span>
        </div>

    <?php endif; ?>

<?php endif; //empty vehicle - data from RI  ?>


<?php // spinner ?>

<script>
    $body = $("body");

    $(document).on({
        ajaxStart: function () {
            $body.addClass("loading");
        },
        ajaxStop: function () {
            $body.removeClass("loading");
        }
    });
    
    function updateKmsAdjustResults(){        
        showAdjustedNotification();
        setTimeout(function(){ $("#associatedCarTable").trigger('create');}, 3000);
      //  window.top.sendHeight();
        
    }
</script>
<div class="modal"></div>


