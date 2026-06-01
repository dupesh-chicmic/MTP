<div class="car_pdf">

	<iframe src="<?php echo $link; ?>" width='100%' style='max-width: 100%; height:100%'></iframe>

</div>
<br/>
<!--div class="btn_back btn_centre  button-square">
  <button type=button onclick="goBack()" id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none"><span><img src="images/mobile/previous.svg" class="img-fluid"/></span></button>
</div-->

<script type="text/javascript">
function goBack(){
    window.location.href='<?php echo $backUrl;?>';
}
</script>