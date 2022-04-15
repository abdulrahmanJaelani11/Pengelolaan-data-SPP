<?php
include 'session/session_staf.php';
include "koneksi.php";

// AMBIL DATA USER 
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id =" . $_SESSION['id']));

// AMBIL DATA KELAS 
$query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");

// AMBIL DATA JURUSAN
$query_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");

// HAPUS DATA SISWA
if (isset($_POST['hapus'])) {
    $nisn = $_POST['nisn'];
    mysqli_query($koneksi, "DELETE fROM siswa WHERE nisn = $nisn");
    if (mysqli_affected_rows($koneksi)) {
        header("location: dataSiswa.php");
        exit;
        $sukses = "berhasil Menghapus Data";
    }
}

// CARI SISWA 
if (isset($_POST['cari'])) {
    $nama = $_POST['nama'];

    $query = mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan WHERE nama LIKE '%$nama%'");
    if (mysqli_num_rows($query) > 0) {
        $query = $query;
    } else {
        $error = "Siswa tidak ditemukan";
    }
}
// var_dump(mysqli_fetch_assoc($query));
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
                        <a class="nav-link active" href="dataSiswa.php">Data Siswa</a>
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

    <!-- CONTENT UTAMA  -->
    <div class="container-fluid" style="margin-top: 60px;">

        <!-- FORM TAMBAH SISWA  -->
        <div class="row justify-content-center form_tambah_siswa" style="display: none; position:absolute; z-index:2; width:100%">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card shadow mt-3">
                    <div class="card-header">
                        <h3 class="text-center font-weight-bold text-uppercase">Form Tambah Siswa</h3>
                    </div>
                    <div class="card-body">
                        <div id="pesan"></div>
                        <form action="proses/prosesTambahSiswa.php" method="post" id="formTambahSiswa">
                            <div class="form-group">
                                <label for="nama">Nama *</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama Siswa" required>
                            </div>
                            <div class="form-group">
                                <label for="nisn">NISN *</label>
                                <input type="numeric" name="nisn" id="nisn" class="form-control" placeholder="Masukan nisn Siswa" required autocomplete="off">
                                <div class="invalid-feedback invalid-nisn"></div>
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas *</label>
                                <select name="kelas" id="kelas" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <?php while ($kelas = mysqli_fetch_assoc($query_kelas)) : ?>
                                        <option value="<?= $kelas['id_kelas']; ?>"><?= $kelas['NoKelas']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jurusan">Jurusan *</label>
                                <select name="jurusan" id="jurusan" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <?php while ($jurusan = mysqli_fetch_assoc($query_jurusan)) : ?>
                                        <option value="<?= $jurusan['id_jurusan']; ?>"><?= $jurusan['jurusan']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <div type="submit" id="btn_batal" name="batal" class="btn btn-warning btn-block btn-sm"> Batal </div>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="simpan" class="btn btn-primary btn-block btn-sm"> Simpan </button>
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

        <!-- DATA SISWA  -->
        <div class="row">
            <div class="col-12 col-sm-12">
                <div class="card shadow mt-3">
                    <div class="card-header py-3">
                        <h5 class="font-weight-bold text-uppercase">Data Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-md-5 mb-3">
                                <?php if ($user['posisi'] == 'admin') : ?>
                                    <div href="" class="btn  btn-sm btn-primary btn_tambah_siswa">
                                        Tambah Data
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-7">
                                <form action="getPencarian.php" method="post" id="formPencarian">
                                    <div class="form-group row">
                                        <div class="col-8">
                                            <input type="text" autofocus name="nama" id="inputCari" class="form-control form-control-sm" placeholder="Search..." autocomplete="off">
                                            <div class="text-danger mt-2" style="font-size: 13px;">* Anda bisa mencari siswa dengan berdasarkan Nama, Nisn, Kelas Bahkan Nama Jurusan *</div>
                                        </div>
                                        <div class="col-4">
                                            <a href="dataSiswa.php" class="btn btn-block btn-primary btn-sm">Refresh</a>
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
                        <div class="table-resposive" id="dataSiswa">

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
                    success: function(data) {
                        if (data == 22) {
                            $('#pesan').addClass("alert alert-danger")
                            $('#pesan').text("Nisn Sudah Terdaftar")
                            $('#nisn').addClass('is-invalid')
                            $('.invalid-nisn').text("Nisn Sudah Terdaftar")
                        } else if (data == 4) {
                            $('#pesan').addClass("alert alert-danger")
                            $('#pesan').text("Gagal Menambah data siswa")
                            $('input, select').val('')
                        } else if (data == 1) {
                            alert("Berhasil Menambahkan data Siswa")
                            $('#bg-blur').fadeToggle(500)
                            $('.form_tambah_siswa').slideToggle(800)
                            $('input, select').val('')
                        }
                        loadData()
                    }
                });
            })

            $('#nisn').click(function() {
                $(this).removeClass('is-invalid')
            })

            $('#inputCari').keyup(function() {
                var inputan = $('#inputCari').val()
                $.ajax({
                    url: $('#formPencarian').attr('action'),
                    type: $('#formPencarian').attr('method'),
                    data: {
                        input: inputan
                    },
                    success: function(respon) {
                        $('#dataSiswa').html(respon)
                    }
                });
            })

            $('#nisn').keyup(function() {
                var nisn = $('#nisn').val()

                $.ajax({
                    url: 'proses/prosesPencarianNisn.php',
                    type: 'POST',
                    data: {
                        nisn: nisn
                    },
                    success: function(data) {
                        if (data == 22) {
                            $('#nisn').addClass('is-invalid')
                            $('.invalid-nisn').text('NISN sudah ada')
                        } else if (data == 0) {
                            $('#nisn').removeClass('is-invalid')
                            $('#nisn').addClass('is-valid')
                        } else {
                            $('#nisn').removeClass('is-invalid')
                        }
                    }
                });
            })
        })

        function loadData() {
            $.get('proses/getDataSiswa.php', function(data) {
                $('#dataSiswa').html(data)
            })
        }
    </script>
</body>

</html>