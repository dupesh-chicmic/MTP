<div class="view_realexForm" id="contactPage">
	<h4 class="white">Please check the invoice(s) details below before proceeding:</h4>
	<?php $this->renderPartial('_viewPaymentDetails', array('qpayRequest'=>$realexRequest->request)); ?>
	<br/>
	<?php echo QPayRealexHtml::form($realexRequest, '', 'Proceed',array('class'=>'button1','style'=>'font-size:9px;')); ?><br/>
    <?php if($showBackButton): ?>
	<!--<?php echo CHtml::link('Return to the main site', Yii::app()->createAbsoluteUrl('/'),array('style'=>'color:#3E8D9E;')); ?>-->
    <?php endif;?>
</div>