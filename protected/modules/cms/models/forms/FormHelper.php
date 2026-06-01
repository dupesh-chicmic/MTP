<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FormHelper
 *
 * @author Mike
 */
class FormHelper {
    //put your code here


    public static function getUniversalSelect($label, $parent_db_field, $parent_id, $html_id, $modelName, $order, $active_id){
        $out ="";
        $out .= '<label for="'.$html_id.'">'.$label.'</label>';

            //echo $form->hiddenField($model_lacznika,'category_id');
        //echo '<input value="" name="CmsArticleCategory[time]" id="CmsArticleCategory_time" type="hidden" />';




            //$active_id = $model->isNewRecord ? 0 : $model_lacznika->category;
            //echo CmsCategory::model()->getCategorySelects(70, "time_", 'Time_category_id', $active_id);
            //echo $form->dropDownList($model,'status',CHtml::listData(CmsDictionary::model()->dictionaryGetGroup('article_status'), 'value', 'txt'));
            $criteria=new CDbCriteria;
            $criteria->order = '`'.$order.'`';
            $criteria->compare($parent_db_field,$parent_id); //tylko TIME kategorie

            //$all2 = $modelName::model()->findAll($criteria);
            $all2 = CActiveRecord::model($modelName)->findAll($criteria);

            $out .= '<select id="'.$html_id.'" name="'.$html_id.'">';

            $out .= '<option value="0"> -- wybierz -- </option>';
                foreach ($all2 as $TimeOption2){
                    if ($TimeOption2['id']==$active_id){
                        $out .= '<option value="'.$TimeOption2['id'].'" selected="selected">'.$TimeOption2['name'].'</option>';
                    }else {
                        $out .= '<option value="'.$TimeOption2['id'].'">'.$TimeOption2['name'].'</option>';
                    }

                }
            $out .= '</select>';

            return $out;
     }



     public static function getUniversalDualBoxSelect($label=null, $optionList=null, $parent_db_field=null, $parent_id=null, $html_id='box1View', $modelName=null, $order=null){
            $out ="";
        $out .= '<label for="'.$html_id.'">'.$label.'</label>';

        $out .= '<div>
    <table>
            <tr>
                <td>
                        <!--Filter: <input type="text" id="box1Filter" /><button type="button" id="box1Clear">X</button><br />-->
                        <select id="'.$html_id.'" multiple="multiple" style="height:500px;width:300px;">
                        ';

        foreach($optionList as $key=>$val){
            $out .= '<option value="'.$val.'">'.$key.'</option>';
        }


                        $out .= '</select><br/>
                         <span id="box1Counter" class="countLabel"></span>
                       <select id="box1Storage">
                        </select>
                </td>
                <td>
                    <button id="to2" type="button">&nbsp;>&nbsp;</button>
                    <button id="allTo2" type="button">&nbsp;>>&nbsp;</button>
                    <button id="allTo1" type="button">&nbsp;<<&nbsp;</button>
                    <button id="to1" type="button">&nbsp;<&nbsp;</button>
                </td>
                <td>
                    <!--Filter: <input type="text" id="box2Filter" /><button type="button" id="box2Clear">X</button><br />-->
                    <select id="box2View" multiple="multiple" style="height:500px;width:300px;">
                    </select><br/>
                    <span id="box2Counter" class="countLabel"></span>
                    <select id="box2Storage">
                    </select>
                </td>
            </tr>
        </table>
    </div>';

        Yii::app()->clientScript->registerScript('parent','
                                        $(document).ready(function()
                                        {
                                            $.configureBoxes();
                                        });
                                ',CClientScript::POS_HEAD);

        return $out;
     }

     public static function getUniversalSingleListBox($label, $parent_db_field, $parent_id, $html_id, $modelName, $order, $active_ids){
        $out ="";
        $out .= '<label for="'.$html_id.'">'.$label.'</label>';

            //echo $form->hiddenField($model_lacznika,'category_id');
        //echo '<input value="" name="CmsArticleCategory[time]" id="CmsArticleCategory_time" type="hidden" />';




            //$active_id = $model->isNewRecord ? 0 : $model_lacznika->category;
            //echo CmsCategory::model()->getCategorySelects(70, "time_", 'Time_category_id', $active_id);
            //echo $form->dropDownList($model,'status',CHtml::listData(CmsDictionary::model()->dictionaryGetGroup('article_status'), 'value', 'txt'));
            $criteria=new CDbCriteria;
            $criteria->order = '`'.$order.'`';
            $criteria->compare($parent_db_field,$parent_id); //tylko TIME kategorie
            //$all2 = $modelName::model()->findAll($criteria);
            $all2 = CActiveRecord::model($modelName)->findAll($criteria);

            $out .= '<select id="'.$html_id.'" name="'.$html_id.'[]" multiple="multiple" >';

                foreach ($all2 as $TimeOption2){
                    $selected = "";
                    if (!empty($active_ids)){
                        foreach ($active_ids as $active){
                            if ($TimeOption2['id'] == $active)  $selected = ' selected="selected"';
                        }
                    }
                    $out .= '<option value="'.$TimeOption2['id'].'" '. $selected.'>'.$TimeOption2['name'].'</option>';
                }
            $out .= '</select>';

            return $out;
     }



}
?>
