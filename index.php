<?php
session_start();
if (isset($_SESSION['nisn'])) {
    header("location: beranda_siswa.php");
    exit;
} else if (isset($_SESSION['login'])) {
    header("location: beranda.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
    <title>Welcome</title>
    <link rel="stylesheet" href="assets/css/welcomePage.css">
</head>

<body>
    <div class="nav fixed-top bg-primary text-light">
        <h4 class="mt-2 ml-2 font-weight-bold">STEKMAN-PAY</h4>
        <ul class="text-dark" id="btn" style="border-radius: 10px;">
            <button type="submit" name="login" class="btn btn-outline-warning"> Login </button>
            <ul style="display: none;">
                <li><a href="login_staf.php">Petugas</a></li>
                <li><a href="login_siswa.php">Siswa</a></li>
            </ul>
        </ul>
    </div>

    <div class="container" style="font-family: cursive; margin-top: 100px;">
        <div class="row">
            <div class="col-lg-5" style="margin-top: 140px;">
                <div class="card shadow">
                    <div class="card-body text-dark">
                        <h1>STEKMAN-PAY</h1>
                        <P>Selamat Datang di Website STEKMAN-PAY</P>
                        <button type="submit" name="tentang" class="btn btn-outline-warning"> About Us </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <img src="assets/img/bg3.jpg" class="img-fluid" alt="">
            </div>
        </div>
    </div>










    <script>
        $(document).ready(function() {
            $('#btn').click(function() {
                $(this).find('ul').slideToggle(500);
                // alert("OK")
            });

            $('li a').hover(function() {
                $(this).css('color', 'orange')
            })

            $('li a').mouseleave(function() {
                $(this).css('color', 'rgb(32, 132, 240)')
            })
        });
    </script>
</body>

</html>