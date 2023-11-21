<?php
class Grafikon_Model
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = get_db_connection();
    }

    public function getVarosok()
    {
        $stmt = $this->dbh->prepare('SELECT id, nev FROM varos ORDER BY nev');
        $stmt->execute([]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChartData($varos_id)
    {
        $stmt = $this->dbh->prepare('SELECT ev, no, (osszesen - no) AS ferfi FROM lelekszam WHERE varosid = ? ORDER BY ev');
        $stmt->execute([$varos_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>