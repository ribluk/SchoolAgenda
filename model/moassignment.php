<?php

require_once 'database.php';
require_once 'dataobject/doassignment.php';
require_once 'moclass.php';

class moassignment
{
    public static function insert($row, $target)
    {
        //var_dump($row) . '\n<br>';

        try {
            $conn = Database::get_connection();

            $moclass = new moclass();
            $classesId = $moclass->selectClassesId();
            $isAclass = false;
            foreach ($classesId as $id) {
                if ($target == $id) {
                    $isAclass = true;
                    break;
                }
            }

            if ($isAclass) {
                $insertStmnt = $conn->prepare("INSERT INTO assignment (id, teacher, subject, description, deadline) 
                                            VALUES (:id, :teacher, (
                                                SELECT subject FROM teacher_class WHERE teacher=:teacher AND subject=:subject AND class=:target),
                                            :description, :deadline)");

                $conn->beginTransaction();

                $insertStmnt->bindValue(':id', $row->get_id());
                $insertStmnt->bindValue(':teacher', $row->get_teacher());
                $insertStmnt->bindValue(':subject', $row->get_subject());
                $insertStmnt->bindValue(':description', $row->get_description());
                $insertStmnt->bindValue(':deadline', $row->get_deadline());
                $insertStmnt->bindValue(':target', $target);
                $insertStmnt->execute();

                $classUsers = $moclass->selectClassUsers($target);

                foreach ($classUsers as $user) {
                    $insertStmnt = $conn->prepare("INSERT INTO alumn_assignment (alumn, assignment) VALUES (:alumn, :assignment)");

                    $insertStmnt->bindValue(':alumn', $user);
                    $insertStmnt->bindValue(':assignment', $row->get_id());
                    $insertStmnt->execute();
                }
            } else {
                $insertStmnt = $conn->prepare("INSERT INTO assignment (id, teacher, subject, description, deadline) 
                                                VALUES (:id, :teacher, (
                                                    SELECT subject FROM teacher_class WHERE teacher=:teacher AND subject=:subject AND class=(
                                                        SELECT class FROM alumn_class WHERE alumn=:target)), 
                                                :description, :deadline)");

                $conn->beginTransaction();

                $insertStmnt->bindValue(':id', $row->get_id());
                $insertStmnt->bindValue(':teacher', $row->get_teacher());
                $insertStmnt->bindValue(':subject', $row->get_subject());
                $insertStmnt->bindValue(':target', $target);
                $insertStmnt->bindValue(':description', $row->get_description());
                $insertStmnt->bindValue(':deadline', $row->get_deadline());
                $insertStmnt->execute();


                $insertStmnt = $conn->prepare("INSERT INTO alumn_assignment (alumn, assignment) VALUES (:alumn, :assignment)");

                $insertStmnt->bindValue(':alumn', $target);
                $insertStmnt->bindValue(':assignment', $row->get_id());
                $insertStmnt->execute();
            }

            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error insert: " . $e->getMessage();
        }
    }

    public static function update($row, $target)
    {
        try {
            $conn = Database::get_connection();

            $updateAssStmnt = $conn->prepare("UPDATE assignment SET 
                teacher = '" . $row->get_teacher() . "'," .
                "subject = '" . $row->get_subject() . "'," .
                "description = '" . $row->get_description() . "'," .
                "deadline = '" . $row->get_deadline() . "' 
                WHERE id = '" . $row->get_id() . "'");

            $updateAssStmnt->execute();

            $moclass = new moclass();
            $classesId = $moclass->selectClassesId();
            $isAclass = false;
            foreach ($classesId as $id) {
                if ($target == $id) {
                    $isAclass = true;
                    break;
                }
            }

            if ($isAclass) {
                $classUsers = $moclass->selectClassUsers($target);

                foreach ($classUsers as $user) {
                    $deleteToUpdate = $conn->prepare("DELETE FROM alumn_assignment WHERE assignment = '" . $row->get_id() . "'");
                    $deleteToUpdate->execute();
                }

                foreach ($classUsers as $user) {
                    $insertStmnt = $conn->prepare("INSERT INTO alumn_assignment (alumn, assignment) VALUES (:alumn, :assignment)");

                    $insertStmnt->bindValue(':alumn', $user);
                    $insertStmnt->bindValue(':assignment', $row->get_id());
                    $insertStmnt->execute();
                }
            } else {
                $deleteToUpdate = $conn->prepare("DELETE FROM alumn_assignment WHERE assignment = '" . $row->get_id() . "'");
                $deleteToUpdate->execute();

                $updateStmnt = $conn->prepare("INSERT INTO alumn_assignment (alumn, assignment) VALUES (:alumn, :assignment)");
                $updateStmnt->bindValue(':alumn', $target);
                $updateStmnt->bindValue(':assignment', $row->get_id());
                $updateStmnt->execute();
            }
        } catch (PDOException $e) {
            echo "Error update: " . $e->getMessage();
        }
    }

    public static function delete($id)
    {
        try {
            $conn = Database::get_connection();

            // var_dump($email) . '\n<br>';

            $conn->beginTransaction();
            $foreignKeyCheck = $conn->prepare("SET FOREIGN_KEY_CHECKS=1");
            $foreignKeyCheck->execute();
            $conn->commit();

            $conn->beginTransaction();
            $deleteStmnt = $conn->prepare("DELETE FROM assignment WHERE id = '" . $id . "'");
            // var_dump($deleteStmnt);
            $deleteStmnt->execute();
            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error update: " . $e->getMessage();
        }
    }

    public static function selectAssignments($email, $type)
    {
        $assignmentRows = array();
        $query = "";

        try {
            $conn = Database::get_connection();

            switch ($type) {
                case 'admin':
                    $query = "SELECT * FROM assignment";
                    break;
                case 'alumn':
                    $query = "SELECT * FROM assignment WHERE id IN (SELECT assignment FROM alumn_assignment WHERE alumn='" . $email . "')";
                    break;
                case 'teacher':
                    $query = "SELECT * FROM assignment WHERE teacher = '" . $email . "'";
                    break;
            }

            if ($query != "") {
                $selectStmnt = $conn->prepare($query);
                //var_dump($selectStmnt);

                $conn->beginTransaction();
                $selectStmnt->setFetchMode(PDO::FETCH_ASSOC);
                $selectStmnt->execute();
                $assignments = $selectStmnt->fetchAll();
                $conn->commit();

                foreach ($assignments as $assignment) {
                    $assignment = new doassignment($assignment['id'], $assignment['teacher'], $assignment['subject'], $assignment['description'], $assignment['deadline']);

                    $alumnsStmnt = $conn->prepare('SELECT DISTINCT aa.alumn FROM assignment a JOIN alumn_assignment aa ON aa.assignment = "' . $assignment->get_id() . '";');
                    $alumnsStmnt->setFetchMode(PDO::FETCH_ASSOC);
                    $alumnsStmnt->execute();
                    $alumns = $alumnsStmnt->fetchAll();
                    // var_dump($alumnsStmnt);
                    // echo '<br>';
                    $assignment->set_targets($alumns);

                    array_push($assignmentRows, $assignment);
                }
            }

            return $assignmentRows;
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error insert: " . $e->getMessage();
        }
    }


    public static function selectAssignmentsTargets()
    {
        try {
            $conn = Database::get_connection();
            $selectStmnt = $conn->prepare("SELECT DISTINCT email FROM user WHERE type = 'alumn';");
            //var_dump($selectAllStmnt);

            $conn->beginTransaction();
            $selectStmnt->setFetchMode(PDO::FETCH_ASSOC);
            $selectStmnt->execute();
            $result = $selectStmnt->fetchAll();
            $conn->commit();

            return $result;
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error insert: " . $e->getMessage();
        }
    }



    public static function selectAssignmentsClasses()
    {
        try {
            $conn = Database::get_connection();
            $selectStmnt = $conn->prepare("SELECT id FROM class;");
            //var_dump($selectAllStmnt);

            $conn->beginTransaction();
            $selectStmnt->setFetchMode(PDO::FETCH_ASSOC);
            $selectStmnt->execute();
            $result = $selectStmnt->fetchAll();
            $conn->commit();

            return $result;
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error insert: " . $e->getMessage();
        }
    }


    public static function selectAssignmentsSubjects()
    {
        try {
            $conn = Database::get_connection();
            $selectClassesStmnt = $conn->prepare("SELECT DISTINCT subject FROM teacher_class");
            //var_dump($selectAllStmnt);

            $conn->beginTransaction();
            $selectClassesStmnt->setFetchMode(PDO::FETCH_ASSOC);
            $selectClassesStmnt->execute();
            $result = $selectClassesStmnt->fetchAll();
            $conn->commit();

            return $result;
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error insert: " . $e->getMessage();
        }
    }
}
