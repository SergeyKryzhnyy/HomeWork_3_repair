<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Capsule\Manager as DB;
class User extends Model
{



    protected $table = 'users';
    public $timestamps = false;
    public $primaryKey = 'id';

    private $id;
    private $name;
    private $email;
    private $password;

    public function __construct()
    {
    }
    public static function getId($email)
    {
        Database::getConn();
        $data = DB::table('users')->where('email','=',$email)->get();
        foreach ($data as $user)
        {
            $data = $user->id;
        }
        if(!$data)
        {
            return null;
        }
        return $data;
    }

    public static function getName($id)
    {
        Database::getConn();
        $data = DB::table('users')->where('id','=',$id)->get();
        foreach ($data as $user)
        {
            $data = $user->name;
        }
        if(!$data)
        {
            return null;
        }
        return $data;
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

    public static function getPassword($email)
    {
        Database::getConn();
        $data = DB::table('users')->where('email','=',$email)->get();
        foreach ($data as $user)
        {
            $data = $user->password;
        }
        if(!$data)
        {
            return null;
        }
        return $data;
    }

    public static function saveUser($name, $email, $password)
    {
        Database::getConn();
        $db = new User;
        $db->name = $name;
        $db->email = $email;
        $db->password = $password;
        $db->save();
    }

//    public function save()//сохраняем нового юзера
//    {
//        $db = Db::getInstance();
//        $insert = "INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)";
//        $db->exec($insert, __METHOD__, [':name'=>$this->name, ':email'=>$this->email, ':password'=>self::getPasswordHash($this->password)]);
//        $id = $db->lastInsertId();
//        $this->id = $id;
//        return $id;
//    }

    public static function getById($id)
    {
        Database::getConn();
        $users = DB::table('users')->where('id','=',$id)->get();
        foreach ($users as $user)
        {
            $data = $user->name;
            //$data['password'] = $user->password;
        }
        if(!$users)
        {
            return null;
        }
        return $data;

    }

    public static function getStringNameById(int $id): string
    {
        $db = Db::getInstance();
        $select = "SELECT name FROM users WHERE id = $id";
        $data = $db->fetchOne($select, __METHOD__);

        return $data['name'];
    }




    public static function getByEmail($email):string
    {
        Database::getConn();
        $data = DB::table('users')->where('email','=', $email)->get();
        foreach ($data as $user)
        {
            $data = $user->email;
        }
        return $data;

    }

    public static function getPasswordHash(string $password)
    {
        return sha1('sfasdf' . $password);
    }

}