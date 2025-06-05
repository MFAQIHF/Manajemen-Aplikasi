<?php
require 'config/Database.php'; //memuat class Database dan Auth
require 'classes/Auth.php';

$auth = new Auth((new Database())->connect());// koneksi ke database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($auth->login($_POST['username'], $_POST['password'])) { //memanggil method login pada class Auth
        header('Location: dashboard.php'); // login berhasil diarahkan ke dahboard
        exit();
    } else {
        $error = "Login gagal.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - MARES</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <br>
            <input type="password" name="password" placeholder="Password" required><br>
            <br>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>

</html>