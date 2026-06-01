<?php
class QPayRequest extends CActiveRecord
{
	const STAT_COMPLETED=0;
	const STAT_PENDING=1;
	const STAT_ERROR=2;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qpay_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('method_id', 'required'),
			array('method_id, status', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical', 'min'=>0.01),
			array('timestamp', 'safe'),
			array('id, method_id, amount, timestamp, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'invoiceQPayRequests' => array(self::HAS_MANY, 'InvoiceQPayRequest', 'qpay_request_id'),
			'invoices'=>array(self::MANY_MANY, 'Invoice', 'invoice_qpay_request(qpay_request_id, invoice_id)'),
			'method'=>array(self::BELONGS_TO, 'QPayMethod', 'method_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'method_id' => 'Method',
			'amount' => 'Amount',
			'timestamp' => 'Timestamp',
			'status' => 'Status',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$alias=$this->getTableAlias();
		$criteria=new CDbCriteria;

		$criteria->compare($alias.'.id',$this->id);
		$criteria->compare($alias.'.method_id',$this->method_id);
		$criteria->compare($alias.'.amount',$this->amount);
		$criteria->compare($alias.'.timestamp',$this->timestamp,true);
		$criteria->compare($alias.'.status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QpayRequest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
