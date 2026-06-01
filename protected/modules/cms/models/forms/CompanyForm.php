<?php

class CompanyForm extends FormModel
{
    public $klient;
    public $firma;

    public function init()
    {
        $this->firma=new Firma;
    }

    public function setAttributes($values, $safeOnly=true)
    {
        $this->uzytkownik->attributes=$values['Uzytkownik'];
        $this->klient->attributes=$values['Klient'];

        if($this->scenario=='insert')
        {
            $this->adres->attributes=$values['Adres'];
            $this->firma->attributes=$values['Firma'];
            $this->isCompany=$values['isCompany'];
        }
    }

    public function validate()
    {
        $validated=$this->uzytkownik->validate();
        if(!$this->klient->validate())
            $validated=false;
        if($this->scenario!='insert')
                return $validated;
        if(!$this->adres->validate())
            $validated=false;
        if($this->isCompany)
            if(!$this->firma->validate())
                    $validated=false;

        return $validated;
    }

    public function saveTransaction()
    {
        //defaults
        if($this->scenario=='insert')
        {
            $this->uzytkownik->typ_uzytkownika=Slownik::getValue('typ_uzytkownika', 'klient administrator');
            if($this->isCompany)
                $this->klient->typ_klienta=Slownik::getValue('typ klienta', 'firma');
            else
                $this->klient->typ_klienta=Slownik::getValue('typ klienta', 'indywidualny');
        }

        if($this->scenario=='createSubEmployee')
        {
            $this->uzytkownik->scenario='insert';
            $this->klient->scenario='insert';
            $this->uzytkownik->typ_uzytkownika=Slownik::getValue('typ_uzytkownika', 'klient zwykły');
            $this->klient->typ_klienta=Slownik::getValue('typ klienta', 'firma');
        }

        if($this->uzytkownik->save(false))
        {
            $this->klient->id_uzytkownika=$this->uzytkownik->id;

            if($this->klient->save(false))
            {
                if($this->scenario=='createSubEmployee')
                {
                    $klientFirma=new KlientFirma;
                    $klientFirma->id_klienta=$this->klient->id_uzytkownika;
                    $klientFirma->id_firmy=$this->firma->id;
                    if($klientFirma->save(false))
                        return true;
                    else
                        return false;
                }

                if($this->scenario!='insert')
                        return true;

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
                            {
                                $klientFirma=new KlientFirma;
                                $klientFirma->id_klienta=$this->klient->id_uzytkownika;
                                $klientFirma->id_firmy=$this->firma->id;
                                if($klientFirma->save(false))
                                        return true;
                            }
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
