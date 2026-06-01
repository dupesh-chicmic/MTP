<?php
/*
 * formularz dodania danych klienta indywidualnego lub firmy
 * używany: siteController->actionNewCustomer
 */

class CustomerPersonalForm extends FormModel
{
    public $isCompany;
    public $uzytkownik;
    public $klient;
    public $adres;
    public $firma;

    public function init()
    {
        $this->isCompany=0;
        $this->uzytkownik=new Uzytkownik;
        $this->klient=new Klient;
        $this->adres=new Adres;
        $this->firma=new Firma;
    }

    public function setAttributes($values, $safeOnly=true)
    {
        $this->isCompany=$values['isCompany'];
        $this->uzytkownik->attributes=$values['Uzytkownik'];
        $this->klient->attributes=$values['Klient'];
        $this->adres->attributes=$values['Adres'];
        $this->firma->attributes=$values['Firma'];
    }

    public function validate()
    {
        $validated=$this->uzytkownik->validate();
        if(!$this->klient->validate())
            $validated=false;
        if(!$this->adres->validate())
            $validated=false;
        if($this->isCompany)
            if(!$this->firma->validate())
                    $validated=false;

        return $validated;
    }

    public function saveTransaction()
    {
        $this->uzytkownik->typ_uzytkownika=Slownik::getValue('typ_uzytkownika', 'klient administrator');
        if($this->uzytkownik->save(false))
        {
            $this->klient->id_uzytkownika=$this->uzytkownik->id;
            if($this->isCompany)
                    $this->klient->typ_klienta=Slownik::getValue('typ klienta', 'indywidualny');
            else
                $this->klient->typ_klienta=Slownik::getValue('typ klienta', 'firma');
            if($this->klient->save(false))
            {
                if($this->adres->save(false))
                {
                    if($this->isCompany)
                    {
                        if($this->firma->save(false))
                        {
                            $firmaAdres=new FirmaAdres;
                            $firmaAdres->id_firmy=$this->firma->id;
                            $firmaAdres->id_adresu=$this->adres->id;
                            //wartości domyślne
                            $firmaAdres->domyslny=1;
                            $firmaAdres->odbiorca=$this->firma->nazwa_pelna.' '.$this->uzytkownik->getName();
                            $firmaAdres->typ_adresu=Slownik::getValue('typ_adresu', 'do faktury');
                            if($firmaAdres->save(false))
                                    return true;
                        }
                    }
                    else
                    {
                        $klientAdres=new KlientAdres;
                        $klientAdres->id_klienta=$this->klient->id_uzytkownika;
                        $klientAdres->id_adresu=$this->adres->id;
                        //wartości domyślne
                        $klientAdres->domyslny=1;
                        $klientAdres->odbiorca=$this->uzytkownik->getName();
                        $klientAdres->typ_adresu=Slownik::getValue('typ_adresu', 'do faktury');
                        if($klientAdres->save(false))
                            return true;
                    }
                }
            }
        }
        return false;
    }
}
?>
