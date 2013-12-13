<?php

namespace Users\Model;

class Users
{
    public $id;
    public $userid;
    public $password;
    public $fname;
    public $lname;
    public $email;
    public $mobile;
    public $status;
    public $parent_userid;
    public $created_by;
    public $created_datetime;
   
   public function exchangeArray($data)
   {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->userid = (isset($data['userid'])) ? $data['userid'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->fname = (isset($data['fname'])) ? $data['fname'] : null;
        $this->lname = (isset($data['lname'])) ? $data['lname'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->mobile = (isset($data['mobile'])) ? $data['mobile'] : null;
        $this->status = (isset($data['status'])) ? $data['status'] : '1';
        $this->parent_userid = (isset($data['parent_userid'])) ? $data['parent_userid'] : 'SuperAdmin';
        $this->created_by = (isset($data['created_by'])) ? $data['created_by'] : 'Self';
        $this->created_datetime = (isset($data['created_datetime'])) ? $data['created_datetime'] : date("Y-m-d H:i:s");
   }
   
}
