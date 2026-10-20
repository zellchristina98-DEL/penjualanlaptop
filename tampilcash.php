<?php
include 'koneksi.php';
header('Content-Type: application/json');

$sql = "SELECT bc.kode_cash, bc.ktp, p.nama_pembeli, bc.kode_laptop, l.merk, l.type, bc.cash_tgl, bc.cash_bayar 
        FROM beli_cash bc 
        JOIN pembeli p ON bc.ktp = p.ktp 
        JOIN laptop l ON bc.kode_laptop = l.kode_laptop";

$result = $conn->query($sql);
$data = array();

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>