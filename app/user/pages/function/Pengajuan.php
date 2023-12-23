<?php
session_start();

include "../../../../config/koneksi.php";

if ($_GET['aksi'] == "pengajuan") {
    // Pastikan parameter POST yang dibutuhkan telah diset
    if (isset($_POST['nama_mahasiswa']) && isset($_POST['judul']) && isset($_POST['link_berkas']) && isset($_POST['kode_dosen'])) {
        // Tangkap data dari formulir atau sumber lainnya
        $nama_mahasiswa = $_POST['nama_mahasiswa'];
        $judul = $_POST['judul'];
        $link_berkas = $_POST['link_berkas'];
        $kode_dosen = $_POST['kode_dosen'];

        // Retrieve fullname of the selected Dosen based on the provided kode_user
        $result_dosen = mysqli_query($koneksi, "SELECT fullname FROM user WHERE kode_user = '$kode_dosen' AND role = 'Dosen'");
        $row_dosen = mysqli_fetch_assoc($result_dosen);
        $nama_dosen = $row_dosen['fullname'];

        $id_user = $_SESSION['id_user'];

        // Insert data into the pengajuan table, including the fullname of Dosen and setting status_pengajuan to 0
        $query = "INSERT INTO pengajuan (id_mahasiswa, kode_dosen, nama_dosen, nama_mahasiswa, judul, link_berkas, status_pengajuan) VALUES ('$id_user', '$kode_dosen', '$nama_dosen', '$nama_mahasiswa', '$judul', '$link_berkas', 0)";

        $result = mysqli_query($koneksi, $query);

        if ($result) {
            // Menggunakan JavaScript untuk menampilkan alert
            echo '<script>alert("Data berhasil disimpan.");';
            // Menggunakan JavaScript untuk melakukan pengalihan ke halaman tertentu
            echo 'window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
        } else {
            // Menggunakan JavaScript untuk menampilkan alert
            echo '<script>alert("Gagal menyimpan data: ' . mysqli_error($koneksi) . '");</script>';
        }
    } else {
        // Menggunakan JavaScript untuk menampilkan alert
        echo '<script>alert("Parameter POST tidak lengkap.");</script>';
    }
} else if ($_GET['aksi'] == "edit") {
    // Pastikan parameter POST yang dibutuhkan telah diset
    if (isset($_POST['id_pengajuan']) && isset($_POST['nama_mahasiswa']) && isset($_POST['judul']) && isset($_POST['link_berkas']) && isset($_POST['status_pengajuan'])) {
        // Tangkap data dari formulir atau sumber lainnya
        $id_pengajuan = $_POST['id_pengajuan'];
        $nama_mahasiswa = $_POST['nama_mahasiswa'];
        $judul = $_POST['judul'];
        $link_berkas = $_POST['link_berkas'];
        $status_pengajuan = $_POST['status_pengajuan'];

        // Update data in the pengajuan table based on id_pengajuan
        $query = "UPDATE pengajuan SET nama_mahasiswa = '$nama_mahasiswa', judul = '$judul', link_berkas = '$link_berkas', status_pengajuan = '$status_pengajuan' WHERE id_pengajuan = '$id_pengajuan'";

        $result = mysqli_query($koneksi, $query);

        if ($result) {
            // Menggunakan JavaScript untuk menampilkan alert
            echo '<script>alert("Data berhasil disimpan.");';
            // Menggunakan JavaScript untuk melakukan pengalihan ke halaman tertentu
            echo 'window.location.href="' . $_SERVER['HTTP_REFERER'] . '";</script>';
        } else {
            // Menggunakan JavaScript untuk menampilkan alert
            echo '<script>alert("Gagal menyimpan data: ' . mysqli_error($koneksi) . '");</script>';
        }
    } else {
        // Menggunakan JavaScript untuk menampilkan alert
        echo '<script>alert("Parameter POST tidak lengkap.");</script>';
    }
}
 elseif ($_GET['aksi'] == "pengembalian") {

    include "Pemberitahuan.php";

    if ($_POST['kondisiBukuSaatDikembalikan'] == "Baik") {
        $denda = "Tidak ada";
    } elseif ($_POST['kondisiBukuSaatDikembalikan'] == "Rusak") {
        $denda = "Rp 20.000";
    } elseif ($_POST['kondisiBukuSaatDikembalikan'] == "Hilang") {
        $denda = "Rp 50.000";
    }

    $judul_buku = $_POST['judulBuku'];
    $tanggal_pengembalian = $_POST['tanggalPengembalian'];
    $kondisiBukuSaatDikembalikan = $_POST['kondisiBukuSaatDikembalikan'];

    $ambil_id = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE judul_buku = '$judul_buku'");
    $row = mysqli_fetch_assoc($ambil_id);

    $id_peminjaman = $row['id_peminjaman'];

    $query = "UPDATE peminjaman SET tanggal_pengembalian = '$tanggal_pengembalian', kondisi_buku_saat_dikembalikan = '$kondisiBukuSaatDikembalikan', denda = '$denda'";

    $query .= "WHERE id_peminjaman = $id_peminjaman";

    $sql = mysqli_query($koneksi, $query);

    if ($sql) {
        // Send notif to admin
        InsertPemberitahuanPengembalian();

        $_SESSION['berhasil'] = "Pengembalian buku berhasil !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Pengembalian buku gagal !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
} else if ($_GET['aksi'] == "hapus") {
    $id_pengajuan = $_GET['id_pengajuan'];

    $sql = mysqli_query($koneksi, "DELETE FROM pengajuan WHERE id_pengajuan = $id_pengajuan");

    if ($sql) {
        $_SESSION['berhasil'] = "Data berhasil di hapus !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Data gagal di hapus !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}
function UpdateDataPeminjaman()
{
    include "../../../../config/koneksi.php";

    $nama_lama = $_SESSION['fullname'];
    $nama_anggota = $_POST['Fullname'];

    // Mencari nama dalam database berdasarkan session nama lengkap
    $query1 = mysqli_query($koneksi, "SELECT * FROM user WHERE fullname = '$nama_lama'");
    $row = mysqli_fetch_assoc($query1);

    // membuat variable dari hasil query1
    $nama_lama = $row['fullname'];

    // Fungsi update nama anggota pada table peminjaman
    $query = "UPDATE peminjaman SET nama_anggota = '$nama_anggota'";
    $query .= "WHERE nama_anggota = '$nama_lama'";

    $sql = mysqli_query($koneksi, $query);
}
