<?php
//error_reporting(E_ERROR | E_PARSE);

require_once SERVER_ROOT . '/lib/tcpdf/tcpdf.php';

class Pdfexport_Controller {
    private $model;

    public function __construct()
    {
        $this->model = new Pdfexport_Model();
    }

    public function main(array $vars)
    {
        $varos_id = $vars[0];
        $ev = $vars[1];

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetFont('dejavusans', '', 11);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Web-programozás II - 2. feladat');
        $pdf->SetTitle('Lélekszám infó');
        $pdf->SetSubject('Lélekszám infó');
        $pdf->SetKeywords('TCPDF, PDF, Web-programozás II, 2. feladat');

        $pdf->AddPage();
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        $megye = $this->model->getMegyeNev($varos_id);
        $varosInfo = $this->model->getVarosInfo($varos_id);
        $evinfo = $this->model->getEvInfo($varos_id, $ev);

        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<h1 style="text-align: center;">Város adatlap</h1>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<p>Város neve: ' . $varosInfo['nev'] . '</p>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<p>Megye: ' . $megye . '</p>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<p>Megyeszékhely: ' . ($varosInfo['megyeszekhely'] == 0 ? 'Nem' : 'Igen') . '</p>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<p>Megyei jogú: ' . ($varosInfo['megyeijogu'] == 0 ? 'Nem' : 'Igen') . '</p>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<h3>Lélekszám statisztikai adatok ' . $ev . '. évre:</h3>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<p>Nő: ' . $evinfo['no'] . '</p>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<p>Féfi: ' . $evinfo['ferfi'] . '</p>');
        $pdf->writeHTML('<br>');
        $pdf->writeHTML('<p>Összesen: ' . $evinfo['osszesen'] . '</p>');
        $pdf->Output('export.pdf', 'I');
    }
}

?>