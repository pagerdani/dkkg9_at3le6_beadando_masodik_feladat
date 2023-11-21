<?php

class Minta_Almenu1_Controller
{
    public $baseName = 'minta_almenu1';
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