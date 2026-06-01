<?php

/**
 * This is the model class for table "invoice".
 *
 * The followings are the available columns in table 'invoice':
 * @property integer $id
 * @property string $no
 * @property string $total_gross
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property QpayRequest[] $qpayRequests
 */
class Invoice extends CActiveRecord
{
	const STAT_TOPAY=1;
	const STAT_PAID=2;
	const STAT_CANCELED=3;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoice';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('no', 'filter', 'filter'=>'trim'),
			array('bp_id, no, total_gross, status', 'required'),
			array('status, bp_id', 'numerical', 'integerOnly'=>true),
			array('no', 'numerical', 'integerOnly'=>true, 'min'=>37000),
			array('total_gross', 'length', 'max'=>10),
			array('no, bp_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'qpayRequests' => array(self::MANY_MANY, 'QPayRequest', 'invoice_qpay_request(invoice_id, qpay_request_id)'),
			'successQPayRequest' => array(self::MANY_MANY, 'QPayRequest', 'invoice_qpay_request(invoice_id, qpay_request_id)', 'condition'=>'successQPayRequest.status=0'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'no' => 'No',
			'total_gross' => 'Total Gross',
			'status' => 'Status',
			'bp_id'=>'A/c no',
		);
	}

	public function search()
	{
		$alias=$this->getTableAlias();
		$criteria=new CDbCriteria;

		$criteria->compare($alias.'.id',$this->id);
		$criteria->compare($alias.'.no',$this->no);
		$criteria->compare($alias.'.total_gross',$this->total_gross);
		$criteria->compare($alias.'.status',$this->status);
		$criteria->compare($alias.'.bp_id',$this->bp_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function findByNo($no, $criteria=array())
	{
		return self::model()->findByAttributes(array('no'=>$no), $criteria);
	}
}
