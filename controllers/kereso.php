<?php
class Kereso_Controller
{
    public $baseName = 'kereso';
    private $kereso_model;

    public function __construct()
    {
        $this->kereso_model = new Kereso_Model();
    }

    public function main(array $vars)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            switch($_POST['op']) {
                case 'megye':
                    echo json_encode($this->kereso_model->getMegyek());
                    break;
                case 'varos':
                    echo json_encode($this->kereso_model->getVarosok($_POST['id']));
                    break;
                case 'ev':
                    echo json_encode($this->kereso_model->getEvek($_POST['id']));
                    break;
                case 'info':
                    echo json_encode($this->kereso_model->getInfo($_POST['varosid'], $_POST['ev']));
                    break;
            }
            die();
        } else {
            $view = new View_Loader($this->baseName."_main");
            $view->assign('js', '<script src="' . SITE_ROOT . 'js/kereso.js"></script>');
        }
    }
}

?>