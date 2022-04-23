<?php
namespace App\Controller;

use Src\AbstractController;
use \App\Model\Post as PostModel;
use Src\Db;

class Post extends AbstractController
{
    private $text;
    private $id_user;
    public $posts;

    public function sentAction()
    {
        $post = $this->text = $_POST['post'];
        $user = new PostModel();
        $db = Db::getInstance();
        $user->savePost($post, $_SESSION['id']);
        $this->redirect('/blog/index');
        //return $this->view->render('User/register.phtml', ['user'=>UserModel::getById((int) $_GET['id'])]);
    }




}