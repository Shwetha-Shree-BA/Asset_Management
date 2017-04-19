<?php
/**
*class Objective:- its a Model class , Interaction with database database operation.
*
*/
namespace AssetManagement\Model;
use Zend\Db\TableGateway\TableGateway;

class leasedoutuserTable {
    protected $tableGateway;

    //Instantiate the Table Gateway Object during the creation of LeasedoutTable Object:-
	public function __construct(TableGateway $tableGateway) {
            $this->tableGateway=$tableGateway;
    }
    /**
    * 
    *Inserting the Row's to the LeasedInfoTable:-
    * @param $leased
    */ 
    public function addLeasedUsers(leased $leased) {
        $data= array(
            'requestedTime'=>$leased->requestedTime,
            'returnedTime'=>$leased->returnedTime,
            'assetId'=>$leased->assetId,
            'userId'=>$leased->userId,
        );
        
            $this->tableGateway->insert($data);

    }
    /**
    * 
    *used to Fetch all the Row's of the LeasedInfoTable:-
    * @return $resultSet
    */ 
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }


    /**
    * Used to update the Return time by the Leased user:-
    * @param $id
    * @param $leased
    */
    public function updateStatus($id,leased $leased) {
        $data = array(
            'returnedTime'=>$leased->returnedTime,
        );
            $this->tableGateway->update($data, array('Id' => (int) $id));
    }


    /**
    * Join Operation  of AssetInfoTable, UserInfoTable , leasedoutuserTable.
    * Used by the Admin to get all the user ,Asset , leased user information:-
    */
    public function joinLeasedOutUser() {
        $sqlSelect = $this->tableGateway->getSql()->select();
		$sqlSelect
            ->columns(array('Id','requestedTime','returnedTime','userId','returnedTime','assetId'));
        $sqlSelect
            ->join('UserInfoTable', 'UserInfoTable.Id = leasedoutuserTable.userId', array('firstname','email'), 'inner');
        $sqlSelect
            ->join('AssetInfoTable', 'AssetInfoTable.AssetId = leasedoutuserTable.assetId', array('AssetName','AssetStatus','AssetDesc'), 'inner');
        $statement 
            = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
		$resultSet = $statement->execute();
		return $resultSet;

    }

    
    /**
    * Used by the LeasedOut User  to fetch the row based on the Id:-
    * @param $id
    * 
    */
    public function getLeasedRow($id) {
        $id  = (int) $id;
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('Id','requestedTime','returnedTime','userId'));
        $sqlSelect->join('UserInfoTable', 'UserInfoTable.Id = leasedoutuserTable.userId', array('firstname','email'), 'inner');
       
        $sqlSelect->join('AssetInfoTable', 'AssetInfoTable.AssetId = leasedoutuserTable.assetId', array('AssetName'), 'inner');
        $sqlSelect->where(array( 'leasedoutuserTable.userId' => $id));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $resultSet;
    }
    /**
    * During the Updation  in order to bind the information of the LeasedUser,
    *  In that case it is Used:-
    * @param $id
    * @return $row
    */
    public function getRowOfLeasedUser($id) {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('userId' => $id));
        $row = $rowset->current();
        return $row;
    }
}

?>