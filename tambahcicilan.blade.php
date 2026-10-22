<?php
include 'koneksi.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_cicilan =$_POST('kode_cicilan') ??'';
    $kode_kredit =$_POST('kode_kredit') ??'';
    $tanggal =$_POST('tanggal_cicilan') ??'';
    $cicilanke =$_POST('cicilanke') ??'';
    $jumlah_cicilan =$_POST('jumlah_cicilan') ??'';
    $sisacicilke =$_POST('sisacicilke') ??'';
    $sisa_cicilan =$_POST('sisa_cicilan') ??'';

    if($kode_cicilan && $kode_cicilan && $tanggal && $cicilanke && $jumlah_cicilan && $sisacicilke && $sisa_cicilan )

        $cek =$conn->prepare("SELECT COUNT(*) AS jml from kredit where kode_kredit?");
        $cek->bind_param("s",$kode_kredit);
        $ceK->execute();
        $result =$cek->get_result()->fatch_assoc();
        if ($result['jml'] == 0) {
            $response['massage'] ="kode kredit tidak ditemukan!";
            echo json_encode($response);
            exit;
        }
    $cek->close();

    $stmt =$conn->prepare("INSERT INTO bayar_cicilan
    (kode_cicilan,kode_kredit,tanggal_cicilan,cicilanke,jumlah_cicilan,sisacicilke,sisa_cicilan
    VALUES (?,?,?,?,?,?,?)");
    $stmt->blind_param("sssiiii",
     $kode_cicilan,
     $kode_kredit,
     $tanggal,
      $cicilanke ,
      $jumlah_cicilan,
       $sisacicilke,
        $sisa_cicilan
     );

     if($stmt->execute()){
        $response['success'] =true;
         $response['message'] ="Data Berhasil disimpan";
     } else {
        $response['message']= "semua data wajib diisi";
     }
     }else {
        $response['message']= "Metode request tidak valid";
     }
echo json_encode($response);
?>