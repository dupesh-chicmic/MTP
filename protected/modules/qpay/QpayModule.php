<?php
class QpayModule extends CWebModule
{
	public $currentRequest;

	public function init()
	{
		$this->setImport(array(
			'qpay.models.*',
			//'qpay.components.*',
		));
		parent::init();
	}
}
