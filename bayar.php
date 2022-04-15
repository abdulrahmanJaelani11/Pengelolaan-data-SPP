<?php
include 'session/session_staf.php';

// AMBIL USERNAME USER 
$users = $_SESSION['username'];
// AMBIL KONEKSI 
include "koneksi.php";
// AMBIL DATA 
$bulan = mysqli_query($koneksi, "SELECT * FROM bulan");

// CEK SISWA YANG AKAN BAYAR 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan WHERE id_siswa = $id"));
} else {
    $siswa = mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
    <style>
        body {
            font-family: cursive;
        }
    </style>
</head>

<body>
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
                        <a class="nav-link" aria-current="page" href="beranda.php">Beranda</a>
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
                        <a class="nav-link active" aria-current="page" href="bayar.php">Bayar</a>
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

    <!-- CONTENT UTAMA  -->
    <div class="container-fluid" style="margin-top: 100px;">

        <!-- FORM PEMBAYARAN  -->
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="text-center text-dark">Form Pembayaran</h2>
                    </div>
                    <div class="card-body">
                        <div id="pesan"></div>
                        <form action="proses/prosesBayar.php" method="post">
                            <div class="form-group">
                                <label for="nama">Nama *</label>
                                <select id="idSiswa" name="nama" class="form-control" required autofocus>
                                    <option value="<?= isset($id) ? $siswa['id_siswa'] : ''; ?>"><?= isset($id) ?  $siswa['nama'] : '--Pilih Siswa--'; ?></option>
                                    <?php while ($row = mysqli_fetch_assoc($siswa)) : ?>
                                        <option value="<?= $row['id_siswa']; ?>"><?= $row['nama']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pembayaran">Pembayaran *</label>
                                <select name="pembayaran" class="form-control" required id="pembayaran">
                                    <option value="">--Pilih Pembayaran--</option>
                                    <?php while ($row = mysqli_fetch_assoc($bulan)) : ?>
                                        <option value="<?= $row['id_bulan']; ?>"><?= $row['bulan']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <div class="invalid-feedback invalid-pembayaran"></div>
                            </div>
                            <div class="form-group">
                                <label for="nominal">Nominal *</label>
                                <input type="text" name="nominal" id="nominal" class="form-control" placeholder="Nominal Pembayaran" required>
                                <div class="invalid-feedback invalid-nominal"></div>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal Pembayaran *</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="simpan" class="btn btn-primary btn-block"> Bayar </button>
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
                            $('#pesan').addClass('alert alert-danger')
                            $('#pesan').text("Pembayaran Gagal")
                        } else if (respons == 'sudahbayar') {
                            $('#pesan').addClass('alert alert-danger')
                            $('#pesan').text("Siswa Telah Membayar Bulan Ini Sebelumnya, Silahkan Lunasi di Form Pelunasan")
                            $('#pembayaran').addClass('is-invalid')
                        } else if (respons == 'sudahLunas') {
                            $('#pesan').addClass('alert alert-warning')
                            $('#pesan').text("Siswa Sudah Melunasi Administrasi ini")
                            $('#pembayaran').addClass('is-invalid')
                        } else {
                            alert("Pembayaran Berhasil");
                            document.location = 'detailSiswa.php?id=' + respons
                        }
                        // console.log(respons)
                    }
                });
            })

            $('#nominal').keyup(function() {
                if ($('#pembayaran').val() != 13 && $('#pembayaran').val() != 14 && $('#pembayaran').val() != 15) {
                    console.log($('#pembayaran').val())
                    console.log($('#nominal').val())
                    if ($('#nominal').val() > 150000) {
                        $(this).addClass('is-invalid')
                        $('.invalid-nominal').text('Pembayaran Lebih')
                    } else {
                        $(this).removeClass('is-invalid')
                        $(this).addClass('is-valid')
                    }
                } else {
                    console.log($('#pembayaran').val())
                    console.log($('#nominal').val())
                    if ($('#nominal').val() > 75000) {
                        $(this).addClass('is-invalid')
                        $('.invalid-nominal').text('Pembayaran Lebih')
                        // $('.btn-primary').hide('button')
                    } else {
                        $(this).removeClass('is-invalid')
                        $(this).addClass('is-valid')
                        // $('.btn-primary').slideToggle('button')
                    }
                }
            })

            $('#pembayaran').click(function() {
                var idBayar = $(this).val()
                var idSiswa = $('#idSiswa').val()
                $.ajax({
                    url: 'proses/getPencarianPembayaran.php',
                    type: "POST",
                    data: {
                        id_pembayaran: idBayar,
                        id_siswa: idSiswa
                    },
                    success: function(respon) {
                        if (respon == 'ada') {
                            $('#pembayaran').addClass('is-invalid')
                            $('.invalid-pembayaran').text('Siswa sudah membayar Administrasi ini')
                        } else if (respon == 'null') {
                            $('#pembayaran').removeClass('is-invalid')
                            $('#pembayaran').addClass('is-valid')

                        }
                        console.log(respon)
                    }
                });
            })
        })
    </script>
</body>

</html>