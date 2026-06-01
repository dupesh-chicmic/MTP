<?php
class InvoiceRealexForm extends CFormModel
{
	public $invoice1;
	public $invoice2;
	public $invoice3;
	public $invoice4;
	public $totalGrossAmount;
	public $ac;
	private $_realexRequest;
	private $_invoices;

	public function init()
	{
		Yii::app()->getModule('qpay')->getModule('qpayrealex');
		parent::init();
	}

	public function rules()
	{
		return array(
			array('ac, invoice1, invoice2, invoice3, invoice4', 'filter', 'filter'=>'trim'),
			array('ac, invoice1, totalGrossAmount', 'required'),
			array('ac', 'numerical', 'integerOnly'=>true, 'min'=>1, 'message'=>'Numbers only'),
			array('invoice1, invoice2, invoice3, invoice4', 'numerical', 'integerOnly'=>true, 'min'=>37000, 'message'=>'This number is invalid', 'tooSmall'=>'This number is invalid'),
			array('totalGrossAmount', 'numerical', 'min'=>0.01),
		);
	}

	public function attributeLabels()
	{
		return array(
			'invoice1'=>'Invoice Number 1',
			'invoice2'=>'Invoice Number 2',
			'invoice3'=>'Invoice Number 3',
			'invoice4'=>'Invoice Number 4',
			'totalGrossAmount'=>'Total gross amount',
			'ac'=>'A/c No',
		);
	}

	public function save($runValidation=true, $attributes=null)
	{
 		if(!$runValidation || $this->validate($attributes))
 		{
 			$dbTrans=Yii::app()->db->beginTransaction();
 			$invoices=array();
 			for($i=1; $i<5; $i++)
 			{
 				$t='invoice'.$i;
 				$invoiceNo=$this->$t;

 				if($invoiceNo)
 				{
	 				if($invoice=Invoice::model()->findByAttributes(array('no'=>$invoiceNo)))
	 				{
	 					if($invoice->status==Invoice::STAT_PAID)
	 					{
	 						$this->addError('invoiceNos', 'Invoice no '.$invoice->no.' is already paid. Please remove it from list.');
	 						return false;
	 					}
	 				}
	 				else
	 				{
		 				$invoice=new Invoice;
		 				$invoice->setAttributes(array(
		 					'no'=>$invoiceNo,
		 					'status'=>Invoice::STAT_TOPAY,
		 					'bp_id'=>$this->ac,
		 				));
	 					$invoice->save(false);
	 				}
	 				$invoices[]=$invoice;
 				}
 			}

 			$this->_invoices=$invoices;

 			$realexRequest=new QPayRealexRequest;
 			$realexRequest->setAttributes(array(
 				'var_ref'=>'Invoices-'.$this->implodeInvoiceNos(),
 				'cust_num'=>$this->ac,
 				'amount'=>$this->totalGrossAmount
 			));

 			if(!$realexRequest->makeRequest())
 			{
 				Yii::log('Realex local error making new request: '.var_export($realexRequest->errors, true), 'error', 'qpay');
 				$this->addError('', 'An internal error accured. Transaction has been canceled. Administrator wil be notified about this problem. Please try agan later.');
 			}

 			$this->_realexRequest=$realexRequest;

 			foreach($invoices as $invoice)
 			{
 				$t=new InvoiceQPayRequest;
 				$t->setAttributes(array(
					'invoice_id'=>$invoice->id,
					'qpay_request_id'=>$realexRequest->order_id
 				));
 				$t->invoice=$invoice;
 				$t->qpayRequest=$realexRequest->request;
 				$realexRequest->request->addRelatedRecord('invoiceQPayReqests', $t, true);
 				$invoice->addRelatedRecord('qpayRequests', $t, $realexRequest->order_id);
 				$t->save(false);
 			}

 			if(!($hasErrors=$this->hasErrors()))
	 			$dbTrans->commit();
 			else
 				$dbTrans->rollback();
 			return !$hasErrors;
 		}
 		else
 			return false;
	}

	public function getRealexRequest()
	{
		return $this->_realexRequest;
	}

	public function getInvoices()
	{
		return $this->_invoices;
	}

	public function implodeInvoiceNos()
	{
		$invoices[]=$this->invoice1;
		if($this->invoice2)
			$invoices[]=$this->invoice2;
		if($this->invoice3)
			$invoices[]=$this->invoice3;
		if($this->invoice4)
			$invoices[]=$this->invoice4;

		return implode(',', $invoices);
	}
}