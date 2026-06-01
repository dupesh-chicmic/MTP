<?php
	$make = $rangecode	=	null;
	
	if(	$_GET['make'])
		$make =	$_GET['make'];

	if(	$_GET['rangecode'])
		$rangecode =	$_GET['rangecode'];

?>
<div id="content">
	<div class="width">
		<div class="con_box">
			<div class="mt_tab">
				<div class="byPrice_modal">
					<a href="<?php echo (($carsVisibleLink) ? Yii::app()->createUrl('mobile/archive',array('page'=>'cars')) : '#'); ?>" class="passenger <?=($page == 'cars') ? 'btn_active' : '' ?>">Passenger</a>
					<a href="<?php echo (($commVisibleLink) ? Yii::app()->createUrl('mobile/archive',array('page'=>'commercial')) : '#'); ?>" class="commercial <?=($page == 'commercial') ? 'btn_active' : '' ?>">Commercial</a>
				</div>
				
				<div class="modal_select">
					<div class="options">
						<select class="form-control" name="arch_month" id="arch_month">
							<?=$archOptions?>
						</select>
					</div>
					<div class="options">
						<select class="form-control" name="select1" id="select1">
							<?=implode( $makeData )?>
						</select>
					</div>
					<?php 
						if($arch_year < $arch){
						
							echo '<div class="options">
									<select class="form-control bmw" name="select2" id="select2">
									'.implode( $modalData ).'
									</select>
								</div>';
						}
					?>
					
				</div>
				
			</div><!-- End mt_tab -->
			<div class="tab_content" id="list-data">

				<div class="table-list tab tab1">
                    <div class="brand_title">
                        <span id="titleFieldFromXml"><?php echo $headerTitle;?></span>
						<span id="titleFieldFromXml"><?php echo $tableTitle;?></span>
						<p class="desktop-display">Please click on the variant for valuation details.</p>
						<p class="mobile-landscape-display">Please click on the variant for valuation details.</p>
						<p class="mobile-display"><img src="./images/rotate.png" alt=""  class="rotate_icn"/>Please rotate your device to see all details.</p>
                    </div>
                <!--/div-->
                	<div class="table-wrapper">
						<table class="items">
							<thead id="headItems">
								<tr>
									<th scope="col" class="mobile-show col-md-3 text-left">Model</th>
									<th scope="col" class="mobile-show col-md-5 text-right">Variant</th>
									<th scope="col" class="body col-md-4 text-right">Body</th>
									<th scope="col" class="col-md-5 text-right">LRP/CRP</th>
									<th scope="col" class="col-md-4 text-right">From/To</th>
									<?php if($SHOW_CODE_COLUMN): ?>
										<th scope="col">Code</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>  
								<?php
									$enterKmFormUzupelnij = ''; $corecode = 0;
									
									if($arch < $january2020){
										$corecode = 1;
									}
									//echo "<pre>";
									//print_R($model);
									if(!empty($model)){
										$id = (count($model) == 1 && isset($model['id'])) ? $model['id'] : $allCars[0]['id'];
										// if(!empty($range)){
										// 	$cars = $modelName::model()->findAll(array(
										// 		"condition"=>"rangecode=:range AND $fildName=:mid" . $condition,
										// 		'params'=>array('range'=>$range, ':mid'=>$id)
										// 	));
										// }else {
										// 	$cars = $modelName::model()->findAll(array(
										// 		'condition'=>"$fildName=:mid".$condition,
										// 		'params'=>array(':mid'=>$id)
										// 	));
										// }

										// echo UsedCarsModel::getRangeDesc ($range, $page); die;

										$cars = UsedCarsModel::fetchCarsData ($page, $id, $range, $corecode );
								
										//print_r($cars); 
										$i 	  = 0;
										$anchor = 2;
										
										foreach ($cars as $row)
										{
											$model_name = $row['vehicle'];
											$variant = $row['codenumber']."-";
											$variant = $row['badge'];
											$variant = $row['mtpvariant'] .' '.$row['badge'];
											if( isset( Yii::app()->params['app_mode'] ) && Yii::app()->params['app_mode'] == 'development' ){
												$variant = $row['codenumber']."-".$row['mtpvariant'] .' '.$row['badge'];
											}
											if($arch >= $january2020){
												$model_name = UsedCarsModel::getRangeDesc ($range, $page);
												// $variant = $row['codenumber']."-".$row['mtpvariant'] .' '.$row['badge'];
												// $variant = $row['mtpvariant'] .' '.$row['badge'];
											}
											echo '<tr id="trcontent'.$row['codenumber'].'">';
												echo '<td class="mobile-show">'.$model_name. '</td>';
												// echo '<td class="mobile-show">'.$row['vehicle']. '</td>';
												echo '<td class="mobile-show open-varnt text-right" id="showcont_'.$row['codenumber'].'" onclick="showContent('.$row['codenumber'].');">'
														.'<a style="height: 0px;" name="anchor_'.$anchor.'"></a>'
														. '<span class="actionLink">'
														. '<a href="#anchor_'.(($i >= 2) ? $anchor-1 : 0).'" id="car_'.$row['codenumber'].'" name="up_'.$row['codenumber'].'">'.$variant.'</a>'
														. '</span>'
														. '</td>';
												$anchor++;
												echo '<td class="text-right" data-label="Body" class="body">'.$row['body'].'</td>';
												echo '<td class="text-right" data-label="LRP/CRP">'.$row['price'].'</td>';
												echo '<td class="text-right" data-label="From/To">'.$row['years'].'</td>';
												if($SHOW_CODE_COLUMN) {
													echo '<td data-label="Code">'.$row['codenumber'].'</td>';
												}
												$fuel = $row['fuel'];
											echo '</tr>';
											echo '<tr>';
												echo '<td colspan="5" style="padding:0;">';
													// var_dump(isset($_GET['backpdf']) && isset($_GET['selrow']) && $row['codenumber']==$_GET['selrow'] && $_GET['backpdf']==1);
													if(isset($_GET['backpdf']) && isset($_GET['selrow']) && $row['codenumber']==$_GET['selrow'] && $_GET['backpdf']==1){
														echo '<div class="hideModelDetails" id="content_'.$row['codenumber'].'" style="display:block;">';
													}else{
														echo '<div class="hideModelDetails" id="content_'.$row['codenumber'].'" style="display:none;">';
													}

													
														$spec = 'spec'.$i;
														$intro = 'intro'.$i;
														$note = 'note'.$i;
														$specMw="";
														for($c=1;$c<5;$c++){
															if($row['spec'.$c]!="")
																$specMw.=$row['spec'.$c]."<br/>";
														}
														$introMw = '';
														for($c=1;$c<6;$c++){
															if($row['intro'.$c]!="")
																$introMw.=$row['intro'.$c]."<br/>";
														}

														$noteMw = '';
														for($c=1;$c<6;$c++){
															if($row['note'.$c]!="")
																$noteMw.=$row['note'.$c]."<br/>";
														}
													?>
													<div class="vr">
														<table style="width:100%;float:left;">
															<thead>
																<tr>
																	<th class="text-center">Years</th>
																	<th class="text-center">Kms[x1000]</th>
																	<th>Guide €</th>
																</tr>
															</thead>
															<tbody>
																<?php
																$year = ''; $kms = ''; $grp = '';
																//lat jest zawsze 16
																for($i=0;$i<16;$i++){
																	$year = $row['yr'.$i];
																	$kms = $row['kms'.$i];//UsedCarsModel::ensureKmsFormat($row['kms'.$i]);
																	$grp = $row['GRP'.$i];
																	if($year != ''){        
																		echo '<tr id="tr_'.$row['codenumber'].'_'.$year.'">'; 
																			echo '<td class="inner text-center" id="show_td_'.$row['codenumber'].'_'.$year.'" onclick="enterKm(\''.$kms.'\', \'tr_'.$row['codenumber'].'_'.$year.'\', \'km_'.$row['codenumber'].'\', \'tr_'.$row['codenumber'].'_'.$year.'\', \'year_'.$row['codenumber'].'\', \''.$year.'\', \'guide_'.$row['codenumber'].'\', \''.$grp.'\', \'fuel_'.$row['codenumber'].'\', \''.$fuel.'\', \'guideKm_'.$row['codenumber'].'\', \''.$kms.'\' , \''.$row['codenumber'].'\')"><span class="actionLink">'.$year.'</b></td>';
																			echo '<td class="inner text-center" >'.$kms.'</td>';
																			echo '<td class="inner" >'.$grp.'</td>';
																		echo'</tr>';
																		$enterKmFormUzupelnij .= '$(\'#\'+trId_zaznacz).siblings().removeClass("activeTr"); ';
																	}
																}
																?>
															</tbody>
														</table>
													</div>

													<div class="dataRight">
														<div class="dataLeft">
															<span class="headerColor">Engine</span><br/><?php echo $specMw ?><br /> 
															<span class="headerColor">Introduced/Modified</span><br /><?php echo $introMw ?><br />
															<span class="headerColor">Notes</span><br /><?php echo $noteMw ?> 
														</div>
													</div>

													<div class="carForm">
														<!--div class="divider2"></div-->
														<label>Enter Kms (x1000)</label>
														<div class="form1">
															<?php            
																echo CHtml::beginForm(Yii::app()->createUrl('mobile/archive',array('arch'=>$arch)),'',array('onsubmit'=>'return valid();'));
																echo CHtml::textField('km', '', array('class'=>'km','id'=>'km_'.$row['codenumber']));
																echo CHtml::hiddenField('year', '', array('id'=>'year_'.$row['codenumber']));
																echo CHtml::hiddenField('guide', '', array('id'=>'guide_'.$row['codenumber']));//km usera wpisane
																echo CHtml::hiddenField('guideKm', '', array('id'=>'guideKm_'.$row['codenumber']));
																echo CHtml::hiddenField('fuel', '', array('id'=>'fuel_'.$row['codenumber']));
																$pageName = ($page == 'cars') ? 'UsedCarsModel' : 'UsedComCars';
																echo CHtml::hiddenField('carOrCom', $pageName, array('id'=>'carOrCom'.$row['codenumber']));
																echo CHtml::hiddenField('codenumber', $row['codenumber'], array('id'=>$row['codenumber']));

																echo CHtml::hiddenField('make', $_GET['make'], array('id'=>'make'.$row['codenumber']));
																echo CHtml::hiddenField('rangecode', $_GET['rangecode'], array('id'=>'rangecode'.$row['codenumber']));
																/* echo CHtml::hiddenField('import', $importId); */
																echo CHtml::hiddenField('import', $arch, array('id'=>'import'.$row['codenumber']));
																echo CHtml::hiddenField('YII_CSRF_TOKEN',Yii::app()->request->csrfToken);
																echo '<div class="adjust_btn_archiv">';
																echo CHtml::button('ADJUST', array(
																		'class'=>'button1 adjustme',
																		'onclick'=>CHtml::ajax(array(
																						'type'=>'POST', 
																						'url'=>array("mobile/ajaxCount"), 
																						'update'=>'#value_'.$row['codenumber'].''
																					) 
																				)
																			)
																		);
																// var_dump($i);
																echo Chtml::endForm();
																echo '</div>';
															?>
														</div>
													
														<div class="adjustedValue">
															<!-- <img src="images/divider.png" style="width:100%;" /> -->
															<label class="fontColor"></label>
															<?php
																echo '<span id="value_'.$row['codenumber'].'" class="value">Adjusted Guide value &#8364;';
																echo '</span>';
															?>
														</div>
													</div>
												</div>
											</td><!-- id="content_codenumber" -->
										</tr>
										<?php
											$i++;
										} //end forech
									}// end if model is empty condition
								?>
							</tbody>
						</table>
						<table id="header-fixed"></table>
					</div> 
				</div>


			</div>
			<!-- End tab_content -->
		</div>
	</div>
