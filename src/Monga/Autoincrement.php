<?php

/**
 * A Monga auto increment helper class, returns the next available auto 
 * incremented id. <br />
 * 
 * 
 * 
 * 
 * @author SergeiStuchin
 */
namespace Monga;

use Mongo;
use MongoCollection;



class Autoincrement {

    private $_counterCollectionName = "auto_increments";
    private $_collectionName;
    private $_dbName;

    //
    public function __construct($collectionName)
    {
        $this->_collectionName = $collectionName;
        //$this->_dbName = $dbName;
        $this->_dbName =$GLOBALS["database"];
    }
    
    /**
     * returns the next available auto incremented id
     * 
     * @return integer
     */
    public function getNext()
    {

        //$dbName = $this->_dbName;
        $counterCollName = $this->_counterCollectionName;
        $collName = $this->_collectionName;
        
        // get the next available id
        $nextAvailableId = $this->_getNextAutoIncrementId();

        // if it's null, then there is no entry in the db, create one
        if(!$nextAvailableId) {
            $this->_createTheObject();
            return 1;
        }

        return $nextAvailableId;
    }
    
       
    
    private function _createTheObject()
    {
        $counterCollName = $this->_counterCollectionName;
        $this->_dbName->collection($counterCollName)
                    ->insert(array(
                        "_id" => $this->_collectionName, 
                        "id" => new MongoInt32("1")
                    
                        ));
    }
    
    /**
     * finds the next available id and increases the counter
     * 
     * @param 
     * @return integer 
     */
    private function _getNextAutoIncrementId() 
    {
      

        $counterCollName = $this->_counterCollectionName;
        $collection = $this->_dbName->collection($counterCollName);
        $result = $collection->findOne(array('_id' => ($this->_collectionName)));
        $result["id"]++;
        $collection->save($result);

        // check if there is an error
        if(!$result)
            return false;
        
        return $result["id"];

    }
    
}
