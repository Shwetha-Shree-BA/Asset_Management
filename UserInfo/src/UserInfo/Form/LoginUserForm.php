<?php
/**
*Class Objective Creating the form for the Login Users.
*/
namespace UserInfo\Form;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\Input;

class LoginUserForm extends Form {
    function __construct($name= null) {
        parent::__construct('loginuser');
        //setting post method for this form
        $this->setAttribute("method","post");
        
        $this->add(array(
            "name"=>"email",
            "attributes"=>array(
                "type"=>"text"
            ),
            "options"=>array(
                "lable"=>"email"
            ),
        ));

        $this->add(array(
            "name"=>"password",
            "attributes"=>array(
                "type"=>"password"
            ),
            "options"=>array(
                "lable"=>"password"
            ),
        ));
        $this->add(array(
            "name"=>"rememberme",
            "type"=>"Checkbox",
            "options"=>array(
                "label"=>"Remember Me!?"
            ),
        ));
        $this->add(array(
            "name"=>"submit",
            "attributes"=>array(
                "type"=>"submit",
                "value"=>"login"
            ),
        ));


	}
}
?>