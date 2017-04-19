<?php
/*
* Class Objective:-  Objective is converting the array into Asset Object.
*
*/
namespace AssetManagement\Model;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
class Asset  {

	public $AssetId;
	public $AssetName;
	public $AssetType;
	public $AssetDesc;
	public $AssetStatus;
	public $slno;
	public $testableDevice;
	

	/*
	*InOrder to Exchange the form Data with the Asset Object:-
	* @param $data.
	*/
    public function exchangeArray($data) {
		
	    $this->AssetId   
	        = (!empty($data['AssetId']))? $data['AssetId'] :null;
	    $this->AssetName   
	        =  (!empty($data['AssetName'])) ?  $data['AssetName'] :null;
	    $this->AssetType 
	        =  (!empty($data['AssetType'])) ?  $data['AssetType'] :null;
	    $this->AssetDesc
            =  (!empty($data['AssetDesc'])) ?  $data['AssetDesc'] :null;
	    $this->AssetStatus
            =  (!empty($data['AssetStatus']))? $data['AssetStatus']:null;
	    $this->slno 
	        =  (!empty($data['slno']))? $data['slno']:null;
	    $this->testableDevice
	        = (!empty($data['testableDevice']))? $data['testableDevice']:0;
	}

	/*
	*For Editing exchanging the form data with Asset object:-
	* @param $data
	*/	
    public function editexchangeArray($data) {
	
	    $this->AssetId   
	        = (isset($data->AssetId))? 	$data->AssetId :null;
	    $this->AssetName   
	        =  (isset($data->AssetName))? $data->AssetName :null;
	    $this->AssetType  
	        =  (isset($data->AssetType)) ? $data->AssetType :null;
	    $this->AssetDesc  
	        =  (isset($data->AssetDesc)) ? $data->AssetDesc :null;
	    $this->AssetStatus 
	        =  (isset($data->AssetStatus))?$data->AssetStatus:null;
	    $this->slno 
	        =  (isset($data->slno))? $data->slno:null;
	   $this->testableDevice
	        = (isset($data->testableDevice))? $data->testableDevice:0;
	}
	/*
	*This is used in Binding the data for EDiting purpose:-
	* @return objectvariable.
	*/
    public function  getArrayCopy() {
		return get_object_vars($this);
	}



}
?>