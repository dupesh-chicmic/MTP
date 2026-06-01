<?php

class SiteController extends CmsController
{
	/**
	 * Declares class-based actions.
	 */
        public $defaultAction='pass';
        public $layout='universal_element_column';
        public $displayBottomBanners=false;
        public $dispLeftCols = 0;
        public $dispRightCols = 0;
        public $title = "Logowanie";
        public $txt = "";
        public $error = "";
        private $_model;
        public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

        public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('settings'),
                                'users'=>array('@'),
                                'expression'=>'$user->isEmployee'
			),
                        array('allow',
                            'actions'=>array('pass'),
				'users'=>array('*'),
			),
                        array('deny',
                              'actions'=>array('pass', 'logout'),
				'users'=>array('?'),
			),

			array('allow',
                            'actions'=>array('addFavorites','deleteFavorites','sendMail','serializeNewElement','deleteSerializedElement','editSerializedElement','payment_ok','payment_cancelled','add_element_popup','chooseRegisterUser','thanks'),
				'users'=>array('*'),
			),
		);
	}

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
               // echo 'tu'.$_SESSION['cms_id'];
 if( (Yii::app()->getUser()->getName() == 'admin') || (Yii::app()->getUser()->getName() == 'su') ){
        //echo $this->render('index');
        $this->redirect(array('/cms/cmsPage/create'));
 }else{     
     
     $urlHome = CmsPage::model()->getElement('id', 4, 'CmsPage', 'url');
     $this->redirect(array('/cms/cmsPage/displayPage','url'=>$urlHome));
     exit;
//                $criteria=new CDbCriteria;
//                $criteria->select="*";
//                $criteria->compare('id', Yii::app()->user->getId());
//                $model = Uzytkownik::model()->find($criteria);
//                //echo $model->typ_uzytkownika; exit;
//                if($model->typ_uzytkownika == 2){ //pracownik/artysta
//                    $this->render('logged_artist',array(
//                            'model'=>$model,
//                    ));
//                    exit;
//                }

		$this->render('logged_client',array(
			'model'=>$model,
		));
 }


            //$this->render('index');
            //$this->redirect(array('Oferta/zamawianie'));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{            
	    if($error=Yii::app()->errorHandler->error){
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

        public function actionSettings(){	
            $this->layout='universal_element_column_back';
		$this->render('settings');                
	}

        public function actionPage()
	{
		//$model=$this->loadModel();
		$model=CmsPage::model()->find(array(
                            'select'=>'*',
                            'condition'=>'url="'.$_GET['url'].'"',
                    )
                    );
		$this->render('page',array('model'=>$model));
	}

        public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=CmsPage::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'Wybrany adres nie istnieje.');
		}
		return $this->_model;
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
            $this->layout = 'none';
            $model=new LoginForm;

            if(isset($_POST['LoginForm']))
            {
                $model->attributes=$_POST['LoginForm'];
//var_dump($model->attributes);
                //echo $model->login = $_POST['LoginForm']['login'];

                if($model->validate())
                {
                    $this->forward('pass');
                    //$this->redirect(Yii::app()->user->returnUrl);
                }
            }
        
            $this->render('login',array('model'=>$model));
        }

        public function actionPass()
        {
            if(Yii::app()->user->isGuest){
                   // $this->redirect(array('site/login'));
                    $this->redirect(array('/cms/cmsPage/displayPage','url'=>'home'));
                    //echo "tututu";
            }

            if(Yii::app()->user->isAdmin){
                $this->layout='main';
                //$this->redirect(array('cms/cmsPage/displayPage','url'=>'home'));
                $this->redirect(array('/cms/site/index'));
            }
                    //$this->redirect(array(''));

            /**
             *@TODO: pracownik dostaje na dzień dobry panel ofertowy, do adjustu
             */

            if(Yii::app()->user->isEmployee)
                $this->redirect(array('site/index'));

            $this->redirect(array('site/index'));
            
            //$this->redirect(array('customer/'));
/* nie byo tego u Olexa
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
 * /*
 */
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

        public function actionThanks(){
            $this->render('thanks');
        }
        
        public function actionChooseRegisterUser(){

            if(!empty($_POST)){                
                if(isset($_POST['artysta'])){                                        
                    $this->redirect(array('Employee/createEmployee'));                   
                    exit;
                }else{                   
                    $model=new CustomerForm;
                    $this->render('newCustomer',array('model'=>$model));
                    exit;
                }
            }
            $this->render('registerType');
        }

       public function actionNewCustomer()
        {
    // uncomment the following code to enable ajax-based validation
    /*
    if(isset($_POST['ajax']) && $_POST['ajax']==='new-customer-form-newCustomer-form')
    {
        echo CActiveForm::validate($model);
        Yii::app()->end();
    }
*/
         /* */
            include_once './protected/modules/cms/components/PictureManager.php';
            $pictureManager = new PictureManager();
        /* */
            $model=new CustomerForm;

            if(isset($_POST['Klient']))
            {
                $model->attributes=array('Klient'=>$_POST['Klient'], 'Uzytkownik'=>$_POST['Uzytkownik'], 'Adres'=>$_POST['Adres'], 'Firma'=>$_POST['Firma'], 'isCompany'=>$_POST['isCompany']);

                if($model->validate()){
                   $model->folder = $model->id;
                   //var_dump();
                   
                    if($model->save())
                    {
                        /* utworz foldery */
                        $pictureManager->createMainAndSubFolders('./pictures/user/'.$model->folder, 'm', 'd');

                        $this->render('thanks');
                        return;
                    }
                }
            }

            $this->render('newCustomer',array('model'=>$model));

        }
        
        public function actionSendMail(){
                $criteria=new CDbCriteria;
                $criteria->select="*";
                $criteria->compare('id', Yii::app()->user->getId());                
                $User = Uzytkownik::model()->find($criteria);
                		
                $model = new CmsArticle;
                if(isset($_POST['CmsArticle']))
                {
                $text = $model->info_3;
                
                    Yii::import('application.extensions.phpmailer.JPhpMailer');
                    $mail = new JPhpMailer;
                    $mail->IsSMTP();
                    $mail->Host = 'smpt.163.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'yourname@163.com';
                    $mail->Password = 'yourpassword';
                    $mail->SetFrom('yourname@163.com', 'yourname');
                    $mail->Subject = 'PHPMailer Test Subject via smtp, basic with authentication';
                    $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                    $mail->MsgHTML(''.$text.'<p>'.$User->imie.' '.$User->nazwisko.'');
                    $mail->AddAddress('john.doe@otherdomain.com', 'John Doe');
                    $mail->Send();                
                }
            
        }



    public function actionSerializeNewElement(){
        
        include_once './protected/components/Serialization.php';
        $serialization = new Serialization();

            $pathToFile = $serialization->getPathToFile();

            $deserializedArray = $serialization->deserialize( $pathToFile );

            //$title = CmsPage::createURL($_POST['title']);
            $title = str_replace("\"", "", $_POST['title']);
            $key = CmsPage::createURL($_POST['key']);
            //$value = CmsPage::createURL($_POST['value']);
            $value = $_POST['value'];

            $serialization->addConfigElement($deserializedArray, $title, $key, $value, $pathToFile );
            
            $this->redirect('index.php?r=cms/site/settings');
    }
    
    public function actionDeleteSerializedElement(){
        include_once './protected/components/Serialization.php';
        $serialization = new Serialization();
        
            $pathToFile = $serialization->getPathToFile();

            $deserializedArray = $serialization->deserialize( $pathToFile );

            $serialization->deleteConfigElement($deserializedArray, $_GET['t'], $_GET['element'], $pathToFile );
            
            $this->redirect('index.php?r=cms/site/settings');                
    }
    
    public function actionEditSerializedElement(){
        include_once './protected/components/Serialization.php';
        $serialization = new Serialization();
        
        $pathToFile = $serialization->getPathToFile();
        
        if(empty($_GET['edit'])){
            if(!empty($_GET['row'])){
                $this->redirect('index.php?r=cms/site/settings&element='.$_GET['element'].'&edit=1&row=1');
            }else{
                $this->redirect('index.php?r=cms/site/settings&element='.$_GET['element'].'&edit=1');
            }
        }
    
    }
    
          public function actionCars()
	{
            
           $this->render('newCars');
            
	}

    
}

