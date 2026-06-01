<?php

class CmsPageController extends CmsController
{
	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'column1';
        //public $defaultAction='create';
        public $defaultAction='displayPage';
        
        //to ma byc przekazane do widoku (displayPage)
        public $title;
        public $styl;
        public $txt;
        public $success;
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('captcha','showDetailsNews','showDetailsGallery','index','view','displayPage','displayGalleries','displayGalleriesList','contact', 'displayPageIframe'),
				'users'=>array('*'),
			),
/*
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'), //@ wszyscy zalogowani
			),
 */
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','backup','publicPage'),
				'users'=>array('admin'), //zalogowani jako admin / admin to jest manage
			),
			array('allow',
				'actions'=>array('admin','delete','create','update','backup','publicPage'),
				'users'=>array('su'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}



	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
             if (Yii::app()->user->isGuest){
                 $this->redirect('//cms/cmsPage/displayPage');
             }
            $model=new CmsPage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
            
		if(isset($_POST['CmsPage'])) {
                
		  $model->attributes = $_POST['CmsPage'];

                    if (empty($_POST['CmsPage']['title'])){
                        $model->title = $model->link_name;
                    }
                    $model->name = $model->link_name;                                        
                        
                    if (empty($_POST['CmsPage']['url'])){
                        //echo ">>>>>>>>> url pusty";
                        $name = $model->link_name;
                        $url = $model->url;
                        $prop_url = CmsPage::createURL($name); //tworze z name urla
                        if( CmsPage::checkURL($prop_url) ){
                            $model->url = $prop_url; //dodaje urla do nazwy
                        }

			if($model->save()){
                            
                            // zapis do lacznika
                            $modelPageElement = new PageElement;
                            $modelPageElement->id_page = $model->id;

                            if($model->function != 3){ // 3 = universalElement                            
                                $modelPageElement->id_universal_element = null;
                                $modelPageElement->id_element = null;
                            }else{
                                $layGroup = CmsPage::model()->getElement('id',$_POST['addOnsUniversalElement'],'CmsLayouts','group');
                                $ueId = CmsPage::model()->getElement('table_name',$layGroup,'CmsUniversal','id');                                 
                                $modelPageElement->id_universal_element = $ueId;
                                if(isset($_POST["CmsPage"]['param_2'])){
                                    $modelPageElement->id_element = $_POST["CmsPage"]['param_2'];
                                }
                            }
                            $modelPageElement->save();
                            /* --- */
                            
                            $order = $model->order;
                            $orderRet = CmsPage::model()->GetOrder('CmsPage', $order, Yii::app()->language.'_cms_page');                      
                            $this->redirect(array('view','id'=>$model->id));
                        }
                    }else{
                        //echo ">>>>>>>>> url NIE pusty";
                        $url = $model->url;
                        $prop_url = CmsPage::createURL($url);
                        $final_url = CmsPage::existsURL($prop_url);

//                            echo " DODAJE zmieniony ".$final_url;
                             $model->url = $final_url;

			if($model->save()){
                            
                            // zapis do lacznika
                            $modelPageElement = new PageElement;
                            $modelPageElement->id_page = $model->id;

                            if($model->function != 3){ // 3 = universalElement                            
                                $modelPageElement->id_universal_element = null;
                                $modelPageElement->id_element = null;
                            }else{
                                $layGroup = CmsPage::model()->getElement('id',$_POST['addOnsUniversalElement'],'CmsLayouts','group');
                                $ueId = CmsPage::model()->getElement('table_name',$layGroup,'CmsUniversal','id');                                 
                                $modelPageElement->id_universal_element = $ueId;
                                if(isset($_POST["CmsPage"]['param_2'])){
                                    $modelPageElement->id_element = $_POST["CmsPage"]['param_2'];
                                }
                            }
                            $modelPageElement->save();
                            /* --- */
                            
                            $order = $model->order;
                            $orderRet = CmsPage::model()->GetOrder('CmsPage', $order, Yii::app()->language.'_cms_page');

                            $this->redirect(array('view','id'=>$model->id));
                        }
                        
                    }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

            $model=new CmsPage;
            $id = $_GET['id'];
            $old_parent_id = CmsPage::model()->getElement('id', $id, 'CmsPage','parent_id');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CmsPage']))
		{
                  $model->attributes=$_POST['CmsPage'];

                    if (empty($_POST['CmsPage']['title'])){
                        $model->title = $model->link_name;
                    }         
                    $model->name = $model->link_name;
                    
                    if(empty($model->url)){
                        $link = $model->link_name;
                            $upd_url = CmsPage::createURL($link);
                            $upd_url = CmsPage::existsURL($upd_url);
                            $model->url = $upd_url;
                    }                  
                  
                    if (!empty($_POST['CmsPage']['url'])){ //url nie jest pusty - po create zawsze cos bedzie!
                        $url = $_POST['CmsPage']['url'];
                        $id = $_GET['id'];
                        
                        //$model->url = $final_url;
                        //$prop_url = CmsPage::createURL($url); //tu nie stworzy z name urla bo juz juest zrobiony(po create)
                        //$check = CmsPage::checkURL($prop_url); //zwroci false bo juz taki istnieje
                        $check = CmsPage::checkURLbyID($url,$id);
                        if( $check == false ){
                            //nie ma takiego urla w bazie moze smialo update_owac                            
                            $upd_url = CmsPage::createURL($url);
                            $upd_url = CmsPage::existsURL($upd_url);
                            $model->url = $upd_url;
                            //echo "zmiana URL!!!!!!!!!!!!!!!!";
                        }else {//echo "ten sam URL!!!!!!!!!!!!!!!!";
                        }

                    }

                    //Sprawdz czy z redirection nie zmieniono na inna funkcje
                    if($model->function != 4){ //4 = redirection
                          $model->param_1 = '';
                    }
                    
                    /* uzupelnij lacznik PageElement */
                    // w $_POST['addOnsUniversalElement'] = idUniversalnego elementu NP. MAPY (TRZEbA pobrac id z universal i dopiero zapisac w laczniku1)
                    // w $_POST["CmsPage"]['param_2'] = idElementu (universalnego) NP. mapaRynekGlowny (z map)
             
                    //szukaj w laczniu by id (jesli nie ma zrob nowy wpis
                    $modelPageElement = PageElement::model()->find('id_page=?',array($id));
                    
                    $layGroup = CmsPage::model()->getElement('id',$_POST['addOnsUniversalElement'],'CmsLayouts','group');
                    $ueId = CmsPage::model()->getElement('table_name',$layGroup,'CmsUniversal','id'); 
                   
                    if($modelPageElement){
                        // update
                        if($model->function != 3){ // 3 = universalElement                            
                            $modelPageElement->id_universal_element = null;
                            $modelPageElement->id_element = null;
                        }else{                        
                            $modelPageElement->id_universal_element = $ueId;
                            if(isset($_POST["CmsPage"]['param_2'])){
                                $modelPageElement->id_element = $_POST["CmsPage"]['param_2'];
                            }
                        }                        
                        
                    }else{
                        // create (bo nie istnieje)
                        $modelPageElement = new PageElement;
                        $modelPageElement->id_page = $id;
                        
                        if($model->function != 3){ // 3 = universalElement                            
                            $modelPageElement->id_universal_element = null;
                            $modelPageElement->id_element = null;
                        }else{
                            $modelPageElement->id_universal_element = $ueId;
                            if(isset($_POST["CmsPage"]['param_2'])){
                                $modelPageElement->id_element = $_POST["CmsPage"]['param_2'];
                            }
                        }
                    }
                    $modelPageElement->save();
                    /* --- */

                    //sprawdza czy zmienil sie parent id
                    if($old_parent_id != $model->parent_id ){
                        if($model->save()){
                            $lastOrder = '999999';
                            $element = CmsPage::model()->find('id=?', array($model->id));
                            
                            $element->order = $lastOrder;
                            $element->update(array('order')); //ustawiam order na 999999

                            $model=new CmsPage;
                            $orderNew = CmsPage::model()->find('id=?', array($_GET['id']));
                            $order = $orderNew->order;
                            
                            $orderRet = CmsPage::model()->GetOrder('CmsPage', $order, Yii::app()->language.'_cms_page');
                            $this->redirect(array('view','id'=>$orderNew->id));
                        }
                    }

			if($model->save()){
                            $order = $model->order;
                            $orderRet = CmsPage::model()->GetOrder($model, $order, Yii::app()->language.'_cms_page');

                            $this->redirect(array('view','id'=>$model->id));
                        }

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

        public function actionPublicPage(){

                $id = $_GET['id'];
                $model=$this->loadModel($id);
                $model->display = $_GET['p'];
                $model->save();
                    
		$this->render('update',array(
			'model'=>$model,
		));            
        }
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

		}else if(isset($_GET['id'])){
                    $id = $_GET['id'];                    
                    $this->loadModel($id)->delete();
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('create'));
                }
		else{
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                }
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CmsPage');
                
                if(isset($_GET['lang'])){
                    Yii::app()->user->setLanguage($_GET['lang']);
                }

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CmsPage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CmsPage']))
			$model->attributes=$_GET['CmsPage'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionDisplayPage($url=null)
	{
        $this->layout="//layouts/iframe";
//		$this->render('//mobile/displayMobilePage',array(
//			'model'=>$this->loadModelBy_url($_GET['url']),
//		));
//        Yii::app()->end();

                if($url == null){
                    $url="";    
                }
                if(isset($_GET['lang'])){
                    Yii::app()->user->setLanguage($_GET['lang']);
                }
                if(isset($_GET['url'])){
                    $url=$_GET['url'];
                }else {
                    $criteria = new CDbCriteria;
                    $criteria->compare('display',1);
                    $criteria->order='`order`';
                    $criteria->limit=1;
//echo "jest";
                    $defaultPage = CmsPage::model()->findAll($criteria);
//echo "jest";
                    $url = $defaultPage[0]->url;
//echo "jest".$defaultPage[0]->url;
                }
                
                     

                        
//echo "<p>pokaz URL ".$url.' <p>';
                        
		$model=$this->loadModelBy_url($url);

                $function = $model->getAttribute('function');
                switch($function){
// 1-normal 2-contact 3-universalEl 4-redirection
                    
//                    case '2': //'f_contact':
//                        /* pierwsze pokazanie formularza Yii */
//                            $modelContact=new ContactForm;
//            	
//                            $this->render('displayPage',array(
//                                    'model'=>$model,
//                                    'modelContact'=>$modelContact,
//                            ));
//                        break;
//                    
//                    case '3':
////                        echo 'function universal element<p>';
//                            $this->render('displayPage',array(
//                                    'model'=>$model,
//                            ));
//                        break;
                    case '4':
                        // REDIRECTION
                            $model->layout = 4;
                            $this->render('displayPage',array(
                                    'model'=>$model,
                            ));
                        break;
                    default:
                    	$this->render('displayPage',array(
                            'model'=>$model,
                        ));
                        break;
                }
	}
        
        public function actionDisplayPageIframe($url=null)
	{
        $this->layout="//layouts/iframe";
//		$this->render('//mobile/displayMobilePage',array(
//			'model'=>$this->loadModelBy_url($_GET['url']),
//		));
//        Yii::app()->end();

                if($url == null){
                    $url="";    
                }
                if(isset($_GET['lang'])){
                    Yii::app()->user->setLanguage($_GET['lang']);
                }
                if(isset($_GET['url'])){
                    $url=$_GET['url'];
                }else {
                    $criteria = new CDbCriteria;
                    $criteria->compare('display',1);
                    $criteria->order='`order`';
                    $criteria->limit=1;
//echo "jest";
                    $defaultPage = CmsPage::model()->findAll($criteria);
//echo "jest";
                    $url = $defaultPage[0]->url;
//echo "jest".$defaultPage[0]->url;
                }
                
                     

                        
//echo "<p>pokaz URL ".$url.' <p>';
                        
		$model=$this->loadModelBy_url($url);

                $function = $model->getAttribute('function');
                switch($function){
// 1-normal 2-contact 3-universalEl 4-redirection
                    
//                    case '2': //'f_contact':
//                        /* pierwsze pokazanie formularza Yii */
//                            $modelContact=new ContactForm;
//            	
//                            $this->render('displayPage',array(
//                                    'model'=>$model,
//                                    'modelContact'=>$modelContact,
//                            ));
//                        break;
//                    
//                    case '3':
////                        echo 'function universal element<p>';
//                            $this->render('displayPage',array(
//                                    'model'=>$model,
//                            ));
//                        break;
                    case '4':
                        // REDIRECTION
                            $model->layout = 4;
                            $this->render('displayPage',array(
                                    'model'=>$model,
                            ));
                        break;
                    default:
                    	$this->render('displayPage',array(
                            'model'=>$model,
                        ));
                        break;
                }
	}

        public function actionShowDetailsNews(){
            // klik z listy newsow
            // $_GET['nid'] = id newsa
            if(isset($_GET['nid']) && $_GET['nid'] != ''){
                $model= CmsPage::model()->find('url=?',array($_GET['url']));
                $model->layout = 31; // news Details layout
                $this->render('displayPage',array(
                    'model'=>$model,
                ));
            }else{
                throw new CHttpException(404,Yii::t(Yii::app()->language.'_YiiTranslation', 'The requested page does not exist.'));
            }
        }
        
        public function actionShowDetailsGallery(){
            // klik z listy galerii
            // $_GET['gid'] = id newsa
            if(isset($_GET['gid']) && $_GET['gid'] != ''){
                $model= CmsPage::model()->find('url=?',array($_GET['url']));
                $model->layout = 36; // gallery Details layout
                $this->render('displayPage',array(
                    'model'=>$model,                
                ));
            }else{
                throw new CHttpException(404,Yii::t(Yii::app()->language.'_YiiTranslation', 'The requested page does not exist.'));
            }
        }            
        
        
        
        
        public function actionDisplayGalleriesList(){
		$model=new CmsGallery;
                $modelGalleryPicture=new CmsGalleryPicture;

		$this->render('/cmsGallery/displayGalleries',array(
			'model'=>$model,
                        'modelGalleryPicture'=>$modelGalleryPicture,
		));
        }

        public function actionDisplayGalleries($id){
		$model=$this->loadGalleryModel($id);

                $modelGalleryPicture=CmsGalleryPicture::model()->find('image=?',array($model->image));
                
		$this->render('/cmsGallery/displayGalleries',array(
			'model'=>$model,
                        'modelGalleryPicture'=>$modelGalleryPicture,
		));
        }        


        /* 
         * Backup i restore bazy danych
         */
        public function actionBackup(){
		$model=new CmsPage;

		if(isset($_POST['CmsPage']))
		{
                  $model->attributes=$_POST['CmsPage'];

                    //BACKUP
                    if( $model->param_1 == 1 ){ //tylko backup zaznaczony
                        //cmsPage model - funkcja backupu
                        $model->BackupDateBase();
                        $this->redirect(array('backup'));
                    }//end if backup

                    //RESTORE
                    if( $model->param_2 == 1 ){ //tylko restore zaznaczony
                        //cmsPage model - funkcja backupu                        
                        if(isset($_GET['restore'])){
                           
                            $restore_file = $_GET['restore'];
                            $file_exist = './backup/'.$restore_file;
                            if (file_exists($file_exist)){
                                $model->RestoreDateBase($restore_file);
                                $this->redirect(array('backup'));
                            }else{
                                echo "Plik nie istnieje"; return;
                            }
                        }
                    }//end if restore
                  
                }

                //usuwanie backupu
                if(isset($_GET['delete'])){
                    $delete_file = './backup/'.$_GET['delete'];
                    if (file_exists($delete_file)){                        
                        unlink($delete_file);
                        $this->redirect(array('backup'));
                    }else{
                        echo "Plik nie istnieje"; return;
                    }
                }


		$this->render('/cmsPage/backup',array(
			'model'=>$model,  
		));

        }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CmsPage::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

        /* Laduje model po url */
	public function loadModelBy_url($url)
	{
            //okreslam kryteria wyszukiwania z bazy
                $criteria=new CDbCriteria;
                $criteria->compare('url', $url); // compare szuka (co, numer (id?))

		$model=CmsPage::model()->find($criteria);
		if($model===null)
			throw new CHttpException(404,'ERROR The requested page does not exist.');
		return $model;
	}

        
        /* Laduje model galerii */
	public function loadGalleryModel($id)
	{
		$model=CmsGallery::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cms-page-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
	public function actionContact(){
		$model=new ContactForm;                               
            
		if(isset($_POST['ContactForm'])) {
			$model->attributes=$_POST['ContactForm'];
			if($model->validate()){			

                //$od='From';
				//$header="'.$od.' {$model->email}\r\nReply-To: {$model->email}";
				//mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$header);
                             
              ob_start(); 
                Yii::import('application.extensions.phpmailer.JPhpMailer');
                $mail = new JPhpMailer;
                $SMTPDebug = true;
                //$mail->IsSMTP();
                $mail->CharSet = "UTF-8";
                $mail->Host = Yii::app()->params['mail_host'];
                $mail->SMTPAuth = true;
                $mail->Port = '587';
                $mail->Username = Yii::app()->params['mail_username'];
                $mail->Password = Yii::app()->params['mail_password'];
                $mail->SetFrom("carguide@mtp.ie", 'mtp system');
                $mail->Subject = "From: ".$model->email." ".$model->subject;
                $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
                $mail->MsgHTML("From: ".$model->email."<br />Name: ".$model->name."<br />".$model->body);

                if(empty(Yii::app()->params['adminEmail']) || Yii::app()->params['adminEmail'] == "")
                    $mail->AddAddress("contact@mtp.ie");
                else
                    $mail->AddAddress(Yii::app()->params['adminEmail']);
                
                $mail->Send();
                $mail->ClearAddresses();
                $mail->ClearAttachments();
             ob_end_clean();
             
				Yii::app()->user->setFlash('contact','Message sent.');
				$this->refresh();
			}
                        $this->render('displayPage',array('url'=>$_GET['url']));exit;
		}
           $this->actionDisplayPage($_GET['url']);
	}        
        
}
