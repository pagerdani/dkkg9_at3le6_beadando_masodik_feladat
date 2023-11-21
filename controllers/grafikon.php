<?php

class Grafikon_Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Grafikon_Model();
    }

    public $baseName = 'grafikon';

    public function main(array $vars)
    {
        $view = new View_Loader($this->baseName."_main");

        $varosok = $this->model->getVarosok();
        $varosid = $_POST['varosid'] ?? null;

        $view->assign('varosok', $varosok);
        $view->assign('varosid', $varosid);
        $view->assign('js',
            '<script src="' . SITE_ROOT . 'js/chartjs/chart.umd.min.js"></script>' . PHP_EOL .
            '<script src="' . SITE_ROOT . 'js/grafikon.js"></script>'
        );

        $result = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $result = $this->model->getChartData($varosid);
        }

        $view->assign('result', $result);
    }
}

?>