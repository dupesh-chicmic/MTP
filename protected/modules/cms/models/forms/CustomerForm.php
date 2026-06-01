<?php
/*
 * formularz dodania danych klienta indywidualnego lub firmy
 * używany: siteController->actionNewCustomer
 */

class CustomerForm extends FormModel
{
    public $isCompany;
    public $uzytkownik;
    public $klient;
    public $adres;
    public $firma; 

    public function init()
    {
        $this->uzytkownik=new Uzytkownik($this->scenario);
        $this->klient=new Klient($this->scenario);
        $this->adres=new Adres;
        $this->firma=new Firma;
        $this->isCompany=0;
    }

    public function setAttributes($values, $safeOnly=true)
    {
        $this->uzytkownik->attributes=$values['Uzytkownik'];
        $this->klient->attributes=$values['Klient'];

        if($this->scenario=='insert')
        {
            $this->adres->attributes=$values['Adres'];
            $this->adres->nazwa=$this->uzytkownik->getName();
            $this->firma->attributes=$values['Firma'];
            $this->isCompany=$values['isCompany'];
            if($this->isCompany)
                $this->adres->nazwa=$this->firma->getName().' '.$this->adres->nazwa;
        }
    }

    public function validate()
    {
        $validated=$this->uzytkownik->validate();
        
        if(!$this->klient->validate()){
            $validated=false;
           // echo "blad klient validate";
        }
        if($this->scenario!='insert')
        {
            //echo "blad scenario validate";
            return $validated;
        }
        if(!$this->adres->validate()){
            //echo "blad adres validate";
            $validated=false;
        }
        if($this->isCompany)
            if(!$this->firma->validate()){
                   //  echo "blad isCompany validate";
                    $validated=false;
            }
        return $validated;
    }

    public function saveTransaction()
    {
        if($this->scenario=='insert')
        {
            //echo "in scenario insert 1";
            $this->uzytkownik->typ_uzytkownika=Slownik::getValue('typ_uzytkownika', 'klient administrator');
            if($this->isCompany){
                  // echo "insert is company";
                $this->klient->typ_klienta=Slownik::getValue('typ klienta', 'firma');
            }
            else{
               // echo "scenario insert else";
                $this->klient->typ_klienta=Slownik::getValue('typ klienta', 'indywidualny');
            }
        }

        if($this->scenario=='createSubEmployee')
        {
                       // echo "in scenario subEmployee  1";
            $this->uzytkownik->scenario='insert';
            $this->klient->scenario='insert';
            $this->uzytkownik->typ_uzytkownika=Slownik::getValue('typ_uzytkownika', 'klient zwykły');
            $this->klient->typ_klienta=Slownik::getValue('typ klienta', 'firma');
        }

        if($this->uzytkownik->save(false))
        {
                      // echo "if yztkownik save";
            $this->klient->id_uzytkownika=$this->uzytkownik->id;
            
            if($this->klient->save(false))
            {  // echo "if klient save";
                if($this->scenario=='createSubEmployee')
                {
                  // echo "if uzytkownik klient scenario";
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

                $this->adres->scenario='findOrInsert';
                if($this->adres->save(false))
                {
                   // echo "adres save";
                    $klientAdres=new KlientAdres;
                    $klientAdres->id_klienta=$this->klient->id_uzytkownika;
                    $klientAdres->id_adresu=$this->adres->id;
                    $klientAdres->domyslny=1;
                    $klientAdres->typ_adresu=Slownik::getValue('typ_adresu', 'do faktury');
                    if($klientAdres->save(false))
                    {
                        //echo "klientadres save";
                        if($this->isCompany)
                        {
                            //echo "is company save";
                            if($this->firma->save(false))
                            {   //echo "firma save";
                                $klientFirma=new KlientFirma;
                                $klientFirma->id_klienta=$this->klient->id_uzytkownika;
                                $klientFirma->id_firmy=$this->firma->id;
                                if($klientFirma->save(false))
                                    return true;
                            }
                        }else {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
}
?>
