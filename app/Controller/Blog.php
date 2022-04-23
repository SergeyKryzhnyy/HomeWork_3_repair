<?php
namespace App\Controller;

use App\Model\Post as PostModel;
use App\Model\User as UserModel;
use Src\AbstractController;

class Blog extends AbstractController
{
    private $posts;


    public function indexAction()
    {
       if (!$this->user)
       {
           $this->redirect('/user/register');
       }
        return $this->view->render('blog/index.phtml', ['user'=>$this->user]);
    }


}