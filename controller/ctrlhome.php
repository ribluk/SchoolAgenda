<?php

class ctrlhome
{
    public function route()
    {
        if (isset($_GET['controller'])){
            $controller = $_GET['controller'];
        } else {
            $controller = 'ctrlhome';
        }

        require_once 'controller/' . $controller . '.php';
        $controller = new $controller();
        $controller->view();
    }

    public function view()
    {
        require_once 'model/moassignment.php';
        require_once 'dataobject/doassignment.php';

        $assignmentMo = new moassignment();

        if(isset($_POST['emailCalendar'])){
            $_POST['calendarAssignments'] = $assignmentMo->selectAssignments($_POST['emailCalendar'], $_POST['typeCalendar']);
        } else {
            $_POST['calendarAssignments'] = $assignmentMo->selectAssignments('', 'admin');
        }


        include './view/header.php';
        include './view/calendar.php';
        include './view/footer.php';
    }
}
