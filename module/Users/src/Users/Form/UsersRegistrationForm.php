<?php
namespace Users\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Db\TableGateway\TableGateway;

class UsersRegistrationForm extends Form implements InputFilterProviderInterface
{

    public function __construct()
    {
        parent::__construct("UsersRegistrationForm");
        $this->setAttribute('method', 'post');
        //$this->setAttribute('action', 'newuid');
        //$this->setAttribute('action', $this->url('index', array('action' => 'newuid')));
        $this->add(array(
             'name' => 'id',
             'attributes' => array(
                 'type'  => 'hidden',
                 
             ),
         ));
        //multicheckbox		
	   $this->add(array(
            'type' => 'Zend\Form\Element\MultiCheckbox',
            'name' => 'what',
            'options' => array(
                'label' => 'What You Have?',
                'value_options' => array(
                    '1' =>'Car',
                    '2'=>'Mobile',
                    '3'=>'Bike',
                    '4'=>'Scooter'
                ),
            ),
            'attributes' => array(
                'value' => '1' //set checked to '1'
            )
        ));
      //first name    
         $this->add(array(
            'name' => 'fname',
            'attributes' => array(
                'type'  => 'text',
                 'id' => 'fname',
                 
            ),
            'options' => array(
                'label' => 'First Name',
                
            ),
        )); 
         
       //Last name    
         $this->add(array(
            'name' => 'lname',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'lname',
            ),
            'options' => array(
                'label' => 'Last Name',
            ),
        )); 
        // title="Please select at least two cars, but no more than three" validate="required:true, rangelength:[2,3]"
         //State List    
         $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'ustate',            
            'options' => array(
            'label' => 'State',
           ),
            'attributes' => array(
                'value' => '0' ,//set selected to '1',
                'id' => 'ustate',
                'class' => 'ustate',                
            )
        ));

         //ZIP    
         $this->add(array(
            'name' => 'uzip',
            'attributes' => array(
                'type'  => 'text',
                'id' => 'uzip',
            ),
            'options' => array(
                'label' => 'ZIP',
            ),
        )); 
         
        //Gender 
        $this->add(array(            
            'name' => 'ugender',
            'type' => 'Zend\Form\Element\Radio', 
            'options' => array(
                'label' => 'Gender',
                'value_options' => array(
                    '1' => 'Male',
                    '2' => 'Female',
                ),
            ),
            'attributes' => array(
                  'value' => '1', //set checked to '1'
                  'id' => 'ugender',
                  'class' => 'ugender',
            )
        ));
        
        //email
         $this->add(array(
            'name' => 'uemail',
		'attributes' => array(
                'type'  => 'Email',
                'id' => 'uemail',
		'placeholder' => 'you@domain.com',
                 'class' => 'uemail',
                 'id' => 'uemail',
                 
            ),            
            'options' => array(
                'label' => 'Email',
               
            )
        ));
         
		
		//DOB
         $this->add(array(
            'name' => 'ubirth',
            'attributes' => array(
                'type'  => 'date',
                 'id' => 'ubirth',				 
                 'class' => 'ubirth',
                 'id' => 'ubirth',
                 
            ),            
            'options' => array(
                'label' => 'ubirth',
               
            )
        ));
		
         //User name  userpass
         $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'date',
                'id' => 'username',
            ),
            'options' => array(
                'label' => 'User Name',
            ),
             'attributes' => array(
                 'class' => 'username',
                 'id' => 'username',
            )
        ));
         
         //User Password
         $this->add(array(
            'name' => 'userpass',
             'id' => 'userpass',
            'options' => array(
                'label' => 'Password',
            ),
             'attributes' => array(
                 'class' => 'userpass',
                 'id' => 'userpass',
				   'type'  => 'Password',
            )
        ));
         
         //User Confirm Password
         $this->add(array(
            'name' => 'confpass',
            'options' => array(
                'label' => 'Confirm Password',
            ),
             'attributes' => array(
                 'class' => 'confpass',
                 'id' => 'confpass',
				  'type'  => 'Password',
            )
        ));
         
       
         //submit button
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'id' => 'submitbutton',
            ),
        ));
        
        //reset button
         $this->add(array(
            'name' => 'reset',
            'attributes' => array(
                'type'  => 'reset',
                'value' => 'Reset',
                'id' => 'submitbutton',
            ),
        ));

       
    }

public function getInputFilterSpecification() {
        return array(
            'fname' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message' => 'Enter your First Name'
                        )
                    )
                )
            ), 
            
             'lname' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message' => 'Enter your Last Name'
                        )
                    )
                )
            ),
            
            'uemail' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message' => 'Email address is required'
                        )
                    ),
                    array(
                        'name' => 'EmailAddress',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 255,
                            'messages' => array(
                                \Zend\Validator\EmailAddress::INVALID_FORMAT => 'Email address format is invalid'
                            )
                        )
                    ),


                )

            ),
            
            
            'userpass' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message' => 'Password is required'
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => '6',
                            'message' => 'Password should be atleast 6 characters long.'
                        )
                    )
                )

            ),


            'confpass' => array(
                'required' => true,
                'filters' => array(
                    array('name' => 'StringTrim'),
                    array('name' => 'StripTags')
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'message' => 'Confirm Password is required'
                        ),
                    ),
                    array(
                        'name' => 'identical',
                        'options' => array(
                            'token' => 'userpass',
                            'message' => 'Confirm Password Should be same as Password field'
                        )
                    ),
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'min' => '6',
                            'message' => 'Password should be atleast 6 characters long.'
                        )
                    )

                )

            ),

            
            
        );
    }
}
?>
