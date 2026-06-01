
<!--<div id="headItems">
        <div class="associatedItem" style="width: 235px;"><span style="min-width: 235px;max-width: 235px;display: block;"></span></div>
        <!--<div class="associatedItem" style="width: 160px;"><span style="min-width: 160px;max-width: 160px;display: block;">Model</span></div>
        <div class="associatedItem" style="width: 165px;"><span style="min-width: 165px;max-width: 165px;display: block;">Type: </span></div>
        <div class="associatedItem" style="width: 65px;"><span style="min-width: 65px;max-width: 65px;display: block;">Doors: </span></div>
        <div class="associatedItem" style="width: 90px;"><span style="min-width: 90px;max-width: 90px;display: block;">Body: </span></div>
        <div class="associatedItem" style="width: 120px;"><span style="min-width: 120px;max-width: 120px;display: block;">Transmission: </span></div>
        <div class="associatedItem" style="width: 70px;"><span style="min-width: 70px;max-width: 70px;display: block;">GRP €: </span></div>
        <div class="associatedItem" style="width: 90px;"><span style="min-width: 90px;max-width: 90px;display: block;">GRP km Adjustment: </span></div>
        <!--<div class="associatedItem" style="width: 80px;"><span style="min-width: 80px;max-width: 80px;display: block;">Option Adjust. €</span></div>
        <div class="associatedItem" style="width: 70px;"><span style="min-width: 70px;max-width: 70px;display: block;">Multiple Option: </span></div>
    </div>-->
    
<?php 
    $uniqueSelector = time();
    $types = array();
    $doors = array();
    $bodies = array();
    $selectAllowed = array();
    $transmissions = array(); 
    $carResults = null;
    
    if(!empty($main_coreWithAssociatedCarsModel) ||  !empty($rest_coreWithAssociatedCarsModel)) {
        $carResults = array_merge($main_coreWithAssociatedCarsModel,$rest_coreWithAssociatedCarsModel);
       // echo 'a';
       // var_dump($carResults);
       // exit;
    }
    //$selectedValues = getSelectedValues();
    
    foreach ($carResults as $car) {
       // echo "badge type".$car['badgetype'];
//        if(fitsSelectedValues($car)){
            //echo '->'.$car['years'].'<-';
        $searchYearGRPValue = RegistrationService::getFieldValueForYear("GRP", $vehicleYear, $car);
        if(!empty($searchYearGRPValue)){
            
       
            if (!in_array($car['badgetype'], $types)) {
                
                //if(UsedCars::isInYears($car['years'], $vehicleYear)){
                    $types[$car['badgetype']] = $car['badgetype'];
                //}
                
            }
            
            if (!in_array($car['drs'], $doors)) {
                $doors[$car['drs']] = $car['drs'];
            }

            if (!in_array($car['bod'], $bodies)) {
                $bodies[$car['bod']] = $car['bod'];
            }

            if (!in_array($car['transmission'], $transmissions)) {
                $transmissions[$car['transmission']] = $car['transmission'];
            }
            //select arrays allowed
            $selectAllowed['types']['drs'][$car['badgetype']][]=$car['drs'];
            $selectAllowed['types']['bod'][$car['badgetype']][]=$car['bod'];
            $selectAllowed['types']['transmission'][$car['badgetype']][]=$car['transmission'];
            
            $selectAllowed['drs']['bod'][$car['drs']][]=$car['bod'];
            $selectAllowed['drs']['transmission'][$car['drs']][]=$car['transmission'];
            
            $selectAllowed['bod']['transmission'][$car['bod']][]=$car['transmission'];
            
            foreach($selectAllowed['types']['drs'] as $key=>$value){
                $selectAllowed['types']['drs'][$key] = array_unique($value);
            }
            foreach($selectAllowed['types']['bod'] as $key=>$value){
                $selectAllowed['types']['bod'][$key] = array_unique($value);
            }
            foreach($selectAllowed['types']['transmission'] as $key=>$value){
                $selectAllowed['types']['transmission'][$key] = array_unique($value);
            }
            foreach($selectAllowed['drs']['bod'] as $key=>$value){
                $selectAllowed['drs']['bod'][$key] = array_unique($value);
            }
            foreach($selectAllowed['drs']['transmission'] as $key=>$value){
                $selectAllowed['drs']['transmission'][$key] = array_unique($value);
            }
            foreach($selectAllowed['bod']['transmission'] as $key=>$value){
                $selectAllowed['bod']['transmission'][$key] = array_unique($value);
            }
            
            $selctScript = '     
            ';
        }
        }
    
