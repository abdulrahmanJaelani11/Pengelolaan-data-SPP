<?php
session_start();
include "../koneksi.php";

// AMBIL DATA USER 
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id =" . $_SESSION['id']));

// AMBIL KELAS
$query = mysqli_query($koneksi, "SELECT * FROM kelas");
?>
<div class="table-responsive">
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Spesifik Kelas</th>
                <?php if ($user['posisi'] == 'admin') : ?>
                    <th width="150">Opsi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php while ($kelas = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $kelas['kelas']; ?></td>
                    <td><?= $kelas['NoKelas']; ?></td>
                    <?php if ($user['posisi'] == 'admin') : ?>
                        <td>
                            <a href="proses/prosesHapusKelas.php?id=<?= $kelas['id_kelas']; ?>" onclick="return confirm('Yakin Untuk Menghapus kelas?')" class="btn btn-sm btn-danger btn-block btnHapus">Hapus</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>