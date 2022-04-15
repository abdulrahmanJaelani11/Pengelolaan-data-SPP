<?php
include 'session/session_staf.php';
include "koneksi.php";
$id_user = $_SESSION['id'];
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * from users WHERE id = $id_user"));
// var_dump($user);

$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan WHERE siswa.id_siswa = $id");
$data = mysqli_fetch_assoc($query);
$pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran JOIN siswa ON siswa.id_siswa=pembayaran.id_siswa JOIN bulan ON bulan.id_bulan = pembayaran.id_bulan WHERE siswa.id_siswa = $id");
// var_dump($pembayaran);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa</title>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
</head>

<body style="font-family: cursive;">
    <!-- NAVBAR  -->
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

    <!-- CONTENT UTAMA -->
    <div class="container-fluid" style="margin-top: 60px;">

        <div class="row justify-content-center mt-3">
            <!-- DETAIL SISWA 
         -->
            <div class="col-lg-4 col-sm-10 mt-3">
                <div class="card shadow">
                    <div class="card-body">
                        <h3 class="text-center">Rincian Siswa</h3>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="username">Nama *</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?= $data['nama']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="username">NISN *</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?= $data['nisn']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="username">Kelas *</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?= $data['NoKelas']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="username">Jurusan *</label>
                                <input type="text" name="username" id="username" class="form-control" value="<?= $data['jurusan']; ?>" readonly>
                            </div>
                        </form>
                        <?php if ($user['posisi'] == 'admin') : ?>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <a href="formUpdate.php?id=<?= $id; ?>" class="btn btn-block btn-primary btn-sm">Update</a>
                                </div>
                                <div class="col-6">
                                    <form action="deleteSiswa.php" method="post" class="d-inline">
                                        <input type="hidden" name="nisn" value="<?= $data['nisn']; ?>">
                                        <button type="submit" name="hapus" onclick="return confirm('Yakin untuk Menghapus Siswa?')" class="btn btn-danger btn-sm btn-block"> Hapus Siswa </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- DETAIL ADMINISTRASI  -->
            <div class="col-lg-8 mt-3">
                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="text-center">Rincian Administrasi</h3>
                    </div>
                    <div class="card-body">
                        <div id="gagal"></div>
                        <a href="cetak.php?id=<?= $id; ?>" class="btn btn-success btn-sm">Print</a>
                        <a href="bayar.php?id=<?= $id; ?>" class="btn btn-primary btn-sm">Bayar</a>
                        <a href="detailPembayaran.php?id=<?= $id; ?>" class="btn btn-info btn-sm">Detail Pembayaran</a>
                        <div class="table-responsive">
                            <table class="table table-bordered mt-3 text-center">
                                <thead>
                                    <tr>
                                        <th>Pembayaran</th>
                                        <th>Nominal</th>
                                        <th>Keterangan</th>
                                        <th>Petugas</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($data = mysqli_fetch_assoc($pembayaran)) : ?>
                                        <tr>
                                            <td><?= $data['bulan']; ?></td>
                                            <td><?= $data['nominal']; ?></td>
                                            <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['keterangan']; ?></td>
                                            <td><?= $data['petugas']; ?></td>
                                            <td><?= $data['tgl_pembayaran']; ?></td>
                                            <td>
                                                <?php if ($data['keterangan'] == "BELUM LUNAS") : ?>
                                                    <a href="formPelunasan.php?id=<?= $data['id_pembayaran']; ?>" class="btn btn-warning btn-sm btn-block">Lunasi!!</a>
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
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(respon) {
                        if (respon == 1) {
                            document.location = 'dataSiswa.php';
                        } else if (respon == 4) {
                            $('#gagal').text("Gagal Menghapus data Siswa");
                            $('#gagal').addClass('alert alert-danger');
                        }
                    }
                });
            })
        })
    </script>
    <script src="assets/js/tilt.js"></script>
</body>

</html>