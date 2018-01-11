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

            $stmt = $database->query("SELECT * FROM player WHERE id = $id");

            $players = $stmt->fetchAll(PDO::FETCH_OBJ);
            $database = null;

            return json_encode($players);
        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
    }

    public function newPlayer(Player $player)
    {

        try {
            $insertPlayerData = "INSERT INTO player(nome, pontos) VALUE ('{$player->getNome()}', {$player->getPontos()})";
            $database = new Database();
            $database = $database->getConnection();

            $database->query($insertPlayerData);
            return true;
        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
        return false;
    }

    public function updatePlayer(Player $player)
    {

        try {
            $insertPlayerData = "UPDATE player SET nome = '{$player->getNome()}', pontos = {$player->getPontos()} WHERE id = {$player->getId()}";
            $database = new Database();
            $database = $database->getConnection();

            $database->query($insertPlayerData);

            return true;
        } catch (PDOException $exception) {
            $this->echoError($exception);
        }
        return false;
    }

    public function delete(Player $player)
    {

        try {
            $insertPlayerData = "DELETE FROM player WHERE id = {$player->getId()}";
            $database = new Database();
            $database = $database->getConnection();

            $database->query($insertPlayerData);

            return true;
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