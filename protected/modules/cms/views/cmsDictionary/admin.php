<?php
$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Dictionary')=>array('index'),
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Manage dictionary elements'),
);
    if(Yii::app()->user->isSu() == false){ //jest tylko adminem
        $this->menu=array(
            //array('label'=>'List CmsDictionary', 'url'=>array('index')),
        );
    }else{ //jestem SU
        $this->menu=array(
            array('label'=>'List CmsDictionary', 'url'=>array('index')),
            array('label'=>Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new element'), 'url'=>array('create')),
        );
    }
    
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cms-dictionary-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="inside">

<?php 
if(Yii::app()->user->isSu() == true){
    echo '<div id="sideContent">';
    echo '<div class="boxNewPage"><a href="index.php?r=cms/cmsDictionary/create"><img alt="arrow" src="'.$this->module->assetsUrl.'/images/admin/img/arrow.png"></a>
        <div class="text"><a href="index.php?r=cms/cmsDictionary/create">'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Add new element').'</a></div></div>';
    echo '</div><br />';
}

echo '<p>';
    echo Yii::t(Yii::app()->language.'_YiiTranslation', 'You may optionally enter a comparison operator (<, <=, >, >=, <> or =).');
echo '</p>';

    if(Yii::app()->user->isSu() == true){ //jest SU
        echo CHtml::link(Yii::t(Yii::app()->language.'_YiiTranslation', 'Advanced search'),'#',array('class'=>'search-button'));
    }
?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php
      if(Yii::app()->user->isSu() == false){ //jest tylko adminem
            $provider = $model->search();
            $provider->setPagination(array('pageSize'=>20));
            
            $this->widget('zii.widgets.grid.CGridView', array(                
                    'id'=>'cms-dictionary-grid',
                    'enablePagination'=>true,
                    'dataProvider'=>$provider,
                    'cssFile'=> $this->module->assetsUrl.'/css/gridViewStyle/backGrid.css',
                    'summaryText'=>'',
                    'filter'=>$model,
                    'columns'=>array(
                            'group',
                            'key',
                            'txt',
                            array(
                                    'class'=>'CButtonColumn',
                            ),
                    ),
            ));
      }else{ // jest SU
            $provider = $model->search();
            $provider->setPagination(array('pageSize'=>20));
            
            $this->widget('zii.widgets.grid.CGridView', array(
                    
                    'id'=>'cms-dictionary-grid',
                    'enablePagination'=>true,
                    'dataProvider'=>$provider,
                    'cssFile'=> $this->module->assetsUrl.'/css/gridViewStyle/backGrid.css',
                    'summaryText'=>'',
                    'filter'=>$model,
                    'columns'=>array(
                            'id',
                            'key',
                            'txt',
                            'client_editable',
                            'value',
                            'group',
                            /*
                            'actions',
                            */
                            array(
                                    'class'=>'CButtonColumn',
                            ),
                    ),
            ));
      }

?>

</div>