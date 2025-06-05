<?php
require 'config/Database.php'; // memuat kelas Database dan auth
require 'classes/Auth.php';

$auth = new Auth((new Database())->connect()); //memuat onejk auth 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($auth->register($_POST['username'], $_POST['password'])) { //memangil metod reigister dari class auth
        header('Location: login.php'); //diarahkan ke page login
        exit();
    } else {
        $error = "Registrasi gagal.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register - MARES</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="form-container">
        <h2>Register</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required><br>
            <br>
            <input type="password" name="password" placeholder="Password" required><br>
            <br>
            <button type="submit" class="btn">Register</button>
        </form>
    </div>
</body>

</html>