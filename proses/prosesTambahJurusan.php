<?php
include "../koneksi.php";
$jurusan = $_POST['jurusan'];
$query = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE jurusan = '$jurusan'");
if (mysqli_num_rows($query) > 0) {
    echo "<script>alert('Jurusan sudah ada');</script>";
} else {
    mysqli_query($koneksi, "INSERT INTO jurusan VALUES ('', '$jurusan')");
    if (mysqli_affected_rows($koneksi) > 0) {
        echo 1;
    } else {
        echo 4;
    }
}
