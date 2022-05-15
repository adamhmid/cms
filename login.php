<?php
$pesan="";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    
        include "config/database.php";
    
        $username = input($_POST["username"]);
        $password = input(md5($_POST["password"]));
        
        $cek_pengguna = "select * from pengguna where username='".$username."' and password='".$password."' limit 1";
        $hasil_cek = mysqli_query ($kon,$cek_pengguna);
        $jumlah = mysqli_num_rows($hasil_cek);
        $row = mysqli_fetch_assoc($hasil_cek); 

        if ($jumlah>0){
            if ($row["status"]==1){
                $_SESSION["id_pengguna"]=$row["id_pengguna"];
                $_SESSION["kode_pengguna"]=$row["kode_pengguna"];
                $_SESSION["nama_pengguna"]=$row["nama_pengguna"];
                $_SESSION["username"]=$row["username"];
                
                //Redirect ke halaman admin
                header("Location:admin/index.php?halaman=kategori");

            }else {
                    $pesan="<div class='alert alert-warning'><strong>Gagal!</strong> Status pengguna tidak aktif.</div>";
                }

        }else {
            $pesan="<div class='alert alert-danger'><strong>Error!</strong> Username dan password salah.</div>";
        }
    }      
?>

<div class="card mb-4">
  <div class="card-header">Halaman Login</div>
    <div class="card-body">
    <?php 	if ($_SERVER["REQUEST_METHOD"] == "POST") echo $pesan; ?>
    <?php 	if(isset($_GET['pesan'])){ if ($_GET["pesan"] == "login_dulu") echo "<div class='alert alert-danger'>Anda harus login dulu</div>"; }?>
        <div class="row">
     
            <div class="col-sm-5">
                <form action="index.php?halaman=login" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" name="username" placeholder="Masukan username">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukan password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>