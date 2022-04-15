<?php
session_start();
if (isset($_SESSION['nisn'])) {
    session_unset();
    session_destroy();
    header("location: index.php");
} elseif (isset($_SESSION['username'])) {
    session_unset();
    session_destroy();

    header("location: index.php");
}
