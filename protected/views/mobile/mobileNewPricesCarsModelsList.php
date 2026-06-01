<?php
/*
 * Widok new prices mobile lista modeli dla danej marki
 * ajaxem wolane sa szczegoly po wybraniu modelu
 * paramerty przesylane jsonem (POST)
 */
?>
<ul data-role="listview">
    <a href="<?php echo Yii::app()->createUrl('mobile/showNewPricesCars'); ?>" data-role="button" data-theme="b" data-corners="false">Back to Car list</a>
</ul>
<?php
    echo '<script type="text/javascript">
    function hideOthers(carsLength) {
      for (i = 0; i < carsLength; i++) { 
       if ($("#tab_"+i).length>0) {
            document.getElementById(\'tab_\'+i).innerHTML="";
        }
      
      }
    }
    </script>';
    
    $vehicle = $carModels;
    $counter = count($vehicle);
    $rangeCounter = 0;
    for($i=0; $i < $counter; $i++)
    {
        if(!isset($vehicle[$i]['rangecode'])) {continue;}else {}
        if ($vehicle[$i]['rangecode'] == $rangecode){
            $rangeCounter++;
            echo '<div id="tab">';
            echo '<h3 id="carClick_'.$i.'" style="margin-left:10px;">'.$vehicle[$i]['model'].': '.$vehicle[$i]['doors'].'d '.$vehicle[$i]['body'].'</h3>';
       
?>
<div id="<?php echo "tab_".$i; ?>"></div>
<?php
        echo '</div>';
        }
    }
    
    echo '<script type="text/javascript">';
    for($i=0; $i < $counter; $i++) 
    {
        if(!isset($vehicle[$i]['rangecode'])) {continue;}else {}
        if ($vehicle[$i]['rangecode'] == $rangecode){
                        
        echo '$(\'#carClick_'.$i.'\').unbind(\'click\');
                var param'.$i.' = {model: "'.$vehicle[$i]['model'].'", doors: "'.$vehicle[$i]['doors'].'", body: "'.$vehicle[$i]['body'].'", retail: "'.$vehicle[$i]['retail'].'", engine: "'.$vehicle[$i]['engine'].'", bhp: "'.$vehicle[$i]['bhp'].'", vrt: "'.$vehicle[$i]['vrt'].'", band: "'.$vehicle[$i]['band'].'", co2: "'.$vehicle[$i]['co2'].'", fuel: "'.$vehicle[$i]['fuel'].'", tax: "'.$vehicle[$i]['tax'].'"};
                $(\'#carClick_'.$i.'\').click(function() {
                    hideOthers('.$counter.');
                    jQuery.ajax({\'url\':\'index.php?r=mobile/viewAjaxNewCars&car='.$file.'\',type: \'GET\',\'data\':param'.$i.',\'cache\':false,\'success\':function(html){jQuery("#tab_'.$i.'").html(html)}});
                    calculateHeightOnAjaxAddMore(230);
                });
             '; 
        }
    }
    echo '</script>';
?>

                    