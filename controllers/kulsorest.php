<?php

class Kulsorest_Controller
{
    public $baseName = 'kulsorest';
    public function main(array $vars)
    {
        $view = new View_Loader($this->baseName."_main");

        $datum = $_POST['datum'] ?? date('Y-m-d');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $start = date("Y-m-d\TH:i", strtotime($datum . ' 00:00'));
            $end = date("Y-m-d\TH:i", strtotime($datum . ' 23:59'));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,  "https://api.carbonintensity.org.uk/generation/" . $start . "/" . $end);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = json_decode(curl_exec($ch), true);
            curl_close($ch);

            $view->assign('result', $result);
        }

        $view->assign('datum', $datum);
        $view->assign('js', '<script src="' . SITE_ROOT . 'js/kulsorest.js"></script>');
    }
}

?>