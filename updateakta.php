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

// Ambil data akta berdasarkan ID
$sql = "SELECT * FROM akta_kelahiran WHERE id = ? AND email = ?";
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
    $nama_bayi = trim($_POST['nama-bayi']);
    $jenis_kelamin = trim($_POST['jenis-kelamin-bayi']);
    $tempat_lahir = trim($_POST['tempat-lahir-bayi']);
    $tanggal_lahir = trim($_POST['tanggal-lahir-bayi']);
    $nik_ibu = trim($_POST['nik-ibu']);
    $nama_ibu = trim($_POST['nama-ibu']);
    $tempat_lahir_ibu = trim($_POST['tempat-lahir-ibu']);
    $tanggal_lahir_ibu = trim($_POST['tanggal-lahir-ibu']);
    $pekerjaan_ibu = trim($_POST['pekerjaan-ibu']);
    $alamat_ibu = trim($_POST['alamat-ibu']);
    $nik_ayah = trim($_POST['nik-ayah']);
    $nama_ayah = trim($_POST['nama-ayah']);
    $tempat_lahir_ayah = trim($_POST['tempat-lahir-ayah']);
    $tanggal_lahir_ayah = trim($_POST['tanggal-lahir-ayah']);
    $pekerjaan_ayah = trim($_POST['pekerjaan-ayah']);
    $alamat_ayah = trim($_POST['alamat-ayah']);

    // Validasi data
    if (!is_numeric($nik_ibu) || strlen($nik_ibu) != 16 || !is_numeric($nik_ayah) || strlen($nik_ayah) != 16) {
        die("NIK Ibu dan Ayah harus berupa 16 digit angka.");
    }
    if (empty($nama_bayi) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($nama_ibu) || empty($nama_ayah)) {
        die("Semua field wajib diisi.");
    }

    // Update data di database
    $sql = "UPDATE akta_kelahiran SET 
                nama_bayi = ?, jenis_kelamin = ?, tempat_lahir = ?, tanggal_lahir = ?, 
                nik_ibu = ?, nama_ibu = ?, tempat_lahir_ibu = ?, tanggal_lahir_ibu = ?, pekerjaan_ibu = ?, alamat_ibu = ?, 
                nik_ayah = ?, nama_ayah = ?, tempat_lahir_ayah = ?, tanggal_lahir_ayah = ?, pekerjaan_ayah = ?, alamat_ayah = ?
            WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssssiss", 
        $nama_bayi, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, 
        $nik_ibu, $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu, $pekerjaan_ibu, $alamat_ibu, 
        $nik_ayah, $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah, $pekerjaan_ayah, $alamat_ayah, $id, $_SESSION['email']
    );

    if ($stmt->execute()) {
        header("Location: readakta.php?success=2");
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
    <title>Update Akta Kelahiran</title>
    <link rel="stylesheet" href="css/styleupdate.css">
</head>

<body>
    <div class="container">
        <h1 class="title">Edit Akta Kelahiran</h1>
        <form action="" method="POST" class="akta-form">
            <h2 class="section-title">Data Bayi</h2>
            <div class="form-group">
                <label for="nama-bayi">Nama Bayi:</label>
                <input type="text" id="nama-bayi" name="nama-bayi" value="<?php echo htmlspecialchars($data['nama_bayi']); ?>" required>
            </div>
            <div class="form-group">
                <label for="jenis-kelamin-bayi">Jenis Kelamin:</label>
                <select id="jenis-kelamin-bayi" name="jenis-kelamin-bayi" required>
                    <option value="laki-laki" <?php echo $data['jenis_kelamin'] === 'laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="perempuan" <?php echo $data['jenis_kelamin'] === 'perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="tempat-lahir-bayi">Tempat Lahir:</label>
                <input type="text" id="tempat-lahir-bayi" name="tempat-lahir-bayi" value="<?php echo htmlspecialchars($data['tempat_lahir']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal-lahir-bayi">Tanggal Lahir:</label>
                <input type="date" id="tanggal-lahir-bayi" name="tanggal-lahir-bayi" value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>" required>
            </div>

            <h2 class="section-title">Data Ibu</h2>
            <div class="form-group">
                <label for="nik-ibu">NIK Ibu:</label>
                <input type="text" id="nik-ibu" name="nik-ibu" value="<?php echo htmlspecialchars($data['nik_ibu']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nama-ibu">Nama Ibu:</label>
                <input type="text" id="nama-ibu" name="nama-ibu" value="<?php echo htmlspecialchars($data['nama_ibu']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tempat-lahir-ibu">Tempat Lahir Ibu:</label>
                <input type="text" id="tempat-lahir-ibu" name="tempat-lahir-ibu" value="<?php echo htmlspecialchars($data['tempat_lahir_ibu']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal-lahir-ibu">Tanggal Lahir Ibu:</label>
                <input type="date" id="tanggal-lahir-ibu" name="tanggal-lahir-ibu" value="<?php echo htmlspecialchars($data['tanggal_lahir_ibu']); ?>" required>
            </div>
            <div class="form-group">
                <label for="pekerjaan-ibu">Pekerjaan Ibu:</label>
                <input type="text" id="pekerjaan-ibu" name="pekerjaan-ibu" value="<?php echo htmlspecialchars($data['pekerjaan_ibu']); ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat-ibu">Alamat Ibu:</label>
                <textarea id="alamat-ibu" name="alamat-ibu" required><?php echo htmlspecialchars($data['alamat_ibu']); ?></textarea>
            </div>

            <h2 class="section-title">Data Ayah</h2>
            <div class="form-group">
                <label for="nik-ayah">NIK Ayah:</label>
                <input type="text" id="nik-ayah" name="nik-ayah" value="<?php echo htmlspecialchars($data['nik_ayah']); ?>" required>
            </div>
            <div class="form-group">
                <label for="nama-ayah">Nama Ayah:</label>
                <input type="text" id="nama-ayah" name="nama-ayah" value="<?php echo htmlspecialchars($data['nama_ayah']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tempat-lahir-ayah">Tempat Lahir Ayah:</label>
                <input type="text" id="tempat-lahir-ayah" name="tempat-lahir-ayah" value="<?php echo htmlspecialchars($data['tempat_lahir_ayah']); ?>" required>
            </div>
            <div class="form-group">
                <label for="tanggal-lahir-ayah">Tanggal Lahir Ayah:</label>
                <input type="date" id="tanggal-lahir-ayah" name="tanggal-lahir-ayah" value="<?php echo htmlspecialchars($data['tanggal_lahir_ayah']); ?>" required>
            </div>
            <div class="form-group">
                <label for="pekerjaan-ayah">Pekerjaan Ayah:</label>
                <input type="text" id="pekerjaan-ayah" name="pekerjaan-ayah" value="<?php echo htmlspecialchars($data['pekerjaan_ayah']); ?>" required>
            </div>
            <div class="form-group">
                <label for="alamat-ayah">Alamat Ayah:</label>
                <textarea id="alamat-ayah" name="alamat-ayah" required><?php echo htmlspecialchars($data['alamat_ayah']); ?></textarea>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn add">✔ Simpan</button>
                <a href="readakta.php" class="btn cancel">✖ Batal</a>
            </div>
        </form>
    </div>
</body>

</html>
