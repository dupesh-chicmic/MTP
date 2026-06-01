<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CmsController extends CController
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
        public function init(){
            if(Yii::app()->request->getIsAjaxRequest()){
                Yii::app()->clientScript->scriptMap=array('jquery.js'=>false, 'jquery-ui.min.js'=>false);
            }
        }

      public function beforeRender($view){

           $this->pageDisplayer = new QPageDisplayer;
           if (isset($_GET['url']) && $_GET['url'] != '') {
               $url = $_GET['url'];
               $this->pageDisplayer->getPage($url);
               /* menu */
               $this->pageDisplayer->getSubMenu($url);
               /* --- */
           }

           /* menu top */
           $this->pageDisplayer->getMainMenu(); //np. menu_top
           /* --- */

           $this->pageDisplayer->getAllElements();
           $this->pageDisplayer->getDictionary('front');

           /* Newsy - wszystkie */
           $this->pageDisplayer->getNewsByOrderByFieldFromCmsUniversal();
           /* Galerie - wszystkie */
           $this->pageDisplayer->getGalleryByOrderByFieldFromCmsUniversal();

           return parent::beforeRender(null);
        }

/* MW wyrzucone po tym jak wywalal blad po dodaniu isAgency()
    protected function beforeAction($action)
    {
       if(Yii::app()->user->model==null)
            Yii::app()->user->model=Klient::model();
        return parent::beforeAction($action);
    }
*/
}


