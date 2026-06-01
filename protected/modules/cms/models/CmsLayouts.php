<?php

/**
 * This is the model class for table "cms_layouts".
 *
 * The followings are the available columns in table 'cms_layouts':
 * @property integer $id
 * @property string $name
 * @property string $group
 * @property integer $display
 * @property integer $deletable
 * @property integer $order
 * @property string $col_up
 * @property string $col_down
 * @property string $col_left
 * @property string $col_right
 * @property string $col_center
 * @property string $image
 * @property string $fileName
 */
class CmsLayouts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CmsLayouts2 the static model class
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
		return 'cms_layouts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('display, deletable, order', 'numerical', 'integerOnly'=>true),
			array('name, col_up, col_down, col_left, col_right, col_center, image', 'length', 'max'=>200),
			array('group', 'length', 'max'=>75),
			array('fileName', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, group, display, deletable, order, col_up, col_down, col_left, col_right, col_center, image, fileName', 'safe', 'on'=>'search'),
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
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'group' => 'Group',
			//'display' => 'Display',
			'deletable' => 'Deletable',
			//'order' => 'Order',
			//'image' => 'Image',
			//'fileName' => 'File Name',
		);
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('group',$this->group,true);
		$criteria->compare('display',$this->display);
		$criteria->compare('deletable',$this->deletable);
		$criteria->compare('order',$this->order);
		$criteria->compare('col_up',$this->col_up,true);
		$criteria->compare('col_down',$this->col_down,true);
		$criteria->compare('col_left',$this->col_left,true);
		$criteria->compare('col_right',$this->col_right,true);
		$criteria->compare('col_center',$this->col_center,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('fileName',$this->fileName,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getLayoutsByGroup($groupId){
            /*  
               //ma zwrocic
                $groupArrayScript .= '
                5 : \'Text A\',
                10 : \'Text B\',
                15 : \'Text C\'    
                ';
            */
            $criteria=new CDbCriteria;
            $criteria->order='`name`';
            if($groupId=='universalElements'){                
                $criteria->condition = 'LENGTH( `group` ) > 5' ;
            }else{
                $criteria->compare('`group`', $groupId);
            }            
            $criteria->compare('`display`', 1);
            $layoutsByGroup = CmsLayouts::model()->findAll($criteria);
            
            //$layoutsKeyVal = '\'';
            $layoutsKeyVal = '';
            foreach($layoutsByGroup as $layout){
  
                $layoutsKeyVal .= $layout->id.' : \''.$layout->name.'\',';
                
            }
            
            //$layoutsKeyVal .= '\'';
            return $layoutsKeyVal;
        }

        
        public function generateCase_universal_elements(){
            // pobierz : mapy, newsy, galeria, video itp.
            
            $criteria=new CDbCriteria;
            $criteria->order='`name`';            
            $criteria->condition = 'LENGTH( `group` ) > 5' ;
            $criteria->compare('`display`', 1);
            $layoutUnivParents = CmsLayouts::model()->findAll($criteria);
            
            $jsOut = '';
            foreach($layoutUnivParents as $parentElement){
                    $jsOut .= '
                    case \''.$parentElement['id'].'\':                                        
                                var group_array = {';
                                $jsOut .= CmsLayouts::model()->generateCase_universal_elements_jsElements($parentElement['group']);
                                $jsOut .= '};

                                var select = document.getElementById("CmsPage_param_2");
                                select.options.length = 0;
                                for(index in group_array) {
                                    select.options[select.options.length] = new Option(group_array[index], index);
                                }';
                               
                    $jsOut .= '
                                var group_arrayLay = {';
                                $jsOut .= CmsLayouts::model()->getLayoutsByGroup($parentElement['id']); 
                                $jsOut .= '};

                                var select = document.getElementById("CmsPage_layout");
                                select.options.length = 0;
                                for(index in group_arrayLay) {
                                    select.options[select.options.length] = new Option(group_arrayLay[index], index);
                                }                        
';
                    $jsOut .= 'break;';
            }
            return $jsOut;            
        }
        
        public function generateCase_universal_elements_jsElements($universalElName){
            /*  
               //ma zwrocic
                $groupArrayScript .= '
                5 : \'Text A\',
                10 : \'Text B\',
                15 : \'Text C\'    
                ';
            */
            $criteria=new CDbCriteria;
            //$criteria->order='`title`';         
            $criteria->compare('`display`', 1);
            $elements = CActiveRecord::model($universalElName)->findAll($criteria);
           // $elements = $universalElName::model()->findAll($criteria);
            
            //$$elementsKeyVal = '\'';
            $elementsKeyVal = '';
            foreach($elements as $el){
  
                $elementsKeyVal .= $el->id.' : \''.$el->title.'\',';
                
            }
            
            //$$elementsKeyVal .= '\'';
            return $elementsKeyVal;
        }        
 
        
        
        
//        public function generateCase_universal(){            
//            // pobierz rodzicow : mapy, newsy, galeria, video itp.
//            
//            $criteria=new CDbCriteria;
//            $criteria->order='`name`';            
//            $criteria->condition = 'LENGTH( `group` ) > 5' ;
//            $criteria->compare('`display`', 1);
//            $layoutUnivParents = CmsLayouts::model()->findAll($criteria);
//            
//            $jsOut = '';
//            foreach($layoutUnivParents as $parentElement){
//                    $jsOut .= '
//                    case \''.$parentElement['id'].'\':                                        
//                                var group_array = {';
//                                $jsOut .= CmsLayouts::model()->getLayoutsByGroup($parentElement['id']); 
//                                $jsOut .= '};
//
//                                var select = document.getElementById("CmsPage_layout");
//                                select.options.length = 0;
//                                for(index in group_array) {
//                                    select.options[select.options.length] = new Option(group_array[index], index);
//                                }
//                    break;';
//            }
//            return $jsOut;            
//        }
        
        
                
}