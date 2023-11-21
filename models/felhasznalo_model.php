<?php

class Felhasznalo_Model
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = get_db_connection();
    }

    public function felhasznalo_letezik($felhasznalo)
    {
        $stmt = $this->dbh->prepare('SELECT COUNT(*) AS count FROM felhasznalok WHERE bejelentkezes = ?;');
        $stmt->execute([$felhasznalo]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function felhasznalo_hozzaad($data)
    {
        $stmt = $this->dbh->prepare('INSERT INTO felhasznalok(csaladi_nev, utonev, bejelentkezes, jelszo, szerepkor_id) VALUES(?,?,?,?,?);');
        $stmt->execute([
            $data['csaladi_nev'],
            $data['utonev'],
            $data['bejelentkezes'],
            password_hash($data['jelszo'], PASSWORD_DEFAULT),
            $data['szerepkor_id']
        ]);
    }

    public function jelszot_ellenoriz($bejelentkezes, $jelszo)
    {
        $stmt = $this->dbh->prepare('SELECT bejelentkezes, jelszo FROM felhasznalok WHERE bejelentkezes = ?');
        $stmt->execute([$bejelentkezes]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return password_verify($jelszo, $result['jelszo']);
    }

    public function get_felhasznalo($bejelentkezes)
    {
        $stmt = $this->dbh->prepare('SELECT f.id, csaladi_nev, utonev, bejelentkezes, szerepkor_id, sz.kod as szerepkor_kod FROM felhasznalok f INNER JOIN szerepkorok sz ON f.szerepkor_id = sz.id WHERE bejelentkezes = ?');
        $stmt->execute([$bejelentkezes]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>