<?php
session_start();
    include '../../config/database.php';

    $id_pengguna=$_POST["id_pengguna"];
    $gambar=$_POST["gambar"];

    $sql="delete from pengguna where id_pengguna=$id_pengguna";
    $hapus_pengguna=mysqli_query($kon,$sql);


?>