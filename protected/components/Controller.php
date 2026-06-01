<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to 'application.views.layouts.column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='application.views.layouts.column1';
        public $pageDisplayer;
        
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
        public $subMenu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

       	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

    
    public function actionSetViewParams() {
        if(isset($_GET['orders'])) {
            Yii::app()->user->setShowOrders($_GET['orders']);
        }
        
        $this->redirect(Yii::app()->request->urlReferrer);
    }
    
      public function beforeRender($view){
           
           $this->pageDisplayer = new QPageDisplayer;
           if (isset($_GET['url']) && $_GET['url'] != '') {
               $url = $_GET['url'];
               $this->pageDisplayer->getPage($url);
               /* menu */
               
               /* --- */
           }
           $this->pageDisplayer->getSubMenu();
           /* menu top */
           $this->pageDisplayer->getMainMenu(); //np. menu_top           
           /* --- */
           
           $this->pageDisplayer->getAllElements();
           $this->pageDisplayer->getDictionary('front');                      
           
           /* Newsy - wszystkie */
           $this->pageDisplayer->getNewsByOrderByFieldFromCmsUniversal();
           /* Galerie - wszystkie */
           $this->pageDisplayer->getGalleryByOrderByFieldFromCmsUniversal();
           /* Banner Top */
           //$this->pageDisplayer->getBannerTop();

           return parent::beforeRender(null);
        }

    public function init() {
        Yii::app()->getModule('cms');
    }

    public function beforeAction($action)
    {
        // default variables
        $data   = [];
        $event  = Yii::app()->controller->action->id;
        // echo "<pre>";
        // print_r($_SESSION);
        // print_r(Yii::$app->request);
        // die;
        // if (!(Yii::app()->mobileDetect->isMobile() || Yii::app()->mobileDetect->isTablet())) {
        //     Uzytkownik::updateNetworkUserSession();
        // }

        // // $recordCounter = new RecordCounter;
        // // $data          = $_REQUEST;
        // // echo "<pre>";
        // // print_r($data);
        // // print_r($action);
        // // die;
		// // $recordCounter->storeCounter($data, $action);
        return parent::beforeAction($action);
    }
    
    
    public static function getLayoutDevice()
    {
        if(Yii::app()->mobileDetect->isMobile() || Yii::app()->mobileDetect->isTablet())
        {                
            // ustawienie back button dla metod wywolanych w kontrolerach innych niz Mobile!
            Yii::app()->user->setFlash('showBackButton',"SHOW");
            return "//layouts/mainMobile";
        }
        else
        {
            return 'mainSubPage';
        }  
    }
    
}


