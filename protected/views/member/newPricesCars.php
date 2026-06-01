<?php
$pathToFiles = './data/cars/';
$xmlStartFile = 'Alfa Romeo.xml'; // zaraz po wejsciu na strone new prices
$startRangeCode = null;
$rangeName = '';

if (isset($_GET['rangecode'])) {
    $startRangeCode = $_GET['rangecode'];
}

$make_name = "";
if (isset($_GET['make'])) {
    $make_file = $pathToFiles . urldecode($_GET['make']);
    $xmlStartFile = $_GET['make'];
    $make_name = $_GET['make'];
} else {
    $make_file = $pathToFiles . $xmlStartFile;
    $make_name = $xmlStartFile;
}
if (!file_exists($make_file)) {
    echo 'File <b>' . $make_file . '</b> not exists.';
    die;
}
?>
<div class="subMenu"><!--<img src="images/logo3.png" />-->
    <!-- <div class="title commercial_sub_menu">Light Commercial & 4WD Guide</div>-->
    <ul>
        <?php
        $man_file = file_get_contents('./data/cars/man.xml');
        //$cars = simplexml_load_string(html_entity_decode(htmlentities($cars_file)), 'SimpleXMLElement', LIBXML_NOCDATA); // nie dziala na test (live)
        $man_file = htmlspecialchars($man_file);
        $cars = simplexml_load_string(html_entity_decode($man_file), 'SimpleXMLElement', LIBXML_NOCDATA);
        
        //RANGES:
        $range_array = UsedCars::newCarsRanges('./data/cars/nCarsRanges.xml');  
        if(empty($startRangeCode)){
            $startRangeCode= array_values($range_array);
            $startRangeCode = $startRangeCode[0];
            $startRangeCode = array_values($startRangeCode);
            $startRangeCode = $startRangeCode[0];
        }        
      
        $effectiveFieldFromXml = '';
        $titleFieldFromXml = '';
        foreach ($cars->make as $row) {
           //var_dump($row);
          //  exit;
            $class = "";
            if (urlencode($xmlStartFile) == urlencode($row['file'])) {
                $class = 'active ';
                $effectiveFieldFromXml = $row['effective'];
                $titleFieldFromXml = $row['distributor'];
            }
            //display name of manuafacturer
           $manufacturerName = str_replace(' ', '_', $row['distributor']);
            echo '<li class="make_name '.$class.'"><a class="'.$class.'" onclick="showRangeModels(\'range_model_list_'.$manufacturerName.'\');">' . $row['distributor'] . '</a></li>';
            
            //display range names for manufacturer:
            
           // echo $manufacturerName.'--view';
            //exit;
            if(!empty($class)){
                echo '<div name="rangeModels" id="range_model_list_'.$manufacturerName.'" class="range_model_list">';
            }else {
                echo '<div name="rangeModels" id="range_model_list_'.$manufacturerName.'" class="range_model_list" style="display:none;">';
            }
            
            if(!empty($manufacturerName)){
                $rangeClass = "";
                foreach($range_array[$manufacturerName] as $range_name=>$range_val){
                   //echo $range_name.'--a--';
                  // var_dump($range_val);
                  // exit;
                    
                    if($range_val == $startRangeCode){
                        $rangeClass = 'active ';
                        $rangeName = $range_name;
                    }else {
                        $rangeClass = '';
                    }
                   
                   if (Yii::app()->controller->action->id == 'newPricesCarsIframe') {
                       echo '<li class="range_model_name '.$rangeClass.'"><a class="' . $rangeClass . '" href="index.php?r=member/newPricesCarsIframe&make=' . urlencode((String)$row['file']) . '&rangecode=' .urlencode((string)$range_val). '">' . $range_name . '</a></li>';
                   } else {
                       echo '<li class="range_model_name '.$rangeClass.'""><a class="' . $rangeClass . '" href="index.php?r=member/newPricesCars&make=' . urlencode((String)$row['file']) . '&rangecode=' .urlencode((string)$range_val). '">' . $range_name . '</a></li>';
                   }
                   
                }
            }
             echo '</div>';
        }
        ?>
    </ul>
</div>

