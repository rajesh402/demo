<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\FileUploadForm;

class FuploadController extends AbstractActionController
{ 
     public function fuploadAction()
        {
            $form = new FileUploadForm();             
            $request = $this->getRequest();
            if($request-> isPost())
            {
                $form-> setData($request-> getPost());
                if($form-> isValid())
                {
                    return new ViewModel(
                        array(                
                            'form' => $form                
                            ) 
                       );
                }
            }        
            return new ViewModel( array('form'=>$form) ); 
        } //end of fuploadAction    
        
     public function factionAction(){
         
        $sm = $this->getServiceLocator();
        $contactsTable = $sm->get('Users\Model\ContactsTable'); 
        $allowedExts = array("gif", "jpeg", "jpg", "png", "csv");
        $temp = explode(".", $_FILES["fupload"]["name"]);
        $extension = end($temp);       
        if ((($_FILES["fupload"]["type"] == "image/gif")
        || ($_FILES["fupload"]["type"] == "image/jpeg")
        || ($_FILES["fupload"]["type"] == "image/jpg")
        || ($_FILES["fupload"]["type"] == "image/pjpeg")
        || ($_FILES["fupload"]["type"] == "image/x-png")
        || ($_FILES["fupload"]["type"] == "text/csv")        
        || ($_FILES["fupload"]["type"] == "image/png"))        
        && in_array($extension, $allowedExts))
          {
          if ($_FILES["fupload"]["error"] > 0)
            {
                 echo "Return Code: " . $_FILES["fupload"]["error"] . "<br>";
            }
          else
            {
                echo "Upload: " . $_FILES["fupload"]["name"] . "<br>";
                echo "Type: " . $_FILES["fupload"]["type"] . "<br>";
                echo "Size: " . ($_FILES["fupload"]["size"] / 1024) . " kB<br>";
                echo "Temp file: " . $_FILES["fupload"]["tmp_name"] . "<br>";

            if (file_exists("upload/" . $_FILES["fupload"]["name"]))
              {
                    echo $_FILES["fupload"]["name"] . " already exists. ";
              }
            else
              {
                    $path= getcwd()."\public\upload";  
                    move_uploaded_file($_FILES["fupload"]["tmp_name"],
                    $path. $_FILES["fupload"]["name"]);
                    echo "Stored in: " . "upload/" . $_FILES["fupload"]["name"];
                    //get the csv file
                    $path = $path."".$_FILES["fupload"]["name"];                    
                    $store_status = $contactsTable->saveData($path);
                    $msg = array();
                    if($store_status == 1)
                    {                        
                        $msg['status'] = 1;
                        
                    }else
                    {
                         $msg['status'] = 0;
                    }
                     return new ViewModel( array('msg'=>$msg) );
              }
            }
          }
        else
          { 
                 echo "Invalid file";
          }
        return new ViewModel(); 
     } //end of faction   
}
