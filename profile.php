<?php
require 'db_connection.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Ambil data email dari sesi
$email = $_SESSION['email'];

// Ambil informasi pengguna dari database
$sql = "SELECT username, email FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $username = $user['username'];
    $email = $user['email'];
} else {
    echo "Error: Pengguna tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-left">
            <img src="images/logoakun.png" alt="Profile Picture" class="profile-image">
        </div>
        <div class="profile-right">
            <h1 class="profile-title">Profil Saya</h1>
            <div class="profile-details">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
