<?php 
/*
 * Widok syboru samochodu z listy CARS
 */

$style = "";
echo CHtml::beginForm(Yii::app()->createUrl('mobile/gSelectMakeComms'), 'POST', array('id'=>'commsForm', 'style'=>$style,'autocomplete'=>'off' ));

?>
<div id="CommMakeModelForm">
<div id="dw-control-group"  data-role="controlgroup" data-type="horizontal">
  <a href="<?php echo Yii::app()->createUrl('mobile/gSelectMake');?>" class="dw-radio-btn ui-btn ui-corner-all ">Passenger</a>
  <a href="#" class="dw-radio-btn ui-btn ui-corner-all ui-btn-active dw-com">Commercial</a>  
</div>
<!--</div>-->
<p class="mobile-display"><img src="./images/rotate.png" alt="" class="rotate_icn"/>Please rotate your device to see all details.</p>
<div class="menu_group">
<?php
echo CHtml::hiddenField('vehicle_type', 'comm');
echo CHtml::hiddenField('import_id', $usedCarsMark[0]['id_import']);

$selectedYear = isset($_GET['com_year'])?$_GET['com_year']:''; 
$selectedcomms_mark_name = isset($_GET['comms_mark_name'])?$_GET['comms_mark_name']:'';
$selectedcars_ranges = isset($_GET['comms_ranges'])?$_GET['comms_ranges']:'';
$selectedcars_fuel = isset($_GET['comms_fuel'])?$_GET['comms_fuel']:'';
$selectedcars_transmission = isset($_GET['comms_transmission'])?$_GET['comms_transmission']:'';
$selectedcars_body = isset($_GET['comms_body'])?$_GET['comms_body']:'';
$selectedcars_model = isset($_GET['comms_model'])?$_GET['comms_model']:'';

