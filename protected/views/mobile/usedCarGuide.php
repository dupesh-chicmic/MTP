<?php 
$SHOW_CODE_COLUMN = Yii::app()->params['used_car_com_code_column_visibility'];
//-----------------------
$criteria=new CDbCriteria;
$criteria->order = '`name`';
$criteria->condition='id_import=:importId';
if (isset($_GET['make']) && $_GET['make'] != ''){
    $tableTitle = $model['idImport']['nazwa'];
    $importId = $model['id_import'];
    $criteria->params=array(':importId'=>$model['id_import']);
}else{
    $tableTitle = $model[0]['idImport']['nazwa'];
    $importId = $model[0]['id_import'];
    $criteria->params=array(':importId'=>$model[0]['id_import']);
}
$allCars = UsedCars::model()->findAll($criteria);

if (!isset($_GET['make'])){
    $headerTitle = $allCars[0]['name'];
}
$range = null;
$usedCarsRanges = array();
if(!empty($_GET['rangecode'])){
    $range = $_GET['rangecode'];
    $usedCarsRanges = UsedCars::usedCarsRanges($importId);
}else{
    $usedCarsRanges = UsedCars::usedCarsRanges($importId);
    if(!empty($usedCarsRanges)){              
		$startRangeCode = array_values($usedCarsRanges);
		$startRangeCode = $startRangeCode[0];
		$range = array_values($startRangeCode);
		$range = $range[0];
    }
}
// MENU LEWE
echo $this->renderPartial('//mobile/_usedCarComListMenuLeft', 
        array('allCarsModel'=>$allCars,
              'make'=>(isset($_GET['make'])) ? $_GET['make'] : '',
              'range'=>$range,
              'usedCarsRanges'=>$usedCarsRanges,
              'type'=>'cars'
            )); 
?>
 
<div class="contentContainer">

