<?php
/*
 * formularz dodania danych klienta indywidualnego lub firmy
 * używany: siteController->actionNewCustomer
 */

class PasswordForm extends FormModel
{
    public $uzytkownik;
    public $oldPassword;
    public $newPassword;
    public $newPasswordR;

    public function setAttributes($values, $safeOnly=true)
    {
        $this->oldPassword=UserIdentity::encryptPassword($values['oldPassword']);
        $this->newPassword=$values['newPassword'];
        $this->newPasswordR=$values['newPasswordR'];
    }

    public function validate()
    {
        if($this->newPassword!=$this->newPasswordR)
        {
            $this->AddError('Haslo', 'Podane hasła różnią się');
            return false;
        }

        if($this->oldPassword!=$this->uzytkownik->haslo)
        {
                $this->AddError('Haslo', 'Hasło konta jest nieprawidłowe');
                return false;
        }

        $this->uzytkownik->haslo=$this->newPassword;
        $this->uzytkownik->scenario='passwordChange';
        $validated=$this->uzytkownik->validate(array('haslo'));
        if(!$validated)
            $this->addError('newPassword', $this->uzytkownik->getError('haslo'));
        $this->uzytkownik->scenario='update';
        return $validated;
    }
}
?>
