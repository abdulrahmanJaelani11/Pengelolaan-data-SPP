<?php
include 'session/session_staf.php';
include "koneksi.php";
$id = $_GET['id'];
$siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas WHERE id_siswa = $id"));
$pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran JOIN siswa ON siswa.id_siswa=pembayaran.id_siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan JOIN bulan ON bulan.id_bulan = pembayaran.id_bulan WHERE siswa.id_siswa = $id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RIWAYAT PEMBAYARAN</title>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
</head>

<body style="font-family: cursive;">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="beranda.php">STEKMAN-PAY</a>
            <button class="navbar-toggler" type="button" id="btn" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="beranda.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dataSiswa.php">Data Siswa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dataKelas.php">Data Kelas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dataJurusan.php">Data Jurusan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="bayar.php">Bayar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="return confirm('Yakin Untuk Logout?')" href="logout.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="margin-top: 60px;">
        <div class="row mt-4">
            <div class="col text-center">
                <div class="card shadow">
                    <div class="card-body">
                        <h2>RIWAYAT PEMBAYARAN ADMINISTRASI SISWA</h2>
                        <h3> SMK TEKNOLOGI MANDIRI</h3>
                        <h4>Nama : <?= $siswa['nama'] . ' ' . $siswa['NoKelas']; ?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <a href="detailSiswa.php?id=<?= $siswa['id_siswa']; ?>" class="btn btn-info btn-sm">Detail Siswa</a>
                        <a href="bayar.php?id=<?= $id; ?>" class="btn btn-primary btn-sm">Bayar</a>
                        <a href="cetak.php?id=<?= $id; ?>" class="btn btn-success btn-sm">Print</a>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center mt-2">
                                <thead>
                                    <tr>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Jurusan</th>
                                        <th>Pembayaran</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                        <th>Petugas</th>
                                        <th>Tanggal transaksi</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = mysqli_fetch_assoc($pembayaran)) : ?>
                                        <tr>
                                            <td><?= $data['nama']; ?></td>
                                            <td><?= $data['NoKelas']; ?></td>
                                            <td><?= $data['jurusan']; ?></td>
                                            <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['bulan']; ?></td>
                                            <td><?= $data['nominal']; ?></td>
                                            <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['keterangan']; ?></td>
                                            <td><?= $data['petugas']; ?></td>
                                            <td><?= $data['tgl_pembayaran']; ?></td>
                                            <td>
                                                <?php if ($data['keterangan'] == "BELUM LUNAS") : ?>
                                                    <a href="" class="btn btn-warning btn-sm btn-block">Lunasi!!</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>