<?php
include "../koneksi.php";
$nisn = $_POST['nisn'];
$password = $_POST['password'];
$konfirmasi = $_POST['konfirmasi'];

if ($password == $konfirmasi) {
    if (mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM akunsiswa WHERE nisn = $nisn")) > 0) {
        echo "NISN_Sudah_Terdaftar";
    } else {
        if (mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn = $nisn")) > 0) {
            mysqli_query($koneksi, "INSERT INTO akunsiswa (id, nisn, password, img) VALUES ('', '$nisn', '$password', 'default.png')");
            if (mysqli_affected_rows($koneksi) > 0) {
                echo "Berhasil_Membuat_Akun";
            } else {
                echo "Gagal_Membuat_Akun";
            }
        } else {
            echo "NISN_yang_anda_masukan_salah";
        }
    }
} else {
    echo "Konfirmasi_Password_tidak_sesuai";
}
