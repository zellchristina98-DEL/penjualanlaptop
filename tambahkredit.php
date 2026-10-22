<?php
include 'koneksi.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_kredit  = $_POST['kode_kredit'] ?? '';
    $ktp          = $_POST['ktp'] ?? '';
    $kode_laptop  = $_POST['kode_laptop'] ?? '';
    $tanggal      = $_POST['tanggal_kredit'] ?? '';
    $bayar_kredit = $_POST['bayar_kredit'] ?? '';
    $tenor        = $_POST['tenor'] ?? '';
    $totalcicil   = $_POST['cicilan'] ?? ''; // Mengambil parameter dari Android 'cicilan'

    if ($kode_kredit && $ktp && $kode_laptop && $tanggal && $bayar_kredit && $tenor && $totalcicil) {
        // Query disesuaikan dengan kolom asli di database (tanpa kode_paket)
        $stmt = $conn->prepare("INSERT INTO kredit 
         (kode_kredit, ktp, kode_laptop, tanggal_kredit, bayar_kredit, tenor, totalcicil) 
         VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sssssii", $kode_kredit, $ktp, $kode_laptop, $tanggal, $bayar_kredit, $tenor, $totalcicil);
        
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Data berhasil disimpan";
        } else {
            $response['message'] = "Gagal simpan: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = "Semua data wajib diisi";
    }
}
echo json_encode($response);
?>