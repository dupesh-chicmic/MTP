<a href="<?php echo Yii::app()->createUrl('mobile/selectCars'); ?>" data-role="button" data-theme="b" data-corners="false">Switch to Used Cars</a>
<?php
    
    echo '<div data-role="collapsible-set" data-theme="b" data-content-theme="a" data-corners="false">
    <div data-role="collapsible">
    <h3 style="text-align:center;">Check by Make/Model</h3>';
    if(!empty($usedCommercialMark))
    {
        echo CHtml::dropDownList('cars_comm_mark_name', 'cars_comm_make_s', 
                CHtml::listData($usedCommercialMark,'id', 'name'),
                array(
                  'prompt'=>'Select Make',
                  'onchange'=>'document.getElementById("commercial_model_details").innerHTML = "";
                               document.getElementById("cars_comm_model-button").firstChild.innerHTML="Select Model";',
                  'ajax' => array(
                    'type'=>'POST', 
                    'url'=>Yii::app()->createUrl('mobile/loadCommercialRanges'),
                    'update'=>'#comms_ranges', 
                    'data'=>array('mark_id'=>'js:this.value','YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                    'cache'=>false,
                    'beforeSend' => "js:function(data)
                                    {
                                       document.getElementById('commercial_model_details').innerHTML = \"\";
                                    }",                      
                ))
            );
        
        
        echo CHtml::dropDownList('comms_ranges','', array(), 
                array(
                  'prompt'=>'Select Range',
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('mobile/loadCommercialModel'),
                  'update'=>'#cars_comm_model',
                  'cache'=>false,
                  'dataType'=>'html',
                  'data'=>array('range_id'=>'js:this.value',
                                'import_nazwa'=>$usedCommercialMark[0]['nazwa'],
                                'import_id'=>$usedCommercialMark[0]['id_import'],
                                'mark_id'=>'js:document.getElementById(\'cars_comm_mark_name\').value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                  'complete' => "js:function(data)
                                    {
                                    document.getElementById('commercial_model_details').innerHTML = \"\";
                                    }",
                ))
              );
        
        
         echo CHtml::dropDownList('cars_comm_model','', array(), 
                array(
                  'prompt'=>'Select Model',
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('mobile/loadCommercialModelDetails'),
                  'update'=>'#commercial_model_details',
                  'cache'=>false,
                  'dataType'=>'html',
                  'data'=>array('car_id'=>'js:this.value','import_nazwa'=>$usedCommercialMark[0]['nazwa'],
                                'import_id'=>$usedCommercialMark[0]['id_import'],
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
  //  echo 'Price not available while mobile site is under construction. Service will resume very shortly. Apologies for the inconvenience.';
    echo '<span class="accordionContent">Enter Registration</span>';
    echo $this->renderPartial('//registrationService/_checkPlateNumber', 
            array(//'model'=>$model,
                  'usedCarComModel'=>'UsedComCarsModel',
                  'importId'=>$usedCommercialMark[0]['id_import'],
                  'checkByRegLookUp'=>false
                )); 
    echo '</div>
        </div>';
?>