<?php
/**
* Class Objective  exchange the Array into the UserObj Table:-
*/
namespace UserInfo\Model;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class  User {

	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $gender;
	public $isleasedout;
	public $roleid;
	protected $inputFilter;

	/*
	*exchanging the form data with the User object:-
	* @param $data
	*/
	public function exchangeArray($data) {
	   $this->Id  =    (!empty($data['Id']))? $data['Id'] :null;
	   $this->firstname  
	       =  (!empty($data['firstname'])) ?  $data['firstname'] :null;
	   $this->lastname   
	       =  (!empty($data['lastname'])) ?  $data['lastname'] :null;
	   $this->email 
	       = (!empty($data['email'])) ? $data['email']:null;
	   $this->password   
	       =  (!empty($data['password'])) ?  $data['password'] :null;
	   $this->gender 
	       =  (!empty($data['gender']))? $data['gender']:null;
	   $this->isleasedout   
	       =  (!empty($data['isleasedout'])) ?  $data['isleasedout'] :0;
	   
	   $this->roleid = (!empty($data['roleid']))? $data['roleid'] :null;
	}

	/*
	*during the updation used for binding:-
	*
	*/
	public function  getArrayCopy() {
	    return get_object_vars($this);
	}

	/*
	*exchanging the form data to the User object:-
	*@param $data
	*/
	public function editexchangeArray($data) {
	    
	    $this->Id   =    (isset($data->Id))? 	$data->Id :null;
        $this->firstname  
            =  (isset($data->firstname))? $data->firstname :null;
		$this->lastname   
		    =  (isset($data->lastname)) ? $data->lastname :null;
		$this->gender 
		    =  (isset($data->gender)) ? $data->gender :null;
		$this->email
		    = (isset($data->email))? $data->email :null;
	}

	/*
	*exchanging the form data with the User asset object:-
	* @param $data
	*/
	public function exchangeAssetArray($data) {
	   $this->Id  =    (!empty($data['Id']))? $data['Id'] :null;
	   $this->firstname  
	       =  (!empty($data['firstname'])) ?  $data['firstname'] :null;
	   $this->lastname   
	       =  (!empty($data['lastname'])) ?  $data['lastname'] :null;
	   $this->email 
	       = (!empty($data['email'])) ? $data['email']:null;
	   $this->assetid   
	       =  (!empty($data['AssetId'])) ?  $data['AssetId'] :null;
	   $this->gender 
	       =  (!empty($data['gender']))? $data['gender']:null;
	   $this->roleid 
	   	   =  (!empty($data['roleid']))? $data['roleid']:null;  
	   
	}

}

?>