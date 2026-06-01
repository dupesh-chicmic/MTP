<?php

/**
 * This is the model class for table "tags_dict".
 *
 * The followings are the available columns in table 'tags_dict':
 * @property integer $id
 * @property string $ri_field
 * @property string $ri_value
 * @property string $mtp_field
 * @property string $mtp_value
 * @property string $mtp_value2
 */
class TagsDict extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tags_dict';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ri_field, ri_value, mtp_field, mtp_value, mtp_value2', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, ri_field, ri_value, mtp_field, mtp_value, mtp_value2', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ri_field' => 'Ri Field',
			'ri_value' => 'Ri Value',
			'mtp_field' => 'Mtp Field',
			'mtp_value' => 'Mtp Value',
			'mtp_value2' => 'Mtp Value2',
		);
	}
        
        public static function getValues($riField, $riValue){
            $dictRow = TagsDict::model()->findAll('ri_field = :riField AND ri_value=:riValue', array('riField'=>$riField, 'riValue'=>$riValue));
            return $dictRow;
        }
        public static function getRiValuesValues($riField, $mtpValue){
            $dictRow = TagsDict::model()->findAll('ri_field = :riField AND mtp_value=:mtpValue', array('riField'=>$riField, 'mtpValue'=>$mtpValue));
            return $dictRow;
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('ri_field',$this->ri_field,true);
		$criteria->compare('ri_value',$this->ri_value,true);
		$criteria->compare('mtp_field',$this->mtp_field,true);
		$criteria->compare('mtp_value',$this->mtp_value,true);
		$criteria->compare('mtp_value2',$this->mtp_value2,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TagsDict the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
