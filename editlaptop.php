<?php

include 'koneksi.php';

$kode_laptop = $_POST['kode_laptop'] ?? '';
$merk = $_POST['merk'] ?? '';
$type = $_POST['type'] ?? '';
$warna = $_POST['warna'] ?? '';
$harga = $_POST['harga'] ?? '';

$response = [
    "status" => 0,
    "message" => "Data Tidak Lengkap"
];

if (!empty($kode_laptop) &&
    !empty($merk) &&
    !empty($type) &&
    !empty($warna) &&
    !empty($harga)) {

    $sql = "UPDATE laptop SET
            merk='$merk',
            type='$type',
            warna='$warna',
            harga='$harga'
            WHERE kode_laptop='$kode_laptop'";

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