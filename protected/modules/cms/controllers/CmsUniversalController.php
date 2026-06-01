<?php

class CmsUniversalController extends CmsController
{
	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='universal_element_column_back';
 
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
				'actions'=>array('index','view','ViewUniversalElement'),
				'users'=>array('*'),
			),

			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','elements','modelElement','deleteElement','order','addPicture','pictureManage','deletePicture',
                                                 'gallery_addPicture','gallery_pictureManage','gallery_deletePicture','gallery_updateGalleryPicture','orderGallery'),
				'users'=>array('admin'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','create','update','delete','elements','modelElement','deleteElement','order','addPicture','pictureManage','deletePicture',
                                                 'gallery_addPicture','gallery_pictureManage','gallery_deletePicture','gallery_updateGalleryPicture','orderGallery'),
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
		$model=new CmsUniversal;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CmsUniversal']))
		{
			$model->attributes=$_POST['CmsUniversal'];
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

		if(isset($_POST['CmsUniversal']))
		{
			$model->attributes=$_POST['CmsUniversal'];
			if($model->save())                           
				$this->redirect(array('view','id'=>$model->id));
		}

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
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CmsUniversal');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CmsUniversal('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CmsUniversal']))
			$model->attributes=$_GET['CmsUniversal'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


	/**
	 * Lista "modeli", elementow universalnych
	 */
	public function actionElements()
	{
            $this->layout='column1';
		//$model=$this->loadModel($id);
                $model = CmsUniversal::model()->findAll();

		$this->render('elements',array(
			'model'=>$model,
		));
	}

	/**
	 *  Elementy wlasciwego modelu (newsy...itp)
	 */
	public function actionModelElement()
	{
                $model_element = $_GET['e'];
                //sprawdz czy model istnieje
                $path_to_model = './protected/modules/cms/models/'.$model_element.'.php';
                if(!file_exists($path_to_model)){
                    //jesli nie istnieje
                    $path_to_model = './protected/modules/cms/models/'.$model_element.'.php';
                    if(!file_exists($path_to_model)){
                        //echo "tu".$path_to_model;
                    //jesli nie istnieje
                        $path_to_model = './protected/modules/GGProduct/models/'.$model_element.'.php';
                        if(!file_exists($path_to_model)){
                    //jesli nie istnieje
                            $path_to_model = './protected/modules/GGProduct/modules/QProduct/models/'.$model_element.'.php';
                            if(!file_exists($path_to_model)){
                    //jesli nie istnieje
                            echo "Model nie istnieje1"; return;
                            }
                        }
                    }  
                }
                /* */
                    include_once './protected/modules/cms/components/PictureManager.php';
                    $pictureManager = new PictureManager();                
                /* */
                    
                if(!file_exists($path_to_model)){
                    //jesli nie istnieje
                    echo "Model nie istnieje"; return;
                }

                $universal_model = CmsUniversal::model()->find('table_name=?', array($model_element));

                    // save i updeate elementow
                    if(isset($_POST[$model_element]))
                    {
                      $id = $_GET['id'];

                        if($id == 0){

                        //nowy wpis do bazy
                            //echo $model_element;
                        $model=new $model_element;
                        $model->setScenario("insert");
                        
//                        echo $model->scenario;
                        //var_dump($model);
                        

                        $model->attributes=$_POST[$model_element];
//var_dump($model->validate());
                        //CREATE
                        switch($model_element){

//                            case 'InputTypes':
//                                echo '<p>case inputTypes<p>';
//                                //$model->id = 15;
//                                //var_dump($model->attributes);
//                                
//                                if($model->save()){  
//                                    print_r($model->getErrors());
//                                    Yii::app()->end();
//                                    die;
//                                    $this->redirect(array('modelElement','e'=>$model_element,'id'=>$model->id,'edit'=>'1'));
//                                }       
//                                echo 'blad';die;
//                                break;
                            
                            case 'CmsLayouts':
                                /* musze wygenerowac plik php z layoutem */
                                $file = 'layout_'.CmsPage::model()->createURL($model->name);
                                $model->fileName = $file;

                                if($model->save()){                                    
                                    $this->redirect(array('modelElement','e'=>$model_element,'id'=>0));
                                }
                                break;
                            
                            case 'CmsMapElements':
                               
                                //TYLKO ELEMENTY MAP
                                //zanim sie zapisze to obrobie zjecie - ikonke do mapy
                                $file_name = $this->AddIco($model, 50, 50);
                                $file_extension = substr($file_name, -3);//zostawia tylko jpg/png/gif

                                if($model->save()){
                                       $order = $model->order;
                                       $db_tbl_name = CmsUniversal::model()->find('table_name=?', array($model_element));
                                       $db_tbl_name = $db_tbl_name['db_tbl_name'];

                                       $orderReturn = CmsPage::model()->GetOrder($model_element, $order, $db_tbl_name);

                                        /*nie wie co i gdzie ma uaktualnic
                                         * na dysku thumba nie ma, ale w zmiennej dalej jest!! dlatego zostanie teraz obrobiony tak,
                                         * aby byl (w bazie) identyko z plikiem na dysku. Potem update pola z ikona */
                                        $file_name = substr($file_name, 0 , 10); //pokaz pierwsze 10 znakow reszta w kosz
                                        $file_name .= '.'.$file_extension; //dodaj rozszerzenie pliku (ma je z getInstance = orginal)

                                        //uaktualnij w bazie
                                        $elements_img = CmsMapElements::model()->find('id=?', array($model->id));
                                        $elements_img->icon_pic = $file_name; //nie thumb
                                        $elements_img->update(array('icon_pic'));

                                        $this->redirect(array('modelElement','e'=>$model_element,'id'=>0));
                                }
                                break;

    default:
        $model->attributes=$_POST[$model_element];
  //  $universal_model
            //$labels = $model_element::model()->attributeLabels();
            //$labels = CActiveRecord::model($model_element)->attributeLabels();

            //$types = $model_element::model()->inputTypes();
    if($_GET['e'] == 'InputTypes'){                
        $types = InputTypes::model()->inputTypesForInputTypes();
    }else{                            
        $types = InputTypes::model()->getInputTypes($_GET['e']);
    }


            //$item = new $model_element;

            if($model->save()){
               if(isset($model->order)){
               $order = $model->order;
               $db_tbl_name = CmsUniversal::model()->find('table_name=?', array($model_element));
               $db_tbl_name = $db_tbl_name['db_tbl_name'];                               
                $orderReturn = CmsPage::model()->GetOrder($model_element, $order, $db_tbl_name);           
               }
               
               foreach($types as $type_key=>$type_value){
//echo ' w foreach '.$type_value['type'].' ';
                   if ($type_value['type']=='image' || $type_value['type']=='def_image'){
                        $model->folder = $model->id;
                        $model->update(array('folder'));
                        
                        if ($type_value['folder_structure']==FOLDER_MAIN){
                            $pictureManager->createMainFolder($type_value['folder_name'].$model->id);
                            $def_pic = $pictureManager->addPicureInMainFolder($model, $type_value['folder_name'].$model->id, $type_value['image_width'], $type_value['image_height'], $type_key);
                        
                            if($def_pic != NO_IMAGE){
                                $model->$type_key = $def_pic;
                                $model->update(array($type_key));
                            }

                        }else {
                            $pictureManager->createMainFolder($type_value['folder_name'].$model->id);
                            foreach($type_value['folder_structure'] as $folder_key=>$folder_val){
                                $pictureManager->createMainFolder($type_value['folder_name'].$model->id.'/'.$folder_key);
                            }                                                        
                                $def_pic = $pictureManager->addPicureInSubFolders($model, $type_value['folder_name'].$model->id, $type_value['folder_structure'], $type_key);
                        }    
                   }
                 if ($type_value['type']=='onlyFolder'){                     
                        $model->folder = $model->id;
                        $model->update(array('folder'));    
                    foreach($type_value['folder_structure'] as $folder_key=>$folder_val){
                        $isIsDefault = $pictureManager->createMainAndSubFolders($type_value['folder_name'].$model->id, $type_value['folder_structure'][0], $type_value['folder_structure'][1]);
                        //tylko 1 raz ma stworzyc folder i sub foldery dlatgo brekiem wyskakuje !!
                             if($isIsDefault != NO_IMAGE){
                                $model->$type_key = $isIsDefault;
                                $model->update(array($type_key));
                            }
                        break;                        
                    }
                 }
                 
                 if($type_value['type']=='file'){
                       $pathToSave = $type_value['folder_name'];
                       $fileName = CmsUploadFiles::model()->uploadFile($pathToSave);
                        if($fileName != NO_IMAGE){
                            $linkToFile = $pathToSave.$fileName;
                            $model->linkToFile = $linkToFile;
                            $model->update(array('linkToFile'));
                            $model->uploadedFile = $fileName;
                            $model->update(array('uploadedFile'));
                        }else{
                            echo NO_IMAGE;
                        }
                   }
                 
               }// end foreach
               
            }else{
                echo 'nie zapisal';
            }
  // print_r($model->getErrors());exit;
        $this->redirect(array('modelElement','e'=>$model_element,'id'=>$model->id,'edit'=>'1'));

    break;

                        } //end switch CREATE
                        
                        }else{// element !=0

//UPDATE
                        switch($model_element){
                            
default:
     $model = CActiveRecord::model($model_element)->find('id=?', array($id));
    if($_GET['e'] == 'InputTypes'){                
        $types = InputTypes::model()->inputTypesForInputTypes();
    }else{                            
        $types = InputTypes::model()->getInputTypes($_GET['e']);
    }
     
//tylko aby pobrac stare zdjecie z bazy            
foreach($types as $type_key=>$type_value){
    if ($type_value['type']=='image' || $type_value['type']=='def_image'){
       $oldPicTmp = $model->$type_key;
    }
}

        $model->attributes=$_POST[$model_element];

           
            if($model->save()){               
               foreach($types as $type_key=>$type_value){
                   if ($type_value['type']=='image' || $type_value['type']=='def_image'){
                        if ($type_value['folder_structure']==FOLDER_MAIN){
                            //$pictureManager->createMainFolder($type_value['folder_name'].$model->folder);
                            if($type_value['type']=='def_image'){
                                if(empty($model->$type_key)){
                                    $model->$type_key = $oldPicTmp;
                                    $model->update(array($type_key));                                    
                                }
                                // usuwa stary default
                                $def_pic = $pictureManager->add_Default_PicureInMainFolder($oldPicTmp, $model, $type_value['folder_name'].$model->id, $type_value['image_width'], $type_value['image_height'], $type_key);                                
                                if($def_pic != NO_IMAGE){
                                    $model->$type_key = $def_pic;
                                    $model->update(array($type_key));
                                }
                            }else{
                                if(empty($model->$type_key)){
                                    $model->$type_key = $oldPicTmp;
                                    $model->update(array($type_key));                                    
                                }
                                $def_pic = $pictureManager->addPicureInMainFolder($model, $type_value['folder_name'].$model->id, $type_value['image_width'], $type_value['image_height'], $type_key);
                                if($def_pic != NO_IMAGE){
                                    echo NO_IMAGE;                                    
                                }                                                                
                            }


                        }else{
                            if($type_value['type']=='def_image'){
                                //usuwa stary default
                                $def_pic = $pictureManager->add_Default_PicureInSubFolders($oldPicTmp, $model, $type_value['folder_name'].$model->id, $type_value['folder_structure'], $type_key);
                                
                                if($def_pic != NO_IMAGE){
                                    $model->$type_key = $def_pic;
                                    $model->update(array($type_key));
                                }//else nie nadpisuje zdjecia   
                            }else{
                                $def_pic = $pictureManager->addPicureInSubFolders($model, $type_value['folder_name'].$model->id, $type_value['folder_structure'], $type_key);                            
                                if($def_pic != NO_IMAGE){
                                    echo NO_IMAGE;                                    
                                }                       
                            }
                        }    
                        
                   }                   
                   
               }// end foreach
               
            }
   
        $this->redirect(array('modelElement','e'=>$model_element,'id'=>$model->id,'edit'=>1));

    break;                            


                            
                            case 'CmsMapElements':
                                /* zanim nastapi update musze! wiedziec jaka ikonka byla wczesniej w bazie
                                 * Potrzebna w przypadku gdy zostanie wykonany update, a nie zostanie dodana nowa ikona (=wtedy pokaze stara)
                                 */
                                $model=new $model_element;

                                //$post=$model_element::model()->findByPk($id);
                                $post = CmsMapElements::model()->find('id=?', array($id));
                                $tempOldIcon = $post['icon_pic'];
                                
                                $post->attributes=$_POST[$model_element]; //nie widzi ikonki!
                                $image=CUploadedFile::getInstance($model,'icon_pic');
                                $file_name = $this->AddIco($model, 50, 50);
                                
                                include_once './protected/modules/cms/components/PictureManager.php';
                                if(empty($image)){                                    
                                    /* usun stara ikonke i zastap defaultowa */
                                        if($tempOldIcon != 'default_GM.png'){                                            
                                            $pictureManager = new PictureManager();

                                            $fullPathWithFileName = './pictures/map_elements/'.$tempOldIcon;
                                            $pictureManager->deleteFolderOrFile($fullPathWithFileName);
                                        }                                                         
                                    $post->save();//wszystko oprocz ikony

                                    $elements_img = CmsMapElements::model()->find('id=?', array($id));
                                    $elements_img->icon_pic = $file_name;//nowa-stara

                                    $elements_img->update(array('icon_pic'));
                                    $this->redirect(array('modelElement','e'=>$model_element,'id'=>$id));
                                }else{                                    
                                    //zostala dodana nowa ikona
                                    //$file_name = $this->AddIco($model, 50, 50); //jest przed if
                                    $file_extension = substr($file_name, -3);//zostawia tylko jpg/png/gif

                                    if($post->save()){

                                            /*nie wie co i gdzie ma uaktualnic
                                             * na dysku thumba nie ma, ale w zmiennej dalej jest!! dlatego zostanie teraz obrobiony tak,
                                             * aby byl (w bazie) identyko z plikiem na dysku. Potem update pola z ikona */
                                            $file_name = substr($file_name, 0 , 10); //pokaz pierwsze 10 znakow reszta w kosz
                                            $file_name .= '.'.$file_extension; //dodaj rozszerzenie pliku (ma je z getInstance = orginal)
                                            
                                            //uaktualnij w bazie
                                            $elements_img = CmsMapElements::model()->find('id=?', array($id));
                                            $elements_img->icon_pic = $file_name; //nie thumb
                                            $elements_img->update(array('icon_pic'));
                                            
                                            if($tempOldIcon != 'default_GM.png'){                                                
                                                $pictureManager = new PictureManager();

                                                $fullPathWithFileName = './pictures/map_elements/'.$tempOldIcon;
                                                $pictureManager->deleteFolderOrFile($fullPathWithFileName);
                                            }
                                            
                                            $this->redirect(array('modelElement','e'=>$model_element,'id'=>$id));
                                    }
                                }//end else
                                break;

                           } //end switch UPDATE

                        }//end else if element != 0




                        
                }// end if(isset($_POST[$model_element]))

                $criteria=new CDbCriteria;                                        
                $criteria->order = '`order`';                
                //$model = $model_element::model()->findAll($criteria);
                $model = CActiveRecord::model($model_element)->findAll($criteria);

                        if(isset($_GET['id']))
                        {

                            $id = $_GET['id'];
                            if($id == 0){
                                //nie potrzeba modelu map/elementow map poniewaz skrypt jest generowany z pliku a on nie potrzebuje danych z bazy
                            }else{
                                $map_model = CmsMap::model()->find('id=?', array($id));

                                if($model_element == 'CmsMap'){
                                        $this->render('modelElement',array(
                                                'model'=>$model,
                                                'universal_model'=>$universal_model,
                                                'map_model'=>$map_model,
                                        ));
                                        exit;
                                }else if($model_element == 'CmsMapElements'){

                                    $map_element_model = CmsMapElements::model()->find('id=?', array($id));
                                        $this->render('modelElement',array(
                                                'model'=>$model,
                                                'universal_model'=>$universal_model,
                                                'map_model'=>$map_model,
                                                'map_element_model'=>$map_element_model,
                                        ));
                                        exit;
                                }//end else if

                            }
                        }
                
               

		$this->render('modelElement',array(
			'model'=>$model,
                        'universal_model'=>$universal_model,                        
		));
	}


	/**
	 *  Widok uniwersalnych elementow (newsy...itp) - Front-end
	 */
	public function actionViewUniversalElement()
	{
                $this->layout = ('universal_element_column');
                
                $model_element = $_GET['e'];

                /* Trzeba sie upewnic czy jest model z elementem! */
                $model_element_file = "./protected/models/".$model_element.".php";
                if( !file_exists($model_element_file) ){
                    echo 'Model '.$model_element.'.php nie istnieje'; return;
                }else{
                    //model istnieje
                    $universal_model = CmsUniversal::model()->find('table_name=?', array($model_element));                    

                    $layout = $universal_model->layout;

                    $view_model = '_view'.$model_element.'_'.$layout;   //example _viewCmsNews

                   // $model = $model_element::model()->findAll();
                    $model = CActiveRecord::model($model_element)->findAll();


                    /* dla konkretnego elementu = id*/
                    if(isset($_GET['id'])){
                        //$model = $model_element::model()->find( 'id=?', array($_GET['id']) );
                        $model = CActiveRecord::model($model_element)->find( 'id=?', array($_GET['id']) );
                    }
//                    else if(!isset($_GET['id'])){
//                        //$model = $model_element::model()->find( 'id=1');
//                        $model = CActiveRecord::model($model_element)->find( 'id=1');
//                    }
//var_dump($model);exit;
                    
                    $this->render('viewUniversalElement',array(
                            'model'=>$model,
                            'universal_model'=>$universal_model,                            
                            'view_model'=>$view_model, //odpowiedni widok
                    ));
                }
	}


        public function actionDeleteElement(){
            /* funkcja usuwa wybrany element po id */
            //echo "usuwam element";

             $model_element = $_GET['e'];
             $id = $_GET['id'];
            
            

            include_once './protected/modules/cms/components/PictureManager.php';
            $pictureManager = new PictureManager();
             /* sklep */
             if($model_element == 'CmsShopProduct' || $model_element == 'CmsShopCategories'){                   
                    $types = InputTypes::model()->getInputTypes($_GET['e']);
                        
                    $path = $types['def_pic']['folder_name'];                                        
                    $pathToFile = $path.$id;
                    $pictureManager->renameFile($pathToFile, '_deleted');
             }
             /* */
             /* Gallery */
             if($model_element == 'CmsGallery'){                   
                    $types = InputTypes::model()->getInputTypes($_GET['e']);
                        
                    $path = $types['image']['folder_name'];                                        
                    $pathToFile = $path.$id;
                    $pictureManager->renameFile($pathToFile, '_deleted');
             }             
             /* */

             if($model_element == 'CmsUploadFiles'){   
                    $pathToFile = CmsPage::model()->getElement('id', $id, $model_element, 'linkToFile');        
                    $pictureManager->deleteFolderOrFile($pathToFile);
             }
             
             //$delete=$model_element::model()->findByPk($id);
             $delete = CActiveRecord::model($model_element)->findByPk($id);
             $delete->delete();             
             
              if($model_element == 'CmsUniversal'){
                  $this->redirect(array('elements','e'=>$model_element,'id'=>0));
              }
              //$model=$this->loadModel($id);
              //$model->delete();
              $this->redirect(array('modelElement','e'=>$model_element,'id'=>0));
              /*
              	$this->render('modelElement',array(
			'model'=>$delete,
		));
               * 
               */
        }


	/**
	 *  Ustawianie kolejnosci na froncie
	 */
	public function actionOrder()
	{
            $this->layout='column1';            
            $model=new CmsPage;
            if(isset($_GET['ord'])) {

                $model_element = $_GET['ord'];
                $model=new $model_element;
                
            }

            if(isset($_GET['id'])) {
                $pid = $_GET['id']; //parent ID             
            }
            
//            if(isset($_GET['ord'])) {
//                switch($_GET['ord']){
//
//                    case 'CmsGallery':
//                        $this->redirect(array('order','ord'=>'CmsGallery','id'=>$pid));
//                        //echo "Asdasd";return;
//                        break;
//                   case 'CmsPage':
//                        $this->redirect(array('order','ord'=>'CmsPage','id'=>$pid));
//                        break;
//                   case 'CmsUniversal':
//                        //echo "ASDASDASDASDASDAS universal model ? =";
//                        $id = $_GET['id'];
//                        $model_universal = CmsPage::model()->findByPk($id);
//                        //echo $model_universal['param_2'];
//                        $this->redirect(array('order','ord'=>$model_universal,'id'=>$id));
//                        break;
//                    default:
//                        $this->redirect(array('order','ord'=>'CmsPage','id'=>$pid));
//                        break;
//                }
//            }
            //$model=$this->loadModel($id);
            
                
                    if(isset($_POST['order'])) {
                        //$model = CmsUniversal::model()->findAll();
                        //$page_model = CmsPage::model()->findAll();
                        //$model = CmsNews::model()->findAll();
//                        $model->attributes=$_POST['CmsNews'];
                        $i=1;
                        foreach($_POST['order'] as $key=>$val){
                            //echo $key."-".$i."<br>";

                            //echo $i."<br>";
                               // $order_elem = $model_element::model()->findByPk($key);
                                $order_elem = CActiveRecord::model($model_element)->findByPk($key);
                                $order_elem->order = $i;

                                $order_elem->update(array('order'));
                            $i++;
                        }

                    }

		$this->render('order',array(
			'model'=>$model,
                        
                        //'model_universal'=>$model_universal,
                        //'page_model'=>$page_model,
                        //'view_model'=>$view_model,
		));
	}
        
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CmsUniversal::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='cms-universal-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


        
        public function AddIco($model_e,$width, $height){
                //zanim sie zapisze to obrobie zjecie - ikonke do mapy
                $image=CUploadedFile::getInstance($model_e,'icon_pic');

                if(empty($image)){
                    //nie zostal dodany obrazek
                    $file_name = 'default_GM.png'; //wazna jest ilosc znakow!
                    return $file_name;
                }else{
                    
                    $file_name = $image;
                    $file_extension = substr($file_name, -3);//zostawia tylko jpg/png/gif

                    $typ = $image->getType();//np. images/jpeg
                    //generuje nazwe pliku
                    $file_name = time().'_thumb.'.$file_extension;


                    if($typ == 'image/jpeg' || $typ == 'image/png' || $typ == 'image/gif'){
                        $image->saveAs('./pictures/map_elements/'.$file_name);
                        $path = './pictures/map_elements/'.$file_name;

                        /* !! TYLKO obrabia na dysku nie ma go w zmiennej (bez _thumb) !! */
                        $img = CmsGallery::model()->ImgResize($width, $height, $path, '');
                            //usuwanie thumba (przed resize) ikonki
                            if (!file_exists($file_name)){

                                $path_m = './pictures/map_elements/'.$file_name.'';
                                unlink($path);                
                            }else{
                                echo "Plik nie istnieje"; return;
                            }
                       return $file_name;
                    }else{
                        echo "Nie mozna dodac zdjecia (ikonki) do mapy"; return;
                    }

                }
        }


        public function AddBanner($model_e,$width, $height){
                //zanim sie zapisze to obrobie zjecie
                $image=CUploadedFile::getInstance($model_e,'image');

                if(empty($image)){
                    //nie zostal dodany obrazek
                    echo 'obrazek nie zostal dodany';
                }else{
                    $file_name = $image;
                    $file_extension = substr($file_name, -3);//zostawia tylko jpg/png/gif

                    $typ = $image->getType();//np. images/jpeg
                    
                    //generuje nazwe pliku
                    $file_name = time().'_thumb.'.$file_extension;


                    if($typ == 'image/jpeg' || $typ == 'image/png' || $typ == 'image/gif'){                        
                        $image->saveAs('./pictures/banner/'.$file_name);
                        $path = './pictures/banner/'.$file_name;          
                        // funkcja z galerii

                        /* !! TYLKO obrabia na dysku nie ma go w zmiennej (bez _thumb) !! */
                        $img = CmsGallery::model()->ImgResize($width, $height, $path, '');
                            //usuwanie thumba (przed resize) 
                            if (!file_exists($file_name)){

                                $path_m = './pictures/banner/'.$file_name.''; //thumb
                                unlink($path);

                            }else{
                                echo "Plik nie istnieje"; return;
                            }

                    }else if($typ == 'application/x-shockwave-flash'){

                        $file_flash = substr($file_name, 0, -10);//usuwa _thumb.swf
                        $file_flash = $file_flash.'.'.$file_extension;
                        
                        $image->saveAs('./pictures/banner/'.$file_flash);                                                            
                        return $file_flash;
      
                    }else{
                        echo "Nie mozna dodac baneru"; return;
                    }

                }
        }



        /* Uniwersalne akcje dodawania,zarzadzania i usowania zdjecia */
    public function actionAddPicture()
	{
        $this->layout='column2';
                /* */
                    include_once './protected/modules/cms/components/PictureManager.php';
                    $pictureManager = new PictureManager();                
                /* */
                    
                        $id = $_GET['id'];
                        $model_element = $_GET['e'];                        
                        $model=new $model_element;

                         $criteria = new CDbCriteria;
                         $criteria->select = '*';
                         $criteria->compare('`id`', $id);
                         $model = CActiveRecord::model($model_element)->find($criteria);

		if(isset($_POST[$model_element]))
		{
                            $types = InputTypes::model()->getInputTypes($_GET['e']);                                                      
                            foreach($types as $key=>$value){          
                                if($key == 'image' || $key == 'def_pic'){
                                    $dbField = $key;
                                }
                            }
                            $mainPath = $types[$dbField]['folder_name'];                    
                    
                        $TEMP_oldDefault = $model->$dbField;
                        
                        
			$model->attributes=$_POST[$model_element];
              
                            $rozmiarSmall = CmsUniversal::model()->getImageSize('image', 'small');
                            $rozmiarLarge = CmsUniversal::model()->getImageSize('image', 'large');                            
                            
                        /* Mariusz nowe */
                        if(isset($_GET['def'])){
                            
                            $folderList = array('d'=>array('image_width'=>$rozmiarLarge['width'], 'image_height'=>$rozmiarLarge['height']),'m'=>array('image_width'=>$rozmiarSmall['width'], 'image_height'=>$rozmiarSmall['height']));
                            $def_pic = $pictureManager->add_Default_PicureInSubFolders($model->$dbField, $model, $mainPath.$model->id, $folderList, $dbField); //image pole formularza z ktorego jest wysylane zdjecie
                                                        
                            //usun stary obrazek z dysku
                            if(!empty($TEMP_oldDefault)){                                
                                $this->actionDeletePicture();
                            }
                            
                            if($def_pic == NO_IMAGE){
                                //echo "Nie wybrano zdjęcia";
                                $this->redirect(array('addPicture','e'=>$model_element,'id'=>$model->id,'img'=>'empty','def'=>'0'));
                            }
                            $model->$dbField = $def_pic;
                            $model->update(array($dbField));                            
                            $this->redirect(array('pictureManage','e'=>$model_element,'id'=>$model->id,'img'=>'empty','delete'=>'0'));
                        }else{
                            $folderList = array('d'=>array('image_width'=>$rozmiarLarge['width'], 'image_height'=>$rozmiarLarge['height']),'m'=>array('image_width'=>$rozmiarSmall['width'], 'image_height'=>$rozmiarSmall['height']));
                            $picture = $pictureManager->addPicureInSubFolders($model, $mainPath.$model->id, $folderList, $dbField);
                            Yii::app()->user->setState('infoMsg', 'Dodano zdjęcie.');
                            if($picture == NO_IMAGE){
                                //echo "Nie wybrano zdjęcia";
                                $this->redirect(array('addPicture','e'=>$model_element,'id'=>$model->id,'img'=>'empty'));
                            }
                        }
                }

                //renderuje strone z formularzem
		$this->render('addPicture',array(
			'model'=>$model,                        
		));
	}



	public function actionPictureManage()
	{
        /* pokazuje wszystkie zdjecia
         */
            $this->layout='column2';
                $id = $_GET['id'];
                $model_element = $_GET['e'];                        

                $model=new $model_element;

                 $criteria = new CDbCriteria;
                 $criteria->select = '*';
                 $criteria->compare('`id`', $id);                 
                 $model = CActiveRecord::model($model_element)->find($criteria);
                 
		$this->render('pictureManage',array(
			'model'=>$model,
		));
	}


        
	public function actionDeletePicture()
	{
            /* funkcja usuwa zdjecia z folderow "/d" i "/m"
             */
            $this->layout='column2';
                    include_once './protected/modules/cms/components/PictureManager.php';
                    $pictureManager = new PictureManager();                
                /* */         
                        $id = $_GET['id'];
                        $model_element = $_GET['e'];                        
                        $DbField = '';

                        $types = InputTypes::model()->getInputTypes($_GET['e']);                                                    
                        foreach($types as $key=>$value){          
                            if($key == 'image' || $key == 'def_pic'){
                                $DbField = $key;
                            }
                        }
                        $path = $types[$DbField]['folder_name'];                                                
                        
                        $model=new $model_element;

                 $criteria = new CDbCriteria;
                 $criteria->select = '*';
                 $criteria->compare('`id`', $id);                 
                 $model = CActiveRecord::model($model_element)->find($criteria);

                 if( isset($_GET['delete']) && $_GET['delete'] != ''){
                     //zwykle zdjecie z pictureManagera
                    $delete_file = '0';               
                    $delete_file = $_GET['delete'];
                
                    $pictureManager->deleteFolderOrFile($path.$model->id.'/m/'.$delete_file);
                    $pictureManager->deleteFolderOrFile($path.$model->id.'/d/'.$delete_file);
                    if($delete_file == $model->$DbField){
                        //default trzeba zrobic update w bazie
                        $model->$DbField = '';
                        $model->update(array($DbField));   
                    }
                 }else if( isset($_GET['def']) && $_GET['def'] == 0){
                     //default z picture managera                     
                    $delete_file = $model->$DbField;
                     
                    $pictureManager->deleteFolderOrFile($path.$model->id.'/m/'.$delete_file);
                    $pictureManager->deleteFolderOrFile($path.$model->id.'/d/'.$delete_file);
                    if($delete_file == $model->$DbField){
                        //default trzeba zrobic update w bazie
                        $model->$DbField = '';
                        $model->update(array($DbField));   
                    }                                          
                 }else{
                    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
                 }                                       

		$this->render('pictureManage',array(
			'model'=>$model,
		));
	}
        /*-----------------------*/

        /* universal gallery actions */
	public function actionGallery_pictureManage()
	{
        /* pokazuje wszystkie zdjecia
         */
            $this->layout='column2';
                        $id = $_GET['id'];
                        $model_element = 'CmsGallery';
                        //$universal_model = CmsUniversal::model()->find('table_name=?', array($model_element));

                        $model=new $model_element;

                 $criteria = new CDbCriteria;
                 $criteria->select = '*';
                 $criteria->compare('`id`', $id);
                 //$model = $model_element::model()->find($criteria);
                 $model = CActiveRecord::model($model_element)->find($criteria);
                 
		$this->render('gallery_pictureManage',array(
			'model'=>$model,
		));
	}
        
    public function actionGallery_addPicture()
	{
            $this->layout='column2';
                /* */
                    include_once './protected/modules/cms/components/PictureManager.php';
                    $pictureManager = new PictureManager();                
                /* */
                    
                        $id = $_GET['id'];
                        $model_element = 'CmsGallery';
                        //$universal_model = CmsUniversal::model()->find('table_name=?', array($model_element));

                        $model=new $model_element;

                         $criteria = new CDbCriteria;
                         $criteria->select = '*';
                         $criteria->compare('`id`', $id);
                         //$model = $model_element::model()->find($criteria);
                         $model = CActiveRecord::model($model_element)->find($criteria);

                         $modelGalleryPicture=new CmsGalleryPicture;
                         
		if(isset($_POST[$model_element]))
		{                    

			$model->attributes=$_POST[$model_element];
              
                            $rozmiarSmall = CmsGallery::model()->getImageSize('image', 'small');
                            $rozmiarLarge = CmsGallery::model()->getImageSize('image', 'large');
                            
                        $types = InputTypes::model()->getInputTypes('CmsGallery');
                        $path = $types['image']['folder_name'];
                        
                        if(isset($_GET['def'])){
                            //$default = $_GET['def'];
                            $folderList = array('d'=>array('image_width'=>$rozmiarLarge['width'], 'image_height'=>$rozmiarLarge['height']),'m'=>array('image_width'=>$rozmiarSmall['width'], 'image_height'=>$rozmiarSmall['height']));
                            $def_pic = $pictureManager->add_Default_PicureInSubFolders($model->image, $model, $path.$model->folder, $folderList, 'image'); //image pole formularza z ktorego jest wysylane zdjecie
                            if($def_pic == NO_IMAGE){
                                //echo "Nie wybrano zdjęcia";
                                $this->redirect(array('gallery_addPicture','e'=>$model_element,'id'=>$model->id,'img'=>'empty','def'=>'0'));
                            }
                            $model->image = $def_pic;
                            $model->update(array('image'));
                            
                            /* dodaj do CmsGalleryPicture wpis */
                                if(CmsGallery::model()->getGalleryMode() == 1){
                                    $modelGalleryPicture->attributes=$_POST['CmsGalleryPicture'];
                                    /* update takze w tabeli cms_gallery_picture */
                                    $modelGalleryPicture->image = $def_pic;
                                    $modelGalleryPicture->parent_id = $model->id;
                                    //$modelGalleryPicture->link = $model->link;
                                    //$modelGalleryPicture->link_title = $model->link_title;
                                    //$modelGalleryPicture->link_position = $model->link_position;
                                    //$modelGalleryPicture->text = $model->text;
                                    $modelGalleryPicture->order = 0;
                                    $modelGalleryPicture->save();                                    
                                    $orderRetPic = CmsPage::model()->GetOrder($model, $modelGalleryPicture->order, 'cms_gallery_picture');
                                }else{
                                    $modelGalleryPicture->attributes=$_POST['CmsGalleryPicture'];
                                    /* update takze w tabeli cms_gallery_picture */
                                    $modelGalleryPicture->image = $def_pic;
                                    $modelGalleryPicture->parent_id = $model->id;
                                    $modelGalleryPicture->order = $model->order;
                                    $modelGalleryPicture->save();
                                    $order = $model->order;
                                    $orderRetPic = CmsPage::model()->GetOrder($model, $order, 'cms_gallery_picture');
                                }                            
                            
                            $this->redirect(array('gallery_pictureManage','e'=>$model_element,'id'=>$model->id,'delete'=>'0'));
                        }else{
                            $folderList = array('d'=>array('image_width'=>$rozmiarLarge['width'], 'image_height'=>$rozmiarLarge['height']),'m'=>array('image_width'=>$rozmiarSmall['width'], 'image_height'=>$rozmiarSmall['height']));
                            $picture = $pictureManager->addPicureInSubFolders($model, $path.$model->folder, $folderList, 'image');

                            if($picture == NO_IMAGE){
                                //echo "Nie wybrano zdjęcia";
                                $this->redirect(array('gallery_addPicture','e'=>$model_element,'id'=>$model->id,'img'=>'empty'));
                            }   
                            
                                if(CmsGallery::model()->getGalleryMode() == 1){
                                    $modelGalleryPicture->attributes=$_POST['CmsGalleryPicture'];
                                    /* update takze w tabeli cms_gallery_picture */
                                    $modelGalleryPicture->image = $picture;
                                    $modelGalleryPicture->parent_id = $model->id;
                                    //$modelGalleryPicture->link = $model->link;
                                    //$modelGalleryPicture->link_title = $model->link_title;
                                    //$modelGalleryPicture->link_position = $model->link_position;
                                    //$modelGalleryPicture->text = $model->text;
                                    $modelGalleryPicture->order = 0;
                                    $modelGalleryPicture->save();                                    
                                    $orderRetPic = CmsPage::model()->GetOrder($model, $modelGalleryPicture->order, 'cms_gallery_picture');
                                }else{
                                    $modelGalleryPicture->attributes=$_POST['CmsGalleryPicture'];
                                    /* update takze w tabeli cms_gallery_picture */
                                    $modelGalleryPicture->image = $picture;
                                    $modelGalleryPicture->parent_id = $model->id;
                                    $modelGalleryPicture->order = $model->order;
                                    $modelGalleryPicture->save();
                                    $order = $model->order;
                                    $orderRetPic = CmsPage::model()->GetOrder($model, $order, 'cms_gallery_picture');
                                }                            
                            $this->redirect(array('gallery_addPicture','e'=>$model_element,'id'=>$model->id));
                        }
                        
         
                }

                //$this->redirect(array('addPicture','e'=>$model_element,'id'=>$id));
//$model=new $model_element;
                //renderuje strone z formularzem
		$this->render('gallery_addPicture',array(
			'model'=>$model, 
                        'modelGalleryPicture'=>$modelGalleryPicture,
		));
	}        
        
	public function actionGallery_deletePicture()
	{
            $this->layout='column2';
                    include_once './protected/modules/cms/components/PictureManager.php';
                    $pictureManager = new PictureManager();                
                       
                        $id = $_GET['id'];
                        $model_element = 'CmsGallery';
                        //$universal_model = CmsUniversal::model()->find('table_name=?', array($model_element));

                        $types = InputTypes::model()->getInputTypes('CmsGallery');
                        $path = $types['image']['folder_name'];
                        
                        $model=new $model_element;

                 $criteria = new CDbCriteria;
                 $criteria->select = '*';
                 $criteria->compare('`id`', $id);
                 //$model = $model_element::model()->find($criteria);
                 $model = CActiveRecord::model($model_element)->find($criteria);

                                          
                //$mainFolder = CmsUniversal::model()->getModelNameAndGenerateFolder($model_element);

                $delete_file = '0';
                $delete_file = $_GET['delete'];
                
                $pictureManager->deleteFolderOrFile($path.$model->folder.'/m/'.$delete_file);
                $pictureManager->deleteFolderOrFile($path.$model->folder.'/d/'.$delete_file);
                if($delete_file == $model->image){
                    //default trzeba zrobic update w bazie
                    $model->image = '';
                    $model->update(array('image'));   
                }

                /* usun wpisy w CmsGalleryPicture */                
                  $gpIdElement = CmsGalleryPicture::model()->find('image=?',array($delete_file));                
                  $modelGalleryPicture=CmsGalleryPicture::model()->find('id=?',array($gpIdElement->id));
                  $modelGalleryPicture->deelte();
                
		$this->render('gallery_pictureManage',array(
			'model'=>$model,
		));
	}
        
        
        
        public function actionGallery_updateGalleryPicture(){
            /* funkcja tylko uaktualnia dane w tabeli cms_gallery_picture dla konkretnego elementu */
/* STARA BEZ PICTURE MANAGERA Mariusza */            
            $Updatephoto = $_GET['upd'];           
            $this->layout = ('none');          

            $modelGalleryPicture=CmsGalleryPicture::model()->find('image=?',array($Updatephoto));
            /* Update */
            if(isset($_POST['CmsGalleryPicture'])){
                
                $modelGalleryPicture->attributes=$_POST['CmsGalleryPicture'];
                $tmp_img = $Updatephoto;
                
                if(isset($_GET['def'])){
                    if($_GET['def'] == 'default'){         
                        
                        $image=CUploadedFile::getInstance($modelGalleryPicture,'image');                       
                        if(!empty($image)){//mam defaulta
                            
                            $folder = $modelGalleryPicture->parent_id;
                            //trzeba usunac stary domyslny obrazek bo zaraz bedzie nowy  
                            
                        $types = InputTypes::model()->getInputTypes('CmsGallery');
                        $path = $types['image']['folder_name'];       
                        
                                if (!file_exists($tmp_img)){
                                    $path_m = $path.$folder.'/m/'.$Updatephoto.'';
                                    unlink($path_m);

                                    $path_d = $path.$folder.'/d/'.$Updatephoto.'';
                                    unlink($path_d);
                                }else{
                                    echo "Plik nie istnieje"; return;
                                }
                                
                            $file_name = $image;
                                    
                            $file_extension = substr($file_name, -3);//zostawia tylko jpg/png/gif
                            $typ = $image->getType();//np. images/jpeg
                            
                            $tmp_img = substr($tmp_img,0,-4);//bez ost 4znakow (z kropka)
                            //generuje nazwe pliku
                            $file_name = $tmp_img.'_thumb.'.$file_extension;


                            if($typ == 'image/jpeg' || $typ == 'image/png' || $typ == 'image/gif'){
                                //zapisuje 2 thumby
                                //if(file_exists($folder)){
                                $image->saveAs($path.$folder.'/m/'.$file_name,false); //false = nie usuwa z tempa
                                $image->saveAs($path.$folder.'/d/'.$file_name);

                                $path_m = $path.$folder.'/m/'.$file_name;
                                $path_d = $path.$folder.'/d/'.$file_name;

                                $img = CmsGallery::model()->ImgResize(231, 200, $path_m, 'm'); //defaultowe m
                                $img = CmsGallery::model()->ImgResize(800, 600, $path_d, 'd'); //defaultowe d
                                /* */
                                //}

                             
                                /* zapis w cms_gallery */
                                    $main_gallery_image = CmsGallery::model()->findByPk($modelGalleryPicture->parent_id);
                                    $main_gallery_image->image = $img;
                                    $main_gallery_image->update(array('image'));                        
                                    
                                    //usuwanie thumba m i d
                                    $types = InputTypes::model()->getInputTypes('CmsGallery');
                                    $path = $types['image']['folder_name'];                                     
                                    if (!file_exists($file_name)){
                                        $path_m = $path.$folder.'/m/'.$file_name.'';
                                        unlink($path_m);

                                        $path_d = $path.$folder.'/d/'.$file_name.'';
                                        unlink($path_d);
                                    }else{
                                        echo "Plik nie istnieje"; return;
                                    }
                                    
                            $modelGalleryPicture->save();
                            /* zapis w cms_gallery_picture */
                                $galleryPicture_image = CmsGalleryPicture::model()->findByPk($modelGalleryPicture->id);
                                //$galleryPicture_image=CmsGalleryPicture::model()->find('image=?',array($tmp_img));
                                $galleryPicture_image->image = $img;
                                $galleryPicture_image->update(array('image')); 

                                //przeladowanie popupu. Z nowymi danymi!  
                                //redirect obowiazkowy!
                                $this->redirect(array('gallery_updateGalleryPicture','upd'=>$img,'id'=>$_GET['id'],'def'=>$_GET['def'],'refresh'=>'1'));

                            }
                        }
                    }
                }
                $modelGalleryPicture->image = $Updatephoto; //inaczej nowy default bedzie pusty
                $modelGalleryPicture->save();                   
            }
            
            
                            $this->render('gallery_updateGalleryPicture',array(                                    
                                    'modelGalleryPicture'=>$modelGalleryPicture,
                            ));
        }        

        public function actionOrderGallery() { /* TESTY */
            /* dostaje poorderowane zdjecia i zmienia na nowo nazwy plikow */
            if(isset($_GET['id'])) {
                $id = $_GET['id']; //parent ID           
                $model_element = $_GET['e'];                
                //$modelEL=new $model_element;
                
                $model = CActiveRecord::model($model_element)->find('id=?', array($id));
var_dump($_POST);exit; //kolejnosc jest OK
                    if(isset($_POST['order'])) {                        

                            /* wczytaj wszystkie pliki z folderu */
                            $directory_m = 'gallery/'.$model->folder.'/m';
                            $directory_d = 'gallery/'.$model->folder.'/d';                                                
                            /* -- */
                           
                        /* */
                            include_once './protected/modules/cms/components/PictureManager.php';
                            $pictureManager = new PictureManager();
                        /* */
//echo '<p>';                            
var_dump($_POST['order']);
echo '<p>--------------<p>';
                        $i=1;
                        foreach($_POST['order'] as $key=>$val){
                              $nowyPlik = $key;
                              //$nowyPlik.' plik > ';//nowy uklad
                              //$plikiZdysku[$i].'<p>';//stary uklad
//echo $val;exit;
                                if(file_exists($directory_m)){
                                    $dir = opendir($directory_m); //otworzenie folderu
                                }else{ echo "Nie znaleziono folderu, przepraszamy."; return; }
                                
                                $doSortowania = array();
                                while($pliki = readdir($dir)){
                                    $doSortowania[] .= $pliki;
                                }                      
                                //asort($doSortowania);                                                                    
var_dump($doSortowania);
                                //while($plik_nazwa = readdir($dir)){ //odczytywanie                                
                                foreach ($doSortowania as $plik_nazwa){
                                    if(($plik_nazwa!=".")&&($plik_nazwa!="..")){                                    
echo $plik_nazwa.'<p>';                                            
                                            $plik_nazwaCUT = substr($plik_nazwa, -14); //zostawi 14 znakow LICZAC OD KONCA (time().jpg)
                                            $nowyPlik = substr($nowyPlik, -14); //bez numerka na poczatku pliku
echo $nowyPlik .' VS '.$plik_nazwaCUT.'<p>';
                                            if($nowyPlik == $plik_nazwaCUT){
                                            //    $nowyPlik = $plik_nazwa;
echo 'W nowyplik == pliknazwaCUT<p>';                                                
                                                /* NIE ROB NIC Z DEFAULTEM */
                                                if($model->image == $nowyPlik){
                                                    $i++;
                                                    continue;
                                                }
                                                
                                                  $nowyPlik = $i.'_'.$nowyPlik;//numeruje
                                                  $staryPlik = $plik_nazwa; // ma numerek bo leci z dysku nie jest CUT

                                                  $old_File_Path_m = $directory_m.'/'.$staryPlik;
                                                  $old_File_Path_d = $directory_d.'/'.$staryPlik;

                                                  $fullPathWithFileName_m = $directory_m.'/'.$nowyPlik;
                                                  $fullPathWithFileName_d = $directory_d.'/'.$nowyPlik;
                    echo $old_File_Path_m.' NewPATH: '.$fullPathWithFileName_m.'<p>';
                                                $i++;
                                            }else{ continue; }

                                        }
                                        
                                }//end foreach   
                                echo '<p>2gi obieg petli<p>';                            
                        }
                        exit;
                    }
                
            }		
                if($_GET['e'] == 'CmsGallery'){
                    $this->redirect(Yii::app()->baseUrl.'/index.php?r=cmsUniversal/gallery_pictureManage&id='.$id.'&delete=0');
                }
            
        }        
        
        /* end gallery */
        
   
  

  
}
