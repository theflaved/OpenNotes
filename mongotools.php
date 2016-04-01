<?php
class mongoWorker
{
    private $connection;
    private $collection;

    function __construct($selCollection){
        $this->connection = (new MongoClient())->selectDB('opennotes');
        $this->collection = new MongoCollection($this->connection, $selCollection);
    }

    function findByValue($key, $value)
    {
        $cursor = $this->collection->find(array($key => $value));
        foreach ($cursor as $item) {
            return ($item);
        }
        return null;
    }

    static function findByValueInCollection($key, $value, $collection)
    {
        $cursor = (new MongoClient())->selectDB('opennotes')->selectCollection($collection)->find(array($key => $value));
        foreach ($cursor as $item) {
            return ($item);
        }
        return null;
    }


    function idGetter($email)
    {
        return $this->findByValue('email', $email)['_id'];
    }

    function docGetter($_id)
    {
        return $this->findByValue('_id', $_id);
    }

    static function usersAdd($email,$pword,$fullname){
        $pword = hash("sha512",$pword);
        $usersWorker = new mongoWorker("users");
        if($usersWorker->collection->findOne(array("email" => $email)) != null) return false;
        $systemWorker = new mongoWorker("systemInfo");
        $uId = $systemWorker->collection->findOne(array('_id' => 'uIdCurr'))['data'];
        $systemWorker->collection->update(array("_id" => "uIdCurr"), array('$set' => array('data' => $uId+1)));
        $usersWorker->collection->insert(array("_id"=> "u$uId", "email" => $email, "pword" => $pword, "fullname" => $fullname));
        return true;
    }
    
    static function docUpdate($collection, $_id, $key, $value){
        $colWorker = new mongoWorker($collection);
        $colWorker->collection->update(array("_id" => "u$_id"), array('$set' => array($key, $value)));
    }
    
    static function docRemove($collection, $_id, $key, $value, $options){
        $
    }
}
?>