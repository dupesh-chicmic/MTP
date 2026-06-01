<?php

class Serialization{

        public function getPathToFile(){
            $path = './protected/modules/cms/config/serialize_file.dat';
            return $path;
        }

        public function deserialize($pathToFile){
            $deserializedFile = unserialize(file_get_contents($pathToFile));
            return $deserializedFile;
        }

        public function serialize($data, $pathToFile){
            $serialize = serialize($data);

            file_put_contents($pathToFile, $serialize);
            //echo "Dane po serializacji > ".$serial;
        }



        public function addConfigElement($data, $title, $key, $val, $pathToFile){
            //$data to jest stary zdeserializowany plik
//            $array= array ($key, $val);
//
//
//            $data[$title] = $array; // dodaje na koniec pliku
            $array= array ($title, $val);
            
            
            $data[$key] = $array; // dodaje na koniec pliku

            //var_dump($data);
            //exit;
            $this->serialize($data,$pathToFile);
        }

        public function deleteConfigElement($data, $title, $key, $pathToFile){
            //edycja elementow tablicy ktora bedzie potem serializowana do pliku
                //$data[$key] = $val;
//            echo $data[$title][0];
//            var_dump($data[$title][0]);
//            //var_dump($data[$title][$key]);
//            exit;
                unset ( $data[$title] );    //wybrany po nazwie
                $this->serialize($data,$pathToFile); // ponowna serializacja bez usunietego elementu
        }

}
?>
