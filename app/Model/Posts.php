<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;


class Posts extends Model
{
    public $timestamps = false;
    public $primaryKey = 'id_message';

    public function showAllPosts()
    {
        Database::getConn();
        $i = 0;
        foreach (Posts::all() as $value)
        {
           $array['text'][$i] = $value->text;
           $array['id_user'][$i] = $value->id_user;
           $array['id_post'][$i] = $value->id_message;
           if ($value->image)
           {
               $array['image'][$i] = $value->image;
           }
            foreach (User::all() as $key)
            {
                if($key->id == $value->id_user)
                {
                    $array['name_user'][$i] = $key->name;
                }
            }
           $i++;
        }
        return $array;
    }

    public function savePost()//сохраняем пост
    {
        Database::getConn();
        $db = new Posts();
        $db->text = $_POST['post'];
        $db->id_user = $_SESSION['id'];

        if (file_exists($_FILES['image']['tmp_name']))
        {
            $img = Image::make($_FILES['image']['tmp_name']);
            $img->fit(500,500);
            $img->text('Hello it is WaterMark',10,10);
            $img->filename =  sha1(microtime(1) . mt_rand(1,1000)) . '.jpg';
            $img->save(getcwd() . '/images/' . $img->filename);
            $name_img =  $img->filename;
        }
        $db->image = $name_img . '.jpg';
        $db->save();
    }

        public function  deletePost($i)
    {
//        $db = Db::getInstance();
//        $insert = "DELETE FROM posts WHERE id_message=:i";
//        $db->exec($insert, __METHOD__,[':i'=>$i]);
          Database::getConn();
          Posts::destroy($i);
    }
}






















//   public $idMessage;
//   public $text;
//   public $idUser;
//   public $nameUser;
//   public $data;
//   public $image;
//
//    public function getIdMessage($int)
//    {
//        return $this->idMessage[$int];
//    }
//
//    public function setIdMessage($message):int
//    {
//        return $this->idMessage = $message;
//    }
//
//    public function getText($int)
//    {
//        return $this->text[$int];
//    }
//
//    public function setText($text):string
//    {
//        return $this->text = $text;
//    }
//
//    public function getNameUser($int)
//    {
//        return $this->nameUser[$int];
//    }
//
//    public function setIdUser($idUser)
//    {
//        return $this->idUser = $idUser;
//    }
//
//    public function getImage()
//    {
//        return $this->image;
//    }
//

//


//
//    public function getAllMessages($user_id)
//    {
//        $db = Db::getInstance();
//        $select = "SELECT * FROM posts WHERE id_user=:user_id ORDER BY `date`";
//        $rows = $db->fetchAll($select, __METHOD__,[':user_id'=>$user_id]);
//        //var_dump($rows);
//        return $rows;
//    }
//

//

