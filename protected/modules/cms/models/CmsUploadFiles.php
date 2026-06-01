<?php

define('NO_FILE','NO_FILE');
/**
 * This is the model class for table "pl_cms_upload_files".
 *
 * The followings are the available columns in table 'pl_cms_upload_files':
 * @property integer $id
 * @property string $title
 * @property string $file
 * @property string $folder
 * @property string $link
 * @property integer $order
 */
class CmsUploadFiles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsUploadFiles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_upload_files';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order', 'numerical', 'integerOnly'=>true),
			array('title, uploadedFile, folder', 'length', 'max'=>500),
			array('linkToFile', 'length', 'max'=>900),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, uploadedFile, folder, linkToFile, order', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
            if(Yii::app()->params['admin_lang'][1] == 'pl'){
		return array(
			'id' => 'ID',
			'title' => 'Tytuł',
			'uploadedFile' => 'Plik',			
			'linkToFile' => 'Link',
			'order' => 'Kolejność',
                        'folder' => 'Folder',
		);
            }else{
        		return array(
			'id' => 'ID',
			'title' => 'Title',
			'uploadedFile' => 'File',			
			'linkToFile' => 'Link',
			'order' => 'Order',
                        'folder' => 'Folder',
		);
            }
	}

	/**
	 * zwraca tablice typow bazodanowych
	 */
//	public function inputTypes()
//	{                      
//            $order_first = CmsDictionary::model()->dictionaryGetText('order_first');
//            $order_last = CmsDictionary::model()->dictionaryGetText('order_last');
//
//		return array(
//			'id' => array('type'=>'hidden'),
//			'title' => array('type'=>'varchar'),
//                        'linkToFile' => array('type'=>'varcharLinkToFile'),						
//                        'uploadedFile' => array('type'=>'file', 'folder_name'=>'./files/'),
//			'order' => array('type'=>'order', 'value_list'=>array(0=>$order_first, 999999=>$order_last)),
//                        'folder' => array('type'=>'hidden'),                        
//		);
//	}
                
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('uploadedFile',$this->file,true);
		$criteria->compare('folder',$this->folder,true);
		$criteria->compare('linkToFile',$this->link,true);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        public function uploadFile($path){
            $model = new CmsUploadFiles;
            $fileName=CUploadedFile::getInstance($model,'uploadedFile');
            
            if(empty($fileName)){ return NO_FILE; }
            else{
                $NewfileName = CmsPage::model()->createURL($fileName);
                $fileName->saveAs($path.$NewfileName); //false = nie usuwa z tempa
                return $NewfileName;
            }
        }
        
        public function deleteFile($path){
            
        }
}