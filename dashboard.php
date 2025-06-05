<?php

require 'config/Database.php'; //konfigurasi Database
require 'classes/Risiko.php'; // memasukan kelas Risiko dan Auth
require 'classes/Auth.php'; 

session_start();
if (!isset($_SESSION['user_id'])) { //memerika keadaan login, jika belum dikemablikan ke login page
    header('Location: login.php');
    exit();
}

$db = (new Database())->connect(); // membuat koneksi ke database
$risiko = new Risiko($db); // membuat objek risiko
$dataRisiko = $risiko->semuaRisiko($_SESSION['user_id']); //mengambil data risiko yg terkatik dgn user_id (yg login)
?>
<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - MARES</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container">
        <h2>Daftar Risiko</h2>
        <a href="input_risiko.php" class="btn">+ Tambah Risiko</a>
        <a href="logout.php" class="btn">Logout</a>
        <table>
            <thead>
                <tr>
                    <th>Nama Risiko</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Kemungkinan</th>
                    <th>Dampak</th>
                    <th>Level Risiko</th>
                    <th>Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dataRisiko as $r): ?> <!--menampilkan data risiko dalam tabel-->
                    <tr>
                        <td><?= htmlspecialchars($r['nama_risiko']) ?></td>
                        <td><?= htmlspecialchars($r['kategori']) ?></td>
                        <td><?= htmlspecialchars($r['deskripsi']) ?></td>
                        <td><?= htmlspecialchars($r['kemungkinan']) ?></td>
                        <td><?= htmlspecialchars($r['dampak']) ?></td>
                        <td><?= htmlspecialchars($r['level_risiko']) ?></td>
                        <td><?= htmlspecialchars($r['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($dataRisiko)): ?>
                    <tr>
                        <td colspan="7">Belum ada risiko yang tercatat.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>

</html>