<?php
$this->breadcrumbs=array(
	'Klienci'=>array('indexCustomer'),
	$model->uzytkownik->login,
);
$menu_admin=array();
if(Yii::app()->user->isAdmin)
{
    $menu_admin=array(array('label'=>'Dodaj pracownika', 'url'=>array('createEmployee')),
	array('label'=>'Wyszukaj pracownika', 'url'=>array('adminEmployee')));
}

$this->menu=array_merge($menu_admin, array(

	//array('label'=>'Lista klientów', 'url'=>array('indexCustomer')),
	array('label'=>'Dodaj klienta', 'url'=>array('createCustomer')),
//	array('label'=>'Zaktualizuj dane klienta', 'url'=>array('updateCustomer', 'id'=>$model->id)),
//	array('label'=>'Usuń klienta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Jesteś pewny, że chcesz usunąć konto klienta?')),
	array('label'=>'Wyszukaj klienta', 'url'=>array('adminCustomer')),
        array('label'=>'Edytuj dane firmowe', 'url'=>array('updateCustomerCompany', 'id'=>$model->id_uzytkownika), 'visible'=>$model->isCompany),
        array('label'=>'Aktywuj konto klienta', 'url'=>array('confirm', 'id'=>$model->id_uzytkownika), 'visible'=>($model->uzytkownik->status_uzytkownika==0)),
));
?>

<h1>Dane szczegółowe klienta: <?php echo $model->getName(); ?></h1>

<?php

    if($model->isCompany)
            $companyAttributes=array(
                'klientFirma.firma.nazwa_pelna:text:Pełna nazwa firmy',
                'klientFirma.firma.nazwa_skrocona:text:Skrócona nazwa firmy',
                'klientFirma.firma.nip:text:Nip',
                'klientFirma.firma.regon:text:Regon',
                'klientFirma.firma.telefon:text:Nr telefonu',
                'klientFirma.firma.fax:text:Nr faxu',
                array('label'=>'Typ firmy', 'value'=>Slownik::getDictName('typ firmy', $model->getCompany()->typ_firmy)),
            );
    else
        $companyAttributes=array();

     $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array_merge(array(
	//	'id',
                'uzytkownik.login',
		'uzytkownik.imie',
		'uzytkownik.nazwisko',
		'tel',
		'tel_kom',
		array('name'=>'typ_klienta', 'value'=>Slownik::getDictName('typ klienta', $model->typ_klienta))
	), $companyAttributes),
));

     ?>
