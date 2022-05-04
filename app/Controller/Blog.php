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
        if ($_SESSION['id']==ADMIN_ID)
        {
            $id_status['id'] = 1;
        }
        else{
            $id_status['id'] = 0;
        }
       $twig = $this->view->getTwig();

        $array['name'] = UserModel::getName($_SESSION['id']);
        if (TWIG_VIEW == 1)
        {
            echo $twig->render('index.twig', ['array'=>$array, 'id_status'=>$id_status]);
        }
       else{
           return $this->view->render('blog/index.phtml', ['user'=>$this->user]);
       }
       return '';
    }

    public function findAction()
    {
        $twig =  $this->view->getTwig();

        $user_found  = UserModel::getByAll($_POST['search_email']);

        $result['name'] = $user_found['name'];
        $result['email'] = $user_found['email'];

        //echo $twig->render('index.twig', ['result'=>$result, 'id_status'=>'1']);
        echo $twig->render('search.twig', ['result'=>$result]);

        $this->redirect('/blog/index');


    }

}