</div>

<?php
	$enterKmForm = '';
    Yii::app()->clientScript->registerScript('subMenu','', CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScript('dataRight',$enterKmForm, CClientScript::POS_HEAD); 
    Yii::app()->clientScript->registerScript('contentContainer','
    var enter = 0;
    function valid() {
      return (enter == 1) ? true : false;
    }',CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/stickyDiv.js',CClientScript::POS_END);

	//mobile render here:
	$lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));
?>

<script type="text/javascript">

	function showContent(code){
		$( '.op-varnt' ).removeClass( 'op-varnt' );
        $(".hideModelDetails").css("display","none");
        $("#content_"+code).css("display","block");
        toToptheContent("trcontent"+code);
        $("#content_"+code+">div.vr>table>tbody>tr:first>td:first").trigger('click');
        // $('.adjustme').trigger('click');
		// $(document).find('#'+formKmId).parents('form').find('.adjustme').trigger('click');
    }

	$(document).ready(function(){
        $(document).on("click", ".range-model", function(){
            var getName = $(this).attr("data-name");       
            $(".range_model_list").hide();
            $(".sub-nav-data-"+getName).show();
        });
		<?php if(isset($selrow) && !empty($selrow) 
				&& isset($selyear) && !empty($selyear) ){
		?>
			// $(document).find('#showcont_<?php echo $selrow; ?>').trigger('click');
			// $(document).find('#show_td_<?php echo $selrow; ?>_<?php echo $selyear; ?>').trigger('click');
			// toToptheContent("trcontent<?php echo $selrow; ?>");
		<?php }
		?>
    });

    function enterKm(km, trId_odznacz, formKmId, trId_zaznacz, formYearId, year, formUserKmId, UserKm, formFuelId, fuel, formGuideKmId, guideKm, value_clear)
    {
    	<?php echo $enterKmFormUzupelnij; ?>

	    var x = document.getElementById(formKmId).value = km;
	    var year = document.getElementById(formYearId).value = year;
	    var guideUsr = document.getElementById(formUserKmId).value = UserKm;
	    var guideKm = document.getElementById(formGuideKmId).value = guideKm;
	    var fuel = document.getElementById(formFuelId).value = fuel;
	    document.getElementById(trId_zaznacz).className = "activeTr"; // zaznacza
	    //clear adjustment value
	    document.getElementById("value_"+value_clear).innerHTML = "Adjusted Guide value &#8364;<!--<a href=\"index.php?r=mobile/generatePdf&m=UsedCarsModel&imp='.$importId.'&make='.$make.'&rangecode='.$rangecode.'&cn="+value_clear+ "\" target=\"_blank\"><img src=\"./images/pdf.png\" style=\"width:28px; height:28px;\" alt=\"[pdf]\" /></a>-->";
	    // $('.adjustme').trigger('click');
		$(document).find('#'+formKmId).parents('form').find('.adjustme').trigger('click');
	}

	function toToptheContent(selector){
		document.getElementById(selector).scrollIntoView();
		$('html, body').animate({
		         scrollTop: $('#'+selector).offset().top - ($(window).height() - $('#'+selector).outerHeight(true))
		    }, 'fast');
	}
	<?php
		if(isset($_GET['backpdf']) && isset($_GET['selrow']) && $_GET['selrow'] !='' && $_GET['backpdf']==1){
	?>
		$("#showcont_<?php echo $_GET['selrow']; ?>").ready(function(){
			//block will be loaded with element with id myid is ready in dom
			$("#show_td_<?php echo $_GET['selrow'];?>_<?php echo $_GET['seltd'];?>").trigger('click');
		});
	<?php 		
		}
	?>
	
</script>