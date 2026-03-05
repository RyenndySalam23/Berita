<?php
// config/koneksi.php
$host = "localhost";
$username = "root";
$password = "";
$database = "db_berita1"; // Ganti dengan nama database yang benar

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");

// Fungsi helper untuk query
function query($sql) {
    global $conn;
    return mysqli_query($conn, $sql);
}

function escape($str) {
    global $conn;
    return mysqli_real_escape_string($conn, $str);
}

function fetch_assoc($result) {
    return mysqli_fetch_assoc($result);
}

function num_rows($result) {
    return mysqli_num_rows($result);
}
?>