<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
           Pengajuan Judul KP
            <small>
                <script type='text/javascript'>
                    var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                    var date = new Date();
                    var day = date.getDate();
                    var month = date.getMonth();
                    var thisDay = date.getDay(),
                        thisDay = myDays[thisDay];
                    var yy = date.getYear();
                    var year = (yy < 1000) ? yy + 1900 : yy;
                    document.write(thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
                    //
                </script>
            </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Pengajuan Judul KP</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tgl-pinjam" data-toggle="tab">Formulir Pengajuan Judul</a></li>
                        <li><a href="#tgl-pengembalian" data-toggle="tab">Riwayat Pengajuan Judul</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- Font Awesome Icons -->
                        <div class="tab-pane active" id="tgl-pinjam">
                            <section id="new">
                                <form action="pages/function/PengajuanKP.php?aksi=pengajuan" method="POST">
                                    <?php
                                    include "../../config/koneksi.php";
                                    $id_user = $_SESSION['id_user'];
                                    $query_fullname = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'");
                                    $row1 = mysqli_fetch_array($query_fullname);
                                    ?>
                                    <div class="form-group">
                                        <label>Nama Anggota</label>
                                        <input type="text" class="form-control" name="nama_mahasiswa" value="<?= $row1['fullname']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" name="judul">
                                    </div>
                                    <div class="form-group">
                                        <label>Link Berkas</label>
                                        <input type="text" class="form-control" name="link_berkas">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Dosen</label>
                                        <select class="form-control" name="kode_dosen">
                                            <?php
                                            $result = mysqli_query($koneksi, "SELECT * FROM user WHERE role = 'Dosen' AND kode_user LIKE 'D%'");
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $row['kode_user'] . "'>" . $row['fullname'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                                    </div>
                                </form>
                            </section>
                        </div>

                        <!-- Tanggal Pengembalian -->
                        <div class="tab-pane" id="tgl-pengembalian">
                            <table class="table table-bordered" id="example1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mahaiswa</th>
                                        <th>Judul</th>
                                        <th>Link Berkas</th>
                                        <th>Dosen Pembimbing</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <?php
                                include "../../config/koneksi.php";

                                $no = 1;
                                $fullname = $_SESSION['fullname'];
                                $query = mysqli_query($koneksi, "SELECT * FROM pengajuan_kp WHERE nama_mahasiswa = '$fullname'");
                                while ($row = mysqli_fetch_assoc($query)) {
                                ?>
                                    <tbody>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['nama_mahasiswa']; ?></td>
                                            <td><?= $row['judul']; ?></td>
                                            <td><?= $row['link_berkas']; ?></td>
                                            <td><?= $row['nama_dosen']; ?></td>
                                            <td>
                                                <?php
                                                if ($row['status_pengajuan'] == 0) {
                                                    echo "Berkas belum diverifikasi";
                                                } else if ($row['status_pengajuan'] == 1) {
                                                    echo "Di ACC";
                                                } else {
                                                    echo "Di Tolak";
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="pages/function/Pengajuan.php?aksi=hapus&id_pengajuan=<?= $row['id_pengajuan']; ?>" class="btn btn-danger btn-sm btn-del">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                        <!-- /#tgl-pengembalian] -->

                        <!-- /.tab-content -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- jQuery 3 -->
<script src="../../assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/dist/js/sweetalert.min.js"></script>
<!-- Pesan Berhasil Edit -->
<script>
    <?php
    if (isset($_SESSION['berhasil']) && $_SESSION['berhasil'] <> '') {
        echo "swal({
            icon: 'success',
            title: 'Berhasil',
            text: '$_SESSION[berhasil]'
        })";
    }
    $_SESSION['berhasil'] = '';
    ?>
</script>
<!-- Pesan Gagal Edit -->
<script>
    <?php
    if (isset($_SESSION['gagal']) && $_SESSION['gagal'] <> '') {
        echo "swal({
                icon: 'error',
                title: 'Gagal',
                text: '$_SESSION[gagal]'
              })";
    }
    $_SESSION['gagal'] = '';
    ?>
</script>
<!-- Swal Hapus Data -->
<script>
    $('.btn-del').on('click', function(e) {
        e.preventDefault();
        const href = $(this).attr('href')

        swal({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Apakah anda yakin ingin menghapus data administrator ini ?',
                buttons: true,
                dangerMode: true,
                buttons: ['Tidak, Batalkan !', 'Iya, Hapus']
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.location.href = href;
                } else {
                    swal({
                        icon: 'error',
                        title: 'Dibatalkan',
                        text: 'Data administrator tersebut tetap aman !'
                    })
                }
            });
    })
</script>