//    function fitsSelectedValues($optionCar){
//        $matchSelected = true;
//        $selectedValues = getSelectedValues();
//        
//        //type
//        if(!empty($selectedValues['dropListTypes'])){
//            if($selectedValues['dropListTypes']!=$optionCar['badgetype']){
//                $matchSelected = false;
//            }
//        }
//        //doors
//        if(!empty($selectedValues['dropListDoors'])){
//            if($selectedValues['dropListDoors']!=$optionCar['drs']){
//                $matchSelected = false;
//            }
//        }
//        //body
//        if(!empty($selectedValues['dropListBodies'])){
//            if($selectedValues['dropListBodies']!=$optionCar['bod']){
//                $matchSelected = false;
//            }
//        }
//        //transmission
//        if(!empty($selectedValues['dropListTransmissions'])){
//            if($selectedValues['dropListTransmissions']!=$optionCar['transmission']){
//                $matchSelected = false;
//            }
//        }
//        return $matchSelected;
//    }
    function dumpValues($arr){
        foreach ($arr as $key=>$val){
            echo 'key:'.$key.'-->'.$val;
        }
    }
    function myCustomSearch($array, $searchType, $searchDoors, $searchBody, $searchTransmission, $calculatedMain_coreWithAssociatedCars, $calculatedRest_coreWithAssociatedCars, $vehicleYear) {
        $cars = array();        
        if(!empty($_POST['userGuideKm'])){
            $calculatedArray = $calculatedMain_coreWithAssociatedCars+$calculatedRest_coreWithAssociatedCars;
            
        }
        //MW HERE
        foreach ($array as $key => $result) {
            if ($result['badgetype'] == $searchType && $result['drs'] == $searchDoors && $result['bod'] == $searchBody && $result['transmission'] == $searchTransmission) {
                $cars[] = $result;
            }
        }
        
        if (!empty($cars)) {
            //echo '<b>Search results:</b>';
//            foreach ($cars as $car) {
                $car = $cars[0];//ME HERE !!!!! we need only one result - if more than one they are the same anyway
                if ($car['linkas'] == "") {
                    echo '<h2 class="upper_case"><b>MTP GUIDE VALUATION</b></h2>';
                }
                
                else {
                    echo '<div>MTP Option: ' .  $car['linkas'] . '</div>';
                }
               // echo 'veh_year:'.$vehicleYear.'---------';
               // var_dump($car);
                ?>

                <table class="column1 gray_back">
                    <tr>
                        <td><span class="text">Type</span></td><td><?php echo $car['badgetype']; ?></td>
                    </tr>
                    <tr>
                        <td><span class="text">Doors</span></td><td><?php echo $car['drs']; ?></td>
                    </tr>
                    <tr>
                        <td><span class="text">Body</span></td><td><?php echo $car['bod']; ?></td>
                    </tr>
                    <tr>
                        <td><span class="text">Transmission</span></td><td><?php echo $car['transmission']; ?></td>
                    </tr>
                    <tr>
                        <td><b><span class="text">GRP</span></b></td><td><b><?php echo RegistrationService::getFieldValueForYear("GRP", $vehicleYear, $car);/*$car['GRP1'];*/ ?></b></td>
                    </tr>
                
                
                
                
                <?php
//                echo '<div>Type: <b>' .  $car['badgetype'] . '</b></div>';
//                echo '<div>Doors: ' .  $car['drs'] . '</div>';
//                echo '<div>Body: ' .  $car['bod'] . '</div>';
//                echo '<div>Transmission: ' .  $car['transmission'] . '</div>';
//                echo '<div><b>GRP: ' .  $car['GRP1'] . '</b></div><br><br><br>';
                if(!empty($_POST['userGuideKm'])){
                   // echo 'tu';
                   // dumpValues($calculatedArray);
                   // exit;
                $adjustedValue =  RegistrationService::getCalculatedValueByCodeNumber($calculatedArray, $car['codenumber']); 
                    if(!empty($adjustedValue)){
                        //echo '<div class="associatedItem" style="width: 100% !important;"><span style="display: block;"><b>GRP (km Adjusted): '.$adjustedValue.'</b> </span></div>';
                        echo '<tr>
                                <td><span class="text">GRP (km Adjusted)</span></td><td>'.$adjustedValue.'</td>
                              </tr>';
                    }else {
//                        echo '<tr>
        //                        <td><span class="text">GRP (km Adjusted)</span></td><td>'.$adjustedValue.'</td>
        //                      </tr>';
                          // echo 'Adjusted value:';
                    }
                }
                echo '</table>';   
//            }
        }
        
        else {
            echo ' <br><div><b>No results</b> </div> <br>';
        }
    }
    
