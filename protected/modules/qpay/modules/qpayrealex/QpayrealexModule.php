<?php
class QpayRealexModule extends CWebModule
{
	//public $responseRoute='handleResponse';
        //public $responseRoute='http://mtp.ie/app/index.php?r=/realex/handleResponse';
    public $responseRoute='http://mtp.ie/app/index.php?r=realex/HandleResponse';
        

	public function init()
	{
		$this->setImport(array(
			'qpayrealex.models.*',
			'qpayrealex.components.*',
		));
	}

	public function setCurrentRequest($request)
	{
		$this->getParentModule()->currentRequest=$request;
	}

	public function getCurrentRequest()
	{
		return $this->getParentModule()->currentRequest;
	}
}
