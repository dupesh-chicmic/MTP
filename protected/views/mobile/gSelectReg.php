<?php 
/*
 * Widok wyboru samochodu z listy CARS
 */
$importId = (isset($usedCarsMark[0]['id_import']) && $usedCarsMark[0]['id_import']) ? $usedCarsMark[0]['id_import'] : null;
    echo '<div class="emphasize2" style="text-align:center;">SEARCH BY <a href="'.Yii::app()->createUrl('mobile/gSelectMake').'">MAKE/MODEL</a></div>';
    echo '<div class="emphasize2" style="text-align:center;">OR</a></div>';
    
    echo $this->renderPartial('//registrationService/_checkPlateNumber', 
            array(//'model'=>$model,
                  'usedCarComModel'=>'UsedCarsModel',
                  'importId'=>$importId,
                  'checkByRegLookUp'=>false,
                  'options'=>$options
                )); 
    echo '<div id="regResult"></div>';
    echo '</div>';
?>
	<div id="cars_model_details"></div>
	<script>
		addToHomescreen();
	</script>
<script type="text/javascript">
$('.pdficon').hide();
<?php if(Yii::app()->params['website_type']==Yii::app()->params['website']['MOBILE']){ ?>
    function submitFormReg(){
         if($('#check_ri_field').val()==''){
            alert('Please fill in the registration field.');
            return false;
        }else {
          // $('#regFormMobile').submit();
          //new ajax for submission starts here
          $.ajax({
            url: "<?php echo Yii::app()->createUrl('registrationService/gCheckPlateNumberByRegLookUpMobile'); ?>",
            type: 'post',
            data: $('#regFormMobile').serialize(),
            beforeSend: function(){
              $( '.ui-mobile' ).addClass( 'ui-loading' );              
            },
            success: function(data) {
				$("#regResult").html(data);
            },
            complete: function(event,xhr,options){
				var codeNumber = '';
				var VehicleRegNumber = '';
        var gPrice = '';
        var gkms = '';
        var gdate = '';
				codeNumber = $(event.responseText).wrap('<div />').parent().find('input#VehicleRegNumber').val()?$(event.responseText).wrap('<div />').parent().find('input#VehicleRegNumber').val():'';
				VehicleRegNumber = $(event.responseText).wrap('<div />').parent().find('input#codenumber').val()?$(event.responseText).wrap('<div />').parent().find('input#codenumber').val():'';

        var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9\+\/\=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/\r\n/g,"\n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}

        gPrice = $(event.responseText).wrap('<div />').parent().find('input#gprice').val()?$(event.responseText).wrap('<div />').parent().find('input#gprice').val():'';
				
        gkms = $(event.responseText).wrap('<div />').parent().find('input#gkms').val()?$(event.responseText).wrap('<div />').parent().find('input#gkms').val():'';

        gdate = $(event.responseText).wrap('<div />').parent().find('input#gdate').val()?$(event.responseText).wrap('<div />').parent().find('input#gdate').val():'';
				if(gdate){
          gdate = Base64.encode(gdate);
        }

        if(gkms){
          gkms = Base64.encode(gkms);
        }
        if(gPrice){
          gPrice = Base64.encode(gPrice);
        }


        $( '.ui-mobile' ).removeClass( 'ui-loading' );
        //code to focus on the div
        if( $(window).width() <= 767 ){
            $('#regResult').show();
            $('#regFormMobile').hide();
        }else{
          $('#regResult').show();
          $('#regFormMobile').show();
        }
			  var baseUrl = "<?php echo Yii::app()->createUrl('/mobile/generatePdf',array('m'=>'UsedCarsModel','imp'=>$usedCarsMark[0]['id_import'])); ?>";
			  if(VehicleRegNumber && codeNumber 
				&& VehicleRegNumber !='' && codeNumber !=''){
				  $('.pdficon').show();
				  $('.pdflink a').attr('href',baseUrl+'&cn='+codeNumber+'&reg='+VehicleRegNumber+'&gPrice='+gPrice+'&gkms='+gkms+'&gdate='+gdate);
			  }else{
				  $('.pdficon').hide(); // 142D1635
			  }
              //code to focus on the div
            }
          })
          //ends here
        }
    }


<?php } ?>
    function setRegNumber()
    {
        var lvRegNr = $("#check_ri_field").val();        
        document.getElementById("colorBoxLinkRegNumber").href="<?php echo Yii::app()->createUrl('registrationService/checkPlateNumberByRegLookUpMobile',array('usedCarComModel'=>'usedCarComModel', 'useAjax'=>1, 'importId'=>$importId, 'VehicleRegNumber'=>"")); ?>"+lvRegNr;
    }

    $('.reg_field').click(function(){
        $(".WrapperPadding").remove();
    });
    
    function goUp(){
      $('#regResult').hide();
      $('#regFormMobile').show();
      // document.body.scrollTop = 0; // For Safari
      // document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
	// on click focus
</script>