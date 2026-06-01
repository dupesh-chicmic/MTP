<?php if($realexRequest->isSuccessful): ?>
<h4 style="color:#ffc63d;">Thank you! Your payment has been processed.<br/>Thank you for using our online payment facility.</h4>
<br/>
<?php $this->renderPartial('_viewReceipt', array('qpayRequest'=>$realexRequest->request)); ?>
<br/>
<?php echo CHtml::link('Get receipt as PDF', Yii::app()->createAbsoluteUrl('/realex/getReceiptPDF', array('qpayRequestID'=>$realexRequest->order_id, 'token'=>$realexRequest->sha1hash)), array('target'=>'_blank', 'style'=>'color:#ffc63d; ')); ?>
<?php else: ?>
	<?php if($realexRequest->isCanceled): ?>
		<h2>Your payment has been cancelled</h2><br/>
	<?php else: ?>
		<h2>An error occurred during payment transaction.<br/>Please try again.</h2><br/>
		Error details:<br/>
		<?php echo $realexRequest->message; ?><br/>
	<?php endif; ?>
	<br/>
	<h3>Payment details:</h2>
	<?php $this->renderPartial('_viewPaymentDetails', array('qpayRequest'=>$realexRequest->request)); ?>
<?php endif; ?>
<br/><br/>
<?php echo CHtml::link('Back to main Page', 'http://mtp.ie', array('style'=>'color:#ffc63d; ')); ?>
    <?php 
    //echo CHtml::link('Perform another payment >>>', Yii::app()->createAbsoluteUrl('/realex/payInvoice'));?>
    

