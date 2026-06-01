<?php
class QFormatter extends CFormatter {
    public function formatPLN($amount) {
        return number_format($amount,2, ',', ' ').' zł';
    }
    
    public function formatFilename($word)
    {
            $tmp = preg_replace('/^\W+|\W+$/', '', $word); // remove all non-alphanumeric chars at begin & end of string
            $tmp = preg_replace('/\s+/', '_', $tmp); // compress internal whitespace and replace with _
            $tmp=str_replace(array(
                'ę', 'ó', 'ą', 'ś', 'ł', 'ż', 'ź', 'ć', 'ń', 'Ę', 'Ó', 'Ą', 'Ś', 'Ł', 'Ż', 'Ź', 'Ć', 'Ń'),array(
                'e', 'o', 'a', 's', 'l', 'z', 'z', 'c', 'n', 'E', 'O', 'A', 'S', 'L', 'Z', 'Z', 'C', 'N'),
                $tmp);
            $tmp=str_replace(array('\'', '"', '`'), '_', $tmp);//wywal cudzysłowy
            return strtolower(preg_replace('/\W-/', '', $tmp)); // remove all non-alphanumeric chars except _ and -
    }
    
    public function formatPostalCode($code) {
        return substr($code,0,2).'-'.substr($code,2);
    }
    
    public function formatImplodeProperties($objectArray, $propertyNames='id', $returnArray=false, $glue=',', $prefix='', $suffix='') {
        $array=array();
        if(!is_array($propertyNames)) {
            $propertyNames=array($propertyNames);
        }
        foreach($objectArray as $oa) {
            for($i=0;$i<count($propertyNames);$i++) {
                if(isset($oa->$propertyNames[$i])) {
                    $array[]=$prefix.$oa->$propertyNames[$i].$suffix;
                }
            }
        }

        if($returnArray) {
            return $array;
        }
        
        return implode($glue, $array);
    }
    
    public function formatArrayKey($array, $key) {
        if(is_array($array)&&isset($array[$key])) {
            return $array[$key];
        }
        return false;
    }
}

?>
