<?php
    session_start();
    $id_pengguna=$_SESSION['id_pengguna'];
    $_SESSION['id_pengguna']='';
    $_SESSION['kode_pengguna']='';
    $_SESSION['nama_pengguna']='';
    $_SESSION['username']='';
    $_SESSION['level']='';

   

    unset($_SESSION['id_pengguna']);
    unset($_SESSION['kode_pengguna']);
    unset($_SESSION['nama_pengguna']);
    unset($_SESSION['username']);
    unset($_SESSION['level']);

    session_unset();
    session_destroy();

    header('Location:../index.php?halaman=login');

?>