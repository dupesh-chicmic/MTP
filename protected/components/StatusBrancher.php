<?php
class StatusBrancher
{
    private $description;
    private $statusArray;
    private $currentStatus=null;
    private $startStatusId=-1;

    /**
     * @param $desc string Ustala identyfikator grupy statusów (np.: Status wysyłki zamówienia)
     */
    public function setGroupDesc($desc)
    {
        $this->description=$desc;
    }

    /**
     * @return string sidentyfikator grupy statusów (np.: Status wysyłki zamówienia)
     */
    public function getGroupDesc()
    {
        return $this->description;
    }

    /**
     * @param $statusArray array Ustala bieżącą tabelę statusów:
     * $statusArray[$i]=array('name'=>'nazwa statusu', 'value'=>'wartość statusu, 'branch'=>array('index numeryczny pierwszego możliwego statusu', ... ,'index numeryczny ostatniego możliwego statusu');
     */
    public function setStatusArray($statusArray, $startStatusId=-1)
    {
        $this->statusArray=$statusArray;
        $this->startStatusId=$startStatusId;
    }

    public function getStatusArray()
    {
        return $this->statusArray;
    }
/*
    public static function test()
    {
            $statusArray[ 0]=array('name'=>'złożenie zamówienia','branch'=>array(1,2,3));
            $statusArray[ 1]=array('name'=>'przyjęte do realizacji','branch'=>array(4,5));
            $statusArray[ 2]=array('name'=>'odrzucone - brak wymaganych danych','branch'=>array(1));
            $statusArray[ 3]=array('name'=>'odrzucone - brak materiałów do wytworzenia','branch'=>array());
            $statusArray[ 4]=array('name'=>'sprawdzone merytorycznie','branch'=>array(6));
            $statusArray[ 5]=array('name'=>'do poprawy','branch'=>array(4,5));
            $statusArray[ 6]=array('name'=>'projekt w trakcie','branch'=>array(7,5));
            $statusArray[ 7]=array('name'=>'projekt OK','branch'=>array(8));
            $statusArray[ 8]=array('name'=>'do druku','branch'=>array(9));
            $statusArray[ 9]=array('name'=>'przydzielono matrycę','branch'=>array(10));
            $statusArray[10]=array('name'=>'wydrukowane','branch'=>array(11));
            $statusArray[11]=array('name'=>'przekazane do wysyłki','branch'=>array(15));
            $statusArray[12]=array('name'=>'przedawnione','branch'=>array());
            $statusArray[13]=array('name'=>'reklamowane','branch'=>array(14));
            $statusArray[14]=array('name'=>'reklamacja w toku','branch'=>array(15));
            $statusArray[15]=array('name'=>'wysłane ponownie', 'branch'=>array(15));
            $statusArray[15]=array('name'=>'dostarczone', 'branch'=>array(13,12));
            $this->statusArray=$statusArray;
    }
*/
    public function addStatus($statusId, $statusArray)
    {
        if(!is_array($statusArray))
            throw new Exception('Parameter 1 must be an array.');

        $this->statusArray[$statusId]=$statusArray;
    }

    public function getStatusByName($name)
    {
        foreach($this->statusArray as $s)
        {
            if($s['name']==$name)
                    return $s;
        }

        throw new Exception('Status "'.$name.'" not found');
    }

    public function getStatusById($id)
    {
        if(isset($this->statusArray[$id]))
                return $this->statusArray[$id];

        throw new Exception('Status id "'.$id.'" not found');
    }

    public function setCurrentStatusId($id)
    {
        $this->currentStatus=$this->getStatusById($id);
    }

    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    /**
     * @author Aleksander Stekman
     * @param array tablica asocjacyjna 'Status'
     * 'id'             [int]   =>  //identyfikator statusu
     * 'name            [string]=>  //nazwa właściwa statusu
     * 'displayName'    [string]=>  //nazwa wyświetlana
     * 'branches'       [array] =>  //tablica z identyfikatorami następnych możliwych statusów
     *
     * @return array tablica asocjacyjna tablic 'Status' o kluczach pokrywających się z identyfikatorami statusów
     */
    public function getStatusBranches($status)
    {
        if(empty($status['branches']))
        {
            if($this->existsStatusId($status['id']+1))
                return array($status['id']+1=>$this->getStatusById($status['id']+1));
            return array();
        }
        $branches=array();
        foreach($status['branches'] as $branch)
            $branches[$branch]=$this->getStatusById($branch);
        return $branches;
    }

    public function getCurrentStatusBranches()
    {
        return $this->getStatusBranches($this->currentStatus);
    }

    public function existsStatusId($id)
    {
        try
        {
            $this->getStatusById($id);
        }
        catch(Exception $e)
        {
            return false;
        }
        return true;
    }

    public function setStartStatusId($startStatusId)
    {
        $this->startStatusId=$startStatusId;
    }

    public function statusIdCompare($statusId1, $statusId2)
    {
        if(!$this->existsStatusId($statusId1))
            throw new Exception('Status id "'.$statusId1.'" does not exist');
        if(!$this->existsStatusId($statusId2))
            throw new Exception('Status id "'.$statusId2.'" does not exist');

        if($statusId1==$statusId2)
            return 0;

        if($this->startStatusId==-1)
                throw new Exception ('Status group does not have start status defined');
        $branches=array($this->getStatusById($this->startStatusId));
        
        do
        {
            if(count($branches)>1)
                throw new Exception('Unable to compare status id='.$statusId1.' and id='.$statudId2.'. Branches in status path');

            reset($branches);
            if($branches[key($branches)]['id']==$statusId1)
                    return -1;
            if($branches[key($branches)]['id']==$statusId2)
                    return 1;

            $branches=$this->getStatusBranches($branches[key($branches)]);
        }
        while(!empty($branches));
    }
}
?>
