<?php
if (Yii::app()->user->hasFlash('errorMsg')) {
    echo '<div class="flash-error" role="alert">';
    echo Yii::app()->user->getFlash('errorMsg');
    echo '</div>';
}

$arch = null;
        if(!empty($_POST['arch'])){
            $arch = $_POST['arch'];
        }
?>

<?php if (!empty($vehicle)): ?>

    <?php
//echo var_dump($vehicle);'MTP (codenumber)='.$model['codenumber'] .' RI (code)='.$vehicle['code']; 
//var_dump($model);
//echo '<br/>';
//var_dump($vehicle);

    ?>
    <h1>Vehicle Data for <?php echo $vehicle['registerVehicleNumber']; ?>
        <?php if(Yii::app()->params['used_car_com_code_column_visibility']){
               echo '(code '.$vehicle['code'].')';
            }?>
			
        <span style="font-size:9px;">powered by <a target="_blank" href="http://www.mywheels.ie">MyWheels.ie</a></span></h1>

    <table class="column1">
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
            <td><span class="text">Body</span></td><td><?php echo $vehicle['body']; ?></td>
        </tr>
    </table>

    <table class="column2">
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
            <td><span class="text">Motor Tax</span></td><td><?php echo $vehicle['roadTax']; ?></td>
        </tr>
    </table>

    <?php if (!empty($model)): ?>
        <div class="associatedContainer">
        <?php $changedModelVehicleData = RegistrationService::getChangeRiDataResults($model, $vehicle); ?>
            <div>MTP Associated Values for: <span class="text"><?php echo $changedModelVehicleData['make'] . ' ' . $changedModelVehicleData['model']; ?></span></div>
            <span class="subTitle">
        <?php echo $vehicle['importTitle']; ?>
            </span>
            <br />
            Average Kilometre Reading <span id="defaultUserGuideKm" class="text"><?php echo $vehicle['kmsForYear']*1000 / 1000; ?></span> km (x1000).
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
       
        
        echo CHtml::beginForm('', '', array('onsubmit' => 'return valid();'));
        echo 'Adjusted Kilometre Reading';
        echo '<div class="form1">' . CHtml::textField('userGuideKm', '', array('class' => 'km', 'id' => 'adjustKmByRegLookup', 'maxlength' => '3', 'autocomplete' => 'off')) . '</div>';
        echo 'km (x1000)';
        echo CHtml::hiddenField('VehicleRegNumber', $vehicle['registerVehicleNumber']);
        echo CHtml::hiddenField('vehicleYear', $vehicle['year']);
        echo CHtml::hiddenField('usedCarComModel', $type);
        echo CHtml::hiddenField('defaultKmsForYear', ($vehicle['kmsForYear']*1000 / 1000));
        echo CHtml::hiddenField('checkedAllCheckboxes', '');
        echo CHtml::hiddenField('customValueGrp', '');
        echo CHtml::hiddenField('coreCodenumberForCustomValue', '');
        echo CHtml::hiddenField('YII_CSRF_TOKEN', Yii::app()->request->csrfToken);
         if(!empty($arch)){
            echo CHtml::button('ADJUST', array('class' => 'button1',
            'id' => 'adjustRegLookupBtn',
            'onclick' => CHtml::ajax(array('type' => 'POST', 'url' => array("registrationService/ajaxCalculateByRegLookUpArch", array('arch'=>$arch)),
                'update' => '#associatedCarTable',
                'beforeSend' => 'doActionsBeforeSend()',
                'complete' => 'showAdjustedNotification()',
            ))
        ));
        }else {
            echo CHtml::button('ADJUST', array('class' => 'button1',
            'id' => 'adjustRegLookupBtn',
            'onclick' => CHtml::ajax(array('type' => 'POST', 'url' => array("registrationService/ajaxCalculateByRegLookUp"),
                'update' => '#associatedCarTable',
                'beforeSend' => 'doActionsBeforeSend()',
                'complete' => 'showAdjustedNotification()',
            ))
        ));
        }
        
        echo Chtml::endForm();
        ?>

            <br />
        </div>

        <!--<div style="display: none;" id="odometerError" class="flash-error" role="alert">Please enter the correct Kms number.</div>-->

        <?php
        echo '<div style="height:50px; margin-bottom: 5px;"><div id="adjustedNotice" style="width: 940px; display:none;" class="flash-warning" role="alert">';
        echo 'Data updating. Please wait...';
        echo '</div></div>';
        ?>
        <?php
        $years = $model['years'];
