




    <div role="main" class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">
		
	<br/>
        <?php echo '<div class="emphasize4" style="text-align:center;">'.strtoupper($_POST['VehicleRegNumber']).'</div>';?>
        
<?php 

//$msg = '<div class="emphasize2">We cannot find a match to that registration plate at this time. <br><br>Please search By <a href="'.Yii::app()->createUrl('mobile/gSelectMake').'">Make/Model</a> or contact us at <a href="mailto:info@mtp.ie">info@mtp.ie</a> and our research team will assist you.</div>';
//$msg = '<br><div class="results emphasize2">Reg Lookup facility is undergoing an upgrade. <br>Please use <a href="'.Yii::app()->createUrl('mobile/gSelectMake').'">By Make/Model</a> during this time </div>';
$msg = '<br><div class="results emphasize2">This vehicle doesn’t have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';
$backUrl = Yii::app()->createUrl('mobile/gSelectReg');
echo $msg; ?>
    <br/>
<!--<a href="<?php echo $backUrl;?>">-->
    

<br/>
 </div>
<br/>
<div class="btn_go btn_centre button-square">
  <button type=button onclick="goBack()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none"><span><img src="images/mobile/previous.svg" class="img-fluid"/></span></button>
</div>
    <!-- <img class="buttonBack" onclick="goBack()" style="height: 100px; width: 100px;" id="carGo" 
     data-role="button" src="images/mobile/back.png" data-shadow="false" data-iconpos="notext" data-theme="none" /> -->

    <script type="text/javascript">
    function goBack(){
        window.location.href='<?php echo $backUrl;?>';
    }
    </script>
