<?php
/*
 * formularz dodania danych klienta indywidualnego lub firmy
 * używany: siteController->actionNewCustomer
 */

class AddressForm extends FormModel
{
    public $adres;
    public $addressData;
    public $klient;

    public function init()
    {
        $this->adres=new Adres;
        $this->addressData=new KlientAdres;
    }

    public function setAttributes($values, $safeOnly=true)
    {
        if(isset($values['AddressData']))
            $this->addressData->attributes=$values['AddressData'];
        $this->adres->attributes=$values['Adres'];
    }

    public function validate()
    {
        $validated=$this->adres->validate();
        if(!$this->addressData->validate())
            $validated=false;

        return $validated;
    }

    public function saveTransaction()
    {
        if($this->adres->save(false))
        {
            $this->addressData->id_adresu=$this->adres->id;
            $this->addressData->id_klienta=$this->klient->id_uzytkownika;
            
            if($this->addressData->save(false))
               return true;
        }
        return false;
    }
}
?>
