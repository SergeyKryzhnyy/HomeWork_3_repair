<?php
namespace Src;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

//require_once __DIR__.'../vendor/autoload.php';


class View
{
    private $templatePath = '';
    private $data = [];
    public $twig;
    public function __construct()
    {
        $this->templatePath = PROJECT_ROOD_DIR . DIRECTORY_SEPARATOR . 'app/View';
    }

    public function render(string $tpl, $data =[])//:string
    {
        $this->data += $data;
        //$userName ='123';
        ob_start();
        include $this->templatePath . DIRECTORY_SEPARATOR . $tpl;
        return ob_get_flush();
    }

    public function __get($varName)
    {
        return $this->data[$varName] ?? null;
    }

    public function assign(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    public function getTwig()
    {
        $loader = new FilesystemLoader('../html/views');
        $this->twig = new Environment($loader);
        return $this->twig;
    }
}