<?php

class Minta_Controller
{
    public $baseName = 'minta';
    public function main(array $vars)
    {
        if (!bejelentkezve()) {
            header('Location: ' . SITE_ROOT . 'belepes', true, 302);
            die();
        }

        $view = new View_Loader($this->baseName."_main");
    }
}

?>