<?php
/*
 * formularz dodania/zmiany danych osobowych klienta
 * używany przez klienta administratora w celu dodania nowego konta systemowego do firmy matki
 */

class FormModel extends CFormModel
{
    public $uzytkownik;
    public $klient;

    public function  __construct($scenario='insert')
    {
        parent::__construct($scenario);
    }

    public function save($doValidate=true)
    {
        if($doValidate)
            if(!$this->validate())
                    return false;

            // if(!Yii::app()->db->currentTransaction)  {
        Yii::app()->db->beginTransaction();
                   // }
        $validated=false;
                    try
                    {
                        if($this->beforeSave())
                        {
                            if($this->saveTransaction())
                                    if($this->afterSave())
                                            $validated=true;
                        }
                    }
                    catch(CException $e)
                    {
                     //   if($this->_transactionOwner)   {
                            $t=Yii::app()->db->currentTransaction->rollback();

                           // $this->_transactionOwner=false;
                       // }
                        throw $e;
                        return false;
                    }

                    if($validated)
                    {
                        Yii::app()->db->currentTransaction->commit();
                    }
                    else
                    {
                        Yii::app()->db->currentTransaction->rollback();
                    }

         return $validated;
    }

    public function beforeSave()
    {
        return true;
    }

    public function afterSave()
    {
        return true;
    }

    public function saveTransaction($doValidate=false)
    {
        return true;
    }
}
?>
