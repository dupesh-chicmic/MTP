<?php
/* elementy ze slownika */
$dict_univ_element = CmsDictionary::model()->dictionaryGetText('adm_univ_element');
/* */
$dict_univ_element = 'Settings';

$this->breadcrumbs=array(
	$dict_univ_element,
);

echo 'Z main >> settings >> '.Yii::app()->params['klucz'][1];

echo '<div id="container">';

echo '<h1 style="padding-left:20px;"><img class="navImageBig" src="'.$this->module->assetsUrl.'/images/admin/settings.png" />'.$dict_univ_element.'</h1>';

    include_once './protected/components/Serialization.php';
    $serialization = new Serialization();

    $deserializedArray = $serialization->deserialize( $serialization->getPathToFile() );
    
echo '<table class="universal_elementTable">';
    
   $i=1;
   
   $countEdit = 3; //to bedzie serializowane - nie usuwalne!
   
   if(!empty($deserializedArray)){
   
      if(empty($_GET['edit'])){ 
       //pierwsze uruchomienie
        foreach($deserializedArray as $titleArrayKey => $titleArrayValue){// var_dump($deserializedArray).'<p>';
            foreach($titleArrayValue as $key => $value){


                    echo  '<tr onMouseover="this.bgColor=\'#DDDDDD\'"onMouseout="this.bgColor=\'#F8F8F8\'"><td><div class="universal_element"><strong>'.$i.' '.$titleArrayKey.'</strong><br /><i>'.$titleArrayValue[0].'</i>';

                    echo '</div></td>
                        <td>'.$titleArrayValue[1].'</td>

                        <td><a href="index.php?r=site/editSerializedElement&element='.$titleArrayValue[0].'"><img style="width:24px; height:25px;" src="'.$this->module->assetsUrl.'/images/admin/edit_2.png" alt="Edit"></a></td>';
                             if($titleArrayValue[0] == 'adminlang'){
                                // nie wolno usunac
                             }else{
                                echo'<td><a href="index.php?r=site/deleteSerializedElement&element='.$titleArrayValue[0].'&t='.$titleArrayKey.'"><img style="width:24px; height:25px;" src="'.$this->module->assetsUrl.'/images/admin/delete.png" alt="Delete"></a></td>';
                            }
                        echo '</tr>';
                    $i++;
             break;
            }

        }
        
        
      }else{
          // edytuje
          
//echo 'EDYTUJE';
        foreach($deserializedArray as $titleArrayKey => $titleArrayValue){// var_dump($deserializedArray).'<p>';
            foreach($titleArrayValue as $key => $value){               
                
                    echo  '<tr onMouseover="this.bgColor=\'#DDDDDD\'"onMouseout="this.bgColor=\'#F8F8F8\'"><td><div class="universal_element"><strong>'.$i.' '.$titleArrayKey.'</strong><br /><i>'.$titleArrayValue[0].'</i>';
                    echo '</div></td>';
                        
if($_GET['element'] == $titleArrayValue[0]){//to jego chcemy edytowac
                        echo '<td>
                            <form METHOD="post" ACTION="index.php?r=site/serializeNewElement">
                                <input type="hidden" name="title" value="'.$titleArrayKey.'" />
                                <input type="hidden" name="key" value="'.$titleArrayValue[0].'" />
                                New Value <input type="text" name="value" value="'.$titleArrayValue[1].'" />';
                                    if(isset($_GET['row'])){
                                        $i = $_GET['row'];
                                        
                                    }
                            echo '<input type="submit" value="Update"/> 
                            </form>';
//                            echo '<form METHOD="post" ACTION="index.php?r=site/editSerializedElement&element='.$titleArrayValue[0].'&row=1">
//                            <input type="submit" value="Add new"/>
//                            </form>';
                            echo '</td>';
}else{
    echo '<td>'.$titleArrayValue[1].'</td>';
}
                        echo '<td><a href="index.php?r=site/editSerializedElement&element='.$titleArrayValue[0].'"><img style="width:24px; height:25px;" src="'.$this->module->assetsUrl.'/images/admin/edit_2.png" alt="Edit"></a></td>';
                             if($titleArrayValue[0] == 'adminlang'){
                                // nie wolno usunac
                             }else{
                                echo'<td><a href="index.php?r=site/deleteSerializedElement&element='.$titleArrayValue[0].'&t='.$titleArrayKey.'"><img style="width:24px; height:25px;" src="'.$this->module->assetsUrl.'/images/admin/delete.png" alt="Delete"></a></td>';
                            }
                        echo '</tr>';
                    $i++;
             break;
            }

        }          
          
      }

   }
echo '</table>';  

echo '<div style="padding:10px;">';
echo 'Add new element<p>';

echo '
    <form METHOD="POST" ACTION="index.php?r=site/serializeNewElement">
        Title<input type="text" name="title" />
        Key<input type="text" name="key" />
        Value<input type="text" name="value" />
        <input type="submit" value="OK"/>
    </form>
';

echo '</div>';

echo '</div>';
?>
