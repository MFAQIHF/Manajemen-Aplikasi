<?php
require 'config/Database.php'; // konfigurasi database
require 'classes/Risiko.php'; // memasukkan class Risiko dan Validator
require 'classes/Validator.php';
session_start();

if (!isset($_SESSION['user_id'])) { // memeriksa status login
    header('Location: login.php');
    exit();
}

$db = (new Database())->connect(); // koneksi ke database
$risiko = new Risiko($db); // membuat objek risiko

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'user_id' => $_SESSION['user_id'], // mengambil isi dari tabel risiko dari form
        'nama_risiko' => $_POST['nama_risiko'] ?? '', // ?? untuk memeriksa apakah sudah terisi belum jika belum akan diisi ' '(tidak ada) atau 0 
        'kategori' => $_POST['kategori'] ?? '',
        'deskripsi' => $_POST['deskripsi'] ?? '',
        'kemungkinan' => $_POST['kemungkinan'] ?? 0,
        'dampak' => $_POST['dampak'] ?? 0,
    ];

    if (isset($data['nama_risiko'], $data['kategori'], $data['deskripsi'], $data['kemungkinan'], $data['dampak'])) {

        $simpanBerhasil = $risiko->simpanRisiko($data); // memangil method simpanRisko

        if ($simpanBerhasil) {
            echo "Risiko berhasil disimpan!";
        } else {
            echo "Gagal menyimpan risiko. Periksa log server untuk detail.";
        }
    } else {
        echo "Data tidak valid! Pastikan nama risiko, kategori, deskripsi, kemungkinan, dan dampak terisi.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Input Risiko</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="form-container">
        <h2>Tambah Risiko Baru</h2>
        <form method="post">
            <label for="nama_risiko">Nama Risiko:</label>
            <input type="text" id="nama_risiko" name="nama_risiko" required><br>
            <br>
            <label for="kategori">Kategori Risiko:</label>
            <input type="text" id="kategori" name="kategori" required><br>
            <br>
            <label for="deskripsi">Deskripsi Risiko:</label>
            <input type="text" id="deskripsi" name="deskripsi" required><br>
            <br>
            <label for="kemungkinan">Kemungkinan (1-5):</label>
            <input type="number" id="kemungkinan" name="kemungkinan" min="1" max="5" required><br>
            <br>
            <label for="dampak">Dampak (1-5):</label>
            <input type="number" id="dampak" name="dampak" min="1" max="5" required><br>
            <br>
            <button type="submit" class="btn">Simpan Risiko</button>
            <a href="dashboard.php" class="btn">Kembali ke Dashboard</a>
        </form>
    </div>
</body>

</html>