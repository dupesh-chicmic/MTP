<?php

$page = 'cars'; //Or can be 'commercial'

$availablePages = array('cars', 'commercial');

if(isset($_GET['page']) && !empty($_GET['page']) && in_array($_GET['page'], $availablePages) ) {
    $page = $_GET['page'];
}

$pathToFiles = './data/'.$page.'/';
$xmlStartFile = 'Alfa Romeo.xml'; // zaraz po wejsciu na strone new prices
$rangesxml = '/nCarsRanges.xml';
$carsPdf = 'newPricesCarsPdf';
$commcatdiv = '';

$startRangeCode = null;
$rangeName = '';   $make_name = "";

//
if($page == 'commercial'){ 
    $xmlStartFile = 'Citroen.xml'; 
    $rangesxml = '/nComsRanges.xml';
    $carsPdf = 'NewPricesCommsPdf';
    $commcatdiv = '<div id="" style="font-size: smaller; color:#f7d702; font-weight:bold;">For VRT Category B vehicles, the motor tax relates to vehicles used for commercial purposes.</div>';
}

 // zaraz po wejsciu na strone new prices

if (isset($_GET['rangecode'])) {
    $startRangeCode = $_GET['rangecode'];
}

if (isset($_GET['make'])) {
    $make_name = $xmlStartFile = $_GET['make'];
    $make_file = $pathToFiles . urldecode($make_name);    
} else {
    $make_file = $pathToFiles . $xmlStartFile;
    $make_name = $xmlStartFile;
}

if (!file_exists($make_file)) {
    echo 'File <b>' . $make_file . '</b> not exists.';
    die;
}
?>

<div id="dw-control-group"  data-role="controlgroup" data-type="horizontal">
        <a href="<?php echo Yii::app()->createUrl('mobile/newPrices').'&page=cars';?>" target="_self" onchange="stickyhead();" class="dw-radio-btn ui-btn ui-corner-all <?=($page == 'cars') ? 'ui-btn-active' : '' ?>" >Passenger</a>
        <a href="<?php echo Yii::app()->createUrl('mobile/newPrices').'&page=commercial';?>" target="_self" onchange="stickyhead();"
            class="dw-radio-btn ui-btn ui-corner-all <?=($page == 'commercial') ? 'ui-btn-active' : '' ?>">Commercial</a>  
</div>

<div class="subMenu">
    <ul>
    <?php
        $man_file = file_get_contents('./data/'.$page.'/man.xml');
        $man_file = htmlspecialchars($man_file);
        $cars = simplexml_load_string(html_entity_decode($man_file), 'SimpleXMLElement', LIBXML_NOCDATA);
        //RANGES:
        // code updated above needs to work below..
        $range_array = UsedCars::newCarsRanges('./data/'.$page.$rangesxml);  
        if(empty($startRangeCode)){
            $startRangeCode= array_values($range_array);
            $startRangeCode = $startRangeCode[0];
            $startRangeCode = array_values($startRangeCode);
            $startRangeCode = $startRangeCode[0];
        }        
      
        $effectiveFieldFromXml = '';
        $titleFieldFromXml = '';
        foreach ($cars->make as $row) {
            $class = "";
            if (urlencode($xmlStartFile) == urlencode($row['file'])) {
                $class = 'active ';
                $effectiveFieldFromXml = $row['effective'];
                $titleFieldFromXml = $row['distributor'];
            }
            //display name of manuafacturer
            $manufacturerName = str_replace(' ', '_', $row['distributor']);
            //echo '<li class="make_name '.$class.'"><a id="range-model-'.$manufacturerName.'" class="range-model '.$class.'" data-name="'.$manufacturerName.'" onclick="showRangeModels(\'range_model_list_'.$manufacturerName.'\');">' . $row['distributor'] . '</a></li>';

            echo '<li class="make_name '.$class.'"><a id="range-model-'.$manufacturerName.'" class="range-model '.$class.'" data-name="'.$manufacturerName.'">' . $row['distributor'] . '</a></li>';
            
            //display range names for manufacturer:
            if(!empty($class)){
                echo '<div name="rangeModels" id="range_model_list_'.$manufacturerName.'" class="range_model_list main-nav-item">';
            }else {
                echo '<div name="rangeModels" id="range_model_list_'.$manufacturerName.'" class="range_model_list sub-nav sub-nav-data-'.$manufacturerName.'" style="display:none;">';
            }
            
            if(!empty($manufacturerName)){
                $rangeClass = "";
                foreach($range_array[$manufacturerName] as $range_name=>$range_val){
                    
                    if($range_val == $startRangeCode){
                        $rangeClass = 'active ';
                        $rangeName = $range_name;
                    }else {
                        $rangeClass = '';
                    }
                    
                    echo '<li class="range_model_name '.$rangeClass.'""><a class="' . $rangeClass . '" href="index.php?r=mobile/newPrices&make=' . urlencode((String)$row['file']) . '&rangecode='.urlencode((string)$range_val).'&page='.$page.'">' . $range_name .'</a></li>';

                }
            }
            echo '</div>';
        }
        ?>
    </ul>
