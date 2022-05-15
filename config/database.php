<?php
    $host="sql304.byethost4.com";
    $user="b4_30415057";
    $password="adam5961";
    $db="b4_30415057_project_website_dinamis_adam";
    
    $kon = mysqli_connect($host,$user,$password,$db);
    if (!$kon){
          die("Koneksi gagal:".mysqli_connect_error());
    }
?>