<?php
$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
$backUrl = Yii::app()->createUrl('site/loginIFrame');
?>




    <div role="main" class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">
		
	<br/><br/>
        This web app is available only on mobile devices. <br/><br/>For desktop please use the <a href="http://mtp.ie/">mtp.ie</a> system.    <br/><br/><br/><br/>
<!--<a href="<?php echo $backUrl;?>">-->
    

<br/><br/><br/>
 </div>
<br/>
   <!-- <img class="buttonBack" onclick="goBack()" style="height: 100px; width: 100px;" id="carGo" 
     data-role="button" src="images/mobile/back.png" data-shadow="false" data-iconpos="notext" data-theme="none" />
-->
    <script type="text/javascript">
    function goBack(){
        window.location.href='<?php echo $backUrl;?>';
    }
    </script>
