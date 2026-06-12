<?php
class Koneksi {
    private $host = "localhost";
    private $db_name = "DB_LATIHAN_TRPL1A_SunuSetyoJati";
    private $username = "root";
    private $password = "";
    protected $conn;

    public function getKoneksi() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Koneksi error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>