<?php

include 'koneksi.php';

$ktp = $_POST['ktp'] ?? '';
$nama_pembeli = $_POST['nama_pembeli'] ?? '';
$alamat_pembeli = $_POST['alamat_pembeli'] ?? '';
$telp_pembeli = $_POST['telp_pembeli'] ?? '';

$response = [
    "status" => 0,
    "message" => "Data Tidak Lengkap"
];

if (!empty($ktp) &&
    !empty($nama_pembeli) &&
    !empty($alamat_pembeli) &&
    !empty($telp_pembeli)) {

    $sql = "UPDATE pembeli SET
            nama_pembeli='$nama_pembeli',
            alamat_pembeli='$alamat_pembeli',
            telp_pembeli='$telp_pembeli'
            WHERE ktp='$ktp'";

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