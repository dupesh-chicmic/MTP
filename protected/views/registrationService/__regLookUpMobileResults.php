<?php 
    if (!empty($cars)) { ?>
    <div>Results:</div><br>
    <?php    
        foreach($cars as $car) { ?>
        <div>Type: <?php echo $car['badgetype']; ?></div>
        <div>Doors: <?php echo $car['drs']; ?></div> 
        <div>Body: <?php echo $car['bod']; ?></div>
        <div>Transmission: <?php echo $car['transmission']; ?></div><br>
        <?php }
    }
    
    else { ?>
        <div class="paddingBottom10" >Nothing to display</div>
    <?php }?>