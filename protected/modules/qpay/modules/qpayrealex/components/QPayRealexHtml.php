<?php
class QPayRealexHtml
{
	public static function form($realexRequest, $additionalFormHtml='', $submitLabel='Click here to purchase', $submitHtmlOptions=array())
	{
		$sett=$realexRequest->settings;
		if(!isset($submitHtmlOptions['name']))
			$submitHtmlOptions['name']='submit';

		return
			CHtml::beginForm($sett->get('qpay.realex', $sett->get('qpay.realex', 'test mode')?'test hosted payment page URL':'hosted payment page URL'), 'post')
			.CHtml::hiddenField('MERCHANT_ID', $sett->get('qpay.realex', 'merchant ID'))
			.CHtml::hiddenField('ORDER_ID', $realexRequest->order_id)
			.CHtml::hiddenField('ACCOUNT', $realexRequest->account)
			.CHtml::hiddenField('AMOUNT', $realexRequest->amount)
			.CHtml::hiddenField('CURRENCY', $realexRequest->currency)
			.CHtml::hiddenField('TIMESTAMP', $realexRequest->timestamp)
			.CHtml::hiddenField('SHA1HASH', $realexRequest->sha1hash)
			//.CHtml::hiddenField('AUTO_SETTLE_FLAG', $realexRequest->auto_settle_flag)
                        .CHtml::hiddenField('AUTO_SETTLE_FLAG', 1)
			.CHtml::hiddenField('VAR_REF', $realexRequest->var_ref)
			.CHtml::hiddenField('CUST_NUM', $realexRequest->cust_num)
                        //.CHtml::hiddenField('MERCHANT_RESPONSE_URL', 'http://mtp.ie/app/index.php?r=qpay/qpayrealex/qpayrealex/response')
                        //.CHtml::hiddenField('MERCHANT_RESPONSE_URL', 'http://mtp.ie/app/index.php?r=realex/handleResponse')Was on 2016-05-18 - wasnt working 
			.($realexRequest->merchant_response_url?CHtml::hiddenField('MERCHANT_RESPONSE_URL', $realexRequest->merchant_response_url):'')
			.CHtml::submitButton($submitLabel, $submitHtmlOptions)
			.$additionalFormHtml
			.CHtml::endForm();
	}
}