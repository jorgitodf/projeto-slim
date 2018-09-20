<?php

namespace App\Traits;

use App\Src\Load;

trait View
{
    protected $twig;

    protected function twig()
    {
        $loader = $loader = new \Twig_Loader_Filesystem('../app/Views');

        $this->twig = new \Twig_Environment($loader, array(
            //'cache' => '/path/to/compilation_cache',
            'debug' => true
        ));
    }

    protected function functions()
    {
        $functions = Load::file('/app/Functions/twig.php');

        foreach ($functions as $function) {
            $this->twig->addFunction($function);
        }
        
    }

    protected function load()
    {
        $this->twig();
        $this->functions();
    }

    protected function view($view, $data)
    {
        $this->load();
        $template = $this->twig->loadTemplate(str_replace('.', '/', $view).'.html.twig');
        return $template->display($data);
    }
}