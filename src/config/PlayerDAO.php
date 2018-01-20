<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 10/01/18
 * Time: 17:43
 */

class PlayerDAO
{
    public function getPlayers()
    {
        try {
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->query("SELECT * FROM player");

            $players = $stmt->fetchAll(PDO::FETCH_OBJ);
            $database = null;

            return json_encode($players);
        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
    }

    public function getPlayer($id)
    {
        try {
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare("SELECT * FROM player WHERE id = :id");

            $stmt->execute(["id" => $id]);

            $players = $stmt->fetchAll(PDO::FETCH_OBJ);
            $database = null;

            return $players[0];
        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
    }

    public function newPlayer(Player $player)
    {

        try {
            $insertPlayerData = "INSERT INTO player(nome, email, pontos, data) VALUE (:nome, :email, :pontos, :data)";
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare($insertPlayerData);


            $stmt->execute(
                [
                    "nome" => $player->getNome(),
                    "email" => $player->getEmail(),
                    "pontos" => $player->getPontos(),
                    "data" => $player->getData()
                ]
            );

            $lastId = $database->lastInsertId();

            return $this->getPlayer($lastId);

        } catch (PDOException $exception) {
           return $exception->getMessage();
        }
    }

    public function updatePlayer(Player $player)
    {

        try {
            $query = "UPDATE player SET pontos = :pontos WHERE id = :id";
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare($query);

            $stmt->execute(
                [
                    "id" => $player->getId(),
                    "pontos" => $player->getPontos()
                ]
            );

            return $this->getPlayer($player->getId());
        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
        return false;
    }

    public function delete(Player $player)
    {

        try {
            $query = "DELETE FROM player WHERE id = :id";
            $database = new Database();
            $database = $database->getConnection();

            $stmt = $database->prepare($query);

            return $stmt->execute(["id" => $player->getId()]);
        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
        return false;
    }


    /**
     * @param $exception
     */
    public function echoError($exception)
    {
        echo '{"error": {"text": ' . $exception->getMessage() . '}';
    }
}