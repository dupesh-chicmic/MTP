<div>ref#(Order ID): <?php echo $qpayRequest->id; ?></div>
<br/>
<b>Motor Trade Publishers</b><br/><br/>
<?php echo CmsDictionary::model()->dictionaryGetText('front_footer_address'); ?>
<br/>
<?php echo CmsDictionary::model()->dictionaryGetText('front_footer_phone'); ?>
<br/>
<?php echo CmsDictionary::model()->dictionaryGetText('front_footer_email'); ?>
<br/>
Web: www.mtp.ie<br/>
Vat # IE 8272252S<br/>

<br/>
PAYMENT DETAILS:<br/>
<div>Date: <?php echo $qpayRequest->timestamp; ?></div>
<?php $this->renderPartial('_viewPaymentDetails', array('qpayRequest'=>$qpayRequest));