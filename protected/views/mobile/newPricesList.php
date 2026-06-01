<?php 
	$make = "";
	if (isset($_GET['make'])) {
	    $make = '&make='.$_GET['make'];
	}
?>
<div id="content">
	<div class="width">

		<div class="con_box">

			<div class="mt_tab">
				<div class="byPrice_modal">
					<a href="<?php echo Yii::app()->createUrl('mobile/newPrices').'&page=cars'.$make;?>" class="passenger <?=($page == 'cars') ? 'btn_active' : '' ?>">Passenger</a>
					<a href="<?php echo Yii::app()->createUrl('mobile/newPrices').'&page=commercial'.$make;?>" class="commercial <?=($page == 'commercial') ? 'btn_active' : '' ?>">Commercial</a>
				</div>

				<div class="modal_select">
					<div class="options">
						<select class="form-control" id="aselect1">
							<?=$makeOptions?>
						</select>
					</div>

					<div class="options series_select"<?php if( !$seriesOptions ) echo ' style="display:none;"'; ?>>
						<select class="form-control" id="aselect3">
						<?=$seriesOptions?>
						</select>
					</div>

					<div class="options">
						<select class="form-control bmw" id="aselect2">
						<?=$modelOptions?>
						</select>
					</div>

				</div>

			</div><!-- End mt_tab -->

			<div class="tab_content" id="list-data">
				<?=$tableHtml?>
			</div>
			<!-- End tab_content -->
		</div>
	</div>
</div>