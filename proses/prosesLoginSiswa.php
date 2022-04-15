<?php
session_start();
include "../koneksi.php";

$nisn = $_POST['nisn'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM akunsiswa WHERE nisn = $nisn");
$data = mysqli_fetch_assoc($query);
if (mysqli_num_rows($query) > 0) {
    if (mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn = $nisn")) > 0) {
        if ($password == $data['password']) {
            $_SESSION['nisn'] = $nisn;
            echo 1;
        } else {
            echo 4;
        }
    } else {
        echo 0;
    }
} else {
    echo 0;
}
