<?php
class DefaultController extends Controller
{
	public function actionIndex()
	{
		if(isset($_GET['version']))
		{
			$this->module->importVersionUpgradeClass($_GET['version']);
			$class=$this->module->getVersionUpgradeClass($_GET['version']);
			$upgradeSystem=new $class;

			if(!empty($_POST['run']))
			{
				$upgradeSystem->run();
			}
		}
		else
			$upgradeSystem=null;

		$this->render('index', array('upgradeSystem'=>$upgradeSystem));
	}
}