<?php
/*
*class objective:-Form for leased out users, for adding updating and view.
*
*/
namespace AssetManagement\Form;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\Form\Element\Select;
class leasedForm extends Form  {

function __construct($name= null, $opt ,$id ) {

    //calling the Parent Constructor.
    parent::__construct('leasedout');

    //setting post method for this form
    $this->setAttribute("method","post");

    $this->setAttribute('id','leasedformid');
//leasedout table Id:-
    $this->add(array(
        "name"=>"Id",
        "attributes"=>array(
                "type"=>"hidden"
            )
    ));

//leasedout requested time:-
    $this->add(array(
        "name"=>"requestedTime",
        "attributes"=>array(
            "type"=>"text",
            //"disabled" => "disabled"
        ),
        "options"=>array(
            "lable"=>"requestedTime"
        )

    ));
//leased out return time:-
    $this->add(array(
        "name"=>"returnedTime",
        "attributes"=>array(
            "type"=>"text",
           

        ),
            
        "options"=>array(
            "lable"=>"returnedTime"
        )

    ));
//opting the Asset
    $this->add(array(
        "name"=>"assetId",
        "type"=>"Select",
        'options' => array(
            'empty_option' => 'select Asset',
            'value_options' =>  $opt ,
         ),
        "attributes"=>array(
           // "disabled"=>"disabled"
        ),
          
    ));
//opting the user:-
    $this->add(array(
        "name"=>"userId",
        "attributes"=>array(
            "type"=>"text",
            "value"=>$id,
           // "disabled"=>"disabled",
           // 'ignore' => TRUE
            'required' => false
        ),
        "options"=>array(
            "lable"=>"userid"
        )

    ));

//Adding the submit button:-
	$this->add(array(
        "name"=>"submit",
        "attributes"=>array(
            "type"=>"submit",
            "value"=>"submit",
        ),
    ));

}
}
?>