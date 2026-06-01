<?php
/*
 * Szczegolowy widok danych dla konkretnego modelu
 */
?>
<table style="padding:7px; background-color:#fff; width:100%;">
    
    <tr style="text-align: center;"><td><b style="color:#68B5C2;"><?php echo $nazwa_importu ?></b></td></tr>
    
    <tr><td><b>Model: </b><?php echo $data['maker'].' '.$data['vehicle']; ?></td></tr>
    <tr><td class="tableRow"><b>Type: </b><?php echo $data['badge']; ?></td></tr>
    <tr><td class="tableRow"><b>Body: </b><?php echo $data['body']; ?></td></tr>
    <tr><td class="tableRow"><b>LRP/CRP: </b><?php echo $data['price']; ?></td></tr>
    <tr><td class="tableRow"><b>From/To: </b><?php echo $data['years']; ?></td></tr>
    
</table>

<table style="padding:7px; background-color:#fff; width:100%;">
    <thead style="background-color: #e8eae5;">
        <tr><td class="tableRow"><b>Engine:</b></td></tr>
    </thead>
    
<?php
    for($spe=1;$spe<5;$spe++)
    {
        if($data['spec'.$spe]!="")
        {
            echo '<tr><td>'.$data['spec'.$spe].'</td></tr>';
        }
    }
?>
    
    <thead style="background-color: #e8eae5;">
        <tr><td class="tableRow"><b>Introduced/Modified:</b></td></tr>
    </thead>    
<?php    
    for($int=1;$int<6;$int++)
    {
        if($data['intro'.$int]!="")
        {
            echo '<tr><td>'.$data['intro'.$int].'</td></tr>';
        }
    }    
?>
    <thead style="background-color: #e8eae5;">
        <tr><td class="tableRow"><b>Notes:</b></td></tr>
    </thead>        
<?php
    for($not=1;$not<6;$not++)
    {
        if($data['note'.$not]!="")
        {
            echo '<tr><td>'.$data['note'.$not].'</td></tr>';
        }
    }
?>
</table>


<table class="cars_model_table" style="padding:7px; background-color:#fff; width:100%;">
    <thead style="background-color: #e8eae5;">
    <tr>
        <td class="tableRow"><b>Years: </b></td>
        <td class="tableRow"><b>Kms: </b></td>
        <td class="tableRow"><b>Guide €: </b></td>
    </tr>
    </thead>
    <tbody>
        <?php
            $codeNumberSearch = $data['codenumber'];
            
            for($i=0; $i<=15; $i++)
            {
                if(empty($data['yr'.$i]) && empty($data['kms'.$i]) && empty($data['GRP'.$i]))
                    continue;
                
                    echo '<tr id="tr_'.$codeNumberSearch.'_'.$data['yr'.$i].'">';
                    echo '<td>';
                    echo '<button class="actionLink" id="tr_'.$codeNumberSearch.'_'.$data['yr'.$i].'">'.$data['yr'.$i].'</button>';
                    echo '<td>'.$data['kms'.$i].'</td>';
                    echo '<td>'.$data['GRP'.$i].'</td>';
                    echo '</tr>';
                    echo '<script type="text/javascript">
                            $(\'#tr_'.$codeNumberSearch.'_'.$data['yr'.$i].'\').click(function( event ) {
                                $(\'#tr_'.$codeNumberSearch.'_'.$data['yr'.$i].'\').siblings().removeClass("activeTr");                                
                                enterKm(\''.$data['kms'.$i].'\', \'km_'.$codeNumberSearch.'\', \'tr_'.$codeNumberSearch.'_'.$data['yr'.$i].'\', \'year_'.$codeNumberSearch.'\', \''.$data['yr'.$i].'\', \'guide_'.$codeNumberSearch.'\', \''.$data['GRP'.$i].'\', \'fuel_'.$codeNumberSearch.'\', \''.$data['fuel'].'\', \'guideKm_'.$codeNumberSearch.'\', \''.$data['kms'.$i].'\');
                                document.getElementById("ajaxUpdateDiv").innerHTML = "Adjusted value &#8364;<!--<a href=\"index.php?r=member/generatePdf&m='.$carOrCom.'&imp='.$import_id.'&cn='.$codeNumberSearch.'\"><img src=\"./images/pdf.png\" style=\"border:none; width:28px; height:28px;\" alt=\"[pdf]\" /></a>-->";    
                            });
                         </script>';
            }
            
        ?>
    </tbody>
</table>    

<?php // ODOMETER CALCULATIONS ?>
<script type="text/javascript">
        function enterKm(km, formKmId, trId_zaznacz, formYearId, year, formUserKmId, UserKm, formFuelId, fuel, formGuideKmId, guideKm)
        {
            var x = document.getElementById(formKmId).value = km;
            var year = document.getElementById(formYearId).value = year;
            var guideUsr = document.getElementById(formUserKmId).value = UserKm;
            var guideKm = document.getElementById(formGuideKmId).value = guideKm;
            var fuel = document.getElementById(formFuelId).value = fuel;
            document.getElementById(trId_zaznacz).className = "activeTr"; // zaznacza klikniety element
        }
</script>

<?php
echo '<div class="carForm">
    <div class="divider2"></div>
     <label>Select year to adjust kilometre reading and value.</label>
    <div class="form1">';
echo CHtml::beginForm('','',array('onsubmit'=>'return valid();'));
echo CHtml::textField('km', '', array('class'=>'km','id'=>'km_'.$codeNumberSearch));
echo CHtml::hiddenField('year', '', array('id'=>'year_'.$codeNumberSearch));
echo CHtml::hiddenField('guide', '', array('id'=>'guide_'.$codeNumberSearch));//km usera wpisane
echo CHtml::hiddenField('guideKm', '', array('id'=>'guideKm_'.$codeNumberSearch));
echo CHtml::hiddenField('fuel', '', array('id'=>'fuel_'.$codeNumberSearch));
echo CHtml::hiddenField('carOrCom', $carOrCom); // OR COMMERCIAL!
echo CHtml::hiddenField('codenumber', $codeNumberSearch);
echo CHtml::hiddenField('isMobileCall', 1);
echo CHtml::hiddenField('YII_CSRF_TOKEN',Yii::app()->request->csrfToken);
echo CHtml::hiddenField('import', $import_id);
echo '<br />';
echo CHtml::button('ADJUST', array('id'=>'doIt','class'=>'button1',
//'onclick'=>CHtml::ajax(array('type'=>'POST', 'url'=>array("mobile/ajaxOdometerCalc"), 
//'update'=>'#ajaxUpdateDiv'))
    ));
echo Chtml::endForm();
?>
<script type="text/javascript">
    $('#doIt').click(function( event ) {
            jQuery.ajax({'type':'POST','url':'index.php?r=mobile/ajaxOdometerCalc','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#ajaxUpdateDiv").html(html); window.parent.sendHeight();}});
        }
    );    
</script>
<?php
echo '</div>';
echo '</div>';

echo '<div class="adjustedValue">
<span id="ajaxUpdateDiv" class="value">Adjusted value &#8364;';
//pdf
    //echo '<a href="index.php?r=member/generatePdf&m='.$carOrCom.'&cn='.$codeNumberSearch.'&imp='.$import_id.'"><img src="./images/pdf.png" style="border:none; width:28px; height:28px;" alt="[pdf]" /></a>';
echo '</span>
</div>'; 
?>