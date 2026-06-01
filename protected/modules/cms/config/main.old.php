<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.


    include_once './protected/components/Serialization.php';
    $serialization = new Serialization();

    $deserializedArray = $serialization->deserialize( $serialization->getPathToFile() );
   
if(!empty($deserializedArray)){
    $serializationParams = $deserializedArray;
}

    $language = Yii::app()->params['admin_lang'][1];
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Qbix',
        'defaultController'=>'site',
        'language'=>'pl',    //''.$language.'',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
                'application.models.forms.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'su',
		),
		
	),
        //main page
        //'homeUrl'=>array('path'),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			//'allowAutoLogin'=>true,
                        'class' => 'WebUser', 
		),
        'session'=>array(
                'sessionName'=>'QBIX',//TODO Mike:zmien nazwe sesji
                'timeout'=>99999,
                'autoStart'=>false,
                'savePath'=>session_save_path().''
            ),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
            /*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
             *
             */
		// uncomment the following to use a MySQL database
		

'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=qbix_start',
			'emulatePrepare' => true,
                        'username' => 'root',
			'password' => 'root',
			'charset' => 'utf8',
		),
//         'db'=>array(
//			'connectionString' => 'mysql:host=sql.a0copyplot.nazwa.pl;dbname=a0copyplot',
//			'emulatePrepare' => true,
//			'username' => 'a0copyplot',
//			'password' => 'LAla@1234',
//			'charset' => 'utf8',
//		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages

                            // LOG
//				array(
//					'class'=>'CWebLogRoute',
//				),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>$serializationParams
);