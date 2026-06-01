<?php
/*
 * Widok new prices mobile lista modeli dla danej marki
 * ajaxem wolane sa szczegoly po wybraniu modelu
 * paramerty przesylane jsonem (POST)
 */
?>
<ul data-role="listview">
    <a href="<?php echo Yii::app()->createUrl('mobile/showNewPricesComm'); ?>" data-role="button" data-theme="b" data-corners="false">Back to Commercial & 4WD List</a>
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
        
        echo '<h3 id="carClick_'.$i.'" style="margin-left:10px;">'.$vehicle[$i]['model'].': '.$vehicle[$i]['doors'].''.$vehicle[$i]['body'].'</h3>';
        
        //echo '<h3 onclick="hideOthers('.$counter.');" id="carClick_'.$i.'" style="margin-left:10px;">'.$vehicle[$i]['model'].': '.$vehicle[$i]['body'].'</h3>';
        
        
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
                var param'.$i.' = {model: "'.$vehicle[$i]['model'].'", body: "'.$vehicle[$i]['body'].'", retail: "'.$vehicle[$i]['retail'].'", gvw: "'.$vehicle[$i]['gvw'].'", cat: "'.$vehicle[$i]['cat'].'", cc: "'.$vehicle[$i]['cc'].'", vrt: "'.$vehicle[$i]['vrt'].'", band: "'.$vehicle[$i]['band'].'", co2: "'.$vehicle[$i]['co2'].'", fuel: "'.$vehicle[$i]['fuel'].'", tax: "'.$vehicle[$i]['tax'].'"};
                $(\'#carClick_'.$i.'\').click(function() {
                    hideOthers('.$counter.');
                    jQuery.ajax({\'url\':\'index.php?r=mobile/viewAjaxNewComm&car='.$file.'\',type: \'GET\',\'data\':param'.$i.',\'cache\':false,\'success\':function(html){jQuery("#tab_'.$i.'").html(html)}});
                        calculateHeightOnAjaxAddMore(230);  
                        
                });
             '; 
        }
    }
    echo '</script>';
?>

