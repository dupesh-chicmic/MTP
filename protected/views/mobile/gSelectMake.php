<div id="search_make_model_form">
<div id="dw-control-group"  data-role="controlgroup" data-type="horizontal">
	<a href="#" class="dw-radio-btn ui-btn ui-corner-all ui-btn-active dw-cars" >Passenger</a>
	<a href="<?php echo Yii::app()->createUrl('mobile/gSelectMakeComm');?>" class="dw-radio-btn ui-btn ui-corner-all">Commercial</a>
</div>
<p class="mobile-display"><img src="./images/rotate.png" alt="" class="rotate_icn"/>Please rotate your device to see all details.</p>
<div class="menu_group">
<?php
	$style = "";
	echo CHtml::beginForm(Yii::app()->createUrl('mobile/gCarDetails'), 'POST', array('id'=>'carsForm', 'style'=>$style,'autocomplete'=>'off' ));
    echo CHtml::hiddenField('vehicle_type', 'cars');
    echo CHtml::hiddenField('import_id', $usedCarsMark[0]['id_import']);

    $years = Mobile::getDisplayYears('Yrs2Display_ByMake.xml'); 
	$selectedYear = isset($_GET['year'])?$_GET['year']:'';
	$selectedcars_ranges = isset($_GET['cars_ranges'])?$_GET['cars_ranges']:'';
	$selectedcars_fuel = isset($_GET['cars_fuel'])?$_GET['cars_fuel']:'';
	$selectedcars_transmission = isset($_GET['cars_transmission'])?$_GET['cars_transmission']:'';
	$selectedcars_body = isset($_GET['cars_body'])?$_GET['cars_body']:'';
	$selectedcars_model = isset($_GET['cars_model'])?$_GET['cars_model']:'';

	echo CHtml::dropDownList('year', 'year', 
		$years,
		array(
			'prompt'=>'Select Year',
			'data-iconpos'=>"right",
			'options' => array(  $selectedYear => array('selected'=>true)),
			'ajax' => array(
				'type'=>'POST', 
				'url'=>Yii::app()->createUrl('mobile/loadMake'),
				'update'=>'#cars_mark_name', 
				'data'=>array(
						// 'year'=>'js:this.value',
						'year'=>'js:$( "#carsForm #year" ).val()',
						'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken,
						'vehicle_type'=>'js:document.getElementById(\'vehicle_type\').value'
					),
				'cache'=>false,
				'beforeSend' => "js:function(jqXHR, data){
					if( $( '#carsForm #year' ).hasClass( 'xhr-running' ) || !$( '.ui-page.ui-page-theme-a.ui-page-active' ).find( '.dw-radio-btn' ).hasClass( 'dw-cars' ) ) { 
						jqXHR.abort();
					}
					$( '#carsForm #year' ).addClass( 'xhr-running' );
					$( '.ui-mobile' ).addClass( 'ui-loading' );
				}", 
				'complete' =>  "js:function(data)
				{
					$( '#carsForm #year' ).removeClass( 'xhr-running' );
					$( '.ui-mobile' ).removeClass( 'ui-loading' );
					unselect('#cars_mark_name'); unselect('#cars_ranges'); unselect('#cars_model'); unselect('#cars_fuel'); unselect('#cars_transmission'); unselect('#cars_body'); unselect('#cars_doors'); unselect('#cars_badge');                                     
					singleSelect('#cars_mark_name');
				}",																				
		    )
      	)
    );

	if(!empty($usedCarsMark))
	{
		$selectedCarMake = isset($_GET['cars_mark_name'])?$_GET['cars_mark_name']:'';
		echo CHtml::dropDownList('cars_mark_name', 'cars_make_s', 
			CHtml::listData($usedCarsMark,'id', 'name'),
			array(
				'prompt'=>'Select Make',
				'data-iconpos'=>"right",
				'options' => array(  $selectedCarMake => array('selected'=>true)),
				'ajax' => array(
						'type'=>'POST', 
						'url'=>Yii::app()->createUrl('mobile/loadCarsRanges'),
						'update'=>'#cars_ranges', 
						'data'=>array('mark_id'=>'js:this.value',
						'year'=>'js:$( "#carsForm #year" ).val()',
						'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
						'cache'=>false,
					'beforeSend' => "js:function(jqXHR, data){
						if( $( '#cars_mark_name' ).hasClass( 'xhr-running' ) ) { 
							jqXHR.abort();
						}
						$( '#cars_mark_name' ).addClass( 'xhr-running' );
						$( '.ui-mobile' ).addClass( 'ui-loading' );
					}",
					'complete' =>  "js:function(data) {
						$( '#cars_mark_name' ).removeClass( 'xhr-running' );
						$( '.ui-mobile' ).removeClass( 'ui-loading' );
						unselect('#cars_ranges');unselect('#cars_model');unselect('#cars_fuel'); unselect('#cars_transmission'); unselect('#cars_body'); unselect('#cars_doors'); unselect('#cars_badge');
						singleSelect('#cars_ranges');
					}",
			  	)
			)
  		);
		
		
		echo CHtml::dropDownList('cars_ranges','', $ranges, 
			array(
				'prompt'=>'Select Range',
				'data-iconpos'=>"right",
				'options' => array(  $selectedcars_ranges => array('selected'=>true)),
				'ajax' => array(
				'type'=>'POST', 
				'url'=>Yii::app()->createUrl('mobile/loadFuel'),
				'update'=>'#cars_fuel',
				'cache'=>false,
				'dataType'=>'html',
				'data'=>array('page_model' => $page_model, 'range_id'=>'js:this.value',
				'year'=>'js:$( "#carsForm #year" ).val()',
				'import_nazwa'=>$usedCarsMark[0]['nazwa'],
				'import_id'=>$usedCarsMark[0]['id_import'],
				'mark_id'=>'js:document.getElementById(\'cars_mark_name\').value',
				'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				'beforeSend' => "js:function(jqXHR, data){
					if( $( '#cars_ranges' ).hasClass( 'xhr-running' ) ) { 
						jqXHR.abort();
					}
					$( '#cars_ranges' ).addClass( 'xhr-running' );
					$( '.ui-mobile' ).addClass( 'ui-loading' );
				}",
				'complete' => "js:function(data)
				{
					$( '#cars_ranges' ).removeClass( 'xhr-running' );
					$( '.ui-mobile' ).removeClass( 'ui-loading' );
					unselect('#cars_fuel');unselect('#cars_model'); unselect('#cars_transmission'); unselect('#cars_body'); unselect('#cars_doors'); unselect('#cars_badge');
					singleSelect('#cars_fuel');
				}",
			))
		);

		// echo "<pre>";
		// print_r($usedCarsMark);
		// die;
		
		//Load fuel
		echo CHtml::dropDownList('cars_fuel','', $fuelData, 
			array(
				'prompt'=>'Select Fuel',
				'data-iconpos'=>"right",
				'options' => array(  $selectedcars_fuel => array('selected'=>true)),
				'ajax' => array(
					'type'=>'POST', 
					'url'=>Yii::app()->createUrl('mobile/loadTransmission'),
					'update'=>'#cars_transmission',
					'cache'=>false,
					'dataType'=>'html',
					'data'=>array('page_model' => $page_model, 
						'year'=>'js:$( "#carsForm #year" ).val()',
						'range_id'=>'js:document.getElementById(\'cars_ranges\').value',
						'import_nazwa'=>$usedCarsMark[0]['nazwa'],
						'import_id'=>$usedCarsMark[0]['id_import'],
						'mark_id'=>'js:document.getElementById(\'cars_mark_name\').value',
						'fuel_type'=>'js:this.value',
						
						'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
					),
					'beforeSend' => "js:function(jqXHR, data){
						if( $( '#cars_fuel' ).hasClass( 'xhr-running' ) ) { 
							jqXHR.abort();
						}
						$( '#cars_fuel' ).addClass( 'xhr-running' );
						$( '.ui-mobile' ).addClass( 'ui-loading' );
					}",
					'complete' => "js:function(data)
					{
						$( '#cars_fuel' ).removeClass( 'xhr-running' );
						$( '.ui-mobile' ).removeClass( 'ui-loading' );
						unselect('#cars_transmission'); unselect('#cars_model'); unselect('#cars_body'); unselect('#cars_doors'); unselect('#cars_badge');
						singleSelect('#cars_transmission');
					}",
				)
			)
		);		
		
		echo CHtml::dropDownList('cars_transmission','', $transmissionData, 
			array(
				'prompt'=>'Select Transmission',
				'data-iconpos'=>"right",
				'options' => array(  $selectedcars_transmission => array('selected'=>true)),
				'ajax' => array(
					'type'=>'POST',
					'url'=>Yii::app()->createUrl('mobile/loadBodyDoor'),
					'update'=>'#cars_body',
					'cache'=>false,
					'dataType'=>'html',
					'data'=>array(
							'page_model' => $page_model,
							'range_id'=>'js:document.getElementById(\'cars_ranges\').value',
							'year'=>'js:$( "#carsForm #year" ).val()',
							'import_nazwa'=>$usedCarsMark[0]['nazwa'],
							'import_id'=>$usedCarsMark[0]['id_import'],
							'mark_id'=>'js:document.getElementById(\'cars_mark_name\').value',
							'fuel_type'=>'js:document.getElementById(\'cars_fuel\').value',
							'transmission'=>'js:this.value',
							'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
						),
					'beforeSend' => "js:function(jqXHR, data){
						if( $( '#cars_transmission' ).hasClass( 'xhr-running' ) ) { 
							jqXHR.abort();
						}
						$( '#cars_transmission' ).addClass( 'xhr-running' );
						$( '.ui-mobile' ).addClass( 'ui-loading' );
					}",
					'complete' => "js:function(data)
					{
						$( '#cars_transmission' ).removeClass( 'xhr-running' );
						$( '.ui-mobile' ).removeClass( 'ui-loading' );
						unselect('#cars_body');unselect('#cars_model'); unselect('#cars_doors'); unselect('#cars_badge');
						singleSelect('#cars_body');
					}",
				)
			)
		);

		// Load Transmission
		// echo "<pre>";
		// print_r($transmissionData);
		// die;
		echo CHtml::dropDownList('cars_body','',$carsBodyData, 
				array(
					'prompt'=>'Select Body with Doors',
					'data-iconpos'=>"right",
					'options' => array(  $selectedcars_body => array('selected'=>true)),
					'ajax' => array(
						'type'=>'POST', 
						'url'=>Yii::app()->createUrl('mobile/loadModelType'),
						'update'=>'#cars_model',
						'cache'=>false,
						'dataType'=>'html',
						'data'=>array(
							'page_model' => $page_model,
							'range_id'=>'js:document.getElementById(\'cars_ranges\').value',
							'year'=>'js:$( "#carsForm #year" ).val()',
							'import_nazwa'=>$usedCarsMark[0]['nazwa'],
							'import_id'=>$usedCarsMark[0]['id_import'],
							'mark_id'=>'js:document.getElementById(\'cars_mark_name\').value',
							'fuel_type'=>'js:document.getElementById(\'cars_fuel\').value',
							'transmission'=>'js:document.getElementById(\'cars_transmission\').value',
							'model_txt'=>'js:this.value',
							'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
						),
						'beforeSend' => "js:function(jqXHR, data){
							if( $( '#cars_body' ).hasClass( 'xhr-running' ) ) { 
								jqXHR.abort();
							}
							$( '#cars_body' ).addClass( 'xhr-running' );
							$( '.ui-mobile' ).addClass( 'ui-loading' );
						}",
						'complete' => "js:function(data)
						{
							$( '#cars_body' ).removeClass( 'xhr-running' );
							$( '.ui-mobile' ).removeClass( 'ui-loading' );
								unselect('#cars_model');
							singleSelect('#cars_model');
						}",
					)
				)
			);
		//loadCarsModel selectedcars_model
		echo CHtml::dropDownList('cars_model','', $modelTypeData, 
			array(
				'prompt'=>'Select Model with Type',
				'data-iconpos'=>"right",
				'options' => array(  $selectedcars_model => array('selected'=>true)),
				
			)
		);									
	}
	echo CHtml::textField('userKms', '', array('placeholder'=>'Enter Kms (if known)', 'id'=>'user_kms', 'class'=>"reg_field", 'maxlength'=>12));
	echo '<br/>';
