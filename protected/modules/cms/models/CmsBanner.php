<?php

/**
 * This is the model class for table "pl_cms_banner".
 *
 * The followings are the available columns in table 'pl_cms_banner':
 * @property integer $id
 * @property string $title
 * @property string $txt
 * @property string $image
 * @property string $code
 * @property string $url
 * @property integer $display
 * @property string $data_waznosci
 * @property integer $order
 *
 * The followings are the available model relations:
 */
class CmsBanner extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsBanner the static model class
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
		return 'pl_cms_banner';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order', 'required'),
			array('display, order', 'numerical', 'integerOnly'=>true),
			array('title, image, url', 'length', 'max'=>500),
			array('txt, code, data_waznosci', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, txt, image, code, url, display, data_waznosci, order', 'safe', 'on'=>'search'),
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
			'txt' => 'Tekst',
			'image' => 'Zdjęcie lub animacja flash',
			//'code' => 'Kod skryptu',
			'url' => 'Url',
			'display' => 'Wyświetlaj',
			//'data_waznosci' => 'Data Ważności',
			'order' => 'Kolejność',
		);
            }else{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'txt' => 'Text',
			'image' => 'Picture or Flash animation',
			//'code' => 'Script code',
			'url' => 'Url',
			'display' => 'Display',
			//'data_waznosci' => 'Expire date',
			'order' => 'Order',
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
		$criteria->compare('txt',$this->txt,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('display',$this->display);
		$criteria->compare('data_waznosci',$this->data_waznosci,true);
		$criteria->compare('order',$this->order);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}


        public function ShowBanner(){
            /* pierwszenstwo w wyswietlaniu ma pole code */
            
                $criteria=new CDbCriteria;
                $criteria->select='*';
                $criteria->compare('display', 1);
                $criteria->order='`order`';
                $banery_z_bazy = CmsBanner::model()->findAll($criteria);

                $model = new CmsBanner;
                
                $link = '#';
                $banery = array();
                echo '<div class="slideshow" style="width: 970px; height: 320px; position: relative;">';
                foreach($banery_z_bazy as $baner){

                    if(empty($baner['code'])){

                        //var_dump(Yii::app()->getModule('cms'));die;
                        $directory = './pictures/banner/'.$baner['id'];  //podaje sciezke/nazwa folderu

                        if(file_exists($directory)){
                            
                        }else{ echo "Folder z banerami nie został znaleziony"; }

                          foreach (new DirectoryIterator($directory) as $fileInfo) {
                              $plik_nazwa = $fileInfo->getFilename();
                                
                                if(($plik_nazwa!=".")&&($plik_nazwa!="..")&&($plik_nazwa!=".svn")){                                
                                    if($baner['image'] == $plik_nazwa){
                                        $file_extension = substr($baner['image'], -3);//zostawia tylko jpg/png/gif
                                        if($file_extension == 'swf'){
                                            
                                            echo '<a style="width: 970px; height: 320px;"  href="'.$link.'"><div>';
                                            // flash
                                                echo '
                                                <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                                                codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
                                                WIDTH="770" HEIGHT="110" id="prezentacja">
                                                 <PARAM NAME=movie VALUE="'.$directory.'/'.$plik_nazwa.'"> <PARAM NAME=quality VALUE=high>
                                                 <PARAM NAME=bgcolor VALUE=#FFFFFF><param name="wmode" value="transparent" />
                                                <EMBED src="'.$directory.'/'.$plik_nazwa.'" quality=high bgcolor=#FFFFFF  WIDTH="280" HEIGHT="200" NAME="prezentacja" ALIGN="left"
                                                TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" wmode="transparent"></EMBED>
                                                </OBJECT>';
                                                
                                                  echo '</div><div class="title">'.$baner['title'].'</div>';
                                                  echo $baner['txt'];
                                                echo '</div></a>';
                                        }else{
                                            if(empty($baner['url'])){
                                                echo '<a style="width: 970px; height: 320px; background-color: rgb(200,203,192) !important; *background-color:rgb(200,203,192) !important;" href="#">';
                                            }else{
                                                echo '<a style="width: 970px; height: 320px; background-color: rgb(200,203,192) !important; *background-color:rgb(200,203,192) !important;" href="'.$baner['url'].'">';
                                            }

                                            
                                                echo '<div><img src="'.$directory.'/'.$plik_nazwa.'"/>';
                                            echo '<div class="title"><span>'.$baner['txt'].'</span></div>';
                                            echo '</div></a>';
                                        }
                                    }//end if($baner['image'] == $plik_nazwa){
                                }
                            }   // end foreach
                            
                    }else{
                        //jesli zostal wpisany kod skryptu
                        echo $baner['code'];
                    }

                }//end foreach
                echo '</div>';
        }


}

?>