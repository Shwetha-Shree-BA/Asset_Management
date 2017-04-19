<?php
/**
* Class Objective Is to perform the interaction with userHasAsset Table:-
*/
namespace UserInfo\Model;
use Zend\Db\TableGateway\TableGateway;

class UserHasAsset {
    protected $tableGateway;
    /*
    *table gateway object is created by service manager:-
    * @param TableGateway
    */
    public function __construct(TableGateway $tableGateway) {
            $this->tableGateway=$tableGateway;
    }
    /*
    *Insertion of assetid and userid into userhasAsset table:-
    *@param $assetid, $userid.
    */
    public function addIds($assetid,$userid) {
        $data= array(
           'AssetId'=>$assetid,
    	   'userId'=>$userid,
        );
        $this->tableGateway->insert($data);
    }
}
?>