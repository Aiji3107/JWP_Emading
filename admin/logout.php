<?php
session_start();

//unsset semua session seua variable
unset($_SESSION['username']);
unset($_SESSION['id_users']);

//unset all
session_unset();

//Destroy Session
session_destroy();

//Arahkan ke halaman login
header('location: ../login.php?pesan=logout');
?>