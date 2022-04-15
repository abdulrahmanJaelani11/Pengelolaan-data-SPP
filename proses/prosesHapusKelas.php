<?php
include "../koneksi.php";
$id = $_GET['id'];
// var_dump($id);
// die;
if (mysqli_num_rows(mysqli_query($koneksi, "SELECT id_kelas FROM siswa WHERE id_kelas = $id")) > 0) {
    echo "hapus" . 22;
} else {
    mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas = $id");
    if (mysqli_affected_rows($koneksi) > 0) {
        echo "hapus" . 1;
    } else {
        echo "hapus" . 0;
    }
}
