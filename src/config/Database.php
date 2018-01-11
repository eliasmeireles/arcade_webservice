<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 10/01/18
 * Time: 01:32
 */

class Database
{
    private $host = "localhost";
    private $user = "id2230004_arcadeadministration";
    private $password = "rootAdming";
    private $dataBaseName = "id2230004_arcade_data_players";



    public function getConnection() {
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dataBaseName";
        $dataConnection = new PDO($mysql_connect_str, $this->user, $this->password);
        $dataConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dataConnection;
    }
}