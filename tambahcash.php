<?php
include 'koneksi.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
 $kode_cash =$_POST['kode_cash'] ?? '';
 $ktp = $_POST['ktp'] ?? '';
 $kode_laptop = $_POST['kode_laptop'] ?? '';
 $cash_tgl = $_POST['cash_tgl'] ?? '';

 if($kode_cash && $ktp && $kode_laptop && $cash_tgl) {
 $stmt = $conn->prepare("SELECT harga from laptop where kode_laptop = ?");
 $stmt->bind_param("s", $kode_laptop);
    $stmt->execute();
    $stmt->bind_result($harga);
    $stmt->fetch();
    $stmt->close();

if ($harga)
{
    $stmt = $conn->prepare("INSERT INTO cash (kode_cash, ktp, kode_laptop, cash_tgl, harga) 
    VALUES (?, ?, ?, ?, ?)");
    $stmt2->bind_param("ssssd", $kode_cash, $ktp, $kode_laptop, $cash_tgl, $harga);
    $response['success'] = $stmt->execute();
    $response['message'] = $response['success'] ? "Data Berhasil Disimpan" : "Gagal simpan: " . $stmt->error;
    $stmt->close();
}  
else
{
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