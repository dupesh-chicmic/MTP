<?php
/*
$this->breadcrumbs=array(
        'Panel zarządzania'=>array('/'),
	'Pracownicy'=>array('indexEmployee'),
	$model->uzytkownik->login,
);
$menu_admin=array();
if(Yii::app()->user->isAdmin)
{
    $menu_admin=array(array('label'=>'Dodaj pracownika', 'url'=>array('createEmployee')),
	array('label'=>'Wyszukaj pracownika', 'url'=>array('adminEmployee')));
}

$this->menu=array_merge($menu_admin, array(
//	array('label'=>'Zaktualizuj dane pracownika', 'url'=>array('updateEmployee', 'id'=>$model->id)),
//	array('label'=>'Usuń pracownika', 'url'=>'#', 'linkOptions'=>array('submit'=>array('deleteEmployee','id'=>$model->id),'confirm'=>'Jesteś pewny, że chcesz usunąć konto pracownika?')),
        array('label'=>'Dodaj klienta', 'url'=>array('createCustomer')),
	array('label'=>'Wyszukaj klienta', 'url'=>array('adminCustomer')),
        array('label'=>'Aktualne zamówienia', 'url'=>array('/zamowienia')),

        //array('label'=>'Zatwierdź konto klienta', 'url'=>array('confirm', 'id'=>$model->id), 'visible'=>($model->status=='niezweryfikowany')),
));
?>

<h1>Dane szczegółowe pracownika: <?php echo $model->uzytkownik->getName(); ?> <i>&lt;<?php echo $model->uzytkownik->login; ?>&gt;</i></h1>

<?php

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->uzytkownik,
	'attributes'=>array(
		//'id_uzytkownika',
		'login',
//		'haslo',
		'imie',
		'nazwisko',
		'ostatnie_nieudane_logowanie',
		//'status',
		//'typ_konta_uzytkownika',
		//'data_zatrudnienia',
		//'uprawnienia',
	),

));

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_uzytkownika',
//		'haslo',
		//'imie',
		//'nazwisko',
		//'ostatnie_nieudane_logowanie',
		//'status',
		//'typ_konta_uzytkownika',
		'data_zatrudnienia',
		//'uprawnienia',
	),

));
*/
?>

<?php


$this->beginContent('//layouts/main');
echo '<div class="strona">

            <div class="page">
                <div class="fieldCaption siteFont fieldCaptionLogo">'.$artysta->imie.' '.$artysta->nazwisko.'</div>
                <div class="pageTresc">';

echo '<div class="artistPhoto">';

        $directory = 'pictures/user/'.$artysta->folder.'/m';  //podaje sciezke/nazwa folderu
        if(file_exists($directory)){
            $dir = opendir($directory); //otworzenie folderu

            while($plik_nazwa = readdir($dir))  //odczytywanie
            {
                if(($plik_nazwa!=".")&&($plik_nazwa!="..")) //jesli element != "." i ".."   sprawdze prawidlowo folder w przeciwnym wypadku wyklucza elementy "." i ".."
                    {
                        if($artysta->image == $plik_nazwa){
                           echo'<img src="'.$directory.'/'.$plik_nazwa.'" alt="Brak obrazka" />';
                        }
                    }
            }

            closedir($dir);//zamykam katalog
        }else{ echo 'Folder ze zdjęciami użytkownika "<b><i>'.$artysta->login.'</i></b>" nie został odnaleziony, przepraszamy.';
            header( "refresh:3;url=index.php?r=site/index" );
        }

echo '</div>';
echo '<div class="center">';
    echo '<div class="order">
            ZAMÓW<p>
            •	Koronkowe obrusy<br />
            •	Firanki<br />
            •	Poszewki<br />
            •	Poduszki<br />
            •	narzuty<br />
          </div>';
    echo '<div class="message">Napisz do mnie</div>';
echo '</div>';

echo '<div class="left">
        <div class="aboutMe">';
            echo $artysta->txt;
        echo '</div>';

        echo '<div class="text">';
              echo 'Moi melonowi artyści';
        echo '</div>';

        echo '<div class="photo"><img src="'.$this->module->assetsUrl.'/images/mini_picture1.png" /></div>';
        echo '<div class="photo"><img src="'.$this->module->assetsUrl.'/images/mini_picture2.png" /></div>';
        echo '<div class="photo"><img src="'.$this->module->assetsUrl.'/images/mini_picture3.png" /></div>';

echo'</div>';




echo '<div class="myArt">';
echo 'Moja sztuka';
echo '</div>';

echo '<div class="doForMe">';
echo 'Czy możesz dla mnie zrobić (js) znika po kliknieciu!';
echo ' + button (wysyla na maila z Uzytkownik::model()-> po id';
echo '</div>';

                echo '</div>';




echo '</div>';

echo '</div>';

$this->endContent();

?>