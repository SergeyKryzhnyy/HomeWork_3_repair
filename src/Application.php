<?php
namespace Src;

use App\Model\User as UserModel;
class Application
{
    private $route;
    /** @var AbstractController */
    private $controller;
    private $actionName;

    public function __construct()
    {
        $this->route = new Route();
    }

    public function run()
    {
        try {
            session_start();
            $this->initController();
            $this->initAction();

            $view = new View();// объект для отображения шаблона
            $this->controller->setView($view);

            $this->initUser();

            $content = $this->controller->{$this->actionName}();// вызываем метод (в примере "логин" из юзера), используя переменную actionName

        } catch (RedirectException $e){
            header('location: ' . $e->getUrl());
        } catch (RouteException $e)
        {
            header("HTTP/1.0 404 Not Found");
        }
    }


    public function initUser()
    {
        $id = $_SESSION['id'] ?? null;
        if ($id)
        {
            $user = UserModel::getById($id);
            if ($user)
            {
                $this->controller->setUser($user);
            }
        }
    }


    private function initController()//если нет такого контроллера
    {
        $controllerName = $this->route->getControllerName();
        if (!class_exists($controllerName))//проверяем существует ли введенный метод (передаем объект)
        {
            throw new RouteException('Class' . $controllerName . ' not found');
        }
        $this->controller = new $controllerName();
    }

    private function initAction()// если нет такого метода
    {
        $actionName = $this->route->getActionName();
        if (!method_exists($this->controller, $actionName))//проверяем существует ли введенный метод (передаем объект)
        {
            throw new RouteException('Action' . $actionName . ' not exist' .' in' . get_class($this->controller));//get_class испольщуем, потому что controller - объект!!!
        }
        $this->actionName = $actionName;
    }


}