<?php
require_once 'BaseModel.php'; //Memasukkan class BaseModel

class User extends BaseModel
{
    public function __construct(mysqli $db)
    {
        parent::__construct($db);//menyimpan koneksi database ke BaseModel
    }

    public function allUsers() //mengambil semua pengguna
    {
        $stmt = $this->conn->prepare("SELECT * FROM users");
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getUserById($id) //mengambil pengguna berdasar id
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return null;
        }
        $stmt->bind_param("i", $id); // "i" for integer
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>