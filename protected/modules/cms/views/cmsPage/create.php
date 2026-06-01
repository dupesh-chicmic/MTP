<?php
$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Pages')=>array('index'),
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new page'),
);
?>
<div id="sideContent">
<?php echo '<div class="boxNewPage"><a href="index.php?r=cms/cmsPage/create"><img src="'.$this->module->assetsUrl.'/images/admin/img/arrow.png" alt="arrow"></a><div class="text"><a href="index.php?r=cms/cmsPage/create">'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new page').'</a></div></div>'; ?>


<?php
            $class='wait';
                    $criteria=new CDbCriteria;
                    $criteria->compare('parent_id', 1);
                    $criteria->order = '`order`';
                    $page_z_bazy = CmsPage::model()->findAll($criteria);

                    $menuLeft = array();

                    echo '<ul class="boxBackground">';
                        foreach($page_z_bazy as $page){
                            //if($page['display']==1){
                                    echo '<li class="options"><div class="caption"><a href="index.php?r=cms/cmsPage/update&&id='.$page['id'].'">'.$page['link_name'].'</a>';
                                    if($page['display']==0){
                                     echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="(!)"></div>';
                                    }                                    
                                    if($page['deletable']==1){
                                         echo '</div><div class="iconExit"><a href="index.php?r=cms/cmsPage/delete&&id='.$page['id'].'" title="Delete" onclick="return confirm(\''.Yii::t(Yii::app()->language.'_YiiTranslation', 'Are you sure you want to delete this item?').'\')"><img alt="Delete" src="'.$this->module->assetsUrl.'/images/admin/img/delete.png"></a></div>';
                                    }else{
                                        echo '</div>'; //caption div
                                    }
                                    echo '</li>
                                        <li class="line"></li>';
                            //}
                        }
					  
                      echo '</ul>';              
echo '<a href="index.php?r=cms/cmsPage/create"><div class="buttonClearForm">'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Reset form').'</div></a>
    </div>'; // END sideContent
    
        //Formularz
echo $this->renderPartial('_form', array('model'=>$model)); //nazwa widoku + dane

?>
