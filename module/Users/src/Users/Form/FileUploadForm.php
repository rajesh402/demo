<?php
namespace Users\Form;
use Zend\Form\Form;

class FileUploadForm extends Form
{
    public function __construct()        
    { 
         parent::__construct("FileUploadForm");
         $this->setAttribute('method', 'post');
         $this->setAttribute('enctype','multipart/form-data');
         
           $this->add(array(
             'name' => 'id',
             'attributes' => array(
                 'type'  => 'hidden',
                 
             ),
         ));
          
          //File Upload    
         $this->add(array(
            'name' => 'fupload',
            'attributes' => array(
                'type'  => 'file',
                 'id' => 'fupload',
                 
            ),
            'options' => array(
                'label' => 'Upload',                
            ),
        ));  
         
       //Submit button
         $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
                'id' => 'submitbutton',
            ),
        ));  
          
    } //end of construction
}//end of form class
?>
