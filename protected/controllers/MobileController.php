<?php

/**
 * 
 *******************************************************************************
 * <hr>
 * Plik: <b>MobileController.php</b><br> 
 * Autor: <b>Mariusz Winiarz</b><br>
 * Firma: <b>Qbix-Soft</b><br>
 * Data utworzenia: <b>10-07-2013</b><br>
 * <hr>
 *******************************************************************************
 * Klasa posiada akcje do zarzadzania wersja mobilna aplikacji
 *******************************************************************************
 * <hr> 
 * @author mariusz 
 *******************************************************************************
 */


class MobileController extends Controller
{
    public static $PARAM_USED_CARS_MODEL = "UsedCarsModel";
    public static $PARAM_USED_COM_CARS_MODEL = "UsedComCarsModel";
    public static $PARAM_RGE_OR_NULL_EMPTY = "Rge or Mdl is empty.";

    public static $PARAM_ACCES_DENIED = "Access denied.";
    public static $PARAM_INCORRECT_LOGIN_PASS = "Login or password is incorrect.";
    public $layout = "//layouts/mainMobile";


    public $passengerCarBodies = [
        "Cabriolet",
        "Cabrio",
        "Cabrio.",
        "Convertible",
        "Conv",
        "Conv.",
        "Coupe",
        "Cpe",
        "Coupé",
        "Cpé",
        "Estate",
        "Est",
        "Est.",
        "Combi",
        "Tourer",
        "Touring",
        "Avant",
        "avt",
        "Tdiavt",
        "Hatch",
        "Hatchback",
        "HB",
        "Hb",
        "HB.",
        "Hb.",
        "hb.",
        "MPV",
        "MPV",
        "MPV",
        "Roadster",
        "Rdster",
        "Rd'ster",
        "Rds",
        "Saloon",
        "SALOON",
        "Sal",
        "Sal.",
        "Sedan",
        "Station Wagon",
        "S/Wagon",
        "SUV",
        "SUV",
        "Estate"
    ];
    //highlighted yellow colored car body types which is on condition marked
    public $commercialCarBodies = [
        "Chassis Cab",
        "Ch/Cab",
        "Commercial",
        "Comm",
        "Comm.",
        "Crew Cab",
        "Crew/Cab",
        "C/Cab",
        "Crew Cab",
        "Double Cab",
        "D/Cab",
        "Dbl Cab",
        "Dbl. Cab",
        "Pick Up",
        "Pick-Up",
        "Pick Up D'Cab",
        "Pick-Up D'Cab",
        "Pick Up S'Cab",
        "Pick-Up S'Cab",
        "Van",
        "Van",
        "Pick Up",
        "Pick Up"
    ];
    public $highlightedCommBody = [
        "Cabriolet",
        "Cabrio",
        "Cabrio.",
        "Convertible",
        "Conv",
        "Conv.",
        "Coupe",
        "Cpe",
        "Coupé",
        "Cpé",
        "Estate",
        "Est",
        "Est.",
        "Combi",
        "Tourer",
        "Touring",
        "Avant",
        "avt",
        "Tdiavt",
        "Hatch",
        "Hatchback",
        "HB",
        "Hb",
        "HB.",
        "Hb.",
        "hb.",
        "MPV",
        "MPV",
        "MPV",
        "Roadster",
        "Rdster",
        "Rd'ster",
        "Rds",
        "Saloon",
        "SALOON",
        "Sal",
        "Sal.",
        "Sedan",
        "Station Wagon",
        "S/Wagon",
        "SUV",
        "SUV",
        "Estate"
    ];
    //highlighted yellow colored car body types which is on condition marked
    public $highlightedCarBody = [
        "Chassis Cab",
        "Ch/Cab",
        "Commercial",
        "Comm",
        "Comm.",
        "Crew Cab",
        "Crew/Cab",
        "C/Cab",
        "Crew Cab",
        "Double Cab",
        "D/Cab",
        "Dbl Cab",
        "Dbl. Cab",
        "Pick Up",
        "Pick-Up",
        "Pick Up D'Cab",
        "Pick-Up D'Cab",
        "Pick Up S'Cab",
        "Pick-Up S'Cab",
        "Van",
        "Van",
        "Pick Up",
        "Pick Up"
    ];
    //All NVDF bodies
    public $NVDF_BODIES = [
        "Cabriolet",
        "Cabrio",
        "Cabrio.",
        "Chassis Cab",
        "Ch/Cab",
        "Commercial",
        "Comm",
        "Comm.",
        "Convertible",
        "Conv",
        "Conv.",
        "Coupe",
        "Cpe",
        "Coupé",
        "Cpé",
        "Crew Cab",
        "Crew/Cab",
        "C/Cab",
        "Crew Cab",
        "Double Cab",
        "D/Cab",
        "Dbl Cab",
        "Dbl. Cab",
        "Estate",
        "Est",
        "Est.",
        "Combi",
        "Tourer",
        "Touring",
        "Avant",
        "avt",
        "Tdiavt",
        "Hatch",
        "Hatchback",
        "HB",
        "Hb",
        "HB.",
        "Hb.",
        "hb.",
        "MPV",
        "MPV",
        "MPV",
        "Pick Up",
        "Pick-Up",
        "Pick Up D'Cab",
        "Pick-Up D'Cab",
        "Pick Up S'Cab",
        "Pick-Up S'Cab",
        "Roadster",
        "Rdster",
        "Rd'ster",
        "Rds",
        "Saloon",
        "Sal",
        "Sal.",
        "Sedan",
        "Station Wagon",
        "S/Wagon",
        "SUV",
        "SUV",
        "Van",
        "Van",
        "Pick Up",
        "Pick Up",
        "Estate"
    ];

    protected $production;
    /**
     * Metoda ustawia przycisk Back button dla wszystkich akcji z tego kontrolera
     * @param type $action
     * @return boolean
     */
    public function __construct()
    {
        $this->production = $_ENV['production'];
    }
    public function beforeAction($action)
    {
        Yii::app()->user->setFlash('showBackButton', "SHOW");
        parent::beforeAction($action);
        return true;
    }