//    function getSelectedValues(){
//        $selectedFields = array();
//        if(!empty($_GET['last_select'])){
//            
//            $lastSelect = $_GET['last_select'];
//            if($lastSelect>=0){$selectedFields['dropListTypes']=$_POST['dropListTypes'];}
//            if($lastSelect>=1){$selectedFields['dropListDoors']=$_POST['dropListDoors'];}
//            if($lastSelect>=2){$selectedFields['dropListBodies']=$_POST['dropListBodies'];}
//            if($lastSelect>=3){$selectedFields['dropListTransmissions']=$_POST['dropListTransmissions'];}
//            
//            return $selectedFields;
//           // for($selectI=0; $selectI<4;$selectI++){
//              //  $selectedFIelds['']
//                //if($lastSelect==$selectI) break;
//           // }
//        //}
//        }
//    }
    

    
    ?>

    <div id="searchResults"></div>                 
<?php 
        if(!empty($_POST['dropListDoors'])){$dropListDoors=$_POST['dropListDoors'];}else {$dropListDoors=null;}
        if(!empty($_POST['dropListBodies'])){$dropListBodies=$_POST['dropListBodies'];}else {$dropListBodies=null;}
        if(!empty($_POST['dropListTransmissions'])){$dropListTransmissions=$_POST['dropListTransmissions'];}else {$dropListTransmissions=null;}
        if(!empty($_POST['dropListTypes'])){$dropListTypes=$_POST['dropListTypes'];}else {$dropListTypes=null;}
        if(!empty($_POST['importId'])){$importId=$_POST['importId'];}else {$dropListTypes=null; $importId=null;}
        
//    if (isset($_POST['search'])) {
//   
//        myCustomSearch($carResults, $dropListTypes, $dropListDoors, $dropListBodies, $dropListTransmissions);
//       
//    }
        
?>     

<div class="divSelect">
    <form id="searchForm" method="POST" action="<?php $this->createUrl('checkPlateNumberByRegLookUpMobile');  ?>">
    <!--    <div class="selectLabel">Type</div>                 -->
    <div class="mtpGuide" style="background-color: #e8eae5; padding:10px; border: 1px solid #d0d2ce;">Choose your vehicle specific features below to see the exact MTP associated value.</div>
    <?php 
        
       
    
        echo CHtml::hiddenField('VehicleRegNumber', $_POST['VehicleRegNumber']);
        echo CHtml::hiddenField('usedCarComModel', $_POST['usedCarComModel']);
        echo CHtml::hiddenField('importId', $importId);
        echo CHtml::hiddenField('useAjax', 1);
        echo CHtml::hiddenField('hfType'.$uniqueSelector);
        echo CHtml::hiddenField('hfDoors'.$uniqueSelector);
        echo CHtml::hiddenField('hfBody'.$uniqueSelector);
        echo CHtml::hiddenField('hfTransmission'.$uniqueSelector);
      
         
        echo CHtml::dropDownList('dropListTypes', $dropListTypes, $types,
            array (
                'empty' => 'Select Type',
                'id' => 'selectType_'.$uniqueSelector,
                'class' => 'carSelect',
//                'onclick' => CHtml::ajax(array('type' => 'POST', 'url' => array("registrationService/checkPlateNumberByRegLookUpMobile"),
//                    'update' => "#associatedCarTable",
//                    //'beforeSend' => 'doActionsBeforeSend()',
//                    'complete' => 'updateResults()',
//                    ))
//                'ajax' => array(
//                    'type'=>'POST',
//                    'url'=>CController::createUrl('registrationService/checkPlateNumberByRegLookUpMobile', ['lastSelected'=>0]),
//                    //'data'=>'js:jQuery("#searchForm").serialize()',
//                    'success'=>'js:function(data) {
//                        $("#searchResults").html(data);
//                    }'
//                )
            )
        );
        
        
        echo CHtml::dropDownList('dropListDoors',  $dropListDoors, $doors,
            array (
                'empty' => 'Select Doors',
                'id' => 'selectDoors_'.$uniqueSelector,
                'class' => 'carSelect'
            )
        ); 

        
        echo CHtml::dropDownList('dropListBodies',  $dropListBodies, $bodies,
            array (
                'empty' => 'Select Body',
                'id' => 'selectBody_'.$uniqueSelector,
                'class' => 'carSelect'
            )
        ); 
        
        echo CHtml::dropDownList('dropListTransmissions',  $dropListTransmissions, $transmissions,
            array (
                'empty' => 'Select Transmission',
                'id' => 'selectTransmission_'.$uniqueSelector,
                'class' => 'carSelect'
            )
        );
    ?>
        <div class="center">
