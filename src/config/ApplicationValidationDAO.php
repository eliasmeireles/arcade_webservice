<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 11/01/18
 * Time: 22:26
 */

class ApplicationValidationDAO
{

    public function getPermition(AppPermition $token)
    {
        try {
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare("SELECT id, permition_token FROM application_permition WHERE permition_token = :token");
            $stmt->execute(['token' => $token->getPermitionToken()]);

                $appPermition = new AppPermition();
            if ($stmt->rowCount() > 0) {
                $appPermition->setPermitionToken($token->getPermitionToken());
                $appPermition->setIsValid(true);

                return $appPermition;
            } else {
                $appPermition->setPermitionToken($token->getPermitionToken());
                $appPermition->setIsValid(false);

                return $appPermition;
            }

        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
    }
}