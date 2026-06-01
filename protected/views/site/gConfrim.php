<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
$backUrl = Yii::app()->createUrl('site/loginIFrame');
?>




    <div role="main" class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">
		
	<br/><br/>
Thank you for registering your interest in our app. <br/><br/>We will send you an email shortly with your login details.
    <br/><br/><br/><br/>
<!--<a href="<?php echo $backUrl;?>">-->
    

<br/>
 </div>
<br/>
 <div class="btn_back btn_centre button-square">
		  <button class="buttonBack" onclick="goBack()" id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
			<span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
		  </button>
		</div>
		
   <!-- <img class="buttonBack" onclick="goBack()" style="height: 100px; width: 100px;" id="carGo" 
     data-role="button" src="images/mobile/back.png" data-shadow="false" data-iconpos="notext" data-theme="none" /> -->

    <script type="text/javascript">
    function goBack(){
        window.location.href='<?php echo $backUrl;?>';
    }
    </script>
