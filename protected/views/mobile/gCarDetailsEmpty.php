<?php 
echo '<div class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">';
echo '<div class="emphasize4">Your Vehicle</div>';

?>
<div class="emphasize2">
    <br><div class="results emphasize2"><span class='emphasize2'>We cannot find a match to your selection at this time. Please contact us at <a href="mailto:info@mtp.ie">info@mtp.ie</a> and our research team will assist you. </span></div>
</div>


</div>
 <div class="btn_back btn_centre button-square">
		  <button class="buttonBack" onclick="goBack()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
			<span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
		  </button>
</div>		

<script type="text/javascript">
    function goBack(){
        parent.history.back();
      
    }
</script>
<style>
    .buttonBack, .buttonGo { cursor: pointer; left: unset; margin: 0; }
    .footer_right { margin: 0; float: none; left: unset; padding: 0; text-align: center; color: #ffd800; }
    /*@media (max-width:479px){
        .res_desc { float: left; margin-right: 6px; width: 100%; text-align: center; }
        .res_res { float: left; width: 100%; text-align: center; }
        .res_res>span { float: none; }
        .buttonBack, .buttonGo { cursor: pointer; float: none; left: unset; margin: 0; }
        .btn_centre { text-align: center; margin: 10px; width: 100%; clear: both; float: left; }
    }*/
</style>