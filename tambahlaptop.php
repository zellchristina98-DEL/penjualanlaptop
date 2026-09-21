<?php
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json');

include 'koneksi.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kode  = trim($_POST['kode_laptop'] ?? '');
    $merk  = trim($_POST['merk'] ?? '');
    $type  = trim($_POST['type'] ?? '');
    $warna = trim($_POST['warna'] ?? '');
    $harga = trim($_POST['harga'] ?? '');

    if ($kode && $merk && $type && $warna && $harga) {

        if (!is_numeric($harga)) {
            $response['message'] = "Harga harus berupa angka!";
        } else {
            $checkStmt = $conn->prepare("SELECT kode_laptop FROM laptop WHERE kode_laptop = ?");
            if (!$checkStmt) {
                $response['message'] = "Error SQL (Cek Kolom): " . $conn->error;
                echo json_encode($response);
                exit;
            }
            
            $checkStmt->bind_param("s", $kode);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $response['message'] = "Kode Laptop '$kode' sudah terdaftar! Gunakan kode lain.";
            } else {
                $insertStmt = $conn->prepare("INSERT INTO laptop (kode_laptop, type, merk, warna, harga) VALUES (?, ?, ?, ?, ?)");
                if (!$insertStmt) {
                    $response['message'] = "Error SQL Insert: " . $conn->error;
                    echo json_encode($response);
                    exit;
                }

                $hargaInt = (int)$harga;
                $insertStmt->bind_param("ssssi", $kode, $type, $merk, $warna, $hargaInt);

                if ($insertStmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = "Data Berhasil Disimpan";
                } else {
                    $response['message'] = "Gagal simpan: " . $conn->error;
                }
                $insertStmt->close();
            }
            $checkStmt->close();
        }

    } else {
        $response['message'] = "Semua data wajib diisi";
    }

} else {
    $response['message'] = "Metode request tidak valid";
}

echo json_encode($response);
?>