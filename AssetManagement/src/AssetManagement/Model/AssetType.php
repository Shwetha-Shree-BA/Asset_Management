<?php
/*
*  Class Objective:- is to fetch all AssetType Information.
*/

namespace AssetManagement\Model;
use Zend\Db\TableGateway\TableGateway;

class AssetType {
    
    protected $tableGateway;
	//Creating the object of Table Gateway while instantiating the AssetType:-
	public function __construct(TableGateway $tableGateway) {
            $this->tableGateway=$tableGateway;
    }

    
    /**
    * 
    *Fetching the both AssetTypeId and Asset Type Information from AssetType Table:-
    * @return resultSet obj.
    */ 
    public function fetchAll(){
	    $resultSet = $this->tableGateway->select();
        return $resultSet;
	}
}

?>