<?php
session_start();
include "koneksi.php";
$nisn = $_SESSION['nisn'];
if (!isset($_SESSION['nisn'])) {
    header("location: index.php");
    exit;
}
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan JOIN akunsiswa ON akunsiswa.nisn=siswa.nisn WHERE siswa.nisn = $nisn"));
$admin = mysqli_query($koneksi, "SELECT * FROM users WHERE posisi = 'admin'");
$petugas = mysqli_query($koneksi, "SELECT * FROM users WHERE posisi = 'petugas'");
$jumlah_admin = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE posisi = 'admin'"));
$jumlah_petugas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM users WHERE posisi = 'petugas'"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
    <title>Beranda</title>
</head>

<body style="font-family: cursive;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
                        <a class="nav-link" onclick="return confirm('Yakin Untuk Logout?')" href="logout.php">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card mt-2 shadow text-primary">
                    <div class="card-header">
                        <h4 class="text-center font-weight-bold text-uppercase"><?= date("d M Y"); ?></h4>
                    </div>
                    <div class="card-body text-center">
                        <h4>Selamat datang <b><?= $data['nama']; ?></b></h4>
                    </div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-sm-12 col-lg-7">
                <div class="card shadow mt-2">
                    <div class="card-body">
                        <?php if (isset($error)) : ?>
                            <div class="alert my-2 alert-danger">
                                <?= $error; ?>
                            </div>
                        <?php endif; ?>
                        <div class="card shadow" id="form" style="display: none;">
                            <div class="card-body">
                                <form action="proses/prosesSimpanFotoProfil.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <div class="col-md-10 col-sm-7">
                                            <input type="file" name="img" id="img" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-md-2 col-sm-4">
                                            <button type="submit" name="simpan" class="btn mt-2 btn-sm btn-block btn-success"> simpan </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-5 col-sm-5">
                                <div class="card mt-2 click">
                                    <div class="row justify-content-center opsi" style="display: none;">
                                        <div class="col-4">
                                            <a href="assets/img/pp/<?= $data['img']; ?>" target="blank" class="btn btn-success btn-sm my-2 btn-block">Lihat</a>
                                        </div>
                                        <div class="col-4">
                                            <div type="submit" name="btn" class="btn btn-sm btn-block my-2 btn-primary" style="list-style: none;" id="upload"> Upload </div>
                                        </div>
                                        <div class="col-4">
                                            <a href="hapus_img_siswa.php?id=<?= $data['id']; ?>" onclick="return confirm('Yakin untuk menghapus Foto Profil?')" style="list-style: none;" class="btn btn-sm btn-block btn-danger my-2">Hapus</a>
                                        </div>
                                    </div>
                                    <img data-tilt data-tilt-glare data-tilt-max-glare='0.8' src="assets/img/pp/<?= $data['img']; ?>" class="img-thumbnail img" style="cursor: pointer;">
                                    <div class="card-body text-center">
                                        <h5 class="text-uppercase"><?= $data['nama']; ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-sm-7">
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <label for="nama">Nama *</label>
                                                <input type="text" name="nama" id="nama" class="form-control form-control-sm" value="<?= $data['nama']; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="nisn">NISN *</label>
                                                <input type="text" name="nisn" id="nisn" class="form-control form-control-sm" value="<?= $data['nisn']; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="kelas">Kelas *</label>
                                                <input type="text" name="kelas" id="kelas" class="form-control form-control-sm" value="<?= $data['NoKelas']; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="jurusan">jurusan *</label>
                                                <input type="text" name="jurusan" id="jurusan" class="form-control form-control-sm" value="<?= $data['jurusan']; ?>" readonly>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-sm-12 mt-2">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="row m-2">
                            <?php
                            $belumLunas = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM pembayaran JOIN siswa ON siswa.id_siswa = pembayaran.id_siswa WHERE siswa.nisn = $nisn && keterangan = 'BELUM LUNAS'"));
                            ?>
                            <div class="col-sm-6 col-lg-12">
                                <div id="btn_administrasi" data-tilt class="card mt-2 border-left-success shadow card-info" style="cursor: pointer;">
                                    <div class="card-body text-success">
                                        <div class="py-2">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h5 class="font-weight-bold text-uppercase">Administrasi Saya</h5>
                                                    <h5 class="font-weight-bold">Belum lunas <?= $belumLunas; ?></h5>
                                                </div>
                                                <div class="col-4">
                                                    <div class="btn btn-sm btn-show btn-block btn-success">Lihat</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-12">
                                <div id="coba" data-tilt data-tilt-scale='1.1' class="card mt-2 card-info border-left-primary shadow" style="cursor: pointer;">
                                    <div class="card-body text-primary">
                                        <div class="py-2">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h5 class="font-weight-bold text-uppercase">data admin</h5>
                                                    <h5 class="font-weight-bold"><?= $jumlah_admin; ?> Orang</h5>
                                                </div>
                                                <div class="col-4">
                                                    <div href="#" class="btn btn-sm btn-show btn-block btn-primary">Lihat</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-12">
                                <div class="card mt-2 shadow border-left-info" id="cuk" data-tilt data-tilt-reverse='true'>
                                    <div class="card-body text-info">
                                        <div class="py-2">
                                            <div class="row">
                                                <div class="col-8">
                                                    <h5 class="font-weight-bold text-uppercase">data petugas</h5>
                                                    <h5 class="font-weight-bold"><?= $jumlah_petugas; ?> Orang</h5>
                                                </div>
                                                <div class="col-4">
                                                    <div href="#" class="btn btn-sm btn-show btn-block btn-info">Lihat</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 justify-content-center">
            <?php
            $siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas"));
            $pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran JOIN siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan ON siswa.id_siswa=pembayaran.id_siswa JOIN bulan ON bulan.id_bulan = pembayaran.id_bulan WHERE siswa.nisn = $nisn");
            ?>
            <div class="col-sm-12 col-lg-10" style="display: none; position:absolute; z-index:2; top:15%;" id="administrasi">
                <div class="card shadow tabel">
                    <div class="tutup_administrasi tutup" style="position: absolute; top:0; right:0; width:30px; line-height:30px; text-align:center; height:30px; cursor:pointer;">X</div>
                    <div class="card-body">
                        <h4 class="text-uppercase text-center mt-2">Riwayat Pembayaran Administrasi saya</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center mt-2">
                                <thead>
                                    <tr>
                                        <td>Pembayaran</td>
                                        <td>Nominal</td>
                                        <td>Keterangan</td>
                                        <td>Petugas</td>
                                        <td>Tanggal Pembayaran</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = mysqli_fetch_assoc($pembayaran)) : ?>
                                        <tr>
                                            <td><?= $data['bulan']; ?></td>
                                            <td><?= $data['nominal']; ?></td>
                                            <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'bg-danger text-light' : '' ?>"><?= $data['keterangan']; ?></td>
                                            <td><?= $data['petugas']; ?></td>
                                            <td><?= $data['tgl_pembayaran']; ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div style="position:absolute; top:0; bottom:0; opacity:.7; left:0; right:0; z-index:1; display:none" class="bg-secondary" id="bg"></div>

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
            <div class="col-sm-12 col-lg-10" id="petugas" style="display: none; position:absolute; z-index:3; top:15%;">
                <div class="card shadow mt-2">
                    <div class="tutup_petugas tutup" style="position: absolute; top:0; right:0; width:30px; line-height:30px; text-align:center; height:30px; cursor:pointer;">X</div>
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



    </div>

    <script src="assets/js/script.js"></script>
    <script src="assets/js/tilt.js"></script>
    <!-- <script>
        $(document).ready(function() {
            $('#coba').click(function() {
                $('.admin').slideToggle(1000);
            })
        })
    </script> -->
</body>

</html>