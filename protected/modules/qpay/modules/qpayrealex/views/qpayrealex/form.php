<h2>Realex request about to be send with given data:</h2>
<pre><?php var_dump($realexRequest->attributes); ?></pre>
<?php echo QPayRealexHtml::form($realexRequest);?>
<h2>Simulate realex response</h2>
<?php echo CHtml::beginForm(array('response')); ?>
<?php $postData=array(
'RESULT' => '00',
'AUTHCODE' => '12345',
'MESSAGE' => '[ test system ] Authorised',
'PASREF' => '14048015755629962',
'AVSPOSTCODERESULT' => 'M',
'AVSADDRESSRESULT' => 'M',
'CVNRESULT' => 'M',
'ACCOUNT' => 'internet',
'MERCHANT_ID' => 'motortradepublishers',
'ORDER_ID' => '31',
'TIMESTAMP' => '20140708073923',
'AMOUNT' => '100',
'MERCHANT_RESPONSE_URL' => 'http://www.mtp.ie/test/index.php?r=qpay/realex/response',
'SHA1HASH' => '39928e6064b92ccd56281dc354d5f9df1e2051ea',
'submit' => 'Click here to purchase',
'BATCHID' => '-1',
);
$formDataHtml='';
foreach($postData as $name=>$value)
	$formDataHtml.=CHtml::hiddenField($name, $value);
echo $formDataHtml;
echo CHtml::submitButton('Simulate');
echo CHtml::endForm();