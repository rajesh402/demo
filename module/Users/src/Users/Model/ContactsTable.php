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

class ContactsTable
{
    protected $tableGateway;
    protected $dbAdapter;
    
    public function __construct(Adapter $dbAdapter, TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->dbAdapter = $dbAdapter;
    }
    
    public function saveData($path)
    { 
        if (($handle = fopen($path, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
               
                $row_data = array();   
                
                $row_data['contact_first'] = $data[0];
                $row_data['contact_last'] = $data[1];
                $row_data['contact_email'] = $data[2];
                
                $this->tableGateway->insert($row_data);
            }
            return 1;
            fclose($handle);
        }
    }
}


















?>
