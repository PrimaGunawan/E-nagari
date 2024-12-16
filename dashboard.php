<?php
session_start();
if (isset($_SESSION['username'])) {
    echo "Selamat datang, " . $_SESSION['username'] . "!";
} else {
    echo "Anda harus login terlebih dahulu.";
}
?>
