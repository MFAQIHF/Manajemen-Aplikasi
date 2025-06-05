<?php
class Database
{
    public function connect()
    {
        $host = 'localhost';
        $db = 'mares';
        $user = 'root';
        $pass = '';

        $conn = new mysqli($host, $user, $pass, $db); //membuat onjek koneksi mysqli 

        if ($conn->connect_error) { //memeriksa error saat koneksi
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}
?>
