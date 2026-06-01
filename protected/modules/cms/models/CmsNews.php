<?php

/**
 * This is the model class for table "pl_cms_news".
 *
 * The followings are the available columns in table 'pl_cms_news':
 * @property integer $id
 * @property string $title
 * @property integer $order
 * @property integer $display
 * @property integer $archive
 * @property string $txt
 * @property string $short_txt
 * @property string $_date
 * @property string $image
 * @property string $folder
 *
 * The followings are the available model relations:
 */

define("CAT_FOLDER_MAIN", "main");
//define("FOLDER_MAIN", "main");
class CmsNews extends CmsActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsNews the static model class
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
		return parent::prefixTableName('pl_cms_news');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('_date', 'required'),
			array('order, display, archive', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>300),
			array('image, folder', 'length', 'max'=>700),
			array('txt, short_txt', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, order, display, archive, txt, short_txt, _date, image, folder', 'safe', 'on'=>'search'),
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
            if(Yii::app()->language == 'pl'){
		return array(
			'id' => 'ID',
			'title' => 'Tytuł',
			'order' => 'Kolejność',
			'display' => 'Wyświetlaj',
			'archive' => 'Archiwizuj',
			'txt' => 'Tekst',
			'short_txt' => 'Skrócony tekst',
			'_date' => 'Data dodania',
			'image' => 'Zdjęcie domyślne',
			'folder' => 'Folder',
		);
            }else{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'order' => 'Order',
			'display' => 'Display',
			'archive' => 'Archive',
			'txt' => 'Text',
			'short_txt' => 'Short text',
			'_date' => 'Add date',
			'image' => 'Default picture',
			'folder' => 'Folder',
		);
            }
	}

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
		$criteria->compare('order',$this->order);
		$criteria->compare('display',$this->display);
		$criteria->compare('archive',$this->archive);
		$criteria->compare('txt',$this->txt,true);
		$criteria->compare('short_txt',$this->short_txt,true);
		$criteria->compare('_date',$this->_date,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('folder',$this->folder,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

        
        public static function getLatestNews(){
             $criteria = new CDbCriteria;
             $criteria->select='*';             
             $criteria->compare('`display`', 1);
             $criteria->order = '`_date` DESC';
             $criteria->limit = 3;
             $result = CActiveRecord::model('CmsNews')->findAll($criteria);
            
            $ile = count($result);
           
            foreach($result as $news){
                echo '<div class="col">';
                    echo '<span class="newsTitle">';
                        echo '<a href="index.php?r=cmsUniversal/viewUniversalElement&&e=CmsNews&&id='.$news['id'].'">'.$news['title'].'</a>';
                    echo '</span>';
                    
                        echo'<div class="newsPicture"><img src="./pictures/news/'.$news['folder'].'/'.$news['image'].'" alt=""></div>';
                        echo $news['txt'];                        
                        echo '<div class="date"><span>'.$news['_date'].'</span><a href="index.php?r=cmsUniversal/viewUniversalElement&&e=CmsNews&&id='.$news['id'].'">więcej &raquo;</a></div>';
                                           
                echo'</div>';
            }                                                       
            
        }                        
        

        public static function getImageSize($poleDB, $typ){
            $rozmiary = array('image' => array('small'=>array('hight'=>115, 'width'=>165), 'medium'=>array('hight'=>250, 'width'=>350), 'large'=>array('hight'=>250, 'width'=>350), 'default'=>array('hight'=>200, 'width'=>231)));
            return $rozmiary[$poleDB][$typ];
        }
}

