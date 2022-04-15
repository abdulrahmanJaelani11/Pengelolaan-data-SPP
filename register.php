<?php
include "koneksi.php";
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $konfirmasi_Pass = $_POST['konfirmasi'];

    $cek_username = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    $datauser = mysqli_num_rows($cek_username);
    if ($datauser > 0) {
        $error = "Username sudah terdaftar";
    } else {
        if ($password == $konfirmasi_Pass) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $query = mysqli_query($koneksi, "INSERT INTO users VALUES ('', '$username', '$password')");
            if (mysqli_affected_rows($koneksi) > 0) {
                $success = "Berhasil Daftar";
            } else {
                $error = "Gagal Mendaftar";
            }
        } else {
            $error = "konfirmasi Password Tidak Sesuai";
        }
    }
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
</head>

<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card mt-5 shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center text-dark my-3">REGISTER AKUN</h2>
                        <div class="p-4">
                            <?php if (isset($success)) : ?>
                                <div class="alert alert-success">
                                    <?= $success; ?>
                                </div>
                            <?php elseif (isset($error)) : ?>
                                <div class="alert alert-danger">
                                    <?= $error; ?>
                                </div>
                            <?php else : ?>
                                <div class="alert alert-info">
                                    Silahkan Daftar dengan mengisi form di bawah
                                </div>
                            <?php endif; ?>
                            <form action="" method="post" class="user">
                                <div class="form-group pb-3">
                                    <input type="text" name="username" id="username" class="form-control form-control-user" placeholder="Masukan Username" autofocus>
                                </div>
                                <div class="form-group pb-3">
                                    <input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Masukan Password">
                                </div>
                                <div class="form-group pb-3">
                                    <input type="password" name="konfirmasi" id="konfirmasi" class="form-control form-control-user" placeholder="Konfirmasi Password">
                                </div>
                                <div class="form-group pb-3">
                                    <button type="submit" name="register" class="btn btn-primary btn-user btn-block"> Daftar </button>
                                </div>
                            </form>
                            <p class="text-center text-decoration-none"><a href="login.php">Login?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>