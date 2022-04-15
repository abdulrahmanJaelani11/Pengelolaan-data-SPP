<?php
include "koneksi.php";
$id = $_GET['id'];
$query_kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
$query_jurusan = mysqli_query($koneksi, "SELECT * FROM jurusan");
$result = mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan WHERE id_siswa = $id");
$data = mysqli_fetch_assoc($result);
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];

    mysqli_query($koneksi, "UPDATE siswa SET nama = '$nama', nisn = '$nisn', id_kelas = '$kelas', id_jurusan = '$jurusan'");
    if (mysqli_affected_rows($koneksi)) {
        $sukses = "Berhasil Mengupdate Data";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Siswa</title>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
    <script src="assets/js/jquery.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="beranda.php">STEKMAN-PAY</a>
            <button class="navbar-toggler" type="button" id="btn" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="beranda.php">Beranda</a>
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

    <div class="container-fluid mt-3">
        <div class="row justify-content-center">
            <div class="col-5">
                <div class="card shadow">
                    <div class="card-header">
                        <h2 class="text-center text-dark">Form Tambah Siswa</h2>
                    </div>
                    <div class="card-body">
                        <?php if (isset($sukses)) : ?>
                            <div class="alert alert-success">
                                <?= $sukses; ?>
                            </div>
                        <?php endif; ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="nama">Nama *</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama Siswa" required value="<?= $data['nama']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="nisn">NISN *</label>
                                <input type="text" name="nisn" id="nisn" class="form-control" placeholder="Masukan nisn Siswa" required value="<?= $data['nisn']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas *</label>
                                <select name="kelas" id="kelas" class="form-control" required>
                                    <option value="<?= $data['id_kelas']; ?>"><?= $data['NoKelas']; ?></option>
                                    <?php while ($kelas = mysqli_fetch_assoc($query_kelas)) : ?>
                                        <option value="<?= $kelas['id_kelas']; ?>"><?= $kelas['NoKelas']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="jurusan">Jurusan *</label>
                                <select name="jurusan" id="jurusan" class="form-control" required>
                                    <option value="<?= $data['id_jurusan']; ?>"><?= $data['jurusan']; ?></option>
                                    <?php while ($jurusan = mysqli_fetch_assoc($query_jurusan)) : ?>
                                        <option value="<?= $jurusan['id_jurusan']; ?>"><?= $jurusan['jurusan']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="update" class="btn btn-primary btn-block"> Simpan </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>