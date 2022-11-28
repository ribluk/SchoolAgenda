<?php

class ctrlclasses
{
    public function view()
    {
        include './view/header.php';

        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'actionClass':
                    isset($_POST['insertClass']) ? self::insertClass() : self::updateClass();
                    break;
                case 'deleteClass':
                    self::deleteClass();
                    break;

                case 'actionClassesUser':
                    isset($_POST['insertClassesUser']) ? self::insertClassesUser() : self::deleteClassesUser();
                    break;
            }
        }

        require_once 'model/moclass.php';


        $classmo = new moclass();
        $_POST['allClassRows'] = $classmo->selectAll();

        include './view/classes.php';
        include './view/footer.php';
    }


    public function insertClass()
    {
        require_once 'model/moclass.php';
        require_once 'dataobject/doClass.php';

        $row = new doclass($_POST['idInsertClass'], $_POST['classroomInsertClass'], $_POST['capacityInsertClass']);
        $classMo = new moclass();
        $classMo->insert($row);
    }

    public function deleteClass()
    {
        require_once 'model/moclass.php';
        $classMo = new moclass();
        $classMo->delete($_POST['idDeleteClass']);
    }

    public function updateClass()
    {
        require_once 'model/moclass.php';
        require_once 'dataobject/doclass.php';

        $row = new doclass($_POST['idInsertClass'], $_POST['classroomInsertClass'], $_POST['capacityInsertClass']);
        $classMo = new moclass();

        $classMo->update($row);
    }


    public function insertClassesUser()
    {
        require_once 'model/moclass.php';

        $classMo = new moclass();
        if ($_POST['classesUserRadio'] == 'teacher') {
            $subject = $_POST['subjectInsertClassesUser'];
            $classMo->insertUserInClass($_POST['emailClassesUser'], $_POST['classTarget'], $subject);
        } else {
            $classMo->insertUserInClass($_POST['emailClassesUser'], $_POST['classTarget'], '');
        }
    }

    public function deleteClassesUser()
    {
        require_once 'model/moclass.php';

        $classMo = new moclass();
        if ($_POST['classesUserRadio'] == 'teacher') {
            $classMo->deleteUserInClass($_POST['emailClassesUser'], $_POST['classTarget'], $_POST['subjectInsertClassesUser']);
        } else {
            $classMo->deleteUserInClass($_POST['emailClassesUser'], $_POST['classTarget'], '');
        }
    }
}
