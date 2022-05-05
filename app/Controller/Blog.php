<?php
namespace App\Controller;

use App\Model\Posts as PostModel;
use App\Model\User as UserModel;
use Src\AbstractController;

class Blog extends AbstractController
{
    public $id_user_change;
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
        if ($_SESSION['id']==ADMIN_ID)
        {
            $id_status['id'] = 1;
        }
        else{
            $id_status['id'] = 0;
        }
        $twig =  $this->view->getTwig();

        $user_found  = UserModel::getByAll($_POST['search_email']);
        $result['name'] = $user_found['name'];
        $result['email'] = $user_found['email'];
        $result['id'] = $user_found['id'];
        $_SESSION['change_id'] = $result['id'];

        $message  = '';
        if (!$result['email'])
        {
            $message  = 'Пользователь не найден';
            echo $twig->render('index.twig', ['id_status'=>$id_status, 'message'=>$message ]);
            //$this->redirect('/blog/index');
        }
        else{
            echo $twig->render('search.twig', ['result'=>$result]);
        }
    }

    public function changeAction()
    {
        $new_name = $_POST['change_name'];
        $new_email = $_POST['change_email'];
        $result = UserModel::getById($_SESSION['change_id']);
        $twig = $this->view->getTwig();
        if(!$new_email || !$new_name)
        {
            $message = 'Заполните поля!';
        }
        else{
            UserModel::getUserById($_SESSION['change_id'], $new_name, $new_email);
            $message = 'Изменения сохранены!';
        }
        echo $twig->render('search.twig', ['message'=>$message, 'result'=>$result]);
    }

}