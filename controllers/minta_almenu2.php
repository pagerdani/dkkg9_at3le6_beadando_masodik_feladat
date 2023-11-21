<?php

class Minta_Almenu2_Controller
{
    public $baseName = 'minta_almenu2';

    public function main(array $vars)
    {
        if (!bejelentkezve()) {
            header('Location: ' . SITE_ROOT . 'belepes', true, 302);
            die();
        } else if(felhasznalo_szerepkor_kod() != 'admin') {
            header('Location: ' . SITE_ROOT);
            die();
        }

        $view = new View_Loader($this->baseName."_main");
    }
}

?>