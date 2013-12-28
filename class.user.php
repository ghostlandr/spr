<?php

class User
{
    public $name;
    private $username;
    private $password;
    private $email;
    private $account_type;
    private $created;
    private $approved;
    private $userid;

    function __construct($username, $password, $email, $name, $account_type, $created, $approved, $userid)
    {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->name = $name;
        $this->account_type = $account_type;
        $this->created = $created;
        $this->approved = $approved;
        $this->userid = $userid;
    }

    function __destruct()
    {
        unset($this);
    }

    function is_approved()
    {
        return $this->approved == APPROVED;
    }

    function is_approved_admin()
    {
        return $this->account_type == ADMIN && $this->is_approved();
    }

    function is_deleted()
    {
        return $this->name == "";
    }

    function is_same_id($userid)
    {
        return $this->userid == $userid;
    }

    function is_user()
    {
        return $this->account_type == USER;
    }
}
