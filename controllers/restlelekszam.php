<?php

class Restlelekszam_Controller
{
    private $model;

    public function __construct()
    {
        $this->model = new Restlelekszam_Model();
    }

    public function main(array $vars)
    {
        $varos_id = $vars[0] ?? null;

        if (!$varos_id) {
            http_response_code(400);
            die();
        }

        if (!$this->model->varosLetezik($varos_id)) {
            http_response_code(404);
            die();
        }

        header('Content-Type: application/json; charset=utf-8');

        switch($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                echo json_encode($this->model->getLelekszamok($varos_id));
                break;
            case 'POST':
                $incoming = file_get_contents("php://input");
                $data = json_decode($incoming, true);
                $errors = $this->validate($data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode($errors);
                    die();
                } else if ($this->model->evLetezik($varos_id, $data['ev'])) {
                    http_response_code(422);
                    echo json_encode(['ev' => 'Az év már lézetik az adatbázisban.']);
                    die();
                }

                $this->model->insertLelekszam($varos_id, $data);
                break;
            case 'PUT':
                $incoming = file_get_contents("php://input");
                $data = json_decode($incoming, true);
                $errors = $this->validate($data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode($errors);
                    die();
                } else if (!$this->model->evLetezik($varos_id, $data['ev'])) {
                    http_response_code(422);
                    echo json_encode(['ev' => 'Az év nem lézetik az adatbázisban.']);
                    die();
                }

                $this->model->updateLelekszam($varos_id, $data);
                break;
            case 'DELETE':
                $incoming = file_get_contents("php://input");
                $data = json_decode($incoming, true);
                $errors = $this->validateYear($data);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode($errors);
                    die();
                } else if (!$this->model->evLetezik($varos_id, $data['ev'])) {
                    http_response_code(422);
                    echo json_encode(['ev' => 'Az év nem lézetik az adatbázisban.']);
                    die();
                }

                $this->model->deleteLelekszam($varos_id, $data);
                break;
        }
        die();
    }

    private function validate($data)
    {
        $errors = [];

        if (!$data) {
            $errors[] = 'Érvénytelen bemenet.';
            return $errors;
        }

        if (!isset($data['ev']) || !is_numeric($data['ev']) || !($data['ev'] > 0)) {
            $errors['ev'] = 'Érvénytelen év paraméter.';
        }

        if (!isset($data['osszesen']) || !is_numeric($data['osszesen']) || !($data['osszesen'] > 0)) {
            $errors['osszesen'] = 'Érvénytelen összesen paraméter.';
        }

        if (!isset($data['no']) || !is_numeric($data['no']) || !($data['no'] > 0)) {
            $errors['no'] = 'Érvénytelen nő paraméter.';
        }

        if ((!isset($errors['no']) && !isset($errors['osszesen'])) && $data['no'] > $data['osszesen']) {
            $errors['osszesen'] = 'Az összesen paraméter értéke kevés.';
        }

        return $errors;
    }

    private function validateYear($data)
    {
        $errors = [];

        if (!$data) {
            $errors[] = 'Érvénytelen bemenet.';
            return $errors;
        }

        if (!isset($data['ev']) || !is_numeric($data['ev']) || !($data['ev'] > 0)) {
            $errors['ev'] = 'Érvénytelen év paraméter.';
        }

        return $errors;
    }
}

?>