
<?php
/* 
 * Lewe menu w widokach Used Cars i Used Cars Commercial
 */

if(isset($type) && $type == 'cars')
{
    $type = 'usedCarsIFrame';
    $header = 'Car Sales Guide';
}
else
{
    //check usedCars view instead.
    $type = 'usedCommercialIFrame';
    //$header = 'Light Commercial & 4WD Guide';
    $header = '';
}
?>
<div class="subMenu hide-for-small-only"><!--<img src="images/logo3.png" />-->
    <div class="title"><?php echo $header; ?></div>
    <ul>
<?php
     $usedCarsRanges;
     $range;
    if(empty($usedCarsRanges)){
        foreach($allCarsModel as $item)
        {
            $class = (isset($make) && $make == $item['id']) ? 'class="active" ' : '';  
            echo '<li><a '.$class.' href="index.php?r=mobile/'.$type.'&make='.$item['id'].'">'.$item['name'].'</a></li>';            
        }
    }else {
        foreach ($allCarsModel as $row) {
        $class = "";
            if ($make == $row['id']) {
                $class = 'active ';
            }
            //display name of manuafacturer
            $manufacturerName = str_replace(' ', '_', $row['name']);
            if($manufacturerName=='UCarsLinks' || $manufacturerName=='UComsLinks') continue;

            // echo '<li class="make_name '.$class.'"><a class="'.$class.'" onclick="showRangeModels(\'range_model_list_'.$manufacturerName.'\');">' . $row['name'] . '</a></li>';

            echo '<li class="make_name '.$class.'"><a id="range-model-'.$manufacturerName.'" class="range-model '.$class.'" data-name="'.$manufacturerName.'">' . $row['name'] . '</a></li>';
            
            //display range names for manufacturer:
            
            if(!empty($class)){
                echo '<div name="rangeModels" id="range_model_list_'.$manufacturerName.'" class="range_model_list main-nav-item">';
            }else {
                echo '<div name="rangeModels" id="range_model_list_'.$manufacturerName.'" class="range_model_list sub-nav sub-nav-data-'.$manufacturerName.'" style="display:none;">';
            }
            
            if(!empty($manufacturerName)){
                $rangeClass = "";
                if($manufacturerName=='UCarsLinks' || $manufacturerName=='UComsLinks') continue;
                foreach($usedCarsRanges[$manufacturerName] as $range_name=>$range_val){
                
                    if($range_val == $range){
                        $rangeClass = 'active ';
                    }else {
                        $rangeClass = '';
                    }

                    echo '<li class="range_model_name '.$rangeClass.'"><a class="' . $rangeClass . '" href="index.php?r=mobile/'.$type.'&make=' . $row['id'] . '&rangecode=' .urlencode((string)$range_val). '">' . $range_name . '</a></li>';
                }
            }
            echo '</div>';
        }
    }
    
?>
    </ul>
</div>

