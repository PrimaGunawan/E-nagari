<?php
   $servername = "localhost";
   $username = "root";
   $password = ""; // Kosongkan jika tidak ada password di XAMPP
   $dbname = "enagari_db";

   // Membuat koneksi ke database
   $conn = new mysqli($servername, $username, $password, $dbname);

   // Memeriksa koneksi
   if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
   }
   ?>