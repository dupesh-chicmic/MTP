<?php
class RealexController extends Controller
{
	public function init()
	{
		Yii::app()->getModule('qpay')->getModule('qpayrealex');
		parent::init();
	}

	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('payInvoice','handleResponse', 'testHandleResponse', 'testSha', 'getReceiptPDF'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('viewPayments'),
				'users'=>array('admin'),
			),
			array('deny'),
		);
	}

	public function actionPayInvoice()
	{
        // odroznienie glownego layoutu web/mobile 
        //$this->layout = Controller::getLayoutDevice();
            
        $this->layout = 'iframeFoundation';
	    $model=new InvoiceRealexForm;

	    if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-realex-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }

	    if(isset($_POST['InvoiceRealexForm']))
	    {
	        $model->attributes=$_POST['InvoiceRealexForm'];
	        if($model->validate())
	        {
	            if($model->save())
	            {
	            	$this->render('realexForm', array(
                        'realexRequest'=>$model->realexRequest,
                        'showBackButton'=>((Yii::app()->mobileDetect->isMobile() || Yii::app()->mobileDetect->isTablet()) ? false : true)
                    ));
	            	Yii::app()->end();
	            }
	        }
	    }
	   	$this->render('invoiceForm', array('model'=>$model));
	}

	public function actionHandleResponse()
	{
            $this->layout = 'iframeFoundation';
		$realexRequest=Yii::app()->getModule('qpay')->currentRequest;
                
                
		Yii::trace('/realex/handleResponse triggered for request id='.CHtml::value($realexRequest, 'order_id', 'not given'), 'realex');
		if($realexRequest)
		{
			MRealexRequest::handleResponse($realexRequest);
			$this->renderPartial('viewParseRealexResponse', array('realexRequest'=>$realexRequest));
		}
		else
			throw new Exception('Invalid request');
	}
        
        public function actionTestHandleResponse($id)
	{
            $this->layout = 'iframeFoundation';
		//good $realexRequest=Yii::app()->getModule('qpay')->currentRequest;
                $realexRequest=QPayRealexRequest::model()->with('request.invoices')->findAllByAttributes(array('order_id'=>$_GET['id']));
                $realexRequest = $realexRequest[0];
                //$realexRequest->isSuccessful=true;
		Yii::trace('/realex/handleResponse triggered for request id='.CHtml::value($realexRequest, 'order_id', 'not given'), 'realex');
		if($realexRequest)
		{
			MRealexRequest::handleResponse($realexRequest);
			$this->renderPartial('viewParseRealexResponse', array('realexRequest'=>$realexRequest));
		}
		else
			throw new Exception('Invalid request');
	}

	public function actionViewPayments()
	{
		$request=new QPayRequest('search');

		if(isset($_GET['QPayRequest']))
			$request->attributes=$_GET['QPayRequest'];

		$request->status=QPayRequest::STAT_COMPLETED;
		$provider=$request->search();

		$invoice=new Invoice('search');
		if(isset($_GET['Invoice']))
		{
			$invoice->attributes=$_GET['Invoice'];
			$invoice->setTableAlias('invoices');
			$invoiceProvider=$invoice->search();
			$provider->criteria->mergeWith($invoiceProvider->criteria);
			$provider->criteria->mergeWith(array(
				'with'=>array('invoices'=>array('select'=>false)),
				'together'=>true
			));
		}

		$this->render('viewRealexPayments', array('provider'=>$provider, 'filter'=>$request, 'filterInvoice'=>$invoice));
	}

	public function actionGetReceiptPDF()
	{
		if(isset($_GET['qpayRequestID'], $_GET['token']))
		{
                    $qpayRealexRequest=QPayRealexRequest::model()->with('request.invoices')->findAllByAttributes(array('order_id'=>$_GET['qpayRequestID'], 'sha1hash'=>$_GET['token']));
                    //$qpayRealexRequest=QPayRealexRequest::model()->with('request.invoices')->findAllByAttributes(array('order_id'=>$_GET['qpayRequestID']));
			if(!empty($qpayRealexRequest))
			{
				$qpayRealexRequest=reset($qpayRealexRequest);
				$this->renderPartial('_echoReceipt', array('qpayRequest'=>$qpayRealexRequest->request));
			}
			else
				throw new Exception('Payment not found.');
		}
		else
			throw new Exception('Required parameters not given.');
	}
        
        public function actionTestSha()
        {            
                 
                $fp = fsockopen ('ssl://realcontrol2-0.sandbox.realexpayments.com', 443, $errno, $errstr, 30);   
                
                //$fp = fsockopen ("slashdot.org", 80);

                if ($fp) {
                    fwrite($fp, "GET / HTTP/1.1\r\nHOST: realcontrol2-0.sandbox.realexpayments.com/login\r\n\r\n");

                    while (!feof($fp)) {
                        print fread($fp,256);
                    }

                    fclose ($fp);
                } else {
                    print "Fatal error\n";
                }
                
//                var_dump($fp);
//                exit;
        }
        
        
        
   
}