</div>

<div class="contentContainer" id="newPrices">
    <div class="carTable">
       
		<div class="modal_top" style="text-align:center;">
			 <div id="myDiv" style='float:right;'>
				<?php echo '<a target="_blank" href="' . Yii::app()->createUrl('//mobile/'.$carsPdf, array('make' => $make_name, 'rangecode' => $startRangeCode, 'rangename' => $rangeName)) . '&page='.$page.'"><img src="./images/pdf.png" style="width:28px; height:28px;" alt="[pdf]" /></a>'; ?>
			</div>
            <div id="titleFieldFromXml" style="color:#f7d702; font-weight:bold;"><?php echo $titleFieldFromXml; ?></div>
            <div id="effectiveFieldFromXml" style="color:#f7d702; font-weight:bold;">Effective <?php echo $effectiveFieldFromXml; ?></div>
            <div id="" style="font-size: smaller; color:#f7d702; font-weight:bold;">Please click on the variant to see the corresponding tax information.</div>

            <?php echo $commcatdiv; ?>
        </div>

        <?php
            if($page == 'car'){
                echo '<table class="items">
                <thead>
                <th width=280;>Model</th>
                <th width=10;>Doors</th>
                <th width=50;>Body</th>
                <th width=50;>Retail</th>
                <th width=100;>Engine</th>
                <th width=25;>Bhp</th>
                <th width=50;>Co2</th>
                </thead>';

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
                            <td><a style="color:#f7d702; font-weight: bolder;" href="javascript:showDetails(<?php echo $data; ?>)"><?php echo $reader->getAttribute('model');  ?></a></td>
                            <td class=""><?php echo $reader->getAttribute('doors'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('body'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('retail'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('engine'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('bhp'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('co2'); ?></td>
                        </tr>
                        <tr class="modelDetails" name="modelDetails" style="display:none;" id="showHideModelDetails_<?php echo $i.$_GET['rangecode']; ?>">
                            <td colspan="7">
                                <div id="modelDetails_<?php echo $i.$_GET['rangecode']; ?>"></div>
                            </td>
                        </tr>
                        <?php
                        $i++;
                    }
                    $reader->close();
                }
            }else{
                echo '<table class="items">
                <thead>
                <th width=280;>Model</th>
                <th width=100;>Body</th>
                <th width=50;>Retail</th>
                <th width=10;>GVWKg</th>
                <th width=50;>CC</th>
                <th width=25;>Cat</th>
                <th width=50;>Co2</th>  
                </thead>';

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
                            <td><a style="color:#f7d702; font-weight: bolder;" href="javascript:showDetails(<?php echo $data; ?>)"><?php echo $reader->getAttribute('model'); ?></a></td>
                            <td class=""><?php echo $reader->getAttribute('body'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('retail'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('gvw'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('cc'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('cat'); ?></td>
                            <td class=""><?php echo $reader->getAttribute('co2'); ?></td>
                        </tr>
                        <tr class="modelDetails" name="modelDetails" style="display:none;" id="showHideModelDetails_<?php echo $i.$_GET['rangecode']; ?>">
                            <td colspan="7">
                                <div id="modelDetails_<?php echo $i.$_GET['rangecode']; ?>"></div>
                            </td>
                        </tr>                
                        <?php
                        $i++;
                    }
                    $reader->close();
                }
            }
        ?>

        </table>

    </div>
</div>

<script>
    var rangedata = "<?php echo $_GET['rangecode']; ?>";

    $(document).ready(function(){
        $(document).on("click", ".range-model", function(){
            var getName = $(this).attr("data-name");       
            $(".range_model_list").hide();
            $(".sub-nav-data-"+getName).show();
        });
    });

    function showDetails(nr, vrt, band, tax, fuel, drive)
    {
        $(".modelDetails").hide();
        $("#showHideModelDetails_"+nr+rangedata).show();
        $("#modelDetails_"+nr+rangedata).html("<b>Drive:</b> " + drive + "<br />  <b>VRT%:</b> " + vrt + "<br /><b>Band:</b> " + band + "<br /><b>Motor Tax:</b> €" + tax + "<br /><b>Fuel:</b> " + fuel);
    }
</script>