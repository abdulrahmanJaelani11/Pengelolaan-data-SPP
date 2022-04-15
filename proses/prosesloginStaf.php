<?php
session_start();
include "../koneksi.php";
$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
$data = mysqli_fetch_assoc($query);
if (mysqli_num_rows($query) > 0) {
    if (password_verify($password, $data['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['id'] = $data['id'];
        $_SESSION['username'] = $username;
        echo 1;
    } else {
        echo 0.1;
    }
} else {
    echo 0;
}
