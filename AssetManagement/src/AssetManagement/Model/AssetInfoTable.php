<?php
/*
*class Objective AssetInfoTable Model Class this class is used forDatabase operation.
* writting quieries using TableGateway.
*/
namespace AssetManagement\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select as Select;

class AssetInfoTable {

    //This will do the database operation using $tableGateway
    protected $tableGateway;

    //Service Manager injects the TableGateway Object to this class.
    public function __construct(TableGateway $tableGateway) {        
        $this->tableGateway=$tableGateway;
    }

    
    /**
    * Used to Fetch the slno and AssetName from AssetInfoTable:- 
    *
    * @return resultSet
    */ 
    public function fetchName() {
        $status = "available";
        $select = new Select();
        $select->from('AssetInfoTable');
        $select->where(array( 'AssetStatus' => $status ,'testableDevice'=>1));
        $resultSet = $this->tableGateway->selectWith($select);
        return $resultSet;
    }

    /**
    * Used to Update the AssetStatus by the Admin after viewing the leased user  
    */ 
    public function updateAssetStatus($id , Asset $asset) {
        $data = array(
                
            'AssetStatus'=>$asset->AssetStatus,
        
        );
            $this->tableGateway->update($data, array('AssetId' => (int) $id));

    }

    /**
    * Fetching all the AssetInformation by joining with AssetType Table:-
    *
    * @return resultSet obj.
    */ 
    public function fetchAll(){
    
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('AssetId','AssetName','AssetDesc',       
            'AssetStatus'));
        $sqlSelect->join('AssetType', 'AssetType.Id = AssetInfoTable.AssetType', array('AssetType'));
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $resultSet;
    }

    /**
    * Deleting the content of Asset:-
    * @param $id
    *
    */ 
    public function deleteAsset($id){
        $this->tableGateway->delete(array('AssetId' => (int) $id));
    }

    /**
    * getting the AssetInfo Row based on id:
    *@param $id
    *@return $row
    */ 
    public function getAsset($id) {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('AssetId' => $id));
        $row = $rowset->current();
        return $row;
    }
    /**
    * getting Asset Information for the normal Users
    *@param $id
    *@return $resultSet
    */ 
    public function getAssetInfoForUser($id) {
        
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->columns(array('AssetId','AssetName','AssetDesc','AssetStatus'));
        $sqlSelect
            ->join('userhasassetsTable', 'userhasassetsTable.AssetId = AssetInfoTable.AssetId', array());
        $sqlSelect
            ->join('UserInfoTable', 'userhasassetsTable.userId = UserInfoTable.Id', array());
        $sqlSelect
            ->join('AssetType', 'AssetType.Id = AssetInfoTable.AssetType', array('AssetType'));
        $sqlSelect->where(array( 'UserInfoTable.Id' => $id));
        $statement 
            = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        return $resultSet;
    }

    /**
    * updating the Asset content.  
    */ 
    public function updateAsset($id,Asset $asset) {

        $data = array(
            'AssetName' => $asset->AssetName,
            'AssetType'=>$asset->AssetType,
            'AssetDesc'=>$asset->AssetDesc,
            'AssetStatus'=>$asset->AssetStatus,
            'slno'=>$asset->slno,
            'testableDevice'=>$asset->testableDevice,  
        );
            $this->tableGateway->update($data, array('AssetId' => (int) $id));
    }
    /**
    * inserting the Assetdata into AssetInfoTable in myDb Database.
    *@param $asset
    *
    */ 
    public function storeAsset(Asset $asset) {
        $data= array(
            'AssetName'=>$asset->AssetName,
            'AssetType'=>$asset->AssetType,
            'AssetDesc'=>$asset->AssetDesc,
            'AssetStatus'=>$asset->AssetStatus,
            'slno'=>$asset->slno,
            'testableDevice'=>$asset->testableDevice,
        );
        $this->tableGateway->insert($data);
    }
}

?>