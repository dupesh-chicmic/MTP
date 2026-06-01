<?php
/**
 * This is the model class for table "qpay_realex_request".
 *
 * The followings are the available columns in table 'qpay_realex_request':
 * @property integer $order_id
 * @property string $account
 * @property string $currency
 * @property integer $amount
 * @property string $timestamp
 * @property string $sha1hash
 * @property integer $auto_settle_flag
 * @property string $comment1
 * @property string $comment2
 * @property integer $return_tss
 * @property string $shipping_code
 * @property string $shipping_co
 * @property string $billing_cod
 * @property string $cust_num
 * @property string $var_ref
 * @property string $prod_id
 * @property string $hpp_lang
 * @property string $merchant_response_url
 * @property string $card_payment_button
 * @property string $authcode
 * @property string $result
 * @property string $message
 * @property string $cvnresult
 * @property string $pasref
 * @property integer $batchid
 * @property string $eci
 * @property string $cavv
 * @property string $xid
 * @property string $tss
 * @property string $tss_idnum
 */
class QPayRealexRequest extends CActiveRecord
{
	public $settings;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qpay_realex_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('merchant_id, currency, amount, timestamp, order_id, sha1hash', 'required'),
			//array('sha1hash', 'required', 'on'=>'request, response'),
			array('auto_settle_flag, return_tss, batchid', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical', 'integerOnly'=>true, 'min'=>1),
			array('account, shipping_code, authcode, pasref, eci, cavv, xid, tss, tss_idnum', 'length', 'max'=>30),
			array('currency, cvnresult', 'length', 'max'=>3),
			array('timestamp', 'length', 'min'=>14, 'max'=>14),
			array('sha1hash', 'length', 'max'=>40),
			array('comment1, comment2, merchant_response_url, message', 'length', 'max'=>255),
			array('merchant_id, shipping_co, billing_cod, cust_num, var_ref, prod_id', 'length', 'max'=>50),
			array('hpp_lang', 'length', 'max'=>2),
			array('card_payment_button', 'length', 'max'=>25),
			array('result', 'length', 'max'=>10),
			//array('prod_id, cust_num, var_ref', 'match', 'pattern'=>'^[0-9a-zA-Z\–“”_\.,\+@]+$'),
			array('merchant_id, account, order_id, timestamp, auto_settle_flag, comment1, comment2, return_tss, shipping_code, shipping_co, billing_code, billing_co, cust_num, var_ref, prod_id, hpp_lang, merchant_response_url, card_payment_button', 'unsafe', 'on'=>'response'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'request'=>array(self::BELONGS_TO, 'QPayRequest', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'order_id' => 'Order',
			'account' => 'Account',
			'currency' => 'Currency',
			'amount' => 'Amount',
			'timestamp' => 'Timestamp',
			'sha1hash' => 'Sha1hash',
			'auto_settle_flag' => 'Auto Settle Flag',
			'comment1' => 'Comment1',
			'comment2' => 'Comment2',
			'return_tss' => 'Return Tss',
			'shipping_code' => 'Shipping Code',
			'shipping_co' => 'Shipping Co',
			'billing_cod' => 'Billing Cod',
			'cust_num' => 'Cust Num',
			'var_ref' => 'Var Ref',
			'prod_id' => 'Prod',
			'hpp_lang' => 'Hpp Lang',
			'merchant_response_url' => 'Merchant Response Url',
			'card_payment_button' => 'Card Payment Button',
			'authcode' => 'Authcode',
			'result' => 'Result',
			'message' => 'Message',
			'cvnresult' => 'Cvnresult',
			'pasref' => 'Pasref',
			'batchid' => 'Batchid',
			'eci' => 'Eci',
			'cavv' => 'Cavv',
			'xid' => 'Xid',
			'tss' => 'Tss',
			'tss_idnum' => 'Tss Idnum',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
/*	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('timestamp',$this->timestamp,true);
		$criteria->compare('sha1hash',$this->sha1hash,true);
		$criteria->compare('auto_settle_flag',$this->auto_settle_flag);
		$criteria->compare('comment1',$this->comment1,true);
		$criteria->compare('comment2',$this->comment2,true);
		$criteria->compare('return_tss',$this->return_tss);
		$criteria->compare('shipping_code',$this->shipping_code,true);
		$criteria->compare('shipping_co',$this->shipping_co,true);
		$criteria->compare('billing_cod',$this->billing_cod,true);
		$criteria->compare('cust_num',$this->cust_num,true);
		$criteria->compare('var_ref',$this->var_ref,true);
		$criteria->compare('prod_id',$this->prod_id,true);
		$criteria->compare('hpp_lang',$this->hpp_lang,true);
		$criteria->compare('merchant_response_url',$this->merchant_response_url,true);
		$criteria->compare('card_payment_button',$this->card_payment_button,true);
		$criteria->compare('authcode',$this->authcode,true);
		$criteria->compare('result',$this->result,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('cvnresult',$this->cvnresult,true);
		$criteria->compare('pasref',$this->pasref,true);
		$criteria->compare('batchid',$this->batchid);
		$criteria->compare('eci',$this->eci,true);
		$criteria->compare('cavv',$this->cavv,true);
		$criteria->compare('xid',$this->xid,true);
		$criteria->compare('tss',$this->tss,true);
		$criteria->compare('tss_idnum',$this->tss_idnum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}*/

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QpayRealexRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function generateSHA1Hash()
	{
		return sha1(sha1($this->timestamp.'.'.$this->merchant_id.'.'.$this->order_id.'.'.$this->amount.'.'.$this->currency).'.'.Yii::app()->settings->get('qpay.realex', 'shared secret'));
	}

	public function validateResponseSHA1Hash($responseSHA1Hash)
	{
		return sha1(sha1($this->timestamp.'.'.$this->merchant_id.'.'.$this->order_id.'.'.$this->result.'.'.$this->message.'.'.$this->pasref.'.'.$this->authcode).'.'.Yii::app()->settings->get('qpay.realex', 'shared secret'))==$responseSHA1Hash;
	}

	public function getSettings()
	{
		if($this->settings===null)
			$this->settings=Yii::app()->settings;
		return $this->settings;
	}

	public function parseResponse($responseData)
	{
		$this->setScenario('response');

		$parsedResponseData=array_change_key_case($responseData);

		$mustMatch=array('account', 'merchant_id', 'order_id', 'timestamp', 'merchant_response_url');
		foreach($mustMatch as $match)
		{
			if(!isset($parsedResponseData[$match])||$this->$match!=$parsedResponseData[$match]){
                            Yii::log("Field ".$match." does not match original request\n", 'info', 'qpay');
                            $this->addError($match, "Field '$match' does not match original request");
                        }
				
			unset($parsedResponseData[$match]);
		}

		if($this->hasErrors()){
                    Yii::log("Error - MUST MATCH didn't match:\n", 'info', 'qpay');
                  //  var_dump($this->getErrors());
                    
                    return false;
                }
			

		//ignoring not documented values
		unset($parsedResponseData['avspostcoderesult'], $parsedResponseData['avsaddressresult'], $parsedResponseData['submit']);

		$this->setAttributes($parsedResponseData);
		if($this->validate())
		{
			if(!$this->validateResponseSHA1Hash($parsedResponseData['sha1hash'])){
                            Yii::log("Didn't validatedSHA1Hash:\n", 'info', 'qpay');
                            $this->addError('sha1hash', 'Not authorized response.');
                        }				
			else{
                            $this->request->saveAttributes(array('status'=>QPayRequest::STAT_COMPLETED, 'timestamp'=>date_create()->format('Y-m-d G:i:s')));
                        }
				
		}else {
                     Yii::log("Didn't validated:\n", 'info', 'qpay');
                }
		return !$this->hasErrors();
	}

	public function hasResponse()
	{
		return strlen($this->authcode)>0;
	}

	public function makeRequest()
	{
		if($this->hasResponse())
			$this->addError('order_id', 'This request is already processed.');

		if($this->hasErrors())
			return false;

		$sett=$this->getSettings();
		$this->merchant_id=$sett->get('qpay.realex', 'merchant ID');
		$this->timestamp=date_create()->format('YmdHis');
		$this->account=$sett->get('qpay.realex', 'account');
		$this->currency=$sett->get('qpay.realex', 'default currency');
		$this->merchant_response_url=$sett->get('qpay.realex', 'merchant response URL');
		if($this->getIsNewRecord())
		{
			$dbTrans=null;
			$db=$this->getDbConnection();
			if(!$db->getCurrentTransaction())
				$dbTrans=$db->beginTransaction();

			$r=new QPayRequest('create');
			$r->setAttributes(array(
				'method_id'=>1,
				'amount'=>$this->amount,
				'status'=>QPayRequest::STAT_PENDING,
				'timestamp'=>date_create()->format('Y-m-d G:i:s')
			));
			$r->save(false);
			$this->order_id=$r->id;
			$this->amount=self::amountToInt($this->amount);
			$this->request=$r;
			$this->sha1hash=$this->generateSHA1Hash();

			if(!$this->save())
			{
				if($dbTrans)
					$dbTrans->rollback();
				return false;
			}
			if($dbTrans)
				$dbTrans->commit();
		}
		return true;
	}

	public function getIsSuccessful()
	{
		return $this->result=='00';
	}

	public function getIsCanceled()
	{
		return $this->result=='110';
	}

	public function getIsDeclined()
	{
		return $this->result=='101';
	}

	public static function amountToInt($amount)
	{
		$amount=(string)$amount;
		$pos=strpos($amount, ',');
		if($pos===false)
			$pos=strpos($amount, '.');
		if($pos!==false)
		{
			$suff=substr($amount, $pos+1);
			$suff=substr($suff, 0, 2);
			$suff=str_pad($suff, 2-strlen($suff), '0');

			$amount=substr($amount, 0, $pos).$suff;
		}
		else
			$amount.='00';

		return $amount;
	}
}
