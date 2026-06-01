    <div id="headItems">
        <div class="associatedItem" style="width: 235px;"><span style="min-width: 235px;max-width: 235px;display: block;"></span></div>
        <!--<div class="associatedItem" style="width: 160px;"><span style="min-width: 160px;max-width: 160px;display: block;">Model</span></div>-->
        <div class="associatedItem" style="width: 165px;"><span style="margin-left:5px; min-width: 165px;max-width: 165px;display: block;">Type</span></div>
        <div class="associatedItem" style="width: 65px;"><span style="min-width: 65px;max-width: 65px;display: block;">Doors</span></div>
        <div class="associatedItem" style="width: 90px;"><span style="min-width: 90px;max-width: 90px;display: block;">Body</span></div>
        <div class="associatedItem" style="width: 120px;"><span style="min-width: 120px;max-width: 120px;display: block;">Transmission</span></div>
        <div class="associatedItem" style="width: 70px;"><span style="min-width: 70px;max-width: 70px;display: block;">GRP €</span></div>
        <div class="associatedItem" style="width: 90px;"><span style="min-width: 90px;max-width: 90px;display: block;">GRP km Adjustment</span></div>
        <!--<div class="associatedItem" style="width: 80px;"><span style="min-width: 80px;max-width: 80px;display: block;">Option Adjust. €</span></div>-->
        <div class="associatedItem" style="width: 70px;"><span style="min-width: 70px;max-width: 70px;display: block;">Multiple Option</span></div>
    </div>
    
    <?php // main CORE CAR WITH ASSOCIATED CARS ?>
    <?php if(!empty($main_coreWithAssociatedCarsModel)): ?>
        <?php foreach($main_coreWithAssociatedCarsModel as $item): ?>
            <?php 
            //var_dump($item);
            //echo 'corecpde:'.$item['corecode'];
            //
            if(Yii::app()->params['used_car_com_code_column_visibility']){
               // echo ':'.$item['codenumber'];
            }
            //echo 'corecpde:'.$item['codenumber'];
            //exit;
            if(RegistrationService::getFieldValueForYear("yr", $vehicleYear, $item) != ''){ ?>
                <div id="modelDetail" class="<?php echo (empty($item['corecode'])) ? "mtpGuide" : "mtpOption"; ?>">
                    <div class="associatedItem" style="width: 235px !important;"><span style="min-width: 235px;max-width: 235px;display: block;"><?php echo (empty($item['corecode'])) ? "MTP Guide" : ((empty($item['linkas'])) ? "MTP Option" : "MTP Option - ".$item['linkas'] ); ?></span></div>
                    <!--<div class="associatedItem" style="width: 160px !important;"><span style="min-width: 160px;max-width: 160px;display: block;"><?php echo $item['vehicle'] ?></span></div>-->
                    <?php if(Yii::app()->params['used_car_com_code_column_visibility']){
                        ?>
                     
                     <div class="associatedItem" style="width: 165px !important;"><span style="margin-left:5px; min-width: 165px;max-width: 165px;display: block;"><?php echo $item['badgetype'].' ('.$item['codenumber'].')';?></span></div>
                    <?php
                    }else{
                        ?>
                     <div class="associatedItem" style="width: 165px !important;"><span style="margin-left:5px; min-width: 165px;max-width: 165px;display: block;"><?php echo $item['badgetype']?></span></div> 
                     <?php
                    } 
                    ?>
                   
                    <div class="associatedItem" style="width: 50px !important;"><span style="padding-left: 15px; min-width: 50px;max-width: 50px;display: block;"><?php echo $item['drs']?></span></div>
                    <div class="associatedItem" style="width: 90px !important;"><span style="min-width: 90px;max-width: 90px;display: block;"><?php echo $item['bod']?></span></div>
                    
                    <div class="associatedItem" style="width: 120px !important;"><span style="min-width: 120px;max-width: 120px;display: block;"><?php echo $item['transmission']?></span></div>
                    <div class="associatedItem" style="width: 70px !important;"><span id="grp_<?php echo $item['codenumber'];?>" style="min-width: 70px;max-width: 70px;display: block;"><?php echo RegistrationService::getFieldValueForYear("GRP", $vehicleYear, $item); ?></span></div>
                    <div class="associatedItem" style="width: 90px !important;"><span style="min-width: 90px;max-width: 90px;display: block;"><?php echo RegistrationService::getCalculatedValueByCodeNumber($calculatedMain_coreWithAssociatedCars, $item['codenumber']); ?></span></div>
                    
                    <span id="diff_<?php echo $item['codenumber'];?>" style="display: none;"><?php echo (empty($item['corecode'])) ? '' : RegistrationService::getFieldValueForYear("diff", $vehicleYear, $item); ?></span>
                    <div class="associatedItem" style="width: 50px !important;">
                            <span style="text-align: center; min-width: 50px;max-width: 50px;display: block;">
                            <?php if(!empty($item['corecode'])) {
                                    echo CHtml::checkbox('checkbox_'.$item['corecode'],
                                            (strpos($checkedAllCheckboxes,'checkbox_'.$item['codenumber']) === false) ? false : true,
                                            array('id'=>'checkbox_'.$item['codenumber'],'onclick'=>'createGrpCustomValue('.$item['corecode'].');'));         
                                  } 
                            ?>
                            </span>
                    </div>
                </div>
            <?php }//endif; ?>
        <?php endforeach; ?>

    <?php // MOCK ONLY FOR TEST SITE
        // $rest_coreWithAssociatedCarsModel = array();
    ?>
        <?php // rest CORE CARS WITH ASSOCIATED CARS ?>
        <?php foreach($rest_coreWithAssociatedCarsModel as $item): ?>
                <?php 
                    if($main_coreWithAssociatedCarsModel[0]['codenumber'] == $item['codenumber'] ||
                       $main_coreWithAssociatedCarsModel[0]['codenumber'] == $item['corecode']) {
                        continue;
                    }
                ?>
                <?php if(RegistrationService::getFieldValueForYear("yr", $vehicleYear, $item) != ''){?>
                    <div id="modelDetail" class="<?php echo (empty($item['corecode'])) ? "mtpGuide" : "mtpOption"; ?>">
                    <div class="associatedItem" style="width: 235px !important;"><span style="min-width: 235px;max-width: 235px;display: block;"><?php echo (empty($item['corecode'])) ? "MTP Guide" : ((empty($item['linkas'])) ? "MTP Option" : "MTP Option - ".$item['linkas'] ); ?></span></div>
                    <!--<div class="associatedItem" style="width: 160px !important;"><span style="min-width: 160px;max-width: 160px;display: block;"><?php echo $item['vehicle'] ?></span></div>-->
                    <?php if(Yii::app()->params['used_car_com_code_column_visibility']){
                        ?>
                    <div class="associatedItem" style="width: 165px !important;"><span style="margin-left:5px; min-width: 165px;max-width: 165px;display: block;"><?php echo $item['badgetype'].' ('.$item['codenumber'].')';?></span></div>
                    <?php
                    }else{
                        ?>
                        <div class="associatedItem" style="width: 165px !important;"><span style="margin-left:5px; min-width: 165px;max-width: 165px;display: block;"><?php echo $item['badgetype']?></span></div>
                    <?php
                    }
                        ?>
                    <div class="associatedItem" style="width: 50px !important;"><span style="padding-left: 15px; min-width: 50px;max-width: 50px;display: block;"><?php echo $item['drs']?></span></div>
                    <div class="associatedItem" style="width: 90px !important;"><span style="min-width: 90px;max-width: 90px;display: block;"><?php echo $item['bod']?></span></div>
                    
                    <div class="associatedItem" style="width: 120px !important;"><span style="min-width: 120px;max-width: 120px;display: block;"><?php echo $item['transmission']?></span></div>
                    <div class="associatedItem" style="width: 70px !important;"><span id="grp_<?php echo $item['codenumber'];?>" style="min-width: 70px;max-width: 70px;display: block;"><?php echo RegistrationService::getFieldValueForYear("GRP", $vehicleYear, $item); ?></span></div>
                    <div class="associatedItem" style="width: 90px !important;"><span style="min-width: 90px;max-width: 90px;display: block;"><?php echo RegistrationService::getCalculatedValueByCodeNumber($calculatedRest_coreWithAssociatedCars, $item['codenumber']); ?></span></div>
                    
                    <span id="diff_<?php echo $item['codenumber']?>" style="display: none;"><?php echo (empty($item['corecode'])) ? '' : RegistrationService::getFieldValueForYear("diff", $vehicleYear, $item); ?></span>
                    <div class="associatedItem" style="width: 50px !important;">
                            <span style="text-align: center; min-width: 50px;max-width: 50px;display: block;">
                            <?php if(!empty($item['corecode'])) {
                                    echo CHtml::checkbox('checkbox_'.$item['corecode'],
                                            (strpos($checkedAllCheckboxes,'checkbox_'.$item['codenumber']) === false) ? false : true,
                                            array('id'=>'checkbox_'.$item['codenumber'],'onclick'=>'createGrpCustomValue('.$item['corecode'].');'));         
                                  } 
                            ?>
                            </span>
                    </div>
                    </div>
                <?php }//endif; ?>
        <?php endforeach; ?>

                    <!--CUSTOM VALUES-->
                    <div id="modelDetail" class="mtpGuide" style="background-color: #e8eae5; border-top: 1px solid #d0d2ce;">
                        <div class="associatedItem" style="width: 705px !important;">CUSTOM VALUE<img class="customValueInfoBtn" src="./images/info_btn.png" /><br />For a combination of MTP Options, select "Multiple Options" for a custom value</div>
                        <div class="associatedItem" style="width: 70px !important;"><span id="grpCustomValeResult" style="min-width: 70px;max-width: 70px;display: block;"><?php echo $grpCustomValeResult; ?></span></div>
                        <div class="associatedItem" style="width: 90px !important;"><span id="calcGrpCustomVale" style="min-width: 90px;max-width: 90px;display: block;"><?php if(empty($grpCustomValeResult)){}else {echo $calculatedCustomValue;} ?></span></div>
                    </div>

    <?php else: ?>
    <?php
        if(Yii::app()->user->hasFlash('infoMsg')){
            echo '<div class="flash-notice" role="alert">';
            echo Yii::app()->user->getFlash('infoMsg');
            echo '</div>';
        }
    ?>
    <?php endif; ?>

