<?php
session_start();
if (isset($_SESSION['login'])) {
    if ($_SESSION['login']) {
        header("location: beranda.php");
        exit;
    }
}
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
    <script src="assets/js/script.js"></script>
    <style>
        body {
            font-family: cursive;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center" style="margin-top: 5%;">
            <div class="col-lg-6 col-md-12 d-flex">
                <img src="assets/img/bg4.jpg" alt="bg" class="img-fluid" style="margin: auto;">
            </div>
            <div class="col-sm-10 col-md-8 col-lg-5">
                <div class="card mt-5 shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center text-primary font-weight-bold my-3">Selamat Datang</h2>
                        <div class="p-4">
                            <div id="pesan"></div>
                            <form action="proses/prosesloginStaf.php" method="post" class="user">
                                <div class="form-group pb-3">
                                    <input type="text" name="username" id="username" class="form-control form-control-user" placeholder="Masukan Username" autofocus>
                                    <div class="invalid-feedback invalid-username"></div>
                                </div>
                                <div class="form-group pb-3">
                                    <input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Masukan Password">
                                    <div class="invalid-feedback invalid-password"></div>
                                </div>
                                <div class="form-group pb-3">
                                    <input type="checkbox" name="check" id="show" style="margin: 0;"><span style="font-size: small; margin-left:10px;" id="textShow">Tampilkan Password</span>
                                </div>
                                <div class="form-group pb-3">
                                    <button type="submit" name="login" class="btn btn-primary btn-user btn-block"> Login </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault()
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(data) {
                        if (data == 0) {
                            $("#pesan").text("Username Tidak Ditemukan")
                            $("#pesan").addClass('alert alert-danger')
                            $('#username').addClass('is-invalid')
                            $('.invalid-username').text('Username yang anda masukan salah')
                        } else if (data == 0.1) {
                            $("#pesan").text("Password yang anda masukan salah")
                            $("#pesan").addClass('alert alert-danger')
                            $('#password').addClass('is-invalid')
                            $('.invalid-password').text('Password yang anda masukan salah')
                        } else if (data == 1) {
                            document.location = 'beranda.php'
                        }
                    }
                });
            })

            $("#username").click(function() {
                $(this).removeClass("is-invalid")
            })

            $("#password").click(function() {
                $(this).removeClass("is-invalid")
            })
        })
    </script>
</body>

</html>