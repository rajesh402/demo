<?php
namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Users\Model\UserPossession;

class UserPossessionTable
{
    protected $tableGateway;
    protected $dbAdapter;

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->dbAdapter = $dbAdapter;
    }
   
    /*//save by raw query
    public function saveVehicles($last_inserted_uid,$vehicles){      
        for($i = 0; $i < sizeof($vehicles); $i++ ){
             $data = array();
             $data['uname'] = $last_inserted_uid;
             $data['vid'] = $vehicles["$i"];
             $sql = new Sql($this->dbAdapter);
             $insert = $sql->insert();
             $insert->into("user_possession");
             $insert->columns($data);
             $insert->values($data); 
             $sqlString = $sql->getSqlStringForSqlObject($insert);             
             $this->dbAdapter->query($sqlString, Adapter::QUERY_MODE_EXECUTE);

        }
       
    }*/
    
    public function saveVehicles($last_inserted_uid,$vehicles){ 
        if($last_inserted_uid['action'] == "update")
        {
             $this->tableGateway->delete(array('uname' => (int) $last_inserted_uid['id']));
             for($i = 0; $i < sizeof($vehicles); $i++ ){
                $mydata = array();
                $mydata['id'] = '';
                $mydata['uname'] = $last_inserted_uid['id'];
                $mydata['vid'] = $vehicles["$i"];            
                $this->tableGateway->insert($mydata);                
            }
             return 1;
        }else{
             for($i = 0; $i < sizeof($vehicles); $i++ ){
                $mydata = array();
                $mydata['id'] = '';
                $mydata['uname'] = $last_inserted_uid;
                $mydata['vid'] = $vehicles["$i"];            
                $this->tableGateway->insert($mydata);  
                
               // $LastGeneratedValue = $this->dbAdapter->getDriver()->getLastGeneratedValue(); // get the db insert id
                //return $LastGeneratedValue;                
            }
            return 0;
        }                
    } //end of saveVehicles
    
} //end of class