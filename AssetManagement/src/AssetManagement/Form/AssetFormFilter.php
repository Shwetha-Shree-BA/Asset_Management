<?php
/*
*class Objective:- It is used for the case of the Validations purpose.
*
*/
namespace AssetManagement\Form;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;
class AssetFormFilter extends InputFilter {
	
	  public function __construct()
	{	
		
		$AssetName= new Input('AssetName');
		$AssetName->setRequired(true)
				->getFilterChain()
				->attach(new StringTrim())
				->attach(new StripTags());
		$AssetName->getValidatorChain()->attach(new NotEmpty());
		$this->add($AssetName);


		$AssetType= new Input('AssetType');
		$AssetType->setRequired(true)
				->getFilterChain()
				->attach(new StringTrim())
				->attach(new StripTags());
		$AssetType->getValidatorChain()->attach(new NotEmpty());
		$this->add($AssetType);


		$AssetDesc= new Input('AssetDesc');
		$AssetDesc->setRequired(true)
				->getFilterChain()
				->attach(new StringTrim())
				->attach(new StripTags());
		$AssetDesc->getValidatorChain()->attach(new NotEmpty());
		$this->add($AssetDesc);


		$AssetStatus= new Input('AssetStatus');
		$AssetStatus->setRequired(true)
				->getFilterChain()
				->attach(new StringTrim())
				->attach(new StripTags());
		$AssetStatus->getValidatorChain()->attach(new NotEmpty());
		$this->add($AssetStatus);



	}
}