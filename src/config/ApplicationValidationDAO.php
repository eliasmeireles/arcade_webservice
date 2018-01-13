<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 11/01/18
 * Time: 22:26
 */

class ApplicationValidationDAO
{

    public function getPermition($token)
    {
        try {
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare("SELECT id, permition_token FROM application_permition WHERE permition_token = :token");
            $stmt->execute(['token' => $token]);

            if ($stmt->rowCount() > 0) {
                $permition = $stmt->fetchAll(PDO::FETCH_OBJ);



                $appPermition = new AppPermition();
                $appPermition->setPermitionToken($permition[0]->permition_token);
                $appPermition->setIsValid(true);

                return $appPermition;
            } else {
                $permition = new AppPermition();
                $permition->setPermitionToken($token);
                $permition->setIsValid(false);

                return $permition;
            }

        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
    }
}