    public function accessRules()
    {
        return array(
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'users' => array('@'),
            ),
            //                    array('allow', // allow admin user to perform 'admin' and 'delete' actions
            //                            'actions'=>array('importXmlFiles','importXml_dieselBands','importXml_petrolBands','importXml_kmsBands','importXmlFilesMain','importXml_used_carsCars','importXml_used_carsCom','deleteArchive','deleteImport'),
            //                            'users'=>array('admin','su'),
            //                    ),
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Captcha action renders the CAPTCHA image displayed on the contact page
     * @return type
     */
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            )
        );
    }

    /*update Make and Madel search page design*/
    public function actionGSelectMakeModel()
    {
        $licence = Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS);

        if ($licence) {
            $this->render('//mobile/gSelectMakeModel', array(
                // 'usedCarsMark'=>Mobile::getUsedCarsMark(),
            ));
        } else {
            $this->render('//mobile/gMessage', array(
                'msg' => 'Oops! Seems that your licence for the used cars expired. <br>'
                    . 'Please contact our office <br>on<br><a href="tel:018775460">01-8775460</a><br>or<br>'
                    . '<a href="mailto:info@mtp.ie">info@mtp.ie</a><br>'
                    . 'so we can get you motoring again.',
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));
        }
    }

    /* Updated Archive page with updated design */
    public function actionArchive()
    {
        QDinkey::checkDinkeyAccess();
        $production         = $this->production;
        $com_arch   = '';
        $arch       = '';
        $make       = '';
        $rangecode       = '';
        $backpdf    = '';
        $selrow     = '';
        $selyear     = '';

        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $page = $_GET['page'];
            $_SESSION['archive_page'] = $page;
        }

        if (isset($_GET['com_arch']) && !empty($_GET['com_arch'])) {
            $com_arch = $_GET['com_arch'];
            $_SESSION['archive_com_arch'] = $com_arch;
        }

        if (isset($_GET['arch']) && !empty($_GET['arch'])) {
            $arch = $_GET['arch'];
            $_SESSION['archive_arch'] = $arch;
        }

        if (isset($_GET['make']) && !empty($_GET['make'])) {
            $make = $_GET['make'];
            $_SESSION['archive_make'] = $make;
        }

        $_SESSION['archive_rangecode'] = '';
        if (isset($_GET['rangecode']) && !empty($_GET['rangecode'])) {
            $rangecode = $_GET['rangecode'];
            $_SESSION['archive_rangecode'] = $rangecode;
        }

        $_SESSION['selrow'] = '';
        $_SESSION['selyear'] = '';
        $_SESSION['backpdf'] = '';
        if (isset($_GET['backpdf']) && !empty($_GET['backpdf'])) {
            $backpdf = $_GET['backpdf'];
            $_SESSION['backpdf'] = $backpdf;
            // code

            if (isset($_GET['selrow']) && !empty($_GET['selrow'])) {
                $selrow = $_GET['selrow'];
                $_SESSION['selrow'] = $selrow;
            }
        }
        // showcont_ 
        if (isset($_GET['showcont']) && !empty($_GET['showcont'])) {
            $showcont = $_GET['showcont'];
            $_SESSION['showcont'] = $showcont;
        }

        $availablePages = array('cars', 'commercial');

        $page = (isset($_GET['page']) && !empty($_GET['page']) && in_array($_GET['page'], $availablePages)) ? $_GET['page'] : 'cars';

        $PARAM_USED_CARS = ($page == 'cars') ? Uzytkownik::PARAM_USED_CARS : Uzytkownik::PARAM_USED_COMMERCIAL;

        if (Uzytkownik::model()->checkExpirationDate($PARAM_USED_CARS) && Uzytkownik::model()->checkProductIsOn($PARAM_USED_CARS)) {

            $modelImport = $this->getArchiveRegOptions();
            $selected = $archOptions = '';
            $i = 0;
            $commercialItemId = "";
            $passengerItemId = "";
            $nazwa = [];
            foreach ($modelImport as $item) {
                $i++;
                if ($i == 1 && $all > 1) {
                    continue;
                }

                if ($page == 'commercial') {
                    $selected = (isset($_GET['com_arch']) && $_GET['com_arch'] == $item->id) ? ' selected' : '';

                    if (!empty($item->usedComCarsCount)) {
                        if ($i != 1 && $i != 2 && !in_array($item->nazwa, $nazwa)) {
                            if (empty($commercialItemId)) {
                                $commercialItemId = $item->id;
                            }
                            $nazwa[] = $item->nazwa;
                            $archOptions .= '<option value="' . $item->id . '" ' . $selected . '>' . $item->nazwa . '</option>';
                        }
                    }
                } else {
                    $selected = (isset($_GET['arch']) && $_GET['arch'] == $item->id) ? ' selected' : '';
                    if ($i != 1 && !in_array($item->nazwa, $nazwa)) {
                        if (empty($passengerItemId)) {
                            $passengerItemId = $item->id;
                        }
                        $nazwa[] = $item->nazwa;
                        $archOptions .= '<option value="' . $item->id . '" ' . $selected . '>' . $item->nazwa . '</option>';
                    }
                }
            }

            //condition val to hide the model options
            $arch_year = 125;
            //condition val to record hide for corecode fields
            $january2020    =   195;
            //lates import ids
            //$latestImportId = $modelImport[0]->id;
            $latestImportId = $page == 'cars' ?  $passengerItemId : $commercialItemId;
            $comMonths = array('December' => 'November', 'November' => 'November', 'October' => 'September', 'September' => 'September', 'August' => 'July', 'July' => 'July', 'June' => 'May', 'May' => 'May', 'April' => 'March', 'March' => 'March', 'February' => 'January', 'January' => 'January');
            $carComIds = array();
            $i = 0;

            foreach ($modelImport as $item) {
                $carComIds[$item->nazwa] = $item->id;

                if (!empty($item->usedComCarsCount) && $i == 0) {
                    $latestCommImportId = $item->id;
                    $i++;
                }
            }

            foreach ($modelImport as $item) {
                $monthYear = explode(' ', $item->nazwa);
                $carComIds[$monthYear[0] . ' ' . $monthYear[1]] = $carComIds[$comMonths[$monthYear[0]] . ' ' . $monthYear[1]];
            }

            $arch = ($_GET['arch']) ? $_GET['arch'] : $latestImportId;

            $com_arch = (isset($_GET['com_arch']) && !empty($_GET['com_arch'])) ? $_GET['com_arch'] : $latestImportId;

            $arch = ($page == 'commercial') ? $com_arch : $arch;

            // if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS) && Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_CARS)) {

            $SHOW_CODE_COLUMN = Yii::app()->params['used_car_com_code_column_visibility'];

            $carsVisibleLink = Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_CARS);
            $commVisibleLink = Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_COMMERCIAL);

            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $arch);
            //if a particular brand selected
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']); //'id=?',array($_GET['make'])
                $model = ($page == 'cars') ? UsedCars::model()->with('idImport')->find($criteria) : UsedComCars::model()->with('idImport')->find($criteria);
            } else {
                $model = ($page == 'cars') ? UsedCars::model()->with('idImport')->findAll($criteria) : UsedComCars::model()->with('idImport')->findAll($criteria);
            }

            //-----------------------
            $criteria = new CDbCriteria;
            $criteria->order = '`name`';
            $criteria->condition = 'id_import=:importId';
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $tableTitle = $model['idImport']['nazwa'];
                $importId = $model['id_import'];
                $criteria->params = array(':importId' => $model['id_import']);
            } else {
                $tableTitle = $model[0]['idImport']['nazwa'];
                $importId = $model[0]['id_import'];
                $criteria->params = array(':importId' => $model[0]['id_import']);
            }

            $allCars = ($page == 'cars') ? UsedCars::model()->findAll($criteria) : UsedComCars::model()->findAll($criteria);

            if (!isset($_GET['make'])) {
                $headerTitle = $allCars[0]['name'];
            }

            $range = null;
            $usedCarsRanges = ($page == 'cars') ? UsedCars::usedCarsRanges($importId) : UsedCommsRanges::getUsedCommsRanges($importId);
            if (!empty($_GET['rangecode'])) {
                $range = $_GET['rangecode'];
            }

            $makeData = $modalData = array();

            if (empty($usedCarsRanges)) {
                foreach ($allCars as $item) {
                    $selected = (isset($_GET['make']) && $_GET['make'] == $item['id']) ? ' selected' : '';
                    $makeData[$item['id']] = '<option value="' . $item['id'] . '"' . $selected . '>' . $item['name'] . '</option>';
                    if (isset($_GET['make']) && $_GET['make'] == $item['id']) $headerTitle = $item['name'];
                }
            } else {
                foreach ($allCars as $startIndex => $row) {
                    //display name of manuafacturer
                    $manufacturerName = str_replace(' ', '_', $row['name']);
                    if ($manufacturerName == 'UCarsLinks' || $manufacturerName == 'UComsLinks') continue;
                    $selected = (isset($_GET['make']) && $_GET['make'] == $row['id']) ? ' selected' : '';

                    $makeData[$row['id']] = '<option value="' . $row['id'] . '"' . $selected . '>' . $row['name'] . '</option>';
                    if (isset($_GET['make']) && $_GET['make'] == $row['id']) $headerTitle = $row['name'];

                    if (!empty($manufacturerName) && !in_array($manufacturerName, array('UCarsLinks', 'UComsLinks')) && $selected) {
                        foreach ($usedCarsRanges[$manufacturerName] as $range_name => $range_val) {
                            $selected = ($range_val == $range) ? ' selected' : '';
                            $modalData[urlencode((string)$range_val)] = '<option value="' . urlencode((string)$range_val) . '"' . $selected . '>' . $range_name . '</option>';
                        }
                    }
                }

                if (!$modalData) {
                    foreach ($allCars as $startIndex => $row) {
                        //display name of manuafacturer
                        $manufacturerName = str_replace(' ', '_', $row['name']);
                        if ($manufacturerName == 'UCarsLinks' || $manufacturerName == 'UComsLinks') continue;

                        foreach ($usedCarsRanges[$manufacturerName] as $range_name => $range_val) {
                            $selected = ($range_val == $range) ? ' selected' : '';
                            $modalData[urlencode((string)$range_val)] = '<option value="' . urlencode((string)$range_val) . '"' . $selected . '>' . $range_name . '</option>';
                        }
                        break;
                    }
                }
            }

            if ($modalData && !$range) {
                $range = reset(array_keys($modalData));
            }

            $content = array(
                'carsVisibleLink' => $carsVisibleLink,
                'commVisibleLink' => $commVisibleLink,
                'SHOW_CODE_COLUMN' => $SHOW_CODE_COLUMN,
                'headerTitle' => $headerTitle,
                'tableTitle' => $tableTitle,
                'makeData' => $makeData,
                'modalData' => $modalData,
                'allCars' => $allCars,
                'range' => $range,
                'page' => $page,
                'model' => $model,
                'arch' => $arch,
                'com_arch' => $_GET['com_arch'],
                // 'arch_content'  =>  $archPageContent,
                'latestImportId' => $latestImportId,
                'archOptions'   =>  $archOptions,
                'arch_year' =>  $arch_year,
                'january2020'   =>  $january2020,
                'backpdf'   =>  $backpdf,
                'selrow'   =>  $selrow,
                'selyear'   =>  $selyear
            );


            $this->render('//mobile/usedGuideList', $content);
        } else {
            $msgg = 'Oops! Seems that your licence for the used cars expired. <br>'
                . 'Please contact our office <br>on<br><a href="tel:018775460" class="licence_link">01-8775460</a><br>or<br>'
                . '<a href="mailto:info@mtp.ie" class="licence_link">info@mtp.ie</a><br>'
                . 'so we can get you motoring again.';

            if (!Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL)) {
                $msgg = 'Oops! Seems that your licence for the commercial vehicles expired. <br>'
                    . 'Please contact our office <br>on<br><a href="tel:018775460">01-8775460</a><br>or<br>'
                    . '<a href="mailto:info@mtp.ie">info@mtp.ie</a><br>'
                    . 'so we can get you motoring again.';
            }

            if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL) && Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_COMMERCIAL)) {
                $msgg .= '<br/><br/><a href="' . Yii::app()->createUrl('mobile/archive&page=commercial') . '" class="licence_link">Click here for <span>Commercial Archive by MAKE/MODEL</span></a>';
            }
            $this->render('//mobile/gMessage', array(
                'msg' => $msgg,
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));
            exit;
        }
    }

    // New Guide actions:
    public function actionGSelectReg()
    {
        $limit = null;
        if (isset(Yii::app()->params['app_mode']) && Yii::app()->params['app_mode'] != 'development') {
            $limit = 1;
        }
        $options = $this->getArchiveRegOptions($limit);
        $this->render('//mobile/gSelectReg', array(
            'usedCarsMark' => Mobile::getUsedCarsMark(),
            'options' => $options
        ));
    }

    public function getArchiveRegOptions($limit = null)
    {
        $archiveBeginDate   =   $startDate  =   Uzytkownik::getCarsLicenseStartDate();
        $format = "Y-m-d";
        $date1  = DateTime::createFromFormat($format, $startDate);
        $date2  = DateTime::createFromFormat($format, "2012-01-01");
        if ($date2 > $date1) {
            $archiveBeginDate = date($format, strtotime("2012-01-01"));
        }
        $conditionArr = array(
            'order' => '`t`.`id` DESC',
            'condition' => 't.data>date(:x)',
            'params' => array(':x' => $archiveBeginDate),
        );

        if ($limit) {
            $conditionArr['limit'] = $limit;
        }

        $modelImport = Import::model()->with('usedComCarsCount')->findAll($conditionArr);
        return $modelImport;
    }

    public function actionGCarDetails()
    {
        $production         = $this->production;
        if (!isset($_POST['cars_badge'])) {
            $modeltextArr = explode('<-->', $_POST['cars_model']);
            //echo "<pre>"; print_r($modeltextArr); die;
            $_POST['cars_badge'] = $modeltextArr[1];
            $_POST['cars_model'] = $modeltextArr[0];

            $cars_bodyArr = explode('<-->', $_POST['cars_body']);
            $_POST['cars_doors'] = $cars_bodyArr[1];
            $_POST['cars_body'] = $cars_bodyArr[0];
        }

        if ($_POST['cars_badge'] == 'sysbase') {
            $badge = '';
        } else {
            $badge = $_POST['cars_badge'];
        }
        /* if($_POST['cars_body']=='Estate'||$_POST['cars_body']=='Hatch'){
            $_POST['cars_doors']=5;
        } */
        $data = Mobile::getFinalDetailsCars((int)$_POST['cars_mark_name'], $_POST['cars_ranges'], $_POST['cars_model'], $_POST['cars_fuel'], $_POST['cars_transmission'], $_POST['cars_body'], $_POST['cars_doors'], $badge);

        if (empty($data)) {
            return $this->emptyHTMLPage();
        } else {
            $_SESSION['year']    = isset($_REQUEST['year']) ? $_REQUEST['year'] : '';
            $_SESSION['vehicle_type']   = isset($_REQUEST['vehicle_type']) ? $_REQUEST['vehicle_type'] : '';
            $_SESSION['import_id']   = isset($_REQUEST['import_id']) ? $_REQUEST['import_id'] : '';
            $_SESSION['cars_mark_name']   = isset($_REQUEST['cars_mark_name']) ? $_REQUEST['cars_mark_name'] : '';
            $_SESSION['cars_ranges']   = isset($_REQUEST['cars_ranges']) ? $_REQUEST['cars_ranges'] : '';
            $_SESSION['cars_fuel']   = isset($_REQUEST['cars_fuel']) ? $_REQUEST['cars_fuel'] : '';
            $_SESSION['cars_transmission']   = isset($_REQUEST['cars_transmission']) ? $_REQUEST['cars_transmission'] : '';
            $_SESSION['cars_body']   = isset($_REQUEST['cars_body']) ? $_REQUEST['cars_body'] : '';
            $_SESSION['cars_model']   = isset($_REQUEST['cars_model']) ? $_REQUEST['cars_model'] : '';
            $_SESSION['userKms']   = isset($_REQUEST['userKms']) ? $_REQUEST['userKms'] : '';

            return $this->getCarsResultMakeModelHTML($data, 'cars');
        }
    }

    public function emptyHTMLPage()
    {
        $html = "";
        $html .= '<div class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">';
        $html .= '<div class="emphasize4">Your Vehicle</div>';
        $html .= '<div class="emphasize2">
                    <div class="results emphasize2"><span class="emphasize2">We cannot find a match to your selection at this time. Please contact us at <a href="mailto:info@mtp.ie">info@mtp.ie</a> and our research team will assist you. </span></div>
                        </div></div>';
        $html .= '<div class="focusmobile_regscreen">
                    <div class="btn_back btn_centre button-square">
                        <button class="buttonBack" onclick="goUp()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
                            <span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
                        </button>
                    </div> 
                </div>';
        echo $html;
    }

    /*
    * Get HTML for Search by Make and Model page on the form page.
    * Check KMS here too
    * Must be only for Mobile version App
    * Developed on 11-May-2020
    */
    public function getCarsResultMakeModelHTML($data, $type = 'cars')
    {
        $car = null;
        if (!empty($data) && is_array($data)) {
            if (sizeof($data) == 1) {
                $car = $data[0];
            } else {
                $car = $data[0];
            }
        }

        $pdfData = [];
        if ($car['codenumber'] != '') {
            echo '<div class="emphasize4" style="text-align:center;">
             <input type="hidden" id="codenumber" name="codenumber" value="' . strtolower($car['codenumber']) . '"></div>';
        }

        echo '<div class="table_ui ui-body ui-body-a ui-corner-all reg_sel" data-theme="a" data-form="ui-body-a">';
        echo '<div class="emphasize4"><span id="titleFieldFromXml">Your Vehicle';
        if (isset(Yii::app()->params['app_mode']) && Yii::app()->params['app_mode'] == 'development') {
            echo ' - ' . $car['codenumber'];
        }
        echo '</span></div>';

        echo '<div class="emphasize2">';

        echo '<div class="mobile-show">';
        if (sizeof($_POST['year'] > 2)) {
            echo Mobile::displayFullYearForRegYear($_POST['year']) . ' (' . $_POST['year'] . ')'; // convert
            $pdfData['year'] = Mobile::displayFullYearForRegYear($_POST['year']) . ' (' . $_POST['year'] . ')';
        } else {
            echo Mobile::displayFullYearForRegYear($_POST['year']) . ' '; // convert
            $pdfData['year'] = Mobile::displayFullYearForRegYear($_POST['year']);
        }
        echo '</div>';
        echo '<div class="mobile-show">' . $car['maker'] . '</div>';
        echo '<div>' . $car['vehicle'] . '</div>';
        echo '<div class="mobile-show">' . $car['badge'] . '</div>';
        echo '<div>' . strtoupper(Mobile::getFuelText($car['fuel'])) . '</div>';
        echo '<div>' . strtoupper($car['transmission']) . '</div>';
        echo '<div>' . strtoupper($car['bod']) . '</div>';
        echo ($car['drs']) ? '<div>' . $car['drs'] . ' doors</div>' : "";

        $pdfData['maker'] = isset($car['maker']) ? $car['maker'] : '';
        $pdfData['vehicle'] = isset($car['vehicle']) ? $car['vehicle'] : '';
        $pdfData['badge'] = isset($car['badge']) ? $car['badge'] : '';
        $pdfData['fuel'] = isset($car['fuel']) ? strtoupper(Mobile::getFuelText($car['fuel'])) : '';
        $pdfData['transmission'] = isset($car['transmission']) ? strtoupper($car['transmission']) : '';
        $pdfData['bod'] = isset($car['bod']) ? strtoupper($car['bod']) : '';
        $pdfData['drs'] = isset($car['drs']) ? $car['drs'] : '';

        $pdfData['maker'] = isset($car['maker']) ? $car['maker'] : '';
        $pdfData['vehicle'] = isset($car['vehicle']) ? $car['vehicle'] : '';
        $pdfData['badge'] = isset($car['badge']) ? $car['badge'] : '';
        $pdfData['fuel'] = isset($car['fuel']) ? strtoupper(Mobile::getFuelText($car['fuel'])) : '';
        $pdfData['transmission'] = isset($car['transmission']) ? strtoupper($car['transmission']) : '';
        $pdfData['bod'] = isset($car['bod']) ? strtoupper($car['bod']) : '';
        $pdfData['drs'] = isset($car['drs']) ? $car['drs'] : '';

        if (Yii::app()->params['is_test_version']) {
            echo $car['codenumber'] . ' <br/>';
        }

        if (empty($_POST['userKms'])) {
            $info = $car->getValueAndKmsForYear($_POST['year']);
        } else {
            $info = $car->getValueAndKmsForYear($_POST['year']);
            $input = array();
            $kms =  $_POST['userKms'] / 1000;
            $input['km'] = $kms;
            $input['year'] = $_POST['year'];
            $input['fuel'] = $car['fuel'];
            $input['guide'] = $info['value']; // ze znakiem euro            
            $input['guideKm'] = $info['kms']; // km z tabeli          
            $input['import'] = $_POST['import_id'];
            $input['codenumber'] = $car['codenumber'];

            if ($_POST['vehicle_type'] == 'cars') {
                $input['carOrCom'] = 'UsedCarsModel';
                $adjustedValueArray = UsedCars::odometerCalculation($input);
            } else {
                $input['carOrCom'] = 'UsedCarsComModel';
                $adjustedValueArray = UsedCars::odometerCalculation($input);
            }
            $adjustedValue = $adjustedValueArray['adjustedValue'];

            //echo 'adjustedValue'.$adjustedValue;
            if (Mobile::isNumber($adjustedValue)) {
                $info['kms'] = $kms;
                $info['value'] = $adjustedValue;
            } else {
                echo '<br><div class="results emphasize2"><span class=\'emphasize2\'>' . $adjustedValue . '</span></div>';
            }
        }

        if (Mobile::isNumber($info['value'])) {
            $valueString = '<div class="results emphasize4" style="text-align:center; margin-bottom: -10px;">Guide Price <span>&euro;' . Mobile::displayValue($info['value']) . '</span></div>';
            $pdfData['GuidePrice'] = isset($info['value']) ? '&euro;' . Mobile::displayValue($info['value']) : '';
        } else {
            $valueString = '<div class="results emphasize3" >Guide Price <span>NA</span></div>';
            $pdfData['GuidePrice'] = 'NA';
        }
        echo $valueString;
        echo '</div>';
        $kmsString = '<div class="results emphasize2" style="display: flex;width: 100%;margin: 10px 0;text-align: center;align-items: center;
    justify-content: center;"><div class="res_desc">With&nbsp;</div><div class="res_res"><span class="emphasize2 text-left" style="text-align: left;">' . Mobile::displayKms($info['kms']) . '&nbsp;Kms</span></div></div>';

        $pdfData['kmsString'] = isset($info['kms']) ? Mobile::displayKms($info['kms']) . ' Kms' : '';
        echo $kmsString;

        $buttons = ($type == 'cars') ? 'goCarsUp' : 'goCommsUp';
        echo '</div><input type="hidden" id="displayData" name="displayData" value="' . base64_encode(json_encode($pdfData)) . '">';

        $usedCarsMark = Mobile::getUsedCarsMark();
        if ($type == 'cars') {
            echo '<div class="rows pdficons" style="display:none;">
                        <div class="col-md-12 text-right pdflinks">
                            <a target="__blank" href="' . Yii::app()->createUrl('/mobile/makeModelGeneratePdf', array('m' => 'UsedCarsModel', 'imp' => $usedCarsMark[0]['id_import'])) . '" data-baseurl="' . Yii::app()->createUrl('/mobile/makeModelGeneratePdf', array('m' => 'UsedCarsModel', 'imp' => $usedCarsMark[0]['id_import'])) . '"><img src="./images/pdf.png" style="width:28px; height:28px;" alt="[pdf]" /></a>
                        </div>
                </div>';
        }

        if ($type == 'comms') {
            echo '<div class="row pdficonss" style="display:none;">
                    <div class="col-md-12 text-right pdflinkss">
                        <a target="__blank" href= "' . Yii::app()->createUrl('/mobile/makeModelGeneratePdf', array('m' => 'UsedCarsModel', 'imp' => $usedCarsMark[0]['id_import'])) . '" data-baseurl="' . Yii::app()->createUrl('/mobile/makeModelGeneratePdf', array('m' => 'UsedCarsModel', 'imp' => $usedCarsMark[0]['id_import'])) . '"><img src="./images/pdf.png" style="width:28px; height:28px;" alt="[pdf]" /></a>
                    </div>
                </div>';
        }

        echo '<div class="focusmobile_regscreen">
            <div class="btn_back btn_centre button-square">
          <button class="buttonBack" onclick="' . $buttons . '()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
            <span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
          </button>
        </div> </div>';
    }

    public function actionGSelectMakeComms()
    {
        $production         = $this->production;
        if (!isset($_POST['comms_badge'])) {
            $modeltextArr = explode('<-->', $_POST['comms_model']);
            $_POST['comms_badge'] = $modeltextArr[1];
            $_POST['comms_model'] = $modeltextArr[0];

            $cars_bodyArr = explode('<-->', $_POST['comms_body']);
            $_POST['comms_doors'] = $cars_bodyArr[1];
            $_POST['comms_body'] = $cars_bodyArr[0];
        }

        if ($_POST['comms_badge'] == 'sysbase') {
            $badge = '';
        } else {
            $badge = $_POST['comms_badge'];
        }
        if ($_POST['comms_body'] == "Pick Up S'Cab") {
            $_POST['comms_doors'] = 2;
        }
        if ($_POST['comms_body'] == "Pick Up D'Cab") {
            $_POST['comms_doors'] = 4;
        }

        if ($_POST['comms_body'] == "Commercial") {
            $_POST['comms_doors'] = 5;
        }
        $data = Mobile::getFinalDetailsComms((int)$_POST['comms_mark_name'], $_POST['comms_ranges'], $_POST['comms_model'], $_POST['comms_fuel'], $_POST['comms_transmission'], $_POST['comms_body'], $_POST['comms_doors'], $badge);
        if (empty($data)) {
            return $this->emptyHTMLPage();
        } else {

            $_SESSION['com_year']    = isset($_REQUEST['year']) ? $_REQUEST['year'] : '';
            $_SESSION['com_vehicle_type']   = isset($_REQUEST['vehicle_type']) ? $_REQUEST['vehicle_type'] : '';
            $_SESSION['com_import_id']   = isset($_REQUEST['import_id']) ? $_REQUEST['import_id'] : '';
            $_SESSION['comms_mark_name']   = isset($_REQUEST['comms_mark_name']) ? $_REQUEST['comms_mark_name'] : '';
            $_SESSION['comms_ranges']   = isset($_REQUEST['comms_ranges']) ? $_REQUEST['comms_ranges'] : '';
            $_SESSION['comms_fuel']   = isset($_REQUEST['comms_fuel']) ? $_REQUEST['comms_fuel'] : '';
            $_SESSION['comms_transmission']   = isset($_REQUEST['comms_transmission']) ? $_REQUEST['comms_transmission'] : '';
            $_SESSION['comms_body']   = isset($_REQUEST['comms_body']) ? $_REQUEST['comms_body'] : '';
            $_SESSION['comms_model']   = isset($_REQUEST['comms_model']) ? $_REQUEST['comms_model'] : '';
            $_SESSION['comms_userKms']   = isset($_REQUEST['userKms']) ? $_REQUEST['userKms'] : '';
            return $this->getCarsResultMakeModelHTML($data, 'comms');
        }
    }

    public function actionGRegCarDetails()
    {
        $this->render('//mobile/gRegCarDetails', array(
            'usedCarsMark' => Mobile::getUsedCarsMark(),
        ));
    }

    public function actionGSelectMake()
    {
        $production         = $this->production;
        $licence            = Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS);

        if ($licence) {
            $selectedYear    = isset($_GET['year']) ? $_GET['year'] : '';
            $selectedCarMake = isset($_GET['cars_mark_name']) ? $_GET['cars_mark_name'] : '';
            $selectedcars_fuel = isset($_GET['cars_fuel']) ? $_GET['cars_fuel'] : '';
            $ranges[]        = '';
            $fuelData[]        = '';
            $transmissionData[] = '';
            $carsBodyData[] = '';
            $modelTypeData[] = '';
            if ($selectedYear && $selectedCarMake) {
                $ranges = UsedCars::getManufacturersRanges((int) $selectedCarMake, $selectedYear);
                if ($ranges) {
                    $ranges = array_flip($ranges);
                } else {
                    $ranges[] = 'No Range Available';
                }
            }

            $selectedcars_ranges = isset($_GET['cars_ranges']) ? $_GET['cars_ranges'] : '';
            if ($selectedcars_ranges) {
                $fuelData = Mobile::getFuelOptions('UsedCarsModel', (int)$selectedCarMake, $selectedcars_ranges);
            }


            if ($selectedcars_fuel) {
                $transmissionData = Mobile::getTransmissionOptions('UsedCarsModel', (int)$selectedCarMake, $selectedcars_ranges, $selectedcars_fuel, $selectedYear);
            }

            $selectedcars_transmission = isset($_GET['cars_transmission']) ? $_GET['cars_transmission'] : '';
            if ($selectedcars_transmission) {
                $transData = Mobile::getBodyDoorsWithoutModel('UsedCarsModel', (int)$selectedCarMake, $selectedcars_ranges, $selectedcars_fuel, $selectedcars_transmission, $selectedYear);
                foreach ($transData as $index => $car_data) {
                    foreach ($car_data as $value => $cars_model) {
                        $doors = ($value) ? $value . " doors" : "";
                        $carsBodyData[$cars_model . '<-->' . $value] = $cars_model . ' ' . $doors;
                    }
                }
                $carsBodyData = array_filter($carsBodyData);
            }

            $selectedcars_body = isset($_GET['cars_body']) ? $_GET['cars_body'] : '';
            if ($selectedcars_body) {
                $modeltext = explode('<-->', $selectedcars_body);
                $badgetype = $modeltext[1];
                $carmodel =  $modeltext[0];
                $modelType       = Mobile::getModelsByRangeForTheBand('UsedCarsModel', (int) $selectedCarMake, $selectedcars_ranges, $selectedcars_fuel, $selectedcars_transmission, $badgetype, $carmodel);
                $data = Mobile::filterForChosenYear($modelType, $selectedYear);
                $listData = array_unique(CHtml::listData($data, 'codenumber', function ($data) {
                    return $data->vehicle . "<->" . $data->badgetype . "<->" . $data->body;
                }));

                foreach ($listData as $value => $cars_model) {
                    /* To add code number for testing */
                    $carModelValue = explode("<->", $cars_model);
                    $vehicle = $carModelValue[0];
                    $badgetype = $carModelValue[1];
                    $body = $carModelValue[2];
                    $codenumber = $value;
                    $cars_model = str_replace('<->', " - ", $cars_model);
                    /* end */
                    $modelTypeData[$vehicle . '<-->' . $badgetype] =  $vehicle . ' - ' . $codenumber . ' - ' . $badgetype;
                }
            }


            $this->render('//mobile/gSelectMake', array(
                'usedCarsMark' => Mobile::getUsedCarsMark(),
                'page_model'    =>  'UsedCarsModel',
                'pdfbackdata' => $_REQUEST,
                'production' => $production,
                'ranges' => $ranges,
                'fuelData' => $fuelData,
                'transmissionData' => $transmissionData,
                'carsBodyData' => $carsBodyData,
                'modelTypeData' => $modelTypeData
            ));
        } else {
            $msgg = 'Oops! Seems that your licence for the used cars expired. <br>'
                . 'Please contact our office <br>on<br><a href="tel:018775460" class="licence_link">01-8775460</a><br>or<br>'
                . '<a href="mailto:info@mtp.ie" class="licence_link">info@mtp.ie</a><br>'
                . 'so we can get you motoring again.';

            $comlicence = Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL);
            if ($comlicence) {
                $msgg .= '<br/><br/><a href="' . Yii::app()->createUrl('mobile/gSelectMakeComm') . '" class="licence_link">Click here for <span>Commercial MAKE/MODEL Search</span></a>';
            }

            $this->render('//mobile/gMessage', array(
                'msg' => $msgg,
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));
        }
    }

    public function actionGSelectMake_bkp()
    {
        $licence = Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS);

        if ($licence) {
            $this->render('//mobile/gSelectMake_bkp', array(
                'usedCarsMark' => Mobile::getUsedCarsMark(),
                'page_model'    =>    'UsedCarsModel'
            ));
        } else {
            $this->render('//mobile/gMessage', array(
                'msg' => 'Oops! Seems that your licence for the used cars expired. <br>'
                    . 'Please contact our office <br>on<br><a href="tel:018775460">01-8775460</a><br>or<br>'
                    . '<a href="mailto:info@mtp.ie">info@mtp.ie</a><br>'
                    . 'so we can get you motoring again.',
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));
        }
    }

    public function actionGSelectMakeComm()
    {
        $licence = Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL);

        if ($licence) {
            $selectedYear = isset($_GET['com_year']) ? $_GET['com_year'] : '';
            $selectedcomms_mark_name = isset($_GET['comms_mark_name']) ? $_GET['comms_mark_name'] : '';
            $selectedcars_ranges = isset($_GET['comms_ranges']) ? $_GET['comms_ranges'] : '';
            $selectedcars_fuel = isset($_GET['comms_fuel']) ? $_GET['comms_fuel'] : '';
            $selectedcars_transmission = isset($_GET['comms_transmission']) ? $_GET['comms_transmission'] : '';
            $selectedcars_body = isset($_GET['comms_body']) ? $_GET['comms_body'] : '';
            $selectedcars_model = isset($_GET['comms_model']) ? $_GET['comms_model'] : '';
            $ranges = [];
            if ($selectedcomms_mark_name) {
                $ranges = UsedComCars::getManufacturersRanges((int) $selectedcomms_mark_name);
                $ranges = array_flip($ranges);
            }

            $fuelOptiondata = [];
            if ($selectedcars_ranges) {
                $fuelOptiondata = Mobile::getFuelOptions('UsedComCarsModel', (int)$selectedcomms_mark_name, $selectedcars_ranges);
            }

            $transdata = [];
            if ($selectedcars_fuel) {
                $transdata = Mobile::getTransmissionOptions('UsedComCarsModel', (int)$selectedcomms_mark_name, $selectedcars_ranges, $selectedcars_fuel, $selectedYear);
            }

            $BodyDoorsWithoutdata = [];
            if ($selectedcars_transmission) {
                $bodyDoorData = Mobile::getBodyDoorsWithoutModel('UsedComCarsModel', (int)$selectedcomms_mark_name, $selectedcars_ranges, $selectedcars_fuel, $selectedcars_transmission, $selectedYear);
                foreach ($bodyDoorData as $index => $car_data) {
                    foreach ($car_data as $value => $cars_model) {
                        $doors = ($value) ? $value . " doors" : "";
                        $BodyDoorsWithoutdata[$cars_model . '<-->' . $value] = $cars_model . ' ' . $doors;
                    }
                }
            }

            $modelTypedata = [];
            if ($selectedcars_body) {
                $modeltext = explode('<-->', $selectedcars_body);
                $badgetype = $modeltext[1];
                $carmodel =  $modeltext[0];
                $data = Mobile::getModelsByRangeForTheBand('UsedComCarsModel', (int) $selectedcomms_mark_name, $selectedcars_ranges, $selectedcars_fuel, $selectedcars_transmission, $badgetype, $carmodel);

                $data = Mobile::filterForChosenYear($data, $selectedYear);
                $listData = array_unique(CHtml::listData($data, 'codenumber', function ($data) {
                    return $data->vehicle . "<->" . $data->badgetype . "<->" . $data->body;
                }));
                foreach ($listData as $value => $cars_model) {
                    /* To add code number for testing */
                    $carModelValue = explode("<->", $cars_model);
                    $vehicle = $carModelValue[0];
                    $badgetype = $carModelValue[1];
                    $body = $carModelValue[2];
                    $codenumber = $value;
                    $cars_model = str_replace('<->', " - ", $cars_model);
                    /* end */
                    $modelTypedata[$vehicle . '<-->' . $badgetype] = $vehicle . ' - ' . $codenumber . ' - ' . $badgetype;
                }
            }

            $this->render('//mobile/gSelectMakeComm', array(
                'usedCarsMark' => Mobile::getUsedCommercialMark(),
                'page_model'    =>    'UsedComCarsModel',
                'ranges' => $ranges,
                'fuelOptiondata' => $fuelOptiondata,
                'transdata' => $transdata,
                'BodyDoorsWithoutdata' => $BodyDoorsWithoutdata,
                'modelTypedata' => $modelTypedata
            ));
        } else {
            $this->render('//mobile/gMessage', array(
                'msg' => 'Oops! Seems that your licence for the commercial vehicles expired. <br>'
                    . 'Please contact our office <br>on<br><a href="tel:018775460" class="licence_link">01-8775460</a><br>or<br>'
                    . '<a href="mailto:info@mtp.ie" class="licence_link">info@mtp.ie</a><br>'
                    . 'so we can get you motoring again.',
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));
        }
    }

    public function actionGSelectMakeComm_bkp()
    {
        $licence = Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL);

        if ($licence) {
            $this->render('//mobile/gSelectMakeComm_bkp', array(
                'usedCarsMark' => Mobile::getUsedCommercialMark(),
            ));
        } else {
            $this->render('//mobile/gMessage', array(
                'msg' => 'Oops! Seems that your licence for the commercial vehicles expired. <br>'
                    . 'Please contact our office <br>on<br><a href="tel:018775460">01-8775460</a><br>or<br>'
                    . '<a href="mailto:info@mtp.ie">info@mtp.ie</a><br>'
                    . 'so we can get you motoring again.',
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));
        }
    }

    //loadCarsModelFuel
    /* ---------------------------------------------------------------------- */
    /* CARS actions ----------------------------------------------------------*/
    /* ---------------------------------------------------------------------- */

    /**
     * Metoda renderuje widok, dodatkowo przekazuje liste marek
     */
    public function actionSelectCars()
    {
        $this->render('//mobile/selectCars', array(
            'usedCarsMark' => Mobile::getUsedCarsMark(),
        ));
    }

    /**
     * Metoda ajaxowo uzupelnia select modelami dla wybranej marki
     */
    public function actionLoadMake()
    {
        $data = Mobile::getUsedCarsMark();
        $listData = CHtml::listData($data, 'id', 'name');
        echo "<option value=''>Select Make</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }
    public function actionLoadCommercialMake()
    {
        $data = Mobile::getUsedCommercialMark();

        $listData = CHtml::listData($data, 'id', 'name');
        echo "<option value=''>Select Make</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCarsModel()
    {
        $data = Mobile::getModelsByRangeForTheBandForCars((int) $_POST['mark_id'], $_POST['range_id']);
        if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
            //vehiclaBadgeAndYear zdefiniowane specjalnie dla tej listy w modelu UsedCarsModel
            $listData = CHtml::listData($data, 'id', 'vehiclaBadgeAndYear');
            echo "<option value=''>Select Model</option>";
        } else {
            $data = Mobile::filterForChosenYear($data, $_POST['year']);
            $listData = array_unique(CHtml::listData($data, 'vehicle', 'vehicle'));
            echo "<option value=''>Select Model</option>";
        }
        foreach ($listData as $value => $cars_model) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
        }
    }

    public function actionLoadCarsRanges()
    {
        if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
            $ranges = UsedCars::getManufacturersRanges((int) $_POST['mark_id']);
        } else {
            $ranges = UsedCars::getManufacturersRanges((int) $_POST['mark_id'], $_POST['year']);
        }

        if ($ranges) {
            $ranges = array_flip($ranges);
            echo "<option value=''>Select Range</option>";
            foreach ($ranges as $value => $cars_model)
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
        } else {
            echo "<option value=''>No Range Available</option>";
        }
    }

    public function actionLoadCarsFuel()
    {
        $data = Mobile::getFuelOptions("UsedCarsModel", (int)$_POST['mark_id'], $_POST['range_id']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');

        echo "<option value=''>Select Fuel</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCommsFuel()
    {
        $data = Mobile::getFuelForComms((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');

        echo "<option value=''>Select Fuel</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCarsTransmission()
    {
        $data = Mobile::getTransmissionForCars((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt'], $_POST['cars_fuel']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Transmission</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCarsBody()
    {
        $data = Mobile::getBodyForCars((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt'], $_POST['cars_fuel'], $_POST['cars_transmission']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Body</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCarsDoors()
    {
        $data = Mobile::getDoorsForCars((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt'], $_POST['cars_fuel'], $_POST['cars_transmission'], $_POST['cars_body']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Doors</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCarsBadgeType()
    {
        $data = Mobile::getBadgeTypeForCars((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt'], $_POST['cars_fuel'], $_POST['cars_transmission'], $_POST['cars_body'], $_POST['cars_doors']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Type</option>";
        foreach ($listData as $value => $cars_model) {
            if ($value == '') {
                echo CHtml::tag('option', array('value' => 'sysbase'), CHtml::encode('Base model'), true);
            } else {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
            }
        }
    }

    /**
     * Metoda renderuje widok z danymi wybranego modelu
     */
    public function actionLoadCarsModelDetails()
    {
        if (!empty($_POST['car_id'])) {
            $lvDataImportu = (empty($_POST['import_nazwa'])) ? '' : $_POST['import_nazwa'];
            $lvIdImportu = (empty($_POST['import_id'])) ? '' : $_POST['import_id'];
            $this->renderPartial(
                '_detailsData',
                array(
                    'data' => Mobile::getDetailsDataForUsedCars((int) $_POST['car_id']),
                    'nazwa_importu' => $lvDataImportu,
                    'import_id' => $lvIdImportu,
                    'carOrCom' => 'UsedCarsModel'
                ),
                false,
                true
            );
            Yii::app()->end();
        }
    }

    /* ---------------------------------------------------------------------- */
    /* COMMERCIAL actions ----------------------------------------------------*/
    /* ---------------------------------------------------------------------- */

    /**
     * Metoda ajaxowo renderuje widok z danymi wybranego modelu
     */
    public function actionSelectCommercials()
    {
        $this->render('//mobile/selectCommercials', array(
            'usedCommercialMark' => Mobile::getUsedCommercialMark(),
        ));
    }

    public function actionLoadCommercialRanges()
    {
        $ranges = UsedComCars::getManufacturersRanges((int) $_POST['mark_id']);
        $ranges = array_flip($ranges);
        echo "<option value=''>Select Model</option>";
        foreach ($ranges as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    /**
     * Metoda ajaxowo uzupelnia select modelami dla wybranej marki
     */
    public function actionLoadCommercialModel()
    {
        $data = Mobile::getModelsByRangeForTheBandForComms((int) $_POST['mark_id'], $_POST['range_id']);
        if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
            //vehiclaBadgeAndYear zdefiniowane specjalnie dla tej listy w modelu UsedComCarsModel
            $listData = CHtml::listData($data, 'id', 'vehiclaBadgeAndYear');
            echo "<option value=''>Select Model</option>";
        } else {
            $data = Mobile::filterForChosenYear($data, $_POST['year']);
            //vehiclaBadgeAndYear zdefiniowane specjalnie dla tej listy w modelu UsedComCarsModel
            //was : $listData = CHtml::listData($data,'id','vehiclaBadgeAndYear');
            $listData = array_unique(CHtml::listData($data, 'vehicle', 'vehicle'));
            //$listData = CHtml::listData($data,'vehicle','vehicle');
            echo "<option value=''>Select Model</option>";
        }
        foreach ($listData as $value => $cars_model) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
        }
    }

    public function actionLoadCommercialTransmission()
    {
        $data = Mobile::getTransmissionForComms((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt'], $_POST['comms_fuel']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Transmission</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCommercialBody()
    {
        $data = Mobile::getBodyForComms((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt'], $_POST['comms_fuel'], $_POST['comms_transmission']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Body</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCommercialDoors()
    {
        $data = Mobile::getDoorsForComms((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt'], $_POST['comms_fuel'], $_POST['comms_transmission'], $_POST['comms_body']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Doors</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadCommsBadgeType()
    {
        $data = Mobile::getBadgeTypeForComms((int)$_POST['mark_id'], $_POST['range_id'], $_POST['model_txt'], $_POST['comms_fuel'], $_POST['comms_transmission'], $_POST['comms_body'], $_POST['comms_doors']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Type</option>";
        foreach ($listData as $value => $cars_model) {
            if ($value == '') {
                echo CHtml::tag('option', array('value' => 'sysbase'), CHtml::encode('Base model'), true);
            } else {
                echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
            }
        }
    }

    /**
     * Metoda ajaxowo renderuje widok z danymi wybranego modelu
     */
    public function actionLoadCommercialModelDetails()
    {
        if (!empty($_POST['car_id'])) {
            $lvDataImportu = (empty($_POST['import_nazwa'])) ? '' : $_POST['import_nazwa'];
            $lvIdImportu = (empty($_POST['import_id'])) ? '' : $_POST['import_id'];
            $this->renderPartial(
                '_detailsData',
                array(
                    'data' => Mobile::getDetailsDataForUsedCommercial((int) $_POST['car_id']),
                    'nazwa_importu' => $lvDataImportu,
                    'import_id' => $lvIdImportu,
                    'carOrCom' => 'UsedComCarsModel'
                ),
                false,
                true
            );
            Yii::app()->end();
        }
    }

    /**
     * Render widoku po obliczeniach - wyniki sa przekazywane
     */
    public function actionAjaxOdometerCalc()
    {
        $this->renderPartial('//member/_ajaxAdjustedValue', UsedCars::odometerCalculation($_POST));
    }

    ///////////////////////////////////////////////////////
    // END OF NEW ACTIONS FOR GUIDE    ********************
    ///////////////////////////////////////////////////////

    /**
     * Metoda renderuje widok menu glownego
     * Akcja jest wywolywana po metodzie beforeAction dlatego dla tej akcji 
     * back button musi byc ukryty
     */
    public function actionMainMenu()
    {
        Yii::app()->user->setFlash('showBackButton', null);
        $this->render('//mobile/mainMenu', array(
            'mobileMenu' => Mobile::getMobileSites(),
        ));
    }

    /**
     * Metoda renderuje strone pobrana po urlu z BD
     */
    public function actionView()
    {
        $lvUrl = (empty($_GET['url'])) ? '' : $_GET['url'];
        if (!empty($lvUrl)) {
            $lvMobilePage = Mobile::getSiteContent($lvUrl);
            switch ($lvMobilePage->layout) {
                case 39: // Editorial
                    $lvRenderPage = '//mobile/mobileEditorialsPage';
                    $lvConditions = array(
                        'site' => $lvMobilePage,
                        'lvNews' => Mobile::getAllNews()
                    );
                    break;
                case 17: // Contact
                    $lvRenderPage = '//mobile/mobileContactPage';
                    $lvConditions = array('site' => $lvMobilePage);
                    break;
                default: // Text Page
                    $lvRenderPage = '//mobile/mobileTextPage';
                    $lvConditions = array('site' => $lvMobilePage);
                    break;
            }
            $this->render($lvRenderPage, $lvConditions);
        } else {
            $this->forward('mainMenu');
        }
    }

    /**
     * Render panelu logowania
     */
    public function actionLoginPanel()
    {
        $this->render('//mobile/loginPanel', array('model' => new LoginForm));
    }

    /**
     * Logowanie do aplikacji
     * Dodatkowo jest przeprowadzana walidacja czy user ma dostep do mobile.
     */
    public function actionLogin()
    {
        $model = new LoginForm;
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate()) {
                if (Yii::app()->user->isMobileOn) {
                    //$this->forward('chooseType');
                    $this->forward('mainMenu');
                } else {
                    Yii::app()->user->setFlash('mobileError', self::$PARAM_ACCES_DENIED);
                    $this->forward('mainMenu');
                }
            } else {
                Yii::app()->user->setFlash('mobileError', self::$PARAM_INCORRECT_LOGIN_PASS);
            }
        }
        $this->forward('loginPanel');
    }

    /**
     * W akcji sprawdzane jest ciastko. Jeśli jest poprawne renderowany jest 
     * widok w ktorym uzytkownik wybiera typ Cars/Commercial
     */
    public function actionChooseType()
    {
        if (Yii::app()->user->isGuest) {
            $this->forward('loginPanel');
        } else {
            $lvUser = Uzytkownik::model()->find(array(
                'condition' => 'id=:id',
                'params' => array(':id' => Yii::app()->user->getId())
            ));
            if (Mobile::checkCookie($lvUser)) {
                $this->render('//mobile/chooseType', array('userModel' => $lvUser));
            } else {
                Yii::app()->user->setFlash('mobileError', self::$PARAM_ACCES_DENIED);
                $this->forward('mainMenu');
            }
        }
    }
    public function actionChooseTypeIFrame()
    {
        $this->layout = '//layouts/iframeMobile';
        if (Yii::app()->user->isGuest) {
            $this->forward('loginPanel');
        } else {
            $lvUser = Uzytkownik::model()->find(array(
                'condition' => 'id=:id',
                'params' => array(':id' => Yii::app()->user->getId())
            ));
            if (Mobile::checkCookie($lvUser)) {
                $this->render('//mobile/chooseType', array('userModel' => $lvUser));
            } else {
                Yii::app()->user->setFlash('mobileError', self::$PARAM_ACCES_DENIED);
                $this->forward('mainMenu');
            }
        }
    }

    /**
     * Wylogowanie uzytkownika z aplikacji
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->forward('mainMenu');
    }
    public function actionLogoutwp()
    {
        Uzytkownik::destroyNetworkSession();
        Yii::app()->user->logout();
        if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
            echo '<script>window.top.location.href = "http://mtp.ie/login/";</script>';
        } else {
            echo '<script>window.top.location.href = "' . Yii::app()->params['main_url'] . 'login/";</script>';
        }
    }

    /**
     * Metoda obslugujaca strone kontaktowa wersji mobilnej
     */
    public function actionContact()
    {
        $model = new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes = $_POST['ContactForm'];
            if ($model->validate()) {
                $header = "From {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'], $model->subject, $model->body, $header);
                Yii::app()->user->setFlash('contact', 'Message sent.');
                $this->refresh();
            }
            $this->render('//mobile/mobileContactPage', array('site' => Mobile::getSiteContent('mob_contact')));
            Yii::app()->end();
        }
        $this->actionView('mob_contact');
    }

    /**
     * Render widoku pozwalajacego wybrac New Prices
     * Cars / Commercial
     */
    public function actionChooseNewPrices()
    {
        $this->render('chooseNewPrices');
    }

    public function actionTempMessage()
    {
        $this->render('tempMessage');
    }

    /**
     * CARS
     * Metoda renderuje specjalnie dla mobile przygotowany widok new prices
     */
    public function actionShowNewPricesCars()
    {
        $this->render('mobileNewPricesCars', array('xmlManFileData' => Mobile::getNewPricesCarsManData()));
    }

    public function actionShowNewPricesCarsRanges($manufacturer, $car)
    {
        $this->render('mobileNewPricesCarsRanges', array('car' => $car, 'manufacturer' => $manufacturer));
    }

    /**
     * Render widoku New Prices CARS
     */
    public function actionCarModels()
    {
        $this->render('mobileNewPricesCarsModelsList', array(
            'carModels' => Mobile::getCarData($_GET['car']),
            'rangecode' => $_GET['rangecode'],
            'file' => $_GET['car']
        ));
    }

    /**
     * NEW PRICES - CARS
     * Metoda renderuje widok z uzupelniona tablica danych
     */
    public function actionViewAjaxNewCars()
    {
        $vehicle = array();
        $vehicle['model'] = $_GET['model'];
        $vehicle['doors'] = $_GET['doors'];
        $vehicle['body'] = $_GET['body'];
        $vehicle['retail'] = $_GET['retail'];
        $vehicle['engine'] = $_GET['engine'];
        $vehicle['bhp'] = $_GET['bhp'];
        $vehicle['vrt'] = $_GET['vrt'];
        $vehicle['band'] = $_GET['band'];
        $vehicle['co2'] = $_GET['co2'];
        $vehicle['fuel'] = $_GET['fuel'];
        $vehicle['tax'] = $_GET['tax'];

        $this->renderPartial(
            '_mobileNewPricesCarsDetails',
            array('vehicle' => $vehicle),
            false,
            true
        );
    }

    /**
     * COMMERCIAL
     * Metoda renderuje specjalnie dla mobile przygotowany widok new prices
     */
    public function actionShowNewPricesComm()
    {
        $this->render('mobileNewPricesCommercial', array('xmlManFileData' => Mobile::getNewPricesCommManData()));
    }

    public function actionShowNewPricesCommRanges($manufacturer, $car)
    {
        $this->render('mobileNewPricesCommRanges', array('car' => $car, 'manufacturer' => $manufacturer));
    }

    /**
     * Render widoku New Prices COMMERCIAL
     */
    public function actionCommModels()
    {
        $this->render('mobileNewPricesCommModelsList', array(
            'carModels' => Mobile::getCommData($_GET['car']),
            'rangecode' => $_GET['rangecode'],
            'file' => $_GET['car']
        ));
    }

    /**
     * NEW PRICES - COMMERCIAL
     * Metoda renderuje widok z uzupelniona tablica danych
     */
    public function actionViewAjaxNewComm()
    {
        $vehicle = array();
        $vehicle['model'] = $_GET['model'];
        $vehicle['body'] = $_GET['body'];
        $vehicle['retail'] = $_GET['retail'];
        $vehicle['gvw'] = $_GET['gvw'];
        $vehicle['cc'] = $_GET['cc'];
        $vehicle['cat'] = $_GET['cat'];
        $vehicle['vrt'] = $_GET['vrt'];
        $vehicle['band'] = $_GET['band'];
        $vehicle['co2'] = $_GET['co2'];
        $vehicle['fuel'] = $_GET['fuel'];
        $vehicle['tax'] = $_GET['tax'];

        $this->renderPartial(
            '_mobileNewPricesCommDetails',
            array('vehicle' => $vehicle)
        );
    }

    /**
     * Metoda renderuje specjalnie dla mobile przygotowany widok po wyslaniu formularza valuations
     */
    public function actionValuationThanks()
    {
        unset($_POST);
        $this->render('valuationThanks');
    }

    public function actionSelectCarsTest()
    {
        $this->render('//mobile/selectCarsTest', array(
            'usedCarsMark' => Mobile::getUsedCarsMark(),
        ));
    }

    public function actionNewPricesCars()
    {
        $this->render('//mobile/newPricesCars', array(
            'usedCarsMark' => Mobile::getUsedCarsMark()
        ));
    }

    public function actionNewPricesCarsPdf()
    {
        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/mobile/newPricesCarsPdf.php'); // inaczej nie da sie otworzyc pliku
        $this->render('//member/newPricesCarsPdf');
    }

    public function actionNewPricesCommsPdf()
    {

        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/mobile/newPricesCommsPdf.php'); // inaczej nie da sie otworzyc pliku
        $this->render('newPricesCommsPdf');
    }

    public function actionArchive_old()
    {
        QDinkey::checkDinkeyAccess();
        $modelImport = Import::model()->with('usedComCarsCount')->findAll(array(
            'order' => '`t`.`id` DESC',
        ));
        $this->render('//mobile/archive', array('modelImport' => $modelImport, 'carComIds' => $carComIds));
    }

    public function actionArchive_bkp()
    {
        QDinkey::checkDinkeyAccess();

        $modelImport = Import::model()->with('usedComCarsCount')->findAll(array(
            'order' => '`t`.`id` DESC',
        ));

        $comMonths = array('December' => 'November', 'November' => 'November', 'October' => 'September', 'September' => 'September', 'August' => 'July', 'July' => 'July', 'June' => 'May', 'May' => 'May', 'April' => 'March', 'March' => 'March', 'February' => 'January', 'January' => 'January');
        $carComIds = array();
        foreach ($modelImport as $item) {
            $carComIds[$item->nazwa] = $item->id;
        }
        foreach ($modelImport as $item) {
            $monthYear = explode(' ', $item->nazwa);
            $carComIds[$monthYear[0] . ' ' . $monthYear[1]] = $carComIds[$comMonths[$monthYear[0]] . ' ' . $monthYear[1]];
        }
        $this->render('//mobile/archive', array('modelImport' => $modelImport, 'carComIds' => $carComIds));
    }

    public function actionUsedCarsArchive()
    {
        QDinkey::checkDinkeyAccess();
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
            $this->render('//mobile/usedCarGuide', array(
                'model' => $model,
            ));
        } else {
            $this->redirect(array('/site/expired'));
            exit;
        }
    }

    public function actionUsedPassengerComercialArchive()
    {
        //year-month after model box is commented
        $arch_year = 125;

        QDinkey::checkDinkeyAccess();
        if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS) && Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_CARS)) {
            $availablePages = array('cars', 'commercial');
            $page = (isset($_GET['page']) && !empty($_GET['page']) && in_array($_GET['page'], $availablePages)) ? $_GET['page'] : 'cars';
            $arch = ($page == 'commercial') ? $_GET['com_arch'] : $_GET['arch'];

            $SHOW_CODE_COLUMN = Yii::app()->params['used_car_com_code_column_visibility'];

            $carsVisibleLink = Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_CARS);
            $commVisibleLink = Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_COMMERCIAL);

            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $arch);
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']); //'id=?',array($_GET['make'])
                $model = ($page == 'cars') ? UsedCars::model()->with('idImport')->find($criteria) : UsedComCars::model()->with('idImport')->find($criteria);
            } else {
                $model = ($page == 'cars') ? UsedCars::model()->with('idImport')->findAll($criteria) : UsedComCars::model()->with('idImport')->findAll($criteria);
            }

            //-----------------------
            $criteria = new CDbCriteria;
            $criteria->order = '`name`';
            $criteria->condition = 'id_import=:importId';
            if (isset($_GET['make']) && $_GET['make'] != '') {
                $tableTitle = $model['idImport']['nazwa'];
                $importId = $model['id_import'];
                $criteria->params = array(':importId' => $model['id_import']);
            } else {
                $tableTitle = $model[0]['idImport']['nazwa'];
                $importId = $model[0]['id_import'];
                $criteria->params = array(':importId' => $model[0]['id_import']);
            }
            $allCars = ($page == 'cars') ? UsedCars::model()->findAll($criteria) : UsedComCars::model()->findAll($criteria);

            if (!isset($_GET['make'])) {
                $headerTitle = $allCars[0]['name'];
            }

            $range = null;
            $usedCarsRanges = ($page == 'cars') ? UsedCars::usedCarsRanges($importId) : UsedCommsRanges::getUsedCommsRanges($importId);
            if (!empty($_GET['rangecode'])) {
                $range = $_GET['rangecode'];
            }

            $makeData = $modalData = array();

            if (empty($usedCarsRanges)) {
                foreach ($allCars as $item) {
                    $selected = (isset($_GET['make']) && $_GET['make'] == $item['id']) ? ' selected' : '';
                    $makeData[$item['id']] = '<option value="' . $item['id'] . '"' . $selected . '>' . $item['name'] . '</option>';
                    if (isset($_GET['make']) && $_GET['make'] == $item['id']) $headerTitle = $item['name'];
                }
            } else {
                foreach ($allCars as $startIndex => $row) {

                    //display name of manuafacturer
                    $manufacturerName = str_replace(' ', '_', $row['name']);
                    if ($manufacturerName == 'UCarsLinks' || $manufacturerName == 'UComsLinks') continue;
                    $selected = (isset($_GET['make']) && $_GET['make'] == $row['id']) ? ' selected' : '';

                    $makeData[$row['id']] = '<option value="' . $row['id'] . '"' . $selected . '>' . $row['name'] . '</option>';
                    if (isset($_GET['make']) && $_GET['make'] == $row['id']) $headerTitle = $row['name'];

                    if (!empty($manufacturerName) && !in_array($manufacturerName, array('UCarsLinks', 'UComsLinks')) && $selected) {
                        foreach ($usedCarsRanges[$manufacturerName] as $range_name => $range_val) {
                            $selected = ($range_val == $range) ? ' selected' : '';
                            $modalData[urlencode((string)$range_val)] = '<option value="' . urlencode((string)$range_val) . '"' . $selected . '>' . $range_name . '</option>';
                        }
                    }
                }

                if (!$modalData) {
                    foreach ($allCars as $startIndex => $row) {
                        //display name of manuafacturer
                        $manufacturerName = str_replace(' ', '_', $row['name']);
                        if ($manufacturerName == 'UCarsLinks' || $manufacturerName == 'UComsLinks') continue;

                        foreach ($usedCarsRanges[$manufacturerName] as $range_name => $range_val) {
                            $selected = ($range_val == $range) ? ' selected' : '';
                            $modalData[urlencode((string)$range_val)] = '<option value="' . urlencode((string)$range_val) . '"' . $selected . '>' . $range_name . '</option>';
                        }
                        break;
                    }
                }
            }

            if ($modalData && !$range) {
                $range = reset(array_keys($modalData));
            }

            $pageTemplate = ($page == 'cars') ? 'usedCarGuideList' : 'usedComGuideList';

            $this->render('//mobile/' . $pageTemplate, array(
                'carsVisibleLink' => $carsVisibleLink,
                'commVisibleLink' => $commVisibleLink,
                'SHOW_CODE_COLUMN' => $SHOW_CODE_COLUMN,
                'headerTitle' => $headerTitle,
                'tableTitle' => $tableTitle,
                'makeData' => $makeData,
                'modalData' => $modalData,
                'allCars' => $allCars,
                'range' => $range,
                'page' => $page,
                'model' => $model,
                'arch' => $_GET['arch'],
                'com_arch' => $_GET['com_arch'],
                'arch_year' =>  $arch_year
            ));
        } else {
            $this->redirect(array('/site/expired'));
            exit;
        }
    }

    public function actionUsedCarsIFrame()
    {
        QDinkey::checkDinkeyAccess();

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
                $this->render('//mobile/usedCarGuide', array(
                    'model' => $model,
                    'headerTitle' => $headerTitle
                ));
            } else {
                if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
                    echo '<script>window.top.location.href = "http://mtp.ie/license/";</script>';
                } else {
                    echo '<script>window.top.location.href = "' . Yii::app()->params['main_url'] . 'license/";</script>';
                }

                exit;
            }
        } else {
            throw new CHttpException(400, 'Used cars are temporarily unavailable.');
        }
    }

    public function actionUsedCommercialIFrame()
    {
        QDinkey::checkDinkeyAccess();
        //$this->layout = Controller::getLayoutDevice();
        // $this->layout = '//layouts/iframe';
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
                $this->render('//mobile/usedComGuide', array(
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
    public function actionAjaxCount()
    {
        if (!empty($_POST)) {
            $this->renderPartial('//mobile/_ajaxAdjustedValue', UsedCars::odometerCalculation($_POST));
        }
    }

    public function actionArchiveRegLookupListIFrame()
    {
        $startDate = Uzytkownik::getCarsLicenseStartDate();
        $archiveBeginDate = $startDate;
        $format = "Y-m-d";
        $date1  = DateTime::createFromFormat($format, $startDate);
        $date2  = DateTime::createFromFormat($format, "2016-09-01");
        if ($date2 > $date1) {
            $archiveBeginDate = date($format, strtotime("2016-09-01"));
        }
        //echo 'date from:'.$archiveBeginDate;
        $modelImport = Import::model()->with('usedComCarsCount')->findAll(array(
            'order' => '`t`.`id` DESC',
            'condition' => 't.data>date(:x)',
            'params' => array(':x' => $archiveBeginDate)
        ));
        $this->render('//mobile/archiveRegLookupList', array('modelImport' => $modelImport));
    }

    public function actionUsedCarsArchiveRegLookup()
    {
        $this->render('//mobile/usedCarsByRegLookup', array('hideHeader' => false));
    }

    public function actionUsedComCarsArchiveRegLookup()
    {
        $this->render('//mobile/usedCommercialByRegLookup', array('hideHeader' => false));
    }

    public function actionUsedComCarsArchive()
    {
        QDinkey::checkDinkeyAccess();
        if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL) && Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_COMMERCIAL)) {
            $criteria = new CDbCriteria;
            $criteria->condition = 't.id_import=:id_import';
            $criteria->params = array(':id_import' => $_GET['arch']);

            if (isset($_GET['make']) && $_GET['make'] != '') {
                $criteria->condition = 't.id=:id';
                $criteria->params = array(':id' => $_GET['make']); //'id=?',array($_GET['make'])            
                $model = UsedComCars::model()->with('idImport')->find($criteria);
            } else {
                $model = UsedComCars::model()->with('idImport')->findAll($criteria);
            }
            $this->render('//mobile/usedComGuide', array(
                'model' => $model,
            ));
        } else {
            $this->redirect(array('/site/expired'));
            exit;
        }
    }

    //new route
    public function actionNewPrices_old_bk()
    {
        $this->render('//mobile/newPrices', array());
    }

    public function actionNewPrices()
    {
        $backUrl = Yii::app()->createAbsoluteUrl('/') . '?' . Yii::app()->getRequest()->queryString;
        $availablePages = array('cars', 'commercial');
        $effectiveData = $filesPath = $seriesData = $modelsData = array();
        $page = (isset($_GET['page']) && !empty($_GET['page']) && in_array($_GET['page'], $availablePages)) ? $_GET['page'] : 'cars';
        $pathToFiles = './data/' . $page . '/';
        $mainCarsFilePath = $pathToFiles . ($page == 'cars' ? 'nCarsRanges.xml' : 'nComsRanges.xml');
        //new code/condition for licence check for both types
        $PARAM_USED_CARS = ($page == 'cars') ? Uzytkownik::PARAM_USED_CARS : Uzytkownik::PARAM_USED_COMMERCIAL;

        if (Uzytkownik::model()->checkExpirationDate($PARAM_USED_CARS) && Uzytkownik::model()->checkProductIsOn($PARAM_USED_CARS)) {
            /* 
        * Get all makes files path [ 
        */
            $allCarsFilePath = file_get_contents($pathToFiles . '/man.xml');
            $allCarsFilePath = htmlspecialchars($allCarsFilePath);
            $makes = simplexml_load_string(html_entity_decode($allCarsFilePath), 'SimpleXMLElement', LIBXML_NOCDATA);

            foreach ($makes as $make) {
                $dist = (string)$make['distributor'];
                $effective = (string)$make['effective'];
                $file = (string)$make['file'];
                $distCode = str_replace(' ', '_', $dist);
                $filesPath[$distCode] = urlencode($file);
                $effectiveData[$distCode] = ' ( ' . $effective . ' )';
                $makeNames[$filesPath[$distCode]] = $dist . ' ( Effective ' . $effective . ' )';
            }

            $selectedMake = (
                isset($_GET['make']) &&
                $_GET['make'] != ''
            ) ? $_GET['make'] : false;

            $selectedSeries = (
                isset($_GET['series']) &&
                $_GET['series'] != ''
            ) ? $_GET['series'] : false;

            $selectedModel = (
                isset($_GET['model']) &&
                $_GET['model'] != ''
            ) ? $_GET['model'] : false;

            /*
        * ]
        */

            /* 
        * Get all makes with 
        * series and model [ 
        */
            $allCarsMakeModels = file_get_contents($mainCarsFilePath);
            $allCarsMakeModels = htmlspecialchars($allCarsMakeModels);
            $carsMakeModels = simplexml_load_string(html_entity_decode($allCarsMakeModels), 'SimpleXMLElement', LIBXML_NOCDATA);

            $maker = "";
            if ($selectedMake) {
                foreach ($carsMakeModels as $make) {
                    $manufacturer = trim((string)$make['manufacturer']);
                    $distCode = str_replace(' ', '_', $manufacturer);
                    if ($distCode == $selectedMake) {
                        $maker = $selectedMake;
                    }
                }
            }

            if ($maker != $selectedMake) {
                $selectedMake = '';
            }

            $modelName = $seriesName = '';
            foreach ($carsMakeModels as $make) {
                $manufacturer = trim((string)$make['manufacturer']);
                $distCode = str_replace(' ', '_', $manufacturer);

                if (!$selectedMake) $selectedMake = $distCode;

                $makeOptions[$distCode] = '<option value="' . $distCode . '" data-file="' . $filesPath[$distCode] . '"' . (($selectedMake == $distCode) ? ' selected' : '') . '>' . $manufacturer  . $effectiveData[$distCode] . '</option>';

                if ($selectedMake != $distCode) {
                    continue;
                }

                $series = trim((string)$make['series']);
                $seriesCode = str_replace(' ', '_', $series);

                $model = trim((string)$make['rangedesc']);
                $modelCode = $rangecode = trim((string)$make['rangecode']);

                if ($seriesCode) {
                    if (!$selectedSeries) $selectedSeries = $seriesCode;
                    if ($selectedSeries == $seriesCode) $seriesName = $series;
                    $seriesData[$seriesCode] = '<option value="' . $seriesCode . '"' . (($selectedSeries == $seriesCode) ? ' selected' : '') . '>' . $series . '</option>';
                    if ($selectedSeries != $seriesCode) {
                        continue;
                    }
                }

                if (!$selectedModel) $selectedModel = $modelCode;
                if ($selectedModel == $modelCode) $modelName = $model;
                $modelsData[$modelCode] = '<option value="' . $modelCode . '"' . (($selectedModel == $modelCode) ? ' selected' : '') . '>' . $model . '</option>';
            }

            ksort($makeOptions);
            $makeOptions = implode('', $makeOptions);
            $seriesOptions = ($seriesData) ? implode('', $seriesData) : '';
            $modelOptions = implode('', $modelsData);
            /* 
        * ]
        */

            /*
        * Html [ 
        */
            $tableHtml = $this->getNewPricesList($page, $filesPath[$selectedMake], $selectedModel, $modelName, $makeNames, $seriesName, $backUrl);
            /*
        * ]
        */

            $this->render('//mobile/newPricesList', array('page' => $page, 'makeOptions' => $makeOptions, 'seriesOptions' => $seriesOptions, 'modelOptions' => $modelOptions, 'tableHtml' => $tableHtml));
        } else {
            $msgg = 'Oops! Seems that your licence for the used cars expired. <br>'
                . 'Please contact our office <br>on<br><a href="tel:018775460" class="licence_link">01-8775460</a><br>or<br>'
                . '<a href="mailto:info@mtp.ie" class="licence_link">info@mtp.ie</a><br>'
                . 'so we can get you motoring again.';

            if (!Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL)) {
                $msgg = 'Oops! Seems that your licence for the commercial vehicles expired. <br>'
                    . 'Please contact our office <br>on<br><a href="tel:018775460">01-8775460</a><br>or<br>'
                    . '<a href="mailto:info@mtp.ie">info@mtp.ie</a><br>'
                    . 'so we can get you motoring again.';
            }

            if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL) && Uzytkownik::model()->checkProductIsOn(Uzytkownik::PARAM_USED_COMMERCIAL)) {
                $msgg .= '<br/><br/><a href="' . Yii::app()->createUrl('mobile/archive&page=commercial') . '" class="licence_link">Click here for <span>Commercial New Prices</span></a>';
            }
            $this->render('//mobile/gMessage', array(
                'msg' => $msgg,
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));

            exit;
        }
    }

    private function getNewPricesList($page, $postedMakeFile, $postedModel, $postedModelName, $makeNames, $seriesName, $backUrl)
    {
        if (!$postedMakeFile || !$postedModel) {
            return '';
        }

        $postedMakeFile = urldecode($postedMakeFile);

        $variantData = array();

        $carsPdf = ($page == 'cars') ? 'newPricesCarsPdf' : 'NewPricesCommsPdf';
        $pathToFiles = './data/' . $page . '/';

        if (!file_exists($pathToFiles . $postedMakeFile)) return '';
        /* 
        * Get all variants with first
        * make, series and model [ 
        */
        $variantsXmlData = file_get_contents($pathToFiles . $postedMakeFile);
        $variants = simplexml_load_string(html_entity_decode(htmlspecialchars($variantsXmlData)), 'SimpleXMLElement', LIBXML_NOCDATA);

        foreach ($variants as $variant) {
            $currentRangeCode = (string)$variant['rangecode'];
            if ($postedModel != $currentRangeCode) continue;

            $dynamicData = array();
            foreach ($variant->attributes() as $keyEle => $valEle) {
                $dynamicData[(string)$keyEle] = (string)$valEle;
            }
            $variantData[] = $dynamicData;
        }
        /* 
        * ]
        */

        $pdfParams = array('make' => urlencode($postedMakeFile), 'rangecode' => $postedModel, 'rangename' => $postedModelName, 'backurl' => $backUrl);
        if ($seriesName) $pdfParams['seriesname'] = $seriesName;
        $html = '<div id="tab1" class="table-list tab tab1">
                    <div class="brand_title">
                        <div id="myDiv" class="pdf_export"><a target="_blank" href="' . Yii::app()->createUrl('//mobile/' . $carsPdf, $pdfParams) . '&page=' . $page . '"><img src="' . Yii::app()->params['mobile_url'] . 'images/pdf.png"
                            style="width:28px; height:28px;" alt="[pdf]"></a></div><br/>
                        <span id="titleFieldFromXml">' . $makeNames[urlencode($postedMakeFile)] . '</span>
                        <p class="desktop-display">Please click on the variant to see the corresponding tax information.</p>
                        ' . ($page == 'commercial' ? '<p>For VRT Category B vehicles, the motor tax relates to vehicles used for commercial purposes.</p>' : '') . '
                        <p class="mobile-landscape-display">Please <strong>select the variant</strong> to see the corresponding tax information.</p>
                        <p class="mobile-display"><img src="./images/rotate.png" alt=""  class="rotate_icn"/>Please rotate your device to see all details.</p>
                    </div>
                <!--/div-->
                <div class="table-wrapper">
                    <table class="items">
                        <thead id="headItems">
                            <tr>
                                <th scope="col" class="col-md-2">Model</th>
                                <th scope="col" class="mobile-show col-md-5">Variant</th>
                                ' . ($page == 'cars' ? '<th scope="col" class="drs-text text-right col-md-1">Drs</th>' : '') . '
                                <th scope="col" class="text-right body col-md-3">Body</th>
                                <th scope="col" class="text-right col-md-1">Fuel</th>
                                <th scope="col" class="text-center col-md-2">Transmission</th>
                                <th scope="col" class="col-md-1">CC</th>
                                ' . ($page == 'commercial' ? '<th scope="col" class="gvw-text text-right col-md-1">GVW</th>' : '<th scope="col" class="bhp-text col-md-1">Bhp</th>') . '
                                <th scope="col" class="col-md-1">Co2</th>
                                <th scope="col" class="mobile-show col-md-2 text-right">Retail (€)</th>
                            </tr>
                            </thead>
                            <tbody>';
        if ($variantData) {
            foreach ($variantData as $variant) {
                $html .= '<tr>
                            <td class="col-md-2" data-label="Model">' . ($variant['rangedesc'] ? $variant['rangedesc'] : 'NA') . '</td>
                            <td data-label="Variant" class="mobile-show col-md-5">
                                <a href="javascript:void(0);" class="ui-link open-varnt" onclick="openDetails( \'' . ($variant['vrt'] ? $variant['vrt'] : 'NA') . '\', \'' . ($variant['band'] ? $variant['band'] : 'NA') . '\', \'' . ((isset($variant['cat']) && $variant['cat']) ? $variant['cat'] : 'NA') . '\', \'' . ($variant['tax'] ? '€ ' . $variant['tax'] : 'NA') . '\', \'' . $page . '\');">' . ($variant['variant'] ? $variant['variant'] : 'NA') . '</a>
                            </td>

                            ' . ($page == 'cars' ? '<td data-label="Drs" class="drs-text text-right col-md-1">' . ($variant['doors'] ? $variant['doors'] : 'NA') . '</td>' : '') . '

                            <td data-label="Body" class="body text-right  col-md-3" >' . ($variant['body'] ? $variant['body'] : 'NA') . '</td>
                            <td data-label="Fuel" class="text-right col-md-1">' . ($variant['fuel'] ? $variant['fuel'] : 'NA') . '</td>
                            <td data-label="Transmission" class="text-center col-md-2">' . ($variant['transmission'] ? $variant['transmission'] : 'NA') . '</td>
                            <td data-label="CC" class="col-md-1">' . ($variant['cc'] ? $variant['cc'] : 'NA') . '</td>
							' . ($page == 'commercial' ? '<td data-label="GVWkg" class="gvw-text col-md-1 text-right">' . ($variant['gvw'] ? $variant['gvw'] : 'NA') . '</td>' : ' <td data-label="BHP" class="bhp-text col-md-1" >' . ($variant['bhp'] ? $variant['bhp'] : 'NA') . '</td> ') . '
                            <td data-label="Co2" class="col-md-1">' . ($variant['co2'] ? $variant['co2'] : 'NA') . '</td>
                            <td class="mobile-show col-md-2 text-right" data-label="Retail €">€ ' . ($variant['retail'] ? $variant['retail'] : 'NA') . '</td>
                        </tr>';
            }
        } else {
            $html .= '<tr>
                        <td colspan="10" style="text-align:center;">Variants not found!!</td>
                    </tr>';
        }
        $html .= '</tbody>
                </table>
				<table id="header-fixed"></table>
            </div>
        </div>';

        return $html;
    }


    /*Lates methods for Ajax call on Make and model page*/
    public function actionLoadFuel()
    {
        $data = Mobile::getFuelOptions($_POST['page_model'], (int)$_POST['mark_id'], $_POST['range_id']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');

        echo "<option value=''>Select Fuel</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadTransmission()
    {
        $data = Mobile::getTransmissionOptions($_POST['page_model'], (int)$_POST['mark_id'], $_POST['range_id'], $_POST['fuel_type'], $_POST['year']);
        $listData = $data; //CHtml::listData($data,'id','vehiclaBadgeAndYear');
        echo "<option value=''>Select Transmission</option>";
        foreach ($listData as $value => $cars_model)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($cars_model), true);
    }

    public function actionLoadModelType()
    {
        $modeltext = explode('<-->', $_POST['model_txt']);
        $badgetype = $modeltext[1];
        $carmodel =  $modeltext[0];
        //echo $carmodel." ".$badgetype;die("==");
        $data = Mobile::getModelsByRangeForTheBand($_POST['page_model'], (int) $_POST['mark_id'], $_POST['range_id'], $_POST['fuel_type'], $_POST['transmission'], $badgetype, $carmodel);
        // $data = Mobile::getModelsByRangeForTheBand($_POST['page_model'], (int) $_POST['mark_id'], $_POST['range_id'], $_POST['fuel_type'], $_POST['transmission']);
        //echo "<pre>";print_r($data); die("====");
        if (Yii::app()->params['website_type'] == Yii::app()->params['website']['API']) {
            $listData = CHtml::listData($data, 'id', 'vehiclaBadgeAndYear');
            echo "<option value=''>Select Model</option>";
        } else {
            $data = Mobile::filterForChosenYear($data, $_POST['year']);
            // $listData = array_unique(CHtml::listData($data,'badgetype','vehicle'));
            $listData = array_unique(CHtml::listData($data, 'codenumber', function ($data) {
                return $data->vehicle . "<->" . $data->badgetype . "<->" . $data->body;
            }));
            // $listData = array_unique(CHtml::listData($data,'badgetype',function($data){return $data->vehicle."<->".$data->codenumber;}));
            echo "<option value=''>Select Model with Type</option>";
        }

        foreach ($listData as $value => $cars_model) {
            /* To add code number for testing */
            $carModelValue = explode("<->", $cars_model);
            $vehicle = $carModelValue[0];
            $badgetype = $carModelValue[1];
            $body = $carModelValue[2];
            $codenumber = $value;
            $cars_model = str_replace('<->', " - ", $cars_model);

            if (isset(Yii::app()->params['app_mode']) && Yii::app()->params['app_mode'] != 'development') {
                echo CHtml::tag('option', array('value' => $vehicle . '<-->' . $badgetype), CHtml::encode($vehicle . ' - ' . $badgetype), true);
            } else {
                echo CHtml::tag('option', array('value' => $vehicle . '<-->' . $badgetype), CHtml::encode($vehicle . ' - ' . $codenumber . ' - ' . $badgetype), true);
            }
        }
    }

    // public function actionLoadBodyDoor()
    // {
    //    ###### production code
    //    // $modeltext = explode('<-->', $_POST['model_txt']);
    //     // $badgetype = $modeltext[1];
    //     // $carmodel = $modeltext[0];

    //     // $data = Mobile::getBodyDoors ($_POST['page_model'], (int)$_POST['mark_id'], $_POST['range_id'], $carmodel, $_POST['fuel_type'], $_POST['transmission'], $badgetype);
    //     $data = Mobile::getBodyDoorsWithoutModel ($_POST['page_model'], (int)$_POST['mark_id'], $_POST['range_id'], $_POST['fuel_type'], $_POST['transmission']);
    //     ###### prod code ends

    //     $data = Mobile::getBodyDoorsWithoutModel ($_POST['page_model'], (int)$_POST['mark_id'], $_POST['range_id'], $_POST['fuel_type'], $_POST['transmission'], $_POST['year']);

    //     $listData = $data;//CHtml::listData($data,'id','vehiclaBadgeAndYear');

    //     $type = "passenger";
    //     if(isset($_POST['type'])  &&  $_POST['type'] == "commercial")
    //     {
    //         $type = "commercial";
    //         echo "<option value=''>Select Body </option>";
    //     }else{
    //         echo "<option value=''>Select Body with Doors </option>";
    //     }
    //     $doorsSuffix = ($type == "passenger") ? " doors" : "";
    //     $conCheck = [];
    //     foreach($listData as $index=>$car_data) {
    //         foreach($car_data as $value=>$cars_model) {
    //             if(isset($_POST['type'])  &&  $_POST['type'] == "commercial")
    //             {
    //                 // if(!empty($value)){
    //                     echo CHtml::tag('option', array('value'=>$cars_model . '<-->' . $value),CHtml::encode($cars_model . ' ' . $doors),true);
    //                 // }
    //             }else{
    //                 $doors = ($value) ? $value." doors" : "";
    //                 echo CHtml::tag('option', array('value'=>$cars_model . '<-->' . $value),CHtml::encode($cars_model . ' ' . $doors),true);   
    //             }

    //         }
    //     } 

    //     #### prod code
    //     /* $doorsSuffix = $type == "passenger" ? " doors" : "";
    //     foreach($listData as $index=>$car_data) {
    //         foreach($car_data as $value=>$cars_model) {
    //         $doors = ($value) ? $value." doors" : "";
    //         echo CHtml::tag('option', array('value'=>$cars_model . '<-->' . $value),CHtml::encode($cars_model . ' ' . $doors),true);   
    //     }
    //     } */
    // }

    public function actionLoadBodyDoor()
    {
        // Assuming $data is already fetched as before
        $data = Mobile::getBodyDoorsWithoutModel($_POST['page_model'], (int)$_POST['mark_id'], $_POST['range_id'], $_POST['fuel_type'], $_POST['transmission'], $_POST['year']);
        $listData = $data;
        //echo"<pre>";print_r($listData); die("==");
        $type = "passenger";
        if (isset($_POST['type']) && $_POST['type'] == "commercial") {
            $type = "commercial";
            echo "<option value=''>Select Body </option>";
        } else {
            echo "<option value=''>Select Body with Doors </option>";
        }

        /* foreach($listData as $cars_model) {
            // Generate the options directly since $cars_model is the value you want to display
            if(isset($_POST['type']) && $_POST['type'] == "commercial") {
                echo CHtml::tag('option', array('value' => $cars_model), CHtml::encode($cars_model), true);
            } else {
                // For non-commercial, you can add 'doors' suffix if needed
                echo CHtml::tag('option', array('value' => $cars_model), CHtml::encode($cars_model), true);
            }
        } */
        foreach ($listData as $index => $car_data) {
            foreach ($car_data as $key => $cars_model) {
                if (isset($_POST['type'])  &&  $_POST['type'] == "commercial") {
                    // if(!empty($value)){
                    echo CHtml::tag('option', array('value' => $cars_model . '<-->' . $key), CHtml::encode($cars_model . ' ' . $doors), true);
                    // }
                } else {
                    $doors = ($key) ? $key . " doors" : "";
                    echo CHtml::tag('option', array('value' => $cars_model . '<-->' . $key), CHtml::encode($cars_model . ' ' . $doors), true);
                }
            }
        }
    }

    public function actioncarpdf()
    {
        if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS)) {
            // echo "<iframe src='https://online.fliphtml5.com/dvqmm/ckvl/' width='100%' style='height:100%'></iframe>";
            // echo "<iframe src='https://fliphtml5.com/check/dvqmm/tsof/index.html#p=1' width='100%' style='height:100%'></iframe>";31-aug-2020
            echo "<iframe src='https://online.fliphtml5.com/dvqmm/gurw/' width='100%' style='height:100%'></iframe>";
            // $this->render('//mobile/gIframe',array(
            //     'link'=>'https://fliphtml5.com/check/dvqmm/tsof/index.html#p=1',
            //     'backUrl'=>Yii::app()->createUrl('mobile/gSelectReg')
            // ));
        } else {
            $this->render('//mobile/gMessage', array(
                'msg' => 'Oops! Seems that your licence for the used cars expired. <br>'
                    . 'Please contact our office <br>on<br><a href="tel:018775460">01-8775460</a><br>or<br>'
                    . '<a href="mailto:info@mtp.ie">info@mtp.ie</a><br>'
                    . 'so we can get you motoring again.',
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));
        }
    }

    public function actioncommpdf()
    {
        if (Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL)) {

            echo "<iframe src='https://online.fliphtml5.com/dvqmm/lntb/' width='100%' style='height:100%'></iframe>";
        } else {
            // $this->redirect(array('/site/expired'));
            // exit;
            $this->render('//mobile/gMessage', array(
                'msg' => 'Oops! Seems that your licence for the commercial vehicles expired. <br>'
                    . 'Please contact our office <br>on<br><a href="tel:018775460" class="licence_link">01-8775460</a><br>or<br>'
                    . '<a href="mailto:info@mtp.ie" class="licence_link">info@mtp.ie</a><br>'
                    . 'so we can get you motoring again.',
                'backUrl' => Yii::app()->createUrl('mobile/gSelectReg')
            ));
        }
    }

    public function actionGeneratePdf()
    {

        $production         = $this->production;
        $userYear = '';
        $userKms = '';
        $userValue = '';
        $cartype = "passenger";
        $archMonth  = "";
        $selectedModel = self::$PARAM_USED_CARS_MODEL;
        if (isset($_GET['m']) && $_GET['m'] != '' && isset($_GET['cn']) && $_GET['cn'] != '' && $_GET['reg'] != '') {
            $_GET['reg'] = str_replace(' ', '', $_GET['reg']);
            $vehicleData = array();
            $vehicleData = RegistrationService::getRiDataResults($_GET['cn']);
            if (!empty($vehicleData['errors'])) {
                return false;
                exit;
            }
            if (strtoupper($_GET['reg']) == "151D18418" || strtolower($_GET['reg']) == "151d18418") {
                $vehicleData['code'] = "6802400350";
            }
            $archcheck = isset($_GET['imp']) ? $_GET['imp'] : '';
            $returnedCodeNumber = $vehicleData['code'];
            $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber, $archcheck);
            if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
                $model = RegistrationService::getCarCommModel("UsedCarsModel", $returnedCodeNumber, $archcheck);
                $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel($selectedModel, $model, $archcheck);
                $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel($selectedModel, $model, $archcheck);
                $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            }
            $vehicleYear = $vehicleData['year'];
            $calculatedMain_coreWithAssociatedCars = $calculatedRest_coreWithAssociatedCars = array();
            $checkedAllCheckboxes = null;
            $grpCustomValeResult = null;
            $calculatedCustomValue  = null;

            $archiveIds = Import::model()->with('usedComCarsCount')->findAll(array(
                'order' => '`t`.`id` DESC'
            ));
            $arch = ($_GET['imp']) ? $_GET['imp'] : '';
            foreach ($archiveIds as $item) {
                if ($item->id == $arch) {
                    $archMonth  =   $item->nazwa;
                }
            }

            $regPageContent = array(
                'vehicle' => array_merge($vehicleData, $vehicleKms),
                'model' => $model,
                'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                'calculatedMain_coreWithAssociatedCars' => $calculatedMain_coreWithAssociatedCars,
                'calculatedRest_coreWithAssociatedCars' => $calculatedRest_coreWithAssociatedCars,
                'vehicleYear' => $vehicleYear,
                'checkedAllCheckboxes' => $checkedAllCheckboxes,
                'grpCustomValeResult' => $grpCustomValeResult,
                'calculatedCustomValue' => $calculatedCustomValue,
                'type' => $selectedModel,
                'regNumber' => $vehicleData['registerVehicleNumber'],
                'archMonth' => $archMonth,
                'arch'    =>  $arch,
                'archcheck' =>  $archcheck,
                'cartype'   =>  $cartype
            );
            $regPageTableData = $this->getRegResultData($regPageContent);

            $urlCodeData    =   array(
                'arch' => $_SESSION['arch'],
                'VehicleRegNumber' => $_SESSION['VehicleRegNumber'],
                'usedCarComModel' => $_SESSION['usedCarComModel'],
                'importId' => $_SESSION['importId'], // 'useAjax'=>$_SESSION['useAjax']
                'useAjax' => $_SESSION['useAjax'],
                'selrow' => isset($_SESSION['selrow']) ? $_SESSION['selrow'] : '',
                'showcont' => isset($_SESSION['showcont']) ? $_SESSION['showcont'] : ''
            );

            $url = array('backUrl' => Yii::app()->createAbsoluteUrl('mobile/gSelectReg', $urlCodeData));
        }

        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/mobile/generatePdf.php'); // inaczej nie da sie otworzyc pliku
        $this->render('generatePdf', array(
            'model' => $model,
            'userYear' => $vehicleYear,
            'userKms' => $userKms,
            'userValue' => $userValue,
            'regPageContent' => $regPageContent,
            'regPageTableData' => $regPageTableData,
            'url' => $url
        ));
    }

    public function indicator24Check($returnedCodeNumber, $archcheck = null)
    {
        $indicator24 = substr($returnedCodeNumber, 3, 2);
        $originalCode = $returnedCodeNumber;

        // Check if the RI-returned code exists in database FIRST
        $existsInDb = RegistrationService::getCarCommModel("UsedCarsModel", $originalCode, $archcheck);
        if(empty($existsInDb)) {
            $existsInDb = RegistrationService::getCarCommModel("UsedComCarsModel", $originalCode, $archcheck);
        }

        // DEBUG LOG
        Yii::log('indicator24Check (Mobile): original='.$originalCode.' indicator24='.$indicator24.' existsInDb='.(!empty($existsInDb)?'YES':'NO'), CLogger::LEVEL_ERROR, 'application.registration');

        // Only apply link transformation if RI code exists in database
        // Link files are for variants, not for missing codes
        if(!empty($existsInDb) && $indicator24 != '24'){
            $linkedCode = XmlUcarsLinks::getLinkedCarCode($returnedCodeNumber);
            if(!empty($linkedCode)){
                Yii::log('indicator24Check (Mobile): Applying link UcarsLinks from '.$returnedCodeNumber.' to '.$linkedCode, CLogger::LEVEL_ERROR, 'application.registration');
                $returnedCodeNumber = $linkedCode;
            }else {
                $linkedCode = XmlUcommsLinks::getLinkedCarCode($returnedCodeNumber);
                if(!empty($linkedCode)){
                    Yii::log('indicator24Check (Mobile): Applying link UcommsLinks from '.$returnedCodeNumber.' to '.$linkedCode, CLogger::LEVEL_ERROR, 'application.registration');
                    $returnedCodeNumber = $linkedCode;
                }
            }
        } else if(empty($existsInDb)) {
            Yii::log('indicator24Check (Mobile): Code does NOT exist in database, returning original code unchanged: '.$originalCode, CLogger::LEVEL_ERROR, 'application.registration');
        }

        return $returnedCodeNumber;
    }

    public function getRegResultData($data)
    {
        $vehicle        = $data['vehicle'];
        $cartype        = $data['cartype'];
        $selectedModel  = $data['type'];
        $carData        = RegistrationService::getCarDetail($data);
        $maker      = isset($data['make']) ? strtolower($data['make']) : '';
        $verisktag  = isset($data['vehicle']['model']) ? strtolower($data['vehicle']['model']) : '';
        $bodytags   = "";
        $skipRow = false;
        if ($verisktag) {
            if (strpos(strtolower($verisktag), 'grand') !== false) {
                if (isset($maker) && strpos(strtolower($maker), 'renault') !== false) {
                    $skipRow  = true;
                }
            }
        }

        $car        = $carData['car'];
        $skip       = $carData['skip'];
        $carModel = 'UsedCarsModel';
        if ($data['cartype'] == 'commercial') {
            $carModel = 'UsedComCarsModel';
        }
        if ($vehicle['kmsForYear']) {
            $model = RegistrationService::getCarCommModel($carModel, $car['codenumber'], $data['archcheck']);
            $vehicle['kmsForYear'] = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicle['year'], $model))['kmsForYear'];
        }

        $retData = [];
        $retData['Year'] = '';
        if (is_numeric($vehicle['year'])) {
            if (strlen((string)$vehicle['year']) > 2) {
                $retData['Year'] = Mobile::displayFullYearForRegYear($vehicle['year']) . ' (' . $vehicle['year'] . ')';
            } else {
                $retData['Year'] = Mobile::displayFullYearForRegYear($vehicle['year']) . ' <br/>'; // convert
            }
        }

        $carTooOldOrYoung = false;
        $skip = 0;

        if (!RegistrationService::isValidYear($vehicle, $data['vehicle']['registerVehicleNumber'])) {
            $carTooOldOrYoung = true;
            $skip = 3;
        } else {
            if (empty($vehicle['code'])) {
                $skip = 5;
            }
        }

        $retData['make'] = isset($vehicle['make']) ? $vehicle['make'] : '';
        $retData['model'] = isset($vehicle['model']) ? $vehicle['model'] : '';
        $retData['colour'] = isset($vehicle['colour']) ? $vehicle['colour'] : '';
        $retData['engine'] = isset($vehicle['engine']) ? $vehicle['engine'] : '';
        $retData['fuel'] = isset($vehicle['fuel']) ? $vehicle['fuel'] : '';
        $retData['transmission'] = isset($vehicle['transmission']) ? $vehicle['transmission'] : '';

        if (strpos(strtolower($vehicle['model']), 'golf') !== false && strpos(strtolower($vehicle['body']), 'estate') !== false) {
            $retData['body'] = 'ESTATE/HATCH';
        } else {
            $retData['body'] = isset($vehicle['body']) ? $vehicle['body'] : '';
        }

        if (strpos(strtolower($vehicle['model']), 'velar') !== false) {
            $skip = 4;
        }

        $RiRetrunedCode = null;
        if (!empty($vehicle['code'])) {
            $RiRetrunedCode = $vehicle['code'];
            $used_or_new = substr($vehicle['code'], 3, 2);
            if ($used_or_new == '12') {
                $skip = 4;
            }
        }

        if ($cartype == 'passenger') {
            // if( in_array($vehicle['body'], $this->commercialCarBodies) ){
            if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->commercialCarBodies))) {
                $skip = 6;
            }
        } else {
            // if( in_array($vehicle['body'], $this->passengerCarBodies) ){
            if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->passengerCarBodies))) {
                $skip = 3;
            }
        }

        //new shifted
        if ($skip != 6) {
            $retData['Co2'] = isset($vehicle['CO2']) ? $vehicle['CO2'] : '';
            $retData['roadTax'] = isset($vehicle['roadTax']) ? '€' . $vehicle['roadTax'] : '--';

            if (Yii::app()->params['is_test_version']) {
                if (!empty($vehicle['code'])) {
                    $retData['veriskCode'] = isset($vehicle['code']) ? $vehicle['code'] . '(verisk)' : '--';
                }
            } else {
                if (!empty($vehicle['code'])) {
                    $retData['veriskCode'] = '--';
                }
            }
        }
        //new shifted
        if ($skip == 0) {
        } else if ($skip == 3) {
            //outside of Valid years
            $retData['message'] = '--';
        } else if ($skip == 4) {
            //velar and "12" codes - car too new            
            $retData['message'] = '--';
        } elseif ($skipRow) {
            $retData['message'] = '--';
        } else {
            //skip = 5 as well
            $retData['message'] = '--';
        }

        if ($car) {
            if ($skip == 0) {
                $info = $car->getValueAndKmsForYear($vehicle['year']);
                $kms =  $vehicle['kmsForYear'];
                // if(!empty($_POST['userGuideKm'])){
                if (!empty($kms)) {
                    $import = Import::getLastImportData();

                    $input = array();
                    // $kms =  $_POST['userGuideKm']/1000;
                    $input['km'] = $kms;
                    $input['year'] = $vehicle['year'];
                    $input['fuel'] = $car['fuel'];
                    $input['guide'] = $info['value']; // ze znakiem euro
                    $input['guideKm'] = $info['kms']; // km z tabeli    
                    if ($imp['imp'] && $imp['imp'] != '') {
                        if ($imp['imp'] == $import->id) {
                            $input['import'] = $import->id;
                        } else {
                            $input['import'] = $imp['imp'];
                        }
                    } else {
                        $input['import'] = $import->id;
                    }

                    $input['codenumber'] = $car['codenumber'];
                    $input['carOrCom'] = 'UsedCarsModel';
                    $adjustedValueArray = UsedCars::odometerCalculation($input);

                    $adjustedValue = $adjustedValueArray['adjustedValue'];
                    if (Mobile::isNumber($adjustedValue)) {
                        $info['kms'] = $kms;
                        $info['value'] = $adjustedValue;
                    } else {
                        $retData['adjustedValue'] = $adjustedValue;
                    }
                }

                $kmsforthis = (Mobile::isNumber($info['value'])) ? '&euro;' . Mobile::displayValue($info['value']) : 'NA';
                $retData['GUIDEPrice'] = $kmsforthis;

                $retData['kmss'] = Mobile::displayKms($info['kms']) . " Kms";
            }
        } else {
            if (strtolower($vehicle['registerVehicleNumber']) != '201d19296' || strtoupper($vehicle['registerVehicleNumber']) != '201D19296') {
                $retData['message'] = "__";
            }
        }
        return $retData;
    }

    public function actionMakeModelGeneratePdf()
    {
        $production         = $this->production;
        $regPageTableData   = [];
        $archMonth          = '';
        if (
            isset($_GET['m']) && $_GET['m'] != ''
            && isset($_GET['cn']) && $_GET['cn'] != ''
            && isset($_GET['imp']) && $_GET['imp'] != ''
            && isset($_GET['pd']) && $_GET['pd'] != ''
        ) {
            $displayData = json_decode(base64_decode($_GET['pd']));
            $displayData = isset($displayData) && !empty($displayData) ? (array) $displayData : [];
            if (isset($displayData) && !empty($displayData)) {
                $archiveIds = Import::model()->with('usedComCarsCount')->findAll(array(
                    'order' => '`t`.`id` DESC'
                ));
                $arch = ($_GET['imp']) ? $_GET['imp'] : '';
                foreach ($archiveIds as $item) {
                    if ($item->id == $arch) {
                        $archMonth  =   $item->nazwa;
                    }
                }
                $displayData['archMonth'] = $archMonth;

                if (isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] == 'comm') {
                    $urlCodeData    =   array(
                        'com_vehicle_type' => $_SESSION['com_vehicle_type'],
                        'com_import_id' => $_SESSION['com_import_id'],
                        'com_year' => $_SESSION['com_year'],
                        'comms_mark_name' => $_SESSION['comms_mark_name'],
                        'comms_ranges' => $_SESSION['comms_ranges'],
                        'comms_fuel' => $_SESSION['comms_fuel'],
                        'comms_transmission' => $_SESSION['comms_transmission'],
                        'comms_body' => $_SESSION['comms_body'],
                        'comms_model' => $_SESSION['comms_model'],
                        'comms_userKms' => $_SESSION['comms_userKms'],
                    );

                    $displayData['backurl'] = Yii::app()->createAbsoluteUrl('mobile/gSelectMakeComm', $urlCodeData);
                } else {
                    $urlCodeData    =   array(
                        'vehicle_type' => $_SESSION['vehicle_type'],
                        'import_id' => $_SESSION['import_id'],
                        'year' => $_SESSION['year'],
                        'cars_mark_name' => $_SESSION['cars_mark_name'],
                        'cars_ranges' => $_SESSION['cars_ranges'],
                        'cars_fuel' => $_SESSION['cars_fuel'],
                        'cars_transmission' => $_SESSION['cars_transmission'],
                        'cars_body' => $_SESSION['cars_body'],
                        'cars_model' => $_SESSION['cars_model'],
                        'userKms' => $_SESSION['userKms'],
                    );
                    $displayData['backurl'] = Yii::app()->createAbsoluteUrl('mobile/gSelectMake', $urlCodeData);
                }

                $displayData['print'] = '<a href="javascript:void(0)" onClick="window.print()">Print</a>';
                $regPageTableData = $displayData;

                Yii::import('application.extensions.*');
                require_once('tcpdf/config/lang/eng.php');
                require_once('tcpdf/tcpdf.php');
                require_once('./protected/views/mobile/makeModelPdf.php'); // inaczej nie da sie otworzyc pliku

                $this->render('makeModelPdf', array('regPageTableData' => $regPageTableData, 'production' => $production));
            }
        } else {
            echo "<script>window.location = history.go(-1);</script>";
        }
    }

    /*
    include iframe code from here
    */
    public function actionGenerateIframePdf()
    {
        $this->layout = false;
        $filename = "/data/mtpintegration/dev/images/test.txt";
        if (touch($filename)) {
            echo $filename . " modification time has been changed to present time";
        } else {
            echo "Sorry, could not change modification time of " . $filename;
        }

        file_put_contents('test.pdf', $binary);
        die;
        // error_reporting(0);
        $userYear = '';
        $userKms = '';
        $userValue = '';
        $cartype = "passenger";
        $archMonth    = "";
        $selectedModel = self::$PARAM_USED_CARS_MODEL;
        $requestType = isset($_GET['type']) ? strtolower($_GET['type']) : 'web';

        if (isset($_GET['m']) && $_GET['m'] != '' && isset($_GET['cn']) && $_GET['cn'] != '' && $_GET['reg'] != '') {
            $_GET['reg'] = str_replace(' ', '', $_GET['reg']);
            $vehicleData = array();
            $vehicleData = RegistrationService::getRiDataResults($_GET['cn']);

            if (!empty($vehicleData['errors'])) {
                return false;
                exit;
            }
            if (strtoupper($_GET['reg']) == "151D18418" || strtolower($_GET['reg']) == "151d18418") {
                $vehicleData['code'] = "6802400350";
            }
            $archcheck = isset($_GET['imp']) ? $_GET['imp'] : '';
            $returnedCodeNumber = $vehicleData['code'];
            $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber, $archcheck);

            if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
                $model = RegistrationService::getCarCommModel("UsedCarsModel", $returnedCodeNumber, $archcheck);
                $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel($selectedModel, $model, $archcheck);
                $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel($selectedModel, $model, $archcheck);
                $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            }
            $vehicleYear = $vehicleData['year'];
            $calculatedMain_coreWithAssociatedCars = $calculatedRest_coreWithAssociatedCars = array();
            $checkedAllCheckboxes = null;
            $grpCustomValeResult = null;
            $calculatedCustomValue  = null;

            $archiveIds = Import::model()->with('usedComCarsCount')->findAll(array(
                'order' => '`t`.`id` DESC'
            ));
            $arch = ($_GET['imp']) ? $_GET['imp'] : '';
            foreach ($archiveIds as $item) {
                if ($item->id == $arch) {
                    $archMonth  =   $item->nazwa;
                }
            }

            $regPageContent = array(
                'vehicle' => array_merge($vehicleData, $vehicleKms),
                'model' => $model,
                'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                'calculatedMain_coreWithAssociatedCars' => $calculatedMain_coreWithAssociatedCars,
                'calculatedRest_coreWithAssociatedCars' => $calculatedRest_coreWithAssociatedCars,
                'vehicleYear' => $vehicleYear,
                'checkedAllCheckboxes' => $checkedAllCheckboxes,
                'grpCustomValeResult' => $grpCustomValeResult,
                'calculatedCustomValue' => $calculatedCustomValue,
                'type' => $selectedModel,
                'regNumber' => $vehicleData['registerVehicleNumber'],
                'archMonth' => $archMonth,
                'arch'    =>  $arch,
                'archcheck' =>  $archcheck,
                'cartype'   =>  $cartype
            );
            $regPageTableData = $this->getRegResultData($regPageContent);
        }
        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/mobile/generateiframepdf.php'); // inaczej nie da sie otworzyc pliku
        // Close and output PDF document
        $ds = DIRECTORY_SEPARATOR;
        $directory = getcwd() . $ds . 'images' . $ds;
        $filePath = $directory . 'MTP1_' . $date . '.pdf';

        $this->render('generateiframepdf', array(
            'model' => $model,
            'userYear' => $vehicleYear,
            'userKms' => $userKms,
            'userValue' => $userValue,
            'regPageContent' => $regPageContent,
            'regPageTableData' => $regPageTableData,
            'requestFrom' => $requestType,
            'filePath' => $filePath
        ));
    }
}
