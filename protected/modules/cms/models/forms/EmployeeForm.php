<?php

class EmployeeForm extends FormModel
{
    public $uzytkownik;
    public $pracownik;

    public function init()
    {
        $this->uzytkownik=new Uzytkownik($this->scenario);
        $this->pracownik=new Pracownik($this->scenario);
    }

    public function setAttributes($values, $safeOnly=true)
    {
        $this->uzytkownik->attributes=$values['Uzytkownik'];
        $this->pracownik->attributes=$values['Pracownik'];
    }

    public function validate()
    {
        $validated=$this->uzytkownik->validate();                
        if(!$this->pracownik->validate())
            $validated=false;

        $validated = true; // Brzydkie rozwiazanie Mariusza - tego wiersza nie powinno byc
        return $validated;
    }

    public function beforeSave()
    {
        //wartości domyślne
        $this->uzytkownik->typ_uzytkownika=Slownik::getValue('typ_uzytkownika', 'pracownik');        
        return parent::beforeSave();
    }

    public function saveTransaction()
    {
        if($this->scenario=='update'&&strlen($this->uzytkownik->haslo)==0)
        {
            $attributes=$this->uzytkownik->getAttributes();
            unset($attributes['haslo']);
            $attributes=array_keys($attributes);
        }
        else
            $attributes=null;

        if($this->uzytkownik->save(false, $attributes))
        {
            $this->pracownik->id_uzytkownika=$this->uzytkownik->id;

            if($this->pracownik->save(false))
                return true;
        }

        return false;
    }
}
?>
