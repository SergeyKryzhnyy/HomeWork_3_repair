<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Capsule\Manager as DB;
class User extends Model
{
    protected $table = 'users';
    public $timestamps = false;

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

    public static function saveUser()
    {
        Database::getConn();
        $db = new User;
        $db->name= $_POST['name'];
        $db->email = $_POST['email'];
        $db->password = User::getPasswordHash($_POST['password']);
        $db->save();
    }

    public static function getById($id)
    {
        Database::getConn();
        $users = DB::table('users')->where('id','=',$id)->get();
        foreach ($users as $user)
        {
            $data['name'] = $user->name;
            $data['email'] = $user->email;
        }
        if(!$users)
        {
            return null;
        }
        return $data;

    }

    public static function getUserById($id, $new_name, $new_email)
    {
        Database::getConn();
        $user = User::find($id);
        $user->name = $new_name;
        $user->email = $new_email;
        $user->save();

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

    public static function getByAll($email)
    {
        Database::getConn();
        $data = DB::table('users')->where('email','=', $email)->get();
        foreach ($data as $user)
        {
            $data['id'] = $user->id;
            $data['name'] = $user->name;
            $data['password'] = $user->password;
            $data['email'] = $user->email;
        }
        return $data;
    }

    public static function getPasswordHash(string $password)
    {
        return sha1('sfasdf' . $password);
    }

}