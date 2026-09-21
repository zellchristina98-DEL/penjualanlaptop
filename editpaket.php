<?php

include 'koneksi.php';

$kode_paket = $_POST['kode_paket'] ?? '';
$uang_muka = $_POST['uang_muka'] ?? '';
$tenor = $_POST['tenor'] ?? '';
$bunga_cicilan = $_POST['bunga_cicilan'] ?? '';

$response = [
    "status" => 0,
    "message" => "Data Tidak Lengkap"
];

if (!empty($kode_paket) &&
    !empty($uang_muka) &&
    !empty($tenor) &&
    !empty($bunga_cicilan)) {

    $sql = "UPDATE paket SET
            uang_muka='$uang_muka',
            tenor='$tenor',
            bunga_cicilan='$bunga_cicilan'
            WHERE kode_paket='$kode_paket'";

    if (mysqli_query($conn, $sql)) {

        $response = [
            "status" => 1,
            "message" => "Update Berhasil"
        ];

    } else {

        $response = [
            "status" => 0,
            "message" => "Update Gagal: " . mysqli_error($conn)
        ];
    }
}

echo json_encode($response);

?>