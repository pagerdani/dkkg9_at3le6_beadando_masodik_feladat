<?php

class Restteszt_Model
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
}

?>