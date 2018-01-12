<?php
/**
 * Created by PhpStorm.
 * User: elias
 * Date: 11/01/18
 * Time: 22:54
 */

class AppPermition implements JsonSerializable
{
    private $id;
    private $permition_token;
    private $isValid;

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
    public function getPermitionToken()
    {
        return $this->permition_token;
    }

    /**
     * @param mixed $permition_token
     */
    public function setPermitionToken($permition_token)
    {
        $this->permition_token = $permition_token;
    }

    /**
     * @return mixed
     */
    public function getisValid()
    {
        return $this->isValid;
    }

    /**
     * @param mixed $isValid
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;
    }




    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'permition_token' => $this->getPermitionToken(),
            'isValid' => $this->getisValid()
        ];
    }
}