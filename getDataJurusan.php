<?php
session_start();
include "koneksi.php";
// AMBIL DATA USER 
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id =" . $_SESSION['id']));
// AMBIL DATA JURUSAN
$query = mysqli_query($koneksi, "SELECT * FROM jurusan");
?>

<div class="table-resposive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Jurusan</th>
                <?php if ($user['posisi'] == 'admin') : ?>
                    <th>Opsi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php while ($jurusan = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $jurusan['jurusan']; ?></td>
                    <?php if ($user['posisi'] == 'admin') : ?>
                        <td>
                            <form action="proses/prosesHapusJurusan.php" method="post" id="hapusJurusan">
                                <input type="hidden" name="id" class="id_jurusan" value="<?= $jurusan['id_jurusan']; ?>">
                                <button type="submit" name="hapus" class="btn hapus btn-danger btn-sm btn-block"> Hapus </button>
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>