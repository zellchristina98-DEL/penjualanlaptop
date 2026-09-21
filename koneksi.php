<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "penjualan_laptop";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    header('Content-Type: application/json');
    die(json_encode([
        'success' => false,
        'message' => 'Koneksi database gagal: ' . $conn->connect_error
    ]));
}
?>