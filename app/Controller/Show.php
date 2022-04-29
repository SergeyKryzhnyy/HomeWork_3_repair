<?php
namespace App\Controller;

use Src\AbstractController;
use \App\Model\Post as PostModel;
use Src\Db;

class Show extends AbstractController
{
    public $array = [];


    public function indexAction()
    {
        $posts = new PostModel();

        if (!$this->user)
        {
            $this->redirect('/user/register');
        }

        if(isset($_POST['id']))
        {
            $posts->deletePost($_POST['id']);
        }

        $posts->showAllPosts();
        //return $this->view->render('blog/message.phtml', ['posts'=>$posts]);
       //return $this->view->render('Blog/message.phtml',);

        $twig =  $this->view->getTwig();
//echo "<pre>";
//var_dump($posts);

        if ($_SESSION['id']==ADMIN_ID)
        {
            $array['id'] = 1;
        }
        else{
            $array['id'] = 0;
        }
        $array['name'] = $this->user->getName();
        for ($i=0; $i<20; $i++)
        {
            if(!$posts->getIdMessage($i))
            {
                break;
            }

            $array['text'][$i]  = $posts->getText($i);
            $array['id_post'][$i] = $posts->getIdMessage($i);
            $array['name_user'][$i] = $posts->getNameUser($i);
            if($posts->getImage())
            {
                $array['image'] = $posts->getImage();
            }

        }
        if (TWIG_VIEW == 1)
        {
            echo $twig->render('message.twig', ['array'=>$array]);
        }
        else
        {
            return $this->view->render('blog/index.phtml', ['user'=>$this->user]);
        }
        return '';
    }


    public function jsonAction()
    {
        $model = new PostModel();
        echo $posts_json = $model->getAllMessages($_GET['user_id']);

        header('Content-type: application-json');
        echo json_encode($posts_json);
        //return $this->view->render('blog/message.phtml', ['posts_json'=>$posts_json]);
    }
}
