<?php

class ctrlusers
{
    public function view()
    {
        include './view/header.php';

        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'actionUser') {
                isset($_POST['insertUser']) ? self::insertUser() : self::updateUser();
            } else if ($_GET['action'] == 'deleteUser') {
                self::deleteUser();
            }
        }

        require_once 'model/mouser.php';
        $userMo = new mouser();
        $_POST['allUserRows'] = $userMo->selectAll();

        include './view/users.php';

        include './view/footer.php';
    }

    public function insertUser()
    {
        require_once 'model/mouser.php';
        require_once 'dataobject/douser.php';

        $row = new douser($_POST['emailInsertUser'], $_POST['passwordInsertUser'], $_POST['nameInsertUser'], $_POST['surnameInsertUser'], $_POST['addressInsertUser'], $_POST['dateobInsertUser']);
        $userMo = new mouser();

        if ($_POST['userRadio'] == 'alumn') {
            $row->set_type('alumn');
        } else {
            $row->set_type('teacher');
        }

        $userMo->insert($row);
    }

    public function deleteUser()
    {
        require_once 'model/mouser.php';
        $userMo = new mouser();
        $userMo->delete($_POST['emailDeleteUser']);
    }

    public function updateUser()
    {
        require_once 'model/mouser.php';
        require_once 'dataobject/douser.php';

        $row = new douser($_POST['emailInsertUser'], $_POST['passwordInsertUser'], $_POST['nameInsertUser'], $_POST['surnameInsertUser'], $_POST['addressInsertUser'], $_POST['dateobInsertUser']);
        $userMo = new mouser();

        if ($_POST['userRadio'] == 'alumn') {
            $row->set_type('alumn');
        } else {
            $row->set_type('teacher');
        }

        $userMo->update($row);
    }
}
