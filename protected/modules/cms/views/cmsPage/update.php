<?php

$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Pages')=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	
);

$editable = CmsPage::model()->getElement('id', $_GET['id'], 'CmsPage', 'editable');

?>
<div id="sideContent">
<?php echo '<div class="boxNewPage"><a href="'.$this->createUrl("cmsPage/create").'"><img src="'.$this->module->assetsUrl.'/images/admin/img/arrow.png" alt="arrow" /></a><div class="text"><a href="index.php?r=cms/cmsPage/create">'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new page').'</a></div></div>';
?>


<?php
        $urlID = null;
        $activePath = null;
        
        if(isset($_GET['id'])){ $urlID = $_GET['id'];
            $activePath = CmsPage::model()->getMenuActivePath('CmsPage', 'parent_id', $urlID);
        }else{ $urlID = '';}
        

            $class='wait';
                    $criteria=new CDbCriteria;
                    $criteria->compare('parent_id', 1);
                    $criteria->order = '`order`';
                    $page_z_bazy = CmsPage::model()->findAll($criteria);


                    $menuLeft = array();

                    /* dodaj nowa strone */
// echo '<div class="addNewPage"><a href="index.php?r=cms/cmsPage/create">'.$dict_dodaj_nowa.'</a></div>';
                    echo '<ul class="boxBackground">';
                    
                        foreach($page_z_bazy as $page){
                            //if($page['display']==1){
                                
                                if(isset($_GET['id'])){
                                    if(CmsPage::model()->isOnActivePath($page['id'], $activePath)){$class='active onClick';}
                                }else{ //$urlID = '';
                                  //  echo "nie zlapal;";
                                }


                                
                                if(CmsPage::model()->isOnActivePath($page['id'], $activePath)){
                                
                                echo '<li class="options"><div class="caption"><a href="'.$this->createUrl("cmsPage/update", array("id"=>$page['id'])).'">'.$page['link_name'].'</a>';
                                //echo '<li class="options"><div class="caption"><a href="index.php?r=cms/cmsPage/update&&id='.$page['id'].'">'.$page['link_name'].'</a>';
                                if($page['display']==0){
                                 echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="(!)"></div>';
                                }
                                if($page['deletable']==1){
                                     echo '</div><div class="iconExit"><a href="'.$this->createUrl("cmsPage/delete", array("id"=>$page['id'])).'" title="Delete" onclick="return confirm(\''.Yii::t(Yii::app()->language.'_YiiTranslation', 'Are you sure you want to delete this item?').'\')"><img alt="Delete" src="'.$this->module->assetsUrl.'/images/admin/img/delete.png"></a></div>';
                                }else{
                                        echo '</div>'; //caption div
                                }
                                     echo '</li><li class="line"></li>';

                                $level=0;
                                    /* szukam childow dla id z urla */
                                    $criteriaChild=new CDbCriteria;
                                    $criteriaChild->compare('parent_id', $page['id']); // wszystkie dzieci
                                    $criteriaChild->order = '`order`';
                                    $page_z_bazy_children = CmsPage::model()->findAll($criteriaChild);

                                    if (is_array($page_z_bazy_children)){
                                        CmsPage::model()->getSubmenu($page_z_bazy_children, $level+1, $activePath,$this->module->assetsUrl); // SUB MENU !
                                    }

                                }else{
                                 echo '<li class="options"><div class="caption"><a href="'.$this->createUrl("cmsPage/update", array("id"=>$page['id'])).'">'.$page['link_name'].'</a>';
                                    if($page['display']==0){
                                     echo '<div class="iconExit"><img style="width:30px; height:30px;" src="'.$this->module->assetsUrl.'/images/admin/img/lupa.png" alt="(!)"></div>';
                                    }                                 
                                     if($page['deletable']==1){
                                       echo '</div><div class="iconExit"><a href="'.$this->createUrl("cmsPage/delete", array("id"=>$page['id'])).'" title="Delete" onclick="return confirm(\''.Yii::t(Yii::app()->language.'_YiiTranslation', 'Are you sure you want to delete this item?').'\')"><img alt="Delete" src="'.$this->module->assetsUrl.'/images/admin/img/delete.png"></a></div>';
                                     }else{
                                        echo '</div>'; //caption div
                                    }
                                       echo '</li><li class="line"></li>';

                                }


                            //}
                            $class='';
                        }
                        echo '</ul>';


echo '
    </div>'; // END sideContent



if($editable==1){
    echo $this->renderPartial('_form', array('model'=>$model));
}else if (Yii::app()->getUser()->getName() == 'su'){
    echo $this->renderPartial('_form', array('model'=>$model));
}else{
    echo '<div class="NoEditable">'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Element cannot be editable').'</div>';
}

?>

