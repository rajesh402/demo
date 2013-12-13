<?php
namespace Users\Model;

class UserPossession
{
    public $id;
    public $uname;
    public $vid;

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->uname = (isset($data['uname'])) ? $data['uname'] : null;
        $this->vid = (isset($data['vid'])) ? $data['vid'] : null;
    }
}