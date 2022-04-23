<?php
namespace Src;

class View
{
    private $templatePath = '';
    private $data = [];

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
}