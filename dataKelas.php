<?php
include 'session/session_staf.php';

// AMBIL KONEKSI 
include "koneksi.php";

// AMBIL DATA USER 
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id =" . $_SESSION['id']));

// CEK STATUS LOGIN 
if (!$_SESSION['login']) {
    header("location: index.php");
    exit;
}

// CARI DATA SISWA 
if (isset($_POST['cari'])) {
    $kelas = $_POST['NoKelas'];

    $query = mysqli_query($koneksi, "SELECT * FROM kelas WHERE NoKelas = '$kelas'");
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
    <title>Data Siswa</title>
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
                        <a class="nav-link active" href="dataKelas.php">Data Kelas</a>
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

    <!-- CONTENT UTAMA  -->
    <div class="container-fluid" style="margin-top: 60px;">

        <!-- FORM TAMBAH DATA KELAS  -->
        <div class="row justify-content-center mt-3 form_tambah_kelas" style="display: none; position:absolute; z-index:2; width:100%">
            <div class="col-lg-5 col-sm-10">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="text-center text-dark">Form Tambah Kelas</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($sukses)) : ?>
                            <div class="alert alert-success">
                                <?= $sukses; ?>
                            </div>
                        <?php elseif (isset($error)) : ?>
                            <div class="alert alert-danger">
                                <?= $error; ?>
                            </div>
                        <?php endif; ?>
                        <form action="proses/prosesTambahKelas.php" method="post">
                            <div id="pesan"></div>
                            <div class="form-group">
                                <label for="kelas">Kelas *</label>
                                <input type="text" name="kelas" id="kelas" class="form-control" placeholder="Masukan nama Kelas (X / XI / XII)" required>
                            </div>
                            <div class="form-group">
                                <label for="NoKelas">Kelas Spesifik *</label>
                                <input type="text" name="NoKelas" id="NoKelas" class="form-control" placeholder="Masukan Kelas Spesifik contoh(X RPL1)" required>
                                <div class="invalid-feedback invalid-NoKelas"></div>
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

        <!-- BACKGROUND BLUR  -->
        <div id="bg-blur" style="position:absolute; top:0; bottom:0; left:0; right:0; background-color:gray; z-index:1; opacity:.5; display:none;"></div>

        <!-- TABLE DATA KELAS  -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card mt-3 shadow">
                    <div class="card-header">
                        <h4 class="text-uppercase font-weight-bold text-center py-2">Data Kelas</h4>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center mt-3">
                            <div class="col-lg-4 mb-3">
                                <?php if ($user['posisi'] == 'admin') : ?>
                                    <div class="btn btn_tambah_kelas btn-primary btn-primary btn-sm">
                                        Tambah Data
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-8">
                                <form action="" method="post">
                                    <div class="form-group row">
                                        <div class="col-md-10">
                                            <input type="text" autofocus name="NoKelas" class="form-control" id="cariKelas" placeholder="Cari Berdasarkan Spesifik Kelas" autocomplete="off">
                                        </div>
                                        <div class="col-md-2">
                                            <a href="dataKelas.php" class="btn btn-block btn-primary btn-sm">Refresh</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="pesan">

                        </div>
                        <div id="dataKelas">

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    success: function(respon) {
                        if (respon == 'kelasSudahAda') {
                            alert("Kelas Sudah Terdaftar")
                            $('#NoKelas').addClass('is-invalid')
                            $('.invalid-NoKelas').text("Kelas Sudah Ada")
                        } else if (respon == 'sukses') {
                            alert("Berhasil Menambahkan data kelas")
                            $('.form_tambah_kelas').slideToggle(500)
                            $('#bg-blur').fadeToggle(500)
                            // $('[name=kelas]').focus()
                            $('input').val('')
                        } else if (respon == 'gagal') {
                            alert("Gagal Menambahkan data Kelas")
                        }
                        loadData()
                    }
                });
            })

            $("#cariKelas").keyup(function() {
                // console.log("HAI");
                var data = $(this).val();
                $.ajax({
                    url: "proses/prosesPencarianKelas.php",
                    type: "POST",
                    data: {
                        data: data
                    },
                    success: function(respon) {
                        $('#dataKelas').html(respon);
                    }
                });
            })
        })

        function loadData() {
            $.get('proses/getDataKelas.php', function(respons) {
                $('#dataKelas').html(respons)

                $('.btnHapus').click(function(e) {
                    e.preventDefault()

                    $.ajax({
                        url: $(this).attr('href'),
                        type: "GET",
                        success: function(data) {
                            if (data == 'hapus1') {
                                alert("Berhasil Menghapus data Kelas")
                            } else if (data == 'hapus22') {
                                $('.pesan').addClass('alert alert-danger')
                                $('.pesan').text('Tidak Bisa Menghapus Kelas, Karena kelas di pake oleh Siswa', function() {
                                    $('.pesan').hide()
                                })
                            }
                            console.log(data)
                            loadData()
                        }
                    });
                })
            })
        }
    </script>

</body>

</html>