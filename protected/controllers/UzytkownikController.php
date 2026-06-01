<?php

class UzytkownikController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array(''),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('changeUserDataForm','userAccount','create','update', 'userAccountIframe'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
            
		$model=new Uzytkownik;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Uzytkownik']))
		{
			$model->attributes=$_POST['Uzytkownik'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Uzytkownik']))
		{
			$model->attributes=$_POST['Uzytkownik'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
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
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Uzytkownik');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Uzytkownik('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Uzytkownik']))
			$model->attributes=$_GET['Uzytkownik'];

		$this->render('admin',array(
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
		$model=Uzytkownik::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='uzytkownik-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        

        // --- user account actions
        public function actionUserAccount(){
            //$this->layout='mainSubPage';
            $this->layout = 'iframe';
            $myId = Yii::app()->user->getId();
            
            if(empty($myId)){
                $this->redirect(array('site/loginIframe'));
                exit;
            }else{
                $model = Uzytkownik::model()->find(array(
                    'condition'=>'id=:uid',
                    'params'=>array(':uid'=>$myId)
                ));                
                $this->render('userAccount',array('model'=>$model));
                exit;
            }
        }
        
                public function actionUserAccountIframe(){
            $this->layout='iframe';
            $myId = Yii::app()->user->getId();
            
            if(empty($myId)){
                $this->redirect(array('site/loginIframe'));
                exit;
            }else{
                $model = Uzytkownik::model()->find(array(
                    'condition'=>'id=:uid',
                    'params'=>array(':uid'=>$myId)
                ));                
                $this->render('userAccount',array('model'=>$model));
                exit;
            }
        }

        
        public function actionChangeUserDataForm(){
            //$this->layout='mainSubPage';
            $this->layout = 'iframe';
            
            $myId = Yii::app()->user->getId();
            
            if(empty($myId)){
                $this->redirect(array('site/loginIframe'));
                exit;
            }else{
                $model = Uzytkownik::model()->find(array(
                    'condition'=>'id=:uid',
                    'params'=>array(':uid'=>$myId)
                ));             

                if(isset($_POST['Uzytkownik']) && $_POST['Uzytkownik'] != ''){
                    if(isset($_GET['id']) && $_GET['id'] != ''){
                      if($myId != $_GET['id']){
                          Yii::app()->user->setFlash('accountError','You cannot change data another user! Shame on You!');
                      }else{
                        $temp_encrypted_present_password=$model->haslo; 
                          
                        $model->attributes = $_POST['Uzytkownik'];
                        if($model->validate()){
                            // check old / new password
                            if(!empty($_POST['Uzytkownik_old_password']) && !empty($model->haslo)){
                                
                                // $tempCurrentPassword_encrypted,$oldPasswordField,$newPasswordField,$newPasswordField_confirm
                                $newPass_encrypted = Uzytkownik::model()->validateChangePassword($temp_encrypted_present_password,$_POST['Uzytkownik_old_password'],$model->haslo,$_POST['confirm_new_password']);
                                if(!empty($newPass_encrypted)){
                                    // ! password (passwordField)  was encrypt sha1 automatically
                                    $model->haslo = $newPass_encrypted;
                                    $model->update(array('haslo'));
                                    $model->update(array('email'));
                                    $model->update(array('login'));
                                    $model->update(array('imie'));
                                    $model->update(array('nazwisko'));
                                }
                                
                            }else{
                                $model->update(array('login'));
                                $model->update(array('imie'));
                                $model->update(array('nazwisko'));
                                Yii::app()->user->setFlash('accountSuccess','Data was updated successfully<br />Password was NOT changed.');
                            }
                        }else{
                            $errors = $model->getErrors();
                            //pobierz errory
//                            $errorMsg = '';
//                            foreach($errors as $msg){
//                                $errorMsg .= $msg.'<br />';
//                                Yii::app()->user->setFlash('accountError',$errorMsg);
//                            }
                        }
                      }
                    }
                }
                $this->render('userAccount',array('model'=>$model));
                exit;
            }            
        }
        // ---

        
}
