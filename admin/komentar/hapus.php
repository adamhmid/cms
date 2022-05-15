<?php
session_start();
    include '../../config/database.php';

    $id_komentar=$_POST["id_komentar"];
    $gambar=$_POST["gambar"];

    $sql="delete from komentar where id_komentar=$id_komentar";
    $hapus_komentar=mysqli_query($kon,$sql);


?>