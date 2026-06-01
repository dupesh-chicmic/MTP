<?php

/**
 * @copyright QbixSoft
 * @author Aleksander Stekman
 */

abstract class ActiveRecord extends CActiveRecord
{
    protected $oldValues=array();

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    /**
     * @author Aleksander Stekman
     * @param <type> $runValidation
     * @param <type> $attributes
     * @return boolean
     */
    public function saveTransaction($runValidation=true, $attributes=NULL)
    {
        $t=null;
        if(!Yii::app()->db->currentTransaction)
        {
            Yii::app()->db->beginTransaction();
            $t=Yii::app()->db->currentTransaction;
        }

        if(parent::save($runValidation, $attributes))
        {
            if($t)
                $t->commit();
            return true;
        }

        if($t)
            $t->rollback();
        return false;
    }

    /**
     * @author Aleksander Stekman
     * @return array asocjacyjna z atrybutami, które się zmieniły (klucz główny porównany z rekordem w bazie)
     * zwracane są STARE wartości (czyli te z bazy)
     */
    protected function attributesChanged($attributes=array()) {   
        if(!$this->getIsNewRecord()&&$this->getPrimaryKey()!=null)
            $model=$this->model()->findByPk($this->getPrimaryKey());
        else
        {
            /**
             * @todo olek: jaki powinien być poprawny zapis poniższego???
             */
            $c=get_class($this);
            $model=new $c;
        }

        $changeArray=array();
        foreach($attributes as $a) {
            if($this->$a!=$model->$a) {
                $changeArray[$a]=$model->$a;
            }
        }
        return $changeArray;
    }
}

