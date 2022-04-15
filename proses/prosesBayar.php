<?php
session_start();
include "../koneksi.php";

// AMBIL USERNAME USER 
$users = $_SESSION['username'];

$petugas = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$users'"));

$nama = $_POST['nama'];
$bulan = $_POST['pembayaran'];
$nominal = $_POST['nominal'];
$tanggal = $_POST['tanggal'];
$petugas = $petugas['username'];


$dataBulan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM bulan WHERE id_bulan = '$bulan'"));
if ($dataBulan['bulan'] == "PAS" || $dataBulan['bulan'] == "PTS" || $dataBulan['bulan'] == "MODUL") {
    if ($nominal < 75000) {
        $ket = "BELUM LUNAS";
    } else if ($nominal > 75000) {
        $ket = "PEMBAYARAN LEBIH";
    } else {
        $ket = "LUNAS";
    }
} else {
    if ($nominal < 150000) {
        $ket = "BELUM LUNAS";
    } else if ($nominal > 150000) {
        $ket = "PEMBAYARAN LEBIH";
    } else {
        $ket = "LUNAS";
    }
}

// 99 = BELUM LUNAS
// 22 = DATA ADA
// 4 = GAGAL

$pembayaran_query = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_bulan = $bulan && id_siswa = $nama");
if (mysqli_num_rows($pembayaran_query) > 0) {
    $pembayaran = mysqli_fetch_assoc($pembayaran_query);
    // var_dump($pembayaran);
    // die;
    if ($pembayaran['keterangan'] == "BELUM LUNAS") {
        $pasptsmodul = mysqli_query($koneksi, "SELECT * FROM pembayaran JOIN bulan ON bulan.id_bulan=pembayaran.id_bulan WHERE pembayaran.id_bulan = $bulan && pembayaran.id_siswa = $nama");
        $cekBulan = mysqli_fetch_assoc($pasptsmodul);
        if ($cekBulan['bulan'] == "PAS" || $cekBulan['bulan'] == "PTS" || $cekBulan['bulan'] == "MODUL") {
            mysqli_query($koneksi, "INSERT INTO pembayaran VALUES ('', '$nama', '$bulan', '$nominal', '$petugas', '$ket', '$tanggal')");

            if (mysqli_affected_rows($koneksi) > 0) {
                // $siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa = $nama"));
                echo $nama;
            } else {
                echo 'gagal';
            }
        } else {
            echo 'sudahbayar';
        }
        // echo 'sudahbayar';
        // echo $cekBulan['bulan'];
    } else {
        echo 'sudahLunas';
    }
} else {
    mysqli_query($koneksi, "INSERT INTO pembayaran VALUES ('', '$nama', '$bulan', '$nominal', '$petugas', '$ket', '$tanggal')");

    if (mysqli_affected_rows($koneksi) > 0) {
        // $siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa = $nama"));
        echo $nama;
    } else {
        echo 'gagal';
    }
}
