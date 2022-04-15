<?php
include 'session/session_staf.php';
$username = $_SESSION['username'];
include "koneksi.php";
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'"));
$jumlah_siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa"));
$jumlah_admin = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE posisi = 'admin'"));
$jumlah_petugas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE posisi = 'petugas'"));
$jumlah_jurusan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM jurusan"));
$admin = mysqli_query($koneksi, "SELECT * FROM users WHERE posisi = 'admin'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <title>Beranda</title>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/script.js"></script>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <link rel="stylesheet" href="assets/css/beranda.css">
    <style>
        body {
            font-family: cursive;
        }
    </style>
</head>

<body>
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

        <!-- CARD PROFIL  -->
        <div class="row">
        </div>

        <!-- card header -->
        <div class="row mt-2">
            <div class="col">
                <div class="card shadow">
                    <div class="row justify-content-center">
                        <div class="col-3 d-flex">
                            <img src="assets/img/stekman.jpeg" alt="stekman" width="150" style="margin: auto;">
                        </div>
                        <div class="col-6">
                            <div class="card-body text-center">
                                <h3 class=" font-weight-bold text-uppercase">PENGELOLAAN DATA PEMBAYARAN SPP</h3>
                                <H4 class="font-weight-bold text-uppercase-bold text-uppercase">SMK TEKNOLOGI MANDIRI</H4>
                            </div>
                        </div>
                        <div class="col-3 d-flex">
                            <img src="assets/img/RPL.jpg" alt="RPL" width="127" style="margin: auto;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- data Admin -->
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-10" id="admin" style="display: none; position:absolute; z-index:3; top:15%;">
                <div class="card shadow mt-2">
                    <div class="tutup_admin tutup" style="position: absolute; top:0; right:0; width:30px; line-height:30px; text-align:center; height:30px; cursor:pointer;">X</div>
                    <div class="card-header">
                        <h4 class="font-weight-bold text-uppercase text-center">data admin</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <?php while ($data = mysqli_fetch_assoc($admin)) : ?>
                                <div class="col-sm-6 col-lg-3 mt-3">
                                    <div class="card cek">
                                        <img src="assets/img/pp/<?= $data['img']; ?>">
                                        <div class="card-body">
                                            <h5 class="text-center"><?= $data['username']; ?></h5>
                                            <hr>
                                            <a style="display: none;" href="detailAdmin.php?id=<?= $data['id']; ?>" class="btn detail btn-sm btn-block btn-primary mt-3">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- data Petugas -->
        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-10" id="petugas" style="display: none; position:absolute; z-index:3; top:15%;">
                <div class="card shadow mt-2">
                    <div class="tutup_petugas tutup" style="position: absolute; top:0; right:0; width:30px; line-height:30px; text-align:center; height:30px; cursor:pointer;">X</div>
                    <?php $petugas = mysqli_query($koneksi, "SELECT * FROM users WHERE posisi = 'petugas'"); ?>
                    <div class="card-header">
                        <h4 class="font-weight-bold text-uppercase text-center">data Petugas</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <?php while ($data = mysqli_fetch_assoc($petugas)) : ?>
                                <div class="col-sm-6 col-lg-3 mt-3">
                                    <div class="card cek">
                                        <img src="assets/img/pp/<?= $data['img']; ?>">
                                        <div class="card-body">
                                            <h5 class="text-center"><?= $data['username']; ?></h5>
                                            <hr>
                                            <a style="display: none;" href="detailAdmin.php?id=<?= $data['id']; ?>" class="btn detail btn-sm btn-block btn-primary mt-3">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="position:absolute; top:0; bottom:0; opacity:.7; left:0; right:0; z-index:1; display:none" class="bg-secondary" id="bg"></div>

        <!-- Card -->
        <div class="row">
            <div class="col-lg-3 col-sm-6" id="coba" style="cursor: pointer;">
                <div class="card shadow mt-3 border-left-primary card-info">
                    <div class="card-body">
                        <div class="py-2">
                            <div class="row">
                                <div class="col">
                                    <h5 class="text-primary font-weight-bold text-uppercase">Data Admin</h5>
                                    <span class="text-lg font-weight-bold text-primary"><?= $jumlah_admin; ?> Orang</span>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6" id="cuk" style="cursor: pointer;">
                <div class="card shadow mt-3 border-left-primary card-info">
                    <div class="card-body">
                        <div class="py-2">
                            <div class="row">
                                <div class="col">
                                    <h5 class="text-primary font-weight-bold text-uppercase">Data Petugas</h5>
                                    <span class="text-lg font-weight-bold text-primary"><?= $jumlah_petugas; ?> Orang</span>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card shadow mt-3 border-left-primary">
                    <div class="card-body">
                        <div class="py-2">
                            <div class="row">
                                <div class="col">
                                    <h5 class="text-primary font-weight-bold text-uppercase">Total Siswa</h5>
                                    <span class="text-lg font-weight-bold text-primary"><?= $jumlah_siswa; ?> Orang</span>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card shadow mt-3 border-left-primary">
                    <div class="card-body">
                        <div class="py-2">
                            <div class="row">
                                <div class="col">
                                    <h5 class="text-primary font-weight-bold text-uppercase">Jumlah Jurusan</h5>
                                    <span class="text-lg font-weight-bold text-primary"><?= $jumlah_jurusan; ?> Jurusan</span>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end Card  -->

        <!-- card data siswa -->
        <div class="row mt-3">
            <div class="col">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="font-weight-bold text-uppercase text-center">DATA SISWA SMK TEKNOLOGI MANDIRI</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="card mt-3 shadow border-left-warning">
                    <div class="card-body">
                        <div class="py-2">
                            <h4 class="text-warning font-weight-bold text-uppercase">Kelas X</h4>
                            <?php
                            $kelasX = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas WHERE kelas.kelas = 'X' "));
                            ?>
                            <span class="text-warning font-weight-bold text-lg"><?= $kelasX; ?> Orang</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="card mt-3 shadow border-left-info">
                    <div class="card-body">
                        <div class="py-2">
                            <h4 class="text-info font-weight-bold text-uppercase">Kelas XI</h4>
                            <?php
                            $kelasXI = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas WHERE kelas.kelas = 'XI' "));
                            ?>
                            <span class="text-info font-weight-bold text-lg"><?= $kelasXI; ?> Orang</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="card mt-3 shadow border-left-success">
                    <div class="card-body">
                        <div class="py-2">
                            <h4 class="text-success font-weight-bold text-uppercase">Kelas XII</h4>
                            <?php
                            $kelasXII = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas WHERE kelas.kelas = 'XII' "));
                            ?>
                            <span class="text-success font-weight-bold text-lg"><?= $kelasXII; ?> Orang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>