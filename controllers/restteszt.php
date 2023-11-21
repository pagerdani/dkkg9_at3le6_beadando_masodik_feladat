<?php

class Restteszt_Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Restteszt_Model();
    }

    public $baseName = 'restteszt';
    public function main(array $vars)
    {
        $varosok = $this->model->getVarosok();

        $view = new View_Loader($this->baseName."_main");
        $view->assign('varosok', $varosok);

        $varosid = $_POST['varosid'] ?? null;

        if (isset($_POST['mode']) && $_POST['mode'] == 'POST') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, SITE_ROOT . 'restlelekszam/' . $varosid);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'ev' => $_POST['ev'],
                'no' => $_POST['no'],
                'osszesen' => $_POST['osszesen']
            ]));

            $answer = json_decode(curl_exec($ch), true);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $view->assign('answer', $answer);
            $view->assign('httpcode', $httpcode);
        } else if (isset($_POST['mode']) && $_POST['mode'] == 'PUT') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, SITE_ROOT . 'restlelekszam/' . $varosid);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'ev' => $_POST['ev'],
                'no' => $_POST['no'],
                'osszesen' => $_POST['osszesen']
            ]));

            $answer = json_decode(curl_exec($ch), true);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $view->assign('answer', $answer);
            $view->assign('httpcode', $httpcode);
        } else if (isset($_POST['mode']) && $_POST['mode'] == 'DELETE') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, SITE_ROOT . 'restlelekszam/' . $varosid);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'ev' => $_POST['ev'],
            ]));

            $answer = json_decode(curl_exec($ch), true);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $view->assign('answer', $answer);
            $view->assign('httpcode', $httpcode);
        }

        if ($varosid != null) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, SITE_ROOT . 'restlelekszam/' . $varosid);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $lelekszamok = json_decode(curl_exec($ch), true);
            curl_close($ch);

            $view->assign('lelekszamok', $lelekszamok);
            $view->assign('varosid', $varosid);
        }
    }
}

?>