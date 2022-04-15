<?php
session_start();
include "../koneksi.php";
$username = $_SESSION['username'];
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'"));
// var_dump($user);
// die;

$sebelumnya = $_POST['sebelum'];
$nominalPelunasan = $_POST['nominalPelunasan'];
$id = $_POST['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pembayaran JOIN bulan ON bulan.id_bulan=pembayaran.id_bulan WHERE id_pembayaran = $id"));
$id_siswa = $data['id_siswa'];
$id_bulan = $data['id_bulan'];
$nominal = $data['nominal'] + $nominalPelunasan;
$petugas = $user['username'];
$tanggal = $_POST['tanggal'];
// $tanggal = $data['tgl_pembayaran'];
// var_dump($id_siswa);
// die;
if ($data['bulan'] == "PAS" || $data['bulan'] == "PTS" || $data['bulan'] == "MODUL") {
    $sisa = 75000 - $sebelumnya;
    if ($nominalPelunasan == $sisa) {
        $ket = "LUNAS";
    } elseif ($nominalPelunasan > $sisa) {
        $ket = "LEBIH";
    } else {
        $ket = "BELUM LUNAS";
    }
} else {
    $sisa = 150000 - $sebelumnya;
    if ($nominalPelunasan == $sisa) {
        $ket = "LUNAS";
    } elseif ($nominalPelunasan > $sisa) {
        $ket = "LEBIH";
    } else {
        $ket = "BELUM LUNAS";
    }
}
// var_dump($ket);
// die;

mysqli_query($koneksi, "UPDATE pembayaran SET id_siswa = $id_siswa, id_bulan = $id_bulan, nominal = '$nominal', petugas = '$petugas', keterangan = '$ket', tgl_pembayaran = '$tanggal' WHERE id_pembayaran = $id");
if (mysqli_affected_rows($koneksi)) {
    echo $id_siswa;
} else {
    echo 'gagal';
}
