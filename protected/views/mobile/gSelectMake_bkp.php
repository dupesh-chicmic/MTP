<div id="search_make_model_form">
<div id="dw-control-group"  data-role="controlgroup" data-type="horizontal">
	<a href="#" class="dw-radio-btn ui-btn ui-corner-all ui-btn-active dw-cars" >Passenger</a>
	<a href="<?php echo Yii::app()->createUrl('mobile/gSelectMakeComm');?>" class="dw-radio-btn ui-btn ui-corner-all">Commercial</a>  
</div>

<div class="menu_group">

<?php
	$style = "";

	echo CHtml::beginForm(Yii::app()->createUrl('mobile/gCarDetails'), 'POST', array('id'=>'carsForm', 'style'=>$style,'autocomplete'=>'off' ));
    echo CHtml::hiddenField('vehicle_type', 'cars');
    echo CHtml::hiddenField('import_id', $usedCarsMark[0]['id_import']);

    $years = Mobile::getDisplayYears('Yrs2Display_ByMake.xml');

		echo CHtml::dropDownList('year', 'year', 
		$years,
		array(
			'prompt'=>'Select Year',
			'data-iconpos'=>"right",
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
		echo CHtml::dropDownList('cars_mark_name', 'cars_make_s', 
			CHtml::listData($usedCarsMark,'id', 'name'),
			array(
				'prompt'=>'Select Make',
				'data-iconpos'=>"right",
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
								
		echo CHtml::dropDownList('cars_ranges','', array(), 
			array(
				'prompt'=>'Select Range',
				'data-iconpos'=>"right",
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
					

		//Load fuel
		echo CHtml::dropDownList('cars_fuel','', array(), 
			array(
				'prompt'=>'Select Fuel',
						'data-iconpos'=>"right",
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
									
		//Load Transmission
		echo CHtml::dropDownList('cars_transmission','', array(), 
			array(
				'prompt'=>'Select Transmission',
						'data-iconpos'=>"right",
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
						unselect('#cars_model');unselect('#cars_body'); unselect('#cars_doors'); unselect('#cars_badge');
						singleSelect('#cars_model');
					}",
				)
			)
		);


		//loadCarsModel
		echo CHtml::dropDownList('cars_model','', array(), 
			array(
				'prompt'=>'Select Model with Type',
						'data-iconpos'=>"right",
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
						'transmission'=>'js:document.getElementById(\'cars_transmission\').value',
						'model_txt'=>'js:this.value',
						'YII_CSRF_TOKEN' => Yii::app()->request->csrfToken
					),
					'beforeSend' => "js:function(jqXHR, data){
						if( $( '#cars_model' ).hasClass( 'xhr-running' ) ) { 
							jqXHR.abort();
						}
						$( '#cars_model' ).addClass( 'xhr-running' );
						$( '.ui-mobile' ).addClass( 'ui-loading' );
					}",
					'complete' => "js:function(data)
					{
						$( '#cars_model' ).removeClass( 'xhr-running' );
						$( '.ui-mobile' ).removeClass( 'ui-loading' );
							unselect('#cars_body');
						singleSelect('#cars_body');
					}",
			  	)
			)
		);

		echo CHtml::dropDownList('cars_body','', array(), 
				array(
					'prompt'=>'Select Body with Doors',
					'data-iconpos'=>"right",
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
		            complete: function(){
		            	$( '.ui-mobile' ).removeClass( 'ui-loading' );
		            	//code to focus on the div
		            	if( $(window).width() <= 767 ){
		            		$('#resultCarMakeModel').show();
      						$('#search_make_model_form').hide();
		                }else{
		                	$('#resultCarMakeModel').show();
      						$('#search_make_model_form').show();
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
</script>

<div id="cars_model_details"></div>