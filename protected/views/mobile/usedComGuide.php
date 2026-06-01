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
$allCars = UsedComCars::model()->findAll($criteria);

if (!isset($_GET['make'])){
    $headerTitle = $allCars[0]['name'];
}
$range = null;
$usedCarsRanges = array();
if(!empty($_GET['rangecode'])){
    $range = $_GET['rangecode'];
    $usedCarsRanges = UsedCommsRanges::getUsedCommsRanges($importId);
}else{
    $usedCarsRanges = UsedCommsRanges::getUsedCommsRanges($importId);
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
              'type'=>'commercial'
            ));
?>

<div class="contentContainer">
<?php
//if(!Yii::app()->user->getIsCheckOnly()){
//    // Risk Inteligence 'plate'
//    echo $this->renderPartial('//registrationService/_checkPlateNumber', 
//            array('model'=>$model,
//                  'usedCarComModel'=>'UsedComCarsModel',
//                  'importId'=>$importId,
//                  'checkByRegLookUp'=>false
//                ));
//}
?> 
<div class="carTable" style="">
	<div class="modal_top">
		<span style="text-align:center; color:#ffd800; font-weight: bolder; float:left;"><?php echo $headerTitle; ?></span>
		<span style="text-align:center; color:#ffd800; font-weight: bolder; float:left;"><?php echo $tableTitle;?></span>
		<span style="font-size: smaller; text-align:center; color:#ffd800; font-weight: bolder; float:left;">Please click on Model description for valuation details. </span>
		<a style="float:left; height: 0px;" name="anchor_0"></a>
	</div>
	<div class="table-responsive">
		<table >
		<tr id="headItems">
			<?php if($SHOW_CODE_COLUMN): ?>
				<th class="header" style="width:220px;">Model</th>
				<th class="header" style="width:80px;">Type</th>
				<th class="header" style="width:65px;">Body</th>
				<th class="header" style="width:105px;">LRP/CRP</th>
				<th class="header" style="width:80px;">From/To</th>
				<th class="header" style="width:80px;">Code</th>
			<?php else: ?>
				<th class="header" style="width:260px;">Model</th>
				<th class="header" style="width:95px;">Type</th>
				<th class="header" style="width:75px;">Body</th>
				<th class="header" style="width:110px;">LRP/CRP</th>
				<th class="header" style="width:80px;">From/To</th>        
			<?php endif; ?>
		</tr>
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
			if($row['corecode'] != '') {
				continue;
			}
			
			echo '<tr id="model" id="up_'.$row['codenumber'].'">';
			echo '<a style="height: 0px;" name="anchor_'.$anchor.'"></a>';
			$width = ($SHOW_CODE_COLUMN) ? "210px;": "240px;";
			echo '<td class="modelItem" style="width:'.$width.' padding: 7px 10px;" onclick="showContent('.$row['codenumber'].');">'
					.'<a style="height: 0px;" name="anchor_'.$anchor.'"></a>'
					. '<span class="actionLink">'
					. '<a href="#anchor_'.(($i >= 2) ? $anchor-1 : 0).'" id="car_'.$row['codenumber'].'" name="up_'.$row['codenumber'].'">'.$row['vehicle'].'</a>'
					. '</span>'
					. '</td>';
				$anchor++;
				if($SHOW_CODE_COLUMN) {
					echo '<td class="modelItem" style="width:80px;">'.$row['badge'].'</td>';
					echo '<td class="modelItem" style="width:50px;">'.$row['body'].'</td>';
					echo '<td class="modelItem" style="width:110px;">'.$row['price'].'</td>';
					echo '<td class="modelItem" style="width:70px;">'.$row['years'].'</td>';
					echo '<td class="modelItem" style="width:80px; font-size:small; font-style: italic;">'.$row['codenumber'].'</td>';
				} else {
					echo '<td class="modelItem float" style="width:85px;">'.$row['badge'].'</td>';
					echo '<td class="modelItem float" style="width:60px;">'.$row['body'].'</td>';
					echo '<td class="modelItem float" style="width:105px;">'.$row['price'].'</td>';
					echo '<td class="modelItem float" style="width:70px;">'.$row['years'].'</td>';
				}
				$fuel = $row['fuel'];                
			echo '</tr>';
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
            <span class="headerColor">Introduced/Modified</span><br /><?php echo $introMw ?><br />
            <span class="headerColor">Notes</span><?php echo $noteMw ?>
        </div>
    </div>
    <br />

<?php
    echo '<div class="carForm">
        <!--div class="divider2"></div-->
         <label>Enter Kms</label>
        <div class="form1">';
    echo CHtml::beginForm('','',array('onsubmit'=>'return valid();'));
    echo CHtml::textField('km', '', array('class'=>'km','id'=>'km_'.$row['codenumber']));
    echo CHtml::hiddenField('year', '', array('id'=>'year_'.$row['codenumber']));
    echo CHtml::hiddenField('guide', '', array('id'=>'guide_'.$row['codenumber']));//km usera wpisane
    echo CHtml::hiddenField('guideKm', '', array('id'=>'guideKm_'.$row['codenumber']));
    echo CHtml::hiddenField('fuel', '', array('id'=>'fuel_'.$row['codenumber']));
    echo CHtml::hiddenField('carOrCom', 'UsedComCarsModel');
    echo CHtml::hiddenField('codenumber', $row['codenumber']);
    echo CHtml::hiddenField('import', $importId);
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
         <span id="value_'.$row['codenumber'].'" class="value">Adjusted value &#8364;';
         //pdf
        //echo '<a href="'.Yii::app()->createUrl('/mobile/generatePdf',array('m'=>'UsedComCarsModel','cn'=>$row['codenumber'],'imp'=>$importId)).'"><img src="./images/pdf.png" style="width:28px; height:28px;" alt="[pdf]" /></a>';
             echo '</span>
         </div>'; 
    echo '</div>';
    echo '</div>';

    $i++;
}//end forech
        }// end if model is empty condition
?>
	</table>
		</div> 
	</div>
</div>

<?php
$enterKmForm = 
'';

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
        document.getElementById("value_"+value_clear).innerHTML = "Adjusted value &#8364;<!--<a href=\"index.php?r=mobile/generatePdf&m=UsedComCarsModel&imp='.$importId.'&cn="+value_clear+ "\"><img src=\"./images/pdf.png\" style=\"width:28px; height:28px;\" alt=\"[pdf]\" /></a>-->";    
    }
</script>