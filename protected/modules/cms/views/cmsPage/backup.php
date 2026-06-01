<?php
$this->breadcrumbs=array(
	'Backup',
);

?>

<h1>Backup bazy danych</h1>

<?php
        //Lista kopii
echo '<div class="operations"><div class="boxNewPage"><img alt="arrow" src="'.$this->module->assetsUrl.'/images/admin/img/arrow.png"></a><div class="text">Lista kopii baz danych</div></div>';       
        echo '<div class="menu_universal_el">';
                //echo'<div class="universal_element"><strong>Lista kopii baz danych:</strong></div>';

                $directory = 'backup/';  //podaje sciezke/nazwa folderu
                if(file_exists($directory)){
                    $dir = opendir($directory); //otworzenie folderu
                }else{ echo "Nie znalazłem folderu"; return; }

                while($plik_nazwa = readdir($dir))  //odczytywanie
                {
                    if(($plik_nazwa!=".")&&($plik_nazwa!="..")){
                        echo '<div class="universal_element"><a href="index.php?r=cms/cmsPage/backup&&restore='.$plik_nazwa.'">'.$plik_nazwa.'</a> / <a class="del" href="index.php?r=cms/cmsPage/backup&&delete='.$plik_nazwa.'"> X</a></div>';
                    }
                }

                closedir($dir);//zamykam katalog

        echo '</div>';
echo '</div>'; //operations


echo '<div class="content">';
        //BACKUP

        echo '<div class="form">';

        echo '<div style="float:left;"><strong>Kopia zapasowa bazy danych</strong>
        <p>
        Wykonanie kopii bezpieczeństwa
        bazy danych jest zalecane min. w celu ochrony przed niespodziewaną utratą danych.
        </div>
        ';

             $form_backup=$this->beginWidget('CActiveForm', array(
                    'id'=>'cms-universal-form',
                    'enableAjaxValidation'=>false,
            ));
                                 echo $form_backup->checkBox($model, 'param_1').' ';
                                 echo CHtml::submitButton('Wykonaj kopię bezpieczeństwa');

            echo '</div>'; //class form
              $this->endWidget();


            //RESTORE

        echo '<div class="form">';

            echo '<div style="float:left;"><strong>Wczytanie bazy danych</strong>
            <p>
            Czy na pewno chcesz wczytać baze danych? <span style="color:red;">Zastąpi ona istniejącą.</span>
            </div>
            ';

             $form_restore=$this->beginWidget('CActiveForm', array(
                    'id'=>'cms-universal-form',
                    'enableAjaxValidation'=>false,
            ));


             if(isset($_GET['restore'])){
                 $nazwaBazy = $_GET['restore'];
                 echo '<span style="color:red;">'.$nazwaBazy.'</span><p>';
                 //echo $form_backup->textField($model, 'param_2', array('disabled'=>'disabled',)).'<p>'; //, array('disabled'=>'disabled',)
             }
                                 echo $form_backup->checkBox($model, 'param_2').' ';
                                 echo CHtml::submitButton('Wczytaj kopię bezpieczeństwa');
        echo '</div>'; //class form

echo '</div>';

        $this->endWidget();
      
?>