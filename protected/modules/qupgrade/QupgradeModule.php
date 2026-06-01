<?php
class QupgradeModule extends CWebModule
{
	public $upgradeFilesPath;

	public function init()
	{
		$this->setImport(array(
			'qupgrade.components.*',
		));
	}

	/*public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}*/

	public function getVersion()
	{
		$result=array();
		$result['app_version']=Yii::app()->params['version']?Yii::app()->params['version']:'nieznana';
		if(@class_exists('QSystem', false))
		{
			$t=QSystem::model()->getParam('db_version');
			$result['db_version']=$t?$t:'nieznana';
		}
		else
			$result['db_version']='nieznana';

		return $result;
	}

	public function getUpgrades()
	{
		$upgrades=array();

		if($this->upgradeFilesPath)
		{
			foreach(new DirectoryIterator($this->getVersionFileUpogradePath()) as $file)
				if(!$file->isDot()&&$file->isDir())
					$upgrades[]=$file->getFileName();
		}
		else
			$upgrades=false;

		return $upgrades;
	}

	public function getVersionFileUpogradePath($version='')
	{
		return Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR.$this->upgradeFilesPath.DIRECTORY_SEPARATOR.$version;
	}

	public function getVersionUpgradeClass($version)
	{
		foreach(new DirectoryIterator($this->getVersionFileUpogradePath($version)) as $file)
			if($file->isFile()&&substr($file->getFileName(), -11)=='Upgrade.php')
					return substr($file->getBaseName(), 0, -4);
		return false;
	}

	public function importVersionUpgradeClass($version)
	{
		include($this->getVersionFileUpogradePath($version).DIRECTORY_SEPARATOR.$this->getVersionUpgradeClass($version).'.php');
	}
}
