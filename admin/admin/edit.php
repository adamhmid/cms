
<?php
    $id_pengguna=$_POST["id_pengguna"];
    // mengambil data barang dengan kode paling besar
    include '../../config/database.php';
    $query = mysqli_query($kon, "SELECT * FROM pengguna where id_pengguna=$id_pengguna");
    $data = mysqli_fetch_array($query); 

    $kode_pengguna=$data['kode_pengguna'];
    $nama_pengguna=$data['nama_pengguna'];
    $email=$data['email'];
    $no_telp=$data['no_telp'];
    $username=$data['username'];
    $password=$data['password'];
    $status=$data['status'];
?>
    <form action="admin/edit.php" method="post">
    <div class="form-group">
            <label>Kode pengguna:</label>
            <h3><?php echo $kode_pengguna; ?></h3>
            <input name="id_pengguna" value="<?php echo $id_pengguna; ?>" type="hidden" class="form-control">
        </div>
        <div class="form-group">
            <label>Nama pengguna:</label>
            <input name="nama_pengguna" value="<?php echo $nama_pengguna; ?>" type="text" class="form-control" placeholder="Masukan nama" required>
        </div>

        <div class="row">
            <div class="col-sm-6">
            <div class="form-group">
                    <label>Email:</label>
                    <input name="email" value="<?php echo $email; ?>" type="email" class="form-control" placeholder="Masukan email" required>
            </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>No Telp:</label>
                    <input name="no_telp" value="<?php echo $no_telp; ?>" type="text" class="form-control" placeholder="Masukan no telp" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Username:</label>
                    <input name="username" value="<?php echo $username; ?>" type="text" class="form-control" placeholder="Masukan username" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Password:</label>
                    <input name="password" value="<?php echo $password; ?>" type="password" class="form-control" placeholder="Masukan password" required>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" class="form-control">
                        <option <?php if ($status==1) echo "selected"; ?> value="1">Aktif</option>
                       <option <?php if ($status==0) echo "selected"; ?> value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>


        <button type="submit" name="simpan_edit" class="btn btn-dark">Update Pengguna</button>
    </form>

<?php
    if (isset($_POST['simpan_edit'])) {
        //Include file koneksi, untuk koneksikan ke database
        include '../../config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        $id_pengguna=input($_POST["id_pengguna"]);
        $nama_pengguna=input($_POST["nama_pengguna"]);
        $email=input($_POST["email"]);
        $no_telp=input($_POST["no_telp"]);
        $username=input($_POST["username"]);
        $status=input($_POST["status"]);
 


        $ambil_password=mysqli_query($kon,"select password from pengguna where id_pengguna=$id_pengguna limit 1");
        $data = mysqli_fetch_array($ambil_password);
        
        if ($data['password']==$_POST["password"]){
            $password=input($_POST["password"]);
        }else {
            $password=md5(input($_POST["password"]));
        }

        //Query input menginput data kedalam tabel anggota
        $sql="update pengguna set
        nama_pengguna='$nama_pengguna',
        email='$email',
        no_telp='$no_telp',
        username='$username',
        password='$password',
        status='$status'
        where id_pengguna=$id_pengguna";

        //Mengeksekusi/menjalankan query 
        $hasil=mysqli_query($kon,$sql);


        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:../index.php?halaman=admin&edit=berhasil");
        }
        else {
            header("Location:../index.php?halaman=admin&edit=gagal");;

        }
        
    }
    ?>