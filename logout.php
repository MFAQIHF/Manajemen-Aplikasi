<?php
require 'classes/Auth.php';
require 'config/Database.php';
$auth = new Auth((new Database())->connect());
$auth->logout(); //memanggil method logout dari class auth yang berfungsi menghancurkan sesi
header('Location: index.php'); //diarahkan kembali ke hlmn index.php
exit();
?>