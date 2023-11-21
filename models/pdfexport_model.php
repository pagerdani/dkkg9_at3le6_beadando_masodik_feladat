<?php

class Pdfexport_Model
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = get_db_connection();
    }

    public function getMegyeNev($varos_id)
    {
        $stmt = $this->dbh->prepare('SELECT m.nev FROM varos v INNER JOIN megye m ON v.megyeid = m.id WHERE v.id = ?');
        $stmt->execute([$varos_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['nev'];
    }

    public function getVarosInfo($varos_id)
    {
        $stmt = $this->dbh->prepare('SELECT nev, megyeszekhely, megyeijogu FROM varos WHERE id = ?');
        $stmt->execute([$varos_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEvInfo($varos_id, $ev)
    {
        $stmt = $this->dbh->prepare('SELECT ev, osszesen, no, (osszesen - no) AS ferfi FROM lelekszam WHERE varosid = ? AND ev = ?');
        $stmt->execute([$varos_id, $ev]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>