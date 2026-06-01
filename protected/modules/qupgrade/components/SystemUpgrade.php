<?php
/**
 * @author: Aleksander Stekman
 * @version: 0.1
 */
abstract class SystemUpgrade extends CComponent
{
	public $db;
	public $version;
	public $settings;
	private $_dbSql;
	private $_log=array();
	public $defaultDbCreateTableOptions='ENGINE=InnoDB DEFAULT CHARSET=utf8';
	public $requiredAppComponents=array();
	public $requiredModules=array();
	private $_preconditionsFulfil;

	public function __construct($db=null)
	{
		$this->db=$db?$db:Yii::app()->db;
		$this->init();
	}

	public function init()
	{

	}

	public function stages()
	{
		$stages=array();
		$methods=get_class_methods(get_called_class());
		foreach($methods as $method)
		{
			$subName=substr($method, 0, 7);
			if($subName=='upgrade')
				$stages[]=substr($method, 7);
		}

		return $stages;
	}

	public function checkPreconditions()
	{
		$result=array();
		if(!empty($this->requiredAppComponents))
		{
			foreach($this->validateComponents($this->requiredAppComponents) as $name=>$ok)
			{
				$name='Sprawdzam obecność komponentu aplikacji "'.$name.'"';
				if($ok)
					$result[$name]=true;
				else
				{
					$result[$name]=array('errors'=>array('Nie znaleziono komponentu.'));
					$this->_preconditionsFulfil=false;
				}
			}
		}

		if(!empty($this->requiredModules))
		{
			foreach($this->validateModules($this->requiredModules) as $name=>$ok)
			{
				$name='Sprawdzam obecność modułu "'.$name.'"';
				if($ok)
					$result[$name]=true;
				else
				{
					$result[$name]=array('errors'=>array('Nie znaleziono modułu.'));
					$this->_preconditionsFulfil=false;
				}
			}
		}

		if($this->_preconditionsFulfil===null)
			$this->_preconditionsFulfil=true;
		return $result;
	}

	public function arePreconditionsFulfil()
	{
		return $this->$_preconditionsFulfil;
	}

	public function getDb()
	{
		if($this->db===null)
			$this->db=Yii::app()->getComponent('db')?Yii::app()->db:false;
		return $this->db;
	}

	public function alterTables()
	{
		return array();
	}

	public function addLog($msg, $flush=false)
	{
		$this->_log[]=$msg;
		if($flush)
			$this->flushLog();
	}

	public function log($text)
	{
		if(is_array($text))
			$text=implode("\n", $text);
		if(!empty($text))
		{
			Yii::log($text, 'info', 'upgrade');
			flush();
		}
	}

	public function flushLog()
	{
		$this->log($this->_log);
		$this->_log=array();
	}

	protected function beforeRun()
	{
		set_time_limit(0);
		$this->dbRefreshMetaData($this->alterTables());
		if($this->_preconditionsFulfil===null)
			$this->checkPreconditions();
		if(!$this->_preconditionsFulfil)
		{
			$this->log('System nie spełnia wymagań systemowych. ');
			return false;
		}
		$this->log('Rozpoczynam upgrade '.Yii::app()->name.' do wersji '.$this->version);
		return true;
	}

	protected function afterRun()
	{
		$this->flushLog();
		$this->log('Upgrade systemu '.Yii::app()->name.' do wersji '.$this->version.' zakończony.');
	}

	public function run($stages=null)
	{
		$result=false;
		try
		{
			if($this->beforeRun())
			{
				if($stages===null)
					$stages=$this->stages();

				foreach($stages as $stage)
				{
					$methodName='upgrade'.$stage;
					$this->$methodName();
				}
				$this->afterRun();
			}
			else
			{
				$this->log('Wystąpił błąd podczas przygotowania upgradu systemu');
			}
		}
		catch(Exception $e)
		{
			$this->flushLog();
			$this->log('Upgrade systemu '.Yii::app()->name.' do wersji '.$this->version.' przerwany z powodu błędu: '.$e->getMessage().$e->getTraceAsString());
		}
		return $result;
	}

	public function dbCreateIndex($name, $tableName, $columns, $unique=false, $ifNotExists=true)
	{
		$db=$this->db;
		$t=$db->createCommand('SHOW KEYS FROM `'.$tableName.'` WHERE key_name="'.$name.'"')->queryScalar();
		if(!$t)
		{
			$this->log("Aktualizuję index $name tabeli $tableName");
			return $db->createCommand()->createIndex($name, $tableName, $columns, $unique);
		}
		return true;
	}

