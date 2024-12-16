<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Ambil email pengguna untuk menampilkan data akta kelahiran yang relevan
$email = $_SESSION['email'];

// Ambil data dari tabel akta_kelahiran berdasarkan email pengguna
$sql = "SELECT * FROM akta_kelahiran WHERE email = ?";
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
    <title>Data Akta Kelahiran</title>
    <link rel="stylesheet" href="css/styleread.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Data Akta Kelahiran</h1>

        <?php if ($result->num_rows > 0) : ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama Bayi</th>
                        <th>Jenis Kelamin</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Nama Ibu</th>
                        <th>NIK Ibu</th>
                        <th>Nama Ayah</th>
                        <th>NIK Ayah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_bayi']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                            <td><?php echo htmlspecialchars($row['tempat_lahir']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_ibu']); ?></td>
                            <td><?php echo htmlspecialchars($row['nik_ibu']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_ayah']); ?></td>
                            <td><?php echo htmlspecialchars($row['nik_ayah']); ?></td>
                            <td>
                                <a href="updateakta.php?id=<?php echo $row['id']; ?>" class="btn update">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="no-data-message">Tidak ada data Akta Kelahiran yang tersedia. <a href="pembuatanaktalahir.html" class="btn add">Buat Akta Baru</a></p>
        <?php endif; ?>
    </div>
</body>

</html>
