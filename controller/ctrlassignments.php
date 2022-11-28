<?php

class ctrlassignments
{
    public function view()
    {
        include './view/header.php';

        if (isset($_GET['action'])) {
            if ($_GET['action'] == 'actionAssignment') {
                isset($_POST['insertAssignment']) ? self::insertAssignment() : self::updateAssignment();
            } else if ($_GET['action'] == 'deleteAssignment') {
                self::deleteAssignment();
            }
        }

        require_once 'model/moassignment.php';
        $assignmentMo = new moassignment();
        $_POST['allAssignmentRows'] = $assignmentMo->selectAssignments('', 'admin');
        $_POST['targetsAlumns'] = $assignmentMo->selectAssignmentsTargets();
        $_POST['targetsClasses'] = $assignmentMo->selectAssignmentsClasses();
        $_POST['subjectAssignment'] = $assignmentMo->selectAssignmentsSubjects();

        include './view/assignment.php';

        include './view/footer.php';
    }

    public function insertAssignment()
    {
        require_once 'model/moassignment.php';
        require_once 'dataobject/doassignment.php';

        $row = new doassignment($_POST['idInsertAssignment'], $_POST['teacherInsertAssignment'], $_POST['subjectInsertAssignment'], $_POST['descriptionInsertAssignment'], $_POST['deadlineInsertAssignment']);

        $assignmentMo = new moassignment();
        $assignmentMo->insert($row, $_POST['targetInsertAssignment']);
    }

    public function deleteAssignment()
    {
        require_once 'model/moassignment.php';

        $assignmentMo = new moassignment();

        $assignmentMo->delete($_POST['idDeleteAssignment']);
    }

    public function updateAssignment()
    {
        require_once 'model/moassignment.php';
        require_once 'dataobject/doassignment.php';

        $row = new doassignment($_POST['idInsertAssignment'], $_POST['teacherInsertAssignment'], $_POST['subjectInsertAssignment'], $_POST['descriptionInsertAssignment'], $_POST['deadlineInsertAssignment']);

        $assignmentMo = new moassignment();
        $assignmentMo->update($row, $_POST['targetInsertAssignment']);
    }
}
