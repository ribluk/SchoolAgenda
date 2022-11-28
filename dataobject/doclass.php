<?php

class doclass
{
    private $id;
    private $classroom;
    private $capacity;
    private $teachers = array();
    private $alumns = array();
    private $subjects = array();

    function __construct($id, $classroom, $capacity)
    {
        $this->id = $id;
        $this->classroom = $classroom;
        $this->capacity = $capacity;
    }


//  GETTERS
    function get_id()
    {
        return $this->id;
    }

    function get_classroom()
    {
        return $this->classroom;
    }

    function get_capacity()
    {
        return $this->capacity;
    }

    function get_teachers()
    {
        return $this->teachers;
    }

    function get_alumns()
    {
        return $this->alumns;
    }

    function get_subjects()
    {
        return $this->subjects;
    }


//  SETTERS
    function set_id($id)
    {
        $this->id = $id;
    }

    function set_classroom($classroom)
    {
        $this->classroom = $classroom;
    }

    function set_capacity($capacity)
    {
        $this->capacity = $capacity;
    }

    function set_teachers($teachers)
    {
        $this->teachers = $teachers;
    }

    function set_alumns($alumns)
    {
        $this->alumns = $alumns;
    }

    function set_subjects($subjects)
    {
        $this->subjects = $subjects;
    }
}