	public function dbCreateForeignKeyConstraints($table, array $constraints)
	{
		$result=array();
		$db=$this->getDb();
		foreach($constraints as $name=>$constraint)
		{
			$this->addLog("Dodaję do tabeli $table klucz obcy o nazwie '$name'");
			if($this->dbHasForeignKeyConstraint($name, $table))
			{
				$this->addLog("Klucz obcy istnieje, pomijam.");
				continue;
			}
			if(isset($constraint['newName']))
			{
				if($this->dbHasForeignKeyConstraint($constraint['newName'], $table))
					$db->createCommand()->dropForeignKey($constraint['newName'], $table);
			}
			else
				$constraint['newName']=$name;

			if(!array_key_exists('mustExists', $constraint)) $constraint['mustExists']=true;
			if(!isset($constraint['refColumns'])) $constraint['refColumns']='id';
			if(!array_key_exists('delete', $constraint)) $constraint['delete']=null;
			if(!array_key_exists('update', $constraint)) $constraint['update']=null;

			$result[$name]=$db->createCommand()->addForeignKey($constraint['newName'], $table, $constraint['columns'], $constraint['refTable'], $constraint['refColumns'], $constraint['delete'], $constraint['update']);
			$this->addLog("Klucz obcy dodano.");
		}
		return $result;
	}

	public function dbDropForeignKeyConstraints($table, $names)
	{
		$db=$this->getDb();
		if(is_string($names))
			$names=array($names);

		foreach($names as $name)
			if($this->dbHasForeignKeyConstraint($name, $table))
				$db->createCommand()->dropForeignKey($name, $table);
	}

