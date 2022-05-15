
<?php
session_start();

        //Include file koneksi, untuk koneksikan ke database
        if (isset($_POST['publish']) || isset($_POST['simpan_konsep'])) {
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (isset($_POST['publish'])) {
                $status=1;
            }else {
                $status=0;
            }
            //Include database
            include '../../config/database.php';

            $kode_artikel=input($_POST["kode_artikel"]);
            $judul_artikel=input($_POST["judul_artikel"]);
            $kategori=input($_POST["kategori"]);
            $isi_artikel=input($_POST["isi_artikel"]);
            $tanggal=date("Y-m-d H:i:s");
            $ekstensi_diperbolehkan	= array('png','jpg');
            $gambar = $_FILES['gambar']['name'];
            $x = explode('.', $gambar);
            $ekstensi = strtolower(end($x));
            //$ukuran	= $_FILES['gambar']['size'];
            $file_tmp = $_FILES['gambar']['tmp_name'];
            $id_pengguna = 0;

            if (!empty($gambar)){
                if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
                    //Mengupload gambar
                    move_uploaded_file($file_tmp, 'gambar/'.$gambar);

                    //Menambah artikel dengan gambar
                    $sql="insert into artikel (kode_artikel,judul_artikel,isi_artikel,gambar,tanggal,status,id_kategori,id_pengguna) values
                    ('$kode_artikel','$judul_artikel','$isi_artikel','$gambar','$tanggal','$status','$kategori', '$id_pengguna')";
                }    
                
            }else {
                    //Menambah artikel tanpa gambar, maka gambar_defauilt.png yang akan digunakan
                    $sql="insert into artikel (kode_artikel,judul_artikel,isi_artikel,tanggal,status,id_kategori,id_pengguna) values
                    ('$kode_artikel','$judul_artikel','$isi_artikel','$tanggal','$status','$kategori','$id_pengguna')";
                     
            }

            //Mengeksekusi/menjalankan query 
            $simpan_artikel=mysqli_query($kon,$sql);

            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($simpan_artikel) {
                header("Location:../index.php?halaman=artikel&kategori=$kategori&add=berhasil");
            }
            else {
                header("Location:../index.php?halaman=artikel&kategori=$kategori&add=gagal");
                
            } 

        }
    }

      // mengambil data produk dengan kode paling besar
      include '../../config/database.php';
      $query = mysqli_query($kon, "SELECT max(id_artikel) as kodeTerbesar FROM artikel");
      $data = mysqli_fetch_array($query);
      $id_artikel = $data['kodeTerbesar'];
      $id_artikel++;
      $huruf = "A";
      $kodeartikel = $huruf . sprintf("%04s", $id_artikel);

?>
<form action="artikel/tambah-artikel.php" method="post" enctype="multipart/form-data">
    <!-- rows -->
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Kode:</label>
                <h3><?php echo $kodeartikel; ?></h3>
                <input name="kode_artikel" value="<?php echo $kodeartikel; ?>" type="hidden" class="form-control">
            </div>
        </div>
    </div>
    <!-- rows -->
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Judul Artikel:</label>
                <input name="judul_artikel" type="text" class="form-control" placeholder="Masukan nama artikel" required>
            </div>
        </div>
    </div>
    <!-- rows -->   
    <div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Isi Artikel:</label>
            <textarea name="isi_artikel" class="form-control"  rows="5" ></textarea>
        </div>
    </div>
    </div>
    <!-- rows -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div id="msg"></div>
                <label>Gambar:</label>
                <input type="file" name="gambar" class="file" >
                    <div class="input-group my-3">
                        <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                        <div class="input-group-append">
                                <button type="button" id="pilih_gambar" class="browse btn btn-dark">Pilih Gambar</button>
                        </div>
                    </div>
                <img src="gambar_default.png" id="preview" class="img-thumbnail">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label>Kategori:</label>
                <select name="kategori" class="form-control">
                <?php
                    echo $id_kategori=$_POST['kategori'];
                    include '../../config/database.php';
                    $sql="select * from kategori where id_kategori='$id_kategori' limit 1";
                    $hasil=mysqli_query($kon,$sql);
                    while ($data = mysqli_fetch_array($hasil)):
                ?>
                    <option value="<?php echo $data['id_kategori']; ?>"><?php echo $data['nama_kategori']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
    </div>

    <!-- rows -->   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <button type="submit" name="publish" class="btn btn-success">Publish</button>
                <button type="submit" name="simpan_konsep" class="btn btn-warning">Simpan Konsep</button>
            </div>
    
        </div>
   
    </div>   
</form>
<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>
<script>
    $(document).on("click", "#pilih_gambar", function() {
    var file = $(this).parents().find(".file");
    file.trigger("click");
    });
    $('input[type="file"]').change(function(e) {
    var fileName = e.target.files[0].name;
    $("#file").val(fileName);

    var reader = new FileReader();
    reader.onload = function(e) {
        // get loaded data and render thumbnail.
        document.getElementById("preview").src = e.target.result;
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    });
</script>
