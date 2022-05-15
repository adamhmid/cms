<?php
    include '../../config/database.php';
    $nama_website=$_POST["nama_website"];
    $sql="update profil set nama_website='$nama_website'"; 
    mysqli_query($kon,$sql);

?>