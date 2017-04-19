<?php
/**
* Class Objective Is to perform the interaction with Role Table:-
*/
namespace UserInfo\Model;
use Zend\Db\TableGateway\TableGateway;

class Role {
    protected $tableGateway;
    /**
	* instantiating the table gateway object.
	* @param $tableGateway.
    */
    public function __construct(TableGateway $tableGateway) {
            $this->tableGateway=$tableGateway;
    }
	/**
	*featching all the rows from the rowtable.
	* @return $resultSet.
	*/
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
}

?>