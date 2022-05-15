
<?php
    // mengambil data barang dengan kode paling besar
    include '../../config/database.php';
    $query = mysqli_query($kon, "SELECT max(id_pengguna) as kodeTerbesar FROM pengguna");
    $data = mysqli_fetch_array($query);
    $id_pengguna = $data['kodeTerbesar'];
    $id_pengguna++;
    $huruf = "U";
    $kodepengguna = $huruf . sprintf("%03s", $id_pengguna);
?>
    <form action="admin/tambah.php" method="post">
        <div class="form-group">
            <label>Kode pengguna:</label>
            <h3><?php echo $kodepengguna; ?></h3>
            <input name="kode_pengguna" value="<?php echo $kodepengguna; ?>" type="hidden" class="form-control">
        </div>
        <div class="form-group">
            <label>Nama pengguna:</label>
            <input name="nama_pengguna" type="text" class="form-control" placeholder="Masukan nama" required>
        </div>

        <div class="row">
            <div class="col-sm-6">
            <div class="form-group">
                    <label>Email:</label>
                    <input name="email" type="email" class="form-control" placeholder="Masukan email" required>
            </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>No Telp:</label>
                    <input name="no_telp" type="text" class="form-control" placeholder="Masukan no telp" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Username:</label>
                    <input name="username" type="text" class="form-control" placeholder="Masukan username" required>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Password:</label>
                    <input name="password" type="password" class="form-control" placeholder="Masukan password" required>
                </div>
            </div>
        </div>


        <div class="row">
 
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Status:</label>
                    <select name="status" class="form-control">
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>


        <button type="submit" name="simpan_tambah" class="btn btn-dark">Tambah</button>
    </form>

<?php
    if (isset($_POST['simpan_tambah'])) {
        //Include file koneksi, untuk koneksikan ke database
        include '../../config/database.php';
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    
        $kode_pengguna=input($_POST["kode_pengguna"]);
        $nama_pengguna=input($_POST["nama_pengguna"]);
        $email=input($_POST["email"]);
        $no_telp=input($_POST["no_telp"]);
        $username=input($_POST["username"]);
        $password=md5(input($_POST["password"]));
        $status=input($_POST["status"]);


        //Query input menginput data kedalam tabel 
        $sql="insert into pengguna (kode_pengguna,nama_pengguna,email,no_telp,username,password,status) values
        ('$kode_pengguna','$nama_pengguna','$email','$no_telp','$username','$password','$status')";
        //Mengeksekusi/menjalankan query 
        $hasil=mysqli_query($kon,$sql);
     
   

        //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
        if ($hasil) {
            header("Location:../index.php?halaman=admin&tambah=berhasil");
        }
        else {
            header("Location:../index.php?halaman=admin&tambah=gagal");

        }
        
    }
?>