<?php

/**
 * This is the model class for table "pracownik".
 */
class Pracownik extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'pracownik':
	 * @var string $data_zatrudnienia
	 * @var integer $status
	 * @var integer $uprawnienia
	 * @var integer $id_uzytkownika
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Pracownik the static model class
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
		return 'pracownik';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id_uzytkownika', 'required'),
			array('uprawnienia, id_uzytkownika', 'numerical', 'integerOnly'=>true),
			array('data_zatrudnienia', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('data_zatrudnienia, uprawnienia, id_uzytkownika', 'safe', 'on'=>'search'),
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
			'uzytkownik' => array(self::HAS_ONE, 'Uzytkownik', 'id'),
                        'wlasnoscElemZam' => array(self::HAS_MANY, 'WlasnoscElemZam', 'id_uzytkownika')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'data_zatrudnienia' => 'Data Zatrudnienia',
			'uprawnienia' => 'Uprawnienia',
			'id_uzytkownika' => 'ID',
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

		$criteria->compare('data_zatrudnienia',$this->data_zatrudnienia,true);

		$criteria->compare('uprawnienia',$this->uprawnienia);

                $criteria->compare('uzytkownik.login',$this->uzytkownik->login);

                $criteria->compare('uzytkownik.nazwisko',$this->uzytkownik->nazwisko);

                $criteria->compare('uzytkownik.imie',$this->uzytkownik->imie);

                $criteria->condition='uzytkownik.typ_uzytkownika BETWEEN 2 and 9';

                $criteria->with='uzytkownik';

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public static function load($employee_id)
        {
            return Pracownik::model()->with('uzytkownik')->findByPk($employee_id);
        }

        public function getName()
        {
            return $this->uzytkownik->getName();
        }

        public function provideMyOrderElements($extraConditions=null)
        {
//            $criteria=new CDbCriteria;
//            $criteria->select='t.id_elem_zam, t.czas_przydzielenia';
//            $criteria_condition='';
//            if ($extraConditions!=null){
//                //echo "is set extra cond";
//                foreach($extraConditions as $key=>$value){
//                    $criteria_condition.=$key.' = '.$value. ' AND ';
//                    //echo "kryteria:".$key.'=>'.$value."<br>";
//
//                }
//            }
//            if(!isset($criteria_condition))
//                $criteria_condition='';
//            $criteria->condition=$criteria_condition.'t.id_uzytkownika='.$this->id_uzytkownika.' AND t.czas_przydzielenia IN (SELECT max(t.czas_przydzielenia) as czas_przydzielenia FROM wlasnosc_elem_zam t GROUP BY t.id_elem_zam)';
//            $criteria->order='zamowienie.deadline';
//            $criteria->with=array(
//                'elementZamowienia',
//                'elementZamowienia.zamowienie'=>array(
//                    'condition'=>
//                        'zamowienie.status!='.Slownik::getIdFromName('wyslane', 'status zamówienia').' AND '.
//                        'zamowienie.status!='.Slownik::getIdFromName('odebrane', 'status zamówienia')                      
//                ),
//                'elementZamowienia.zamowienie.klient',
//                'elementZamowienia.cena');
//            /**
//             * @todo dlaczego wychodzimy od własności??
//             */
//            //return new CActiveDataProvider('WlasnoscElemZam', array('criteria'=>$criteria));
//            
            $model=new ElementZamowienia;
            $provider=$model->search();
            //$provider->criteria->compare('zamowienie.data_zlozenia', $this->_relatedCache['data_zlozenia_zamowienia'], true);
            $provider->criteria->addCondition('t.id_uzytkownika IS NOT NULL');
            $provider->criteria->addCondition("wlasnosci.czas_przydzielenia IN (SELECT max(t.czas_przydzielenia) as czas_przydzielenia FROM wlasnosc_elem_zam t GROUP BY t.id_elem_zam)");
            return $provider;
        }

        public function provideOrderElements($addCriteria=null)
        {
            $criteria=new CDbCriteria;
            $criteria->addCondition('t.id_uzytkownika IS NOT NULL');
            $criteria->order='t.id DESC';
            $criteria->with=array(
                'zamowienie.klient',
            );
            if($addCriteria) {
                $criteria->mergeWith($addCriteria);
            }

            $criteria->together=true;
            
            return new CActiveDataProvider('ElementZamowienia', array('criteria'=>$criteria));
        }


        public function assignOrderItem($id) {
        	$model=ElementZamowienia::model()->findByPk($id);
        	$model->employee_owner_id=$this->id_uzytkownika;
        	if(!$model->save()) {
                    return false;
                }
            return WlasnoscElemZam::assignToEmployee($id, $this->id_uzytkownika);
        }
        
    public function others($exclude=null) {
        if($exclude===null) {
            $exclude=array(Yii::app()->user->model);
        }
        
        $exclude=Yii::app()->format->implodeProperties($exclude, 'id_uzytkownika', true);
        $exclude[]=1;//admin
        $exclude[]=0;//su 
        $this->getDbCriteria()->addNotInCondition($this->getTableAlias().'.id_uzytkownika', $exclude);
        $this->getDbCriteria()->mergeWith(array(
            'condition'=>$this->getTableAlias().'.id_uzytkownika!=1',
            'with'=>'uzytkownik',
        ));
        return $this;
    }
}
