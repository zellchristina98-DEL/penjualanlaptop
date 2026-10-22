<?php
include 'koneksi.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_cash = $_POST['kode_cash'] ?? '';
    $ktp = $_POST['ktp'] ?? '';
    $kode_laptop = $_POST['kode_laptop'] ?? '';
    $cash_tgl = $_POST['cash_tgl'] ?? '';

    if($kode_cash && $ktp && $kode_laptop && $cash_tgl) {
        $stmt = $conn->prepare("SELECT harga FROM laptop WHERE kode_laptop = ?");
        $stmt->bind_param("s", $kode_laptop);
        $stmt->execute();
        $stmt->bind_result($harga);
        $stmt->fetch();
        $stmt->close();

        if ($harga !== null) {
        
            $stmt = $conn->prepare("INSERT INTO beli_cash (kode_cash, ktp, kode_laptop, cash_tgl, cash_bayar) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssd", $kode_cash, $ktp, $kode_laptop, $cash_tgl, $harga);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Data berhasil disimpan";
            } else {
                $response['message'] = "Gagal simpan: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = "Kode Laptop tidak ditemukan";
        }
    } else {
        $response['message'] = "Semua data wajib diisi";
    }
} else {
    $response['message'] = "Metode request tidak valid";
}
echo json_encode($response);
?>