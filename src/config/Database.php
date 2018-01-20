<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 10/01/18
 * Time: 01:32
 */

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = 'root';
    private $dataBaseName = 'arcade_data_players';


//    private $host = '108.179.193.70';
//    private $user = 'arcad826';
//    private $password = '1ru9BcH9p5';
//    private $dataBaseName = 'arcad826_service_data';



    public function getConnection() {
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dataBaseName";
        $dataConnection = new PDO($mysql_connect_str, $this->user, $this->password);
        $dataConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dataConnection;
    }
}