<?php
namespace App\Controller;

use App\Model\Posts;
use Src\AbstractController;

class Show extends AbstractController
{
    public function indexAction()
    {

        $posts = new Posts();
        $result = $posts->showAllPosts();

    if ($_SESSION['id']==ADMIN_ID)
        {
            $id_status['id'] = 1;
        }
        else{
            $id_status['id'] = 0;
        }

        $twig =  $this->view->getTwig();
        if (TWIG_VIEW == 1)
        {
            echo $twig->render('message.twig', ['array'=>$result, 'id_status'=>$id_status]);
        }
        else
        {
            return $this->view->render('blog/index.phtml', ['user'=>$this->user]);
        }

        if (isset($_POST['id']))
        {
            $posts = new Posts();
            $posts->deletePost($_POST['id']);

        }
    }

}
