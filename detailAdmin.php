<?php
session_start();
if (!$_SESSION['login']) {
    header("location: index.php");
    exit;
}
include "koneksi.php";
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <title>Detail Admin</title>
</head>

<body>
    <div class="container-fluid">
        <div class="card mt-3 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-5 col-sm-6">
                        <div class="card mt-2 click">
                            <img src="assets/img/pp/<?= $data['img']; ?>" class="img-thumbnail img">
                            <div class="card-body text-center">
                                <h5 class="text-uppercase"><?= $data['username']; ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-6">
                        <div class="card mt-2">
                            <div class="card-body">
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="username">Username *</label>
                                        <input type="text" name="username" id="username" class="form-control" value="<?= $data['username']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="posisi">Posisi *</label>
                                        <input type="text" name="posisi" id="posisi" class="form-control" value="<?= $data['posisi']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="telp">No Telepon *</label>
                                        <input type="text" name="telp" id="telp" class="form-control" value="<?= $data['telepon']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email *</label>
                                        <input type="text" name="email" id="email" class="form-control" value="<?= $data['email']; ?>" readonly>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>