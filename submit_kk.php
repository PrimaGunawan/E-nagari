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
    $nama_kepala = $_POST['nama-kepala'];
    $nik_kepala = $_POST['nik-kepala'];
    $tempat_lahir = $_POST['tempat-lahir-kepala'];
    $tanggal_lahir = $_POST['tanggal-lahir-kepala'];
    $jenis_kelamin = $_POST['jenis-kelamin-kepala'];
    $agama = $_POST['agama-kepala'];
    $pekerjaan = $_POST['pekerjaan-kepala'];
    $alamat = $_POST['alamat-kepala'];
    $kecamatan = $_POST['kecamatan'];
    $provinsi = $_POST['provinsi'];
    $kabupaten = $_POST['kabupaten'];

    // Simpan data ke tabel pembuatankk
    $sql = "INSERT INTO kk (email, nama_kepala, nik_kepala, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, pekerjaan, alamat, kecamatan, provinsi, kabupaten)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", $email, $nama_kepala, $nik_kepala, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $pekerjaan, $alamat, $kecamatan, $provinsi, $kabupaten);

    if ($stmt->execute()) {
        header("Location: readkk.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
