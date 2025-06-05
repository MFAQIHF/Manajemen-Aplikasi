<?php
session_start();
if (isset($_SESSION['user_id'])) { //memeriksa keadaan "login"
    header('Location: dashboard.php'); // diarahkan ke dahsboard
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Manajemen Risiko</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container">
        <h2>Selamat Datang</h2>
        <a href="login.php" class="btn">Login</a>
        <a href="register.php" class="btn">Register</a>
    </div>
</body>

</html>