<?php

class doassignment
{
    private $id;
    private $teacher;
    private $subject;
    private $description;
    private $deadline;
    private $targets = array();

    function __construct($id, $teacher, $subject, $description, $deadline)
    {
        $this->id = $id;
        $this->teacher = $teacher;
        $this->subject = $subject;
        $this->description = $description;
        $this->deadline = $deadline;
    }


    function get_id()
    {
        return $this->id;
    }

    function get_teacher()
    {
        return $this->teacher;
    }

    function get_subject()
    {
        return $this->subject;
    }

    function get_description()
    {
        return $this->description;
    }

    function get_deadline()
    {
        return $this->deadline;
    }

    function get_targets()
    {
        return $this->targets;
    }


    function set_id($id)
    {
        $this->id = $id;
    }

    function set_teacher($teacher)
    {
        $this->teacher = $teacher;
    }

    function set_subject($subject)
    {
        $this->subject = $subject;
    }

    function set_description($description)
    {
        $this->description = $description;
    }   

    function set_deadline($deadline)
    {
        $this->deadline = $deadline;
    }

    function set_targets($targets)
    {
        $this->targets = $targets;
    }
}
