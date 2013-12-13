<?php
namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Users\Model\Users;

class UsersTable
{
    protected $tableGateway;
    protected $dbAdapter;

    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->dbAdapter = $dbAdapter;
    }
    
     public function getUser($id)
     {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->from('users');
        $select->where(array('id' => $id));
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        
        if ($results instanceof ResultInterface && $results->isQueryResult())
            {
                $resultSet = new ResultSet();
                $resultSet->initialize($results);
            }
        return $resultSet;                 
     }
     
    /*//save user using raw query
    public function saveUser($data){
    $sql = new Sql($this->dbAdapter);
    $insert = $sql->insert();
    $insert->into("users");
    $insert->columns($data);
    $insert->values($data);
    $sqlString = $sql->getSqlStringForSqlObject($insert);
    $results = $this->dbAdapter->query($sqlString, Adapter::QUERY_MODE_EXECUTE);
    if (!$results) {
    throw new \Exception("Insert failed.");
    return 0;
    }else{
    echo "inserted";
    $LastGeneratedValue = $this->dbAdapter->getDriver()->getLastGeneratedValue(); // get the db insert id
    return $LastGeneratedValue;
    }
    //these two lines give the id of last inserted id
    //$LastGeneratedValue = $this->dbAdapter->getDriver()->getLastGeneratedValue(); // get the db insert id
    //return $LastGeneratedValue;
    }*/
    
    
    //save user using prepared statement
    public function saveUser($data){
        $id = $data['id'];
        if ($id == '') {
            $this->tableGateway->insert($data);
            $LastGeneratedValue = $this->dbAdapter->getDriver()->getLastGeneratedValue();
            return $LastGeneratedValue;
        }else{
            $this->tableGateway->update($data, array('id' => $id));
            $myaction = array();
            $myaction['action'] = "update";
            $myaction['id'] = $id;
            return $myaction;
        }            
    } //end of saveUser prepared statement
    
    public function deleteUser($id)
     {       
         return $this->tableGateway->delete(array('id' => (int) $id));
     }
    
    //these two lines give the id of last inserted id
    //$LastGeneratedValue = $this->dbAdapter->getDriver()->getLastGeneratedValue(); // get the db insert id
    //return $LastGeneratedValue;
     
    public function showUser(){
         $sql = new Sql($this->dbAdapter);
         $select = $sql->select();
         $select->from('users');
         $statement = $sql->prepareStatementForSqlObject($select);
         $results = $statement->execute();
         if ($results instanceof ResultInterface && $results->isQueryResult())
            {
                $resultSet = new ResultSet();
                $resultSet->initialize($results);
            }
         return $resultSet;                        
    }
    
    

}//end of class