<?php

/**
 * This is the model class for table "pl_page_element".
 *
 * The followings are the available columns in table 'pl_page_element':
 * @property integer $id_page
 * @property integer $id_universal_element
 * @property integer $id_element
 */
class PageElement extends CmsActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PageElement the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
            return parent::prefixTableName('pl_page_element');		
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_page, id_universal_element, id_element', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_page, id_universal_element, id_element', 'safe', 'on'=>'search'),
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
                    'cmsPage' => array(self::BELONGS_TO, 'CmsPage', 'id_page'),
                    'cmsUniversal' => array(self::BELONGS_TO, 'CmsUniversal', 'id_universal_element'),
                    // Elementy Universalne
                    'maps' => array(self::BELONGS_TO, 'CmsMap', 'id_element'),
                    'news' => array(self::BELONGS_TO, 'CmsNews', 'id_element'),
                    'gallery' => array(self::BELONGS_TO, 'CmsGallery', 'id_element'),                    
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_page' => 'Id Page',
			'id_universal_element' => 'Id Universal Element',
			'id_element' => 'Id Element',
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

		$criteria=new CDbCriteria;

                $criteria->compare('id',$this->id);
		$criteria->compare('id_page',$this->id_page);
		$criteria->compare('id_universal_element',$this->id_universal_element);
		$criteria->compare('id_element',$this->id_element);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}