<?php
/*
 * Widok syboru samochodu z listy COMMERCIAL
 */
?>
<?php
echo $this->renderPartial('//mobile/_usedCommsMobileMenu', 
            array(//'model'=>$model,
                  'usedCommercialMark'=>$usedCommercialMark,                  
                )); 
?>
<div id="commercial_model_details"></div>

<?php
    Yii::app()->clientScript->registerScript('accordionContent','
    function resetSelects() {
      document.getElementById("commercial_model_details").innerHTML = "";
      document.getElementById("cars_comm_model-button").firstChild.innerHTML="Select Model";
    }',CClientScript::POS_HEAD);   
?>