<?php
include 'koneksi.php'; 

$query = "SELECT * FROM bayar_cicilan";
$result = mysqli_query($conn, $query);

$response = array();

while ($row = mysqli_fetch_assoc($result)) {
    $response[] = $row;
}

echo json_encode($response);
mysqli_close($conn);
?>