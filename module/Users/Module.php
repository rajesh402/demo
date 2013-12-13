<?php
namespace Users;

use Zend\Mvc\ModuleRouteListener;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Driver\ResultInterface;
use Users\model\Users;
use Users\model\UsersTable;
use Users\model\UserPossession;
use Users\model\UserPossessionTable;

use Users\Form\UsersRegistrationForm;

class Module
{
    public function onBootstrap($e)
    {
            $eventManager        = $e->getApplication()->getEventManager();
            $moduleRouteListener = new ModuleRouteListener();
            $moduleRouteListener->attach($eventManager);
            
            $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
            $eventManager        = $e->getApplication()->getEventManager();
            $moduleRouteListener = new ModuleRouteListener();
            $moduleRouteListener->attach($eventManager);
			
            $controller      = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config          = $e->getApplication()->getServiceManager()->get('config');

            $routeMatch = $e->getRouteMatch();
            $actionName = strtolower($routeMatch->getParam('action', 'not-found')); // get the action name

            if (isset($config['module_layouts'][$moduleNamespace][$actionName])) {
                $controller->layout($config['module_layouts'][$moduleNamespace][$actionName]);
            }elseif(isset($config['module_layouts'][$moduleNamespace]['default'])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]['default']);
            }

        }, 100);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
	
	public function getServiceConfig()
        {
            return array(
               'factories' => array(    
                        // For users Table    
                        'Users\Model\UsersTable' => function($sm){
                            $dbAdapter = $sm-> get('Zend\Db\Adapter\Adapter');
                            $tableGateway = $sm->get('UsersTableGateway');
                            $table = new UsersTable($dbAdapter, $tableGateway);
                            return $table;
                        },          
                                
                        'UsersTableGateway' => function($sm){
                            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                            $resultSetPrototype = new ResultSet();
                            $resultSetPrototype->setArrayObjectPrototype(new Users());
                            return new TableGateway('users',$dbAdapter,null,$resultSetPrototype);
                        },
                                
                        // For UserPossession Table
                        'Users\Model\UserPossessionTable' => function($sm){
                            $dbAdapter = $sm-> get('Zend\Db\Adapter\Adapter');
                            $tableGateway = $sm->get('UserPossessionTableGateway');
                            $table = new UserPossessionTable($dbAdapter, $tableGateway);
                            return $table;
                        },          
                                
                        'UserPossessionTableGateway' => function($sm){
                            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                            $resultSetPrototype = new ResultSet();
                            $resultSetPrototype->setArrayObjectPrototype(new UserPossession());
                            return new TableGateway('user_possession',$dbAdapter,null,$resultSetPrototype);
                        },
                                
                        'RegistrationFrm' => function($sm){
                            $dbAdapter = $sm -> get('Zend\Db\Adapter\Adapter');
                            $form = new UsersRegistrationForm( );                            
                            $sql = new Sql($dbAdapter);
                            $select = $sql-> select();
                            $select-> quantifier('DISTINCT');
                            $select-> columns(array('id' , 'sname'));                            
                            $select-> from('state');                            
                            //echo $select->getSqlString($dbAdapter-> getPlatform());
                            $statement = $sql->prepareStatementForSqlObject($select);
                            $result = $statement->execute();
                            if ($result instanceof ResultInterface && $result->isQueryResult())
                            {
                                $resultSet = new ResultSet();
                                $resultSet->initialize($result);
                            }                                                         
                            $statesArray = array();
                            $statesArray[''] = '-- Select --';                            
                            foreach ($resultSet as $st)
                            {                                                        
                                $statesArray[$st->id] = $st->sname;
                            }                            
                            $form-> get('ustate')->setValueOptions($statesArray);
                            return $form;
                        }                                        
               ),//end of factories array
            );
        }   
}
