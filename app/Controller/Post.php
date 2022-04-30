<?php
namespace App\Controller;

use Src\AbstractController;
use \App\Model\Post as PostModel;
use Src\Db;


require_once '../vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;



class Post extends AbstractController
{
    private $text;
    private $id_user;
    public $posts;

    public function sentAction()
    {

        $post = $this->text = $_POST['post'];
        $user = new PostModel();

        if (isset($_FILES['image']['tmp_name']))
        {
            $user->LoadFile($_FILES['image']['tmp_name']);
        }

        $db = Db::getInstance();
        $user->savePost($post, $_SESSION['id']);
        $this->redirect('/show/index');
        //return $this->view->render('User/register.phtml', ['user'=>UserModel::getById((int) $_GET['id'])]);
    }




}