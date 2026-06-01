<?php
 // $this->beginContent('//layouts/mainFront');
/* MOJ PROFIL PRACOWNIKA / ARTYSTY */

$dict_zarzadzaj_zdjeciami = CmsDictionary::model()->dictionaryGetText('adm_zarzadzaj_zdjeciami');
$dict_na_pewno_usunac = CmsDictionary::model()->dictionaryGetText('adm_na_pewno_usunac');
$dict_dodaj_nowa = CmsDictionary::model()->dictionaryGetText('adm_dodaj_nowa');

        Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/assets/js/tiny_mce/tiny_mce.js',CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScript('form','
           tinyMCE.init({
            mode : "exact",
            elements : "element1,element2,element3,element4,element5",
            language : "en",
            element_format : "xhtml",
            theme : "advanced",
            forced_root_block : false,
            force_br_newlines : true,
            force_p_newlines : false,
            convert_fonts_to_spans : false,
            plugins : "save,advimage,advlink,preview,contextmenu, ibrowser",
            convert_urls : false,
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,sub,sup,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist,|,fontsizeselect,|,code",
            theme_advanced_buttons2 : "link,unlink,|,forecolor,backcolor,|,charmap,image,ibrowser,|,removeformat,cleanup",
            theme_advanced_buttons3 : "",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
extended_valid_elements : "a[name|href|target|align|title|onclick],img[src|style||alt|title|width|height|align],hr[class|width|size|noshade|align],span[class|align|style],br,p",
valid_elements : "blockquote,strong,em,cite,abbr,acronym,p,br,b,i,u,ul,ol,li",
	     external_link_list_url : "example_data/example_link_list.js",
             external_image_list_url : "example_data/example_image_list.js"
        });
        ',CClientScript::POS_HEAD);


/* Menu zalogowanej osoby */

if(isset($_GET['url'])){
    $url = $_GET['url'];
}

//$id = CmsPage::model()->getElement('url', $url, 'CmsPage', 'id'); //aktywny id


echo '<div class="strona">

            <div class="page">
                <div class="fieldCaption siteFont fieldCaptionLogo">Profil: '.$model->imie.' '.$model->nazwisko.' <i>('.$model->login.')</i></div>
                <div class="pageTresc">';

echo '<div class="operations"><a href="index.php?r=site/add_element_popup&pic=1">Edytuj zdjęcie</a> / <a href="index.php?r=site/add_element_popup&txt=1">Edytuj opis</a> /
        <a href="index.php?r=cmsArticle/create&artist=create">Wystaw przedmiot</a>
    </div>';
echo '<div class="artistPhoto">';

        $directory = 'pictures/user/'.$model->folder.'/m';  //podaje sciezke/nazwa folderu
        if(file_exists($directory)){
            $dir = opendir($directory); //otworzenie folderu

            while($plik_nazwa = readdir($dir))  //odczytywanie
            {
                if(($plik_nazwa!=".")&&($plik_nazwa!="..")) //jesli element != "." i ".."   sprawdze prawidlowo folder w przeciwnym wypadku wyklucza elementy "." i ".."
                    {
                        if($model->image == $plik_nazwa){
                           echo'<img src="'.$directory.'/'.$plik_nazwa.'" alt="Brak obrazka" />';
                        }
                    }
            }

            closedir($dir);//zamykam katalog
        }else{ echo 'Folder ze zdjęciami użytkownika "<b><i>'.$model->login.'</i></b>" nie został odnaleziony, przepraszamy.';
            header( "refresh:3;url=index.php?r=site/index" );
        }

echo '</div>';

echo '<div class="left">
        <div class="aboutMe">';
            echo $model->txt;
        echo '</div>';

        echo '<div class="text">';
              echo 'Moi melonowi artyści';
        echo '</div>';

        echo '<div class="photo"><img src="'.$this->module->assetsUrl.'/images/mini_picture1.png" /></div>';
        echo '<div class="photo"><img src="'.$this->module->assetsUrl.'/images/mini_picture2.png" /></div>';
        echo '<div class="photo"><img src="'.$this->module->assetsUrl.'/images/mini_picture3.png" /></div>';

echo'</div>';


echo '<div class="myItems"> Moje przedmioty:<hr></hr>';
                $class='';
                    $criteria=new CDbCriteria;
                    $criteria->order = '`order`';
                    $criteria->compare('owner',Yii::app()->user->getId());
                    $article_z_bazy = CmsArticle::model()->findAll($criteria);
                    
                    $menuLeft = array();
                    echo '<div class="menu_universal_el">';
                    echo '<ul class="admin_menu">';

                        foreach($article_z_bazy as $article){
                            if($article['display']==1 && $article['status']!=0){
                                    echo '<div class="'.$class.'"><a href="index.php?r=cmsArticle/update&&id='.$article['id'].'&artist=create">'.$article['nazwa'].'</a>';
                                    //if($article['deletable']==1){
                                         echo ' / <a class="delete" href="index.php?r=cmsArticle/delete&&id='.$article['id'].'&artist=create" title="Delete" onclick="return confirm(\''.$dict_na_pewno_usunac.'\')"><img alt="Delete" src="'.$this->module->assetsUrl.'/assets/b3f499a1/gridview/delete.png"></a>';
                                    //}
                                    echo '</div>';
                            }
                        }
echo '</div>'; //end myItems
                    echo '</div>';
                    

echo '<div class="myArt">';
echo 'Moja sztuka';
echo '</div>';

                echo '</div>';



echo '</div>';

echo '</div>';


//$this->endContent();
?>