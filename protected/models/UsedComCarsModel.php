<?php

/**
 * This is the model class for table "used_com_cars_model".
 */
class UsedComCarsModel extends CActiveRecord
{
	private $vehiclaBadgeAndYear;

	public function getVehiclaBadgeAndYear()
	{
		return $this->vehicle . ' ' . $this->badge . ' ' . $this->years;
	}

	public function getValueAndKmsForYear($regYear)
	{
		$data = $this->attributes;
		for ($i = 0; $i <= 15; $i++) {
			if (empty($data['yr' . $i]) && empty($data['kms' . $i]) && empty($data['GRP' . $i]) && empty($data['diff' . $i]) && empty($data['newprice' . $i]))
				continue;

			if ($regYear == $data['yr' . $i]) {
				$out = array('kms' => $data['kms' . $i], 'value' => $data['GRP' . $i], 'diff' => $data['diff' . $i], 'newprice' => $data['newprice' . $i]);
				return $out;
			}
		}
		return null;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @return UsedComCarsModel the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'used_com_cars_model';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_used_com_cars', 'required'),
			array('id_used_com_cars, order', 'numerical', 'integerOnly' => true),
			array('codenumber, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5', 'length', 'max' => 100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id_used_com_cars, order, codenumber, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'used_cars_com_model' => array(self::BELONGS_TO, 'UsedComCars', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_used_com_cars' => 'ID',
			'order' => 'Order',
			'codenumber' => 'Codenumber',
			'maker' => 'Maker',
			'vehicle' => 'Vehicle',
			'badge' => 'Badge',
			'body' => 'Body',
			'price' => 'Price',
			'years' => 'Years',
			'fuel' => 'Fuel',
			'yr0' => 'Yr0',
			'kms0' => 'Kms0',
			'GRP0' => 'Grp0',
			'yr1' => 'Yr1',
			'kms1' => 'Kms1',
			'GRP1' => 'Grp1',
			'yr2' => 'Yr2',
			'kms2' => 'Kms2',
			'GRP2' => 'Grp2',
			'yr3' => 'Yr3',
			'kms3' => 'Kms3',
			'GRP3' => 'Grp3',
			'yr4' => 'Yr4',
			'kms4' => 'Kms4',
			'GRP4' => 'Grp4',
			'yr5' => 'Yr5',
			'kms5' => 'Kms5',
			'GRP5' => 'Grp5',
			'yr6' => 'Yr6',
			'kms6' => 'Kms6',
			'GRP6' => 'Grp6',
			'yr7' => 'Yr7',
			'kms7' => 'Kms7',
			'GRP7' => 'Grp7',
			'spec1' => 'Spec1',
			'spec2' => 'Spec2',
			'spec3' => 'Spec3',
			'spec4' => 'Spec4',
			'spec' => 'Spec',
			'intro1' => 'Intro1',
			'intro2' => 'Intro2',
			'intro3' => 'Intro3',
			'intro4' => 'Intro4',
			'intro5' => 'Intro5',
			'note1' => 'Note1',
			'note2' => 'Note2',
			'note3' => 'Note3',
			'note4' => 'Note4',
			'note5' => 'Note5',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id_used_com_cars', $this->id);
		$criteria->compare('order', $this->order);
		$criteria->compare('codenumber', $this->codenumber, true);
		$criteria->compare('maker', $this->maker, true);
		$criteria->compare('vehicle', $this->vehicle, true);
		$criteria->compare('badge', $this->badge, true);
		$criteria->compare('body', $this->body, true);
		$criteria->compare('price', $this->price, true);
		$criteria->compare('years', $this->years, true);
		$criteria->compare('fuel', $this->fuel, true);
		$criteria->compare('yr0', $this->yr0, true);
		$criteria->compare('kms0', $this->kms0, true);
		$criteria->compare('GRP0', $this->GRP0, true);
		$criteria->compare('yr1', $this->yr1, true);
		$criteria->compare('kms1', $this->kms1, true);
		$criteria->compare('GRP1', $this->GRP1, true);
		$criteria->compare('yr2', $this->yr2, true);
		$criteria->compare('kms2', $this->kms2, true);
		$criteria->compare('GRP2', $this->GRP2, true);
		$criteria->compare('yr3', $this->yr3, true);
		$criteria->compare('kms3', $this->kms3, true);
		$criteria->compare('GRP3', $this->GRP3, true);
		$criteria->compare('yr4', $this->yr4, true);
		$criteria->compare('kms4', $this->kms4, true);
		$criteria->compare('GRP4', $this->GRP4, true);
		$criteria->compare('yr5', $this->yr5, true);
		$criteria->compare('kms5', $this->kms5, true);
		$criteria->compare('GRP5', $this->GRP5, true);
		$criteria->compare('yr6', $this->yr6, true);
		$criteria->compare('kms6', $this->kms6, true);
		$criteria->compare('GRP6', $this->GRP6, true);
		$criteria->compare('yr7', $this->yr7, true);
		$criteria->compare('kms7', $this->kms7, true);
		$criteria->compare('GRP7', $this->GRP7, true);
		$criteria->compare('spec1', $this->spec1, true);
		$criteria->compare('spec2', $this->spec2, true);
		$criteria->compare('spec3', $this->spec3, true);
		$criteria->compare('spec4', $this->spec4, true);
		$criteria->compare('spec', $this->spec, true);
		$criteria->compare('intro1', $this->intro1, true);
		$criteria->compare('intro2', $this->intro2, true);
		$criteria->compare('intro3', $this->intro3, true);
		$criteria->compare('intro4', $this->intro4, true);
		$criteria->compare('intro5', $this->intro5, true);
		$criteria->compare('note1', $this->note1, true);
		$criteria->compare('note2', $this->note2, true);
		$criteria->compare('note3', $this->note3, true);
		$criteria->compare('note4', $this->note4, true);
		$criteria->compare('note5', $this->note5, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function copyUsedComCarsModelToArchive($id_import)
	{
		$nazwyPolDoInsertu = ' id_used_com_cars, codenumber, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5';
		$sql = 'INSERT INTO `used_com_cars_model_archive` (' . $nazwyPolDoInsertu . ',`id_import`)
                SELECT ' . $nazwyPolDoInsertu . ',' . $id_import . ' FROM `used_com_cars_model`';
		Yii::app()->db->createCommand($sql)->execute();
	}
}
