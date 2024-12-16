<?php
require 'db_connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID dari parameter URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    die("ID data tidak ditemukan.");
}

// Ambil data KK berdasarkan ID
$sql = "SELECT * FROM kk WHERE id = ? AND email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $id, $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan atau Anda tidak memiliki akses.");
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kepala = trim($_POST['nama-kepala']);
    $nik_kepala = trim($_POST['nik-kepala']);
    $tempat_lahir = trim($_POST['tempat-lahir-kepala']);
    $tanggal_lahir = trim($_POST['tanggal-lahir-kepala']);
    $jenis_kelamin = trim($_POST['jenis-kelamin-kepala']);
    $agama = trim($_POST['agama-kepala']);
    $pekerjaan = trim($_POST['pekerjaan-kepala']);
    $alamat = trim($_POST['alamat-kepala']);
    $kecamatan = trim($_POST['kecamatan']);
    $provinsi = trim($_POST['provinsi']);
    $kabupaten = trim($_POST['kabupaten']);

    // Validasi data
    if (!is_numeric($nik_kepala) || strlen($nik_kepala) != 16) {
        die("NIK Kepala Keluarga harus berupa 16 digit angka.");
    }
    if (empty($nama_kepala) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($alamat) || empty($kecamatan) || empty($provinsi) || empty($kabupaten)) {
        die("Semua field wajib diisi.");
    }

    // Update data di database
    $sql = "UPDATE kk SET nama_kepala = ?, nik_kepala = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?, agama = ?, pekerjaan = ?, alamat = ?, kecamatan = ?, provinsi = ?, kabupaten = ? WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssis", $nama_kepala, $nik_kepala, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $agama, $pekerjaan, $alamat, $kecamatan, $provinsi, $kabupaten, $id, $_SESSION['email']);

    if ($stmt->execute()) {
        header("Location: readkk.php?success=2");
        exit();
    } else {
        echo "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Kartu Keluarga</title>
    <link rel="stylesheet" href="css/styleupdate.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Edit Data Kartu Keluarga</h1>
        <form action="" method="POST" class="ktp-form">
            <div class="form-group">
                <label for="nama-kepala">Nama Lengkap Kepala Keluarga:</label>
                <input type="text" id="nama-kepala" name="nama-kepala" value="<?php echo htmlspecialchars($data['nama_kepala']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nik-kepala">NIK Kepala Keluarga:</label>
                <input type="text" id="nik-kepala" name="nik-kepala" value="<?php echo htmlspecialchars($data['nik_kepala']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tempat-lahir-kepala">Tempat Lahir:</label>
                <input type="text" id="tempat-lahir-kepala" name="tempat-lahir-kepala" value="<?php echo htmlspecialchars($data['tempat_lahir']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal-lahir-kepala">Tanggal Lahir:</label>
                <input type="date" id="tanggal-lahir-kepala" name="tanggal-lahir-kepala" value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>" required>
            </div>
            <div class="form-group">
                <label for="jenis-kelamin-kepala">Jenis Kelamin:</label>
                <select id="jenis-kelamin-kepala" name="jenis-kelamin-kepala" required>
                    <option value="laki-laki" <?php echo $data['jenis_kelamin'] === 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="perempuan" <?php echo $data['jenis_kelamin'] === 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="agama-kepala">Agama:</label>
                <input type="text" id="agama-kepala" name="agama-kepala" value="<?php echo htmlspecialchars($data['agama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="pekerjaan-kepala">Pekerjaan:</label>
                <input type="text" id="pekerjaan-kepala" name="pekerjaan-kepala" value="<?php echo htmlspecialchars($data['pekerjaan']); ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat-kepala">Alamat:</label>
                <textarea id="alamat-kepala" name="alamat-kepala" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="kecamatan">Kecamatan:</label>
                <input type="text" id="kecamatan" name="kecamatan" value="<?php echo htmlspecialchars($data['kecamatan']); ?>" required>
            </div>
            <div class="form-group">
                <label for="provinsi">Provinsi:</label>
                <input type="text" id="provinsi" name="provinsi" value="<?php echo htmlspecialchars($data['provinsi']); ?>" required>
            </div>
            <div class="form-group">
                <label for="kabupaten">Kabupaten/Kota:</label>
                <input type="text" id="kabupaten" name="kabupaten" value="<?php echo htmlspecialchars($data['kabupaten']); ?>" required>
            </div>
            <div class="form-buttons">
                <button type="submit" class="btn add">✔ Simpan</button>
                <a href="readkk.php" class="btn cancel">✖ Batal</a>
            </div>
        </form>
    </div>
</body>

</html>
