<?php
include "koneksi.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
</head>

<body style="font-family: cursive;">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 d-flex">
                <img src="assets/img/bgRegister.jpg" alt="bg" class="img-fluid" style="margin: auto;">
            </div>
            <div class="col-lg-5 col-md-9">
                <div class="card mt-5 shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center text-primary font-weight-bold my-3">Selamat Datang</h2>
                        <div class="p-4">
                            <div class="alert alert-info text-center notif">
                                Silahkan Isi form dibawah dengan data yang valid
                            </div>
                            <form action="proses/prosesRegisterSiswa.php" method="post" class="user">
                                <div class="form-group pb-3">
                                    <input type="text" name="nisn" id="nisn" class="form-control form-control-user" placeholder="Masukan NISN" autofocus>
                                    <div class="invalid-feedback invalid-nisn"></div>
                                </div>
                                <div class="form-group pb-3">
                                    <input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Masukan Password">
                                </div>
                                <div class="form-group pb-3">
                                    <input type="password" name="konfirmasi" id="konfirmasi" class="form-control form-control-user" placeholder="Konfirmasi Password">
                                    <div class="invalid-feedback invalid-konfirmasi"></div>
                                </div>
                                <div class="form-group pb-3">
                                    <input type="checkbox" id="show"> <span id="textShow" style="font-size: small;">Tampilkan Password</span>
                                </div>
                                <div class="form-group pb-3">
                                    <button type="submit" name="register" class="btn btn-primary btn-user btn-block"> Daftar </button>
                                </div>
                            </form>
                            <p class="text-center text-decoration-none"><a href="login_siswa.php">Login?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            // SHOW/HIDE PASSWORD 
            $('#show').click(function() {
                if ($('#show').is(':checked')) {
                    $('#password').attr('type', 'text');
                    $('#konfirmasi').attr('type', 'text');
                    $('#textShow').text('Sembunyikan Password')
                } else {
                    $('#password').attr('type', 'password');
                    $('#konfirmasi').attr('type', 'password');
                    $('#textShow').text('Tampilkan Password')
                }

            })

            // REGISTER AKUN 
            $("form").on("submit", function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr("action"),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(respon) {
                        if (respon == "NISN_Sudah_Terdaftar") {
                            $("#nisn").addClass("is-invalid");
                            $(".invalid-nisn").text("NISN yang anda masukan sudah terdaftar!!");
                            $(".notif").addClass("alert-danger text-center");
                            $(".notif").text("Gagal Membuat Akun!!");
                        } else if (respon == "NISN_yang_anda_masukan_salah") {
                            $("#nisn").addClass("is-invalid");
                            $(".invalid-nisn").text("NISN yang anda masukan salah!!");
                            $(".notif").addClass("alert-danger text-center");
                            $(".notif").text("Gagal Membuat Akun!!");
                        } else if (respon == "Konfirmasi_Password_tidak_sesuai") {
                            $("#konfirmasi").addClass("is-invalid")
                            $(".invalid-konfirmasi").text("Konfirmasi Password tidak Sesuai!!");
                        } else if (respon == "Gagal_Membuat_Akun") {
                            $(".notif").removeClass("alert-info");
                            $(".notif").addClass("alert-danger text-center");
                            $(".notif").text("Gagal Membuat Akun!!");
                        } else if (respon == "Berhasil_Membuat_Akun") {
                            // $(".notif").removeClass("alert-info");
                            // $(".notif").addClass("alert-success text-center");
                            // $(".notif").text("Berhasil Membuat Akun!!");
                            alert("Berhasil membuat akun, Silahkan Login");
                            document.location = "login_siswa.php";
                        }
                    }
                });
            })

            // MENGHILANGKAN IS-INVALID PADA NISN
            $("#nisn").click(function() {
                $(this).removeClass("is-invalid");
            })

            // MENGHILANGKAN IS-INVALID PADA KONFIRMASI PASSWORD 
            $("#konfirmasi").click(function() {
                $(this).removeClass("is-invalid");
            })


        })
    </script>
</body>

</html>