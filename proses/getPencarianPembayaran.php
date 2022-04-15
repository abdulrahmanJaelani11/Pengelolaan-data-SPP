<?php
include "../koneksi.php";

$id_bulan = $_POST['id_pembayaran'];
$id_siswa = $_POST['id_siswa'];


$query = mysqli_query($koneksi, "SELECT * FROM pembayaran WHERE id_bulan = $id_bulan && id_siswa = $id_siswa");

if (mysqli_num_rows($query) > 0) {
    echo "ada";
} else {
    echo "null";
}






// if (mysqli_num_rows($query_siswa) > 0) {
//     if (mysqli_num_rows($query_bulan) > 0) {
//         echo "Ada";
//     }
// } else {
//     echo "TidakAda";
// }
