<?php

include "../koneksi.php";
// var_dump($_POST);

$id = $_POST['id'];

mysqli_query($koneksi, "DELETE FROM jurusan WHERE id_jurusan = $id");
if (mysqli_affected_rows($koneksi) > 0) {
    echo 1;
} else {
    echo 0;
}
