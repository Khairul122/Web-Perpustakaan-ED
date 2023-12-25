<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
            Data Pengajuan KP
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
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Pengajuan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Data Anggota</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahaiswa</th>
                                    <th>Judul</th>
                                    <th>Link Berkas</th>

                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            include "../../config/koneksi.php";

                            $no = 1;
                            $kode_dosen = $_SESSION['kode_user']; // Ambil kode_dosen dari session
                            $query = mysqli_query($koneksi, "SELECT * FROM pengajuan_kp WHERE kode_dosen = '$kode_dosen'");
                            while ($row = mysqli_fetch_assoc($query)) {
                            ?>
                                <tbody>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $row['nama_mahasiswa']; ?></td>
                                        <td><?= $row['judul']; ?></td>
                                        <td><?= $row['link_berkas']; ?></td>
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
                                            <a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEditData<?php echo $row['id_kp']; ?>"><i class="fa fa-edit"></i></a>
                                            
                                        </td>
                                    </tr>
                                    <!-- Modal Edit Anggota -->
                                    <div class="modal fade" id="modalEditData<?php echo $row['id_kp']; ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content" style="border-radius: 5px;">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">
                                                        Edit Data ( <?= $row['nama_mahasiswa']; ?> - <?= $row['judul']; ?> )
                                                    </h4>
                                                </div>
                                                <form action="pages/function/PengajuanKP.php?aksi=edit" enctype="multipart/form-data" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" value="<?= $row['id_kp']; ?>" name="id_kp">
                                                        <div class="form-group">
                                                            <label>Nama Mahasiswa <small style="color: red;">* Otomatis Terisi ( Tidak dapat diubah )</small></label>
                                                            <input type="text" class="form-control" value="<?= $row['nama_mahasiswa'] ?>" name="nama_mahasiswa" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Judul </label>
                                                            <input type="text" class="form-control" value="<?= $row['judul']; ?>" name="judul" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Link Berkas</label>
                                                            <input type="text" class="form-control" value="<?= $row['link_berkas']; ?>" name="link_berkas" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status Pengajuan</label>
                                                            <select class="form-control" name="status_pengajuan">

                                                                <option value="1">ACC</option>
                                                                <option value="2">Tolak</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                                        </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /. Modal Edit Anggota-->
                                </tbody>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<div class="modal fade" id="modalTambahAnggota">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 5px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" style="font-family: 'Quicksand', sans-serif; font-weight: bold;">Tambah Anggota</h4>
            </div>
            <form action="pages/function/Anggota.php?aksi=tambah" enctype="multipart/form-data" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Anggota <small style="color: red;">* Otomatis Terisi</small></label>
                        <?php
                        include "../../config/koneksi.php";

                        $query = mysqli_query($koneksi, "SELECT max(kode_user) as kodeTerakhir FROM user");
                        $data = mysqli_fetch_array($query);
                        $kodeTerakhir = $data['kodeTerakhir'];

                        // mengambil angka dari kode barang terbesar, menggunakan fungsi substr
                        // dan diubah ke integer dengan (int)
                        $urutan = (int) substr($kodeTerakhir, 3, 3);

                        // bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
                        $urutan++;

                        // membentuk kode barang baru
                        // perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
                        // misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
                        // angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
                        $huruf = "AP";
                        $Anggota = $huruf . sprintf("%03s", $urutan);
                        ?>
                        <input type="text" class="form-control" value="<?php echo $Anggota ?>" name="kodeAnggota" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nomor Induk Siswa <small style="color: red;">* Wajib diisi</small></label>
                        <input type="number" class="form-control" placeholder="Masukan NIS" name="nis" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Lengkap" name="namaLengkap" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Pengguna <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Nama Pengguna" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Kata Sandi <small style="color: red;">* Wajib diisi</small></label>
                        <input type="text" class="form-control" placeholder="Masukan Kata Sandi" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas <small style="color: red;">* Wajib diisi</small></label>
                        <select class="form-control" name="kelas">
                            <option disabled selected>-- Harap Pilih Kelas --</option>
                            <!-- X -->
                            <option value="X - Administrasi Perkantoran">X - Administrasi Perkantoran</option>
                            <option value="X - Farmasi">X - Farmasi</option>
                            <option value="X - Perbankan">X - Perbankan</option>
                            <option value="X - Rekayasa Perangkat Lunak">X - Rekayasa Perangkat Lunak</option>
                            <option value="X - Tata Boga">X - Tata Boga</option>
                            <option value="X - Teknik Kendaraan Ringan">X - Teknik Kendaraan Ringan</option>
                            <option value="X - Teknik Komputer dan Jaringan">X - Teknik Komputer dan Jaringan</option>
                            <option value="X - Teknik Sepeda Motor">X - Teknik Sepeda Motor</option>
                            <!-- XI -->
                            <option disabled>------------------------------------------</option>
                            <option value="XI - Administrasi Perkantoran">XI - Administrasi Perkantoran</option>
                            <option value="XI - Farmasi">XI - Farmasi</option>
                            <option value="XI - Perbankan">XI - Perbankan</option>
                            <option value="XI - Rekayasa Perangkat Lunak">XI - Rekayasa Perangkat Lunak</option>
                            <option value="XI - Tata Boga">XI - Tata Boga</option>
                            <option value="XI - Teknik Kendaraan Ringan">XI - Teknik Kendaraan Ringan</option>
                            <option value="XI - Teknik Komputer dan Jaringan">XI - Teknik Komputer dan Jaringan</option>
                            <option value="XI - Teknik Sepeda Motor">XI - Teknik Sepeda Motor</option>
                            <!-- XI -->
                            <option disabled>------------------------------------------</option>
                            <option value="XII - Administrasi Perkantoran">XII - Administrasi Perkantoran</option>
                            <option value="XII - Farmasi">XII - Farmasi</option>
                            <option value="XII - Perbankan">XII - Perbankan</option>
                            <option value="XII - Rekayasa Perangkat Lunak">XII - Rekayasa Perangkat Lunak</option>
                            <option value="XII - Tata Boga">XII - Tata Boga</option>
                            <option value="XII - Teknik Kendaraan Ringan">XII - Teknik Kendaraan Ringan</option>
                            <option value="XII - Teknik Komputer dan Jaringan">XII - Teknik Komputer dan Jaringan</option>
                            <option value="XII - Teknik Sepeda Motor">XII - Teknik Sepeda Motor</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Alamat <small style="color: red;">* Wajib diisi</small></label>
                        <textarea class="form-control" style="resize: none; height: 70px;" name="alamat" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    function tambahAnggota() {
        $('#modalTambahAnggota').modal('show');
    }
</script>
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
                text: 'Apakah anda yakin ingin menghapus data anggota ini ?',
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
                        text: 'Data anggota tersebut aman !'
                    })
                }
            });
    })
</script>