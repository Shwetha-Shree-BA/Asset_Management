<?php


/*
* class objective:-Creating the Form for the purpose of adding Assets, Editing 
*  purpose.
*
*/
namespace AssetManagement\Form;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;
use Zend\InputFilter\Input;
use Zend\Form\Element\Select;

class AssetForm extends Form  {

function __construct($name= null,$options, $opt) {

//calling the Parent Constructor.
    parent::__construct('asset');

//setting post method for this form
    $this->setAttribute("method","post");
    $this->setAttribute('id','formid');
    $this->setAttribute('onsubmit','return verify()');
//Adding the hidden element to form (AssetId)
    $this->add(array(
        "name"=>"AssetId",
        "id"=>"id1",
        "attributes"=>array(
            "type"=>"hidden"
            )
        ));
//Adding the AssetName to the Form(AssetName)
    $this->add(array(
        "name"=>"AssetName",
        "id"=>"id2",
        "attributes"=>array(
            "type"=>"text"
            ),
        "options"=>array(
            "lable"=>"AssetName"
            )
    ));
//Selecting the AssetType to the Form(AssetName)

    $this->add(array(
        "name"=>"AssetType",
        "type"=>"Select",
          'options' => array(
            'empty_option' => 'Please select an Type',
            'value_options' => $options,
            )

    ));

//Adding the AssetDesc to the form(AssetDesc)
    $this->add(array(
        "name"=>"AssetDesc",
        "attributes"=>array(
            "type"=>"text"
            ),
        "options"=>array(
            "lable"=>"AssetDesc"
            
            ),
    ));
    
//Adding AssetStatus to Form(AssetStatus)

    $this->add(array(
        "name"=>"AssetStatus",
        "type"=>"Select",
        'options' => array(
            'empty_option' => 'Please select an Type',
            'value_options' => $opt,
            )

    ));

//Adding slno to the Form 
       
    $this->add(array(
        "name"=>"slno",
        "attributes"=>array(
            "type"=>"text"
        ),
        "options"=>array(
            "lable"=>"slno"
        ),
    ));


//Adding testableDevice to the Form:-
        
    $this->add(array(
        "name"=>"testableDevice",
        "type"=>"Checkbox",
        "options"=>array(
            "label"=>"testableDevice ?"
        ),
        
    ));
//Adding DateTime 
/*
    $this->add(array(
    'name' => 'dateTime',
    'type' => 'Zend\Form\Element\DateTime',
));
*/
//Adding the Submit button.

    $this->add(array(
        "name"=>"submit",
        "attributes"=>array(
            "type"=>"submit",
            "value"=>"Add"
        ),
    ));

}

}

?>