<script type="text/javascript">
    function createGrpCustomValue(coreCode) {
        // disable all checkbox exept actual
        disableOtherCheckboxes('checkbox_' + coreCode);
        
        // get core main GRP
        var coreGRP = $("#grp_" + coreCode).html();
        coreGRP = coreGRP.substring(1,coreGRP.length);
        var result = parseInt(coreGRP);
        console.log('result:'+result);
        
        // get all diff values
        var checkboxName = 'checkbox_'+coreCode;
        $("input[name='" + checkboxName + "']").each( function () {
            if($(this).is(':checked')){
                var inputId = $(this).prop('id');
                var diffId = inputId.substring(9,inputId.length);
                diffValue = $("#diff_" + diffId).html();
                
                result = result + parseInt(diffValue);
            }
        });
        
        // check is something checked
        var isSthChecked = isSomethingChecked();
        if(isSthChecked){
            $("#grpCustomValeResult").html('€' + result);
            callAdjust();
        } else {
            //console.log(isSomethingChecked());
            $("#grpCustomValeResult").html('');
            $("#calcGrpCustomVale").html('');
            fillCheckedAllCheckboxes();
            //console.log($("#calcGrpCustomVale").html());
        }
    }
    
    function disableOtherCheckboxes(actualCheckboxes) {
        $('#associatedCarTable input:checked').each(function() {
            var checkboxId = $(this).prop('name');
            if(checkboxId != actualCheckboxes){
                $("input[name='" + checkboxId + "']").prop('checked',false);
            }
        });
    }
    
    function isSomethingChecked() {
        return ($('#associatedCarTable input:checked').size() > 0) ? true : false;
    }
    
    function callAdjust() {
        $("#adjustRegLookupBtn").click();
    }
    
    // call colorbox for custom value info
    $(".customValueInfoBtn").click(function () { 
        $.colorbox({html: '<img  width="714" height="194" src="./images/customValueInfo.png" />'});
    });
</script>