$years = Mobile::getDisplayYears('Yrs2Display_ByMake.xml');

            echo CHtml::dropDownList('year', 'year', 
                $years,
                array(
                  'prompt'=>'Select Year',
                  'data-iconpos'=>"right",
                  'options' => array(  $selectedYear => array('selected'=>true)),
                  'ajax' => array(
                    'type'=>'POST', 
                    'url'=>Yii::app()->createUrl('mobile/loadCommercialMake'),
                    'update'=>'#comms_mark_name', 
                    'data'=>array(
                        // 'year'=>'js:this.value',
                        'year'=>'js:$( "#commsForm #year" ).val()',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken,
                        'vehicle_type'=>'js:document.getElementById(\'vehicle_type\').value'),
                    'cache'=>false,
                    'beforeSend' => "js:function(jqXHR, data)
                                    {
										if( jQuery( '#commsForm #year' ).hasClass( 'xhr-running' ) || !$( '.ui-page.ui-page-theme-a.ui-page-active' ).find( '.dw-radio-btn' ).hasClass( 'dw-com' ) ) { 
											jqXHR.abort();
										}
										jQuery( '#commsForm #year' ).addClass( 'xhr-running' );
										
										$( '.ui-mobile' ).removeClass( 'ui-loading' );
                                       unselect('#comms_mark_name'); unselect('#comms_ranges');unselect('#comms_model'); unselect('#comms_fuel'); unselect('#comms_transmission'); unselect('#comms_body'); unselect('#comms_doors'); unselect('#cars_badge');
                                       singleSelect('#comms_mark_name');
                                    }",
                  'complete' => "js:function(data)
                                    {
                                      jQuery( '#commsForm #year' ).removeClass( 'xhr-running' );
									  $( '.ui-mobile' ).removeClass( 'ui-loading' );
                                    }"
                    
                ))

            );
    if(!empty($usedCarsMark))
    {
        echo CHtml::dropDownList('comms_mark_name', 'comms_make_s', 
                CHtml::listData($usedCarsMark,'id', 'name'),
                array(
                  'prompt'=>'Select Make',
                  'data-iconpos'=>"right",
                  'options' => array(  $selectedcomms_mark_name => array('selected'=>true)),
                  'onchange'=>'document.getElementById("comms_model_details").innerHTML = "";
                               document.getElementById("comms_model-button").firstChild.innerHTML="Select Model";',
                  'ajax' => array(
                    'type'=>'POST', 
                    'url'=>Yii::app()->createUrl('mobile/loadCommercialRanges'),
                    'update'=>'#comms_ranges', 
                    'data'=>array(
                        'year'=>'js:$( "#commsForm #year" ).val()',
                        'mark_id'=>'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                    'cache'=>false,
                    'beforeSend' => "js:function(jqXHR, data)
                                    {
										if( jQuery( '#comms_mark_name' ).hasClass( 'xhr-running' ) ) { 
											jqXHR.abort();
										}
										jQuery( '#comms_mark_name' ).addClass( 'xhr-running' );
                        $( '.ui-mobile' ).removeClass( 'ui-loading' );
                         unselect('#comms_ranges');unselect('#comms_model'); unselect('#comms_fuel'); unselect('#comms_transmission'); unselect('#comms_body'); unselect('#comms_doors'); unselect('#cars_badge');
                         singleSelect('#comms_ranges');
                      }",
                  'complete' => "js:function(data)
                                  {
                                    jQuery( '#comms_mark_name' ).removeClass( 'xhr-running' );
                                    unselect('#comms_ranges');
                                  }"
                    
                ))
            );
        
        echo CHtml::dropDownList('comms_ranges','',$ranges, 
                array(
                  'prompt'=>'Select Range',
                  'data-iconpos'=>"right",
                  'options' => array(  $selectedcars_ranges => array('selected'=>true)),
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('mobile/loadFuel'),
                  'update'=>'#comms_fuel',
                  'cache'=>false,
                  'dataType'=>'html',
                  'data'=>array('page_model' => $page_model, 
                                'range_id'=>'js:this.value',
                                'year'=>'js:$( "#commsForm #year" ).val()',
                                'import_nazwa'=>$usedCarsMark[0]['nazwa'],
                                'import_id'=>$usedCarsMark[0]['id_import'],
                                'mark_id'=>'js:document.getElementById(\'comms_mark_name\').value',
                                'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                  'beforeSend' =>"js:function(jqXHR, data)
                  {
                    if( jQuery( '#comms_ranges' ).hasClass( 'xhr-running' ) ) { 
                      jqXHR.abort();
                    }
                    jQuery( '#comms_ranges' ).addClass( 'xhr-running' );
                      $( '.ui-mobile' ).addClass( 'ui-loading' );
                    }",
                  'complete' => "js:function(data)
                                    {
										jQuery( '#comms_ranges' ).removeClass( 'xhr-running' );
                                      $( '.ui-mobile' ).removeClass( 'ui-loading' );
                                      unselect('#comms_model'); unselect('#comms_fuel'); unselect('#comms_transmission'); unselect('#comms_body'); unselect('#comms_doors'); unselect('#cars_badge');
                                      singleSelect('#comms_fuel');
                                    }",
                ))
              );

         //Load fuel
         echo CHtml::dropDownList('comms_fuel','', $fuelOptiondata, 
                array(
                  'prompt'=>'Select Fuel',
                  'data-iconpos'=>"right",
                  'options' => array(  $selectedcars_fuel => array('selected'=>true)),
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('mobile/loadTransmission'),
                  'update'=>'#comms_transmission',
                  'cache'=>false,
                  'dataType'=>'html',
                  'data'=>array(
                        'page_model' => $page_model, 
                        'year'=>'js:$( "#commsForm #year" ).val()',
                        'range_id'=>'js:document.getElementById(\'comms_ranges\').value',
                        'import_nazwa'=>$usedCarsMark[0]['nazwa'],
                        'import_id'=>$usedCarsMark[0]['id_import'],
                        'mark_id'=>'js:document.getElementById(\'comms_mark_name\').value',
                        'fuel_type'=>'js:this.value',
                        'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                  'beforeSend' =>"js:function(jqXHR, data)
                  {
					if( jQuery( '#comms_fuel' ).hasClass( 'xhr-running' ) ) { 
						jqXHR.abort();
					}
					jQuery( '#comms_fuel' ).addClass( 'xhr-running' );
                    $( '.ui-mobile' ).addClass( 'ui-loading' );
                  }",
                  'complete' => "js:function(data)
                                {
									jQuery( '#comms_fuel' ).removeClass( 'xhr-running' );
                                  $( '.ui-mobile' ).removeClass( 'ui-loading' );
                                    unselect('#comms_transmission'); unselect('#comms_model'); unselect('#comms_body'); unselect('#comms_doors'); unselect('#cars_badge');
                                    singleSelect('#comms_transmission');
                                }",
                ))
              );
         
         //Load Transmission
         echo CHtml::dropDownList('comms_transmission','', $transdata, 
                array(
                  'prompt'=>'Select Transmission',
                  'data-iconpos'=>"right",
                  'options' => array(  $selectedcars_transmission => array('selected'=>true)),
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('mobile/loadBodyDoor'),
                  'update'=>'#comms_body',
                  'cache'=>false,
                  'dataType'=>'html',
                  'data'=>array(
                    'page_model' => $page_model, 
                    'range_id'=>'js:document.getElementById(\'comms_ranges\').value',
                    'year'=>'js:$( "#commsForm #year" ).val()',
                    'import_nazwa'=>$usedCarsMark[0]['nazwa'],
                    'import_id'=>$usedCarsMark[0]['id_import'],
                    'mark_id'=>'js:document.getElementById(\'comms_mark_name\').value',
                    'fuel_type'=>'js:document.getElementById(\'comms_fuel\').value',
                    'transmission'=>'js:this.value',
                    'type'=>"commercial",
                    'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                  ),
                  'beforeSend' =>"js:function(jqXHR, data)
                  {
					if( jQuery( '#comms_transmission' ).hasClass( 'xhr-running' ) ) { 
						jqXHR.abort();
					}
					jQuery( '#comms_transmission' ).addClass( 'xhr-running' );
                    $( '.ui-mobile' ).addClass( 'ui-loading' );
                  }",
                  'complete' => "js:function(data)
                                    {
										jQuery( '#comms_transmission' ).removeClass( 'xhr-running' );
                                      $( '.ui-mobile' ).removeClass( 'ui-loading' );
                                        unselect('#comms_model'); unselect('#comms_body'); unselect('#cars_badge');
                                        singleSelect('#comms_body');
                                    }",
                                    
                ))
              );
         
         //loadCarsModel
         echo CHtml::dropDownList('comms_body','', $BodyDoorsWithoutdata, 
                array(
                  'prompt'=>'Select Body',
                  'data-iconpos'=>"right",
                  'options' => array(  $selectedcars_body => array('selected'=>true)),
                  'ajax' => array(
                  'type'=>'POST', 
                  'url'=>Yii::app()->createUrl('mobile/loadModelType'),
                  'update'=>'#comms_model',
                  'cache'=>false,
                  'dataType'=>'html',
                  'data'=>array(
                      'type'=>"commercial",
                      'page_model' => $page_model,
                      'range_id'=>'js:document.getElementById(\'comms_ranges\').value',
                      'year'=>'js:$( "#commsForm #year" ).val()',
                      'import_nazwa'=>$usedCarsMark[0]['nazwa'],
                      'import_id'=>$usedCarsMark[0]['id_import'],
                      'mark_id'=>'js:document.getElementById(\'comms_mark_name\').value',
                      'fuel_type'=>'js:document.getElementById(\'comms_fuel\').value',
                      'transmission'=>'js:document.getElementById(\'comms_transmission\').value',
                      'model_txt'=>'js:this.value',
                      'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
                    ),
                  'beforeSend' =>"js:function(jqXHR, data)
                  {
          if( jQuery( '#comms_body' ).hasClass( 'xhr-running' ) ) { 
            jqXHR.abort();
          }
          jQuery( '#comms_body' ).addClass( 'xhr-running' );
                    $( '.ui-mobile' ).addClass( 'ui-loading' );
                  }",
                  'complete' => "js:function(data)
                      {
            jQuery( '#comms_body' ).removeClass( 'xhr-running' );
                        $( '.ui-mobile' ).removeClass( 'ui-loading' );
                          unselect('#comms_model');
                          singleSelect('#comms_model');
                      }",
                )
                )
              );
         
         echo CHtml::dropDownList('comms_model','', $modelTypedata, 
                array(
                  'prompt'=>'Select Model with Type',
                  'data-iconpos'=>"right",
                  'options' => array(  $selectedcars_model => array('selected'=>true)),
                  )
              );
         
    }
 echo CHtml::textField('userKms', '', array('placeholder'=>'Enter Kms (if known)', 'id'=>'user_kms', 'class'=>"reg_field", 'maxlength'=>12));
 echo '<br/>';
 //echo CHtml::submitButton('GO',array('class'=>'button1'));
 ?>
</div>

	<div class="btn_go btn_centre button-circle">
       <button type="button" class="buttonGo ui-btn ui-btn-none ui-corner-all" onclick="submitCommsForm()" id="carGo" data-role="button" data-shadow="false" src="images/mobile/go.png" data-iconpos="notext" data-theme="none">Go</button>
    </div>
	
	<!-- <div class="btn_go btn_centre button-circle">
   <input type="button" onclick="submitForm()" id="carGo" data-role="button" data-shadow="false" src="images/mobile/go.png" data-iconpos="notext" data-theme="none" value="Go">
	</div>	 -->
<?php
echo CHtml::endForm();    
echo '</div>
</div>';     
?>
</div>
<div id="resultCommMakeModel">
  <!-- result get displayed here -->
</div>
<script type="text/javascript">
$('.pdficonss').hide();
    function submitCommsForm(){
      if(validate()){
        // $('#commsForm').submit(); 
        // new ajax for submission starts here
          $.ajax({
              url: "<?php echo Yii::app()->createUrl('mobile/gSelectMakeComms'); ?>",
              type: 'post',
              data: $('#commsForm').serialize(),
              beforeSend: function(){
                $( '.ui-mobile' ).addClass( 'ui-loading' );
              },
              success: function(data) {
                $("#resultCommMakeModel").html(data);
              },
              complete: function(event,xhr,options){
                $( '.ui-mobile' ).removeClass( 'ui-loading' );
                //code to focus on the div
                  if( $(window).width() <= 767 ){
                    $('#resultCommMakeModel').show();
                    $('#CommMakeModelForm').hide();
                  }else{
                    $('#resultCommMakeModel').show();
                    $('#CommMakeModelForm').show()
                  }
                //code to focus on the div
                var codeNumber 		= '';
                var postData 		= '';
                var codeNumber 			= $(event.responseText).wrap('<div />').parent().find('input#codenumber').val()?$(event.responseText).wrap('<div />').parent().find('input#codenumber').val():'';
                var postData 	= $(event.responseText).wrap('<div />').parent().find('input#displayData').val()?$(event.responseText).wrap('<div />').parent().find('input#displayData').val():'';
                var baseUrl = "<?php echo Yii::app()->createUrl('/mobile/makeModelGeneratePdf',array('m'=>'UsedCarsModel','imp'=>$usedCarsMark[0]['id_import'])); ?>";
                // console.log(codeNumber);
                if(codeNumber && codeNumber !='' 
                && postData && postData !='' ){
                  $('.pdficonss').show();
                  // console.log($('.pdflink a').attr('data-baseurl'));
                  // $('.pdflink a').attr('href',$('.pdflink a').attr('href')+'&cn='+codeNumber+'&postData='+postData);
                  $('.pdflinkss a').attr('href', baseUrl+'&cn='+codeNumber+'&pd='+postData+'&type=comm');
                }else{
                  $('.pdficonss').hide(); // 142D1635
                }
              }
          })
          //ends here  
      }else {
        alert('Please select all the fields.');
        return false;
      } 
    }

    function validate(){
      if($('#commsForm #comms_body').val()=='') return false;
      if($('#commsForm #comms_transmission').val()=='') return false;
      if($('#commsForm #comms_fuel').val()=='') return false;
      if($('#commsForm #comms_model').val()=='') return false;
      if($('#commsForm #comms_ranges').val()=='') return false;
      if($('#commsForm #comms_mark_name').val()=='') return false;
      if($('#commsForm #year').val()=='') return false;
      return true;
    }

    function singleSelect(child){
        
        size = $(child+' option').size();
        val = $(child+' option').eq(1).val();
        //alert(child+size+' - '+val);
        if(size === 2){
            $(child).val($(child+' option').eq(1).val());
            $(child).selectmenu("refresh");
            $(child).trigger("change");
        }
    }

    function unselect(child){
        //alert(child);
        $(child+" option:selected").removeAttr("selected");
        $(child).selectmenu("refresh");
    }
    
    $("input[type='radio']").bind( "change", function(event, ui) {
          $.ajax({
            url: "<?php echo Yii::app()->createUrl('mobile/loadMake');?>",
            type:'POST',
            cache:false,
            update: "#comms_mark_name",
            dataType:'html',
            data: {'vehicle_type':this.value},
            complete : function(data){
              //console.log(data.response);
             $('#comms_mark_name').html('<option>make</option>');   
             $("option:selected").removeAttr("selected");
             //$('#comms_mark_name').html('<option>ala</option>');   
           }       
            
        });
    });

    function goCommsUp(){
      $('#resultCommMakeModel').hide();
      $('#CommMakeModelForm').show();
      // document.body.scrollTop = 0; // For Safari
      // document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }

    
	// setTimeout(function () {
	// 	var size = $("#comms_mark_name"+' option').size();
	// 	var comval = $("#comms_mark_name").val();
  //   if( comval !='' ){  
  //     $("#comms_mark_name").trigger("change");
  //     setTimeout(function () {
  //       $('#comms_ranges').val("<?php echo $selectedcars_ranges; ?>");
  //       $("#comms_ranges").trigger("change");
  //       setTimeout(function () {
  //         $('#comms_fuel').val("<?php echo $selectedcars_fuel; ?>")
  //         $("#comms_fuel").trigger("change");
  //         setTimeout(function () {
  //           $('#comms_transmission').val("<?php echo $selectedcars_transmission; ?>")
  //           $("#comms_transmission").trigger("change");
  //           setTimeout(function () {
  //             $('#comms_body').val("<?php echo $selectedcars_body; ?>")
  //             $("#comms_body").trigger("change");
  //             setTimeout(function () {
  //               $('#comms_model').val("<?php echo $selectedcars_model; ?>");
  //               // $('#cars_model').val($('#cars_model'+' option').eq(2).val());
  //               // alert('<?php echo $selectedcars_model; ?>');
  //               $("#comms_model").trigger("change");
  //             },2000);
  //           },1000);
  //         },1000);
  //       },1000);
  //     },1000);

  //     comval = '';
  //   }
	// }, 3000);

</script>


<div id="comms_model_details"></div>


