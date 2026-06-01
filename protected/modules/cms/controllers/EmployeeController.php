<?php

class EmployeeController extends CmsController
{
    public $defaultAction='indexCustomer';
	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='column2';
        public $layout='qFrontMain';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(

			array('allow',
                            'actions'=>array('createEmployee','viewEmployee'),
				'users'=>array('*'),
			),
                    
			array('allow',
				'users'=>array('@'),
                                'expression'=>'$user->isEmployee'
			),
                    
			array('deny',  // deny all users
				'users'=>array('*'),
			),

		);
	}
    
	/**
	 * Displays a particular model.
	 */
	public function actionViewEmployee()
	{
            
            //$this->layout = 'column2';
                $criteria=new CDbCriteria;
                $criteria->select="*";
                $criteria->compare('id', $_GET['id']);
                $artysta = Uzytkownik::model()->find($criteria);


		$this->render('viewEmployee',array(
			'model'=>Pracownik::model()->findByPk($_GET['id']),
                        'artysta'=>$artysta,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
        public function actionCreateEmployee()
        {
            $model=new EmployeeForm;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);
         /* */
            include_once './protected/modules/cms/components/PictureManager.php';
            $pictureManager = new PictureManager();
        /* */

            if(isset($_POST['Pracownik']))
            {
                $model->attributes=array('Pracownik'=>$_POST['Pracownik'], 'Uzytkownik'=>$_POST['Uzytkownik'],'isCompany'=>$_POST['isCompany']);
//var_dump($_POST['isCompany']);
//var_dump($_POST['Pracownik']);
//var_dump($_POST['Uzytkownik']);
                if($model->validate())
                {
			if($model->save()){
                            $model->uzytkownik->folder = $model->pracownik->id_uzytkownika;
//				$this->redirect(array('viewEmployee','id'=>$model->pracownik->id_uzytkownika));
                               
                                /* utworz foldery */
                                $pictureManager->createMainAndSubFolders('./pictures/user/'.$model->pracownik->id_uzytkownika, 'm', 'd');

                                $criteria=new CDbCriteria;
                                $criteria->select="*";
                                $criteria->compare('id', $model->pracownik->id_uzytkownika);
                                $modelUzytkownik = Uzytkownik::model()->find($criteria);
                                $modelUzytkownik->folder = $model->pracownik->id_uzytkownika;
                                $modelUzytkownik->update(array('folder'));

                                $this->redirect(array('site/thanks'));
                                return;
                        }
                }
            }
            $this->render('createEmployee',array(
			'model'=>$model));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdateEmployee()
	{
		$model=new EmployeeForm('update');
                $model->pracownik=Pracownik::load($_GET['id']);
                $model->uzytkownik=$model->pracownik->uzytkownik;
                $model->uzytkownik->haslo='';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pracownik']))
		{
			$model->attributes=array('Pracownik'=>$_POST['Pracownik'], 'Uzytkownik'=>$_POST['Uzytkownik']);
			if($model->save())
				$this->redirect(array('viewEmployee','id'=>$model->pracownik->id_uzytkownika));
		}

		$this->render('updateEmployee',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDeleteEmployee()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel(2)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('indexEmployee'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndexEmployee()
	{
            /**
             * @todo to do SCOPE'a
             */
		$dataProvider=new CActiveDataProvider
                (
                    'Pracownik',
                    array
                    (
                        'criteria'=>
                        array
                        (
                            'condition'=>'typ_uzytkownika BETWEEN 2 AND 9',
                            'with'=>array('uzytkownik')
                        )
                    )
                );

		$this->render('indexEmployee',array(
			'dataProvider'=>$dataProvider,
		));
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

        public function actionConfirm()
        {
            $model=Uzytkownik::load($_GET['id']);
            $model->confirm();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(array('viewCustomer','id'=>$model->id));
        }

       	public function actionCreateCustomer()
	{
		$model=new CustomerForm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Klient']))
		{
                    $model->attributes=array('Klient'=>$_POST['Klient'], 'Uzytkownik'=>$_POST['Uzytkownik'], 'Adres'=>$_POST['Adres'], 'Firma'=>$_POST['Firma'], 'isCompany'=>$_POST['isCompany']);
                    if($model->save())
				$this->redirect(array('viewCustomer','id'=>$model->klient->id_uzytkownika));
		}

		$this->render('createCustomer',array('model'=>$model));
	}

        public function actionViewCustomer()
	{
		$this->render('viewCustomer',array(
                    'model'=>Klient::load($_GET['id'])));
	}

        public function actionUpdateCustomerCompany()
	{
            $model=Klient::model()->with('klientFirma.firma')->findByPk($_GET['id']);

            if(isset($_POST['Firma']))
            {
                $model->getCompany()->typ_firmy=$_POST['Firma']['typ_firmy'];
                $model->getCompany()->save(false);
                $this->redirect(array('viewCustomer','id'=>$model->id_uzytkownika));
            }

            $this->render('updateCustomerCompany',array(
			'model'=>$model->getCompany()));
        }

        public function actionUpdateCustomer()
	{
		$model=new CustomerForm('update');
                $model->klient=Klient::load($_GET['id']);
                $model->uzytkownik=$model->klient->uzytkownik;
                $model->uzytkownik->haslo='';
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Klient']))
		{
                    $model->attributes=array('Klient'=>$_POST['Klient'], 'Uzytkownik'=>$_POST['Uzytkownik']);
			if($model->save())
				$this->redirect(array('viewCustomer','id'=>$model->klient->id_uzytkownika));
		}

		$this->render('updateCustomer',array(
			'model'=>$model,
		));
	}

        public function actionDeleteCustomer()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('indexCustomer'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

        public function actionIndexCustomer()
	{
		$dataProvider=new CActiveDataProvider
                (
                    'Klient',
                    array
                    (
                        'criteria'=>
                        array
                        (
                            'with'=>array('uzytkownik')
                        )
                    )
                );
                
		$this->render('indexCustomer',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdminCustomer()
	{
                $model=new Klient('search');
                $model->uzytkownik=new Uzytkownik;
                
		if(isset($_GET['Klient']))
			$model->attributes=array('Klient'=>$_GET['Klient'], 'Uzytkownik'=>$_GET['Uzytkownik']);

		$this->render('adminCustomer', array(
			'model'=>$model,//'dataProvider'=>$dataProvider
		));
	}
        
        public function actionAdminEmployee()
	{
		$model=new Pracownik('search');
                $model->uzytkownik=new Uzytkownik;
                
		if(isset($_GET['Pracownik']))
			$model->attributes=array('Pracownik'=>$_GET['Pracownik'], 'Uzytkownik'=>$_GET['Uzytkownik']);

		$this->render('adminEmployee',array('model'=>$model));
	}
}
