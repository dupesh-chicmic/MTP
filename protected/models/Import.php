<?php

/**
 * This is the model class for table "import".
 *
 * The followings are the available columns in table 'import':
 * @property integer $id
 * @property string $nazwa
 * @property string $data
 * @property string $data_importu
 *
 * The followings are the available model relations:
 * @property UsedCarsArchive[] $usedCarsArchives
 */
class Import extends CActiveRecord
{
    public static $TABLE_KMS_BANDS = 'xml_kms_bands_model';
    public static $TABLE_PETROL_BANDS = 'xml_petrol_bands_model';
    public static $TABLE_PETROL_BANDS_UP = 'xml_petrol_bands_up_model';
    public static $TABLE_DIESEL_BANDS = 'xml_diesel_bands_model';
    public static $TABLE_DIESEL_BANDS_UP = 'xml_diesel_bands_up_model';
    public static $TABLE_ELECTRIC_BANDS = 'xml_electric_bands_model';
    public static $TABLE_ELECTRIC_BANDS_UP = 'xml_electric_bands_up_model';
    public static $TABLE_FILES_CARS = 'xml_ucars_links';
    public static $TABLE_FILES_COMMS = 'xml_ucomms_links';
    public static $XML_FILES_DIR = 'qBixSoft';
    public static $XML_LINKS_FILES_DIR = 'linkFiles';
    
