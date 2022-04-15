<?php
include "../koneksi.php";
$data = $_POST['data'];

$query = mysqli_query($koneksi, "SELECT * FROM kelas WHERE NoKelas LIKE '%$data%'");
$dataKelas = mysqli_fetch_assoc($query);
// if (mysqli_num_rows($query) > 0) {
//     echo "Ada";
// } else {
//     echo "Tidak ada";
// }
?>
<?php if (mysqli_num_rows($query) > 0) : ?>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Spesifik Kelas</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1 ?>
            <?php while ($kelas = mysqli_fetch_assoc($query)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $kelas['kelas']; ?></td>
                    <td><?= $kelas['NoKelas']; ?></td>
                    <td>
                        <a href="proses/prosesHapusKelas.php?id=<?= $kelas['id_kelas']; ?>" onclick="return confirm('Yakin Untuk Menghapus kelas?')" name="hapus" class="btn btn-danger btn-sm btn-block btnHapus">Hapus </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else : ?>
    <div class="alert alert-danger text-center">Tidak Ditemukan</div>
<?php endif; ?>