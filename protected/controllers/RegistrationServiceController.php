<?php

/** MOBILE APP
 *
 *******************************************************************************
 * <hr>
 * Plik: <b>RegistrationServiceController.php</b><br>
 * Autor: <b>Mariusz Winiarz</b><br>
 * Firma: <b>Qbix-Soft</b><br>
 * Data utworzenia: <b>12-01-2014</b><br>
 * <hr>
 *******************************************************************************
 * Klasa sluzy do obslugi danych zwroconych z Risk Inteligence
 *******************************************************************************
 * <hr>
 * @author mariusz
 *******************************************************************************
 */
class RegistrationServiceController extends Controller
{
    public static $PARAM_USED_CARS_MODEL = "UsedCarsModel";
    public static $PARAM_USED_COM_CARS_MODEL = "UsedComCarsModel";
    public static $PARAM_RGE_OR_NULL_EMPTY = "Rge or Mdl is empty.";
    public $chassis = false;
    public $underwriting = false;
    //highlighted yellow colored commercial body types which is on condition marked
    public $highlightedCommBody = [
        "Cabriolet", "Cabrio", "Cabrio.", "Convertible", "Conv", "Conv.", "Coupe", "Cpe", "Coupé", "Cpé", "Estate", "Est", "Est.",
        "Combi", "Tourer", "Touring", "Avant", "avt", "Tdiavt", "Hatch", "Hatchback", "HB", "Hb", "HB.", "Hb.", "hb.", "MPV", "MPV", "MPV",
        "Roadster", "Rdster", "Rd'ster", "Rds", "Saloon", "SALOON", "Sal", "Sal.", "Sedan", "Station Wagon", "S/Wagon", "SUV", "SUV", "Estate"
    ];
    public $passengerCarBodies = [
        "Cabriolet", "Cabrio", "Cabrio.", "Convertible", "Conv", "Conv.", "Coupe", "Cpe", "Coupé", "Cpé", "Estate", "Est", "Est.",
        "Combi", "Tourer", "Touring", "Avant", "avt", "Tdiavt", "Hatch", "Hatchback", "HB", "Hb", "HB.", "Hb.", "hb.", "MPV", "MPV", "MPV",
        "Roadster", "Rdster", "Rd'ster", "Rds", "Saloon", "SALOON", "Sal", "Sal.", "Sedan", "Station Wagon", "S/Wagon", "SUV", "SUV", "Estate"
    ];
    //highlighted yellow colored car body types which is on condition marked
    public $highlightedCarBody = [
        "Chassis Cab", "Ch/Cab", "Commercial", "Comm", "Comm.", "Crew Cab", "Crew/Cab", "C/Cab", "Crew Cab", "Double Cab",
        "D/Cab", "Dbl Cab", "Dbl. Cab", "Pick Up", "Pick-Up", "Pick Up D'Cab", "Pick-Up D'Cab", "Pick Up S'Cab", "Pick-Up S'Cab",
        "Van", "Van", "Pick Up", "Pick Up"
    ];
    public $commercialCarBodies = [
        "Chassis Cab", "Ch/Cab", "Commercial", "Comm", "Comm.", "Crew Cab", "Crew/Cab", "C/Cab", "Crew Cab", "Double Cab",
        "D/Cab", "Dbl Cab", "Dbl. Cab", "Pick Up", "Pick-Up", "Pick Up D'Cab", "Pick-Up D'Cab", "Pick Up S'Cab", "Pick-Up S'Cab",
        "Van", "Van", "Pick Up", "Pick Up"
    ];
    //All NVDF bodies
    public $NVDF_BODIES = [
        "Cabriolet", "Cabrio", "Cabrio.", "Chassis Cab", "Ch/Cab", "Commercial", "Comm", "Comm.", "Convertible", "Conv", "Conv.", "Coupe", "Cpe",
        "Coupé", "Cpé", "Crew Cab", "Crew/Cab", "C/Cab", "Crew Cab", "Double Cab", "D/Cab", "Dbl Cab", "Dbl. Cab", "Estate", "Est", "Est.", "Combi", "Tourer",
        "Touring", "Avant", "avt", "Tdiavt", "Hatch", "Hatchback", "HB", "Hb", "HB.", "Hb.", "hb.", "MPV", "MPV", "MPV", "Pick Up", "Pick-Up", "Pick Up D'Cab",
        "Pick-Up D'Cab", "Pick Up S'Cab", "Pick-Up S'Cab", "Roadster", "Rdster", "Rd'ster", "Rds", "Saloon",
        "Sal", "Sal.", "Sedan", "Station Wagon", "S/Wagon", "SUV", "SUV", "Van", "Van", "Pick Up", "Pick Up", "Estate",
    ];


    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules()
    {
        return array(
            array(
                'allow',  // allow all users to perform 'index' and 'view' actions
                'actions' => array('apiRegLookup', 'apiRegLookupTEST', 'singleRequest', 'singleRequestMtpInternal', 'lmopSingleRequest', 'apiTestSingleRequest', 'testAp', 'GenerateAPIRequest', 'apimakemodel', 'singlerequestbointernal', 'importBOICars', 'importBOIComCars'),
                'users' => array('*'),
            ),
            array(
                'allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('checkPlateNumber', 'GenerateAPIRequest', 'GCheckPlateNumberByRegLookUpMobile', 'checkPlateNumberByRegLookUpArchive', 'usedComCarsArchiveRegLookup', 'usedCarsArchiveRegLookup', 'historyCheck', 'historyCheckMobile', 'generatePdfHistoryCheck', 'generatePdf', 'ajaxCalculateByRegLookUpMobile', 'ajaxCalculateByRegLookUp', 'ajaxCalculate', 'usedCarsLookupIFrame', 'usedCommercialLookupIFrame', 'checkPlateNumberByRegLookUp', 'pdfByRegLookUp', 'calculateByRegLookUp', 'checkPlateNumberByRegLookUpNoAjax', 'checkPlateNumberByRegLookUpMobileSelectsFilter', 'checkPlateNumberByRegLookUpMobile', 'ajaxCalculateByRegLookUpArch'),
                'users' => array('@'),
            ),
            array(
                'allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('apiTester', 'apiMakeModelTest'),
                'users' => array('admin', 'su'),
            ),
            array(
                'deny',  // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction($action)
    {
        if (!(Yii::app()->mobileDetect->isMobile() || Yii::app()->mobileDetect->isTablet())) {
            Uzytkownik::updateNetworkUserSession();
        }

        return parent::beforeAction($action);
    }

    public function actionGCheckPlateNumberByRegLookUpMobile()
    {
        $this->layout = '//layouts/mainMobile';
        //verify the licence
        $this->checkLicence();
        // default variables
        $cartype = "passenger";
        $selectedModel = self::$PARAM_USED_CARS_MODEL;
        $main_coreWithAssociatedCarsModel = $rest_coreWithAssociatedCarsModel = array();
        $model = null;
        $archMonth = "";
        $vehicleKms = array("kmsForYear" => "");
        // Always resolve lookups against the latest import.
        $import = Import::getLastImportData();
        if (empty($import) || empty($import->id)) {
            Yii::log('No import data found while processing mobile reg lookup', CLogger::LEVEL_ERROR, 'application');
            Yii::app()->user->setFlash('errorMsg', 'No import data available.');
            echo $this->gNoRegFoundHTML($_POST['VehicleRegNumber']);
            exit;
        }
        $latestImportId = (int) $import->id;
        $requestedArch = (isset($_POST['arch']) && $_POST['arch'] !== '') ? (int) $_POST['arch'] : 0;
        if (!empty($requestedArch) && $requestedArch !== $latestImportId) {
            Yii::log('Ignoring requested archive import ' . $requestedArch . ' and using latest import ' . $latestImportId, CLogger::LEVEL_WARNING, 'application');
        }
        $archcheck = $latestImportId;
        $arch = $latestImportId;

        $_POST['VehicleRegNumber'] = str_replace(' ', '', $_POST['VehicleRegNumber']);

        //MW HERE 2017-04
        $time_start = microtime(true);
        $timeTrack = 'Start REG: ' . $_POST['VehicleRegNumber'] . ' - ';

        $vehicleData = array();
        Yii::log('Test error log2', CLogger::LEVEL_ERROR, 'application');
        //get data from V-risk
        $vehicleData = RegistrationService::getRiDataResults($_POST['VehicleRegNumber']);
        
        $time_period = microtime(true);
        $timeTrack .= 'After RI (' . ($time_period - $time_start) . ')';

        if (!empty($vehicleData['errors'])) {
            Yii::app()->user->setFlash('errorMsg', $vehicleData['errors']);
            echo $this->gNoRegFoundHTML($_POST['VehicleRegNumber']);
            exit;
        }
        if ($_POST['VehicleRegNumber'] == "151D18418" || $_POST['VehicleRegNumber'] == "151d18418") {
            $vehicleData['code'] = "6802400350";
        }

        $returnedCodeNumber = $vehicleData['code'];
        //MW Link files
        // if the codenumber returned by RI is not the core model we will look yp the right code in the links files and use it right code to make teh valueation.
        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);
        //timetracking
        $time_period = microtime(true);
        $timeTrack .= 'After LinkedCars (' . ($time_period - $time_start) . ')';

        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            $model = RegistrationService::getCarCommModel("UsedCarsModel", $returnedCodeNumber, $archcheck);

            if (empty($model)) {
                $cartype = "commercial";
                $this->checkLicence($cartype);
                $selectedModel = self::$PARAM_USED_COM_CARS_MODEL;
                // search commercial
                if (!RegistrationService::isMPVorOtherNonCommercialBody($vehicleData['body'])) {
                    $model = RegistrationService::getCarCommModel($selectedModel, $returnedCodeNumber, $archcheck);
                }
            } else {
                // search cars
                $this->checkLicence($cartype);
            }

            $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel($selectedModel, $model, $archcheck);
            $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel($selectedModel, $model, $archcheck);
            $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
        }

        //timetracking
        $time_period = microtime(true);
        $timeTrack .= 'After Associated (' . ($time_period - $time_start) . ')';
        //adjusted values 
        $vehicleYear = $vehicleData['year']; //$vehicleKms;//carefull was above couldn get POST vehYear
        $calculatedMain_coreWithAssociatedCars = $calculatedRest_coreWithAssociatedCars = array();
        $checkedAllCheckboxes = (!empty($_POST['checkedAllCheckboxes'])) ? $_POST['checkedAllCheckboxes'] : null;
        $grpCustomValeResult = (!empty($_POST['customValueGrp'])) ? $_POST['customValueGrp'] : null;
        $calculatedCustomValue  = null;

        if (!empty($_POST['userGuideKm'])) {
            $userGuideKm =  $userKm = (empty($_POST['userGuideKm'])) ? $vehicleKms : $_POST['userGuideKm'];
            $skipCalc = false;
            $calculatedMain_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($main_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
            $calculatedRest_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($rest_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
        }
        //timetracking
        $time_period = microtime(true);
        $timeTrack .= 'After OdoCalcs (' . ($time_period - $time_start) . ')';

        if (empty($coreWithAssociatedCarsModel))
            Yii::app()->user->setFlash('infoMsg', self::$PARAM_RGE_OR_NULL_EMPTY);

        $archiveIds = Import::model()->with('usedComCarsCount')->findAll(array(
            'order' => '`t`.`id` DESC'
        ));

        foreach ($archiveIds as $item) {
            if ($item->id == $arch) {
                $archMonth  =   $item->nazwa;
            }
        }

        if ($_POST['useAjax']) {
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

            $_SESSION['arch']    = isset($_REQUEST['arch']) ? $_REQUEST['arch'] : '';
            $_SESSION['VehicleRegNumber']   = isset($_REQUEST['VehicleRegNumber']) ? $_REQUEST['VehicleRegNumber'] : '';
            $_SESSION['usedCarComModel']   = isset($_REQUEST['usedCarComModel']) ? $_REQUEST['usedCarComModel'] : '';
            $_SESSION['importId']   = isset($_REQUEST['importId']) ? $_REQUEST['importId'] : '';
            $_SESSION['useAjax']   = isset($_REQUEST['useAjax']) ? $_REQUEST['useAjax'] : '';

            echo $data = $this->getRegResultHTML($regPageContent);
            echo $data;
        } else {
            // no ajax
            $view = ($selectedModel == self::$PARAM_USED_CARS_MODEL) ? 'usedCarsByRegLookup' : 'usedCommercialByRegLookup';
            $this->render(
                $view,
                array(
                    'vehicle' => array_merge($vehicleData, $vehicleKms),
                    'model' => $model,
                    'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                    'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                    'calculatedMain_coreWithAssociatedCars' => array(),
                    'calculatedRest_coreWithAssociatedCars' => array(),
                    'type' => $selectedModel,
                    'hideHeader' => true
                )
            );
        }
        //timetracking
        $time_period = microtime(true);
        $timeTrack .= 'After Render (' . ($time_period - $time_start) . ')';
        file_put_contents('protected/runtime/timeTracking.log', $timeTrack . "\r\n", FILE_APPEND);
    }

    public function gNoRegFoundHTML($vehicleRegNumber)
    {
        $html = '<div role="main" class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">';
        $html .= '<div class="emphasize4" style="text-align:center;">';
        $html .= strtoupper($vehicleRegNumber);
        $html .= '</div>';
        $html .= '<div class="results emphasize2">This vehicle doesn’t have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div></div>';
        //button
        $html .= '<div class="focusmobile_regscreen">
            <div class="btn_back btn_centre button-square">
          <button class="buttonBack" onclick="goUp()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
            <span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
          </button>
        </div>';
        return $html;
    }

    /*
    * Get HTML for Search by reg page on the form page.
    * Check KMS here too
    * Must be only for Mobile version
    * Developed on 11-May-2020
    */
    public function getRegResultHTML($data)
    {
        $vriskCode  =   $mtpCode    =   "";
        $vehicle = $data['vehicle'];
        $cartype = $data['cartype'];
        $selectedModel = $data['type'];
        $carData = RegistrationService::getCarDetail($data);
        $maker      = isset($data['vehicle']['make']) ? strtolower($data['vehicle']['make']) : '';
        $verisktag  = isset($data['vehicle']['model']) ? explode(' ', strtolower($data['vehicle']['model'])) : '';

        $bodytags   = "";
        $car        = $carData['car'];
        $skip       = $carData['skip'];
        $carModel   = 'UsedCarsModel';
        if ($data['cartype'] == 'commercial') {
            $carModel = 'UsedComCarsModel';
        }

        if (isset(Yii::app()->params['app_mode']) && Yii::app()->params['app_mode'] == 'development') {
            $vriskCode  =   ' - ' . $vehicle['code'];
            if ($car['codenumber'])
                $mtpCode    =   "<br/>MTP Code Number - " . $car['codenumber'];
        }

        if ($vehicle['kmsForYear']) {
            $model = RegistrationService::getCarCommModel($carModel, $car['codenumber'], $data['archcheck']);
            $vehicle['kmsForYear'] = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicle['year'], $model))['kmsForYear'];
        } else {

            $model = RegistrationService::getCarCommModel($carModel, $car['codenumber'], $data['arch']);
            $vehicle['kmsForYear'] = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicle['year'], $model))['kmsForYear'];
        }



        echo '<div class="ui-body ui-body-a ui-corner-all" data-theme="a" data-form="ui-body-a">';
        echo '<div class="emphasize4" style="text-align:center;">' . strtoupper($_POST['VehicleRegNumber']);
        echo $vriskCode . $mtpCode;
        echo '</div>';

        //matched data code with API
        if ($car['codenumber'] != '') {
            echo '<input type="hidden" id="VehicleRegNumber" name="VehicleRegNumber" value="' . strtolower($_POST['VehicleRegNumber']) . '">
			<input type="hidden" id="codenumber" name="codenumber" value="' . strtolower($car['codenumber']) . '">';
        }
        echo '<div class="emphasize2" style="text-align:center;">';
        if (is_numeric($vehicle['year'])) {
            if (strlen((string)$vehicle['year']) > 2) {
                echo Mobile::displayFullYearForRegYear($vehicle['year']) . ' (' . $vehicle['year'] . ')<br/>'; // convert
            } else {
                echo Mobile::displayFullYearForRegYear($vehicle['year']) . ' <br/>'; // convert
            }
        }