//$vehicle['year']=11;
        if (!empty($years)) {
            $yearsArr = explode('/', $years);
            if (sizeof($yearsArr) > 1) {
                $yearFrom = $yearsArr[0];
                $yearTo = $yearsArr[1];
            } else {
                $yearFrom = $years;
                $yearTo = $years;
            }
            if ($vehicle['year'] == $yearFrom || $vehicle['year'] == $yearTo) {
                echo '<div style="height:50px; margin-bottom: 5px;"><div id="borderYearWarning" style="width: 940px;" class="flash-warning" role="alert">';
                echo "**Note** Model change may have occurred in this year. MTP Associated values below correspond to model year " . $years . ". 
                        <br/><br/>
                        <B>Please check the exact model of your vehicle and search by Make or model if it differs from the model listed.</b>";
                echo '</div>';
            }
        }
        ?>

        <?php // generowanie PDF z $RIdata ?>
        <div style="width:970px; float:left;">
        <?php  if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){ ?>
                <a style="float:right; text-decoration: none; color:#2D8296; font-weight: bolder;" onclick="openPdf();" id="pdfByRegLookup" href="#">Download PDF <img src="./images/pdf.png" style="    vertical-align: middle; width:28px; height:28px; border: none;" alt="[pdf]" /></a>
            <?php }else{ // website_type?>
            <a style="float:right; text-decoration: none; color:#2D8296; font-weight: bolder;" id="pdfByRegLookup" href="<?php echo Yii::app()->createUrl('registrationService/pdfByRegLookUp', array('vnumber' => $vehicle['registerVehicleNumber'], 'type' => $type, 'defaultKmsForYear' => ($vehicle['kmsForYear']*1000 / 1000), 'userGuideKm' => $vehicle['kmsForYear']*1000 / 1000, 'grpCustomValeResult' => '', 'coreCodeNumber' => '', 'checkedCheckboxes' => '', 'end' => 1)) ?>">Download PDF <img src="./images/pdf.png" style="    vertical-align: middle; width:28px; height:28px; border: none;" alt="[pdf]" /></a>
            <?php } // website_type?>
        </div>
        <div id="associatedCarTable" style="width:970px;">
        <?php
        $this->renderPartial('_associatedValuesByRegLookUp', array(
            'model' => $model,
            'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
            'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
            'calculatedMain_coreWithAssociatedCars' => $calculatedMain_coreWithAssociatedCars,
            'calculatedRest_coreWithAssociatedCars' => $calculatedRest_coreWithAssociatedCars,
            'vehicleYear' => $vehicle['year'],
            'checkedAllCheckboxes' => '',
            'grpCustomValeResult' => '',
            'calculatedCustomValue' => '',
        ));
        ?>
        </div>
            <?php $searchByMakeModelLink = ($type == 'UsedCarsModel') ? 'member/usedCars' : 'member/usedCommercial'; ?>
        <h1 class="custom" style="text-transform: none;">Not your vehicle? Search <a class="buttonImitation" href="<?php echo Yii::app()->createUrl($searchByMakeModelLink.'IFrame'); ?>">By Make/Model</a></h1>
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
  <?php  if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){ ?>
     function openPdf(){
        var userKms = $('#adjustKmByRegLookup').val();
        var url = '<?php echo Yii::app()->createUrl('registrationService/pdfByRegLookUp', array('vnumber' => $vehicle['registerVehicleNumber'], 'type' => $type, 'defaultKmsForYear' => ($vehicle['kmsForYear']*1000 / 1000), 'grpCustomValeResult' => '', 'coreCodeNumber' => '', 'checkedCheckboxes' => '', 'end' => 1)); ?>';
        var newUrl = url+'&userGuideKm='+userKms;
        //alert(newUrl);
        window.location.href = newUrl;
        
    }
<?php } ?>
    $body = $("body");

    $(document).on({
        ajaxStart: function () {
            $body.addClass("loading");
        },
        ajaxStop: function () {
            $body.removeClass("loading");
        }
    });
</script>
<div class="modal"></div>