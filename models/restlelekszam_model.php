<?php

class Restlelekszam_Model
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = get_db_connection();
    }

    public function varosLetezik($varos_id)
    {
        $stmt = $this->dbh->prepare('SELECT COUNT(*) AS count FROM varos WHERE id = ?;');
        $stmt->execute([$varos_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function evLetezik($varos_id, $ev)
    {
        $stmt = $this->dbh->prepare('SELECT COUNT(*) AS count FROM lelekszam WHERE varosid = ? AND ev = ?;');
        $stmt->execute([$varos_id, $ev]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getLelekszamok($varos_id)
    {
        $stmt = $this->dbh->prepare('SELECT ev, osszesen, no, (osszesen - no) AS ferfi FROM lelekszam WHERE varosid = ? ORDER BY ev');
        $stmt->execute([$varos_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertLelekszam($varos_id, $data)
    {
        $stmt = $this->dbh->prepare('INSERT INTO lelekszam (varosid, ev, no, osszesen) VALUES (?,?,?,?)');
        $stmt->execute([
            $varos_id,
            $data['ev'],
            $data['no'],
            $data['osszesen']
        ]);
    }

    public function updateLelekszam($varos_id, $data)
    {
        $stmt = $this->dbh->prepare('UPDATE lelekszam SET no = ?, osszesen = ? WHERE varosid = ? AND ev = ?');
        $stmt->execute([
            $data['no'],
            $data['osszesen'],
            $varos_id,
            $data['ev']
        ]);
    }

    public function deleteLelekszam($varos_id, $data)
    {
        $stmt = $this->dbh->prepare('DELETE FROM lelekszam WHERE varosid = ? AND ev = ?');
        $stmt->execute([
            $varos_id,
            $data['ev']
        ]);
    }
}

?>