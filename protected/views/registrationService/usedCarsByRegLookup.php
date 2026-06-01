<div class="contentContainer" style="width: 100%;">
    <?php if (isset($hideHeader) && $hideHeader==false): ?>
    <div id="carInfo"><h1 style="text-align: right; padding: 20px 0 0 0;">Enter Irish Registration</h1></div>
    <?php endif; ?>
<?php    
    echo $this->renderPartial('_checkPlateNumberByRegLookUp', 
            array('usedCarComModel'=>'UsedCarsModel','useAjax'=>true));
    
    if(isset($main_coreWithAssociatedCarsModel) &&
       isset($rest_coreWithAssociatedCarsModel)
      ){
        echo '<div id="carInfo">';
            $this->renderPartial('_basicDetailsInformation',
                    array('vehicle' => $vehicle,
                          'model' => $model,
                          'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                          'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                          'calculatedMain_coreWithAssociatedCars' => array(),
                          'calculatedRest_coreWithAssociatedCars' => array(),
                          'type'=> $type
                    ));
        echo '</div>';
    }
?>
</div>

