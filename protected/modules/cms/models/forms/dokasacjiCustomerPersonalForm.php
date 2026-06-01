<?php
/*
 * formularz dodania/zmiany danych osobowych klienta
 * używany przez klienta administratora w celu dodania nowego konta systemowego do firmy matki
 */

class CustomerPersonalForm extends FormModel
{
    public $uzytkownik;
    public $klient;
    public $firma;

    public function init()
    {
        $this->uzytkownik=new Uzytkownik;
        $this->klient=new Klient;
    }

    public function setAttributes($values, $safeOnly=true)
    {
        $this->uzytkownik->attributes=$values['Uzytkownik'];
        $this->klient->attributes=$values['Klient'];
        $this->firma=$values['Firma'];
    }

    public function validate()
    {
        $validated=$this->uzytkownik->validate();
        if(!$this->klient->validate())
                $validated=false;

        return $validated;
    }

    public function saveTransaction()
    {
        $this->klient->uzytkownik=$this->uzytkownik;
        if($this->klient->save())
        {
            $this->klient->klientFirma=new KlientFirma;
            $this->klient->klientFirma->id_klienta=$this->klient->id_uzytkownika;
            $this->klient->klientFirma->id_firmy=$this->firma->id;
            if($this->klient->klientFirma->save(false))
                return true;
        }
        return false;
    }
}
?>
