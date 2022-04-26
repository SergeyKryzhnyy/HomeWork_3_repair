<?php
namespace App\Controller;

use Src\AbstractController;
use \App\Model\Post as PostModel;
use Src\Db;

class Show extends AbstractController
{
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
        return $this->view->render('blog/message.phtml', ['posts'=>$posts]);
       //return $this->view->render('Blog/message.phtml',);
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
