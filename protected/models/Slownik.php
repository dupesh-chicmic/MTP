<?php

/**
 * This is the model class for table "slownik".
 */
class Slownik extends CActiveRecord
{
    public static $licznik=0;
	/**
	 * The followings are the available columns in table 'slownik':
	 * @var integer $id
	 * @var string $grupa
	 * @var string $nazwa
	 * @var integer $wartosc
         * @var string $sciezki
	 * @var integer $dostepnosc
	 * @var string $wywolanie

	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return Slownik the static model class
	 */

    private static $i=0;
    private static $cacheModel=null;
    
    public static function model($className=__CLASS__)
    {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'slownik';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
          	return array(
                        array('id, nazwa_wlasciwa, nazwa_wyswietlana, grupa, nazwa, wartosc', 'required'),
			array('id, id_grupy, wartosc, dostepnosc, wywolanie', 'required'),
			array('wartosc, dostepnosc', 'id_wpisu_nastepnego_poziomu', 'numerical', 'integerOnly'=>true),
			array('nazwa_wlasciwa, wywolanie', 'length', 'max'=>100),
			array('nazwa_wyswietlana, grupa', 'length', 'max'=>50),
			array('sciezki', 'length', 'max'=>500),
                        array('wywolanie', 'length', 'max'=>512),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_grupy, nazwa_wlasciwa, nazwa_wyswietlana, grupa, nazwa, wartosc, sciezki, dostepnosc, wywolanie ,wywolanie, id_wpisu_nastepnego_poziomu', 'safe', 'on'=>'search'),
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
      			'slownikGrupa' => array(self::BELONGS_TO, 'SlownikGrupa', 'id_grupy'),
			'wpisNastepnegoPoziomu' => array(self::BELONGS_TO, 'Slownik', 'id_wpisu_nastepnego_poziomu'),
			'wpisyPoprzedniegoPoziomu' => array(self::HAS_MANY, 'Slownik', 'id_wpisu_nastepnego_poziomu'),
                        'zrodloZamowienia'=>array(self::HAS_MANY, 'Zamowienie', 'zrodlo'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'id_grupy' => 'Id Grupy',
            'nazwa_wlasciwa' => 'Nazwa Wlasciwa',
            'nazwa_wyswietlana' => 'Nazwa Wyswietlana',
            'grupa' => 'Grupa',
            'nazwa' => 'Nazwa',
            'wartosc' => 'Wartosc',
            'sciezki' => 'Sciezki',
            'dostepnosc' => 'Dostepnosc',
            'wywolanie' => 'Wywolanie',
            'id_wpisu_nastepnego_poziomu' => 'Id Wpisu Nastepnego Poziomu',);
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

		$criteria->compare('grupa',$this->grupa,true);

		$criteria->compare('nazwa',$this->nazwa,true);

		$criteria->compare('wartosc',$this->wartosc);
                
		$criteria->compare('sciezki',$this->sciezki,true);

		$criteria->compare('dostepnosc',$this->dostepnosc);

		$criteria->compare('wywolanie',$this->wywolanie,true);


		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        public function __get($name)
        {
            if($name=='nazwa_wyswietlana')
                if(empty($this->attributes['nazwa_wyswietlana']))
                   $name='nazwa_wlasciwa';
                
            return parent::__get($name);
        }
        
        public static function getValue($group, $name, $aux_condition='')
        {
            if(strlen($aux_condition)>0)
                $aux_condition=' AND '.$aux_condition;

            $result=self::model()->find
            (
                array
                    (
                            'select'=>array('wartosc'),
                            'condition'=>'grupa=\''.$group.'\' AND nazwa=\''.$name.'\''.$aux_condition
                   )
            );
            
            if($result)
                return $result->wartosc;

            throw new Exception('Wartość słownikowa nie odnaleziona. Grupa="'.$group.'", nazwa="'.$name.'".');
        }

        public static function getCurrentDictRecord($group)
        {
            /*
            $result=self::model()->find
            (
                array
                    (
                            'select'=>array('id', 'nazwa', 'nazwa_wyswietlana'),
                            'condition'=>'grupa=\''.$group.'\' AND sciezki IS NULL'
                   )
            );

            if(!$result)
                throw new Exception('Nazwa wartości słownikowej nie odnaleziona. Grupa="'.$group.'"');

            return array('name'=>$result->nazwa, 'displayName'=>$result->nazwa_wyswietlana, 'id'=>$result->id);
            */
            $result=self::model()
                        ->with(array('slownikGrupa'=>array('condition'=>'slownikGrupa.nazwa=\''.$group.'\'')))
                        ->findByAttributes(array('sciezki'=>null));

            return array('name'=>$result->nazwa, 'displayName'=>$result->nazwa_wyswietlana, 'id'=>$result->id);
        }

        public static function getDictName($group, $value, $aux_condition='')
        {
            if(strlen($group)==0||strlen($value)==0)
                return null;
 
            if(strlen($aux_condition)>0)
                $aux_condition=' AND '.$aux_condition;

            $result=self::model()->find(
                    array(
                            'select'=>array('nazwa'),
                            'condition'=>'grupa=\''.$group.'\' AND wartosc='.$value.$aux_condition
                        ));

            if(!$result)
                throw new Exception('Nazwa wartości słownikowej nie odnaleziona. Grupa="'.$group.'", wartosc="'.$value.'". Uwaga funckja przestarzała. Uzyj dostępu po ID');

            return $result->nazwa;
        }

        public static function getValueByCall($wywolanie, $group=null)
        {
            if(strlen($wywolanie)==0)
                return null;
            
                if ($group==null){
                    $result=self::model()->find(
                    array(
                            'select'=>array('nazwa'),
                            'condition'=>'`wywolanie`=\''.$wywolanie.'\''
                        ));
                }else {
                    $result=self::model()->find(
                    array(
                            'select'=>array('nazwa'),
                            'condition'=>'grupa=\''.$group.'\' AND wywolanie='.$wywolanie
                        ));
                }
            if(!$result)
                throw new Exception('Nazwa wartości słownikowej nie odnaleziona. Grupa="'.$group.'", wywołanie="'.$wywolanie.'".');

            return $result->nazwa;
        }

        public static function getGroup($group, $aux_condition='')
        {
           if(strlen($aux_condition)>0)
                $aux_condition=' AND '.$aux_condition;

            return self::model()->findAll(
                    array(
                            'select'=>array('id', 'nazwa', 'wartosc', 'sciezki', 'id_wpisu_nastepnego_poziomu'),
                            'condition'=>'grupa=\''.$group.'\''.$aux_condition
                        ));

        }

        public static function getTabMenu($group)
        {
            $model=self::getGroupByName($group);
            foreach ($model as $menuItem){
                    $out[] = array('label'=>$menuItem['nazwa_wyswietlana'], 'url'=>$menuItem['nazwa_wlasciwa']);
                    //$out[]['url'] = $menuItem['nazwa'];
            }
            return $out;

            /*
             *             $model=self::model()->findAll(
                    array(
                            'select'=>array('nazwa','wartosc', 'sciezki','wywolanie'),
                            'condition'=>'grupa=\''.$group.'\''
                        ));
            $out = array();
            foreach ($model as $menuItem){
                    $out[] = array('label'=>$menuItem['wywolanie'], 'url'=>$menuItem['nazwa']);
                    //$out[]['url'] = $menuItem['nazwa'];
            }
            return $out;

             */
        }

        public static function getStatusBrancher($status_group_name, $currentStatusValue=null)
        {
            $startId=-1;
            $group=self::getGroupByName($status_group_name, true);
            foreach($group as $r)
            {
                if($r->id%1000==0)
                        $startId=$r->sciezki;
                $statusArray[$r->id]=array('id'=>$r->id, 'name'=>$r->nazwa_wlasciwa, 'displayName'=>$r->nazwa_wyswietlana, 'branches'=>(empty($r->sciezki)?null:explode(';', $r->sciezki)), 'next_level_ref'=>$r->id_wpisu_nastepnego_poziomu);
            }
            $statusBrancher=new StatusBrancher();
            $statusBrancher->setStatusArray($statusArray);
            $statusBrancher->setGroupDesc($status_group_name);
            if($currentStatusValue!=null)
                $statusBrancher->setCurrentStatusId($currentStatusValue);
            if($startId!=-1)
                $statusBrancher->setStartStatusId($startId);

            return $statusBrancher;
        }

        private static function writeCache($id, $name=null, $group=null)
        {
            if(self::$cacheModel)
            {
                if($id)
                {
                    if(self::$cacheModel->id!=$id)
                        self::$cacheModel=self::model()->with('slownikGrupa')->findByPk($id);
                }
                else
                {
                    if(self::$cacheModel->nazwa_wlasciwa!=$name||self::$cacheModel->slownikGrupa->nazwa!=$group)
                        self::$cacheModel=self::model()
                        ->with(array('slownikGrupa'=>array('condition'=>'slownikGrupa.nazwa=\''.$group.'\'')))
                        ->findByAttributes(array('nazwa_wlasciwa'=>$name));
                }
            }
            else
                if($id)
                    self::$cacheModel=self::model()->with('slownikGrupa')->findByPk($id);
                else
                    self::$cacheModel=self::model()
                        ->with(array('slownikGrupa'=>array('condition'=>'slownikGrupa.nazwa=\''.$group.'\'')))
                        ->findByAttributes(array('nazwa_wlasciwa'=>$name));

            if(!self::$cacheModel)
                throw new Exception('No such record: id='.$id.', name="'.$name.'", group="'.$group.'"');
        }

        public static function getNameFromId($id)
        {
           self::writeCache($id);
           return self::$cacheModel->nazwa_wlasciwa;
        }
        public static function getDisplayNameFromId($id)
        {
            self::writeCache($id);
            return self::$cacheModel->nazwa_wyswietlana;
        }

        public static function getIdFromName($name, $group)
        {
            self::writeCache(null, $name, $group);
            return self::$cacheModel->id;
        }

        public static function getGroupByName($name, $meta=false)
        {
            $sg=SlownikGrupa::model()->with('slowniki')->findByAttributes(array('nazwa'=>$name), ($meta?array():array('having'=>'(slowniki.id%1000)>0')));
            if(empty($sg))
                throw new Exception('No such group: '.$name);
            return $sg->slowniki;
        }
        
        public function getDisplayName()
        {
            return $this->nazwa_wyswietlana;
        }
}
