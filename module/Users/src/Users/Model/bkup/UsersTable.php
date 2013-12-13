<?php 
namespace Users\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;



class UsersTable
{
	protected $tableGateway;
	protected $dbAdapter;

	public function __construct(Adapter $dbAdapter, TableGateway $tableGateway)
	{
	$this->tableGateway = $tableGateway;
        $this->dbAdapter = $dbAdapter;
	}

    public function registration(Users $data)
    {
        $array = array(
            'userid' => $data-> userid,
            'password' => $data-> password,
            'fname' => $data-> fname,
            'lname' => $data-> lname,
            'email'=> $data-> email,
            'mobile' => $data-> mobile,
            'status' => '1',
            'parent_userid' => 'SuperAdmin',
            'created_by' => 'Self',
        );

        return $this-> tableGateway-> insert($array);
    }

    public function getAuthenticUserDetails($userid)
    {
        $sql = new Sql($this-> tableGateway-> getAdapter());

        $select = $sql-> select();
        $select-> columns(array('fname','lname','email','mobile','status',));
        $select-> from(array("u" => "users"));
        $select->where(array( "u.userid='".$userid."'"));

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement-> execute();

        if ($result instanceof ResultInterface && $result->isQueryResult())
        {
            $resultSet = new ResultSet;
            $resultSet->initialize($result);
        }
        return $resultSet-> current();
    }

}
