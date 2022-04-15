<?php
include 'session/session_staf.php';
include "koneksi.php";
$id = $_GET['id'];
$siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas WHERE id_siswa = $id"));
$pembayaran = mysqli_query($koneksi, "SELECT * FROM pembayaran JOIN siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON jurusan.id_jurusan=siswa.id_jurusan ON siswa.id_siswa=pembayaran.id_siswa JOIN bulan ON bulan.id_bulan = pembayaran.id_bulan WHERE siswa.id_siswa = $id");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PRINT</title>
    <link rel="stylesheet" href="assets/css/sb-admin-2.min.css">
</head>

<body style="font-family: cursive;">
    <div class="container-fluid text-center">
        <div class="row mt-4">
            <div class="col">
                <h2>LAPORAN DATA ADMINISTRASI SISWA</h2>
                <h3> SMK TEKNOLOGI MANDIRI</h3>
                <h4>Nama : <?= $siswa['nama'] . ' ' . $siswa['NoKelas']; ?></h4>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Pembayaran</th>
                                <th>Nominal</th>
                                <th>Keterangan</th>
                                <th>Petugas</th>
                                <th>Tanggal transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = mysqli_fetch_assoc($pembayaran)) : ?>
                                <tr>
                                    <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['nama']; ?></td>
                                    <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['NoKelas']; ?></td>
                                    <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['jurusan']; ?></td>
                                    <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['bulan']; ?></td>
                                    <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['nominal']; ?></td>
                                    <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['keterangan']; ?></td>
                                    <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['petugas']; ?></td>
                                    <td class="<?= $data['keterangan'] == 'BELUM LUNAS' ? 'text-danger' : '' ?>"><?= $data['tgl_pembayaran']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.print()
    </script>
</body>

</html>