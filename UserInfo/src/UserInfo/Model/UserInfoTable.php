<?php

/**
* Class Objective Is to perform the interaction with UserInfoTable:-
*/
namespace UserInfo\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select as Select;


//Table class for the Database Table.
class UserInfoTable {
    //This will do the database operation using $tableGateway
    protected $tableGateway;
    //Service Manager injects the TableGateway Object to this class.
    public function __construct(TableGateway $tableGateway) {
            $this->tableGateway=$tableGateway;
    }
    /**
    *Fetching all the rows of the selected coloumn.
    * @return resultSet Object.
    */
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    /**
    *Row Information by userId for binding:-
    *
    * @return $row.
    */
    public function getUser($id) {
        
        $id  = (int) $id;
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('firstname','lastname','email',       
            'gender','roleid'));
        $sqlSelect->join('userhasassetsTable', 'userhasassetsTable.userId = UserInfoTable.Id', array('AssetId'));
        $sqlSelect->where(array( 'UserInfoTable.Id' => $id));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
       /* foreach ($resultSet as $key => $value) {
            print_r($value);
        }exit();*/
        return $resultSet;
    }
    /**
    *updation:-
    *
    * @param $id, $user obj
    */
    public function updateUser($id, $user) {
        $data = array(
            'firstname' => $user->firstname,
            'lastname'=>$user->lastname,
            'email'=>$user->email,
            'gender'=>$user->gender,
        );
            $this->tableGateway->update($data, array('Id' => (int) $id));
    }
    /**
    *Inserting the data into database.
    *
    * @param $user obj.
    */
    public function storeUser(User $user) {
        $data= array(

            'firstname'=>$user->firstname,
            'lastname'=>$user->lastname,
            'email'=>$user->email,
            'password'=>$user->password,
            'gender'=>$user->gender,
            'isleasedout'=>$user->isleasedout,
            'roleid'=>$user->roleid,
        );
        $this->tableGateway->insert($data);

    }
    /**
    *Getting the user Information by the Email ID
    *
    *@param $email
    */
    public function getUserInfoByEmail($email) {
        $rowset = $this->tableGateway->select(array('email' => $email));
        $row = $rowset->current();
        return $row;
    }
}
?>