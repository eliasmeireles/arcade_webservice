<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 11/01/18
 * Time: 22:26
 */

class ApplicationValidation
{

    public function getPermition($token)
    {
        try {
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare("SELECT id, permition_token FROM application_permition WHERE permition_token = '{$token}'");
            $stmt->execute([$token]);

            if ($stmt->rowCount() > 0) {
                $permiton = $stmt->fetchObject(AppPermition::class);
                $permiton->setIsValid(true);
                return $permiton;
            } else {
                $permition = new AppPermition();
                $permition->setIsValid(false);

                return $permition;
            }

        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
    }
}