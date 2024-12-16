<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID data yang akan diperbarui
$id = $_GET['id'];

// Ambil data berdasarkan ID
$sql = "SELECT * FROM ktp WHERE id = ? AND email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id, $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan atau Anda tidak memiliki akses.");
}

// Proses pembaruan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Update data di database
    $sql = "UPDATE ktp SET nik = ?, nama = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?, alamat = ?, rt_rw = ?, kelurahan = ?, kecamatan = ?, agama = ?, status_perkawinan = ?, pekerjaan = ? WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssis", $nik, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $alamat, $rt_rw, $kelurahan, $kecamatan, $agama, $status_perkawinan, $pekerjaan, $id, $_SESSION['email']);

    if ($stmt->execute()) {
      // Redirect ke read.php dengan ID data yang diubah
      header("Location: readktp.php?updated_id=$id");
      exit();
  } else {
      echo "Error: " . $stmt->error;
  }
  
}
$updated_id = isset($_GET['updated_id']) ? $_GET['updated_id'] : null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Data KTP</title>
    <link rel="stylesheet" href="css/styleupdate.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Edit Data KTP</h1>
        <form class="ktp-form" action="" method="POST">
            <div class="form-group">
                <label for="nik">NIK:</label>
                <input type="text" id="nik" name="nik" value="<?php echo htmlspecialchars($data['nik']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tempat-lahir">Tempat Lahir:</label>
                <input type="text" id="tempat-lahir" name="tempat-lahir" value="<?php echo htmlspecialchars($data['tempat_lahir']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal-lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal-lahir" name="tanggal-lahir" value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>" required>
            </div>
            <div class="form-group">
                <label for="jenis-kelamin">Jenis Kelamin:</label>
                <select id="jenis-kelamin" name="jenis-kelamin" required>
                    <option value="laki-laki" <?php echo $data['jenis_kelamin'] === 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="perempuan" <?php echo $data['jenis_kelamin'] === 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="rt-rw">RT/RW:</label>
                <input type="text" id="rt-rw" name="rt-rw" value="<?php echo htmlspecialchars($data['rt_rw']); ?>" required>
            </div>
            <div class="form-group">
                <label for="kelurahan">Kelurahan/Desa:</label>
                <input type="text" id="kelurahan" name="kelurahan" value="<?php echo htmlspecialchars($data['kelurahan']); ?>" required>
            </div>
            <div class="form-group">
                <label for="kecamatan">Kecamatan:</label>
                <input type="text" id="kecamatan" name="kecamatan" value="<?php echo htmlspecialchars($data['kecamatan']); ?>" required>
            </div>
            <div class="form-group">
                <label for="agama">Agama:</label>
                <input type="text" id="agama" name="agama" value="<?php echo htmlspecialchars($data['agama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="status">Status Perkawinan:</label>
                <select id="status" name="status" required>
                    <option value="belum" <?php echo $data['status_perkawinan'] === 'belum' ? 'selected' : ''; ?>>Belum Kawin</option>
                    <option value="sudah" <?php echo $data['status_perkawinan'] === 'sudah' ? 'selected' : ''; ?>>Sudah Kawin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="pekerjaan">Pekerjaan:</label>
                <input type="text" id="pekerjaan" name="pekerjaan" value="<?php echo htmlspecialchars($data['pekerjaan']); ?>" required>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn add">✔ Simpan</button>
                <a href="read.php" class="btn cancel">✖ Batal</a>
            </div>
        </form>
    </div>
</body>

</html>
