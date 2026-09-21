<?php
ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json');

include 'koneksi.php';

$sql = "SELECT * FROM paket";
$result = $conn->query($sql);

$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>