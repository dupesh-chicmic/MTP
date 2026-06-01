<?php
/**
 * Widok w ktorym user wpisuje numer tablicy rejestracyjnej
 */

$style = "width:305px; margin:0 auto; vertical-align:top; ";
if(!empty($_GET['arch'])){
    $actionUrl = "registrationService/checkPlateNumberByRegLookUpArchive";
}else {
    $actionUrl = "registrationService/checkPlateNumberByRegLookUp";
}
?>

<?php echo CHtml::beginForm(((!$useAjax) ? Yii::app()->createUrl($actionUrl) : ''), 'POST', array('style'=>$style,'autocomplete'=>'off', 'onkeypress'=>"return event.keyCode != 13;")); ?>
<div class="checkPlateForm">
    <div class="checkPlateNumber">
        <?php echo CHtml::textField('VehicleRegNumber', '', array('id'=>'registation_no','maxlength'=>12)); ?>
    </div>
    <?php echo CHtml::hiddenField('usedCarComModel', $usedCarComModel); ?>
    <?php 
        if(!empty($_GET['arch'])){
            echo CHtml::hiddenField('arch', $_GET['arch']);
        }
    ?>
    <?php echo CHtml::hiddenField('useAjax', $useAjax); ?>
</div>
    <?php if(!$useAjax): ?>
        <?php echo CHtml::submitButton('Get Valuation',array(
                                        'class'=>'button1',
                                        'id'=>'registation_no_button')); ?>
    <?php else: ?>
        <?php
            echo CHtml::button('Get Valuation', array('class'=>'button1', 
                'id'=>'registation_no_button',
                'onclick'=>CHtml::ajax(array('type'=>'POST', 'url'=>array($actionUrl), 
                'update'=>'#carInfo',
//                'beforeSend' => 'function() { $("body").addClass("loading"); }',
                'complete' => 'function() { window.top.sendHeight(); }'
                    ))
            ));
        ?>       
    <?php endif; ?>
<script>
//$(document).on("keypress", "form", function(event) { 
//    return event.keyCode != 13;
//});
$('#registation_no').keydown(function (e){
    if(e.keyCode == 13){
        $( "#registation_no_button" ).trigger( "click" );
    }else {
        return e.keyCode;
    }
})
</script>
<?php echo CHtml::endForm(); ?>