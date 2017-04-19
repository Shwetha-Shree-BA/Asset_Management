<?php
/**
* Class Objective : creating the Form registration Purpose:-
*/

namespace UserInfo\Form;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\Form\Form;
use Zend\InputFilter\Input;

class  UserForm extends Form  {
    function __construct($name= null, $options ,$opt) {
        //calling the Parent Constructor.
        parent::__construct('user');
        //setting post method for this form
        $this->setAttribute("method","post");
        //setting action for this form (doing the view.)
       
       //Adding the hidden id element to the user table
        $this->add(array(
            "name"=>"Id",
            "attributes"=>array(
                "type"=>"text"
            )
        ));

        //Adding the firstname to the userTable
        $this->add(array(
            "name"=>"firstname",
            "attributes"=>array(
                "type"=>"text"
            ),
            "options"=>array(
                "lable"=>"firstname"
            )
        ));

        //Adding the lastname to the usertable
        $this->add(array(
            "name"=>"lastname",
            "attributes"=>array(
                "type"=>"text"
            ),
            "options"=>array(
                "lable"=>"lastname"
            ),
        ));

        //Adding the password to the usertable
        $this->add(array(
            "name"=>"password",
            "attributes"=>array(
                "type"=>"password"
            ),
            "options"=>array(
                "lable"=>"password"
            ),
        ));
        
        //Adding Email to the usertable
        $this->add(array(
            "name"=>"email",
            "attributes"=>array(
                "type"=>"text",
            ),
            "options"=>array(
                "lable"=>"email"
            ),
        ));

        //Adding Gender to the userTable.
        $this->add(array(
            "name"=>"gender",
            "type"=>"Radio",
            "options"=>array(
                'value_options' => array(
                    '1' => 'Female',
                    '2' => 'Male',
                      
                ),
            ),
        ));

        //Adding  isleasedout user to the userTable
        $this->add(array(
            "name"=>"isleasedout",
            "type"=>"Checkbox",
            "options"=>array(
                "label"=>"isleasedout user ?"
            ),
        ));
        //Adding roleid to the userTable:-
        $this->add(array(
            "name"=>"roleid",
            "type"=>"Select",
            'options' => array(
                'empty_option' => 'Please select an Role',
                'value_options' => $options,
                )

            ));
        //Adding assetid to usertable:-
        $this->add(array(
            "name"=>"assetid",
            "type"=>"Select",
            'options' => array(
                'empty_option' => 'select Asset',
                'value_options' =>  $opt ,
                ),
          
            ));

        //Adding the Submit button.
        $this->add(array(
            "name"=>"submit",
            "attributes"=>array(
                "type"=>"submit",
                "value"=>"Register"
            ),
        ));


    }

}

?>
