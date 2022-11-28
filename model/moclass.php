<?php

require_once 'database.php';
require_once 'dataobject/doclass.php';

class moclass
{
    public static function insert($row)
    {
        //var_dump($row) . '\n<br>';

        try {
            $conn = Database::get_connection();

            $insertStmnt = $conn->prepare("INSERT INTO class (id, classroom, capacity)
            VALUES (:id, :classroom, :capacity)");

            // var_dump($insertStmnt);
            $insertStmnt->bindValue(':id', $row->get_id());
            $insertStmnt->bindValue(':classroom', $row->get_classroom());
            $insertStmnt->bindValue(':capacity', $row->get_capacity());
            $insertStmnt->execute();
        } catch (PDOException $e) {
            echo "Error insert: " . $e->getMessage();
        }
    }

    public static function update($row)
    {
        try {
            $conn = Database::get_connection();

            // var_dump($row) . '\n<br>';
            // var_dump($row->get_id());

            $conn->beginTransaction();
            $foreignKeyCheck = $conn->prepare("SET FOREIGN_KEY_CHECKS=1");
            $foreignKeyCheck->execute();
            $conn->commit();

            $updateStmnt = $conn->prepare("UPDATE class SET 
                classroom = '" . $row->get_classroom() . "'," .
                "capacity = '" . $row->get_capacity() . "' 
                WHERE id = '" . $row->get_id() . "'");
            // var_dump($updateStmnt);

            $conn->beginTransaction();
            $updateStmnt->execute();
            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollback();
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
            $deleteStmnt = $conn->prepare("DELETE FROM class WHERE id = '" . $id . "'");
            // var_dump($deleteStmnt);
            $deleteStmnt->execute();
            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error delete: " . $e->getMessage();
        }
    }


    public static function selectAll()
    {
        $classRows = array();

        try {
            $conn = Database::get_connection();
            $selectClass = $conn->prepare("SELECT * FROM class");

            $selectClass->setFetchMode(PDO::FETCH_ASSOC);
            $selectClass->execute();
            $classes = $selectClass->fetchAll();

            foreach ($classes as $class) {
                $class = new doclass($class["id"], $class["classroom"], $class["capacity"]);

                $alumnsStmnt = $conn->prepare('SELECT DISTINCT ac.alumn FROM class c JOIN alumn_class ac ON ac.class = "' . $class->get_id() . '";');
                // echo '<br>';
                // var_dump($alumnsStmnt);
                $alumnsStmnt->setFetchMode(PDO::FETCH_ASSOC);
                $alumnsStmnt->execute();
                $alumns = $alumnsStmnt->fetchAll();
                $class->set_alumns($alumns);


                $teachersStmnt = $conn->prepare('SELECT DISTINCT tc.teacher, tc.subject FROM class c JOIN teacher_class tc ON tc.class = "' . $class->get_id() . '";');
                // echo '<br>';
                // var_dump($teachersStmnt);
                $teachersStmnt->setFetchMode(PDO::FETCH_ASSOC);
                $teachersStmnt->execute();
                $teachers = $teachersStmnt->fetchAll();
                // echo '<br>';
                // var_dump($teachers);

                $class->set_teachers($teachers);

                // foreach ($class as $row) {
                //     echo $row->get_id() . '<br>';
                //     echo $row->get_classroom() . '<br>';
                //     echo $row->get_capacity() . '<br>';
                //     echo $row->get_alumns() . '<br>';
                //     echo $row->get_teachers() . '<br>';
                // }

                array_push($classRows, $class);
            }

            return $classRows;
        } catch (PDOException $e) {
            echo "Error selectAll: " . $e->getMessage();
        }
    }


    //Class - User relationships
    public function insertUserInClass($userId, $classId, $subject)
    {
        //var_dump($userId) . '\n<br>';
        //var_dump($classId) . '\n<br>';
        //var_dump($subject) . '\n<br>';

        try {
            $conn = Database::get_connection();

            if ($subject != '') {
                $insertStmnt = $conn->prepare("INSERT INTO teacher_class (teacher, class, subject)
                                                VALUES ((SELECT email FROM user WHERE email=:teacher AND type='teacher'), 
                                                :class, :subject)");

                $insertStmnt->bindValue(':teacher', $userId);
                $insertStmnt->bindValue(':class', $classId);
                $insertStmnt->bindValue(':subject', $subject);
                // var_dump($insertStmnt);
            } else {
                $insertStmnt = $conn->prepare("INSERT INTO alumn_class (alumn, class)
                VALUES ((SELECT email FROM user WHERE email=:alumn AND type='alumn'), :class)");

                $insertStmnt->bindValue(':alumn', $userId);
                $insertStmnt->bindValue(':class', $classId);
                // var_dump($insertStmnt);
            }

            $insertStmnt->execute();
        } catch (PDOException $e) {
            echo "Error insert user: " . $e->getMessage();
        }
    }

    public static function deleteUserInClass($userId, $classId, $subject)
    {
        try {
            $conn = Database::get_connection();

            // var_dump($id) . '\n<br>';

            $conn->beginTransaction();
            $foreignKeyCheck = $conn->prepare("SET FOREIGN_KEY_CHECKS=1");
            $foreignKeyCheck->execute();
            $conn->commit();

            $conn->beginTransaction();
            if ($subject != '') {
                $deleteStmnt = $conn->prepare("DELETE FROM teacher_class WHERE teacher = '" . $userId . "' AND class = '" . $classId . "' AND subject = '" . $subject . "'");
            } else {
                $deleteStmnt = $conn->prepare("DELETE FROM alumn_class WHERE alumn = '" . $userId . "' AND class = '" . $classId . "'");
            }
            //var_dump($deleteStmnt);
            $deleteStmnt->execute();
            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error delete user: " . $e->getMessage();
        }
    }

    public static function selectClassesId()
    {
        $classesId = array();

        try {
            $conn = Database::get_connection();

            $selectStmnt = $conn->prepare("SELECT id FROM class");
            $selectStmnt->execute();
            $result = $selectStmnt->fetchAll();

            foreach ($result as $row) {
                array_push($classesId, $row['id']);
            }

            return $classesId;
        } catch (PDOException $e) {
            echo "Error select: " . $e->getMessage();
        }
    }

    public static function selectClassUsers($classId)
    {
        $classUsers = array();

        try {
            $conn = Database::get_connection();

            $selectStmnt = $conn->prepare("SELECT email FROM class JOIN alumn_class ON class.id = alumn_class.class JOIN user ON alumn_class.alumn = user.email WHERE class.id = '" . $classId . "'");
            $selectStmnt->execute();
            $result = $selectStmnt->fetchAll();

            foreach ($result as $row) {
                array_push($classUsers, $row['email']);
            }

            return $classUsers;
        } catch (PDOException $e) {
            echo "Error select: " . $e->getMessage();
        }
    }
}