	public function dbHasForeignKeyConstraint($name, $table)
	{
		return $this->getDb()->createCommand("SELECT 1 FROM information_schema.TABLE_CONSTRAINTS
			WHERE information_schema.TABLE_CONSTRAINTS.CONSTRAINT_TYPE = 'FOREIGN KEY'
			AND information_schema.TABLE_CONSTRAINTS.TABLE_SCHEMA = (SELECT DATABASE())
			AND information_schema.TABLE_CONSTRAINTS.TABLE_NAME = '$table'
			AND information_schema.TABLE_CONSTRAINTS.CONSTRAINT_NAME = '$name'")->queryScalar()?true:false;
	}

	public function executeSql($sql)
	{
		$db=$this->db;
		$result=array();
		if(!is_array($sql))
			$sql=array($sql);
		foreach($sql as $command)
			$result[]=$db->createCommand($command)->execute();
		return $result;
	}

	public function dbRefreshMetaData($activeRecords=array())
	{
		$schema=$this->getDb()->getSchema();
		$schema->refresh();
		foreach($activeRecords as $ar)
		{
			$model=$ar::model();
			$schema->getTable($model->tableName(), true);
			$model->refreshMetaData();
		}
	}

	public function dbForeignKeyChecks($on=true)
	{
		return $this->executeSql('SET foreign_key_checks='.($on?1:0));
	}

	public function dbDropColumns($model, $columns)
	{
		if(!is_array($columns))
			$columns=array($columns);
		$result=array();
		$db=$this->getDb();
		$table=$model->tableName();
		if(!empty($columns))
		{
			$this->dbRefreshMetaData(array(get_class($model)));
			foreach($columns as $column)
			{
				if($model->hasAttribute($column))
				{
					$this->addLog("Usuwam columnę $column z tabeli $table.");
					$result[$column]=$db->createCommand()->dropColumn($table, $column);
				}
			}
			$this->dbRefreshMetaData(array(get_class($model)));
		}
		return $result;
	}

	public function dbAddColumns($model, $columns)
	{
		$result=array();
		$db=$this->getDb();
		$table=$model->tableName();
		if(!empty($columns))
		{
			$this->dbRefreshMetaData(array(get_class($model)));
			$refresh=false;

			if(isset($columns['name']))
				$columns=array($columns);

			foreach($columns as $column)
			{
				$this->addLog("Dodaję kolumnę `{$column['name']}` do tabeli `$table`.");
				if(!$model->hasAttribute($column['name']))
				{
					$result[$column['name']]=$db->createCommand()->addColumn($table, $column['name'], $column['type']);
					$refresh=true;
					$this->addLog("Kolumna dodana.");
				}
				else
				{
					$result[$column['name']]=false;
					$this->addLog("Kolumna istnieje, pomijam.");
				}
			}
			if($refresh)
				$this->dbRefreshMetaData(array(get_class($model)));
		}
		return $result;
	}

	public function dbRenameColumns($model, $columns)
	{
		if(!is_array($columns))
			$columns=array($columns);
		$result=array();
		$db=$this->getDb();
		$table=$model->tableName();
		if(!empty($columns))
		{
			$this->dbRefreshMetaData(array(get_class($model)));
			$refresh=false;
			foreach($columns as $from=>$to)
			{
				if($model->hasAttribute($from))
				{
					$result[$to]=$db->createCommand()->renameColumn($table, $from, $to);
					$this->addLog("Zmieniam nazwę kolumny `$from` na `$to` tabeli `$table`.");
					$refresh=true;
				}
				else
					$result[$to]=false;
			}
			if($refresh)
				$this->dbRefreshMetaData(array(get_class($model)));
		}
		return $result;
	}

	public function dbCreateTable($table, $columns, $options=null, $foreignKeyConstraints=array())
	{
		$db=$this->getDb();
		if($options===true)
			$options=$this->defaultDbCreateTableOptions;
		$result=false;
		if(!$db->createCommand('SHOW TABLES LIKE "'.$table.'"')->queryScalar())
		{
			$db->createCommand()->createTable($table, $columns, $options);
			$this->addLog("Tworzę tabelę `$table`.");
			$this->dbRefreshMetaData();
			$result['table']=true;
		}
		if(!empty($foreignKeyConstraints))
			$result['foreignKeyConstraints']=$this->dbCreateForeignKeys($table, $foreignKeyConstraints);
		return $result;
	}

	public function updateCmsRecords($records)
	{
		$this->addLog("Aktualizacja danych cmsData.");
		foreach($records as $className=>$criterias)
		{
			$model=$className::model();
			foreach($criterias as $record)
				foreach($record['cmsRecords'] as $cmsRecord)
				{
					$model->getDbCriteria()->mergeWith($record['criteria']);
					if(!isset($cmsRecord[0])){
						var_dump($cmsRecord);die;}
					$cmsRecordAttributes=$cmsRecord[0];
					unset($cmsRecord[0]);
					if(!$foundModel=$model->cms(array($cmsRecordAttributes['name']))->find(array('params'=>$cmsRecord)))
						throw new Exception("Właściciel cmsData nie istnieje: kryteria wyszukiwania $className: '{$record['criteria']['condition']}' dla danych: ".http_build_query($cmsRecord, '', '', 0));
					if(!isset($foundModel->cmsData[$cmsRecordAttributes['name']]))
					{
						$cmsData=$foundModel->createCmsData($cmsRecordAttributes['name'], $cmsRecordAttributes);
						if(!$cmsData->save())
							throw new Exception("Błąd zapisu cmsData dla rekordu '$className'. ".QModel::implodeErrors($cmsData, ','));
						$this->addLog("Dodano dane cms o nazwie {$cmsRecordAttributes['name']} dla rekordu '$className'.");
					}
				}
		}
	}

	public function tableExists($tableName)
	{
 		return (bool)Yii::app()->db->createCommand('SELECT 1 FROM information_schema.tables WHERE table_schema=(SELECT DATABASE()) AND table_name="'.$tableName.'"')->queryScalar();
	}

	public function dbColumnExists($model, $columnName)
	{
		if(is_string($model))
			$model=$model::model();

		return array_key_exists($columnName, $model->getTableSchema()->columns);
	}

	public function getDbSql()
	{
		if($this->_dbSql===null)
		{
			$reflector = new ReflectionClass(get_class($this));
			$dbSqlPath=dirname($reflector->getFileName()).DIRECTORY_SEPARATOR.'dbSql.php';
			$this->_dbSql=is_file($dbSqlPath)?include($dbSqlPath):false;
		}
		return $this->_dbSql;
	}

	public function getSettings()
	{
		if($this->settings===null)
			$this->settings=Yii::app()->getComponent('settings')?Yii::app()->settings:false;
		return $this->settings;
	}

	public function updateSettings($newSettings, $force=false)
	{
		if(is_array($newSettings))
		{
			$sett=$this->getSettings();
			foreach($newSettings as $categoryName=>$category)
			{
				foreach($category as $key=>$value)
				{
					if($force||($sett->get($categoryName, $key)===null))
					{
						$sett->set($categoryName, $key, $value);
						$this->addLog("Zaktualizowano ustawienie: [$categoryName] $key => $value");
					}
				}
			}
		}
		else
			throw new Exception('Wymagana tablica nowych ustawień. Podano '.gettype($newSettings));
	}

	public function validateComponents($componentNames)
	{
		$result=array();
		$app=Yii::app();
		foreach($componentNames as $name)
		{
			$result[$name]=$app->getComponent($name)!==null;
			$app->setComponent($name, null);
		}

		return $result;
	}

	public function validateModules($moduleNames)
	{
		$result=array();
		$app=Yii::app();
		foreach($moduleNames as $name)
			$result[$name]=$app->hasModule($name)!==false;

		return $result;
	}
}