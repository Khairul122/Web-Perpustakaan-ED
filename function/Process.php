<?php
session_start();
//------------------------------::::::::::::::::::::------------------------------\\
// Dibuat oleh FA Team di PT. Pacifica Raya Technology \\
//------------------------------::::::::::::::::::::------------------------------\\
include "../config/koneksi.php";

if ($_GET['aksi'] == "masuk") {

    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $data = mysqli_query($koneksi, "SELECT * FROM user WHERE username = '$username' AND password = '$password'");

    $cek = mysqli_num_rows($data);

    if ($cek > 0) {
        $row = mysqli_fetch_assoc($data);

        if ($row['role'] == "Admin") {
            // Jika level user yang login adalah admin maka arahkan user ke halaman admin
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['password'] = $row['password'];
            $_SESSION['status'] = "Login";
            $_SESSION['level'] = "Admin";

            // 
            date_default_timezone_set('Asia/Jakarta');

            $id_user = $_SESSION['id_user'];
            $tanggal = date('d-m-Y');
            $jam = date('H:i:s');

            $query = "UPDATE user SET terakhir_login = '$tanggal ( $jam )'";
            $query .= "WHERE id_user = $id_user";

            $sql = mysqli_query($koneksi, $query);

            header("location: ../admin");
        } else if ($row['role'] == "Anggota") {
            // Jika level user yang login adalah user maka arahkan user kehalaman user
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['level'] = "Anggota";
            $_SESSION['status'] = "Login";

            // 
            date_default_timezone_set('Asia/Jakarta');

            $id_user = $_SESSION['id_user'];
            $tanggal = date('d-m-Y');
            $jam = date('H:i:s');

            $query = "UPDATE user SET terakhir_login = '$tanggal ( $jam )'";
            $query .= "WHERE id_user = $id_user";

            $sql = mysqli_query($koneksi, $query);

            header("location: ../user");
        } else if ($row['role'] == "Dosen") {
            // Jika level user yang login adalah user maka arahkan user kehalaman user
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['level'] = "Dosen";
            $_SESSION['status'] = "Login";
            $_SESSION['kode_user'] = $row['kode_user'];

            // 
            date_default_timezone_set('Asia/Jakarta');

            $id_user = $_SESSION['id_user'];
            $tanggal = date('d-m-Y');
            $jam = date('H:i:s');

            $query = "UPDATE user SET terakhir_login = '$tanggal ( $jam )'";
            $query .= "WHERE id_user = $id_user";

            $sql = mysqli_query($koneksi, $query);

            header("location: ../dosen");
        } else {
            // JIka login gagal tampilkan sebuah pesan gagal login melalui session
            // Dan aktifkan session pada halaman login
            $_SESSION['user_tidak_terdaftar'] = "Maaf, User tidak terdaftar pada database !!";

            header("location: ../masuk");
        }
    } else {
        // JIka login gagal tampilkan sebuah pesan gagal login melalui session
        // Dan aktifkan session pada halaman login
        $_SESSION['gagal_login'] = "Nama Pengguna atau Kata Sandi salah !!";

        header("location: ../masuk");
    }
} else if ($_GET['aksi'] == "daftar") {
    $fullname = $_POST['funame'];
    $username = addslashes(strtolower($_POST['uname']));
    $username1 = str_replace(' ', '', $username);
    $password = $_POST['passw'];
    $kls = $_POST['kelas'];
    $jrs = $_POST['jurusan'];
    $kelas = $kls . $jrs;
    $alamat = $_POST['alamat'];
    $verif = "Tidak";
    $role = $_POST['role'];
    $join_date = date('d-m-Y');



    if ($role == "Dosen") {
        $huruf = "D";
    } else if ($role == "Anggota") {
        $huruf = "AP";
    }

    // Mendapatkan nomor urut berikutnya untuk kode_user
    $query = mysqli_query($koneksi, "SELECT max(substring(kode_user, 2, 3)) as kodeTerakhir FROM user WHERE role = '$role'");
    $data = mysqli_fetch_array($query);
    $urutan = (int)$data['kodeTerakhir'];
    $urutan++;

    // Membentuk kode user baru
    $Anggota = $huruf . sprintf("%03s", $urutan);

    $sql = "INSERT INTO user(kode_user,nis,fullname,username,password,kelas,alamat,verif,role,join_date)
        VALUES('" . $Anggota . "','" . $nis . "','" . $fullname . "','" . $username1 . "','" . $password . "','" . $kelas . "','" . $alamat . "','" . $verif . "','" . $role . "','" . $join_date . "')";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        $_SESSION['berhasil'] = "Pendaftaran Berhasil !";
        header("location: ../masuk");
    } else {
        $_SESSION['gagal'] = "Pendaftaran Gagal !";
        header("location: ../masuk");
    }
}
