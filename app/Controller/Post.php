<?php
namespace App\Controller;

use Src\AbstractController;
use \App\Model\Posts as PostModel;
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
        $user = new PostModel();

        $user->savePost();
        $this->redirect('/show/index');
        //return $this->view->render('User/register.phtml', ['user'=>UserModel::getById((int) $_GET['id'])]);
    }




}