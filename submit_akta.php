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
    $nama_bayi = $_POST['nama-bayi'];
    $jenis_kelamin = $_POST['jenis-kelamin-bayi'];
    $tempat_lahir = $_POST['tempat-lahir-bayi'];
    $tanggal_lahir = $_POST['tanggal-lahir-bayi'];
    $nik_ibu = $_POST['nik-ibu'];
    $nama_ibu = $_POST['nama-ibu'];
    $tempat_lahir_ibu = $_POST['tempat-lahir-ibu'];
    $tanggal_lahir_ibu = $_POST['tanggal-lahir-ibu'];
    $pekerjaan_ibu = $_POST['pekerjaan-ibu'];
    $alamat_ibu = $_POST['alamat-ibu'];
    $nik_ayah = $_POST['nik-ayah'];
    $nama_ayah = $_POST['nama-ayah'];
    $tempat_lahir_ayah = $_POST['tempat-lahir-ayah'];
    $tanggal_lahir_ayah = $_POST['tanggal-lahir-ayah'];
    $pekerjaan_ayah = $_POST['pekerjaan-ayah'];
    $alamat_ayah = $_POST['alamat-ayah'];

    // Simpan data ke tabel akta_kelahiran
    $sql = "INSERT INTO akta_kelahiran (email, nama_bayi, jenis_kelamin, tempat_lahir, tanggal_lahir, nik_ibu, nama_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, pekerjaan_ibu, alamat_ibu, nik_ayah, nama_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, pekerjaan_ayah, alamat_ayah)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssss", $email, $nama_bayi, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $nik_ibu, $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu, $pekerjaan_ibu, $alamat_ibu, $nik_ayah, $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah, $pekerjaan_ayah, $alamat_ayah);

    if ($stmt->execute()) {
        header("Location: readakta.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
