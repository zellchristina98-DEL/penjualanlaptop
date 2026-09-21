<?php

include 'koneksi.php';

$kode_paket = $_POST['kode_paket'] ?? '';

$response = [
    "status" => 0,
    "message" => "Gagal menghapus"
];

if (!empty($kode_paket)) {

    $query = "DELETE FROM paket
              WHERE kode_paket='$kode_paket'";

    if (mysqli_query($conn, $query)) {

        $response = [
            "status" => 1,
            "message" => "Berhasil dihapus"
        ];

    } else {

        $response = [
            "status" => 0,
            "message" => "Gagal menghapus: " . mysqli_error($conn)
        ];
    }
}

echo json_encode($response);

?>