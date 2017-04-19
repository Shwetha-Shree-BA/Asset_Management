<?php
/**
* Class Objective Is to perform the interaction with UserHasRole Table:-
*/
namespace UserInfo\Model;
use Zend\Db\TableGateway\TableGateway;

class UserHasRole {
    protected $tableGateway;
    /*
    *obj of table gateway:-
    *@param TableGateway.
    */
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway=$tableGateway;
    }
    /*
    *Insert into UserHasRole.
    *@param $userId, $roleId
    */
    public function addUserRole($userId,$roleId) {
        $data= array(
            'userId'=>$userId,
    		'roleId'=>$roleId,
        );
        $this->tableGateway->insert($data);

	}
    /**
    *featching the role from the userhasasset and role Table:-
    *
    *@return $resultSet.
    */
    public function fetchAll() {

        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('roleid'));
        $sqlSelect->join('RoleTable', 'RoleTable.Id = userHasRole.roleid', array('rolename'));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        /*foreach ($resultSet as $key => $value) {
            print_r($value['roleid']);
        }exit();*/
        return $resultSet;


    }



    
}
?>