	/**
	 * Returns the static model of the specified AR class.
	 * @return Import the static model class
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
		return 'import';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nazwa, data, data_importu', 'required'),
			array('nazwa', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nazwa, data, data_importu', 'safe', 'on'=>'search'),
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
			'usedCars' => array(self::HAS_MANY, 'UsedCars', 'id_import', 'joinType'=>'INNER JOIN'),
			'usedComCars' => array(self::HAS_MANY, 'UsedComCars', 'id_import', 'joinType'=>'INNER JOIN'),
			'xmlDieselBandsModels' => array(self::HAS_MANY, 'XmlDieselBandsModel', 'id_import'),
			'xmlKmsBandsModels' => array(self::HAS_MANY, 'XmlKmsBandsModel', 'id_import'),
			'xmlPetrolBandsModels' => array(self::HAS_MANY, 'XmlPetrolBandsModel', 'id_import'),
                    
                        'usedCarsCount' => array(self::STAT, 'UsedCars', 'id_import'),
                        'usedComCarsCount' => array(self::STAT, 'UsedComCars', 'id_import'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nazwa' => 'Nazwa',
			'data' => 'Data',
			'data_importu' => 'Data Importu',
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
		$criteria->compare('nazwa',$this->nazwa,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('data_importu',$this->data_importu,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * Funkcja w postaci transakcji importuje pliki xml do bazy danych oraz robi archiwum
     */
    public function importXmlFiles($importCommercialCars, $userImportDate, $userImportName, $importCarLinks=null, $importCommsLinks=null)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try
        {
            $modelImport = new Import();
            $modelImport->data = $userImportDate;
            $modelImport->data_importu = date('Y-m-d');
            $modelImport->nazwa = $userImportName;

            if($modelImport->validate())
            {
                if($modelImport->save())
                {
                    $importId = $modelImport->id;
                    $this->importCarsComm($importCommercialCars, $importId);
                    
                    $statusKmsBands = $this->backup_tables('xmlBackup/kmsBands',self::$TABLE_KMS_BANDS);
                    if($statusKmsBands == 1)
                        XmlKmsBandsModel::model()->export_kmsBand_xml_to_db(self::$TABLE_KMS_BANDS, $importId);
                    
                   // echo 'icl'.$importCarLinks;
                    if(!empty($importCarLinks)){
                      //  echo 'in';
                        $statusKmsBands = $this->backup_tables('xmlBackup/uCarsLinks',self::$TABLE_FILES_CARS);
                       // echo ' statusBack'.$statusKmsBands;
                        if($statusKmsBands == 1)
                            $this->import_Links_xml_to_db(self::$TABLE_FILES_CARS,'UCarsLinks.xml', $importId);
                            //$this->import_Links_xml_to_db(self::$TABLE_FILES_CARS, $importId);
                    }
                    if(!empty($importCommsLinks)){
                       // echo 'in';
                        $statusKmsBands = $this->backup_tables('xmlBackup/uComsLinks',self::$TABLE_FILES_COMMS);
                       // echo ' statusBack'.$statusKmsBands;
                        if($statusKmsBands == 1)
                            $this->import_Links_xml_to_db(self::$TABLE_FILES_COMMS,'UComsLinks.xml', $importId);
                            //$this->import_Links_xml_to_db(self::$TABLE_FILES_CARS, $importId);
                    }
                    
                    //importing cars RANGES (if the file exists)
                    //TUTAJ
                        $statusUsedCarRanges = $this->backup_tables('xmlBackup/uCarsRanges','used_cars_ranges');
                        if($statusUsedCarRanges == 1)
                            $this->import_Ranges_xml_to_db('used_cars_ranges','uCarsRanges.xml', $importId);
                     
                    //importing Comms RANGES (if the file exists)
                    //TUTAJ
                        $statusUsedCarRanges = $this->backup_tables('xmlBackup/uComsRanges','used_comms_ranges');
                        if($statusUsedCarRanges == 1)
                            $this->import_Ranges_xml_to_db('used_comms_ranges','uComsRanges.xml', $importId);
                    
                    if(isset($_POST) && !empty($_POST))
                    {
                        $statusPetrolBandsU = $this->backup_tables('xmlBackup/petrolBandsU',self::$TABLE_PETROL_BANDS_UP);
                        if($statusPetrolBandsU == 1)
                            $this->export_petrolDieselBand_xml_to_db(self::$TABLE_PETROL_BANDS_UP,'PetrolBandsU.xml', $importId);

                        $statusPetrolBands = $this->backup_tables('xmlBackup/petrolBands',self::$TABLE_PETROL_BANDS);
                        if($statusPetrolBands == 1)
                            $this->export_petrolDieselBand_xml_to_db(self::$TABLE_PETROL_BANDS,'PetrolBands.xml', $importId);

                        $statusDieselBandsU = $this->backup_tables('xmlBackup/dieselBandsU',self::$TABLE_DIESEL_BANDS_UP);
                        if($statusDieselBandsU == 1)
                            $this->export_petrolDieselBand_xml_to_db(self::$TABLE_DIESEL_BANDS_UP,'DieselBandsU.xml', $importId);

                        $statusDieselBands = $this->backup_tables('xmlBackup/dieselBands',self::$TABLE_DIESEL_BANDS);
                        if($statusDieselBands == 1)
                            $this->export_petrolDieselBand_xml_to_db(self::$TABLE_DIESEL_BANDS,'DieselBands.xml', $importId);
                        

                               //electric
                        $statusElectricBandsU = $this->backup_tables('xmlBackup/electricBandsU',self::$TABLE_ELECTRIC_BANDS_UP);
                        if($statusElectricBandsU == 1)
                            $this->export_petrolDieselBand_xml_to_db(self::$TABLE_ELECTRIC_BANDS_UP,'ElectricBandsU.xml', $importId);

                        $statusElectricBands = $this->backup_tables('xmlBackup/electricBands',self::$TABLE_ELECTRIC_BANDS);
                        if($statusElectricBands == 1)
                            $this->export_petrolDieselBand_xml_to_db(self::$TABLE_ELECTRIC_BANDS,'ElectricBands.xml', $importId);
                    }
                }
            }

            $transaction->commit();
            Yii::app()->user->setFlash('importXmlSuccess','Selected XML files were imported.');

        }
        catch(Exception $e)
        {
            echo $e.' rollback';
            Yii::app()->user->setFlash('importXmlError','Something went wrong, cannot copy to archive and import new files.');
            $transaction->rollBack();
        }
    }
    
    public function importCarsComm($importCommercialCars, $importId)
    {
        // import UsedCars               
        $this->importCars('used_cars', 'used_cars_model', 'UsedCars', 'xmlBackup/usedCarsCars', $importId);

        // import UsedCarsCom
        if($importCommercialCars == 1)
        {
            $this->importCars('used_com_cars', 'used_com_cars_model', 'UsedComCars', 'xmlBackup/usedCarsCom', $importId);
        }    
    }
    
    /**
     * Metoda importuje dane do odpowiedniej tabeli
     * @param type $tableName_db
     * @param type $tableName_model_db
     * @param type $modelName
     * @param type $backupPath
     * @param type $id_import
     */
    public function importCars($tableName_db, $tableName_model_db, $modelName, $backupPath,$id_import)
    {
        $status = $this->backup_tables($backupPath,$tableName_db);
        if($status == 1)
        {
            // wyczysc cala tabele         
//                    Yii::app()->db->createCommand('TRUNCATE TABLE '.$tableName_db.' ')->execute();
//                    Yii::app()->db->createCommand('TRUNCATE TABLE '.$tableName_model_db.' ')->execute();
            // import wszystkich plikow xml z odpowiedniego folderu
            $folder = ($tableName_db == 'used_cars') ? 'qBixSoft/uCars' : 'qBixSoft/uComs';
            $this->read_dir_and_create_query($folder,$tableName_db,$tableName_model_db,$modelName,$id_import);
        }
        else
        {
            Yii::app()->user->setFlash('importXmlError','System cannot create backup file, xml file was not imported.');
        }            
    }

    /*
     * Metoda przgotowuje i wykonuje insert danych do bazy do tabeli
     * used_cars lub used_com_cars
     * Dane pobierane sa z odpowiednich plikow xml
     */        
    public function read_dir_and_create_query($dir, $tableName, $tableName_model, $modelName,$id_import)
    {
        $lvIdUsedCarsOrCom = null;
        $lvIdUsedCarsOrCom = ($tableName == 'used_cars') ? 'id_used_cars' : 'id_used_com_cars';
        if($lvIdUsedCarsOrCom == null)
            Yii::app()->user->setFlash('importXmlError','Something went wrong, xml file was not imported.');

        $dh = opendir($dir);
        while (($file = readdir($dh)) !== false) 
        {
            if($file !== '.' && $file !== '..'&& $file !== '.svn' && $file !== 'man.xml' && $file !== '.DS_Store') 
            {
                $model = new $modelName;
                $model->name = substr($file,0,-4); //pozbywa sie .xml
                $model->xml = $file;
                $model->id_import = $id_import;
                $model->save();
                if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){
                    Yii::log('Importing File:'.$file, 'info', 'Import');
                    echo 'f:'.$file;
                } 
                $cars_file = file_get_contents('./'.$dir.'/'.$file);
                $cars_file = htmlspecialchars($cars_file);
                //$cars = simplexml_load_string(html_entity_decode(htmlentities($cars_file)), 'SimpleXMLElement', LIBXML_NOCDATA); // tak nie dziala import
                $cars = simplexml_load_string(html_entity_decode($cars_file), 'SimpleXMLElement', LIBXML_NOCDATA);

                foreach ($cars->model as $row)
                {
                    $values = '';
                    $values .= '"'.$model->id.'",'; //id
                    $values .= '"'.$row['codenumber'].'",';
                    $values .= '"'.$row['maker'].'",';
                    $values .= '"'.$row['vehicle'].'",';
                    $values .= '"'.$row['badge'].'",';
                    $values .= '"'.$row['body'].'",';
                    $values .= '"'.$row['price'].'",';
                    $values .= '"'.$row['years'].'",';
                    $values .= '"'.$row['fuel'].'",';

                    for($i=0; $i<16; $i++)
                    {
                        $values .= '"'.$row['yr'.$i].'",';
                        $values .= '"'.$row['kms'.$i].'",';
                        $values .= '"'.$row['GRP'.$i].'",';
                    }

                    $values .= '"'.$row['spec1'].'",';
                    $values .= '"'.$row['spec2'].'",';
                    $values .= '"'.$row['spec3'].'",';
                    $values .= '"'.$row['spec4'].'",';
                    $values .= '"'.$row['spec'].'",';
                    $values .= '"'.$row['intro1'].'",';
                    $values .= '"'.$row['intro2'].'",';
                    $values .= '"'.$row['intro3'].'",';
                    $values .= '"'.$row['intro4'].'",';
                    $values .= '"'.$row['intro5'].'",';
                    $values .= '"'.$row['note1'].'",';
                    $values .= '"'.$row['note2'].'",';
                    $values .= '"'.$row['note3'].'",';
                    $values .= '"'.$row['note4'].'",';
                    $values .= '"'.$row['note5'].'",';
                    $values .= '"'.$row['corecode'].'",';
                    $values .= '"'.$row['rge'].'",';
                    $values .= '"'.$row['mdl'].'",';
                    $values .= '"'.$row['bod'].'",';
                    $values .= '"'.$row['drs'].'",';
                    $values .= '"'.$row['notenum'].'",';
                    $values .= '"'.$row['badgetype'].'",';
                    $values .= '"'.$row['transmission'].'",';
                   // $values .= '"'.$row['LinkAs'].'",';    
                    //$values .= '"'.$row['CarType'].'",';   //present only in cars - never used for anyting - can be MTP internal field or mistake.  
                    if(isset($row['rangecode'])){
                        $values .= '"'.$row['LinkAs'].'",';    
                        $values .= '"'.$row['rangecode'].'"';    
                        
                        $nazwyPolDoInsertu = ' '.$lvIdUsedCarsOrCom.', codenumber, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, yr8, kms8, GRP8, yr9, kms9, GRP9, yr10, kms10, GRP10, yr11, kms11, GRP11, yr12, kms12, GRP12, yr13, kms13, GRP13, yr14, kms14, GRP14, yr15, kms15, GRP15, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, corecode, rge, mdl, bod, drs, notenum, badgetype, transmission, linkas, rangecode';
                    }else {
                        $values .= '"'.$row['LinkAs'].'"';   
                        
                        $nazwyPolDoInsertu = ' '.$lvIdUsedCarsOrCom.', codenumber, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, yr8, kms8, GRP8, yr9, kms9, GRP9, yr10, kms10, GRP10, yr11, kms11, GRP11, yr12, kms12, GRP12, yr13, kms13, GRP13, yr14, kms14, GRP14, yr15, kms15, GRP15, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, corecode, rge, mdl, bod, drs, notenum, badgetype, transmission, linkas';
                    }
                    if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){
                        for($i=1; $i<=15; $i++)
                        {
                            $nazwyPolDoInsertu .= ' Tag'.$i.',';                       
                        }
                        
                        $nazwyPolDoInsertu .= ' yearfrom, yearto,';
                        $nazwyPolDoInsertu .= ' mtpvariant, mtptype, lmopmake, lmopmodel, lmoptype,';
                        
                    $nazwyPolDoInsertu = substr($nazwyPolDoInsertu, 0, -1);
                        
                    $values .= '"'.$row['cc'].'",';
                    $values .= '"'.$row['drive'].'",';
                    
                    for($i=1; $i<=15; $i++)
                    {
                        $values .= '"'.$row['Tag'.$i].'",';                       
                    }
                    
                    $values .='"'.$row['yearfrom'].'",';            
                    $values .='"'.$row['yearto'].'",';            
                    $values .='"'.$row['mtpvariant'].'",';            
                    $values .='"'.$row['mtptype'].'",';            
                    $values .='"'.$row['lmopmake'].'",';            
                    $values .='"'.$row['lmopmodel'].'",';            
                    $values .='"'.$row['lmoptype'].'",';            
                    
                    $values = substr($values, 0, -1);
                    
                    } 
                    
                    // ostatni element bez , !!

                    //$nazwyPolDoInsertu = ' '.$lvIdUsedCarsOrCom.', codenumber, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, yr8, kms8, GRP8, yr9, kms9, GRP9, yr10, kms10, GRP10, yr11, kms11, GRP11, yr12, kms12, GRP12, yr13, kms13, GRP13, yr14, kms14, GRP14, yr15, kms15, GRP15, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, corecode, rge, mdl, bod, drs, notenum, badgetype, transmission, linkas, rangecode';
                    $sql = 'INSERT INTO `'.$tableName_model.'` ('.$nazwyPolDoInsertu.') VALUES ('.$values.')';
                    Yii::app()->db->createCommand($sql)->execute();
                    $this->importDiffColumns($row, $tableName_model);
                }
            }
        }
    }        

    public function importDiffColumns($row, $tableName_model)
    {
        $values = '';
        $id = Yii::app()->db->createCommand('SELECT id FROM `'.$tableName_model.'` ORDER BY id DESC LIMIT 1')->queryScalar();
        
        for($i=0; $i<16; $i++)
        {
            $values .= '`diff'.$i.'`="'.$row['diff'.$i].'", ';
        }
        $values = $values.substr(trim($values), 0, -1);

        $sql = 'UPDATE `'.$tableName_model.'` SET '.$values.' WHERE `id`='.$id.';';
        Yii::app()->db->createCommand($sql)->execute();
    }
    
    /*
     * Metoda przgotowuje i wykonuje insert danych do bazy do tabeli
     * PetrolBands lub DieselBands
     * Dane pobierane sa z odpowiednich plikow xml
     */
    function export_petrolDieselBand_xml_to_db($tableName, $petrolDieselXmlFile, $id_import)
    {
        $dir = self::$XML_FILES_DIR;
        $file = $petrolDieselXmlFile;

        $kms_file = file_get_contents('./'.$dir.'/'.$file);
        $kms_file = htmlspecialchars($kms_file);
        //$kms = simplexml_load_string(html_entity_decode(htmlentities($kms_file)), 'SimpleXMLElement', LIBXML_NOCDATA); // tak nie dziala import
        $kms = simplexml_load_string(html_entity_decode($kms_file), 'SimpleXMLElement', LIBXML_NOCDATA);

        foreach ($kms->bands as $row)
        {
            $values = '';
            // id auto
            $values .= '"'.$row['from'].'",';
            $values .= '"'.$row['to'].'",';
            $values .= '"'.$row['yr1'].'",';
            $values .= '"'.$row['yr2'].'",';
            $values .= '"'.$row['yr3'].'",';
            $values .= '"'.$row['yr4'].'",';
            $values .= '"'.$row['yr5'].'",';
            $values .= '"'.$row['yr6'].'",';
            $values .= '"'.$row['yr7'].'",';
            $values .= '"'.$row['yr8'].'",';
            $values .= '"'.$row['yr9'].'",';
            $values .= '"'.$row['yr10'].'",';
            $values .= '"'.$row['yr11'].'",';
            $values .= '"'.$row['yr12'].'",';
            $values .= '"'.$row['yr13'].'",';
            $values .= '"'.$row['yr14'].'",';
            $values .= '"'.$row['yr15'].'",';
            $values .= '"'.$row['yr16'].'"';
            // ostatni element bez , !!!

            $nazwyPolDoInsertu = 'id_import, fromXml, toXml, yr1, yr2, yr3, yr4, yr5, yr6, yr7, yr8, yr9, yr10, yr11, yr12, yr13, yr14, yr15, yr16';
            $sql = 'INSERT INTO `'.$tableName.'` ('.$nazwyPolDoInsertu.') VALUES ('.$id_import.','.$values.')'; // end query
            Yii::app()->db->createCommand($sql)->execute();
        }
    }
    
    function import_Links_xml_to_db($tableName, $linksFile, $id_import)
    {
        $dir = self::$XML_FILES_DIR.'/'.self::$XML_LINKS_FILES_DIR;
        $file = $linksFile;

        $kms_file = file_get_contents('./'.$dir.'/'.$file);
       // echo ' kms file path:'.'./'.$dir.'/'.$file;
        $kms_file = htmlspecialchars($kms_file);
        //$kms = simplexml_load_string(html_entity_decode(htmlentities($kms_file)), 'SimpleXMLElement', LIBXML_NOCDATA); // tak nie dziala import
        $links = simplexml_load_string(html_entity_decode($kms_file), 'SimpleXMLElement', LIBXML_NOCDATA);
       // var_dump($links);
     
        foreach ($links->vehicle as $row)
        {
         //   echo 'row';
            $values = '';
            // id auto
            $values .= '"'.$row['maker'].'",';
            $values .= '"'.$row['linkcode'].'",';
            $values .= '"'.$row['codenumber'].'"';
            // ostatni element bez , !!!

            $nazwyPolDoInsertu = 'id_import, maker, linkcode, codenumber';
            $sql = 'INSERT INTO `'.$tableName.'` ('.$nazwyPolDoInsertu.') VALUES ('.$id_import.','.$values.')'; // end query
            Yii::app()->db->createCommand($sql)->execute();
        }
    }  
    
        function import_Ranges_xml_to_db($tableName, $linksFile, $id_import)
    {
        $dir = self::$XML_FILES_DIR.'/ranges';
        $file = $linksFile;

        $kms_file = file_get_contents('./'.$dir.'/'.$file);
        if(!empty($kms_file)){
            // echo ' kms file path:'.'./'.$dir.'/'.$file;
             $kms_file = htmlspecialchars($kms_file);
             //$kms = simplexml_load_string(html_entity_decode(htmlentities($kms_file)), 'SimpleXMLElement', LIBXML_NOCDATA); // tak nie dziala import
             $links = simplexml_load_string(html_entity_decode($kms_file), 'SimpleXMLElement', LIBXML_NOCDATA);
            // var_dump($links);
             if(!empty($links)){
                foreach ($links->range as $row)
                {
                 //   echo 'row';
                    $values = '';
                    // id auto
                    $values .= '"'.$row['manufacturer'].'",';
                    $values .= '"'.$row['rangecode'].'",';
                    $values .= '"'.$row['rangedesc'].'"';
                    // ostatni element bez , !!!

                    $nazwyPolDoInsertu = 'id_import, manufacturer, rangecode, rangedesc';
                    $sql = 'INSERT INTO `'.$tableName.'` ('.$nazwyPolDoInsertu.') VALUES ('.$id_import.','.$values.')'; // end query
                    Yii::app()->db->createCommand($sql)->execute();
                }
             }
        }
    }    
    
    /**
     * Metoda robi backup bazy danych lub wybranych tabel
     * @param type $fullPathToSaveBacupFile
     * @param type $tables
     * @return int
     */
    public function backup_tables($fullPathToSaveBacupFile,$tables = '*')
    {
        // wywolanie 
        // $status = $this->backup_tables('xmlBackup/usedCarsCom',$tableName);
        // ---

        $user = Yii::app()->getDb()->username;
        $pass = Yii::app()->getDb()->password;
        $host = Yii::app()->getDb()->connectionString;
        $host = explode('=',$host);
        $hostName = explode(';',$host[1]);

        if(isset($host[3])){
            $hostName = $hostName[0].':'.$host[3];
        }else{
            $hostName = $hostName[0];//localhost
        }
        $db_name = $host[2];
        $db_name = explode(';',$db_name);
        $name = $db_name[0];            
        //echo $hostName.' '.$user.' '.$pass;

        $link = mysqli_connect($hostName,$user,$pass);
        mysqli_select_db($link, $name);
        $return = '';

        //get all of the tables
        if($tables == '*') {
            $saveTableName = $name;
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while($row = mysqli_fetch_row($result))
            {
                $tables[] = $row[0];
            }
        }else{
            $saveTableName = $tables;
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        foreach($tables as $table)
        {
            $result = mysqli_query($link, 'SELECT * FROM '.$table) or die(mysqli_error($link));
            $num_fields = mysqli_num_fields($result);

            $return.= 'DROP TABLE '.$table.';';
            $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";

            for ($i = 0; $i < $num_fields; $i++) 
            {
                while($row = mysqli_fetch_row($result))
                {
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                    $columns = count($row);
                    for($j=0; $j<$columns; $j++) 
                    {
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j<($num_fields-1)) { $return.= ','; }
                    }
                    $return.= ");\n";
                }
            }
            $return.="\n\n\n";
        }

        $backupFile = $fullPathToSaveBacupFile.'/'.$saveTableName."_". date("d.m.Y_H-i-s");
        //save file
        $handle = fopen($backupFile.'.sql','w+');
        fwrite($handle,$return);
        fclose($handle);

        if(empty($return)){
            return 0;
        }else{
            return 1;
        }
    }    
    
    public function clearTable($tableName)
    {
        Yii::app()->db->createCommand('TRUNCATE TABLE '.$tableName.' ')->execute();
    }
    
    public static function getLastImportData()
    {
        return $import = Import::model()->with('usedCars')->find(array(
            'order'=>'`t`.`id` DESC'
        ));
    }
    public static function getLastImportId($carOrComms=null)
    {
        if(!empty($carOrComms)){
            if($carOrComms!="UsedCarsModel"){
                $model = UsedComCars::model()->find(array(
                    'order'=>'`t`.`id_import` DESC'
                ));
                if(!empty($model)){
                    return $model->id_import;
                }
            }
        }
        $import = Import::model()->find(array(
            'order'=>'`t`.`id` DESC'
        ));
        if(!empty($import)){
            return $import->id;
        }
    }
    
    public static function getAllFields($carOrComms){
        $lvIdUsedCarsOrCom = null;
        $lvIdUsedCarsOrCom = ($carOrComms == 'used_cars') ? 'used_cars_model.id as id, id_used_cars' : 'used_com_cars_model.id as id, id_used_com_cars';
        //$lvIdUsedCarsOrCom = ($carOrComms == 'used_cars') ? 'id_used_cars' : 'id_used_com_cars';
        if($lvIdUsedCarsOrCom == null)
            Yii::app()->user->setFlash('importXmlError','Something went wrong, xml file was not imported.');

        
                
                        
                        $nazwyPolDoInsertu = ''.$lvIdUsedCarsOrCom.', codenumber, maker, vehicle, badge, body, price, years, fuel, yr0, kms0, GRP0, yr1, kms1, GRP1, yr2, kms2, GRP2, yr3, kms3, GRP3, yr4, kms4, GRP4, yr5, kms5, GRP5, yr6, kms6, GRP6, yr7, kms7, GRP7, yr8, kms8, GRP8, yr9, kms9, GRP9, yr10, kms10, GRP10, yr11, kms11, GRP11, yr12, kms12, GRP12, yr13, kms13, GRP13, yr14, kms14, GRP14, yr15, kms15, GRP15, spec1, spec2, spec3, spec4, spec, intro1, intro2, intro3, intro4, intro5, note1, note2, note3, note4, note5, corecode, rge, mdl, bod, drs, notenum, badgetype, transmission, linkas, rangecode, cc, drive,';
                    
                    for($i=1; $i<=15; $i++)
                        {
                            $nazwyPolDoInsertu .= ' Tag'.$i.',';                       
                        }
                        
                        $nazwyPolDoInsertu .= ' yearfrom, yearto,';
                        $nazwyPolDoInsertu .= ' mtpvariant, mtptype, lmopmake, lmopmodel, lmoptype,';
                        
                    $nazwyPolDoInsertu = substr($nazwyPolDoInsertu, 0, -1);
                        
                    return $nazwyPolDoInsertu;
              
    }
}