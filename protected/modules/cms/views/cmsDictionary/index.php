<?php
/* elementy ze slownika */
$dict_dict = CmsDictionary::model()->dictionaryGetText('adm_dict_dict');
$dict_dict_zarzadzaj = CmsDictionary::model()->dictionaryGetText('adm_dict_dict_zarzadzaj');
$dict_dict_dodaj_nowy_wpis = CmsDictionary::model()->dictionaryGetText('adm_dict_dict_dodaj_nowy');
$dict_dodaj_nowa = CmsDictionary::model()->dictionaryGetText('adm_dodaj_nowa');
/* */

$this->breadcrumbs=array(
	$dict_dict,
);

    if(Yii::app()->user->isSu() == false){ //jest tylko adminem
        $this->menu=array(
                array('label'=>$dict_dict_zarzadzaj, 'url'=>array('admin')),
            
        );
    }else{ // jestem SU
        $this->menu=array(
                array('label'=>$dict_dict_dodaj_nowy_wpis, 'url'=>array('create')),
                array('label'=>$dict_dict_zarzadzaj, 'url'=>array('admin')),
        );
    }
?>

<h1><?php echo $dict_dict; ?></h1>

<?php 
//$this->widget('zii.widgets.CListView', array(
//	'dataProvider'=>$dataProvider,
//	'itemView'=>'_view',
//)); 
$this->redirect(array('/cms/cmsDictionary/admin')); 
?>
