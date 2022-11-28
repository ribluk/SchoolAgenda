<?php

class douser
{
    private $email;
    private $password;
    private $name;
    private $surname;
    private $address;
    private $dateob;
    private $type;

    function __construct($email, $password, $name, $surname, $address, $dateob)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->address = $address;
        $this->dateob = $dateob;
    }

    function get_email()
    {
        return $this->email;
    }

    function get_password()
    {
        return $this->password;
    }

    function get_name()
    {
        return $this->name;
    }

    function get_surname()
    {
        return $this->surname;
    }

    function get_address()
    {
        return $this->address;
    }

    function get_dateob()
    {
        return $this->dateob;
    }

    function get_type()
    {
        return $this->type;
    }

    function set_type($type)
    {
        $this->type = $type;
    }
}