<div class="carTable" style="margin-top:0px; width: 100%;">

    <div class="modal_top">
		<span class="span_head" ><?php echo $headerTitle;?></span>
		<span class="span_head"><?php echo $tableTitle;?></span>
		<span style="font-size: smaller;" class="span_head">Please click on Model description for valuation details. </span>		
		<a style="float:left; height: 0px;" name="anchor_0"></a>
	</div>	
	
	<div class="table-responsive">
		<table >
		<tr id="headItems">
			<?php if($SHOW_CODE_COLUMN): ?>
				<th class="header" style="width:205px;">Model</th>
				<th class="header" style="width:95px;">Type</th>
				<th class="header" style="width:100px;">Body</th>
				<th class="header" style="width:110px;">LRP/CRP</th>
				<th class="header" style="width:80px;">From/To</th>
				<th class="header" style="width:80px;">Code</th>
			<?php else: ?>
				<th class="header" style="width:220px;">Model</th>
				<th class="header" style="width:135px;">Type</th>
				<th class="header" style="width:100px;">Body</th>
				<th class="header" style="width:120px;">LRP/CRP</th>
				<th class="header" style="width:80px;">From/To</th>
			<?php endif; ?>
		</tr>        
	<?php
		$enterKmFormUzupelnij = '';
			if(!empty($model)){
				$id = (count($model) == 1 && isset($model['id'])) ? $model['id'] : $allCars[0]['id'];
				if(!empty($range)){
					$cars = UsedCarsModel::model()->findAll(array(
						'condition'=>'rangecode=:range AND id_used_cars=:mid',
						'params'=>array('range'=>$range, ':mid'=>$id)
					));
				} else {
					$cars = UsedCarsModel::model()->findAll(array(
						'condition'=>'id_used_cars=:mid',
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
			
			echo '<tr id="model">';
			//echo '<a style="height: 0px;" name="anchor_'.$anchor.'"></a>';
			$width = ($SHOW_CODE_COLUMN) ? "210px;": "220px;";
			echo '<td class="modelItem" style="width:'.$width.'; padding: 7px 10px;" onclick="showContent('.$row['codenumber'].');">'
					.'<a style="height: 0px;" name="anchor_'.$anchor.'"></a>'
					. '<span class="actionLink">'
					. '<a href="#anchor_'.(($i >= 2) ? $anchor-1 : 0).'" id="car_'.$row['codenumber'].'" name="up_'.$row['codenumber'].'">'.$row['vehicle'].'</a>'
					. '</span>'
					. '</td>';
			$anchor++;
			if($SHOW_CODE_COLUMN) {
				echo '<td class="modelItemType" style="width:95px;">'.$row['badge'].'</td>';
				echo '<td class="modelItem" style="width:50px;">'.$row['body'].'</td>';
				echo '<td class="modelItem" style="width:110px;">'.$row['price'].'</td>';
				echo '<td class="modelItem" style="width:80px;">'.$row['years'].'</td>';
				echo '<td class="modelItem" style="width:80px; font-size:small; font-style: italic;">'.$row['codenumber'].'</td>';
			} else {
				echo '<td class="modelItem float" style="width:135px;">'.$row['badge'].'</td>';
				echo '<td class="modelItem float" style="width:100px;">'.$row['body'].'</td>';
				echo '<td class="modelItem float" style="width:120px;">'.$row['price'].'</td>';
				echo '<td class="modelItem float" style="width:80px;">'.$row['years'].'</td>';
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
					<th>Years</th>
					<th>Kms[x1000]</th>
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
						echo '<td class="inner" onclick="enterKm(\''.$kms.'\', \'tr_'.$row['codenumber'].'_'.$year.'\', \'km_'.$row['codenumber'].'\', \'tr_'.$row['codenumber'].'_'.$year.'\', \'year_'.$row['codenumber'].'\', \''.$year.'\', \'guide_'.$row['codenumber'].'\', \''.$grp.'\', \'fuel_'.$row['codenumber'].'\', \''.$fuel.'\', \'guideKm_'.$row['codenumber'].'\', \''.$kms.'\' , \''.$row['codenumber'].'\')"><span class="actionLink">'.$year.'</b></td>';
						echo '<td class="inner" >'.$kms.'</td>';
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
				<span class="headerColor">Notes</span><?php echo $noteMw ?> 
			</div>
		</div>
		<br />

		<div class="carForm">
			<!--div class="divider2"></div-->
			 <label>Enter Kms</label>
			<div class="form1">
			<?php            
				echo CHtml::beginForm('','',array('onsubmit'=>'return valid();'));
				echo CHtml::textField('km', '', array('class'=>'km','id'=>'km_'.$row['codenumber']));
				echo CHtml::hiddenField('year', '', array('id'=>'year_'.$row['codenumber']));
				echo CHtml::hiddenField('guide', '', array('id'=>'guide_'.$row['codenumber']));//km usera wpisane
				echo CHtml::hiddenField('guideKm', '', array('id'=>'guideKm_'.$row['codenumber']));
				echo CHtml::hiddenField('fuel', '', array('id'=>'fuel_'.$row['codenumber']));
				echo CHtml::hiddenField('carOrCom', 'UsedCarsModel');
				echo CHtml::hiddenField('codenumber', $row['codenumber']);
				echo CHtml::hiddenField('import', $importId);
				echo CHtml::hiddenField('YII_CSRF_TOKEN',Yii::app()->request->csrfToken);
				echo CHtml::button('ADJUST', array('class'=>'button1',
						'onclick'=>CHtml::ajax(array('type'=>'POST', 'url'=>array("mobile/ajaxCount"), 
						'update'=>'#value_'.$row['codenumber'].''))
					));
				echo Chtml::endForm();
			?>
			</div>
		 
			 <div class="adjustedValue">
					 <img src="images/divider.png" style="width:100%;" />
			 <label class="fontColor"></label>
			 <?php
				echo '<span id="value_'.$row['codenumber'].'" class="value">Adjusted value &#8364;';
				//pdf
				// echo '<a href="'.Yii::app()->createUrl('/mobile/generatePdf',array('m'=>'UsedCarsModel','cn'=>$row['codenumber'],'imp'=>$importId)).' target="_blank"><img src="./images/pdf.png" style="width:28px; height:28px;" alt="[pdf]" /></a>';
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
			</table>
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
?>

<?php //mobnile render here:
$lvUser = Uzytkownik::model()->find(array(
                'condition'=>'id=:id',
                'params'=>array(':id'=>Yii::app()->user->getId())
            ));
?>

<script type="text/javascript">

	function showContent(code){
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
	    document.getElementById("value_"+value_clear).innerHTML = "Adjusted value &#8364;<!--<a href=\"index.php?r=mobile/generatePdf&m=UsedCarsModel&imp='.$importId.'&cn="+value_clear+ "\" target=\"_blank\"><img src=\"./images/pdf.png\" style=\"width:28px; height:28px;\" alt=\"[pdf]\" /></a>-->";    
	}
</script>