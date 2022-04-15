<?php
include 'session/session_staf.php';
include "koneksi.php";
$id = $_GET['id'];
$pembayaran = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pembayaran JOIN bulan ON bulan.id_bulan=pembayaran.id_bulan JOIN siswa ON siswa.id_siswa = pembayaran.id_siswa WHERE id_pembayaran = $id"));
$id_siswa = $pembayaran['id_siswa'];
if ($pembayaran['bulan'] == "PAS" || $pembayaran['bulan'] == "PTS" || $pembayaran['bulan'] == "MODUL") {
    $sisa = 75000 - $pembayaran['nominal'];
    $jenisPembayaran = $pembayaran['bulan'];
    $total = 75000;
} else {
    $sisa = 150000 - $pembayaran['nominal'];
    $jenisPembayaran = "SPP " . $pembayaran['bulan'];
    $total = 150000;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pelunasan</title>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
</head>

<body style="font-family:cursive">
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

    <div class="container-fluid" style="margin-top: 70px;">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-sm-10">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="text-center text-gray font-weight-bold text-uppercase">Form Pelunasan Administrasi Siswa</h4>
                    </div>
                    <div class="card-body">
                        <div id="pesan"></div>
                        <form action="proses/prosesPelunasan.php" method="post">
                            <div class="form-group">
                                <label for="nama_siswa">Nama Siswa *</label>
                                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control" value="<?= $pembayaran['nama']; ?>" readonly>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="jenisBayar">Jenis Pembayaran *</label>
                                    <input type="text" name="jenisBayar" id="jenisBayar" class="form-control" value="<?= $jenisPembayaran; ?>" readonly>
                                </div>
                                <div class="col-6">
                                    <label for="total">Yang Harus Dibayar *</label>
                                    <input type="text" name="total" id="total" class="form-control" value="<?= $total; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sebelum">Sudah dibayar *</label>
                                <input type="text" name="sebelum" id="sebelum" class="form-control" value="<?= $pembayaran['nominal']; ?>" readonly>
                                <input type="hidden" name="id" id="id" class="form-control" value="<?= $id; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="sisaCicilan">Sisa Cicilan *</label>
                                <input type="text" name="sisaCicilan" id="sisaCicilan" class="form-control" value="<?= $sisa; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nominalPelunasan">Nominal Pelunasan *</label>
                                <input type="text" name="nominalPelunasan" id="nominalPelunasan" class="form-control" placeholder="Nominal Pelunasan" required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal *</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>
                            <div class="form-group row">
                                <div class="col-6">
                                    <a href="detailSiswa.php?id=<?= $id_siswa; ?>" class="btn btn-block btn-secondary btn-sm">Kembali</a>
                                </div>
                                <div class="col-6">
                                    <button type="submit" name="simpan" class="btn btn-primary btn-sm btn-block"> Simpan </button>
                                </div>
                            </div>
                        </form>
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
                    success: function(respons) {
                        if (respons == 'gagal') {
                            $('#pesan').text("Gagal Membayar")
                            $('#pesan').addClass('alert alert-danger')
                        } else {
                            alert("Berhasil membayar")
                            document.location = 'detailSiswa.php?id=' + respons
                        }
                    }
                });
            })
        })
    </script>
</body>

</html>