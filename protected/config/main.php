<?php
	require('config.php');
	// define('YII_DEBUG',false);
	$protocol="https";

	if(isset($_SERVER['HTTPS'])){
       $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
   	}
   	$dataC = (dirname(substr($_SERVER['SCRIPT_FILENAME'], strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) )));
   	$directoryName=( $dataC =='/' || $dataC == ".") ?"/": $dataC.'/';

	define('URL', $protocol."://".$_SERVER['HTTP_HOST']."".$directoryName);
	$websitesurl=array(
		'mobile'=>$_ENV['THE_GUIDE_URL'],
		// 'admin'=>$_ENV['ADMIN_URL'],
		'api'=>$_ENV['API_URL'],
		// 'app'=>$_ENV['APP_URL']
	);

	$websiteType="";
	$loginUrl=array();
	foreach($websitesurl as $key=>$value){
		if(in_array(URL, $value) ){
			$websiteType=$key;
			$loginUrl=array('site/loginIframe');
		}
	}
	// uncomment the following to define a path alias
	// Yii::setPathOfAlias('local','path/to/local-folder');

	// This is the main Web application configuration. Any writable
	// CWebApplication properties can be configured here.

    include_once './protected/components/Serialization.php';
    $serialization = new Serialization();

    $deserializedArray = $serialization->deserialize( $serialization->getPathToFile() );

	$emailData = array(
		// this is used in contact page
		'adminEmail'=>'carguide@mtp.ie ',
        // ustawienia mailowe
        'mail_host'=>'mail.mtp.ie',
        'mail_username'=>'contact@mtp.ie',
        'mail_password'=>'',
        'mail_from'=>'MTP.IE',

        'dinkey'=>array(
            'M_LibrariesURL'=>'http://localhost/dinkey/libs',
            'M_ErrorPageURL'=>'http://localhost/dinkey/dinkeyweberr.php',
        ),
        'googleAnalyticsCode'=>'UA-33837535-1',
	);

	if(!empty($deserializedArray)){
		$serializationParams = $deserializedArray;
	}
	$serializationParams = array_merge($serializationParams,$emailData);

	return array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'MTP',
			'language'=>'en',

		// preloading 'log' component
		'preload'=>array('log'),

		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
			'application.components.dinkey.*',
			'application.components.dinkey.libs.*',
			'application.components.dinkey.libs.protected.*',
		),


		'modules'=>array(
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'xerdcftyuiol',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>false,//array('127.0.0.1','::1'),
			),
			'cms',
			'qpay'=>array('modules'=>array('qpayrealex'=>array('responseRoute'=>'http://mtp.ie/app/index.php?r=/realex/handleResponse'))),
			'qupgrade'=>array('upgradeFilesPath'=>'/protected/data/upgrades'), //relative to webroot
			'debug' => array(
				'class' => 'yii\debug\Module',
				'allowedIPs'=> array('*'),
			),
		),

		// application components
		'components'=>array(
			'user'=>array(
						'class'=>'WebUser',
			),
				'session'=>array(
						'class' => 'CDbHttpSession',
						'sessionName'=>'MTP',
						'timeout'=>86400,
						'autoStart'=>true,
						'savePath'=>'.',
					),
			'mobileDetect' => array(
				'class' => 'ext.MobileDetect.MobileDetect'
			),
			'request'=>array(
				'enableCsrfValidation'=>false,
			),

				'db'=>array(
				'connectionString'=>'mysql:host='.$_ENV['HOST'].';dbname='.$_ENV['DBNAME'].';',
				'username' => $_ENV['USERNAME'],
				'password' =>$_ENV['PASSWORD'],
				'charset'=>$_ENV['CHARSET'],
				'enableProfiling'=>true,
				'enableParamLogging' => true,
			),


			'errorHandler'=>array(
				// use 'site/error' action to display errors
				'errorAction'=>'site/error', //TODO: errorPage - zmienic na strone FRONTOWA (!)
			),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning',
					),
					array(
						'class'=>'CProfileLogRoute',
						'levels'=>'profile',
						'enabled'=>false,
					),
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'info',
						'categories'=>'qpay',
						'logFile'=>'qpay_realex.log',
					),
				),
			),
			'cache'=>array(
				'class'=>'system.caching.CFileCache',
			),
			'settings'=>array(
				'class'             => 'ext.settings.CmsSettings',
				'cacheComponentId'  => 'cache',
				'cacheId'           => 'settings',
				'cacheTime'         => 84000,
				'tableName'     => 'settings',
				'dbComponentId'     => 'db',
				'createTable'       => false,
				'dbEngine'      => 'InnoDB',
			),
			'curl' => array(
			'class' => 'application.extensions.curl.Curl',
			),
		),

		'params'=>array_merge(array(
			'RIVehicleData'=>array(
				'memberID'=>'MTP',
				'sessionDuration'=>31536000,
				'free'=>array(
					'url'=>'https://vqslx.riskintelligence.ie/VehicleQueryReport.asmx',
					'username'=>'mtpfree',
					'password'=>'XMG3HE7d',
				),
				'paid'=>array(
					'url'=>'https://pre-production-rii.moneymate.com/vqs/vehiclequery.asmx?wsdl',
					'username'=>'mtppaid',
					'password'=>'XMG3HE7d',
				)
			),
			
			'website'=>array(
				'ADMIN'=>'admin',
				'MOBILE'=>'mobile',
				'API'=>'api',
				'APP'=>'app'
			),
			'is_test_version'=>false,
			'main_url'=>URL,
			'website_type'=>$websiteType,
			'login_url'=>$loginUrl,
			'admin_url'=>$_ENV['ADMIN'],
			'app_url'=>$_ENV['APP'],
			'api_url'=>$_ENV['API'],
			'site_url'=>$_ENV['SITE'],
			'mobile_url'=>$_ENV['THE_GUIDE'],
			'import_folder'=>	$_ENV['import_folder'],
			'used_car_com_code_column_visibility'=>false,
			'app_mode'	=>	$_ENV['app_mode'],
			'pdf_passenger'	=>	$_ENV['pdf_passenger'],
			'pdf_commercial'	=>	$_ENV['pdf_commercial'],
			$serializationParams
		))
	);