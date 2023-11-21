<?php

class Kereso_Model
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = get_db_connection();
    }

    public function getMegyek()
    {
        $stmt = $this->dbh->prepare('SELECT id, nev FROM megye ORDER BY nev');
        $stmt->execute([]);

        $eredmeny = [];
        $eredmeny['lista'] = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eredmeny["lista"][] = array("id" => $row['id'], "nev" => $row['nev']);
        }

        return $eredmeny;
    }

    public function getVarosok($megye_id)
    {
        $stmt = $this->dbh->prepare('SELECT id, nev FROM varos WHERE megyeid = ? ORDER BY nev');
        $stmt->execute([$megye_id]);

        $eredmeny = [];
        $eredmeny['lista'] = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eredmeny["lista"][] = array("id" => $row['id'], "nev" => $row['nev']);
        }

        return $eredmeny;
    }

    public function getEvek($varos_id)
    {
        $stmt = $this->dbh->prepare('SELECT ev FROM lelekszam WHERE varosid = ? ORDER BY ev');
        $stmt->execute([$varos_id]);

        $eredmeny = [];
        $eredmeny['lista'] = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $eredmeny["lista"][] = array("ev" => $row['ev']);
        }

        return $eredmeny;
    }

    public function getInfo($varos_id, $ev)
    {
        $stmt = $this->dbh->prepare('SELECT osszesen, no, (osszesen - no) AS ferfi FROM lelekszam WHERE varosid = ? AND ev = ? ORDER BY ev');
        $stmt->execute([$varos_id, $ev]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>