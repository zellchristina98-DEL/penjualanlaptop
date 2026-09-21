<?php
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json');

include 'koneksi.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kode  = trim($_POST['kode_paket'] ?? '');
    $uang  = trim($_POST['uang_muka'] ?? '');
    $bunga = trim($_POST['bunga_cicilan'] ?? '');   // FIXED sesuai nama kolom DB
    $tenor = trim($_POST['tenor'] ?? '');

    if ($kode && $uang !== '' && $bunga !== '' && $tenor !== '') {

        if (!is_numeric($uang) || !is_numeric($bunga) || !is_numeric($tenor)) {
            $response['message'] = "Uang muka, bunga, dan tenor harus berupa angka!";
        } else {
            $checkStmt = $conn->prepare("SELECT kode_paket FROM paket WHERE kode_paket = ?");
            if (!$checkStmt) {
                $response['message'] = "Error SQL (Cek Kolom): " . $conn->error;
                echo json_encode($response);
                exit;
            }

            $checkStmt->bind_param("s", $kode);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $response['message'] = "Kode paket '$kode' sudah terdaftar! Gunakan kode lain.";
            } else {
                $insertStmt = $conn->prepare("INSERT INTO paket (kode_paket, uang_muka, bunga_cicilan, tenor) VALUES (?, ?, ?, ?)");
                if (!$insertStmt) {
                    $response['message'] = "Error SQL Insert: " . $conn->error;
                    echo json_encode($response);
                    exit;
                }

                $uangFloat  = (float)$uang;
                $bungaFloat = (float)$bunga;
                $tenorInt   = (int)$tenor;

                $insertStmt->bind_param("sddi", $kode, $uangFloat, $bungaFloat, $tenorInt);

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
$conn->close();
?>