<a href="<?php echo Yii::app()->createUrl('mobile/selectCommercials'); ?>" data-role="button" data-theme="b" data-corners="false">Switch to Commercials & 4WDs</a>
<?php

echo '<div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
    <div data-role="collapsible">
    <h3 style="text-align:center;">Check by Make/Model</h3>';
    if(!empty($usedCarsMark))
    {
        echo CHtml::dropDownList('cars_mark_name', 'cars_make_s', 
                CHtml::listData($usedCarsMark,'id', 'name'),
                array(
                  'prompt'=>'Select Make',
                  'onchange'=>'document.getElementById("cars_model_details").innerHTML = "";
                               document.getElementById("cars_model-button").firstChild.innerHTML="Select Model";',
                  'ajax' => array(
                    'type'=>'POST', 
                    'url'=>Yii::app()->createUrl('mobile/loadCarsRanges'),
                    'update'=>'#cars_ranges', 
                    'data'=>array('mark_id'=>'js:this.value','YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                    'cache'=>false,
                    'beforeSend' => "js:function(data)
                                    {
                                       document.getElementById('cars_model_details').innerHTML = \"\";
                                    }",
                    
                ))
            );
        
        echo CHtml::dropDownList('cars_ranges','', array(), 
                array(
                  'prompt'=>'Select Range',
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('mobile/loadCarsModel'),
                  'update'=>'#cars_model',
                  'cache'=>false,
                  'dataType'=>'html',
                  'data'=>array('range_id'=>'js:this.value',
                                'import_nazwa'=>$usedCarsMark[0]['nazwa'],
                                'import_id'=>$usedCarsMark[0]['id_import'],
                                'mark_id'=>'js:document.getElementById(\'cars_mark_name\').value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                  'complete' => "js:function(data)
                                    {
                                    document.getElementById('cars_model_details').innerHTML = \"\";
                                    }",
                ))
              );
        
        //loadCarsModel

         echo CHtml::dropDownList('cars_model','', array(), 
                array(
                  'prompt'=>'Select Model',
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('mobile/loadCarsModelDetails'),
                  'update'=>'#cars_model_details',
                  'cache'=>false,
                  'dataType'=>'html',
                  'data'=>array('car_id'=>'js:this.value','import_nazwa'=>$usedCarsMark[0]['nazwa'],
                                'import_id'=>$usedCarsMark[0]['id_import'],
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                  'complete' => "js:function(data)
                                    {
                                    window.parent.sendHeight();
                                    }",
                ))
              );
    }

    echo '</div>
</div>';
    
    
    
    //
    echo '<div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
    <div data-role="collapsible">
    <h3 style="text-align:center;">Check by Registration No.</h3>';
//    echo 'Price not available while mobile site is under construction. Service will resume very shortly. Apologies for the inconvenience.';
    echo '<span class="accordionContent">Enter Registration</span>';
    echo $this->renderPartial('//registrationService/_checkPlateNumber', 
            array(//'model'=>$model,
                  'usedCarComModel'=>'UsedCarsModel',
                  'importId'=>$usedCarsMark[0]['id_import'],
                  'checkByRegLookUp'=>false
                )); 
    echo '</div>
</div>';
    ?>