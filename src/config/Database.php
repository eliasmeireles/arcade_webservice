<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 10/01/18
 * Time: 01:32
 */

class Database
{
    private $host = "mysql.hostinger.com.br";
    private $user = "u869896919_mysql";
    private $password = "adminRoot";
    private $dataBaseName = "u869896919_geren";



    public function getConnection() {
        $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dataBaseName";
        $dataConnection = new PDO($mysql_connect_str, $this->user, $this->password);
        $dataConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $dataConnection;
    }
}