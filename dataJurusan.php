<?php
include 'session/session_staf.php';

// AMBIL KONEKSI DATABASE 
include "koneksi.php";

// AMBIL DATA USER 
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id =" . $_SESSION['id']));

// CEK STATUS LOGIN 
if (!$_SESSION['login']) {
    header("location: login_staf.php");
    exit;
}

// PENCARIAN DATA JURUSAN 
if (isset($_POST['cari'])) {
    $jurusan = $_POST['jurusan'];

    $query = mysqli_query($koneksi, "SELECT * FROM jurusan WHERE jurusan = '$jurusan'");
    if (mysqli_num_rows($query) > 0) {
        $query = $query;
    } else {
        $error = "Kelas tidak ditemukan";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jurusan</title>
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
                        <a class="nav-link active" href="dataJurusan.php">Data Jurusan</a>
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

    <!-- CONTENT UTAMA  -->
    <div class="container-fluid" style="margin-top: 60px;">

        <!-- form tambah jurusan  -->
        <div class="row justify-content-center mt-3 form_tambah_jurusan" style="display: none; position:absolute; z-index:2; width:100%">
            <div class="col-lg-5 col-sm-10">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="text-center text-dark">Form Tambah Kelas</h2>
                    </div>
                    <div class="card-body">
                        <form action="proses/prosesTambahJurusan.php" method="post">
                            <div class="form-group">
                                <label for="jurusan">Jurusan *</label>
                                <input type="text" name="jurusan" id="jurusan" class="form-control" placeholder="Masukan nama jurusan" required>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="btn btn-warning btn-sm btn-block" id="btn_batal">Batal</div>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="simpan" class="btn btn-sm btn-primary btn-block"> Simpan </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir form tambah jurusan -->

        <!-- bg-blur modal  -->
        <div id="bg-blur" class="bg-secondary" style="position:absolute; top:0; bottom:0; left:0; right:0; z-index:1; opacity:.5; display:none;"></div>
        <!-- Akhir bg-blur modal  -->

        <!-- table data jurusan  -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mt-3 shadow">
                    <div class="card-header">
                        <h4 class="text-uppercase font-weight-bold text-center py-2">Data Jurusan</h4>
                    </div>
                    <div class="card-body">
                        <div id="pesan"></div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-lg-3 mb-3">
                                <?php if ($user['posisi'] == 'admin') : ?>
                                    <div class="btn_tambah_jurusan btn btn-sm btn-primary">
                                        Tambah Data
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-9">
                                <form action="" method="post">
                                    <div class="form-group row">
                                        <div class="col-6">
                                            <input type="text" autofocus name="jurusan" class="form-control" placeholder="Cari Berdasarkan Nama Jurusan" autocomplete="off">
                                        </div>
                                        <div class="col-3">
                                            <button type="submit" name="cari" class="btn btn-sm btn-block btn-success"> Cari </button>
                                        </div>
                                        <div class="col-3">
                                            <a href="dataJurusan.php" class="btn btn-sm btn-block btn-primary">Refresh</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger">
                                <?= $error; ?>
                            </div>
                        <?php endif; ?>
                        <div id="tabel"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir tabel data jurusan  -->

    </div>

    <script src="assets/js/script.js"></script>
    <script>
        $(document).ready(function() {
            loadData()

            $('form').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(respons) {
                        if (respons == 1) {
                            $('.form_tambah_jurusan').slideToggle(500)
                            $('#bg-blur').fadeToggle(500)
                            $('#pesan').addClass('alert alert-success')
                            $('#pesan').text('Berhasil Menambah data Jurusan')
                        } else if (respons == 4) {
                            $('#pesan').addClass('alert alert-danger')
                            $('#pesan').text('Gagal Menambah data Jurusan')
                            $('.form_tambah_jurusan').slideToggle(500)
                            $('#bg-blur').fadeToggle(500)
                        }
                        loadData()
                        $('#jurusan').val('')
                    }
                });

            })

        })

        function loadData() {
            $.get('getDataJurusan.php', function(respons) {
                $('#tabel').html(respons)

                $('form').on('submit', function(e) {
                    e.preventDefault()
                    $.ajax({
                        url: $('#hapusJurusan').attr('action'),
                        type: $('#hapusJurusan').attr('method'),
                        data: $(this).serialize(),
                        success: function(respons) {
                            if (respons == 1) {
                                alert("Data Berhasil dihapus");
                            } else if (respons == 0) {
                                alert("Data Gagal dihapus");
                            }
                            loadData()
                        }
                    });
                })
            })
        }
    </script>
</body>

</html>