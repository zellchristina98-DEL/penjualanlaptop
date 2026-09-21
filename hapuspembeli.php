<?php

include 'koneksi.php';

$ktp = $_POST['ktp'] ?? '';

$response = [
    "status" => 0,
    "message" => "KTP tidak ditemukan"
];

if (!empty($ktp)) {

    $query = "DELETE FROM pembeli WHERE ktp='$ktp'";

    if (mysqli_query($conn, $query)) {

        if (mysqli_affected_rows($conn) > 0) {

            $response = [
                "status" => 1,
                "message" => "Data Berhasil Dihapus"
            ];

        } else {

            $response = [
                "status" => 0,
                "message" => "Data dengan KTP tersebut tidak ditemukan"
            ];
        }

    } else {

        $response = [
            "status" => 0,
            "message" => "Gagal Menghapus: " . mysqli_error($conn)
        ];
    }
}

echo json_encode($response);

?>