<?php
include "koneksi.php";
$inputan = $_POST['input'];

// AMBIL DATA SISWA
$query = mysqli_query($koneksi, "SELECT * FROM siswa JOIN kelas ON kelas.id_kelas=siswa.id_kelas JOIN jurusan ON 
jurusan.id_jurusan=siswa.id_jurusan WHERE nama LIKE '%$inputan%' OR nisn LIKE '%$inputan%' OR kelas LIKE '%$inputan%' OR NoKelas LIKE '%$inputan%' OR jurusan LIKE '%$inputan%' ");


?>
<?php if (mysqli_affected_rows($koneksi) > 0) : ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php while ($siswa = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $siswa['nama']; ?></td>
                    <td><?= $siswa['nisn']; ?></td>
                    <td><?= $siswa['NoKelas']; ?></td>
                    <td><?= $siswa['jurusan']; ?></td>
                    <td>
                        <a href="detailSiswa.php?id=<?= $siswa['id_siswa']; ?>" class="btn btn-sm btn-block btn-info">Detail</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else : ?>
    <h3 class="mt-4 text-center text-danger">Data Tidak Ditemukan</h3>
<?php endif; ?>