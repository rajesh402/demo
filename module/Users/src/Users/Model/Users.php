<?php
namespace Users\Model;

class Users
{
    public $id;
    public $uname;
    public $ustate;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->uname = (isset($data['uname'])) ? $data['uname'] : null;
        $this->ustate = (isset($data['ustate'])) ? $data['ustate'] : null;
    }
}