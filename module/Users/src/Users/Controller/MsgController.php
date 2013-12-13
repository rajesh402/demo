<?php
namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class MsgController extends AbstractActionController
{ 
     public function msgAction()
    {
        // Turn off the layout, i.e. only render the view script.
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);       
        
        return $viewModel;
    }
    
}
