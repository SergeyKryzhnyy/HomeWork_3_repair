<?php
namespace App\Controller;

use App\Model\Database;
use Src\AbstractController;
use \App\Model\User as UserModel;

class User extends AbstractController
{
    public function loginAction()
    {
        $user = new UserModel();
        $twig =  $this->view->getTwig();
        $email = trim($_POST['email']);
        $message = '';
        Database::getConn();

        if(isset($_POST['email']))
        {
            if($email)
            {
                $password = $_POST['password'];
                $user = UserModel::getByEmail($email);
                if (!$user)
                {
                    $this->view->assign('error','Пользователь на найден');
                    $message = 'Пользователь на найден';
                }
                if($user)
                {
                    if (UserModel::getPassword($email) != UserModel::getPasswordHash($password))
                    {
                        $this->view->assign('error','пароль не подошел!');
                        $message = 'Пароль  не подошел';
                    }
                    else
                    {

                        $_SESSION['id'] = UserModel::getId($email);
                        $this->redirect('/blog/index');
                    }
                }
            }

        }

        if (TWIG_VIEW == 1)
        {
            echo $twig->render('login.twig', ['user'=>UserModel::getById((int) $_GET['id']),'message'=>$message]);

        }
        else{
            return $this->view->render('User/register.phtml', ['user'=>UserModel::getById((int) $_GET['id'])]);
        }
        return '';
    }

    public function registerAction()
    {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $passwordRepeat = $_POST['password_repeat'];
        $success = true;
        $twig =  $this->view->getTwig();
        $message = '';
        if(isset($_POST['email']))
        {

            if (!$name)
            {
                $this->view->assign('error','Поля не могут быть пустыми!');
                $message = 'Поля пустые!';
                $success = false;
            }

            if (strlen($password) < 4)
            {
                $this->view->assign('error','Пароль слишком короткий ');
                $success = false;
                $message = 'Поля пустые!';
            }

            if ($password != $passwordRepeat)
            {
                $this->view->assign('error','Пароли не совпадают');
                $success = false;
                $message = 'Поля пустые!';
            }

            if($success)
            {
                UserModel::saveUser();
                $message = 'Регистрация успешна';
            }
        }
        if ($_SESSION['id']==ADMIN_ID)
        {
            $id_status['id'] = 1;
        }
        else{
            $id_status['id'] = 0;
        }
        if (TWIG_VIEW == 1)
        {
            echo $twig->render('login.twig', ['user'=>UserModel::getById((int) $_GET['id']),'message'=>$message, 'id_status'=>$id_status]);
        }
        else{
            return $this->view->render('User/register.phtml', ['user'=>UserModel::getById((int) $_GET['id'])]);
        }
        return '';
    }

    public function profileAction()
    {
        $id = (int)$_GET['id'];
        $user = UserModel::getById($id);
        var_dump($user);
        return $this->view->render('User/profile.phtml', ['user'=>$user]);
    }

    public function logoutAction()
    {
        session_destroy();
        $this->redirect('/user/login');
    }

    public function register2Action()
    {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $passwordRepeat = $_POST['password_repeat'];
        $success = true;
        $twig =  $this->view->getTwig();
        $message = [];
        if(isset($_POST['email']))
        {

            if (!$name)
            {
                $this->view->assign('error','Поля не могут быть пустыми!');
                $message = 'Поля пустые!';
                $success = false;
            }

            if (strlen($password) < 4)
            {
                $this->view->assign('error','Пароль слишком короткий ');
                $success = false;
                $message = 'Поля пустые!';
            }

            if ($password != $passwordRepeat)
            {
                $this->view->assign('error','Пароли не совпадают');
                $success = false;
                $message = 'Поля пустые!';
            }

            if($success) {
                UserModel::saveUser();
                $message = 'Регистрация успешна';
            }
            else{
                $message = 'Поля пустые!';
            }

        }
        if ($_SESSION['id']==ADMIN_ID)
        {
            $id_status['id'] = 1;
        }
        else{
            $id_status['id'] = 0;
        }
        if (TWIG_VIEW == 1)
        {
             echo $twig->render('index.twig', ['user'=>UserModel::getById((int) $_GET['id']),'message'=>$message, 'id_status'=>$id_status]);
        }
        else{
            return $this->view->render('User/register.phtml', ['user'=>UserModel::getById((int) $_GET['id'])]);
        }
    }
}