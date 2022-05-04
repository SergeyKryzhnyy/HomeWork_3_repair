<?php
namespace App\Controller;

use App\Model\Posts as PostModel;
use App\Model\User as UserModel;
use Src\AbstractController;


class Blog extends AbstractController
{

    public $array=[];
    private $posts;
    public function indexAction()
    {
        $email = trim($_POST['email']);
       if (!$this->user)
       {
           $this->redirect('/user/register');
       }

       $twig =  $this->view->getTwig();

        $array['name'] = UserModel::getName($_SESSION['id']);
        if (TWIG_VIEW == 1)
        {
            echo $twig->render('index.twig', ['array'=>$array]);
        }
       else{
           return $this->view->render('blog/index.phtml', ['user'=>$this->user]);
       }
       return '';
    }

}