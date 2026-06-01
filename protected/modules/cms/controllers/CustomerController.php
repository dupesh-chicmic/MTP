<?php

class CustomerController extends CmsController
{
    //public $layout='column2';
    public $layout='qFrontMain';
    
        public function accessRules()
	{
		return array(
			array('allow',
				'users'=>array('@'),
                                'expression'=>'$user->isCustomer'
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

       	public function actionSettings()
	{
            $this->render('settings');
	}

        public function actionChangePassword()
        {
            $model=new PasswordForm;
            $model->uzytkownik=Yii::app()->user->model->uzytkownik;

            if(isset($_POST['PasswordForm']))
            {
                $model->attributes=$_POST['PasswordForm'];
                if($model->validate())
                {
                    if($model->uzytkownik->save(false, array('haslo')))
                                $this->redirect(array('settings'));
                }
            }
            $this->render('changePassword', array('model'=>$model));
        }

        public function actionSettingsAddress()
        {
            $this->render('settingsAddress', array('model'=>Yii::app()->user->model));
        }

         public function actionPersonal()
        {
            $model=new CustomerForm('update');
            $model->uzytkownik=Yii::app()->user->model->uzytkownik;
            $model->klient=Yii::app()->user->model;

            if(isset($_POST['Klient']))
            {
                $model->attributes=(array('Klient'=>$_POST['Klient'], 'Uzytkownik'=>$_POST['Uzytkownik']));
                unset($model->uzytkownik->haslo);
                if($model->validate())
                {
                    if($model->save(false))
                    {
                        $this->redirect(array('settings'));
                    }
                }
            }

            $this->render('customerPersonal', array('model'=>$model));
        }

        public function actionViewAddress()
        {
            //var_dump(Yii::app()->user->model->getAddressDataById($_GET['id']));die();
            $this->render('viewAddress',
                    array('model'=>Yii::app()->user->model->getAddressDataById($_GET['id'])));
        }

        public function actionCreateAddress()
        {
            $model=new AddressForm(Yii::app()->user->model->isCompany?'company':'customer');
            $model->klient=Yii::app()->user->model;

            if(isset($_POST['Adres']))
            {
                $model->attributes=array('AddressData'=>$_POST['AddressData'], 'Adres'=>$_POST['Adres']);
                if($model->validate())
                {
			if($model->save())
				$this->redirect(array('viewAddress','id'=>$model->addressData->id));
                }
            }
            $this->render('createAddress',array(
			'model'=>$model));
        }

        public function actionUpdateAddress()
        {
            $model=new AddressForm(Yii::app()->user->model->isCompany?'company':'customer');
            $model->addressData=Yii::app()->user->model->getAddressDataById($_GET['id']);
            $model->adres=$model->addressData->adres;
            $model->klient=Yii::app()->user->model;
            
            if(isset($_POST['Adres']))
            {
                $model->attributes=$_POST;
                if($model->validate())
                {
			if($model->save())
				$this->redirect(array('viewAddress','id'=>$model->addressData->id));
                }
            }
            $this->render('updateAddress',array(
			'model'=>$model));
        }

        public function actionUpdateCompany()
        {
            $model=Yii::app()->user->model->getCompany();

             $this->render('updateCompany',array(
			'model'=>$model));
        }

        public function actionViewCompany()
        {
            $model=Yii::app()->user->model->getCompany();

             $this->render('viewCompany',array(
			'model'=>$model));
        }

        public function actionCreateSubEmployee()
        {
            $model=new CustomerForm('createSubEmployee');
            $model->firma=Yii::app()->user->model->getCompany();

            if(isset($_POST['Klient']))
            {
                $model->attributes=array('Klient'=>$_POST['Klient'], 'Uzytkownik'=>$_POST['Uzytkownik']);

                if($model->validate())
                {
                    if($model->save(false))
                    {
                        $this->redirect(array('settings'));
                    }
                }
            }

            $this->render('createSubEmployee', array('model'=>$model));
        }

        public function actionOrders()
        {
            $orders_dp=new CActiveDataProvider(Yii::app()->user->model->zamowienia);
            $this->render('orders', array('orders_dp'));
        }
}