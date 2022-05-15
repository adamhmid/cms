
<div class="card mb-4">
    <div class="card-header">
        <h4>Daftar Komentar</h4>
    </div>
    <div class="card-body">
    <?php
    if (isset($_GET['tambah'])) {
        //Mengecek nilai variabel tambah 
        if ($_GET['tambah']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> komentar telah di tambahkan!</div>";
        }else if ($_GET['tambah']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> komentar gagal di tambahkan!</div>";
        }    
    }
    if (isset($_GET['edit'])) {
        //Mengecek nilai variabel edit 
        if ($_GET['edit']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> komentar telah di edit!</div>";
        }else if ($_GET['edit']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> komentar gagal di edit!</div>";
        }    
      }
    if (isset($_GET['hapus'])) {
        //Mengecek nilai variabel hapus 
        if ($_GET['hapus']=='berhasil'){
            echo"<div class='alert alert-success'><strong>Berhasil!</strong> komentar telah di hapus!</div>";
        }else if ($_GET['hapus']=='gagal'){
            echo"<div class='alert alert-danger'><strong>Gagal!</strong> komentar gagal di hapus!</div>";
        }    
    }
    ?>
       <!-- Tabel daftar komentar -->
       <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Artikel</th>
                    <th>Isi Komentar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        // include database
                        include '../config/database.php';
                        // perintah sql untuk menampilkan daftar komentar
                        $sql="select * from komentar k inner join artikel a on a.id_artikel=k.id_artikel order by id_komentar desc";
                        $hasil=mysqli_query($kon,$sql);
                        $no=0;
                        //Menampilkan data dengan perulangan while
                        while ($data = mysqli_fetch_array($hasil)):
                        $no++;
                    ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['email']; ?></td>
                        <td><?php echo $data['judul_artikel']; ?></td>
                        <td><?php echo $data['isi_komentar']; ?></td>
                        <td><?php echo $data['status_komentar'] == 1 ? "<span class='text-success'>Publish</span>" : "<span class='text-danger'>Tidak Dipublish</span>"; ?> </td>
                        <td>
                            <button class="btn-edit btn btn-warning btn-circle" id_komentar="<?php echo $data['id_komentar']; ?>"  >Edit</button>
                            <button class="btn-hapus btn btn-danger btn-circle"  id_komentar="<?php echo $data['id_komentar']; ?>" >Hapus</button>
                        </td>
                    </tr>
                    <!-- bagian akhir (penutup) while -->
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
     
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

        <!-- Bagian header -->
        <div class="modal-header">
            <h4 class="modal-title" id="judul"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Bagian body -->
        <div class="modal-body">
            <div id="tampil_data">

            </div>  
        </div>
        <!-- Bagian footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
</div>
<script>
       
    // fungsi edit komentar
    $('.btn-edit').on('click',function(){

        var id_komentar = $(this).attr("id_komentar");
    
        $.ajax({
            url: 'komentar/edit.php',
            method: 'post',
            data: {id_komentar:id_komentar},
            success:function(data){
                $('#tampil_data').html(data);  
                document.getElementById("judul").innerHTML='Edit komentar #'+id_komentar;
            }
        });
        // Membuka modal
        $('#modal').modal('show');
    });




    // fungsi hapus komentar
    $('.btn-hapus').on('click',function(){

        var id_komentar = $(this).attr("id_komentar");

        konfirmasi=confirm("Yakin ingin menghapus?")

        if (konfirmasi){
            $.ajax({
                url: 'komentar/hapus.php',
                method: 'post',
                data: {id_komentar:id_komentar},
                success:function(data){
                    window.location.href = 'index.php?halaman=komentar&hapus=berhasil';
                }
            });
        }
});

</script>