<div class="contentContainer" id="newPrices">
    <div class="carTable" style="width:692px;">
        <div id="myDiv" style='float:right;'>
            <?php echo '<a href="' . Yii::app()->createUrl('/member/newPricesCarsPdf', array('make' => $make_name, 'rangecode' => $startRangeCode, 'rangename' => $rangeName)) . '"><img src="./images/pdf.png" style="width:28px; height:28px;" alt="[pdf]" /></a>'; ?>
        </div>
        <div style="text-align:center;">
            <div id="titleFieldFromXml" style="color:#2D8296; font-weight:bold;"><?php echo $titleFieldFromXml; ?></div>
            <div id="effectiveFieldFromXml" style="color:#2D8296; font-weight:bold;">Effective <?php echo $effectiveFieldFromXml; ?></div>
            <div id="" style="font-size: smaller; color:#2D8296; font-weight:bold;">Please click on Model description to expand vehicle data.</div>
        </div>

        <table class="items" width=750;>
            <thead>
            <th width=280;>Model</th>
            <th width=10;>Doors</th>
            <th width=50;>Body</th>
            <th width=50;>Retail</th>
            <th width=100;>Engine</th>
            <th width=25;>Bhp</th>
            <th width=50;>Co2</th>
            </thead>
            <?php
            $reader = new XMLReader();
            $file = $make_file;
            $rangecode = $startRangeCode;
            if (file_exists($file)) {
                if (!$reader->open($file)) {
                    die("Failed to open " . $file);
                }
                $i = 0;
                while ($reader->read()) {
                    if ($reader->getAttribute('model') == '')
                        continue;
                    
                    if ($reader->getAttribute('rangecode') != $rangecode)
                        continue;
                    
                    $data = $i . ',\'' . $reader->getAttribute('vrt') . '\',\'' . $reader->getAttribute('band') . '\',\'' . $reader->getAttribute('tax') . '\',\'' . $reader->getAttribute('fuel') . '\',\'' . $reader->getAttribute('drive') . '\'';
                    ?>
                    <tr>
                        <td><a style="color:#2d8296; font-weight: bolder;" href="javascript:showDetails(<?php echo $data; ?>)"><?php echo $reader->getAttribute('model');  ?></a></td>
                        <td class=""><?php echo $reader->getAttribute('doors'); ?></td>
                        <td class=""><?php echo $reader->getAttribute('body'); ?></td>
                        <td class=""><?php echo $reader->getAttribute('retail'); ?></td>
                        <td class=""><?php echo $reader->getAttribute('engine'); ?></td>
                        <td class=""><?php echo $reader->getAttribute('bhp'); ?></td>
                        <td class=""><?php echo $reader->getAttribute('co2'); ?></td>
                    </tr>
                    <tr name="modelDetails" style="display:none;" id="showHideModelDetails_<?php echo $i; ?>">
                        <td>
                            <div id="modelDetails_<?php echo $i; ?>"></div>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                $reader->close();
            }
            ?>

        </table>

    </div>
</div>

<?php
// stick table header
Yii::app()->clientScript->registerScript('carTable', '$(\'table.items\').floatThead();', CClientScript::POS_READY);
Yii::app()->clientScript->registerScript('newPrices', '
    function showDetails(nr, vrt, band, tax, fuel, drive)
    {
        var el = document.getElementsByName(\'modelDetails\');
        for(var i=0; i < el.length; i++)
        {
            el[i].style.display = "none";
        }
        document.getElementById(\'showHideModelDetails_\'+nr).style.display = "inline";
        document.getElementById(\'modelDetails_\'+nr).innerHTML="<b>Drive:</b> " + drive + "<br />  <b>VRT%:</b> " + vrt + "<br /><b>Band:</b> " + band + "<br /><b>Motor Tax:</b> €" + tax + "<br /><b>Fuel:</b> " + fuel;
    }
    
    function showRangeModels(selector)
    {
        
        var el = document.getElementsByName(\'rangeModels\');
        for(var i=0; i < el.length; i++)
        {
            el[i].style.display = "none";
        }
        //var idname = \'range_model_list_\'+selector;
        //console.log(idname);
        document.getElementById(selector).style.display = "inline";
        //document.getElementById(\'modelDetails_\'+nr).innerHTML="<b>VRT%:</b> " + vrt + "<br /><b>Band:</b> " + band + "<br /><b>Motor Tax:</b> €" + tax + "<br /><b>Fuel:</b> " + fuel;
    }
', CClientScript::POS_HEAD);
?>