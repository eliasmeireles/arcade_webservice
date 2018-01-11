<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 10/01/18
 * Time: 17:37
 */

class Player
{
    private $id;
    private $nome;
    private $pontos;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return mixed
     */
    public function getPontos()
    {
        return $this->pontos;
    }

    /**
     * @param mixed $pontos
     */
    public function setPontos($pontos)
    {
        $this->pontos = $pontos;
    }
}