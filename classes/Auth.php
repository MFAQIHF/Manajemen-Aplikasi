<?php
class Auth // otentikasi pengguna (login & register)
{
    private $conn; // menyimpan objek koneksi database
    public function __construct(mysqli $db) // menerima objek koneksi database
    {
        $this->conn = $db;
        session_start();
    }

    public function register($username, $password)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)"); //insert data pengguna
        if (!$stmt) { //memeriksa error
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("ss", $username, $hashed); // "ss" for two strings
        return $stmt->execute();
    }

    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT id, password FROM users WHERE username = ?"); //memilih id & pass berdasar username
        if (!$stmt) { //memeriksa error
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }
        $stmt->bind_param("s", $username); // "s" for one string
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) { // memeriksa kecocokan hash dengan pw
            $_SESSION['user_id'] = $id; //login berhasil, simpan id di sesi
            return true;
        }
        return false;
    }

    public function isLoggedIn() //memeriksa status login
    {
        return isset($_SESSION['user_id']); // jika sudah login mengembalikan true (ada di sesi)
    }

    public function logout() // menghancurkan semua data dalam sesi
    {
        session_destroy();
    }
}
?>
