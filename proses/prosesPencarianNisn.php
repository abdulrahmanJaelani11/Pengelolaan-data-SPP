<?php

include "../koneksi.php";

$nisn = $_POST['nisn'];

$query = mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn LIKE '%$nisn%'");

if (mysqli_num_rows($query) > 0) {
    echo 22;
} else {
    echo 0;
}
