<?php
/*
* Class Objective  is exchange the array of leased user into the leased Object:-
*
*/
namespace AssetManagement\Model;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class leased {
	public $Id;
	public $requestedTime;
	public $returnedTime;
	public $assetId;
	public $userId;
	/**
    * 
    *Exchanging the form data with the Leased Object:-
    * @param $data
    *@param $id
    */ 
	public function exchangeArray($data,$id) {
	    $this->Id = (!empty($data['Id']))? $data['Id'] :null;
        $this->requestedTime  
         = (!empty($data['requestedTime'])) ?  $data['requestedTime'] :null;
        $this->returnedTime  
         = (!empty($data['returnedTime'])) ?  $data['returnedTime'] : null;
        $this->assetId 
         = (!empty($data['assetId'])) ?  $data['assetId'] :null;
		$this->userId 
		 = (!empty($data['userId']))? $data['userId']: $id;
	}
	/**
    * 
    *During the Updation used to bind to the form data this is used:
    * 
    */ 
	public function  getArrayCopy() {
	    return get_object_vars($this);
	}

	/**
    * 
    *During the Updation used to exchange form data with leased Object:-
    * @param $data
    */ 
	public function editexchangeArray($data) {
	
	    $this->Id = (isset($data->Id))? $data->Id :null;
	    $this->requestedTime   
	        = (isset($data->requestedTime))? $data->requestedTime :null;
	    $this->returnedTime  
	        = (isset($data->returnedTime)) ? $data->returnedTime :null;
	    $this->assetId  
	    	= (isset($data->assetId )) ? $data->assetId  :null;
	    $this->userId 
	    	= (isset($data->userId))?$data->userId:null;
	}

} 

?>