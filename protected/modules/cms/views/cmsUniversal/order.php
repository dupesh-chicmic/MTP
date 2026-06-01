<?php
$this->breadcrumbs=array(
	Yii::t(Yii::app()->language.'_YiiTranslation', 'Order'),
);
?>

<div class="inside">

    <?php echo '<h1><img class="navImageBig" src="'.$this->module->assetsUrl.'/images/admin/order.png" />'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Order').'</h1>'; ?>


    <?php echo CHtml::beginForm();
    Yii::app()->clientScript->registerScript('sortable','
            $(document).ready(function(){
                    $(\'#sortable\').sortable({
                            update: function(event, ui) {
                                    var elementOrder = $(this).sortable(\'toArray\').toString();
                                    document.getElementById(\'order\').value=elementOrder;
                            }
                    });
            });
    ',CClientScript::POS_HEAD);
    ?>
    <ul id="sortable">

    <?php
                       $order_elem = $_GET['ord'];

                       // ******************************** N E W - order 2.0 **************

                if($order_elem == 'CmsPage'){
                    //CmsPage
                    $criteria=new CDbCriteria;
                    $criteria->order = '`order`';
                   // $strony_z_bazy = $order_elem::model()->findAll($criteria);
                    $strony_z_bazy = CActiveRecord::model($order_elem)->findAll($criteria);


                    //CmsUniversal
                    $criteriaUniversal=new CDbCriteria;
                    //$criteriaUniversal->order = '`order`';
                    $criteriaUniversal->compare('`orderable`', 1);
                    $uniwersalne_z_bazy = CmsUniversal::model()->findAll($criteriaUniversal);

                        //$menu = array();
                        $i=1;
                        $id = $_GET['id'];

                        //dla linku wstecz musze wiedziec jaki jest parent_id
                        $pid_wstecz = CmsPage::model()->getElement('id', $id, $order_elem, 'parent_id'); //select parent_id from CmsPage where id=$_GET['id']

                        if($id == 1){ //1 wejscie
    //echo "<br>PRZED WYBRANIEM MENU TOP CZY GALERII CZY AKTUALNOSCI[universal element]<br>";
    //listuje
                        /* --------------  elementy z cmsPage   --------------*/

                        foreach($strony_z_bazy as $page){
                        //if( ($page['id']== 1) || ($page['id']== 3) ){ continue; } // main & menu_top
                            $pid = $page['parent_id'];

                            if($pid == $id){ //ma dzieci

                                                echo '<li class="ui-state-default" id='.$i.'>';
                                                    //echo '<a href="index.php?r=cms/cmsUniversal/order&&id='.$page->id.'&&order='.$page->order.'">'.$page['title'].'</a>';
                                                    echo '<a href="index.php?r=cms/cmsUniversal/order&&ord=CmsPage&&func='.$page['function'].'&&id='.$page['id'].'">'.$page['link_name'].' + </a>';

                                                echo '<input type="hidden" id="order" name="order['.$page->id.']" value="" />';
                                                echo '</li>';
                                                if($pid == 0){ echo "continue;"; }
                            }

                        }//end foreach z cmsPage
                        /* --------------  END elementy z cmsPage   --------------*/

                        /* --------------  elementy z cmsUniversal   --------------*/

                        foreach($uniwersalne_z_bazy as $uniwersalny_item){

                            //echo $Univ_id = $uniwersalny_item['id'];//wiem ze istnieje orderable=1 element musze pobrac model i JEGO elementy ktore bede orderowal

                            //if($Univ_pid == $id){ //ma dzieci
if(Yii::app()->language == 'pl'){
    $universalElementHeaderLanguage = $uniwersalny_item['menu_top_label_pl'];
}else{
    $universalElementHeaderLanguage = $uniwersalny_item['menu_top_label_en'];
}
                                    echo '<li class="ui-state-default" id='.$i.'>';
                                    //echo '<a href="index.php?r=cms/cmsUniversal/order&&id='.$page->id.'&&order='.$page->order.'">'.$page['title'].'</a>';
                                    echo '<a href="index.php?r=cms/cmsUniversal/order&&ord='.$uniwersalny_item['table_name'].'&&id='.$uniwersalny_item['id'].'&&parent_id=1"> '.$universalElementHeaderLanguage.' + </a>';

                                $i++;
                                echo '<input type="hidden" id="order" name="order['.$uniwersalny_item->id.']" value="" />';
                                echo '</li>';
                            //}else{ if($Univ_pid == 0){ continue; } }

                        }//end foreach z CmsUniversal

                        /* --------------  END elementy z cmsUniversal   --------------*/

                        }else{
                            //WSTECZ
                            echo '<div class="back_adm_btn"><a href="index.php?r=cms/cmsUniversal/order&ord=CmsPage&id='.$pid_wstecz.'" >'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Back').'</a></div>';


    //echo "w zarzadzaniu kolejnoscia menu_top wewnatrz";
                            foreach($strony_z_bazy as $page){
                            //if( ($page['id']== 1) || ($page['id']== 3) ){ continue; } // main & menu_top
                                $pid = $page['parent_id'];

                                if($pid == $id){ //ma dzieci

                                        echo '<li class="ui-state-default" id='.$i.'>';
                                        //echo '<a href="index.php?r=cms/cmsUniversal/order&&id='.$page->id.'&&order='.$page->order.'">'.$page['title'].'</a>';
                                        echo '<a href="index.php?r=cms/cmsUniversal/order&&ord='.$order_elem.'&&func='.$page['function'].'&&id='.$page['id'].'">'.$page['link_name'].'</a>';

                                    $i++;
                                    echo '<input type="hidden" id="order" name="order['.$page->id.']" value="" />';
                                    echo '</li>';
                                //}
                                }else{ if($pid == 0){ continue; } }
                            }// end foreach
                        } //end else - if($id == 1){ //1 wejscie
                }else{
       //TO CO JEST NP. W GALERII (nie w stronach galerii) LUB UNIVERSAL ELEMENT

    //echo "JESTEM CALY CZAS W UNIVERSALNYCH ITEMACH :D";

                        if(isset($_GET['parent_id'])){
                            $id = $_GET['parent_id'];
                            //omijaj parent_id = 1                        
                            if($id == 1){//WSTECZ
                                echo '<div class="back_adm_btn"><a href="index.php?r=cms/cmsUniversal/order&ord=CmsPage&id=1" >'.Yii::t(Yii::app()->language.'_YiiTranslation', 'Back').'</a></div>';
                            }else{
                                $rodzic_wstecz = CmsPage::model()->getElement('id', $id, $order_elem, 'parent_cat'); //select parent_id from CmsPage where id=$_GET['id']
                                echo '<div class="back_adm_btn"><a href="index.php?r=cms/cmsUniversal/order&ord='.$order_elem.'&&parent_id='.$rodzic_wstecz.'" >Wstecz</a></div>';
                            }
                        }
                        $criteria=new CDbCriteria;
                        $criteria->order = '`order`';
                        //$Univ_strony_z_bazy = $order_elem::model()->findAll($criteria);
                        $Univ_strony_z_bazy = CActiveRecord::model($order_elem)->findAll($criteria);

                            $menu = array();
                            $i=1;
                            //echo $parent_id = 'none';
                            foreach($Univ_strony_z_bazy as $page){
                                if(isset($page['title'])){
                                    $title = $page['title'];
                                }else{
                                    $title = $page['name'];
                                }
                                /* specjalnie dla kategorii */
                                if(isset($page['parent_cat'])){
                                    $parent_id = $page['parent_cat'];
                                }else if(isset($page['parent_id'])){
                                    $parent_id = $page['parent_id'];
                                }

                                if(isset($parent_id)){
                                    /*okazuje sie ze uniwersalny element jest wspanialym rodzicem(parent_id) i ma dzieci(id) */
                                    if($parent_id == $id){ //ma dzieci

                                            echo '<li class="ui-state-default" id='.$i.'>';
                                            //echo '<a href="index.php?r=cms/cmsUniversal/order&&id='.$page->id.'&&order='.$page->order.'">'.$page['title'].'</a>';
                                            echo '<a href="index.php?r=cms/cmsUniversal/order&&ord='.$order_elem.'&&id='.$parent_id.'&&parent_id='.$page['id'].'"> '.$title.'</a>';

                                        $i++;
                                        echo '<input type="hidden" id="order" name="order['.$page['id'].']" value="" />';
                                        echo '</li>';
                                    //}
                                    }else{ if($parent_id == 0){ continue; } }


                                }else{


                                    if( isset($page['display']) ){
                                        if($page['display'] == 1){
                                            echo '<li class="ui-state-default" id='.$i.'>';
                                            echo '<a href="index.php?r=cms/cmsUniversal/order&&ord='.$order_elem.'&&parent_id=1">'.$title.'</a>';
                                        }
                                    }else{
                                        /* W mapach nie maja pola display! */
                                        //if($page['param2'] == 'CmsMap' || $page['param2'] == 'CmsMapElements'){
                                        if($order_elem == 'CmsMap' || $order_elem == 'CmsMapElements' || $order_elem == 'CmsVideo'){
                                            echo '<li class="ui-state-default" id='.$i.'>';
                                            echo '<a href="index.php?r=cms/cmsUniversal/order&&ord='.$order_elem.'&&parent_id=1">'.$title.'</a>';
                                        }
                                    }
                                    $i++;
                                    echo '<input type="hidden" id="order" name="order['.$page->id.']" value="" />';
                                    echo '</li>';
                                    }
                            }// end foreach
                }


    ?>
    </ul>
    <?php
if(isset($_GET['id']) && $_GET['id'] != 1){
                echo '<div class="row buttons">';           
                         echo CHtml::submitButton(Yii::t(Yii::app()->language.'_YiiTranslation', 'Set the order'));            
                echo '</div>';
}

     echo CHtml::endForm();
     ?>

</div> 