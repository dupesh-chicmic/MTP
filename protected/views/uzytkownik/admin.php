<?php 
if(Yii::app()->user->isAdmin || Yii::app()->user->isSu()){
?>
<!--[if lte IE 9]>
<?php //Yii::app()->getClientScript()->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-1.4.1-cGridViewFixIe78.js'); ?>
<![endif]-->

<?php
    $this->breadcrumbs=array(
    	'Users'=>array('index'),
    	'Manage',
    );

    $this->menu=array(
    	array('label'=>'List of Users', 'url'=>array('index')),
    	array('label'=>'Create User', 'url'=>array('create')),
    );

    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
        	$('.search-form').toggle();
        	return false;
        });
        $('.search-form form').submit(function(){
        	$.fn.yiiGridView.update('uzytkownik-grid', {
        		data: $(this).serialize()
        	});
        	return false;
        });

        function confirmReset()
        {
            var ans = confirm('Are you sure you want to reset token?');
            if (ans == true || ans == 1)
            { 
                return true;
            }
            return false;     
        }
    ");
?>

<h3 style="margin-top:0px; padding-top: 20px;">Manage Users and Licences</h2>

<?php 
//test (przeniesc do CRONA)
//echo '<a href="index.php?r=site/sendEmails&days=1">Send Email to users (1)</a><br />';
//echo '<a href="index.php?r=site/sendEmails&days=30">Send Email to users (30)</a><br />';

    if(Yii::app()->user->hasFlash('errorMsg')){
        echo '<div class="flash-error">';
        echo Yii::app()->user->getFlash('errorMsg');
        echo '</div>';
    }
    if(Yii::app()->user->hasFlash('successMsg')){
        echo '<div class="flash-success">';
        echo Yii::app()->user->getFlash('successMsg');
        echo '</div>';
    }

    echo '<a style="padding-bottom:15px;" href="index.php?r=site/addNewUser">Add new user</a><hr><br />'; ?>

    <p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
    </p>

<?php 
    $provider = $model->search();
    $provider->setPagination(array('pageSize'=>25));
    if(Yii::app()->params['website_type']==Yii::app()->params['website']['MOBILE']){       
        $this->widget('zii.widgets.grid.CGridView', array(
        	'id'=>'table-user-grid',
        	'dataProvider'=>$provider,
            'cssFile'=> './css/userGrid.css',
        	'filter'=>$model,
        	'columns'=>array(
        		'id',
        		'login',
                'email',
                'imie',
        		'nazwisko',
        		'lic_start_cars',
        		'lic_exp_cars',
        		'lic_start_comm',
        		'lic_exp_comm',        
        		'mobile_on',
                'mobile_token',
                'checks',
                array(
                    'class'=>'CButtonColumn',                          
                    'header'=>'Action',
                    'deleteButtonUrl'=>'Yii::app()->createUrl("site/deleteUser", array("delete" => $data->id))',
                    'updateButtonUrl'=>'Yii::app()->createUrl("site/updateUser", array("update" => $data->id))',
                    'viewButtonOptions'=>array('style'=>'display:none'),
                        ),
                array(
                    'header'=>'Reset mobile token',
                    'type'=>'html',
                    'value'=> 'CHtml::link(
                                CHtml::image("./images/mobile_ico.png", ""),
                                "index.php?r=site/resetUserToken&reset=$data->id",
                                array("class"=>"highslide")
                               )',
                ),
                array(
                    'header'=>'Reset desktop token',
                    'type'=>'html',
                    'value'=> 'CHtml::link(
                                CHtml::image("./images/mobile_ico.png", ""),
                                "index.php?r=site/resetUserDesktopToken&reset=$data->id",
                                array("class"=>"highslide")
                               )',
                ),       
        	),
        )); 

    }else{//website_type check 
        $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'table-user-grid',
            'dataProvider'=>$provider,
            'cssFile'=> './css/userGrid.css',
            'filter'=>$model,
            'columns'=>array(
                'id',
                'login',
                'email',
                'imie',
                'nazwisko',
                'lic_start_cars',
                'lic_exp_cars',
                'lic_start_comm',
                'lic_exp_comm',        
                'mobile_on',
                'mobile_token',
                'guide_mobile_token',
                'guide_mobile_token_ios',
                'checks',
                array(
                    'class'=>'CButtonColumn',                          
                    'header'=>'Action',
                    'deleteButtonUrl'=>'Yii::app()->createUrl("site/deleteUser", array("delete" => $data->id))',
                    'updateButtonUrl'=>'Yii::app()->createUrl("site/updateUser", array("update" => $data->id))',
                    'viewButtonOptions'=>array('style'=>'display:none'),
                        ),
                array(
                    'header'=>'Reset mobile token',
                    'type'=>'html',
                    'value'=> 'CHtml::link(
                                CHtml::image("./images/mobile_ico.png", ""),
                                "index.php?r=site/resetUserToken&reset=$data->id",
                                array("class"=>"highslide")
                               )',
                ),
                array(
                    'header'=>'Reset desktop token',
                    'type'=>'html',
                    'value'=> 'CHtml::link(
                                CHtml::image("./images/mobile_ico.png", ""),
                                "index.php?r=site/resetUserDesktopToken&reset=$data->id",
                                array("class"=>"highslide")
                               )',
                ), 
                array(
                    'header'=>'Reset Guide Browser Token',
                    'type'=>'html',
                    'value'=> 'CHtml::link(
                                CHtml::image("./images/guide-16.png", ""),
                                "index.php?r=site/resetGuideToken&reset=$data->id",
                                array("class"=>"highslide")
                               )',
                ),
                array(
                    'header'=>'Reset Guide Home Screen Token',
                    'type'=>'html',
                    'value'=> 'CHtml::link(
                                CHtml::image("./images/guide-16.png", ""),
                                "index.php?r=site/resetGuideHomeScreenIosToken&reset=$data->id",
                                array("class"=>"highslide")
                               )',
                ),
            ),
        )); 

    }//website_type check

    echo CHtml::beginForm(Yii::app()->createUrl('site/clearAllMobileTokens'), 'POST', array('class'=>'btn btn-primary','style'=>' margin-top:10px; float:right;'));
    echo '<img src="./images/mobile_ico.png" alt="">';
    echo CHtml::submitButton('Clear all mobile tokens',array('style'=>'border:none;'));
    echo CHtml::endForm();
    
}else{
    $this->redirect('index.php');
}
?>
