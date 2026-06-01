<?php
/* Dane startowe */
$page = $this->pageDisplayer->page; // wywolanie $page->pole
/* --- */

    
/* ladowanie mapy */
                    $criteria=new CDbCriteria;                    
                    $criteria->compare('id', $page->pageElement->id_element);
                    $mapa = CmsMap::model()->find($criteria);

                    $criteria=new CDbCriteria;
                    $criteria->compare('id_Map', $page->pageElement->id_element); // z lacznika id mapy wybranej przy dodawaniu strony
                    $ElementyMapy = CmsMapElements::model()->findAll($criteria);   
                    
                    

 
  $skrypt = '

function initialize() {
  var myLatlng = new google.maps.LatLng('.$mapa['mapCenter_wide'].','.$mapa['mapCenter_long'].');
  var myOptions = {
    zoom: '.$mapa['zoom'].',
    center: myLatlng,

    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.'.$mapa['styleControll'].'
    },
    navigationControl: true,
    navigationControlOptions: {
      style: google.maps.NavigationControlStyle.'.$mapa['navControllOpt'].'
    },



    mapTypeId: google.maps.MapTypeId.'.$mapa['type'].'
  }
  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);



';
  //policz wszystkie ikony
  
        $len = sizeof($ElementyMapy);
        foreach ($ElementyMapy as $icon) {
//echo $icon['infoWindow'];
             $skrypt .= 'var image = \'pictures/map_elements/'.$icon['icon_pic'].'\';
  var IKONA'.$icon['id'].' = new google.maps.LatLng('.$icon['icoCenter_width'].','.$icon['icoCenter_long'].');
  var marker'.$icon['id'].' = new google.maps.Marker({
      position: IKONA'.$icon['id'].',
      map: map,
      icon: image,
      title:"'.$icon['title'].'"
  });

var contentString = \'<div id="content">\'+
    \'<div id="siteNotice">\'+
    \'</div>\'+
    \'<p><b>'.$icon['infoWindow'].'</b>\'+
    \'<br>\'+
    \'</div>\';

var infowindow = new google.maps.InfoWindow({
    content: contentString
});



google.maps.event.addListener(marker'.$icon['id'].', \'click\', function() {
  infowindow.open(map,marker'.$icon['id'].');
});

';
            //$i++;

        }

         $skrypt .= '}';
 
    Yii::app()->clientScript->registerScript('mapContentPage', $skrypt, CClientScript::POS_HEAD);
    
echo '<i>Mapka dojazdu</i><p>';

echo $page->pageElement->maps->title;

    echo '
    <div style="margin: 0 auto; border: 2px solid #6E6552; width:'.$page->pageElement->maps->size_width.'px; height:'.$page->pageElement->maps->size_height.'px; ">
    <div id="map_canvas" style="width:'.$page->pageElement->maps->size_width.'px; height:'.$page->pageElement->maps->size_height.'px;"></div>
    </div>';
                            


?>