        $carTooOldOrYoung = false;
        $skip = 0;

        if (!RegistrationService::isValidYear($vehicle, $_POST['VehicleRegNumber'])) {
            $carTooOldOrYoung = true;
            $skip = 3;
        } else {

            if (empty($vehicle['code'])) {
                $skip = 5;
            }
        }


        echo '' . $vehicle['make'] . '<br/>';
        echo '' . $vehicle['model'] . '<br/>';
        echo '' . $vehicle['colour'] . '<br/>';
        if (is_array($vehicle['engine'])) {
            echo '' . isset($vehicle['engine']['@value']) ? $vehicle['engine']['@value'] : " " . '<br/>';
        } else {
            echo '' . $vehicle['engine'] . '<br/>';
        }


        echo '' . $vehicle['fuel'] . '<br/>';
        echo '' . $vehicle['transmission'] . '<br/>';

        if (strpos(strtolower($vehicle['model']), 'golf') !== false && strpos(strtolower($vehicle['body']), 'estate') !== false) {
            echo 'ESTATE/HATCH<br/>';
        } else {
            echo '' . $vehicle['body'] . '<br/>';
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
            //Check if this passenger vehicle have commercial body
            if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->commercialCarBodies))) {
                $skip = 6;
            }
        } else {
            //Check if this commercial vehicle have passenger body

            if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->passengerCarBodies))) {
                $skip = 7;
            }
        }
        if ($skip != 6) {

            echo '<br/>Co2: ' . (($vehicle['CO2']) ? $vehicle['CO2'] : "--") . '<br/>';

            if ($vehicle['previous_reg']) {
                echo 'Previous Registration: ' . $vehicle['previous_reg'] . '<br/>';
            }

            if (!empty($vehicle['import_outside']) && ($vehicle['import_outside'] != 'false')) {
                echo 'Import outside of UK/Ire: ' . $vehicle['import_outside'] . '<br/>';
            }

            echo 'Tax Cost: ' . (($vehicle['roadTax']) ? '€' . $vehicle['roadTax'] : "--") . '<br/>';

            if (Yii::app()->params['is_test_version']) {

                if (!empty($vehicle['code'])) {

                    echo '' . $vehicle['code'] . '(verisk)<br/>';
                }
            } else {
                if (!empty($vehicle['code'])) {
                }
            }
        }
        //new shifted

        if ($skip == 0 || $skip == 7) {
            if (Yii::app()->params['is_test_version']) {
                echo '' . $car['bod'] . '(MTP)<br/>';
                echo '' . $car['codenumber'] . '(MTP)<br/>';
            }
            echo '</div>';
        } else if ($skip == 3) {
            //outside of Valid years
            echo '</div><!-- emp2-->';
            echo '<br><div class="results emphasize2">This vehicle doesn’t have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';
        } else if ($skip == 4) {
            //velar and "12" codes - car too new
            echo '</div><!-- emp2-->';
            echo '<br><div class="results emphasize2">This vehicle is too new to have a value on our app right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';
        } else {
            //skip = 5 as well
            echo '</div><!-- emp2-->';
            echo '<br><div class="results emphasize2">This vehicle doesn’t have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';
        }

        $skipRowRenault = false;

        if ($verisktag) {
            if (isset($verisktag[0]) && $verisktag[0] == 'grand') {
                if (isset($maker) && strpos(strtolower($maker), 'renault') !== false) {
                    $skipRowRenault  = true;
                }
            }
        }

        if ($car) {
            if ($skip == 0 || $skip == 7) {
                $info = $car->getValueAndKmsForYear($vehicle['year']);
                //echo"<pre>"; print_r($info); die;
                if (empty($_POST['userGuideKm'])) {
                    $kms =  $vehicle['kmsForYear'];
                } else {
                    $kms =  $_POST['userGuideKm'] / 1000;
                }

                if (!empty($kms)) {
                    $import = Import::getLastImportData();
                    //echo"<pre>"; print_r($import); die;
                    $input = array();
                    $input['km'] = $kms;
                    $input['year'] = $vehicle['year'];
                    $input['fuel'] = $car['fuel'];
                    $input['guide'] = $info['value']; // ze znakiem euro
                    $input['guideKm'] = $info['kms']; // km z tabeli
                    if ($_POST['arch'] && $_POST['arch'] != '') {
                        if ($_POST['arch'] == $import->id) {
                            $input['import'] = $import->id;
                        } else {
                            $input['import'] = $_POST['arch'];
                        }
                    } else {
                        $input['import'] = $import->id;
                    }

                    $input['codenumber'] = $car['codenumber'];
                    $input['carOrCom'] = 'UsedCarsModel';
                    // echo"<pre>"; print_r($input); die;
                    $adjustedValueArray = UsedCars::odometerCalculation($input);
                    //echo"<pre>"; print_r($adjustedValueArray); die;
                    $adjustedValue = $adjustedValueArray['adjustedValue'];
                    if (Mobile::isNumber($adjustedValue)) {
                        $info['kms'] = $kms;
                        $info['value'] = $adjustedValue;
                    } else {
                        echo '<br><div class="results emphasize2"><span class=\'emphasize2\'>' . $adjustedValue . '</span></div>';
                    }
                }

                $kmsforthis = (Mobile::isNumber($info['value'])) ? '&euro;' . Mobile::displayValue($info['value']) : 'NA';
                $gprice = (Mobile::isNumber($info['value'])) ? Mobile::displayValue($info['value']) : 0;

                $valueString = '<div class="results emphasize4" style="text-align:center; margin-bottom: -10px;">GUIDE Price:&nbsp <input type="hidden" name="gprice" id="gprice" value="' . $gprice . '">' . $kmsforthis . '</div>';
                $kmsString = '<div class="results emphasize2" style="text-align:center; margin-bottom: -10px;">With&nbsp: <input type="hidden" name="gkms" id="gkms" value="' . Mobile::displayKms($info['kms']) . '">' . Mobile::displayKms($info['kms']) . '&nbsp;Kms</div>';

                if ($skipRowRenault) {
                    $valueString = '<div class="results emphasize4" style="text-align:center; margin-bottom: -10px;">GUIDE Price:&nbsp <input type="hidden" name="gprice" id="gprice" value=""></div>';
                    $kmsString = '<div class="results emphasize2" style="text-align:center; margin-bottom: -10px;">With&nbsp: <input type="hidden" name="gkms" id="gkms" value="">&nbsp;</div>';
                }
                echo $valueString . $kmsString;
                echo '<div class="results emphasize2" > <input type="hidden" name="gdate" id="gdate" value="' . $data['archMonth'] . '"> (' . $data['archMonth'] . ')</div>';
            }
        } else {
            echo '<!-- emp2-->';
            if (strtolower($_POST['VehicleRegNumber']) != '201d19296' || strtoupper($_POST['VehicleRegNumber']) != '201D19296') {
                echo '<br><div class="results emphasize2">This vehicle doesn’t have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';
            }
        }

        if ($skipRowRenault) {
            echo '<!-- emp2-->';
            echo '<br><div class="results emphasize2">This vehicle doesn’t have an app valuation right now but give us a call on <a href="tel:018775460">018775460</a> and we will help you out</div>';
        }

        $usedCarsMark = Mobile::getUsedCarsMark();

        echo "<br/></div></div>";
        echo '<div class="row pdficon" style="display:none;">
                <div class="col-md-12 text-right pdflink">
                    <a target="__blank" href="' . Yii::app()->createUrl('/mobile/generatePdf', array('m' => 'UsedCarsModel', 'imp' => $usedCarsMark[0]['id_import'])) . '"><img src="./images/pdf.png" style="width:28px; height:28px;" alt="[pdf]" /></a>
                </div>
            </div>';
        echo '<div class="focusmobile_regscreen">
            <div class="btn_back btn_centre button-square">
          <button class="buttonBack" onclick="goUp()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
            <span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
          </button>
        </div> </div>';
    }

    /**
     * Metoda pobiera dane z RI i renderuje z nimi widok
     * 'checksOnly' 'usedCarComModel' 'importId' to dane potrzebne
     * do obliczenia wartosci samochodu {odometer calculation}
     */
    public function actionCheckPlateNumber()
    {
        $lvVehicleRegNumber =   $_REQUEST['VehicleRegNumber'];
        $lvRIVehicleData    =   new RIVehicleData();
        $checksOnly         =   true; // Yii::app()->user->getIsCheckOnly(); //@todo: płatny/nie płatny zależy od wyboru użytkownika (czy chce pełne dane pojazdu czy podstawowe), nie jest to cecha samego użytkownika.
        $lvSoapResult       =   ($checksOnly) ? $lvRIVehicleData->vehicleFreeReport($lvVehicleRegNumber) : $lvRIVehicleData->queryVehicle($lvVehicleRegNumber);

        Yii::app()->controller->renderPartial(
            'checkPlateNumberResults',
            array(
                'RIdata' => $lvSoapResult,
                'checksOnly' => $checksOnly,
                'usedCarComModel' => $_REQUEST['usedCarComModel'],
                'importId' => $_REQUEST['importId'],
            )
        );
    }

    public function actionHistoryCheck()
    {
        $this->layout = '//layouts/iframe';
        $lvSoapResult = null;
        if (!empty($_POST['VehicleRegNumber'])) {
            $lvVehicleRegNumber = $_REQUEST['VehicleRegNumber'];
            $lvRIVehicleData = new RIVehicleData();
            $checksOnly = true;
            $lvSoapResult = $lvRIVehicleData->vehicleHistoryCheck($lvVehicleRegNumber);
        }

        Yii::app()->controller->render(
            'checkPlateNumberResultsHistory',
            array(
                'RIdata' => $lvSoapResult,
                'checksOnly' => true,
            )
        );
    }

    public function actionHistoryCheckMobile()
    {
        $this->layout = '//layouts/mainMobile';
        $lvSoapResult = null;
        if (!empty($_POST['VehicleRegNumber'])) {
            $lvVehicleRegNumber = $_REQUEST['VehicleRegNumber'];
            //$lvVehicleRegNumber = "131D1234";//"06D51321"; // TEST ONLY
            $lvRIVehicleData = new RIVehicleData();
            $checksOnly = true;
            $lvSoapResult = $lvRIVehicleData->vehicleHistoryCheck($lvVehicleRegNumber);
        }

        $this->render(
            'checkPlateNumberResultsHistoryMobile',
            array(
                'RIdata' => $lvSoapResult,
                'checksOnly' => true,
            )
        );
    }

    /**
     * Metoda generuje PDF z otzymanymi danych z RI
     */
    public function actionGeneratePdf()
    {
        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/registrationService/generatePdf.php'); // inaczej nie da sie otworzyc pliku
        $this->render('generatePdf');
    }

    /**
     * Odometer calculation
     */
    public function actionAjaxCalculate()
    {
        echo "Not implemented yet.";
    }

    public function actionUsedCarsLookup()
    {
        $this->layout = Controller::getLayoutDevice();
        $this->render('usedCarsByRegLookup', array('hideHeader' => false));
    }

    public function actionUsedCarsLookupIFrame()
    {
        //$this->layout = Controller::getLayoutDevice();
        $this->layout = '//layouts/iframe';
        $this->render('usedCarsByRegLookup', array('hideHeader' => false));
    }

    public function actionUsedCarsArchiveRegLookup()
    {
        //$this->layout = Controller::getLayoutDevice();
        $this->layout = '//layouts/iframe';
        $this->render('usedCarsByRegLookup', array('hideHeader' => false));
    }

    public function actionUsedCommercialLookup()
    {
        $this->layout = Controller::getLayoutDevice();
        $this->render('usedCommercialByRegLookup', array('hideHeader' => false));
    }

    public function actionUsedCommercialLookupIFrame()
    {
        //$this->layout = Controller::getLayoutDevice();
        $this->layout = '//layouts/iframe';
        $this->render('usedCommercialByRegLookup', array('hideHeader' => false));
    }

    public function actionUsedComCarsArchiveRegLookup()
    {
        //$this->layout = Controller::getLayoutDevice();
        $this->layout = '//layouts/iframe';
        $this->render('usedCommercialByRegLookup', array('hideHeader' => false));
    }

    // TODO: refactor
    public function actionCheckPlateNumberByRegLookUp()
    {
        //$this->layout = Controller::getLayoutDevice();
        $this->layout   =   'iframe';
        $vehicleData    =   array();
        $vehicleData    =   RegistrationService::getRiDataResults($_POST['VehicleRegNumber']);
        $selectedModel  =   $_POST['usedCarComModel'];

        if (!empty($vehicleData['errors'])) {
            Yii::app()->user->setFlash('errorMsg', $vehicleData['errors']);
            if ($_POST['useAjax'] == '') {
                if ($selectedModel == self::$PARAM_USED_CARS_MODEL) {
                    CController::forward('member/usedCars');
                } else {
                    CController::forward('member/usedCommercial');
                }
                exit;
            }
            echo $this->renderPartial(
                '_basicDetailsInformation',
                array(
                    'vehicle' => "",
                    'model' => "",
                    'coreWithAssociatedCarsModel' => "",
                    'type' => $selectedModel
                )
            );
            exit;
        }

        $returnedCodeNumber = $vehicleData['code'];
        //MW Link files
        // if the codenumber returned by RI is not the core model we will look yp the right code in the links files and use it right code to make teh valueation.
        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);

        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            // najpierw szukamy core jesli core jest pusty to commercial
            $model_data   =   $this->getAssociatedCarsModel($returnedCodeNumber);
            $model  =   $model_data['model'];
            $main_coreWithAssociatedCarsModel  =   $model_data['main_coreWithAssociatedCarsModel'];
            $rest_coreWithAssociatedCarsModel  =   $model_data['rest_coreWithAssociatedCarsModel'];

            $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            // jesli $vehicleKms="" to znaczy ze w bazie nie jest uzupelniony rok dla tego samochodu (rok ktory zwraca RI)
        } else {
            $model = null;
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            $vehicleKms = array("kmsForYear" => "");
        }

        if (empty($coreWithAssociatedCarsModel))
            Yii::app()->user->setFlash('infoMsg', self::$PARAM_RGE_OR_NULL_EMPTY);

        if ($_POST['useAjax']) {
            $this->renderPartial(
                '_basicDetailsInformation',
                array(
                    'vehicle' => array_merge($vehicleData, $vehicleKms),
                    'model' => $model,
                    'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                    'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                    'calculatedMain_coreWithAssociatedCars' => array(),
                    'calculatedRest_coreWithAssociatedCars' => array(),
                    'type' => $selectedModel
                )
            );
        } else {
            // no ajax
            $view = ($selectedModel == self::$PARAM_USED_CARS_MODEL) ? 'usedCarsByRegLookup' : 'usedCommercialByRegLookup';
            $this->render(
                $view,
                array(
                    'vehicle' => array_merge($vehicleData, $vehicleKms),
                    'model' => $model,
                    'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                    'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                    'calculatedMain_coreWithAssociatedCars' => array(),
                    'calculatedRest_coreWithAssociatedCars' => array(),
                    'type' => $selectedModel,
                    'hideHeader' => true
                )
            );
        }
    }

    public function actionCheckPlateNumberByRegLookUpArchive()
    {
        $arch = null;
        if (!empty($_POST['arch'])) {
            $arch = $_POST['arch'];
        }
        $this->layout = 'iframe';

        $vehicleData = array();
        $vehicleData = RegistrationService::getRiDataResults($_POST['VehicleRegNumber']);

        $selectedModel = $_POST['usedCarComModel'];

        if (!empty($vehicleData['errors'])) {
            Yii::app()->user->setFlash('errorMsg', $vehicleData['errors']);
            if ($_POST['useAjax'] == '') {
                if ($selectedModel == self::$PARAM_USED_CARS_MODEL) {
                    CController::forward('member/usedCars');
                } else {
                    CController::forward('member/usedCommercial');
                }
                exit;
            }
            echo $this->renderPartial(
                '_basicDetailsInformation',
                array(
                    'vehicle' => "",
                    'model' => "",
                    'coreWithAssociatedCarsModel' => "",
                    'type' => $selectedModel
                )
            );
            exit;
        }

        $returnedCodeNumber = $vehicleData['code'];
        //MW Link files
        // if the codenumber returned by RI is not the core model we will look yp the right code in the links files and use it right code to make teh valueation.
        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);
        //        echo ' changed if found in linked -->'.$returnedCodeNumber.'<--';
        //TODO - allow for years from arch to have lower limits
        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            // najpierw szukamy core jesli core jest pusty to commercial
            $model = RegistrationService::getCarCommModel("UsedCarsModel", $returnedCodeNumber, $arch);
            if (empty($model)) {
                // search commercial
                $model = RegistrationService::getCarCommModel("UsedComCarsModel", $returnedCodeNumber, $arch);
                //TODO - follow up here:
                $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model, $arch);
                $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model, $arch);
            } else {
                // search cars
                $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model, $arch);
                $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model, $arch);
            }
            if (!empty($model)) {
                $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            } else {
                $vehicleKms = array("kmsForYear" => "");
                Yii::app()->user->setFlash('infoMsg', 'We have problem finding the car of that registration');
            }
            // jesli $vehicleKms="" to znaczy ze w bazie nie jest uzupelniony rok dla tego samochodu (rok ktory zwraca RI)
        } else {
            //TODO MW CLEAN ECHO
            echo 'year not empty';
            $model = null;
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            $vehicleKms = array("kmsForYear" => "");
        }

        if (empty($coreWithAssociatedCarsModel))
            Yii::app()->user->setFlash('infoMsg', self::$PARAM_RGE_OR_NULL_EMPTY);

        if ($_POST['useAjax']) {
            $this->renderPartial(
                '_basicDetailsInformation',
                array(
                    'vehicle' => array_merge($vehicleData, $vehicleKms),
                    'model' => $model,
                    'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                    'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                    'calculatedMain_coreWithAssociatedCars' => array(),
                    'calculatedRest_coreWithAssociatedCars' => array(),
                    'type' => $selectedModel
                )
            );
        } else {
            // no ajax
            $view = ($selectedModel == self::$PARAM_USED_CARS_MODEL) ? 'usedCarsByRegLookup' : 'usedCommercialByRegLookup';
            $this->render(
                $view,
                array(
                    'vehicle' => array_merge($vehicleData, $vehicleKms),
                    'model' => $model,
                    'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                    'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                    'calculatedMain_coreWithAssociatedCars' => array(),
                    'calculatedRest_coreWithAssociatedCars' => array(),
                    'type' => $selectedModel,
                    'hideHeader' => true
                )
            );
        }
    }

    public function actionCheckPlateNumberByRegLookUpMobile()
    {
        //MW HERE 2016-11
        if (empty($_POST['useAjax'])) {
            $this->redirect(array('mobile/selectCars'));
            exit;
        }
        $this->layout   =   'iframe';
        $vehicleData    =   array();
        $vehicleData    =   RegistrationService::getRiDataResults();
        $selectedModel  =   $_POST['usedCarComModel'];

        if (!empty($vehicleData['errors'])) {
            Yii::app()->user->setFlash('errorMsg', $vehicleData['errors']);
            if ($_POST['useAjax'] == '') {
                $this->redirect('mobile/selectCars');
                if ($selectedModel == self::$PARAM_USED_CARS_MODEL) {
                    CController::forward('member/usedCars');
                } else {
                    CController::forward('member/usedCommercial');
                }
                exit;
            }
            echo $this->renderPartial(
                '_basicDetailsInformation',
                array(
                    'vehicle' => "",
                    'model' => "",
                    'coreWithAssociatedCarsModel' => "",
                    'type' => $selectedModel
                )
            );
            exit;
        }

        $returnedCodeNumber = $vehicleData['code'];
        //MW Link files
        // if the codenumber returned by RI is not the core model we will look yp the right code in the links files and use it right code to make teh valueation.
        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);

        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            // najpierw szukamy core jesli core jest pusty to commercial
            $model_data   =   $this->getAssociatedCarsModel($returnedCodeNumber);
            $model  =   $model_data['model'];
            $main_coreWithAssociatedCarsModel  =   $model_data['main_coreWithAssociatedCarsModel'];
            $rest_coreWithAssociatedCarsModel  =   $model_data['rest_coreWithAssociatedCarsModel'];

            $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            // jesli $vehicleKms="" to znaczy ze w bazie nie jest uzupelniony rok dla tego samochodu (rok ktory zwraca RI)
        } else {
            $model = null;
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            $vehicleKms = array("kmsForYear" => "");
        }
        //adjusted values 
        $vehicleYear = (!empty($_POST['userGuideKm'])) ? $_POST['vehicleYear'] : $vehicleKms;
        if (!empty($_POST['userGuideKm'])) {
            $userKm = (empty($_POST['userGuideKm'])) ? $vehicleKms : $_POST['userGuideKm'];
            $userGuideKm = RegistrationService::multiplyUserKm($userKm);


            $skipCalc = ($_POST['defaultKmsForYear'] == $_POST['userGuideKm'] || empty($_POST['userGuideKm'])) ? true : false;

            $calculatedMain_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($main_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
            $calculatedRest_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($rest_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);

            $selectedModel = (empty($model)) ? "UsedComCarsModel" : "UsedCarsModel";
            $calculatedCustomValue = RegistrationService::odometerCalculationByRegLookUpCustomValue($_POST['customValueGrp'], $userGuideKm, $vehicleYear, $selectedModel, $returnedCodeNumber); //$_POST['coreCodenumberForCustomValue']);
            $checkedAllCheckboxes = (!empty($_POST['checkedAllCheckboxes'])) ? $_POST['checkedAllCheckboxes'] : null;
            $grpCustomValeResult = (!empty($_POST['customValueGrp'])) ? $_POST['customValueGrp'] : null;
            //andjusted values end
        } else {
            $calculatedMain_coreWithAssociatedCars = array();
            $calculatedRest_coreWithAssociatedCars = array();
            $checkedAllCheckboxes = (!empty($_POST['checkedAllCheckboxes'])) ? $_POST['checkedAllCheckboxes'] : null;
            $grpCustomValeResult = (!empty($_POST['customValueGrp'])) ? $_POST['customValueGrp'] : null;
            $calculatedCustomValue  = null;
        }
        if (empty($coreWithAssociatedCarsModel))
            Yii::app()->user->setFlash('infoMsg', self::$PARAM_RGE_OR_NULL_EMPTY);

        if ($_POST['useAjax']) {

            if (isset($_GET['last_select'])) {
                $this->renderPartial(
                    '_basicDetailsInformationMobile',
                    array(
                        'vehicle' => array_merge($vehicleData, $vehicleKms),
                        'model' => $model,
                        'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                        'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                        //adjust
                        'calculatedMain_coreWithAssociatedCars' => $calculatedMain_coreWithAssociatedCars,
                        'calculatedRest_coreWithAssociatedCars' => $calculatedRest_coreWithAssociatedCars,
                        'vehicleYear' => $vehicleYear,
                        'checkedAllCheckboxes' => $checkedAllCheckboxes,
                        'grpCustomValeResult' => $grpCustomValeResult,
                        'calculatedCustomValue' => $calculatedCustomValue,
                        //adjust end
                        'type' => $selectedModel
                    )
                );
            } else {
                $this->render(
                    '_basicDetailsInformationMobile',
                    array(
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
                        'type' => $selectedModel
                    )
                );
            }
        } else {
            // no ajax
            $view = ($selectedModel == self::$PARAM_USED_CARS_MODEL) ? 'usedCarsByRegLookup' : 'usedCommercialByRegLookup';
            $this->render(
                $view,
                array(
                    'vehicle' => array_merge($vehicleData, $vehicleKms),
                    'model' => $model,
                    'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                    'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                    'calculatedMain_coreWithAssociatedCars' => array(),
                    'calculatedRest_coreWithAssociatedCars' => array(),
                    'type' => $selectedModel,
                    'hideHeader' => true
                )
            );
        }
    }

    public function actionCheckPlateNumberByRegLookUpMobileSelectsFilter()
    {
        if (empty($_POST['useAjax'])) {
            $this->redirect(array('mobile/selectCars'));
            exit;
        }
        $this->layout = 'iframe';

        $vehicleData = array();
        $vehicleData = RegistrationService::getRiDataResults($_POST['VehicleRegNumber']);
        $selectedModel = $_POST['usedCarComModel'];
        $returnedCodeNumber = $vehicleData['code'];
        //MW Link files
        // if the codenumber returned by RI is not the core model we will look yp the right code in the links files and use it right code to make teh valueation.
        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);

        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            // najpierw szukamy core jesli core jest pusty to commercial
            $model_data   =   $this->getAssociatedCarsModel($returnedCodeNumber);
            $model  =   $model_data['model'];
            $main_coreWithAssociatedCarsModel  =   $model_data['main_coreWithAssociatedCarsModel'];
            $rest_coreWithAssociatedCarsModel  =   $model_data['rest_coreWithAssociatedCarsModel'];

            $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            // jesli $vehicleKms="" to znaczy ze w bazie nie jest uzupelniony rok dla tego samochodu (rok ktory zwraca RI)
        } else {
            $model = null;
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            $vehicleKms = array("kmsForYear" => "");
        }

        if (empty($coreWithAssociatedCarsModel))
            Yii::app()->user->setFlash('infoMsg', self::$PARAM_RGE_OR_NULL_EMPTY);

        if ($_POST['useAjax']) {
            if (isset($_GET['last_select'])) {
                $this->render(
                    '_basicDetailsInformationMobile',
                    array(
                        'vehicle' => array_merge($vehicleData, $vehicleKms),
                        'model' => $model,
                        'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                        'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                        'calculatedMain_coreWithAssociatedCars' => array(),
                        'calculatedRest_coreWithAssociatedCars' => array(),
                        'type' => $selectedModel
                    )
                );
            } else {
                $this->render(
                    '_basicDetailsInformationMobile',
                    array(
                        'vehicle' => array_merge($vehicleData, $vehicleKms),
                        'model' => $model,
                        'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                        'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                        'calculatedMain_coreWithAssociatedCars' => array(),
                        'calculatedRest_coreWithAssociatedCars' => array(),
                        'type' => $selectedModel
                    )
                );
            }
        } else {
            // no ajax
            $view = ($selectedModel == self::$PARAM_USED_CARS_MODEL) ? 'usedCarsByRegLookup' : 'usedCommercialByRegLookup';
            $this->render(
                $view,
                array(
                    'vehicle' => array_merge($vehicleData, $vehicleKms),
                    'model' => $model,
                    'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                    'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                    'calculatedMain_coreWithAssociatedCars' => array(),
                    'calculatedRest_coreWithAssociatedCars' => array(),
                    'type' => $selectedModel,
                    'hideHeader' => true
                )
            );
        }
    }

    /**
     * Odometer calculation byRegLookUp
     */
    // TODO: refactor
    public function actionAjaxCalculateByRegLookUp()
    {
        $userKm         =   (empty($_POST['userGuideKm'])) ? $_POST['defaultKmsForYear'] : $_POST['userGuideKm'];
        $userGuideKm    =   RegistrationService::multiplyUserKm($userKm);
        $vehicleYear    =   $_POST['vehicleYear'];
        $selectedModel  =   $_POST['usedCarComModel'];
        $vehicleData    =   RegistrationService::getRiDataResults($_POST['VehicleRegNumber']);
        $returnedCodeNumber =   $vehicleData['code'];

        // najpierw szukamy core jesli core jest pusty to commercial
        $model_data   =   $this->getAssociatedCarsModel($returnedCodeNumber);
        $model  =   $model_data['model'];
        $main_coreWithAssociatedCarsModel  =   $model_data['main_coreWithAssociatedCarsModel'];
        $rest_coreWithAssociatedCarsModel  =   $model_data['rest_coreWithAssociatedCarsModel'];

        $skipCalc = ($_POST['defaultKmsForYear'] == $_POST['userGuideKm'] || empty($_POST['userGuideKm'])) ? true : false;

        $calculatedMain_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($main_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
        $calculatedRest_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($rest_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);

        $selectedModel = (empty($model)) ? "UsedComCarsModel" : "UsedCarsModel";
        $calculatedCustomValue = RegistrationService::odometerCalculationByRegLookUpCustomValue($_POST['customValueGrp'], $userGuideKm, $vehicleYear, $selectedModel, $returnedCodeNumber); // $_POST['coreCodenumberForCustomValue']);

        // clear when $calculatedCustomValue = Valuation cannot be made. Mileage is outside calculation allowance of 
        // on the default clear GRP km Adjustment column

        if (strlen($calculatedCustomValue) > 9 || $skipCalc == true) {
            $calculatedCustomValue = "";
        }
        $this->renderPartial(
            '_associatedValuesByRegLookUp',
            array(
                'model' => $model,
                'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                'calculatedMain_coreWithAssociatedCars' => $calculatedMain_coreWithAssociatedCars,
                'calculatedRest_coreWithAssociatedCars' => $calculatedRest_coreWithAssociatedCars,
                'vehicleYear' => $vehicleYear,
                'checkedAllCheckboxes' => $_POST['checkedAllCheckboxes'],
                'grpCustomValeResult' => $_POST['customValueGrp'],
                'calculatedCustomValue' => $calculatedCustomValue,
            )
        );
    }

    public function actionAjaxCalculateByRegLookUpArch()
    {
        $arch = null;
        if (!empty($_POST['arch'])) {
            $arch = $_POST['arch'];
        }

        $userKm = (empty($_POST['userGuideKm'])) ? $_POST['defaultKmsForYear'] : $_POST['userGuideKm'];
        $userGuideKm = RegistrationService::multiplyUserKm($userKm);
        $vehicleYear = $_POST['vehicleYear'];
        $selectedModel = $_POST['usedCarComModel'];

        $vehicleData = RegistrationService::getRiDataResults($_POST['VehicleRegNumber']);
        $returnedCodeNumber = $vehicleData['code'];

        // najpierw szukamy core jesli core jest pusty to commercial
        $model = RegistrationService::getCarCommModel("UsedCarsModel", $returnedCodeNumber, $arch);
        if (empty($model)) {
            // search commercial
            $model = RegistrationService::getCarCommModel("UsedComCarsModel", $returnedCodeNumber, $arch);
            $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model, $arch);
            $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model, $arch);
        } else {
            // search cars
            $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model, $arch);
            $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model, $arch);
        }

        $skipCalc = ($_POST['defaultKmsForYear'] == $_POST['userGuideKm'] || empty($_POST['userGuideKm'])) ? true : false;

        $calculatedMain_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($main_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc, $arch);
        $calculatedRest_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($rest_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc, $arch);

        $selectedModel = (empty($model)) ? "UsedComCarsModel" : "UsedCarsModel";
        $calculatedCustomValue = RegistrationService::odometerCalculationByRegLookUpCustomValue($_POST['customValueGrp'], $userGuideKm, $vehicleYear, $selectedModel, $returnedCodeNumber, $arch); // $_POST['coreCodenumberForCustomValue']);

        // clear when $calculatedCustomValue = Valuation cannot be made. Mileage is outside calculation allowance of 
        // on the default clear GRP km Adjustment column

        if (strlen($calculatedCustomValue) > 9 || $skipCalc == true) {
            $calculatedCustomValue = "";
        }
        $this->renderPartial(
            '_associatedValuesByRegLookUp',
            array(
                'model' => $model,
                'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                'calculatedMain_coreWithAssociatedCars' => $calculatedMain_coreWithAssociatedCars,
                'calculatedRest_coreWithAssociatedCars' => $calculatedRest_coreWithAssociatedCars,
                'vehicleYear' => $vehicleYear,
                'checkedAllCheckboxes' => $_POST['checkedAllCheckboxes'],
                'grpCustomValeResult' => $_POST['customValueGrp'],
                'calculatedCustomValue' => $calculatedCustomValue,
            )
        );
    }

    public function actionAjaxCalculateByRegLookUpMobile()
    {
        $userKm = (empty($_POST['userGuideKm'])) ? $_POST['defaultKmsForYear'] : $_POST['userGuideKm'];
        $userGuideKm = RegistrationService::multiplyUserKm($userKm);
        $vehicleYear = $_POST['vehicleYear'];
        $selectedModel = $_POST['usedCarComModel'];

        $vehicleData = RegistrationService::getRiDataResults($_POST['VehicleRegNumber']);
        $returnedCodeNumber = $vehicleData['code'];

        // najpierw szukamy core jesli core jest pusty to commercial
        $model_data   =   $this->getAssociatedCarsModel($returnedCodeNumber);
        $model  =   $model_data['model'];
        $main_coreWithAssociatedCarsModel  =   $model_data['main_coreWithAssociatedCarsModel'];
        $rest_coreWithAssociatedCarsModel  =   $model_data['rest_coreWithAssociatedCarsModel'];

        $skipCalc = ($_POST['defaultKmsForYear'] == $_POST['userGuideKm'] || empty($_POST['userGuideKm'])) ? true : false;

        $calculatedMain_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($main_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
        $calculatedRest_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($rest_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);

        $selectedModel = (empty($model)) ? "UsedComCarsModel" : "UsedCarsModel";
        $calculatedCustomValue = RegistrationService::odometerCalculationByRegLookUpCustomValue($_POST['customValueGrp'], $userGuideKm, $vehicleYear, $selectedModel, $returnedCodeNumber); //$_POST['coreCodenumberForCustomValue']);

        // clear when $calculatedCustomValue = Valuation cannot be made. Mileage is outside calculation allowance of 
        // on the default clear GRP km Adjustment column
        if (strlen($calculatedCustomValue) > 9 || $skipCalc == true)
            $calculatedCustomValue = "";

        $this->renderPartial(
            '_associatedValuesByRegLookUpMobile',
            array(
                'model' => $model,
                'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
                'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
                'calculatedMain_coreWithAssociatedCars' => $calculatedMain_coreWithAssociatedCars,
                'calculatedRest_coreWithAssociatedCars' => $calculatedRest_coreWithAssociatedCars,
                'vehicleYear' => $vehicleYear,
                'checkedAllCheckboxes' => $_POST['checkedAllCheckboxes'],
                'grpCustomValeResult' => $_POST['customValueGrp'],
                'calculatedCustomValue' => $calculatedCustomValue,
            )
        );
    }

    public function actionPdfByRegLookUp()
    {
        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/registrationService/pdfByRegLookUp.php'); // inaczej nie da sie otworzyc pliku
        $this->render('generatePdf');
    }



    public function actionGeneratePdfHistoryCheck()
    {
        $RIdata = null;

        if (isset($_GET['reg']) && $_GET['reg'] != '') {
            $lvVehicleRegNumber = $_REQUEST['reg'];
            $lvRIVehicleData = new RIVehicleData();
            $RIdata = $lvRIVehicleData->vehicleHistoryCheck($lvVehicleRegNumber);
        }

        Yii::import('application.extensions.*');
        require_once('tcpdf/config/lang/eng.php');
        require_once('tcpdf/tcpdf.php');
        require_once('./protected/views/registrationService/generatePdfHistoryCheck.php'); // inaczej nie da sie otworzyc pliku

        $this->render('generatePdfHistoryCheck', array(
            'RIdata' => $RIdata,
        ));
    }

    //API call
    public function actionApiRegLookup($reg_number)
    {
        exit();
        $validRegNumber = false;
        $out = array();
        if (!empty($_GET['reg_number'])) {

            $regNumber = $_GET['reg_number'];
            $validRegNumber = true;
        } else {
            $out = $this->getApiMessage('ERROR', 'Empty registration number',  'Empty registration number', array());
            echo $out;
            exit;
        }
        if (!$validRegNumber) {
            $out = $this->getApiMessage('ERROR', 'Registration number outside of test scope reg:' . $regNumber,  'Registration number outside of test scope', array());
            echo $out;
            exit;
        }
        $vehicleData = array();
        $vehicleData = RegistrationService::getRiDataResults($regNumber);

        $returnedCodeNumber = $vehicleData['code'];
        $trace['returnedCodeNumber'] = $returnedCodeNumber;
        //MW Link files
        // if the codenumber returned by RI is not the core model we will look yp the right code in the links files and use it right code to make teh valueation.
        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);

        $trace['mtpCode'] = $returnedCodeNumber;
        if (!RegistrationService::isValidYear($vehicleData)) {
            $out = $this->getApiMessage('ERROR', 'The car is too old or too yourg to be quoted. :' . $regNumber,  'The car is too old or too yourg to be quoted.', array());
            echo $out;
            exit;
        }

        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            // najpierw szukamy core jesli core jest pusty to commercial
            $model_data   =   $this->getAssociatedCarsModel($returnedCodeNumber);
            $model  =   $model_data['model'];
            $main_coreWithAssociatedCarsModel  =   $model_data['main_coreWithAssociatedCarsModel'];
            $rest_coreWithAssociatedCarsModel  =   $model_data['rest_coreWithAssociatedCarsModel'];

            $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            // jesli $vehicleKms="" to znaczy ze w bazie nie jest uzupelniony rok dla tego samochodu (rok ktory zwraca RI)
        } else {
            $model = null;
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            $vehicleKms = array("kmsForYear" => "");
        }

        $vehicle = array_merge($vehicleData, $vehicleKms);
        foreach ($main_coreWithAssociatedCarsModel as $item) {
            if (RegistrationService::getFieldValueForYear("yr", $vehicle['year'], $item) != '') {
                $outVehicle['ri_code'] = $trace['returnedCodeNumber'];
                $outVehicle['mtp_code'] = $item['codenumber']; //$trace['mtpCode'];    
                $outVehicle['make'] = $vehicle['make'];
                $outVehicle['model'] = $vehicle['model'];
                $outVehicle['type'] = $item['badgetype'];
                $outVehicle['drs'] = $item['drs'];
                $outVehicle['body'] = $item['bod'];
                $outVehicle['transmission'] = $item['transmission'];
                $outVehicle['value'] = round(self::strToNumber(RegistrationService::getFieldValueForYear("GRP", $vehicle['year'], $item)), 2);

                $outVehicles[] = $outVehicle;
            }
        }


        //MTP Options
        foreach ($rest_coreWithAssociatedCarsModel as $item) {
            if (
                $main_coreWithAssociatedCarsModel[0]['codenumber'] == $item['codenumber'] ||
                $main_coreWithAssociatedCarsModel[0]['codenumber'] == $item['corecode']
            ) {
                continue;
            }
            if (RegistrationService::getFieldValueForYear("yr", $vehicle['year'], $item) != '') {
                $outVehicle['ri_code'] = $trace['returnedCodeNumber'];
                $outVehicle['mtp_code'] = $item['codenumber']; //$trace['mtpCode'];    
                $outVehicle['make'] = $vehicle['make'];
                $outVehicle['model'] = $vehicle['model'];
                $outVehicle['type'] = $item['badgetype'];
                $outVehicle['drs'] = $item['drs'];
                $outVehicle['body'] = $item['bod'];
                $outVehicle['transmission'] = $item['transmission'];
                $outVehicle['value'] = round(self::strToNumber(RegistrationService::getFieldValueForYear("GRP", $vehicle['year'], $item)), 2);
                $outVehicles[] = $outVehicle;
            }
        }

        $out = $this->getApiMessage('OK', null,  null, $outVehicles);
        echo $out;
        exit;
        $selectedModel = self::$PARAM_USED_CARS_MODEL;
    }

    public static function getApiMessage($status, $errorMsg, $visibleMsg, $vehicles)
    {
        $out['status'] = $status;
        $out['error_msg'] = $errorMsg;
        $out['msg'] = $visibleMsg;
        $out['vehicles'] = $vehicles;
        $response = str_replace('\\/', '/', json_encode($out));
        return $response;
    }

    public static function strToNumber($str)
    {
        $str = str_replace('$', '', $str);
        $str = str_replace('£', '', $str);
        $str = str_replace('€', '', $str);
        $str = str_replace(',', '', $str);
        return $str;
    }

    public static function displayFormatCurrency($value, $currency)
    {
        $value = round($value, 2, PHP_ROUND_HALF_UP);
        $numberFmtCurrency = new \NumberFormatter('en_GB', \NumberFormatter::CURRENCY);
        $numberFmtCurrency->setAttribute(\NumberFormatter::ROUNDING_INCREMENT, 0);
        return $numberFmtCurrency->formatCurrency($value, $currency);
    }

    //API call
    public static function allowedTestRegNUmbers()
    {
        $allowed = array(
            '10D122771',
            '11C10713',
            '12TN870',
            '132D3765',
            '132C1923',
            '141D11854',
            '141MH53',
            '151MH2002',
            '161D35722',
            '161KE4444'
        );
        return $allowed;
    }
    public function actionApiRegMultipleTest()
    {
        $regsTotest;
    }

    public function createPasswordString($password, $nonce, $created)
    {
        $passTxtIn = $password . $nonce . $created;
        return self::digestPassMD5Base64Encode($passTxtIn);
    }

    public function actionApiTester()
    {
        $baseUrl = Yii::app()->params['main_url'];
        $this->layout = '//layouts/iframe';
        
        if (!empty($_POST['username'])) {
            $username   =   $_POST['username'];
            $apiUser    =   ApiUsers::model()->find(
                array(
                    'condition' => 'username=:username',
                    'params' => array(':username' => $username)
                )
            );
            
            $nonce = time(); //'axerfgyuioloiua';
            $created = '2019-04-30T13:45:00Z7';
            $userKms = null;

            $url    = $baseUrl . 'index.php?r=registrationService/';
            $method = 'apiTestSingleRequest';

            if (isset($_POST['form_type']) && $_POST['form_type'] == 'makemodeltest') {
                $redirectUrl = 'apiMakeModel';
            }

            $paramsData =   array(
                'username' => base64_encode($username),
                'nonce' => base64_encode($nonce),
                'created' => base64_encode($created)
            );

            if (!empty($_POST["userkms"])) {
                $userKms = $_POST["userkms"];
                $paramsData['user_kms'] = base64_encode($_POST['userkms']);
            }

            if (!empty($_POST["regnumber"])) {
                $reg_number = $_POST["regnumber"];
                $paramsData['reg_number'] = base64_encode($_POST['regnumber']);
            }

            if (!empty($_POST["mtp_code"])) {
                $reg_number = $_POST["mtp_code"];
                $paramsData['mtp_code'] = base64_encode($_POST['mtp_code']);
            }

            if (!empty($_POST["year"])) {
                $paramsData['year'] = base64_encode($_POST['year']);
            }
            if (!empty($_POST['chassis'])) {
                $paramsData['chassis'] = 1;
            }

            switch ($username) {
                case 'testuser':
                    $password = $apiUser->password;
                    $password = 'tstp63qDRxbeQ';
                    $method = 'apiTestSingleRequest';
                    break;
                case 'lmopuser':
                    $password = 'cTifr$7984FRtyaiwukl';
                    $method = 'lmopSingleRequest';
                    break;
                case 'lmop01':
                    $password = 'fde39A$Yap^qiop09QW';
                    $method = 'lmopSingleRequest';
                    break;
                case 'connollymg01':
                    $password = $apiUser->password;
                    $method = 'singleRequest';
                    break;
                case 'mtpuserdesktop':
                    $password = $apiUser->password;
                    $method = 'singleRequestMtpInternal';
                    break;
                case 'boiuser':
                    $password = $apiUser->password;
                    $method = 'SingleRequestBOInternal';
                    break;
                default:
                    $password = $apiUser->password;
                    $method = 'singleRequest';
                    break;
            }
            
            $paramsData['passwordText'] = $this->createPasswordString($password, $nonce, $created);
            if ($_POST['form_type'] == 'makemodeltest') {
                $method = 'apiMakeModel';
            }
            $url .= $method;
            $url .= '&' . http_build_query($paramsData);
            $this->redirect($url);
            
        } else {
            $this->render('//registrationService/apiTester',    array());
        }
    }

    public function actionGenerateAPIRequest()
    {
        $username = 'testuser';
        $nonce      = "1552561760"; //time();//'axerfgyuioloiua';
        $created = "2019-03-20T05:06:10Z"; //'2018-11-14T07:45:00Z';
        $reg_number = '151D1234'; //'151D1982';
        $password = 'tstp63qDRxbeQ'; //testuser Candidate 01-2019
        $passTxtIn = $password . $nonce . $created;
        $passTxt = self::digestPassMD5Base64Encode($passTxtIn);

        echo "<br>Username:" . $username;
        echo "<br>Nonce:" . $nonce;
        echo "<br>Created:" . $created;
        echo "<br>User:" . $username;
        echo Yii::app()->params['api_url'] . 'index.php?r=registrationService/apiTestSingleRequest&reg_number=' . base64_encode($reg_number) . '&username=' . base64_encode($username) . '&user_kms=' . base64_encode('70000') . '&passwordText=' . $passTxt . '&nonce=' . base64_encode($nonce) . '&created=' . base64_encode($created) . '';
        //unified one car/connolys
    }
    public function actionLmopSingleRequest()
    {
        file_put_contents('./protected/runtime/API_log.log', "\r\n NEW LMOP CALL:" . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
        if (!empty($_GET['user_kms'])) {
            $_GET['user_kms'] = base64_decode($_GET['user_kms']);
            $userKms = $_GET['user_kms'];
        } else {
            $userKms = null;
        }

        if (empty($_GET['username']) || empty($_GET['passwordText']) || empty($_GET['nonce']) || empty($_GET['created']) || empty($_GET['reg_number'])) {
            $out = $this->getApiMessage('ERROR', 'Some arguments are missing',  'Some arguments are missing', array());
            echo $out;
            Yii::app()->end();
        }

        if (!(self::authenticateAPICall('lmopuser', 'cTifr$7984FRtyaiwukl') || self::authenticateAPICall('lmop01', 'XXX___QQQQ_CLOSED'))) {

            $out = $this->getApiMessage('ERROR', 'Authentication error',  'Authentication error', array());
            echo $out;
            Yii::app()->end();
        } else {
            if ((base64_decode($_GET['username']) == 'lmop01') && (isset($_GET['chassis']) && $_GET['chassis'] == 1)) {
                $this->chassis = true;
            }
            if ((base64_decode($_GET['username']) == 'lmop01')) {
                $this->underwriting = true;
            } else {
                $this->underwriting = false;
            }
        }

        $validRegNumber = false;
        $out = array();
        if (!empty($_GET['reg_number'])) {
            $regNumber = base64_decode($_GET['reg_number']);
            $validRegNumber = true;
        } else {
            $out = $this->getApiMessage('ERROR', 'Empty registration number',  'Empty registration number', array());
            echo $out;
            exit;
        }
        if (!$validRegNumber) {
            $out = $this->getApiMessage('ERROR', 'Registration number outside of test scope reg:' . $regNumber,  'Registration number outside of test scope', array());
            echo $out;
            exit;
        }

        $chassis = false;
        if (!empty($_GET['chassis']) && $_GET['chassis'] == 1) {

            $chassis = self::isChassisClient(base64_decode($_GET['username']));

            $oneCarResults = $this->getOneCarDetails($regNumber, $chassis, $userKms);
        } else {
            if ((base64_decode($_GET['username']) == 'lmopuser')) {
                $oneCarResults = $this->getOneCarDetails($regNumber, false, $userKms, true, true);
            } else {
                $oneCarResults = $this->getOneCarDetails($regNumber, false, $userKms);
            }
        }
        //prepare values for display
        $car = $oneCarResults['car'];
        $vehicle = $oneCarResults['vehicle'];
        $adjustedValue = $oneCarResults['adjustedValue'];
        $returnKms = $oneCarResults['returnKms'];
        if (!empty($oneCarResults['msg'])) {
            $out = $this->getApiMessage('ERROR', $oneCarResults['msg'],  $oneCarResults['msg'], array());
            echo $out;
            Yii::app()->end();
        }

        if (strlen((string)$vehicle['year']) > 2) {
            $fullYear =  Mobile::displayFullYearForRegYear($vehicle['year']) . ' (' . $vehicle['year'] . ')<br/>'; // convert
        } else {
            $fullYear = Mobile::displayFullYearForRegYear($vehicle['year']) . ' <br/>'; // convert
        }

        $range = UsedCarsRanges::model()->find('rangecode=:range ORDER BY id DESC', array('range' => $car->rangecode));
        if (empty($range)) {

            $range = UsedCommsRanges::model()->find('rangecode=:range ORDER BY id desc', array('range' => $car->rangecode));
        }
        $outVehicle['mtp_code'] = $car['codenumber']; //$trace['mtpCode'];
        $outVehicle['MTPMake'] = $car['maker']; //$vehicle['make'];
        $outVehicle['MTPModel'] = $car['vehicle'];
        $outVehicle['MTPType'] = $car['badge']; //'Sprint';//$item['badgetype'];

        if ($this->underwriting) {
            $outVehicle['MTPRange'] = $range->rangedesc; //'Sportage';//$vehicle['model'];
            $outVehicle['MTPTypeStripped'] = $car['mtptype'];
            $outVehicle['Doors'] = $car['drs'];
        }

        $outVehicle['Body'] = $car['bod'];
        $outVehicle['Transmission'] = $car['transmission'];
        $outVehicle['Verisk_Body'] = $vehicle['body']; //versik body type
        $outVehicle['Fuel'] = RegistrationService::getFuelDescription($car->fuel); //'diesel';//$item['transmission'];
        $outVehicle['CC'] = $car->cc;

        if ($this->underwriting) {
            $outVehicle['Drive'] = $car->drive;
            $outVehicle['LMOPMake'] = $car->lmopmake; //'LMOPMakeExample';//$item['transmission'];
            $outVehicle['LMOPModel'] = $car->lmopmodel; //'LMOPRangeExample';
            $outVehicle['LMOPType'] = $car->lmoptype; //'LMOPRangeExample';


            //$item['transmission'];
            $outVehicle['RegYear'] = $vehicle['year']; //'152';//$item['transmission'];
        }

        $outVehicle['FullYear'] = RegistrationService::displayFullYearForRegYear($vehicle['year']); //'152';//$item['transmission'];

        if (!$chassis) {
            $outVehicle['Verisk_Make'] = $vehicle['make'];
            $outVehicle['Verisk_Model'] = $vehicle['model'];
            $outVehicle['Verisk_Colour'] = $vehicle['colour'];
            $outVehicle['RegNumber'] = $vehicle['registerVehicleNumber'];


            if ($this->underwriting) {
                $outVehicle['Verisk_DateOf1stReg'] = '';
                $outVehicle['Verisk_EngineNumber'] = '';
                $outVehicle['Verisk_Chassis'] = '';
            } else {
                $outVehicle['Verisk_Transmission'] = $vehicle['transmission'];
                $outVehicle['Verisk_Fuel'] = $vehicle['fuel'];
                $outVehicle['Verisk_Engine'] = $vehicle['engine'];
            }
        }

        if (!empty($adjustedValue)) {
            $str = preg_replace('/\D/', '', $adjustedValue);
        } else {
            $grp = $car->getValueAndKmsForYear($vehicle['year']);
            $str = preg_replace('/\D/', '', $grp['value']);
        }
        if ($this->underwriting) {


            $outVehicle['GRP'] = $str;
            $outVehicle['Kms'] = (string)$returnKms;
        }
        if ($chassis) {
            $outVehicle['Verisk_Make'] = $vehicle['chassisArray']['VehicleData']['Make'];
            $outVehicle['Verisk_Model'] = $vehicle['chassisArray']['VehicleData']['Model'];
            $outVehicle['Verisk_Colour'] = $vehicle['chassisArray']['VehicleData']['Colour'];
            $outVehicle['Verisk_DateOf1stReg'] = $vehicle['chassisArray']['VehicleData']['Date_1st_Registration'];
            $outVehicle['Verisk_EngineNumber'] = $vehicle['chassisArray']['VehicleData']['Engine_Number'];
            $outVehicle['Verisk_Chassis'] = $vehicle['chassisArray']['VehicleData']['Chassis_Number_Clear'];
            $outVehicle['RegNumber'] = $vehicle['chassisArray']['VehicleData']['Registration'];
        }

        if (!empty($car)) {
            $retVehicles[] = $outVehicle;
        }
        $out = $this->getApiMessage('OK', null,  null, $retVehicles);
        echo $out;
        exit;
    }
    public function getOneCarDetails($regNumber, $getChassis, $user_kms, $riDataOnlyOK = false, $ukRegOk = false, $apiUser = null)
    {
        $vehicleData = array();
        $vehicleData = RegistrationService::getRiDataResults($regNumber, $getChassis);
        
        if (empty($vehicleData['code']) || RegistrationService::isUKRegPlate($regNumber)) {
            if (!$riDataOnlyOK || (RegistrationService::isUKRegPlate($regNumber) && !$ukRegOk)) {
                $out = $this->getApiMessage('ERROR', 'Couldn\'t get the car data for this registration:' . $regNumber,  'Couldn\'t get the car data for this registration', array());
                echo $out;
                exit;
            } else {
                $this->getRIOnlyVehicleData($vehicleData, $apiUser);
                //we wil return RI data only without validation - OK for i.e. lmop website
            }
        }
        
        //echo "<pre>"; print_r($vehicleData); die;
        //$vehicleData['code'] = '';
        $trace['returnedCodeNumber'] = $returnedCodeNumber = $vehicleData['code'];
        //MW Link files
        // if the codenumber returned by RI is not the core model we will look yp the right code in the links files and use it right code to make teh valueation.
        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);

        $trace['mtpCode'] = $returnedCodeNumber;
        if (!RegistrationService::isValidYear($vehicleData)) {
            $this->getRIOnlyVehicleData($vehicleData, $apiUser);
        }
        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            // najpierw szukamy core jesli core jest pusty to commercial
            
            $model = RegistrationService::getCarCommModel("UsedCarsModel", $returnedCodeNumber);
            
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            if (empty($model)) {
                //if(!$vehicleData['body']=='MPV'){
                if (!RegistrationService::isMPVorOtherNonCommercialBody($vehicleData['body'])) {
                    // search commercial
                    $model = RegistrationService::getCarCommModel("UsedComCarsModel", $returnedCodeNumber);
                    /* if ($apiUser->username == 'testuser') {
                        $model = RegistrationService::getTestCarCommModel("UsedComCarsModel", $returnedCodeNumber);
                    } */
                    $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model);
                    $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model);
                }
            } else {
                // search cars
                $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model);
                $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model);
            }
            $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            // jesli $vehicleKms="" to znaczy ze w bazie nie jest uzupelniony rok dla tego samochodu (rok ktory zwraca RI)
        } else {
            $model = null;
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            $vehicleKms = array("kmsForYear" => "");
        }
        $vehicleYear = $vehicleData['year'];
        $vehicle = array_merge($vehicleData, $vehicleKms);
        
        $calculatedCustomValue  = null;
        if (!empty($user_kms)) {
            $userKm = (empty($user_kms)) ? $vehicleKms : $user_kms;
            $userGuideKm = $userKm;
            $skipCalc = false;
            $calculatedMain_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($main_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
            $calculatedRest_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($rest_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
            $selectedModel = (empty($model)) ? "UsedComCarsModel" : "UsedCarsModel";
            $checkedAllCheckboxes = (!empty($_POST['checkedAllCheckboxes'])) ? $_POST['checkedAllCheckboxes'] : null;
            $grpCustomValeResult = (!empty($_POST['customValueGrp'])) ? $_POST['customValueGrp'] : null;
            //andjusted values end
        } else {
            $calculatedMain_coreWithAssociatedCars = array();
            $calculatedRest_coreWithAssociatedCars = array();
            $checkedAllCheckboxes = (!empty($_POST['checkedAllCheckboxes'])) ? $_POST['checkedAllCheckboxes'] : null;
            $grpCustomValeResult = (!empty($_POST['customValueGrp'])) ? $_POST['customValueGrp'] : null;
        }

        //changed 2018-07-30 kept it uncommented as the render version of teh mibile app hads it open
        $selectedModel = self::$PARAM_USED_CARS_MODEL;
        
        $params = array(
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
            'regNumber' => $regNumber
        );

        $bestMatchedCarReturnDetails = array();

        $bestMatchedCarReturnDetails = RegistrationService::getBestMatchedCar($params);
        
        // echo "<pre>"; print_r($bestMatchedCarReturnDetails); die;
        $car = $bestMatchedCarReturnDetails['car'];
        
        if (empty($car)) {
            $oneCarResults['car']  = null;
            $oneCarResults['vehicle'] = $vehicle;
            $oneCarResults['adjustedValue'] = null;
            $oneCarResults['returnKms'] = null;
            if (!empty($bestMatchedCarReturnDetails['info'])) {
                if (!empty($bestMatchedCarReturnDetails['info']['msg'])) {
                    $oneCarResults['msg'] = $bestMatchedCarReturnDetails['msg'];
                } else {
                    $oneCarResults['msg'] = 'Unknown error: RSC1851';
                }
            } else {
                $oneCarResults['msg'] = 'Unknown error: RSC1854';
            }
            return $oneCarResults;
            exit;
        }

        $adjustedValue = null;
        $info = $car->getValueAndKmsForYear($vehicle['year']);
        $returnKms = $info['kms'] * 1000;
        if (!empty($user_kms)) {
            $import = Import::getLastImportData();
            $input = array();
            $kms =  $user_kms / 1000;
            $input['km'] = $kms;
            $input['year'] = $vehicle['year'];
            $input['fuel'] = $car['fuel'];
            $input['guide'] = $info['value']; // ze znakiem euro
            $input['guideKm'] = $info['kms']; // km z tabeli
            $input['import'] = $import->id;
            $input['codenumber'] = $car['codenumber'];
            $input['carOrCom'] = 'UsedCarsModel';
            $adjustedValueArray = UsedCars::odometerCalculation($input);
            $adjustedValue = $adjustedValueArray['adjustedValue'];
            $returnKms = (string)$user_kms;
        }
        
        $oneCarResults['car']  = $car;
        $oneCarResults['vehicle'] = $vehicle;
        $oneCarResults['adjustedValue'] = $adjustedValue;
        $oneCarResults['returnKms'] = $returnKms;
        $oneCarResults['msg'] = '';
        if (!empty($bestMatchedCarReturnDetails['info'])) {
            if (!empty($bestMatchedCarReturnDetails['info']['msg'])) {
                $oneCarResults['msg'] = $bestMatchedCarReturnDetails['info']['msg'];
            }
        }
        /* if (
            $oneCarResults['vehicle']['make'] == "Toyota" &&
            strpos($oneCarResults['vehicle']['model'], "Yaris") !== false &&
            strpos($oneCarResults['vehicle']['model'], "Cross") !== false
        ) {

            $oneCarResults['car']['codenumber']="";
        } */

        return $oneCarResults;
    } // end of unified reg lookup

    public function actionSingleRequestMtpInternal()
    {

        file_put_contents('./protected/runtime/API_log.log', "\r\n NEW TESTUSER CALL: " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);


        if (!empty($_GET['user_kms'])) {
            $_GET['user_kms'] = base64_decode($_GET['user_kms']);
            $userKms = $_GET['user_kms'];
        } else {
            $userKms = null;
        }

        if (empty($_GET['username']) || empty($_GET['passwordText']) || empty($_GET['nonce']) || empty($_GET['created']) || empty($_GET['reg_number'])) {
            $out = $this->getApiMessage('ERROR', 'Some arguments are missing',  'Some arguments are missing', array());
            echo $out;
            Yii::app()->end();
        }

        if (!empty($_GET['username'])) {
            $username_status = base64_decode($_GET['username']);
            $message = $this->userStatusCheck($username_status);
            if (isset($message) && !empty($message) && $message == 'blocked') {
                $out = $this->getApiMessage('ERROR', 'Your profile is blocked.',  'Please contact administrator to unblock your profile! ', array());
                echo $out;
                exit;
            }
        }

        if (!(self::authenticateAPIUser(base64_decode($_GET['username'])))) { // new test 2018/04/12
            $out = $this->getApiMessage('ERROR', 'Authentication error',  'Authentication error', array());
            echo $out;
            Yii::app()->end();
        } else {
            if (base64_decode($_GET['username']) == 'lmop01') {
                $this->chassis = true;
            }
        }


        $validRegNumber = false;
        $out = array();
        if (!empty($_GET['reg_number'])) {

            $regNumber = base64_decode($_GET['reg_number']);

            $validRegNumber = true;
        } else {
            $out = $this->getApiMessage('ERROR', 'Empty registration number',  'Empty registration number', array());
            echo $out;
            exit;
        }
        if (!$validRegNumber) {
            $out = $this->getApiMessage('ERROR', 'Registration number outside of test scope reg:' . $regNumber,  'Registration number outside of test scope', array());
            echo $out;
            exit;
        }
        if (!empty($_GET['chassis']) && $_GET['chassis'] == 1) {
            $chassis = self::isChassisClient($_GET['username']);
            $oneCarResults = $this->getOneCarDetails($regNumber, $chassis, $userKms);
        } else {
            $oneCarResults = $this->getOneCarDetails($regNumber, false, $userKms);
        }

        //prepare values for display
        $car = $oneCarResults['car']->id;
        $oneCarResults['car'] = $car;

        //$car = $oneCarResults['car'];
        $vehicle = $oneCarResults['vehicle'];
        $adjustedValue = $oneCarResults['adjustedValue'];
        $returnKms = $oneCarResults['returnKms'];
        //echo json_encode($oneCarResults);

        if (!empty($oneCarResults['msg'])) {
            $out = $this->getApiMessage('ERROR', $oneCarResults['msg'],  $oneCarResults['msg'], array());
            echo $out;
            Yii::app()->end();
        }
        $retVehicles[] = $oneCarResults;

        $out = $this->getApiMessage('OK', null,  null, $oneCarResults);
        echo $out;
        exit;
    }
    public function actionSingleRequest()
    {
        $msg = null;
        $cartype = 'passenger';
        file_put_contents('./protected/runtime/API_log.log', "\r\n NEW TESTUSER CALL: " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
        $apiUser = null;
        $username = base64_decode($_GET['username']);

        if (!empty($_GET['user_kms'])) {
            $_GET['user_kms'] = base64_decode($_GET['user_kms']);
            $userKms = $_GET['user_kms'];
        } else {
            $userKms = null;
        }

        if (empty($_GET['username']) || empty($_GET['passwordText']) || empty($_GET['nonce']) || empty($_GET['created']) || empty($_GET['reg_number'])) {
            $out = $this->getApiMessage('ERROR', 'Some arguments are missing',  'Some arguments are missing', array());
            echo $out;
            Yii::app()->end();
        }

        if (!empty($_GET['username'])) {
            $username_status = base64_decode($_GET['username']);
            $message = $this->userStatusCheck($username_status);
            if (isset($message) && !empty($message) && $message == 'blocked') {
                $out = $this->getApiMessage('ERROR', 'Your profile is blocked.',  'Please contact administrator to unblock your profile! ', array());
                echo $out;
                exit;
            }
        }

        if (!(self::authenticateAPIUser($username))) {
            $out = $this->getApiMessage('ERROR', 'Authentication error',  'Authentication error', array());
            echo $out;
            Yii::app()->end();
        } else {
            if ($username == 'lmop01') {
                $this->chassis = true;
            }
            $apiUser = ApiUsers::model()->find("username='" . $username . "'");
            if (empty($apiUser)) {
                $out = $this->getApiMessage('ERROR', 'Authentication error D302',  'Authentication error D302', array());
                echo $out;
                file_put_contents('./protected/runtime/API_log.log', "\r\n Authentication error D302: username='" . $username . "' " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
                Yii::app()->end();
            }
        }

        $validRegNumber = false;
        $out = array();
        if (!empty($_GET['reg_number'])) {
            $regNumber = base64_decode($_GET['reg_number']);
            $validRegNumber = true;
        } else {
            $out = $this->getApiMessage('ERROR', 'Empty registration number',  'Empty registration number', array());
            echo $out;
            exit;
        }
        if (!$validRegNumber) {
            $out = $this->getApiMessage('ERROR', 'Registration number outside of test scope reg:' . $regNumber,  'Registration number outside of test scope', array());
            echo $out;
            exit;
        }
        
        if (!empty($_GET['chassis']) && $_GET['chassis'] == 1) {
            $chassis = self::isChassisClient($_GET['username']);
            $oneCarResults = $this->getOneCarDetails($regNumber, $chassis, $userKms, $apiUser->riDataOnlyOk, $apiUser->uk_regs, $apiUser);
        } else {
            $oneCarResults = $this->getOneCarDetails($regNumber, false, $userKms, $apiUser->riDataOnlyOk, $apiUser->uk_regs, $apiUser);
        }

        //prepare values for display
        $car = $oneCarResults['car'];
        $vehicle = $oneCarResults['vehicle'];
        $adjustedValue = $oneCarResults['adjustedValue'];
        $returnKms = $oneCarResults['returnKms'];

        if (!empty($oneCarResults['msg'])) {
            $out = $this->getApiMessage('ERROR', $oneCarResults['msg'],  $oneCarResults['msg'], array());
            echo $out;
            Yii::app()->end();
        }
        //Display results
        if (strlen((string)$vehicle['year']) > 2) {
            $fullYear =  Mobile::displayFullYearForRegYear($vehicle['year']) . ' (' . $vehicle['year'] . ')<br/>'; // convert
        } else {
            $fullYear = Mobile::displayFullYearForRegYear($vehicle['year']) . ' <br/>'; // convert
        }
        $range = UsedCarsRanges::model()->find('rangecode=:range ORDER BY id DESC', array('range' => $car->rangecode));
        if (empty($range)) {
            $range = UsedCommsRanges::model()->find('rangecode=:range ORDER BY id desc', array('range' => $car->rangecode));
        }
        $data = array();
        $data['car'] = $car;
        $data['vehicle'] = $vehicle;
        $data['adjustedValue'] = $adjustedValue;
        $data['range'] = $range;
        $data['chassis'] = $this->chassis;
        $data['returnKms'] = $returnKms;
        $data['regNumber'] = $regNumber;
        $outVehicle = RegistrationService::getDisplayValues($data, $apiUser);

        if (!empty($car)) {
            if (isset($car->id_used_com_cars)) {
                $cartype = 'commercial';
            }

            if ($cartype == 'passenger') {
                if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->commercialCarBodies))) {
                    $msg = 'This vehicle does not have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out';
                }
            } else {
                if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->passengerCarBodies))) {
                    $msg = 'This vehicle does not have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out';
                    $outVehicle['GRP'] = $outVehicle['Kms'] = "";
                }
            }
            $retVehicles[] = $outVehicle;
        } else {
            if (is_numeric($vehicle['year'])) {
                if (strlen((string)$vehicle['year']) > 2) {
                    $fullyear = Mobile::displayFullYearForRegYear($vehicle['year']); // convert
                } else {
                    $fullyear = Mobile::displayFullYearForRegYear($vehicle['year']); // convert
                }
            }

            $retVehicles[] = [
                'mtp_code'  =>  '',
                'RegNumber'  =>  $vehicle['registerVehicleNumber'],
                'Make'  =>  $vehicle['make'],
                'Model'  =>  $vehicle['model'],
                'Body'  =>  $vehicle['body'],
                'Transmission'  =>  $vehicle['transmission'],
                'Fuel'  =>  $vehicle['fuel'],
                'Engine'  =>  $vehicle['engine'],
                'Colour'  =>  $vehicle['colour'],
                'RegYear'  =>  $vehicle['year'],
                'FullYear'  =>  $fullyear,
                'GRP'   =>  "",
                'Kms'   =>  ""
            ];

            $msg = 'This vehicle does not have an app valuation right now. But give us a call on 018775460 and we will help you out';
            $retVehicles = $retVehicles;
        }

        $retVehicles[0]['Engine'] = is_array($retVehicles[0]['Engine']) ? (isset($retVehicles[0]['Engine']['@value']) ? $retVehicles[0]['Engine']['@value'] : " ") : $retVehicles[0]['Engine'];
        // Code for passenger type
        $passengerType = 'true';
        // echo "<pre>";
        // echo $apiUser->is_passenger;
        // print_r($apiUser);
        // die;
        if ($apiUser->is_passenger) {
            $passengerType = ($cartype == 'passenger') ? 'True' : 'False';
            if (isset($retVehicles[0]) && !empty($retVehicles[0])) {
                $retVehicles[0]['Passenger'] = $passengerType;
                //$retVehicles[0]['NewPrice'] = "";
            }
        }
        if (!$apiUser->is_newprice) {
            unset($retVehicles[0]['NewPrice']);
        }
        //echo "<pre>"; print_r($retVehicles); die;
        $out = $this->getApiMessage('OK', null,  $msg, $retVehicles);
        $retData = (array) json_decode($out);

        if (isset($retData) && strtolower($retData['status']) == 'ok') {
            $event  = Yii::app()->controller->action->id;
            $date   = new DateTime();
            $requestString = isset($_SERVER['QUERY_STRING']) ? ltrim($_SERVER['QUERY_STRING'], 'r=registrationService') : NULL;
            $requestData = array(
                'action' => $event,
                'parsed_time' => date('Y-m-d H:i:s'),
                'reg_number' => isset($regNumber) ? $regNumber : 'NA',
                'username' => $username,
                'user_kms' => isset($userKms) ? $userKms : NULL,
                'nonce' => isset($_GET['nonce']) ? base64_decode($_GET['nonce']) : NULL,
                'created' => $date->format('Y-m-d\TH:i:s\Z'),
                'full_call' => $requestString,
                'result' => $out
            );
            $recordCounter = new RecordCounter();
            $recordCounter->storeCounter($requestData, $event);
        }
        echo $out;
        exit;
    }

    public function actionApiTestSingleRequest()
    {
        $userKms = $msg = null;
        $cartype = 'passenger';

        file_put_contents('./protected/runtime/API_log.log', "\r\n NEW TESTUSER CALL: " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
        $username = base64_decode($_GET['username']);
        $apiUser = ApiUsers::model()->find("username='" . $username . "'");

        if (empty($apiUser)) {
            $apiUser = new ApiUsers;
        } else {
            $message = $this->userStatusCheck($apiUser->username);
            if (isset($message) && !empty($message) && $message == 'blocked') {
                $out = $this->getApiMessage('ERROR', 'Your profile is blocked.',  'Please contact administrator to unblock your profile! ', array());
                echo $out;
                exit;
            }
        }

        if (!empty($_GET['user_kms'])) {
            $userKms = $_GET['user_kms'] = base64_decode($_GET['user_kms']);
        }
        if (empty($_GET['username']) || empty($_GET['passwordText']) || empty($_GET['nonce']) || empty($_GET['created']) || empty($_GET['reg_number'])) {
            $out = $this->getApiMessage('ERROR', 'Some arguments are missing',  'Some arguments are missing', array());
            echo $out;
            Yii::app()->end();
        }
        if (!(self::authenticateAPICall('testuser', 'tstp63qDRxbeQ'))) { // new test 2018/04/12
            $out = $this->getApiMessage('ERROR', 'Authentication error',  'Authentication error', array());
            echo $out;
            Yii::app()->end();
        } else {
            if (base64_decode($_GET['username']) == 'lmop01') {
                $this->chassis = true;
            }
        }

        $validRegNumber = false;
        $out = array();
        if (!empty($_GET['reg_number'])) {
            $regNumber = base64_decode($_GET['reg_number']);
            $validRegNumber = true;
        } else {
            $out = $this->getApiMessage('ERROR', 'Empty registration number',  'Empty registration number', array());
            echo $out;
            exit;
        }
        if (!$validRegNumber) {
            $out = $this->getApiMessage('ERROR', 'Registration number outside of test scope reg:' . $regNumber,  'Registration number outside of test scope', array());
            echo $out;
            exit;
        }

        $chassis = false;

        if (!empty($_GET['chassis']) && $_GET['chassis'] == 1) {
            $chassis = self::isChassisClient(base64_decode($_GET['username']));
            $oneCarResults = $this->getOneCarDetails($regNumber, $chassis, $userKms, true, true, $apiUser);
        } else {
            $oneCarResults = $this->getOneCarDetails($regNumber, false, $userKms, true, true, $apiUser);
            
        }

        
        //prepare values for display
        $car = $oneCarResults['car'];
        $vehicle = $oneCarResults['vehicle'];
        $adjustedValue = $oneCarResults['adjustedValue'];
        $returnKms = $oneCarResults['returnKms'];

        if (!empty($oneCarResults['msg'])) {
            $out = $this->getApiMessage('ERROR', $oneCarResults['msg'],  $oneCarResults['msg'], array());
            echo $out;
            Yii::app()->end();
        }

        if (strlen((string)$vehicle['year']) > 2) {
            $fullYear =  Mobile::displayFullYearForRegYear($vehicle['year']) . ' (' . $vehicle['year'] . ')<br/>'; // convert
        } else {
            $fullYear = Mobile::displayFullYearForRegYear($vehicle['year']) . ' <br/>'; // convert
        }
        $range = UsedCarsRanges::model()->find('rangecode=:range ORDER BY id DESC', array('range' => $car->rangecode));
        if (empty($range)) {
            $range = UsedCommsRanges::model()->find('rangecode=:range ORDER BY id desc', array('range' => $car->rangecode));
        }

        $data = array();
        $data['car'] = $car;
        $data['vehicle'] = $vehicle;
        $data['adjustedValue'] = $adjustedValue;
        $data['range'] = $range;
        $data['chassis'] = $this->chassis;
        $data['returnKms'] = $returnKms;
        $data['regNumber'] = $regNumber;
        $outVehicle = RegistrationService::getDisplayValues($data, $apiUser);
        
        if (!empty($car)) {
            if (isset($car->id_used_com_cars)) {
                $cartype = 'commercial';
            }

            if ($cartype == 'passenger') {
                if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->commercialCarBodies))) {
                    // if( in_array($vehicle['body'], $this->commercialCarBodies) ){
                    $msg = 'This vehicle does not have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out';
                }
            } else {
                if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->passengerCarBodies))) {
                    // if( in_array($vehicle['body'], $this->passengerCarBodies) ){
                    $msg = 'This vehicle does not have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out';
                    $outVehicle['GRP'] = $outVehicle['Kms'] = "";
                }
            }

            $retVehicles[] = $outVehicle;
        } else {
            if (is_numeric($vehicle['year'])) {
                if (strlen((string)$vehicle['year']) > 2) {
                    $fullyear = Mobile::displayFullYearForRegYear($vehicle['year']); // convert
                } else {
                    $fullyear = Mobile::displayFullYearForRegYear($vehicle['year']); // convert
                }
            }

            $retVehicles[] = [
                'mtp_code'  =>  '',
                'RegNumber'  =>  $vehicle['registerVehicleNumber'],
                'Make'  =>  $vehicle['make'],
                'Model'  =>  $vehicle['model'],
                'Body'  =>  $vehicle['body'],
                'Transmission'  =>  $vehicle['transmission'],
                'Fuel'  =>  $vehicle['fuel'],
                'Engine'  =>  $vehicle['engine'],
                'Colour'  =>  $vehicle['colour'],
                'RegYear'  =>  $vehicle['year'],
                'FullYear'  =>  $fullyear,
                'GRP'   =>  "",
                'Kms'   =>  ""
            ];

            $msg = 'This vehicle does not have an app valuation right now. But give us a call on 018775460 and we will help you out';

            $retVehicles = $retVehicles;
        }

        $retVehicles[0]['Engine'] = is_array($retVehicles[0]['Engine']) ? (isset($retVehicles[0]['Engine']['@value']) ? $retVehicles[0]['Engine']['@value'] : " ") : $retVehicles[0]['Engine'];
         // Code for passenger type
         $passengerType = 'true';
        //  die($username);
        //  if (strtolower($username) == 'firstcitiu02') {
         if ($apiUser->is_passenger) {
             //echo "<pre>"; print_r($retVehicles); die;
             $passengerType = ($cartype == 'passenger') ? 'True' : 'False';
             if (isset($retVehicles[0]) && !empty($retVehicles[0])) {
                 $retVehicles[0]['Passenger'] = $passengerType;
                 //$retVehicles[0]['NewPrice'] = "";
             }
         }
        if (!$apiUser->is_newprice) {
            unset($retVehicles[0]['NewPrice']);
        }

        $out = $this->getApiMessage('OK', null,  $msg, $retVehicles);
        $retData = (array) json_decode($out);

        if (isset($retData) && strtolower($retData['status']) == 'ok') {
            $event  = Yii::app()->controller->action->id;
            $date   = new DateTime();
            $requestString = isset($_SERVER['QUERY_STRING']) ? ltrim($_SERVER['QUERY_STRING'], 'r=registrationService') : NULL;
            $requestData = array(
                'action' => $event,
                'parsed_time' => date('Y-m-d H:i:s'),
                'reg_number' => isset($regNumber) ? $regNumber : 'NA',
                'username' => $username,
                'user_kms' => isset($userKms) ? $userKms : NULL,
                'nonce' => isset($_GET['nonce']) ? base64_decode($_GET['nonce']) : NULL,
                'created' => $date->format('Y-m-d\TH:i:s\Z'),
                'full_call' => $requestString,
                'result' => $out
            );
            $recordCounter = new RecordCounter();
            $recordCounter->storeCounter($requestData, $event);
        }
        echo $out;
        exit;
    }

    public function actionApiRegLookupTEST($reg_number)
    {

        $validRegNumber = false;
        $out = array();
        if (!empty($_GET['reg_number'])) {

            $regNumber = $_GET['reg_number'];

            $validRegNumber = true;
        } else {
            $out = $this->getApiMessage('ERROR', 'Empty registration number',  'Empty registration number', array());
            echo $out;
            exit;
        }
        if (!$validRegNumber) {
            $out = $this->getApiMessage('ERROR', 'Registration number outside of test scope reg:' . $regNumber,  'Registration number outside of test scope', array());
            echo $out;
            exit;
        }
        $vehicleData = array();
        $vehicleData = RegistrationService::getRiDataResults($regNumber);


        $returnedCodeNumber = $vehicleData['code'];
        $trace['returnedCodeNumber'] = $returnedCodeNumber;

        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);

        $trace['mtpCode'] = $returnedCodeNumber;
        if (!RegistrationService::isValidYear($vehicleData)) {
            $out = $this->getApiMessage('ERROR', 'The car is too old or too young to be quoted. :' . $regNumber,  'The car is too old or too young to be quoted.', array());
            echo $out;
            exit;
        }
        //echo ' changed if found in linked -->'.$returnedCodeNumber.'<--';
        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            // najpierw szukamy core jesli core jest pusty to commercial
            $model_data   =   $this->getAssociatedCarsModel($returnedCodeNumber);
            $model  =   $model_data['model'];
            $main_coreWithAssociatedCarsModel  =   $model_data['main_coreWithAssociatedCarsModel'];
            $rest_coreWithAssociatedCarsModel  =   $model_data['rest_coreWithAssociatedCarsModel'];

            $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            // jesli $vehicleKms="" to znaczy ze w bazie nie jest uzupelniony rok dla tego samochodu (rok ktory zwraca RI)
        } else {
            $model = null;
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            $vehicleKms = array("kmsForYear" => "");
        }
        $vehicleYear = $vehicleData['year'];
        $vehicle = array_merge($vehicleData, $vehicleKms);

        $selectedModel = self::$PARAM_USED_CARS_MODEL;
        $params = array(
            'vehicle' => array_merge($vehicleData, $vehicleKms),
            'model' => $model,
            'main_coreWithAssociatedCarsModel' => $main_coreWithAssociatedCarsModel,
            'rest_coreWithAssociatedCarsModel' => $rest_coreWithAssociatedCarsModel,
            //adjust
            'vehicleYear' => $vehicleYear,
            //adjust end
            'type' => $selectedModel
        );
        $outVehicles = array();
        $car = RegistrationService::getBestMatchedCar($params);


        if (strlen((string)$vehicle['year']) > 2) {
            $fullYear =  Mobile::displayFullYearForRegYear($vehicle['year']) . ' (' . $vehicle['year'] . ')<br/>'; // convert
        } else {
            $fullYear = Mobile::displayFullYearForRegYear($vehicle['year']) . ' <br/>'; // convert
        }
        $range = UsedCarsRanges::model()->find('rangecode=:range ORDER BY id DESC', array('range' => $car->rangecode));

        $outVehicle['mtp_code'] = $car['codenumber']; //$trace['mtpCode'];
        $outVehicle['MTPMake'] = $vehicle['make'];
        $outVehicle['MTPModel'] = $car['vehicle'];
        $outVehicle['MTPRange'] = $range->rangedesc; //'Sportage';//$vehicle['model'];
        $outVehicle['MTPType'] = $car['badge']; //'Sprint';//$item['badgetype'];
        $outVehicle['MTPTypeStripped'] = $car['mtptype'];
        $outVehicle['Doors'] = $car['drs'];
        $outVehicle['Body'] = $car['bod'];
        $outVehicle['Fuel'] = RegistrationService::getFuelDescription($car->fuel); //'diesel';//$item['transmission'];
        $outVehicle['CC'] = $car->cc;
        $outVehicle['Drive'] = $car->drive;
        $outVehicle['LMOPMake'] = $car->lmopmake; //'LMOPMakeExample';//$item['transmission'];
        $outVehicle['LMOPModel'] = $car->lmopmodel; //'LMOPRangeExample';
        $outVehicle['LMOPType'] = $car->lmoptype; //'LMOPRangeExample';
        $outVehicle['RegYear'] = $vehicle['year']; //'152';//$item['transmission'];
        $grp = $car->getValueAndKmsForYear($vehicle['year']);
        $str = preg_replace('/\D/', '', $grp['value']);
        $outVehicle['GRP'] = $str;

        if (!empty($car)) {
            $retVehicles[] = $outVehicle;
        }

        $out = $this->getApiMessage('OK', null,  null, $retVehicles);
        echo $out;
        exit;
    }

    public function getOLDLMOPRIOnlyVehicleData($riReturn)
    {
        $ret = array();
        $ret['mtp_code'] = "";
        $ret["MTPMake"] = "";
        $ret["MTPModel"] = "";
        $ret["MTPType"] = "";
        $ret["Body"] = "";
        $ret["Transmission"] = "";
        $ret["Verisk_Body"] = $riReturn["body"];
        $ret["Fuel"] = "";
        $ret["CC"] = "";
        $ret["FullYear"] = ""; //because it is letter based beggining in regnumber - cannot display
        $ret["Verisk_Make"] = $riReturn["make"];
        $ret["Verisk_Model"] = $riReturn["model"];
        $ret["Verisk_Colour"] = $riReturn["colour"];
        $ret["RegNumber"] = strtoupper($riReturn["registerVehicleNumber"]);
        $ret["Verisk_Transmission"] = $riReturn["transmission"];
        $ret["Verisk_Fuel"] = $riReturn["fuel"];
        $ret["Verisk_Engine"] = $riReturn["engine"];

        if (!empty($ret)) {
            $retVehicles[] = $ret;
        }
        $out = $this->getApiMessage('OK', null,  null, $retVehicles);
        echo $out;
        exit;
    }

    public function getRIOnlyVehicleData($riReturn, $apiUser = null)
    {
        $msg = null;
        if (empty($apiUser) || $apiUser->username == 'lmopuser' || $apiUser->username == 'lmop01') {
            return $this->getOLDLMOPRIOnlyVehicleData($riReturn);
        } else {
            $data = array();
            $data['car'] = null;
            $data['vehicle'] = $riReturn;
            $data['adjustedValue'] = null;
            $data['range'] = null;
            $data['chassis'] = null;
            $data['returnKms'] = null;
            $data['regNumber'] = null;
            $ret = RegistrationService::getDisplayValues($data, $apiUser);
        }

        if (!empty($ret)) {
            $retVehicles[] = $ret;
        }
        if (empty($ret['GRP'])) {
            $msg = "This vehicle does not have an app valuation right now but give us a call on 018775460 and we will help you out.";
        }
        
        unset($retVehicles[0]['NewPrice']);
        $out = $this->getApiMessage('OK', null,  $msg, $retVehicles);
        echo $out;
        exit;
    }


    public function getBOIRIOnlyVehicleData($riReturn, $apiUser = null)
    {
        $msg = null;
        if (empty($apiUser) || $apiUser->username == 'lmopuser' || $apiUser->username == 'lmop01') {
            return $this->getOLDLMOPRIOnlyVehicleData($riReturn);
        } else {
            $data = array();
            $data['car'] = null;
            $data['vehicle'] = $riReturn;
            $data['adjustedValue'] = null;
            $data['range'] = null;
            $data['chassis'] = null;
            $data['returnKms'] = null;
            $data['regNumber'] = null;
            $ret = RegistrationService::getBOIDisplayValues($data, $apiUser);
        }

        if (!empty($ret)) {
            $retVehicles[] = $ret;
        }
        if (empty($ret['GRP'])) {
            $msg = "This vehicle does not have an app valuation right now but give us a call on 018775460 and we will help you out.";
        }
        $out = $this->getApiMessage('OK', null,  $msg, $retVehicles);
        echo $out;
        exit;
    }


    public static function isChassisClient($username)
    {
        $users = array(
            'connollymg01' => false,
            'lmop01' => true,
            'boiuser' => true, // updated 5-01-2021
        );
        if (!empty($username)) {
            if (isset($users[$username])) {
                $chassis = $users[$username];

                return $chassis;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function authenticateAPIUser($username)
    {
        $usersObj = ApiUsers::model()->findAll();
        $users = CHtml::listData(ApiUsers::model()->findAll(), 'username', 'password');

        if (!empty($username)) {
            if (isset($users[$username])) {
                $password = $users[$username];
                return self::authenticateAPICall($username, $password);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function authenticateAPICall($username, $password)
    {
        if ($username != base64_decode($_GET['username'])) {
            file_put_contents('./protected/runtime/API_log.log', "\r\n" . date('Y-m-d H:i:s') . ' Wrong username:' . base64_decode($_GET['username']), FILE_APPEND);
            file_put_contents('./protected/runtime/API_log.log', "\r\n" . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
            Yii::log('Wrong username:' . base64_decode($_GET['username']));
            return false;
        }
        $passTxtIn = $password . base64_decode($_GET['nonce']) . base64_decode($_GET['created']);
        $passTxt = self::digestPassMD5Base64Encode($passTxtIn);
        $passTxtMD5 = self::mD5Base64Encode($passTxtIn);
        if ($passTxt === str_replace(' ', '+', $_GET['passwordText']) || $passTxtMD5 === str_replace(' ', '+', $_GET['passwordText'])) {
            return true;
        } else {
            file_put_contents('./protected/runtime/API_log.log', "\r\n" . 'Password do not match:internal:(' . $passTxt . ') external: (' . $_GET['passwordText'] . ')', FILE_APPEND);
            file_put_contents('./protected/runtime/API_log.log', "\r\n" . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
            Yii::log('Password do not match:internal:(' . $passTxt . ') external: (' . $_GET['passwordText'] . ')');
            return false;
        }
    }

    public static function validateNonce($nonceTxt, $username)
    {
        $nonce = new ApiNonce();
        $nonce->username = $username;
        $nonce->nonce = $nonceTxt;

        if ($nonce->save()) {
            return true;
        } else {
            return false;
        }
    }

    public static function validateTimestamp($timestamp)
    {
        $now = time();
        $ts = strtotime($timestamp);

        $diff = $now - $ts;
        $mins = $diff / 60;
        if ($mins < -5 || $mins > 15) {
            file_put_contents('./protected/runtime/API_log.log', "\r\n" . 'Create:now(' . $now . ') ts(' . $ts . ') DIFF:' . $diff, FILE_APPEND);
            file_put_contents('./protected/runtime/API_log.log', "\r\n" . basename($_SERVER['REQUEST_URI']), FILE_APPEND);

            return false;
        } else {
            return true;
        }
    }

    public static function digestPassMD5Base64Encode($string)
    {
        return base64_encode(openssl_digest($string, 'md5', true));
    }

    public static function mD5Base64Encode($string)
    {
        return base64_encode(md5($string));
    }

    public function actionApiMakeModelTest()
    {
        $this->layout = '//layouts/iframe';
        Yii::app()->controller->render('apiVehicleTest', array());
    }

    public function actionApiMakeModel()
    {
        $formData = $_GET;
        //Authentication starts here
        $data = $this->userAuthenticationCheck($formData);
        if (empty($data)) {
            $out = $this->getApiMessage('ERROR', 'Authentication error',  'Authentication error', array());
            echo $out;
            Yii::app()->end();
        }
        //Authentication ends here

        if (!empty($formData['user_kms'])) {
            $userKms = base64_decode($formData['user_kms']);
            if ($userKms < 0) {
                $out = $this->getApiMessage('ERROR', 'Invalid Request Parameter User KMS',  'Invalid Request Params', array());
                echo $out;
                Yii::app()->end();
            }
            // $userKms = $formData['user_kms'];
        } else {
            $userKms = null;
        }

        if (
            isset($formData['mtp_code']) && !empty($formData['mtp_code'])
            && isset($formData['year']) && !empty($formData['year'])
        ) {
            $codenumber = base64_decode($formData['mtp_code']);
            $year = base64_decode($formData['year']);

            $codeArr = explode(',', $codenumber);
            $count = count($codeArr);
            $i = 1;
            $valuationArr = array();
            if ($count > 1) {
                foreach ($codeArr as $codeNum) {
                    $info = $this->getCodeNumberDetails($codeNum, $year, $userKms);
                    if ($i == 1) {
                        $valuationArr[] = Mobile::displayValue($info['value']);
                    } else {
                        if ($info['diff']) {
                            $valuationArr[] = Mobile::displayValue($info['diff']);
                        } else {
                            $valuationArr[] = 0;
                        }
                    }
                    $i++;
                }
                if (preg_match("/^[0-9,]+$/", $valuationArr['0'])) $basevalue = str_replace(',', '', $valuationArr['0']);
            } else {
                $info = $this->getCodeNumberDetails($codeArr['0'], $year, $userKms);
            }

            if ($valuationArr) {
                foreach ($valuationArr as $record) {
                    $grp[] = str_replace(',', '', $record);
                }
                $modelPrice = array_sum($grp);
                if (preg_match("/^[0-9,]+$/", $modelPrice)) $modelPrice = str_replace(',', '', $modelPrice);
            } else {
                if (Mobile::isNumber($info['value'])) {
                    $modelPrice = Mobile::displayValue($info['value']);
                }
                if (preg_match("/^[0-9,]+$/", $modelPrice)) $modelPrice = str_replace(',', '', $modelPrice);
                $codenumber = $info['codenumber'];
            }

            $kmeters = Mobile::displayKms($info['kms']) . "Kms";
            $kmeters = preg_replace("/[^0-9]/", "", $kmeters);

            $outVehicle[] = array(
                'mtp_code' => $codenumber,
                'RegYear' => $year,
                'GRP' => $modelPrice,
                'kms' => $kmeters
            );

            $out = $this->getApiMessage('OK', null,  null, $outVehicle);
            echo $out;
        } else {
            $out = $this->getApiMessage('ERROR', 'Empty Parameters',  'Please pass required Parameters', array());
            echo $out;
            exit;
        }
    }

    public function getCodeNumberDetails($codenumber, $year, $userKms = null)
    {
        $carOrCom = 'UsedCarsModel';
        $car = RegistrationService::getCarCommModel("UsedCarsModel", $codenumber);
        if (!$car) {
            $car = RegistrationService::getCarCommModel("UsedCarsComModel", $codenumber);
            $carOrCom = 'UsedCarsComModel';
            if (!$car) {
                $out = $this->getApiMessage('ERROR', 'Invalid codenumber= ' . $codenumber,  'Invalid codenumber', array());
                echo $out;
                file_put_contents('./protected/runtime/API_log.log', "\r\n Invalid codenumber: codenumber='" . $codenumber . "' " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
                Yii::app()->end();
            }
        }

        $info = $car->getValueAndKmsForYear($year);

        if (!$info) {
            $out = $this->getApiMessage('ERROR', 'Invalid Vehicle year',  'Invalid Vehicle year', array());
            echo $out;
            file_put_contents('./protected/runtime/API_log.log', "\r\n Invalid Vehicle year: codenumber='" . $year . "' " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
            Yii::app()->end();
        }

        if (!empty($userKms)) {
            $input = array();
            $kms =  $userKms / 1000;
            $input['km'] = $kms;
            $input['year'] = $year;
            $input['fuel'] = $car['fuel'];
            $input['guide'] = $info['value']; // ze znakiem euro            
            $input['guideKm'] = $info['kms']; // km z tabeli   

            if ($formData['import_id']) {
                $input['import'] = $formData['import_id'];
            } else {
                $import = Import::getLastImportData();
                $input['import'] = $import->id;
            }

            $input['codenumber'] = $car['codenumber'];
            $input['carOrCom'] = $carOrCom;
            $adjustedValueArray = UsedCars::odometerCalculation($input);

            $adjustedValue = $adjustedValueArray['adjustedValue'];

            if (Mobile::isNumber($adjustedValue)) {
                $info['kms'] = $kms;
                $info['value'] = $adjustedValue;
            } else {
                $modelPrice = $adjustedValue;
            }
        }
        $info['codenumber'] = $car['codenumber'];
        return $info;
    }

    public function userAuthenticationCheck($formData)
    {
        file_put_contents('./protected/runtime/API_log.log', "\r\n NEW TESTUSER CALL: " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
        $apiUser = null;
        $username = base64_decode($formData['username']);
        $apiUser = ApiUsers::model()->find("username='" . $username . "'");
        if (empty($apiUser)) {
            $apiUser = new ApiUsers;
        }

        $isAuthenticated = false;
        if (empty($formData['username']) || empty($formData['passwordText']) || empty($formData['nonce']) || empty($formData['created'])) {
            $out = $this->getApiMessage('ERROR', 'Some arguments are missing',  'Some arguments are missing', array());
            echo $out;
            Yii::app()->end();
        }
        if ($username == 'testuser' && self::authenticateAPICall('testuser', 'tstp63qDRxbeQ')) { // 
            $isAuthenticated = true;
        } else if ($username == 'lmop01' && self::authenticateAPICall('lmop01', 'XXX___QQQQ_CLOSED')) {
            $isAuthenticated = true;
        } elseif ($username == 'lmopuser' && self::authenticateAPICall('lmopuser', 'cTifr$7984FRtyaiwukl')) {
            $isAuthenticated = true;
        } else if (self::authenticateAPIUser($username)) {
            $isAuthenticated = true;
        }
        if ($isAuthenticated) {
            if (base64_decode($formData['username']) == 'lmop01') {
                $this->chassis = true;
            }
        } else {
            $out = $this->getApiMessage('ERROR', 'Authentication error',  'Authentication error', array());
            echo $out;
            Yii::app()->end();
        }

        return true;
    }

    public function indicator24Check($returnedCodeNumber)
    {
        $indicator24 = substr($returnedCodeNumber, 3, 2);

        if ($indicator24 != '24') {
            $linkedCode = XmlUcarsLinks::getLinkedCarCode($returnedCodeNumber);
            if (!empty($linkedCode)) {
                $returnedCodeNumber = $linkedCode;
            } else {
                $linkedCode = XmlUcommsLinks::getLinkedCarCode($returnedCodeNumber);
                if (!empty($linkedCode)) {
                    $returnedCodeNumber = $linkedCode;
                }
            }
        }

        return $returnedCodeNumber;
    }

    static public function userStatusCheck($username)
    {
        if (isset($username)) {
            $apiUser = ApiUsers::model()->find(
                array(
                    'condition' => 'username=:username',
                    'params' => array(':username' => $username)
                )
            );

            $message = 'User doesn\'t exists on MTP.';
            if ($apiUser && $apiUser->status == "0") {
                $status = 'blocked';
                return $status;
            }
            return '';
        } else {
            return '';
        }
    }

    /* 
    *   Get API data from verisk server with varient id
    */
    public function actionSinglerequestbointernal()
    {
        if (empty($_GET['username']) || empty($_GET['passwordText']) || empty($_GET['nonce']) || empty($_GET['created']) || empty($_GET['reg_number'])) {
            $out = $this->getApiMessage('ERROR', 'Some arguments are missing',  'Some arguments are missing', array());
            echo $out;
            Yii::app()->end();
        }

        file_put_contents('./protected/runtime/API_log.log', "\r\n NEW TESTUSER CALL: " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);

        $userKms    =   $msg    =   null;
        $cartype    =   'passenger';
        $username   =   base64_decode($_GET['username']);
        $apiUser    =   ApiUsers::model()->find("username='" . $username . "'");

        if (empty($apiUser)) {
            $apiUser = new ApiUsers;
        } else {
            $message = $this->userStatusCheck($apiUser->username);
            if (isset($message) && !empty($message) && $message == 'blocked') {
                $out = $this->getApiMessage('ERROR', 'Your profile is blocked.',  'Please contact administrator to unblock your profile! ', array());
                echo $out;
                exit;
            }
        }

        if (!empty($_GET['user_kms'])) {
            $userKms = $_GET['user_kms'] = base64_decode($_GET['user_kms']);
        }

        if (!(self::authenticateAPIUser($username))) {
            $out = $this->getApiMessage('ERROR', 'Authentication error',  'Authentication error', array());
            echo $out;
            Yii::app()->end();
        } else {
            $apiUser = ApiUsers::model()->find("username='" . $username . "'");
            if (empty($apiUser)) {
                $out = $this->getApiMessage('ERROR', 'Authentication error D302',  'Authentication error D302', array());
                echo $out;
                file_put_contents('./protected/runtime/API_log.log', "\r\n Authentication error D302: username='" . $username . "' " . basename($_SERVER['REQUEST_URI']), FILE_APPEND);
                Yii::app()->end();
            }
        }


        $validRegNumber = false;
        $out = array();
        if (!empty($_GET['reg_number'])) {
            $regNumber = base64_decode($_GET['reg_number']);
            $validRegNumber = true;
        } else {
            $out = $this->getApiMessage('ERROR', 'Empty registration number',  'Empty registration number', array());
            echo $out;
            exit;
        }

        if (!$validRegNumber) {
            $out = $this->getApiMessage('ERROR', 'Registration number outside of test scope reg:' . $regNumber,  'Registration number outside of test scope', array());
            echo $out;
            exit;
        }

        $chassis = false;

        if (!empty($_GET['chassis']) && $_GET['chassis'] == 1) {
            $chassis    = self::isChassisClient(base64_decode($_GET['chassis'])); // Needs to modify when client will respond, updated 15 Feb 2022
            $chassis    =   false;
        }

        $oneCarResults  =   $this->getOneComCarDetails($regNumber, $chassis, $userKms, true, true, $apiUser);

        //prepare values for display
        $car = $oneCarResults['car'];
        $vehicle = $oneCarResults['vehicle'];
        $adjustedValue = $oneCarResults['adjustedValue'];
        $returnKms = $oneCarResults['returnKms'];

        if (!empty($oneCarResults['msg'])) {
            $out = $this->getApiMessage('ERROR', $oneCarResults['msg'],  $oneCarResults['msg'], array());
            echo $out;
            Yii::app()->end();
        }

        if (strlen((string)$vehicle['year']) > 2) {
            $fullYear =  Mobile::displayFullYearForRegYear($vehicle['year']) . ' (' . $vehicle['year'] . ')<br/>'; // convert
        } else {
            $fullYear = Mobile::displayFullYearForRegYear($vehicle['year']) . ' <br/>'; // convert
        }

        $range = UsedCarsRanges::model()->find('rangecode=:range ORDER BY id DESC', array('range' => $car->rangecode));

        if (empty($range)) {
            $range = UsedCommsRanges::model()->find('rangecode=:range ORDER BY id desc', array('range' => $car->rangecode));
        }

        $data = array();
        $data['car'] = $car;
        $data['vehicle'] = $vehicle;
        $data['adjustedValue'] = $adjustedValue;
        $data['range'] = $range;
        $data['chassis'] = $this->chassis;
        $data['returnKms'] = $returnKms;
        $data['regNumber'] = $regNumber;
        $outVehicle = RegistrationService::getBOIVeriskDisplayValues($data, $apiUser);
        if (!empty($car)) {
            if (isset($car->id_used_com_cars)) {
                $cartype = 'commercial';
            }
            $non_valuation_msg = 'This vehicle does not have an app valuation right now. But give us a call on <a href="tel:018775460">018775460</a> and we will help you out';
            if ($cartype == 'passenger') {
                if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->commercialCarBodies))) {
                    $msg = $non_valuation_msg;
                }
            } else {
                if (in_array(strtolower($vehicle['body']), array_map('strtolower', $this->passengerCarBodies))) {
                    $msg = $non_valuation_msg;
                    $outVehicle['GRP'] = $outVehicle['Kms'] = "";
                }
            }

            $outVehicle['VariantID'] = isset($data['car']['varient_id']) ? $data['car']['varient_id'] : '';

            $retVehicles[] = $outVehicle;
        } else {
            if (is_numeric($vehicle['year'])) {
                if (strlen((string)$vehicle['year']) > 2) {
                    $fullyear = Mobile::displayFullYearForRegYear($vehicle['year']); // convert
                } else {
                    $fullyear = Mobile::displayFullYearForRegYear($vehicle['year']); // convert
                }
            }

            $retVehicles[] = [
                'mtp_code'  =>  '',
                'RegNumber'  =>  $vehicle['registerVehicleNumber'],
                'Make'  =>  $vehicle['make'],
                'Model'  =>  $vehicle['model'],
                'Body'  =>  $vehicle['body'],
                'Transmission'  =>  $vehicle['transmission'],
                'Fuel'  =>  $vehicle['fuel'],
                'Engine'  =>  $vehicle['engine'],
                'Colour'  =>  $vehicle['colour'],
                'RegYear'  =>  $vehicle['year'],
                'FullYear'  =>  $fullyear,
                'GRP'   =>  "",
                'Kms'   =>  "",
                'VariantID' => isset($data['car']['varient_id']) ? $data['car']['varient_id'] : ''
            ];

            $msg = $non_valuation_msg;
            $retVehicles = $retVehicles;
        }

        $out = $this->getApiMessage('OK', null,  $msg, $retVehicles);
        echo $out;
        exit;
    }

    /*Import data from xml file(UCarsBOIMatching.xml) */
    public function actionImportBOICars()
    {
        $output = array();
        $reader = new XMLReader();
        $file = './data/boidata/UCarsBOIMatching.xml';

        if (file_exists($file)) {
            if (!$reader->open($file)) {
                die("Failed to open UCarsBOIMatching.xml");
            }
            $xml = simplexml_load_file($file);
            foreach ($xml->children() as $child) {
                $role = $child->attributes();
                foreach ($role as $key => $value) {
                    $outputAttr[$key] = (string) $value;
                }
                $output[] = $outputAttr;
            }
            $reader->close();
        }
        return $output;
    }

    /* import data in database for BOI user in model */
    /*Import data from xml file(UComsBOIMatching.xml) */
    public function actionImportBOIComCars()
    {
        $output = array();
        $reader = new XMLReader();
        $file = './data/boidata/UComsBOIMatching.xml';

        if (file_exists($file)) {
            if (!$reader->open($file)) {
                die("Failed to open UCarsBOIMatching.xml");
            }
            $xml = simplexml_load_file($file);
            foreach ($xml->children() as $child) {
                $role = $child->attributes();
                foreach ($role as $key => $value) {
                    $outputAttr[$key] = (string) $value;
                }
                $output[] = $outputAttr;
            }

            $reader->close();
        }

        return $output;
    }

    public function getOneComCarDetails($regNumber, $getChassis, $user_kms, $riDataOnlyOK = false, $ukRegOk = false, $apiUser = null)
    {
        $vehicleData = array();
        $vehicleData = RegistrationService::getBOIRiDataResults($regNumber, $getChassis); // to get data from verisk and format the same in model
        if (empty($vehicleData['code']) || RegistrationService::isUKRegPlate($regNumber)) {

            if (!$riDataOnlyOK || (RegistrationService::isUKRegPlate($regNumber) && !$ukRegOk)) {
                $out = $this->getApiMessage('ERROR', 'Couldn\'t get the car data for this registration:' . $regNumber,  'Couldn\'t get the car data for this registration', array());
                echo $out;
                exit;
            } else {
                $this->getRIOnlyVehicleData($vehicleData, $apiUser);
                //we wil return RI data only without validation - OK for i.e. lmop website
            }
        }

        $trace['returnedCodeNumber'] = $returnedCodeNumber = $vehicleData['code'];

        //MW Link files
        // if the codenumber returned by RI is not the core model we will look yp the right code in the links files and use it right code to make teh valueation.
        $returnedCodeNumber = $this->indicator24Check($returnedCodeNumber);

        $trace['mtpCode'] = $returnedCodeNumber;
        if (!empty(RegistrationService::getCarYear($regNumber))) {
            $vehicleData['year'] = RegistrationService::getCarYear($regNumber);
        }

        if (!RegistrationService::isValidYear($vehicleData)) {
            $this->getBOIRIOnlyVehicleData($vehicleData, $apiUser);
        }

        if (!empty($returnedCodeNumber) && RegistrationService::isValidYear($vehicleData)) {
            // najpierw szukamy core jesli core jest pusty to commercial
            $model = RegistrationService::getCarCommModel("UsedCarsModel", $returnedCodeNumber);
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            if (empty($model)) {
                if (!RegistrationService::isMPVorOtherNonCommercialBody($vehicleData['body'])) {
                    // search commercial
                    $model = RegistrationService::getCarCommModel("UsedComCarsModel", $returnedCodeNumber);
                    $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model);
                    $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model);
                }
            } else {
                // search cars
                $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model);
                $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model);
            }
            $vehicleKms = array("kmsForYear" => RegistrationService::getFieldValueForYear("kms", $vehicleData['year'], $model));
            // jesli $vehicleKms="" to znaczy ze w bazie nie jest uzupelniony rok dla tego samochodu (rok ktory zwraca RI)
        } else {
            $model = null;
            $main_coreWithAssociatedCarsModel = array();
            $rest_coreWithAssociatedCarsModel = array();
            $vehicleKms = array("kmsForYear" => "");
        }
        $vehicleYear = $vehicleData['year'];
        $vehicle = array_merge($vehicleData, $vehicleKms);

        $calculatedCustomValue  = null;
        if (!empty($user_kms)) {
            $userKm = (empty($user_kms)) ? $vehicleKms : $user_kms;
            $userGuideKm = $userKm;
            $skipCalc = false;
            $calculatedMain_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($main_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
            $calculatedRest_coreWithAssociatedCars = RegistrationService::odometerCalculationByRegLookUp($rest_coreWithAssociatedCarsModel, $userGuideKm, $vehicleYear, $skipCalc);
            $selectedModel = (empty($model)) ? "UsedComCarsModel" : "UsedCarsModel";
            $checkedAllCheckboxes = (!empty($_POST['checkedAllCheckboxes'])) ? $_POST['checkedAllCheckboxes'] : null;
            $grpCustomValeResult = (!empty($_POST['customValueGrp'])) ? $_POST['customValueGrp'] : null;
            //andjusted values end
        } else {
            $calculatedMain_coreWithAssociatedCars = array();
            $calculatedRest_coreWithAssociatedCars = array();
            $checkedAllCheckboxes = (!empty($_POST['checkedAllCheckboxes'])) ? $_POST['checkedAllCheckboxes'] : null;
            $grpCustomValeResult = (!empty($_POST['customValueGrp'])) ? $_POST['customValueGrp'] : null;
        }

        $selectedModel = self::$PARAM_USED_CARS_MODEL;
        $params = array(
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
            'regNumber' => $regNumber
        );

        $bestMatchedCarReturnDetails = array();
        $bestMatchedCarReturnDetails = RegistrationService::getBestMatchedCar($params);
        $car = $bestMatchedCarReturnDetails['car'];

        if (empty($car)) {
            $oneCarResults['car']  = null;
            $oneCarResults['vehicle'] = $vehicle;
            $oneCarResults['adjustedValue'] = null;
            $oneCarResults['returnKms'] = null;
            if (!empty($bestMatchedCarReturnDetails['info'])) {
                if (!empty($bestMatchedCarReturnDetails['info']['msg'])) {
                    $oneCarResults['msg'] = $bestMatchedCarReturnDetails['msg'];
                } else {
                    $oneCarResults['msg'] = 'Unknown error: RSC1851';
                }
            } else {
                $oneCarResults['msg'] = 'Unknown error: RSC1854';
            }
            return $oneCarResults;
            exit;
        }

        $adjustedValue = null;
        $info = $car->getValueAndKmsForYear($vehicle['year']);
        $returnKms = $info['kms'] * 1000;
        if (!empty($user_kms)) {
            $import = Import::getLastImportData();
            $input = array();
            $kms =  $user_kms / 1000;
            $input['km'] = $kms;
            $input['year'] = $vehicle['year'];
            $input['fuel'] = $car['fuel'];
            $input['guide'] = $info['value']; // ze znakiem euro
            $input['guideKm'] = $info['kms']; // km z tabeli
            $input['import'] = $import->id;
            $input['codenumber'] = $car['codenumber'];
            $input['carOrCom'] = 'UsedCarsModel';
            $adjustedValueArray = UsedCars::odometerCalculation($input);
            $adjustedValue = $adjustedValueArray['adjustedValue'];
            $returnKms = (string)$user_kms;
        }

        $oneCarResults['car']  = $car;
        $veriskCode = isset($vehicle['code']) ? strtolower($vehicle['code']) : '';
        $dbcarCode =  isset($car->codenumber) ? strtolower($car->codenumber) : '';
        if (isset($veriskCode) && isset($dbcarCode) && $veriskCode !== $dbcarCode) {
            $vehicle['code'] = $dbcarCode; // As discussed db code will be shown
        }

        $oneCarResults['vehicle'] = $vehicle;
        $oneCarResults['adjustedValue'] = $adjustedValue;
        $oneCarResults['returnKms'] = $returnKms;
        $oneCarResults['msg'] = '';
        if (!empty($bestMatchedCarReturnDetails['info'])) {
            if (!empty($bestMatchedCarReturnDetails['info']['msg'])) {
                $oneCarResults['msg'] = $bestMatchedCarReturnDetails['info']['msg'];
            }
        }
        return $oneCarResults;
    } // end of unified reg lookup

    public function getAssociatedCarsModel($returnedCodeNumber)
    {
        $model = RegistrationService::getCarCommModel("UsedCarsModel", $returnedCodeNumber);
        if (empty($model)) {
            $model = RegistrationService::getCarCommModel("UsedComCarsModel", $returnedCodeNumber);
            if (empty($model)) {
                $model = null;
                $main_coreWithAssociatedCarsModel = array();
                $rest_coreWithAssociatedCarsModel = array();
                $vehicleKms = array("kmsForYear" => "");
            } else {
                $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model);
                $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedComCarsModel", $model);
            }
        } else {
            $main_coreWithAssociatedCarsModel = RegistrationService::getMain_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model);
            $rest_coreWithAssociatedCarsModel = RegistrationService::getRest_AllCoreWithAssociatedCarsModel("UsedCarsModel", $model);
        }


        $data    =   array(
            'model'                             =>  $model,
            'main_coreWithAssociatedCarsModel'  =>  $main_coreWithAssociatedCarsModel,
            'rest_coreWithAssociatedCarsModel'  =>  $rest_coreWithAssociatedCarsModel
        );

        return $data;
    }

    /**
     * User Licence verifications
     * Developer Mukhpal Singh
     * Last developed 30 sept,2022
     */
    public function checkLicence($type = null)
    {
        $licence        =   Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_CARS);
        $licenceComm    =   Uzytkownik::model()->checkExpirationDate(Uzytkownik::PARAM_USED_COMMERCIAL);

        switch ($type) {
            case "commercial":
                if (!$licenceComm) {
                    echo $this->getExpireHTML('commercial');
                    exit;
                }
                break;
            case "passenger":
                if (!$licence) {
                    echo $this->getExpireHTML('cars');
                    exit;
                }
                break;
            default:
                if (!$licence && !$licenceComm) {
                    echo $this->getExpireHTML('cars');
                    exit;
                }
        }
    }

    /**
     * Expire Licence Message HTML
     * Developer Mukhpal Singh
     * Last developed 30 sept,2022
     */
    public function getExpireHTML($cars = "cars")
    {
        $cars = ($cars != "cars") ? "commercial" : "cars";
        $html = '<div class="license-expire">Oops! Seems that your licence for using ' . $cars . ' search is expired. <br>'
            . 'Please contact our office <br>on<br><a href="tel:018775460">01-8775460</a><br>or<br>'
            . '<a href="mailto:info@mtp.ie">info@mtp.ie</a><br>'
            . 'so we can get you motoring again.</div>'
            . '<div class="focusmobile_regscreen">
            <div class="btn_back btn_centre button-square">
          <button class="buttonBack" onclick="goUp()"  id="carGo" data-role="button" data-shadow="false" data-iconpos="notext" data-theme="none">
            <span><img src="images/mobile/previous.svg" class="img-fluid"/></span>
          </button>
        </div> </div>';
        return $html;
    }
}
