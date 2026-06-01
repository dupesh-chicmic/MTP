<?php if(Yii::app()->user->isGuest):?>

    <?php echo CHtml::beginForm(Yii::app()->createUrl('site/login'), 'POST', array('id'=>'loginForm')); ?>
    <?php $having_trouble = CmsPage::model()->find('id=?', array(64)); ?>
    <?php //echo' <a href="'.Yii::app()->createUrl('cms/cmsPage/displayPage', array('url'=>'having_trouble_logging_in')).'">Having trouble logging in?</a>';?><br/>
    <!--<label>Member Area</label> -->
    <?php //echo CHtml::textField('LoginForm[login]','',array('id'=>'login','class'=>'text login')); ?>
    <?php //echo CHtml::passwordField('LoginForm[password]','',array('id'=>'pwd','class'=>'text pwd')); ?>
    <?php //echo CHtml::submitButton('LOGIN',array('class'=>'submit')); ?>
    <a href="<?php echo Yii::app()->createUrl('site/loginIFrame/', array('class'=>'submit')); ?>">LOGIN</a>
    <?php echo CHtml::endForm(); ?>
    

<?php else: ?>

    <?php echo CHtml::beginForm(Yii::app()->createUrl('site/logout'), 'POST', array('id'=>'loginOutForm')); ?>
    <?php
        if(Yii::app()->user->isAdmin){
            echo' <a href="'.Yii::app()->createUrl('cms/cmsPage/create').'">Manage website</a>';
        }else if(!Yii::app()->user->isGuest){
            echo' <a href="'.Yii::app()->createUrl('uzytkownik/userAccount').'">My account</a>';
        }
    ?><br/>
    <label>Member: <?php echo Yii::app()->user->name; ?></label>
    <?php echo CHtml::submitButton('LOGOUT',array('class'=>'submit','style'=>'padding-right:10px;')); ?>
    <?php echo CHtml::endForm(); ?>

<?php endif; ?>