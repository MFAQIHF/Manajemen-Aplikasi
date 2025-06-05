<?php
class BaseModel //parent class
{
  protected $conn; // Menggunakan protected agar bisa diakses oleh kelas turunan, $conn menyimpan objek koneksi ke database

  public function __construct(mysqli $db) //menyediakan tempat untuk menyimpan objek koneksi database yang sudah ada
  {
    $this->conn = $db;
  }
}
/* class ini menghubungkan objek mysqli pada database ke keseluruhan program yang akan menjadi parent class dari
fungsi fungsi dibawahnya */
?>