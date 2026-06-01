<?php /* Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/pages/mobile/user-guide-list.js',CClientScript::POS_HEAD); */ ?>
<div id="content">
	<div class="width">

		<div class="con_box">

			<div class="mt_tab">
				<div class="byPrice_modal">
					<a href="<?php echo (($carsVisibleLink) ? Yii::app()->createUrl('mobile/usedPassengerComercialArchive',array('arch'=>$arch,'com_arch'=>$com_arch, 'page'=>'cars')) : '#'); ?>" class="passenger <?=($page == 'cars') ? 'btn_active' : '' ?>">Passenger</a>
					<a href="<?php echo (($commVisibleLink) ? Yii::app()->createUrl('mobile/usedPassengerComercialArchive',array('arch'=>$arch,'com_arch'=>$com_arch, 'page'=>'commercial')) : '#'); ?>" class="commercial <?=($page == 'commercial') ? 'btn_active' : '' ?>">Commercial</a>
				</div>

				<div class="modal_select">
					<div class="options">
						<select class="form-control" name="select1" id="select1">
							<?=implode( $makeData )?>
						</select>
					</div>

					<div class="options">
						<select class="form-control bmw" name="select2" id="select2">
						<?=implode( $modalData )?>
						</select>
					</div>

				</div>

			</div><!-- End mt_tab -->

			<div class="tab_content" id="list-data">
				
				<div class="table-list tab tab1">
                    <div class="brand_title">
                        <span id="titleFieldFromXml"><?php echo $headerTitle;?></span>
                        <span id="titleFieldFromXml"><?php echo $tableTitle;?></span>
						<p class="desktop-display">Please click on the variant for valuation details.</p>
						<p class="mobile-landscape-display">Please click on the variant for valuation details.</p>
						<p class="mobile-display">Please rotate your device to see all details.</p>
                    </div>
                <!--/div-->
                	<div class="table-wrapper">
						<table class="items">
							<thead id="headItems">
								<tr>
									<th scope="col" class="mobile-show col-md-5">Model</th>
									<th scope="col" class="mobile-show col-md-5 text-right">Variant</th>
									<th scope="col" class="body col-md-4">Body</th>
									<th scope="col" class="text-right col-md-5">LRP/CRP</th>
									<th scope="col" class="col-md-4">From/To</th>
									<?php if($SHOW_CODE_COLUMN): ?>
										<th scope="col">Code</th>
									<?php endif; ?>
								</tr>
							</thead>
							<tbody>     
								<?php
									$enterKmFormUzupelnij = '';
									$tableAfterTriggerARow = '';

									if(!empty($model)){
										$id = (count($model) == 1 && isset($model['id'])) ? $model['id'] : $allCars[0]['id'];
										if(!empty($range)){
											$cars = UsedComCarsModel::model()->findAll(array(
												'condition'=>'rangecode=:range AND id_used_com_cars=:mid',
												'params'=>array(':range'=>$range, ':mid'=>$id)                               
											));
										}else {
											$cars = UsedComCarsModel::model()->findAll(array(
												'condition'=>'id_used_com_cars=:mid',
												'params'=>array(':mid'=>$id)
											));
										}
								
										$i = 0;
										$anchor = 2;
										foreach ($cars as $row)
										{
											
											// ONLY FOR TEST SITE CHANGE SQL QUERY
											/*if($row['corecode'] != '') {
												continue;
											}*/
											
											echo '<tr id="up_'.$row['codenumber'].'">';
												echo '<td class="mobile-show" data-label="Type">'.$row['vehicle'].'</td>';
												echo '<td class="mobile-show open-varnt text-right" data-label="Model" onclick="showContent('.$row['codenumber'].');">'
														.'<a style="height: 0px;" name="anchor_'.$anchor.'"></a>'
														. '<span class="actionLink">'
														. '<a href="#anchor_'.(($i >= 2) ? $anchor-1 : 0).'" id="car_'.$row['codenumber'].'" name="up_'.$row['codenumber'].'">'.$row['badge'].'</a>'
														. '</span>'
														. '</td>';
												$anchor++;
												// echo '<td class="mobile-show" data-label="Type">'.$row['badge'].'</td>';
												echo '<td data-label="Body" class="body">'.$row['body'].'</td>';
												echo '<td data-label="LRP/CRP" class="text-right">'.$row['price'].'</td>';
												echo '<td data-label="From/To">'.$row['years'].'</td>';
												if($SHOW_CODE_COLUMN) {
													echo '<td data-label="Code">'.$row['codenumber'].'</td>';
												}
												$fuel = $row['fuel'];
											echo '</tr>';
											echo '<tr>';
												echo '<td colspan="5" style="padding:0;">';
													echo '<div class="hideModelDetails" id="content_'.$row['codenumber'].'" style="display:none;">';
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
																				echo '<td class="inner text-center" onclick="enterKm(\''.$kms.'\', \'tr_'.$row['codenumber'].'_'.$year.'\', \'km_'.$row['codenumber'].'\', \'tr_'.$row['codenumber'].'_'.$year.'\', \'year_'.$row['codenumber'].'\', \''.$year.'\', \'guide_'.$row['codenumber'].'\', \''.$grp.'\', \'fuel_'.$row['codenumber'].'\', \''.$fuel.'\', \'guideKm_'.$row['codenumber'].'\', \''.$kms.'\' , \''.$row['codenumber'].'\')"><span class="actionLink">'.$year.'</b></td>';
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
																<span class="headerColor">Introduced/Modified</span><br /><?php echo $introMw ?>
																<br />
																<span class="headerColor">Notes</span><br /><?php echo $noteMw ?>
															</div>
														</div>

														<?php
														echo '<div class="carForm">
																<!--div class="divider2"></div-->
																<label>Enter Kms (x1000)</label>
																<div class="form1">';
																	echo CHtml::beginForm(Yii::app()->createUrl('mobile/usedComCarsArchive',array('arch'=>$com_arch)),'',array('onsubmit'=>'return valid();'));
																	echo CHtml::textField('km', '', array('class'=>'km','id'=>'km_'.$row['codenumber']));
																	echo CHtml::hiddenField('year', '', array('id'=>'year_'.$row['codenumber']));
																	echo CHtml::hiddenField('guide', '', array('id'=>'guide_'.$row['codenumber']));//km usera wpisane
																	echo CHtml::hiddenField('guideKm', '', array('id'=>'guideKm_'.$row['codenumber']));
																	echo CHtml::hiddenField('fuel', '', array('id'=>'fuel_'.$row['codenumber']));
																	echo CHtml::hiddenField('carOrCom', 'UsedComCarsModel');
																	echo CHtml::hiddenField('codenumber', $row['codenumber']);
																	echo CHtml::hiddenField('import', $com_arch);
																	/* echo CHtml::hiddenField('import', $importId); */
																	echo CHtml::hiddenField('YII_CSRF_TOKEN',Yii::app()->request->csrfToken);
																	echo CHtml::button('ADJUST', array('class'=>'button1',
																			'onclick'=>CHtml::ajax(array('type'=>'POST', 'url'=>array("mobile/ajaxCount"), 
																			'update'=>'#value_'.$row['codenumber'].''))
																		));
																	echo Chtml::endForm();
															
															echo '</div>';
															
															echo '<div class="adjustedValue">
																	<img src="images/divider.png" style="width:100%;" />
																	<label class="fontColor"></label>
																	<span id="value_'.$row['codenumber'].'" class="value">Adjusted Guide value &#8364;';
																	//pdf
																	//echo '<a href="'.Yii::app()->createUrl('/mobile/generatePdf',array('m'=>'UsedComCarsModel','cn'=>$row['codenumber'],'imp'=>$importId)).'"><img src="./images/pdf.png" style="width:28px; height:28px;" alt="[pdf]" /></a>';
																echo '</span>
																</div>'; 
														echo '</div>';
													?>
													</div>
												</td><!-- id="content_codenumber" -->
											</tr>
											<?php
												$i++;
										}//end forech
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

    Yii::app()->clientScript->registerScript('subMenu','      

    ', CClientScript::POS_HEAD);
    // Yii::app()->clientScript->registerScript('dataRight',$enterKmForm, CClientScript::POS_HEAD);
    Yii::app()->clientScript->registerScript('contentContainer','
    var enter = 0;
    function valid() {
      return (enter == 1) ? true : false;
    }',CClientScript::POS_HEAD);    
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/stickyDiv.js',CClientScript::POS_END);    
?>

<script type="text/javascript">
    function showContent(code){
		$( '.op-varnt' ).removeClass( 'op-varnt' );
        $(".hideModelDetails").css("display","none");
        $("#content_"+code).css("display","block");
    }

    $(document).ready(function(){
        $(document).on("click", ".range-model", function(){
            var getName = $(this).attr("data-name");       
            $(".range_model_list").hide();
            $(".sub-nav-data-"+getName).show();
        });
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
        document.getElementById("value_"+value_clear).innerHTML = "Adjusted Guide value &#8364;<!--<a href=\"index.php?r=mobile/generatePdf&m=UsedComCarsModel&imp='.$importId.'&cn="+value_clear+ "\"><img src=\"./images/pdf.png\" style=\"width:28px; height:28px;\" alt=\"[pdf]\" /></a>-->";    
    }
</script>