<?php

    if (isset($_POST['tambah_kategori'])) {
   
        
        //Fungsi untuk mencegah inputan karakter yang tidak sesuai
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //Cek apakah ada kiriman form dari method post
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            include '../../config/database.php';
        
            $nama_kategori=input($_POST["nama_kategori"]);

            $ekstensi_diperbolehkan	= array('png','jpg','gif','jpeg');
            $gambar_kategori = $_FILES['gambar_kategori']['name'];
            $x = explode('.', $gambar_kategori);
            $ekstensi = strtolower(end($x));
            $ukuran	= $_FILES['gambar_kategori']['size'];
            $file_tmp = $_FILES['gambar_kategori']['tmp_name'];	

            if (!empty($gambar_kategori)){

                if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){

                    //Mengupload gambar
                    move_uploaded_file($file_tmp, 'gambar_kategori/'.$gambar_kategori);

                    $sql="insert into kategori (nama_kategori,gambar_kategori) values
                    ('$nama_kategori','$gambar_kategori')"; 
                   
                }
            }else {
                $sql="insert into kategori (nama_kategori) values
                ('$nama_kategori')";
            }


            //Mengeksekusi/menjalankan query 
            $simpan_kategori=mysqli_query($kon,$sql);
            //Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
            if ($simpan_kategori) {
                header("Location:../index.php?halaman=kategori&tambah=berhasil");
            }
            else {
                header("Location:../index.php?halaman=kategori&tambah=gagal");
            }

        }

    }

?>
<form action="artikel/tambah-kategori.php" method="post" enctype="multipart/form-data">
    <!-- rows -->
    <div class="row">
        <div class="col-sm-10">
            <div class="form-group">
                <label>Nama kategori:</label>
                <input name="nama_kategori" type="text" class="form-control" placeholder="Masukan Nama kategori" required>
            </div>
        </div>
    </div>

      <!-- rows -->   
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <div id="msg"></div>
                <label>Gambar kategori:</label>
                <input type="file" name="gambar_kategori" class="file" >
                    <div class="input-group my-3">
                        <input type="text" class="form-control" disabled placeholder="Upload Gambar" id="file">
                        <div class="input-group-append">
                                <button type="button" id="pilih_logo" class="browse btn btn-dark">Pilih Gambar</button>
                        </div>
                    </div>
                <img src="gambar_default.png" id="preview" class="img-thumbnail">
            </div>
        </div>
    </div>

        <button type="submit" name="tambah_kategori" class="btn btn-dark">Tambah</button>
</form>
<style>
    .file {
    visibility: hidden;
    position: absolute;
    }
</style>
<script>
    $(document).on("click", "#pilih_logo", function() {
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
