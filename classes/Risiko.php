<?php
require_once 'BaseModel.php'; // memasukan class parent BaseModel

class Risiko extends BaseModel //Mewarisi dari BaseModel
{
    private $id;
    private $namaRisiko;
    private $kategori;
    private $deskripsi;
    private $kemungkinan;
    private $dampak;
    private $levelRisiko;
    private $userId;
    private $createdAt;

    public function __construct(mysqli $db)
    {
        parent::__construct($db); //Memanggil konstruktor BaseModel
    }

    // --- Getter dan Setter untuk properti relevan ---
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setNamaRisiko(string $namaRisiko): void
    {
        $this->namaRisiko = $namaRisiko;
    }

    public function getNamaRisiko(): ?string
    {
        return $this->namaRisiko;
    }

    public function setKategori(string $kategori): void
    {
        $this->kategori = $kategori;
    }

    public function getKategori(): ?string
    {
        return $this->kategori;
    }

    public function setDeskripsi(string $deskripsi): void
    {
        $this->deskripsi = $deskripsi;
    }

    public function getDeskripsi(): ?string
    {
        return $this->deskripsi;
    }

    public function setKemungkinan(int $kemungkinan): void
    {
        // Tambahkan validasi jika perlu
        $this->kemungkinan = $kemungkinan;
    }

    public function getKemungkinan(): ?int
    {
        return $this->kemungkinan;
    }

    public function setDampak(int $dampak): void
    {
        // Tambahkan validasi jika perlu
        $this->dampak = $dampak;
    }

    public function getDampak(): ?int
    {
        return $this->dampak;
    }

    public function setLevelRisiko(string $levelRisiko): void
    {
        $this->levelRisiko = $levelRisiko;
    }

    public function getLevelRisiko(): ?string
    {
        return $this->levelRisiko;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    // Getter/setter di atas bisa digunakan saat membuat objek Risiko
    // dari data database, lalu mengakses properti melalui getter.

    public function simpanRisiko($data)
    {
        $nilaiRisiko = $data['kemungkinan'] * $data['dampak']; // hitung nilai risiko
        $level = $this->hitungLevelRisiko($nilaiRisiko);
        // memasukkan risiko
        $stmt = $this->conn->prepare("INSERT INTO risiko (user_id, deskripsi, kemungkinan, dampak, level_risiko, created_at, nama_risiko, kategori) VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)");
        if (!$stmt) {// memeriksa error
            error_log("Prepare failed: " . $this->conn->error);
            return false;
        }

        try {
            $stmt->bind_param("isiisss", // user_id (int), deskripsi (string), likelihood (int), impact (int), level (string), nama_risiko (string), kategori (string)
                $data['user_id'], // mengikat parameter ke pernyataan: Fungsi ini mengambil nilai-nilai yang sebenarnya dan mengaitkannya dengan placeholder (?) dalam query yang sudah disiapkan.
                $data['deskripsi'],
                $data['kemungkinan'],
                $data['dampak'],
                $level,
                $data['nama_risiko'],
                $data['kategori']
            );
            return $stmt->execute(); //eksekusi pernyataan
        } catch (mysqli_sql_exception $e) {
            error_log("MySQLi Error in simpanRisiko: " . $e->getMessage());//mencatat error
            return false;
        }
    }

    private function hitungLevelRisiko($nilai)//method hitung level risiko
    {
        if ($nilai <= 5) return 'Rendah';
        elseif ($nilai <= 15) return 'Sedang';
        return 'Tinggi';
    }

    public function semuaRisiko($userId = null, $filter = []) //mengambil semua risiko
    {//mengambil data risiko ke tabel risiko
        $sql = "SELECT * FROM risiko";
        $params = [];
        $types = "";

        if ($userId) {
            $sql .= " WHERE user_id = ?";
            $params[] = $userId;
            $types .= "i";
        }

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->conn->error);
            return [];
        }

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>