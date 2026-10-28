<?php
include 'koneksi.php';
header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data sesuai dengan nama parameter yang dikirim dari Android (getParams)
    $kode_cicilan   = $_POST['kode_cicilan'] ?? '';
    $kode_kredit    = $_POST['kode_kredit'] ?? '';
    $tanggal        = $_POST['cicilan_tgl'] ?? '';
    $cicilan_ke     = $_POST['cicilan_ke'] ?? '';
    $jumlah_cicilan = $_POST['jumlah_cicilan'] ?? '';
    $sisa_ke        = $_POST['sisa_ke'] ?? '';
    $sisa_cicilan   = $_POST['sisa_cicilan'] ?? '';

    // Pastikan semua field terisi
    if (!empty($kode_cicilan) && !empty($kode_kredit) && !empty($tanggal) && !empty($cicilan_ke) && !empty($jumlah_cicilan) && !empty($sisa_ke) && !empty($sisa_cicilan)) {
        
        // Cek apakah kode kredit ada di tabel kredit
        $cek = $conn->prepare("SELECT COUNT(*) AS jml FROM kredit WHERE kode_kredit = ?");
        $cek->bind_param("s", $kode_kredit);
        $cek->execute();
        $result = $cek->get_result()->fetch_assoc();
        
        if ($result['jml'] == 0) {
            $response['message'] = "Kode kredit tidak ditemukan!";
            echo json_encode($response);
            exit;
        }
        $cek->close();

        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO bayar_cicilan (kode_cicilan, kode_kredit, tanggal_cicilan, cicilanke, jumlah_cicilan, sisa_cicilan) VALUES (?, ?, ?, ?, ?, ?)");
        
        // Tipe data: s=string, i=integer, d=double/decimal
        $stmt->bind_param("sssidd", $kode_cicilan, $kode_kredit, $tanggal, $cicilan_ke, $jumlah_cicilan, $sisa_cicilan);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Data Berhasil disimpan";
        } else {
            $response['message'] = "Gagal menyimpan: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = "Semua data wajib diisi!";
    }
} else {
    $response['message'] = "Metode request tidak valid";
}

echo json_encode($response);
mysqli_close($conn);
?>