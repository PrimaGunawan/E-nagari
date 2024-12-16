<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Ambil email dari sesi untuk filter data pengguna
$email = $_SESSION['email'];

// Ambil semua data KTP pengguna
$sql = "SELECT * FROM ktp WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Cek apakah ada parameter `updated_id` untuk menyoroti data
$updated_id = isset($_GET['updated_id']) ? $_GET['updated_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data KTP</title>
    <link rel="stylesheet" href="css/styleread.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Data KTP Anda</h1>

        <!-- Jika ada data, tampilkan tabel -->
        <?php if ($result->num_rows > 0) : ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>RT/RW</th>
                        <th>Kelurahan</th>
                        <th>Kecamatan</th>
                        <th>Agama</th>
                        <th>Status</th>
                        <th>Pekerjaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr class="<?php echo ($row['id'] == $updated_id) ? 'highlight' : ''; ?>">
                            <td><?php echo htmlspecialchars($row['nik']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['tempat_lahir']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($row['rt_rw']); ?></td>
                            <td><?php echo htmlspecialchars($row['kelurahan']); ?></td>
                            <td><?php echo htmlspecialchars($row['kecamatan']); ?></td>
                            <td><?php echo htmlspecialchars($row['agama']); ?></td>
                            <td><?php echo htmlspecialchars($row['status_perkawinan']); ?></td>
                            <td><?php echo htmlspecialchars($row['pekerjaan']); ?></td>
                            <td>
                                <a href="updatektp.php?id=<?php echo $row['id']; ?>" class="btn update">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>Tidak ada data KTP yang tersedia. <a href="pembuatanktp.html" class="btn add">Buat KTP Baru</a></p>
        <?php endif; ?>
    </div>
</body>

</html>
