<?php
include "../koneksi.php";

$nama = htmlspecialchars($_POST['nama']);
$nisn = htmlspecialchars($_POST['nisn']);
$kelas = htmlspecialchars($_POST['kelas']);
$jurusan = htmlspecialchars($_POST['jurusan']);

$query = mysqli_query($koneksi, "SELECT nisn FROM siswa WHERE nisn = '$nisn'");
// var_dump(mysqli_num_rows($query));
// die;
if (mysqli_num_rows($query) > 0) {
    echo 22;
    // die;
} else {
    mysqli_query($koneksi, "INSERT INTO siswa VALUES ('', '$nama', '$nisn', '$kelas', '$jurusan')");
    if (mysqli_affected_rows($koneksi) > 0) {
        echo 1;
    } else {
        echo 4;
    }
}
