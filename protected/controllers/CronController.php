<?php
class CronController extends Controller
{
	public function actionImportAutoArchive()
	{
		ini_set('max_execution_time', '360');
		//current month
		$month = date('m');
		//default no archive needed for commercial cars
		$importCarsCom = 0;
        $importCarLinks = 1;
        $importCommsLinks = 1; 
        //check if comms cars needs to Archive or not
		if( $month / 2 != 0){
			//here commercial cars need to archive
			$importCarsCom = 1; 
		}
		//get the last date of previous month
		$prevMonthLastDate = date('Y-m-d', strtotime('last day of previous month'));
		$nameArch = date("F Y", mktime(null, null, null, $month));
        //process to import Archive cars
        Import::model()->importXmlFiles($importCarsCom, $prevMonthLastDate, $nameArch, $importCarLinks, $importCommsLinks);
        
        // $this->actionImportXmlFilesMain();
	}
}