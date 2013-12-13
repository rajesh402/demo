<?php
namespace Users\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Users\Model\UserPossessionTable;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{ 
    public function indexAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('RegistrationFrm');
        $request = $this->getRequest();
        if($request-> isPost())
        {
            $form-> setData($request-> getPost());
            if($form-> isValid())
            {
                //$form->get('submit')->setValue('Save');
                return new ViewModel(
                    array(                
                        'form' => $form                
                        ) 
                   );
            }
        }         
        return new ViewModel( array('form'=>$form) );        
    }
    
    public function uidAction(){
        $sm = $this->getServiceLocator();
        $usersTable = $sm->get('Users\Model\StatesTable');
        $states = $usersTable-> getState(3);
        return new ViewModel( array('states'=>$states) ); 
    }
    
    public function uidsAction(){
        $sm = $this->getServiceLocator();
        $usersTable = $sm->get('Users\Model\StatesTable');
        $states = $usersTable-> fetchAll();
        return new ViewModel( array('states'=>$states) ); 
    }
    
    //new user registration using raw query
    public function newuidAction(){
        $data = $this->getRequest()->getPost();  
        //echo "<pre>";
        //print_r($data);die;
        $datas = array();$vehicles = array();
        $datas['id'] = $data->id;
        $datas['fname'] = $data->fname;
        $datas['lname'] = $data->lname;
        $datas['ustate'] = $data->ustate;
        $datas['uzip'] = $data->uzip;
        $gen = $data->ugender;
            if($gen == 1){
                 $datas['ugender'] = "Male";
            }else{
                $datas['ugender'] = "Female";
            }         
        $datas['uemail'] = $data->uemail;
        $datas['ubirth'] = $data->ubirth;
        $datas['username'] = $data->username;
        $datas['userpass'] = $data->userpass;
        
        $sm = $this->getServiceLocator();
        $usersTable = $sm->get('Users\Model\UsersTable');        
        $last_inserted_uid = $usersTable -> saveUser($datas);

        $vehiclesTable = $sm->get('Users\Model\UserPossessionTable');
        $vehicle = $vehiclesTable -> saveVehicles($last_inserted_uid,$data->what);
        $msg = array();     
        if($vehicle == 0){
             $msg['user_insert'] = "User Has been registered";
             return new ViewModel( array('msg'=>$msg) );
        }else if($vehicle == 1){
             $msg['user_insert'] = "Upated";
             //$this->redirect()->toUrl("/users/index/usercontrol");
             return new ViewModel( array('msg'=>$msg) );
        }        
        //return new ViewModel( array('user'=>$user) ); 
    }
    
    public function usercontrolAction(){
        $sm = $this->getServiceLocator();
        $usersTable = $sm->get('Users\Model\UsersTable');        
        $results = $usersTable -> showUser();
        return new ViewModel( array('users'=>$results) ); 
    }
    
    public function deleteuserAction(){
        $data = $this->getRequest()->getPost(); 
        $msg = array();
        //echo $this->params('id');         
        $sm = $this->getServiceLocator();
        $usersTable = $sm->get('Users\Model\UsersTable');        
        $effected_rows = $usersTable -> deleteUser($this->params('id'));
        if($effected_rows == 1){
            $msg['info'] = "Record Has been Deleted";          
            //return $this->redirect()->toRoute('users', array('controller' => 'index', 'action' => 'usercontrol'));
            $this->redirect()->toUrl("/users/index/usercontrol");
            //return new ViewModel( array('msg'=>$msg) );
        }else{
            $msg['info'] = "Record Does Not Exits";
            return new ViewModel( array('msg'=>$msg) );
        }
    }
    
    public function edituserAction(){ 
        $id = $this->params('id');
        $sm = $this->getServiceLocator();
        $usersTable = $sm->get('Users\Model\UsersTable');
        $row = $usersTable -> getUser($id);
        $row = $row->current();
        if($row['ugender'] == 'Female'){
            $row['ugender'] = 2;
        }else if($row['ugender'] == 'Male'){
            $row['ugender'] = 1;
        }
        $form = $sm->get('RegistrationFrm');
        $form->bind($row);
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
    }//end of edituserAction
    
}
