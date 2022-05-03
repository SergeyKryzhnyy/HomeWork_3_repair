<?php
namespace App\Model;
use Illuminate\Database\Capsule\Manager as Capsule;


class Database
{
    static function getConn()
    {
        $capsule = new Capsule();
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost:3307',
            'database' => 'users',
            'username' => 'admin',
            'password' => '12345',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);

    }

}
