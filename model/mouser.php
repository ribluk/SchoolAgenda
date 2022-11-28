<?php

require_once 'database.php';
require_once 'dataobject/douser.php';

class mouser
{
    public static function insert($row)
    {
        //var_dump($row) . '\n<br>';

        try {
            $conn = Database::get_connection();

            $insertStmnt = $conn->prepare("INSERT INTO user (email, password, name, surname, address, dateob, type)
            VALUES (:email, :password, :name, :surname, :address, :dateob, :type)");

            $conn->beginTransaction();

            //var_dump($insertStmnt);
            $insertStmnt->bindValue(':email', $row->get_email());
            $insertStmnt->bindValue(':password', hash('sha1', $row->get_password()));
            $insertStmnt->bindValue(':name', $row->get_name());
            $insertStmnt->bindValue(':surname', $row->get_surname());
            $insertStmnt->bindValue(':address', $row->get_address());
            $insertStmnt->bindValue(':dateob', $row->get_dateob());
            $insertStmnt->bindValue(':type', $row->get_type());
            $insertStmnt->execute();
            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error insert: " . $e->getMessage();
        }
    }

    public static function update($row)
    {
        try {
            $conn = Database::get_connection();

            // var_dump($row) . '\n<br>';
            // var_dump($row->get_email());

            $conn->beginTransaction();
            $foreignKeyCheck = $conn->prepare("SET FOREIGN_KEY_CHECKS=1");
            $foreignKeyCheck->execute();
            $conn->commit();

            $updateStmnt = $conn->prepare("UPDATE user SET
                password = '" . hash('sha1', $row->get_password()) . "'," .
                "name = '" . $row->get_name() . "'," .
                "surname = '" . $row->get_surname() . "'," .
                "address = '" . $row->get_address() . "'," .
                "dateob = '" . $row->get_dateob() . "'," .
                "type = '" . $row->get_type() . "'
            WHERE email = '" . $row->get_email() . "';");
            // var_dump($updateStmnt);

            $conn->beginTransaction();
            $updateStmnt->execute();
            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error update: " . $e->getMessage();
        }
    }

    public static function delete($email)
    {
        try {
            $conn = Database::get_connection();

            // var_dump($email) . '\n<br>';

            $conn->beginTransaction();
            $foreignKeyCheck = $conn->prepare("SET FOREIGN_KEY_CHECKS=1");
            $foreignKeyCheck->execute();
            $conn->commit();

            $conn->beginTransaction();
            $deleteStmnt = $conn->prepare("DELETE FROM user WHERE email = '" . $email . "';");
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
        try {
            $conn = Database::get_connection();
            $selectAllStmnt = $conn->prepare("SELECT * FROM user");
            $conn->beginTransaction();

            //var_dump($selectAllStmnt);

            $selectAllStmnt->setFetchMode(PDO::FETCH_ASSOC);
            $selectAllStmnt->execute();
            $result = $selectAllStmnt->fetchAll();
            $conn->commit();

            return $result;
        } catch (PDOException $e) {
            $conn->rollback();
            echo "Error select: " . $e->getMessage();
        }
    }
}
