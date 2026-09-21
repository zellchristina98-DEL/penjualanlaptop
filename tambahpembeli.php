<?php
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json');

include 'koneksi.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $noktp  = trim($_POST['ktp'] ?? '');
    $nama   = trim($_POST['nama_pembeli'] ?? '');
    $alamat = trim($_POST['alamat_pembeli'] ?? '');
    $telpon = trim($_POST['telp_pembeli'] ?? '');

    if ($noktp && $nama && $alamat && $telpon) {

        // Cek apakah KTP sudah terdaftar
        $checkStmt = $conn->prepare("SELECT ktp FROM pembeli WHERE ktp = ?");
        if (!$checkStmt) {
            $response['message'] = "Error SQL (Cek KTP): " . $conn->error;
            echo json_encode($response);
            exit;
        }
        $checkStmt->bind_param("s", $noktp);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            $response['message'] = "No. KTP '$noktp' sudah terdaftar!";
        } else {
            $insertStmt = $conn->prepare("INSERT INTO pembeli (ktp, nama_pembeli, alamat_pembeli, telp_pembeli) VALUES (?, ?, ?, ?)");
            if (!$insertStmt) {
                $response['message'] = "Error SQL Insert: " . $conn->error;
                echo json_encode($response);
                exit;
            }

            $insertStmt->bind_param("ssss", $noktp, $nama, $alamat, $telpon);

            if ($insertStmt->execute()) {
                $response['success'] = true;
                $response['message'] = "Data Berhasil Disimpan";
            } else {
                $response['message'] = "Gagal simpan: " . $conn->error;
            }
            $insertStmt->close();
        }
        $checkStmt->close();

    } else {
        $response['message'] = "Semua data wajib diisi";
    }

} else {
    $response['message'] = "Metode request tidak valid";
}

echo json_encode($response);
$conn->close();
?>