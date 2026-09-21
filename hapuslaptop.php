<?php

include 'koneksi.php';

header('Content-Type: application/json');

$kode_laptop = $_POST['kode_laptop'] ?? '';

if (empty($kode_laptop)) {
    echo json_encode([
        "status" => 0,
        "message" => "Kode laptop kosong"
    ]);
    exit;
}

$query = "DELETE FROM laptop WHERE kode_laptop = '$kode_laptop'";

$result = mysqli_query($conn, $query);

if ($result) {

    if (mysqli_affected_rows($conn) > 0) {

        echo json_encode([
            "status" => 1,
            "message" => "Data Berhasil Dihapus"
        ]);

    } else {

        echo json_encode([
            "status" => 0,
            "message" => "Kode laptop tidak ditemukan"
        ]);
    }

} else {

    echo json_encode([
        "status" => 0,
        "message" => "Gagal Menghapus: " . mysqli_error($conn)
    ]);
}

?>