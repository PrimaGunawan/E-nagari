<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Ambil email pengguna untuk menampilkan data Kartu Keluarga yang relevan
$email = $_SESSION['email'];

// Ambil data dari tabel KK berdasarkan email pengguna
$sql = "SELECT * FROM kk WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kartu Keluarga</title>
    <link rel="stylesheet" href="css/styleread.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Data Kartu Keluarga</h1>

        <!-- Tampilkan pesan sukses jika ada -->
        <?php if (isset($_GET['success'])) : ?>
            <p class="success-message">Data Kartu Keluarga berhasil disimpan!</p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0) : ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Kepala Keluarga</th>
                        <th>NIK</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Agama</th>
                        <th>Pekerjaan</th>
                        <th>Alamat</th>
                        <th>Kecamatan</th>
                        <th>Provinsi</th>
                        <th>Kabupaten</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_kepala']); ?></td>
                            <td><?php echo htmlspecialchars($row['nik_kepala']); ?></td>
                            <td><?php echo htmlspecialchars($row['tempat_lahir']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                            <td><?php echo htmlspecialchars($row['agama']); ?></td>
                            <td><?php echo htmlspecialchars($row['pekerjaan']); ?></td>
                            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($row['kecamatan']); ?></td>
                            <td><?php echo htmlspecialchars($row['provinsi']); ?></td>
                            <td><?php echo htmlspecialchars($row['kabupaten']); ?></td>
                            <td>
                                <!-- Link untuk edit data -->
                                <a href="updatekk.php?id=<?php echo $row['id']; ?>" class="btn update">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="no-data-message">Tidak ada data Kartu Keluarga yang tersedia. <a href="pembuatankk.html" class="btn add">Buat Kartu Keluarga Baru</a></p>
        <?php endif; ?>
    </div>
</body>

</html>
