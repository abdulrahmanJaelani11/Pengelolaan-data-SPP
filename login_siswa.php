<?php
session_start();
include "koneksi.php";
if (isset($_SESSION['nisn'])) {
    header("location: beranda_siswa.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
</head>

<body style="font-family: cursive;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 d-flex">
                <img src="assets/img/bgLoginSiswa.jpg" alt="bg5" class="img-fluid" style="margin: auto;">
            </div>
            <div class="col-lg-5 col-md-9">
                <div class="card mt-5 shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center text-primary font-weight-bold my-3">Selamat Datang</h2>
                        <div class="p-4">
                            <div class="alert alert-info" id="pesan">
                                <p class="text-center">Silahkan Login menggunakan akun yang telah anda daftarkan</p>
                            </div>
                            <form action="proses/prosesLoginSiswa.php" method="post" class="user">
                                <div class="form-group pb-3">
                                    <input type="text" name="nisn" id="nisn" class="form-control form-control-user" placeholder="Masukan NISN" autofocus>
                                    <div class="invalid-feedback invalid-nisn"></div>
                                </div>
                                <div class="form-group pb-3">
                                    <input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Masukan Password">
                                    <div class="invalid-feedback invalid-password"></div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="checkbox" id="show"> <span id="textShow" style="font-size: small;">Tampilkan Password</span>
                                </div>
                                <div class="form-group pb-3">
                                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block"> Login </button>
                                </div>
                            </form>
                            <p class="text-center text-decoration-none"><a href="register_siswa.php">Register?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // AJAX 
            $('form').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(respon) {
                        if (respon == 0) {
                            $('#pesan').removeClass('alert-info')
                            $('#pesan').addClass('alert-danger text-center')
                            $('#pesan').text("Akun Tidak Ditemukan")
                            $('#nisn').addClass('is-invalid')
                            $('.invalid-nisn').text("NISN Salah")
                        } else if (respon == 4) {
                            $('#pesan').removeClass('alert-info')
                            $('#pesan').addClass('alert-danger text-center')
                            $('#pesan').text("Password Salah")
                            $('#password').addClass('is-invalid')
                            $('.invalid-password').text("Password Salah")
                        } else if (respon == 1) {
                            document.location = 'beranda_siswa.php'
                        }
                    }
                });
            })

            // TAMPILKAN PASSWORD 
            $('#show').click(function() {
                if ($('#show').is(':checked')) {
                    $('#password').attr('type', 'text')
                    $('#textShow').text('Sembunyikan Password')
                } else {
                    $('#password').attr('type', 'password')
                    $('#textShow').text('Tampilkan Password')
                }
            })
        })
    </script>

</body>

</html>