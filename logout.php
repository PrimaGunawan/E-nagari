<?php
// logout.php
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login atau halaman utama
header("Location: login.html");
exit();
?>