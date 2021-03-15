<?php

namespace App\Model;

/**
 * create a object of user
 */
class UserModel
{
    public $id;
    public $name;
    public $firstname;
    public $mail;
    public $admin;

    public function __construct($id, $firstname, $name, $mail, $admin)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->name = $name;
        $this->mail = $mail;
        $this->admin = $admin;
    }
}