<!--            <input type="submit" value="Search" />-->
            <?php echo CHtml::submitButton('Search', array('name'=>'search', 'class'=>'button')); ?>
<!--            <a href="#" name="" data-role="button" data-theme="b" data-corners="false" onclick="searchCars(); return false;">Search</a>-->
        </div>
    </form>
</div>
 <?php    if (isset($_POST['search'])) {
   
        echo '<div style=" margin-bottom: 5px;"><div id="adjustedNotice" style="width: 940px; display:none;" class="flash-warning" role="alert">';
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
            if ($vehicleYear == $yearFrom || $vehicleYear == $yearTo) {
                //echo '<div style="height:250px; margin-bottom: 5px; display:block;"><div id="borderYearWarning" class="flash-warning" role="alert">';
//                echo "MODEL CHANGE MAY HAVE OCCURRED IN THIS YEAR – MTP ASSOCIATED VALUES BELOW CORRESPOND TO <b>MODEL YEAR " . $years . "</b>
//                        <br/><br/>
//                        <B><u>PLEASE CHECK THE EXACT MODEL <br>OF YOUR VEHICLE AND SEARCH BY <br>MAKE OR MODEL IF IT DIFFERS FROM <br>THE MODEL LISTED</u></b>";
                echo "Model change may have occured in this year - MTP Associated values below correspond to model year " . $years . "
                        <br/><br/>
                        <b>Please check the exact model of your vehicle and search by Make/Model if it differs from the model listed.</b>";

                echo '</div>';
            }
        }
       
        myCustomSearch($carResults, $dropListTypes, $dropListDoors, $dropListBodies, $dropListTransmissions, $calculatedMain_coreWithAssociatedCars, $calculatedRest_coreWithAssociatedCars, $vehicleYear);
       
    }
 ?>
    
   <!-- <div><?php //echo json_encode($selectAllowed);?></div>-->
    
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/mtp.js"></script>
<script type="text/javascript">
    
    function createGrpCustomValue(coreCode) {
        // disable all checkbox exept actual
        disableOtherCheckboxes('checkbox_' + coreCode);
//console.log('coreCode:'+coreCode);
        // get core main GRP
        var coreGRP = $("#grp_" + coreCode).html();
        //console.log('coreGRP:'+coreGRP);
        coreGRP = coreGRP.substring(6,coreGRP.length);
        //console.log('coreGRP2:'+coreGRP);
        var result = parseInt(coreGRP);
        //console.log('result:'+result);
        // get all diff values
        var checkboxName = 'checkbox_'+coreCode;
        //console.log('checkboxName:'+checkboxName);
        $("input[name='" + checkboxName + "']").each( function () {
            if($(this).is(':checked')){
                var inputId = $(this).prop('id');
               // console.log('inputId:'+inputId);
                var diffId = inputId.substring(9,inputId.length);                
                diffValue = $("#diff_" + diffId).html();
               // console.log('diffValue:'+diffValue);
                
                result = result + parseInt(diffValue);
             //   console.log('parseInt(diffValue):'+parseInt(diffValue));
             //   console.log('result last:'+result);
            }
        });
        
        // check is something checked
        var isSthChecked = isSomethingChecked();
        if(isSthChecked){
            $("#grpCustomValeResult").html('GRP: €' + result);
            callAdjust();
            $("#associatedCarTable").trigger('create');
        } else {
            //console.log(isSomethingChecked());
            $("#grpCustomValeResult").html('');
            $("#calcGrpCustomVale").html('');
            fillCheckedAllCheckboxes();
            window.top.sendHeight();
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
    
//        function markCheckedMobileCheckboxes(actualCheckboxes) {
//        $('#associatedCarTable input:checked').each(function() {
//            var checkboxId = $(this).prop('name');
//            if(checkboxId != actualCheckboxes){
//                $("input[name='" + checkboxId + "']").prop('checked',false);
//            }
//        });
//    }
    
    function isSomethingChecked() {
        return ($('#associatedCarTable input:checked').size() > 0) ? true : false;
    }
    
    function callAdjust() {
       // $("#adjustRegLookupBtn").click();
    }
    
    // call colorbox for custom value info
    $(".customValueInfoBtn").click(function () { 
        $.colorbox({html: '<img  width="714" height="194" src="./images/customValueInfo.png" />'});
    });
    
    $( document ).on( 'change', '#selectType_<?php echo $uniqueSelector ?>', function(e) {
        selectedVal = $('#selectType_<?php echo $uniqueSelector ?>').val();
        $('#hfType_<?php echo $uniqueSelector ?>').val(selectedVal);
        updateDoors(selectedVal, <?PHP echo json_encode($selectAllowed['types']['drs']);?>);
        updateBody(selectedVal, <?PHP echo json_encode($selectAllowed['types']['bod']);?>);
        updateTransmission(selectedVal, <?PHP echo json_encode($selectAllowed['types']['transmission']);?>);
    });
    
    $( document ).on( 'change', '#selectDoors_<?php echo $uniqueSelector ?>', function(e) {
        selectedVal = $('#selectDoors_<?php echo $uniqueSelector ?>').val();
        $('#hfDoors_<?php echo $uniqueSelector ?>').val(selectedVal);
        updateBody(selectedVal, <?PHP echo json_encode($selectAllowed['drs']['bod']);?>);
        updateTransmission(selectedVal, <?PHP echo json_encode($selectAllowed['drs']['transmission']);?>);
    });
    
    $( document ).on( 'change', '#selectBody_<?php echo $uniqueSelector ?>', function(e) {
        selectedVal = $('#selectBody_<?php echo $uniqueSelector ?>').val();
        $('#hfBody_<?php echo $uniqueSelector ?>').val(selectedVal);
        updateTransmission(selectedVal, <?PHP echo json_encode($selectAllowed['bod']['transmission']);?>);
    });
    
    $( document ).on( 'change', '#selectTransmission_<?php echo $uniqueSelector ?>', function(e) {
        $('#hfTransmission_<?php echo $uniqueSelector ?>').val($('#selectTransmission_<?php echo $uniqueSelector ?>').val());
    });
    
    function updateResults(){        
        //showAdjustedNotification();
        setTimeout(function(){ $("#WrapperPadding").trigger('create');}, 3000);
      //  window.top.sendHeight();
        
    }
    
   function  updateDoors(selectedVal, arr){
        var temp= arr;
        //alert(options);
        var $select = $('#selectDoors_<?php echo $uniqueSelector ?>');                        
        $select.find('option').remove();                          
        $.each(temp[selectedVal], function(key, value) {              
            $('<option>').val(value).text(value).appendTo($select);     
        });
        $('#selectDoors_<?php echo $uniqueSelector ?>').selectmenu('refresh', true);
       // console.log('doors '+temp[selectedVal][0]);
//        if(temp[selectedVal].length == 1 ){
//            
//            var myDDL = $('#selectDoors');
//                myDDL[0].selectedIndex = 0;
//           
//        }
   }
   
      function  updateBody(selectedVal, arr){
        var temp= arr;
        //alert(options);
        var $select = $('#selectBody_<?php echo $uniqueSelector ?>');                        
        $select.find('option').remove();                          
        $.each(temp[selectedVal], function(key, value) {              
            $('<option>').val(value).text(value).appendTo($select);     
        });
        $('#selectBody_<?php echo $uniqueSelector ?>').selectmenu('refresh', true);
//        if(temp[selectedVal].length == 1 ){
//            $('#selectBody').val(temp[selectedVal][0]);
//        }
   }
   
      function  updateTransmission(selectedVal, arr){
        var temp= arr;
        //alert(options);
        var $select = $('#selectTransmission_<?php echo $uniqueSelector ?>');                        
        $select.find('option').remove();                          
        $.each(temp[selectedVal], function(key, value) {              
            $('<option>').val(value).text(value).appendTo($select);     
        });
        $('#selectTransmission_<?php echo $uniqueSelector ?>').selectmenu('refresh', true);
//        if(temp[selectedVal].length ==1 ){
//            $('#selectTransmission').val(temp[selectedVal][0]);
//        }
   }
</script>