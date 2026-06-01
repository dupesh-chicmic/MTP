<?php
class AdminController extends CController
{
	public function viewLogs()
	{
		if(is_file($logPath=Yii::getPathOfAlias('application.runtime').DIRECTORY_SEPARATOR.'realex_response.log'))
		{
			$log=file_gets_content($logPath);
			$this->render('viewLogs', array('log'=>$log));
		}
	}
}