?>
</div>

<div class="btn_go btn_centre button-circle">
       <button type="button" class="buttonGo ui-btn ui-btn-none ui-corner-all" onclick="submitCarsForm()" id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none" value="Go">Go</button>
</div>
<!--<div class="btn_go btn_centre button-circle"> 
	<input type="button" onclick="submitForm()" id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none" value="Go">
</div> -->
<?php			
	echo CHtml::endForm();    
  	echo '</div></div>';     
?>
</div>
<div id="resultCarMakeModel">
	<!-- result get displayed here -->
</div>
<script type="text/javascript">
	$('.pdficons').hide();
		function submitCarsForm(){
			if(validate()){
				// $('#carsForm').submit();
				//new ajax for submission starts here
		        $.ajax({
		            url: "<?php echo Yii::app()->createUrl('mobile/gCarDetails'); ?>",
		            type: 'post',
		            data: $('#carsForm').serialize(),
		            beforeSend: function(){
		            	$( '.ui-mobile' ).addClass( 'ui-loading' );
		            },
		            success: function(data) {
		              $("#resultCarMakeModel").html(data);
		            },
		            complete: function(event,xhr,options){
		            	// console.log(event.responseText);
						$( '.ui-mobile' ).removeClass( 'ui-loading' );
		            	//code to focus on the div
		            	if( $(window).width() <= 767 ){
		            		$('#resultCarMakeModel').show();
      						$('#search_make_model_form').hide();
		                }else{
		                	$('#resultCarMakeModel').show();
      						$('#search_make_model_form').show();
		                }

						var codeNumber 		= '';
				    	var postData 		= '';
				        var codeNumber 			= $(event.responseText).wrap('<div />').parent().find('input#codenumber').val()?$(event.responseText).wrap('<div />').parent().find('input#codenumber').val():'';
				        var postData 	= $(event.responseText).wrap('<div />').parent().find('input#displayData').val()?$(event.responseText).wrap('<div />').parent().find('input#displayData').val():'';
						var baseUrl = "<?php echo Yii::app()->createUrl('/mobile/makeModelGeneratePdf',array('m'=>'UsedCarsModel','imp'=>$usedCarsMark[0]['id_import'])); ?>";
						// console.log(codeNumber);
						if(codeNumber && codeNumber !='' 
						&& postData && postData !='' ){
							$('.pdficons').show();
							// console.log($('.pdflink a').attr('data-baseurl'));
							// $('.pdflink a').attr('href',$('.pdflink a').attr('href')+'&cn='+codeNumber+'&postData='+postData);
							$('.pdflinks a').attr('href',baseUrl+'&cn='+codeNumber+'&pd='+postData);
						}else{
							$('.pdficons').hide(); // 142D1635
						}

		              //code to focus on the div
		            }
		        })
	          //ends here
			}else {
				alert('Please select all the fields.');
				return false;
			}			
		}

		function validate(){
			if($('#carsForm #cars_body').val()=='') return false;
			if($('#carsForm #cars_transmission').val()=='') return false;
			if($('#carsForm #cars_fuel').val()=='') return false;
			if($('#carsForm #cars_model').val()=='') return false;
			if($('#carsForm #cars_ranges').val()=='') return false;
			if($('#carsForm #cars_mark_name').val()=='') return false;
			if($('#carsForm #year').val()=='') return false;
			return true;
		}

		function singleSelect(child){
			size = $(child+' option').size();
			val = $(child+' option').eq(1).val();
			if(size === 2){
				$(child).val($(child+' option').eq(1).val());
				$(child).selectmenu("refresh");
				$(child).trigger("change");
			}
		}

		function unselect(child){
			$(child+" option:selected").removeAttr("selected");
			$(child).selectmenu("refresh");
		}
				
		$("input[type='radio']").bind( "change", function(event, ui) {
			$.ajax({
				url: "<?php echo Yii::app()->createUrl('mobile/loadMake');?>",
				type:'POST',
				cache:false,
				update: "#cars_mark_name",
				dataType:'html',
				data: {'vehicle_type':this.value},
				complete : function(data){
					//console.log(data.response);
					$('#cars_mark_name').html('<option>make</option>');   
					$("option:selected").removeAttr("selected");
					//$('#cars_mark_name').html('<option>ala</option>');   
				}
			});
		});

	function goCarsUp(){
		$('#resultCarMakeModel').hide();
      	$('#search_make_model_form').show();
      // document.body.scrollTop = 0; // For Safari
      // document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }

	// setTimeout(function () {
	// 	var size = $("#cars_mark_name"+' option').size();
	// 	var passval = $("#cars_mark_name").val();
	// 	if(passval !=''){
	// 	$("#cars_mark_name").trigger("change");
	// 	setTimeout(function () {
	// 		$('#cars_ranges').val("<?php echo $selectedcars_ranges; ?>")
	// 		$("#cars_ranges").trigger("change");
	// 		setTimeout(function () {
	// 			$('#cars_fuel').val("<?php echo $selectedcars_fuel; ?>")
	// 			$("#cars_fuel").trigger("change");
	// 			setTimeout(function () {
	// 				$('#cars_transmission').val("<?php echo $selectedcars_transmission; ?>")
	// 				$("#cars_transmission").trigger("change");
	// 				setTimeout(function () {
	// 					$('#cars_body').val("<?php echo $selectedcars_body; ?>")
	// 					$("#cars_body").trigger("change");
	// 					setTimeout(function () {
	// 						$('#cars_model').val("<?php echo $selectedcars_model; ?>");
	// 						// $('#cars_model').val($('#cars_model'+' option').eq(2).val());
	// 						// alert('<?php echo $selectedcars_model; ?>');
	// 						$("#cars_model").trigger("change");
	// 					},2000);
	// 				},1000);
	// 			},1000);
	// 		},1000);
	// 	},1000);

	// 	passval = '';
	// 	}
	// }, 3000);
</script>

<div id="cars_model_details"></div>
