<?php
/**
 * 
 * ******************************************************************************
 * <hr>
 * Plik: <b>MobileController.php</b><br> 
 * Autor: <b>Mariusz Winiarz</b><br>
 * Firma: <b>Qbix-Soft</b><br>
 * Data utworzenia: <b>12-05-2014</b><br>
 * <hr>
 * ******************************************************************************
 * Klasa odpowiada za akcje zwiazane z informacjami nt. used_cars oraz used_com_cars
 * ******************************************************************************
 * <hr> 
 * @author mariusz 
 * ******************************************************************************
 */
class MemberController extends Controller {
    
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('dinkeyError', 'error'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('generatePdf', 'newPricesCars', 'archiveRegLookupListIFrame', 'newPricesCarsPdf', 'newPricesComms', 'newPricesCommsPdf', 'newPricesCarsIframe', 'newPricesCommsIframe', 'viewNewses', 'usedCarsIFrame', 'usedCommercialIFrame', 'ajaxCount', 'usedCarsArchive', 'archive', 'archiveIFrame', 'usedComCarsArchive', 'usedCarsLookupIFrame', 'usedCommercialLookupIFrame', 'regPdf'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('importXmlFiles', 'importXml_dieselBands', 'importXml_petrolBands', 'importXml_kmsBands', 'importXmlFilesMain', 'importXml_used_carsCars', 'importXml_used_carsCom', 'deleteArchive', 'deleteImport'),
                'users' => array('admin', 'su'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            $this->layout = Controller::getLayoutDevice();
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /*
     * Generator Pdf
     */
    
    public function beforeAction($action)
    {
        if (!(Yii::app()->mobileDetect->isMobile() || Yii::app()->mobileDetect->isTablet())) {
            Uzytkownik::updateNetworkUserSession();
        }
        return parent::beforeAction($action);
    }

    public function actionGeneratePdf() {
        $userYear = $userKms = $userValue = $archMonth  = '';
        $pageData = [];
        $page = $arch = $make = $rangecode = null;
           
        if( $_GET['make'])
            $make = $_GET['make'];

        if( $_GET['rangecode'])
            $rangecode = $_GET['rangecode'];

        if(isset($_GET['imp']) && $_GET['imp'] != ''){
            $archiveIds = Import::model()->with('usedComCarsCount')->findAll(array(
                    'order' => '`t`.`id` DESC'    
                    ));
            $arch = ( $_GET['imp'] )? $_GET['imp'] : '';

            foreach($archiveIds as $item){
                if($item->id == $arch){
                    $archMonth  =   $item->nazwa;
                }
            }
            $pageData['archMonth']   =   $archMonth;
        }

        if (isset($_GET['m']) && $_GET['m'] != '' && isset($_GET['cn']) && $_GET['cn'] != '') {
            if (isset($_GET['imp']) && $_GET['imp'] != '') { //import number
                $import = $_GET['imp'];
            }
             
            if ($_GET['m'] == 'UsedCarsModel') {
                $modelElement = 'UsedCars';
                $with = 'usedCarsModels';
                $urlCodeData    =   array(
                                        'page'=>$_SESSION['archive_page'],                    
                                        'com_arch'=>$_SESSION['archive_com_arch'],
                                        'arch'=>$_SESSION['archive_arch'],   
                                        'make'=>$_SESSION['archive_make'],
                                        'rangecode'=>$_SESSION['archive_rangecode'],
                                        // 'selrow'=>$_SESSION['selrow'],
                                        // 'showcont'=>$_SESSION['showcont']
                                    );
                $backUrl = Yii::app()->createAbsoluteUrl('mobile/archive',$urlCodeData);
       
            } else {
                $modelElement = 'UsedComCars';
                $with = 'usedComCarsModels';
            
                $urlCodeData    =   array(
                                        'page'=>$_SESSION['archive_page'],                    
                                        'com_arch'=>$_SESSION['archive_com_arch'],
                                        'arch'=>$_SESSION['archive_arch'],   
                                        'make'=>$_SESSION['archive_make'],
                                        'rangecode'=>$_SESSION['archive_rangecode']
                                    );
                $backUrl = Yii::app()->createAbsoluteUrl('mobile/archive',$urlCodeData);
            }

            $model = CActiveRecord::model($modelElement)->with($with)->find(array(
                'condition' => '`' . $with . '`.`codenumber`=:number AND `t`.`id_import`=:imp',
                'params' => array(':number' => $_GET['cn'], ':imp' => $_GET['imp'])
            ));

            if (isset($_GET['uy']) && $_GET['uy'] != '') {
                $userYear = $_GET['uy'];
            } 
            if (isset($_GET['ukms']) && $_GET['ukms'] != '') {
                $userKms = $_GET['ukms'];
            } else if(isset($model[$with][0]['kms0']) && $model[$with][0]['kms0'] != '') {
               $userKms =  $model[$with][0]['kms0'];
            }
            if (isset($_GET['v']) && $_GET['v'] != '') {
                $userValue = $_GET['v'];
            } else if(isset($model[$with][0]['GRP0']) && $model[$with][0]['GRP0'] != '') {
               $userValue =  $model[$with][0]['GRP0'];
            }
        }

        $queryStringData    =   [
                                'page'      =>  $page,
                                'arch'      =>  $arch,
                                'com_arch'  =>  $arch,
                                'make'      =>  $make,
                                'rangecode' =>  $rangecode
                            ];
                    
        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/member/generatePdf.php'); // inaczej nie da sie otworzyc pliku
      
        $this->render('generatePdf', array(
            'model' => $model,
            'userYear' => $userYear,
            'userKms' => $userKms,
            'userValue' => $userValue,
            'backUrl' => $backUrl,
            'pageData'  =>  $pageData
        ));
    }

    /**
     * Show New Prices/Cars page
     */
    public function actionNewPricesCars() {
        $this->layout = Controller::getLayoutDevice();
        $this->render('newPricesCars');
    }

    public function actionNewPricesCarsPdf()
    {
        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/member/newPricesCarsPdf.php'); // inaczej nie da sie otworzyc pliku
        $this->render('newPricesCarsPdf');
    }

    public function actionNewPricesCarsIframe() {
        //$this->layout = Controller::getLayoutDevice();
        $this->layout = 'iframe';
        $this->render('newPricesCars');
    }

    /**
     * Show New Prices/Commercial page
     */
    public function actionNewPricesComms() {
        $this->layout = Controller::getLayoutDevice();
        $this->render('newPricesComms');
    }
    
    public function actionNewPricesCommsPdf()
    {
        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/member/newPricesCommsPdf.php'); // inaczej nie da sie otworzyc pliku
        $this->render('newPricesCommsPdf');
    }

    public function actionNewPricesCommsIframe() {
        //$this->layout = Controller::getLayoutDevice();
        $this->layout = 'iframe';
        $this->render('newPricesComms');
    }

    public function actionViewNewses() {
        $criteria = new CDbCriteria();
        $count = CmsNews::model()->count($criteria);
        $pages = new CPagination($count);

        // results per page
        $pages->pageSize = 1;
        $pages->applyLimit($criteria);
        $models = CmsNews::model()->findAll($criteria);

        $this->render('viewNewses', array(
            'listaNewsow' => $models,
            'pages' => $pages
        ));
    }

    public function actionDinkeyError() {
        $this->render('dinkeyError');
    }

    public function actionUsedCars() {
        QDinkey::checkDinkeyAccess();
        $this->layout = Controller::getLayoutDevice();

        $import = Import::model()->with('usedCars')->find(array(
            //'limit'=>1,
            'order' => '`t`.`id` DESC' //pobierze ostatni import (np. gdy w danym dniu dodano 3 importy wezmie najnowszy=ostatni)
        ));

        if (!empty($import->id)) {
            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $import->id);
            // przesylam tylko wybrany model samochodu !
//            $useCarsRanges = UsedCarsRanges::model()->find('id_import=:id_import', array('id_import'=>$import->id));
//            if(empty($useCarsRanges)){
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']);
                $model = UsedCars::model()->with('idImport')->find($criteria);
                $headerTitle = $model['name'];
            } else {
                $model = UsedCars::model()->with('idImport')->findAll($criteria);
                $headerTitle = $model[0]['name'];
            }
            //sprawdz czy moze ogladac te strone    
            if (Yii::app()->user->isGuest || !Uzytkownik::model()->carOrComGuideVisibility_trialIncluded('used_cars', Yii::app()->user->getId())) {
                $this->redirect(array('/site/loginIframe'));
                exit;
            }
//            }

            if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS)) {
                $this->render('usedCarGuide', array(
                    'model' => $model,
                    'headerTitle' => $headerTitle
                ));
            } else {
                $this->redirect(array('/site/expired'));
                exit;
            }
        } else {
            throw new CHttpException(400, 'Used cars are temporarily unavailable.');
        }
    }

    public function actionUsedCarsIFrame() {
        QDinkey::checkDinkeyAccess();
        //$this->layout = Controller::getLayoutDevice();
        $this->layout = '//layouts/iframe';

        $import = Import::model()->with('usedCars')->find(array(
            //'limit'=>1,
            'order' => '`t`.`id` DESC' //pobierze ostatni import (np. gdy w danym dniu dodano 3 importy wezmie najnowszy=ostatni)
        ));

        if (!empty($import->id)) {
            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $import->id);
            // przesylam tylko wybrany model samochodu !
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']);
                $model = UsedCars::model()->with('idImport')->find($criteria);
                $headerTitle = $model['name'];
            } else {
                $model = UsedCars::model()->with('idImport')->findAll($criteria);
                $headerTitle = $model[0]['name'];
            }
            //sprawdz czy moze ogladac te strone    
            if (Yii::app()->user->isGuest || !Uzytkownik::model()->carOrComGuideVisibility_trialIncluded('used_cars', Yii::app()->user->getId())) {
                $this->redirect(array('/site/loginIframe'));
                exit;
            }

            if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS)) {
                $this->render('usedCarGuide', array(
                    'model' => $model,
                    'headerTitle' => $headerTitle
                ));
            } else {
            //                $this->redirect(array('/site/expired'));
            if(Yii::app()->params['website_type']==Yii::app()->params['website']['API']){
                echo '<script>window.top.location.href = "http://mtp.ie/license/";</script>';
            }else{
                echo '<script>window.top.location.href = "'.Yii::app()->params['main_url'].'license/";</script>';
            }
               
                exit;
            }
        } else {
            throw new CHttpException(400, 'Used cars are temporarily unavailable.');
        }
    }

    public function actionUsedCommercial() {
        QDinkey::checkDinkeyAccess();
        $this->layout = Controller::getLayoutDevice();

        //left outer join jesli commercial dla danego misiaca = null 
        $import = Import::model()->with('usedComCars')->find(array(
            //'limit'=>1,
            'order' => '`t`.`id` DESC' //pobierze ostatni import (np. gdy w danym dniu dodano 3 importy wezmie najnowszy=ostatni)
        ));

        if (!empty($import->id)) {
            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $import->id);

            // przesylam tylko konkretny item !
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']); //'id=?',array($_GET['make'])            
                $model = UsedComCars::model()->with('idImport')->find($criteria);
                $headerTitle = $model['name'];
            } else {
                $model = UsedComCars::model()->with('idImport')->findAll($criteria);
                $headerTitle = $model[0]['name'];
            }

            //sprawdz czy moze ogladac te strone    
            if (Yii::app()->user->isGuest || !Uzytkownik::model()->carOrComGuideVisibility_trialIncluded('used_com_cars', Yii::app()->user->getId())) {
                $this->redirect(array('/site/loginIframe'));
                exit;
            }
            if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL)) {
                $this->render('usedComGuide', array(
                    'model' => $model,
                    'headerTitle' => $headerTitle
                ));
            } else {
                $this->redirect(array('/site/expired'));
                exit;
            }
        } else {
            throw new CHttpException(400, 'Used commercial cars are temporarily unavailable.');
        }
    }

    public function actionUsedCommercialIFrame() {
        QDinkey::checkDinkeyAccess();
        //$this->layout = Controller::getLayoutDevice();
        $this->layout = '//layouts/iframe';

        //left outer join jesli commercial dla danego misiaca = null 
        $import = Import::model()->with('usedComCars')->find(array(
            //'limit'=>1,
            'order' => '`t`.`id` DESC' //pobierze ostatni import (np. gdy w danym dniu dodano 3 importy wezmie najnowszy=ostatni)
        ));

        if (!empty($import->id)) {
            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $import->id);

            // przesylam tylko konkretny item !
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']); //'id=?',array($_GET['make'])            
                $model = UsedComCars::model()->with('idImport')->find($criteria);
                $headerTitle = $model['name'];
            } else {
                $model = UsedComCars::model()->with('idImport')->findAll($criteria);
                $headerTitle = $model[0]['name'];
            }

            //sprawdz czy moze ogladac te strone    
            if (Yii::app()->user->isGuest || !Uzytkownik::model()->carOrComGuideVisibility_trialIncluded('used_com_cars', Yii::app()->user->getId())) {
                $this->redirect(array('/site/loginIframe'));
                exit;
            }
            if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL)) {
                $this->render('usedComGuide', array(
                    'model' => $model,
                    'headerTitle' => $headerTitle
                ));
            } else {
                $this->redirect(array('/site/expired'));
                exit;
            }
        } else {
            throw new CHttpException(400, 'Used commercial cars are temporarily unavailable.');
        }
    }

    /**
     * Metoda renderuje widok z obliczonym Odometer calculator
     */
    public function actionAjaxCount() {
        if (!empty($_POST)) {
            $this->renderPartial('_ajaxAdjustedValue', UsedCars::odometerCalculation($_POST));
        }
    }

    public function actionArchive() {
        QDinkey::checkDinkeyAccess();
        $this->layout = 'mainSubPage';

        $modelImport = Import::model()->with('usedComCarsCount')->findAll(array(
            'order' => '`t`.`id` DESC',
        ));

        $this->render('archive', array('modelImport' => $modelImport));
    }

    public function actionArchiveIFrame() {
        //QDinkey::checkDinkeyAccess();
        $this->layout = '//layouts/iframe';

        $modelImport = Import::model()->with('usedComCarsCount')->findAll(array(
            'order' => '`t`.`id` DESC',
        ));

        $this->render('archive', array('modelImport' => $modelImport));
    }
    
    public function actionArchiveRegLookupListIFrame() {
       // QDinkey::checkDinkeyAccess();
        $this->layout = '//layouts/iframe';

        $startDate = Uzytkownik::getCarsLicenseStartDate();
        $archiveBeginDate = $startDate;
        $format = "Y-m-d";
        $date1  = DateTime::createFromFormat($format, $startDate);
        $date2  = DateTime::createFromFormat($format, "2016-09-01");
        if($date2>$date1) {
            $archiveBeginDate=date($format, strtotime ("2016-09-01"));
        }

        $modelImport = Import::model()->with('usedComCarsCount')->findAll(array(
            'order' => '`t`.`id` DESC',
            'condition'=>'t.data>date(:x)', 'params'=>array(':x'=>$archiveBeginDate)           
        ));

        $this->render('archiveRegLookupList', array('modelImport' => $modelImport));
    }

    public function actionUsedCarsArchive() {
        QDinkey::checkDinkeyAccess();
        //$this->layout='mainSubPage';
        $this->layout = 'iframe';
        if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS) && Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_CARS)) {
            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $_GET['arch']);

            // przesylam tylko konkretny item !    
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']); //'id=?',array($_GET['make'])
                $model = UsedCars::model()->with('idImport')->find($criteria);
                echo count($model);
            } else {
                $model = UsedCars::model()->with('idImport')->findAll($criteria);
            }
            $this->render('usedCarGuide', array(
                'model' => $model,
            ));
        } else {
            $this->redirect(array('/site/expired'));
            exit;
        }
    }

    public function actionUsedComCarsArchive() {
        QDinkey::checkDinkeyAccess();
        //$this->layout='mainSubPage';
        $this->layout = 'iframe';

        if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL) && Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_COMMERCIAL)) {
            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $_GET['arch']);

            // przesylam tylko konkretny item !
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']); //'id=?',array($_GET['make'])            
                $model = UsedComCars::model()->with('idImport')->find($criteria);
            } else {
                $model = UsedComCars::model()->with('idImport')->findAll($criteria);
            }
            $this->render('usedComGuide', array(
                'model' => $model,
            ));
        } else {
            $this->redirect(array('/site/expired'));
            exit;
        }
    }

    public function actionImportXmlFilesMain() {
        $this->layout = "admin/mainSubPageForManagingUsers";
        $this->render('importXmlFilesMain');
    }

    /**
     * akcja importuje wybrane pliki xml do bazy
     */
    public function actionImportXmlFiles() {
        ini_set('max_execution_time', '360');
        $importCarsCom = (isset($_POST['usedCarsCom']) && $_POST['usedCarsCom'] != '') ? 1 : 0;
        $importCarLinks = 1; //(isset($_POST['uCarsLink']) && $_POST['uCarsLink'] != '') ? 1 : 0;
        $importCommsLinks = 1; //(isset($_POST['uComsLink']) && $_POST['uComsLink'] != '') ? 1 : 0;


        if (!empty($_POST['my_date']) && !empty($_POST['my_name'])) {
            Import::model()->importXmlFiles($importCarsCom, $_POST['my_date'], $_POST['my_name'], $importCarLinks, $importCommsLinks);
        } else {
            Yii::app()->user->setFlash('importXmlError', 'Title and date cannot be empty.');
        }
        $this->actionImportXmlFilesMain();
    }

    public function actionDeleteArchive() {
        $this->layout = "admin/mainSubPageForManagingUsers";

        $modelImport = Import::model()->with('usedComCarsCount')->findAll(array(
            'order' => 'data DESC',
        ));
        $this->render('deleteArchive', array('modelImport' => $modelImport));
    }

    public function actionDeleteImport() {
        if (isset($_GET['id']) && $_GET['id'] != '') {
            $modelImport = Import::model()->with('usedComCarsCount')->find(array(
                'condition' => 'id=:importId',
                'params' => array(':importId' => $_GET['id'])
            ));
            $modelImport->delete();
        }
        $this->actionDeleteArchive();
    }

    // route to show new pdf
    public function actionRegPdf() {
        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/member/generateRegPdf.php'); // inaczej nie da sie otworzyc pliku

        $this->render('generateRegPdf', array());
    }

}
