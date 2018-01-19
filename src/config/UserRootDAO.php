<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 12/01/18
 * Time: 22:33
 */

class UserRootDAO
{
    public function newRootUser(UserRoot $userRoot)
    {

        try {
            $query = "INSERT INTO user_root(nome, email, senha) VALUE (:nome, :email, :senha)";
            $database = new Database();

            $database = $database->getConnection();

            $stmt = $database->prepare($query);


            $stmt->execute(
                [
                    "nome" => $userRoot->getNome(),
                    "email" => $userRoot->getEmail(),
                    "senha" => $userRoot->getSenha()
                ]
            );

            $lastId = $database->lastInsertId();

            return $this->getRootUserById($lastId);

        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    public function getRootUserById($id)
    {
        try {
            $query = "SELECT * FROM user_root WHERE id = :id";
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare($query);


            $stmt->execute(
                [
                    "id" => $id
                ]
            );

            $userRoot = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $userRoot[0];
        } catch (PDOException $exception) {
            return $this->echoError($exception);
        }
    }

    public function getUserRoot(UserRoot $userRoot)
    {
        try {
            $query = "SELECT * FROM user_root WHERE email = :email";
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare($query);


            $stmt->execute(
                [
                    "email" => $userRoot->getEmail()
                ]
            );

            $userRootResult = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $userRootResult[0];
        } catch (PDOException $exception) {
            return $this->echoError($exception);
        }
    }


    public function updateUserRoot(UserRoot $userRoot)
    {

        try {
            $query = "UPDATE user_root SET senha = :senha WHERE id = :id";
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare($query);

            $stmt->execute(
                [
                    "id" => $userRoot->getId(),
                    "senha" => $userRoot->getSenha()
                ]
            );

            return $this->getUserRoot($userRoot->getId());
        } catch (PDOException $exception) {
            return $exception;
        }
    }


    public function deleteUserRoot(UserRoot $userRoot)
    {

        try {
            $query = "DELETE FROM user_root WHERE id = :id";

            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare($query);

            $stmt->execute(
                [
                    "id" => $userRoot->getId()
                ]
            );
        } catch (PDOException $exception) {
            return $exception;
        }
    }


}