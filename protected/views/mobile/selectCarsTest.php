<?php
/*
 * Widok syboru samochodu z listy CARS
 */
?>

<?php
echo $this->renderPartial('//mobile/_usedCarsMobileMenuTest', 
            array(//'model'=>$model,
                  'usedCarsMark'=>$usedCarsMark,                  
                )); 



    ?>
<div id="cars_model_details"></div>

<?php
    Yii::app()->clientScript->registerScript('accordionContent','
    function resetSelects() {
      document.getElementById("cars_model_details").innerHTML = "";
      document.getElementById("cars_model-button").firstChild.innerHTML="Select Model";
    }',CClientScript::POS_HEAD);
?>