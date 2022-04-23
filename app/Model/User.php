<?php
namespace App\Model;

use Src\AbstractModel;
use Src\Db;

class User extends AbstractModel
{
    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;

    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct($data = [])
    {
        if ($data) {
            $this->id = $data['id'];
            $this->email = $data['email'];
            $this->name = $data['name'];
            $this->password = $data['password'];
        }
    }
    public function getId():int
    {
        return $this->id;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        return $this->name = $name;
    }

    public function setEmail(string $email)
    {
        return $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        return $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function save()//сохраняем нового юзера
    {
        $db = Db::getInstance();
        $insert = "INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)";
        $db->exec($insert, __METHOD__, [':name'=>$this->name, ':email'=>$this->email, ':password'=>self::getPasswordHash($this->password)]);
        $id = $db->lastInsertId();
        $this->id = $id;
        return $id;
    }

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE id = $id";
        $data = $db->fetchOne($select, __METHOD__);

        if(!$data)
        {
            return null;
        }
        return new self($data);
    }

    public static function getByEmail(string $email): ?self
    {
        $db = Db::getInstance();
        $select = "SELECT * FROM users WHERE `email`=:email";
        $data = $db->fetchOne($select, __METHOD__,[':email'=>$email]);

        if(!$data)
        {
            return null;
        }
        return new self($data);

    }

    public static function getPasswordHash(string $password)
    {
        return sha1('sfasdf' . $password);
    }

}