<?php
require 'db_connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['email'])) {
        die("Anda harus login terlebih dahulu!");
    }

    // Ambil email dari sesi
    $email = $_SESSION['email'];

    // Ambil data dari form
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat-lahir'];
    $tanggal_lahir = $_POST['tanggal-lahir'];
    $jenis_kelamin = $_POST['jenis-kelamin'];
    $alamat = $_POST['alamat'];
    $rt_rw = $_POST['rt-rw'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $agama = $_POST['agama'];
    $status_perkawinan = $_POST['status'];
    $pekerjaan = $_POST['pekerjaan'];

    // Simpan data ke tabel pembuatanktp
    $sql = "INSERT INTO ktp (email, nik, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, rt_rw, kelurahan, kecamatan, agama, status_perkawinan, pekerjaan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssss", $email, $nik, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $alamat, $rt_rw, $kelurahan, $kecamatan, $agama, $status_perkawinan, $pekerjaan);

    if ($stmt->execute()) {
        header("Location: readktp.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
