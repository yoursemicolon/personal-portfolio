<?php

include("config.php");

// cek apakah tombol simpan sudah diklik atau blum?
if(isset($_POST['simpan'])){

    // ambil data dari formulir
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah = $_POST['sekolah_asal'];

    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    // cek acdanya foto
    if(empty($foto)){ 



    // buat query update
    $sql = "UPDATE calon_siswa SET nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', sekolah_asal='$sekolah' WHERE id=$id";
    $query = mysqli_query($db, $sql);

    // apakah query update berhasil?
    if( $query ) {
        // kalau berhasil alihkan ke halaman list-siswa.php
        header('Location: list-siswa.php');
    } else {
        // kalau gagal tampilkan pesan
        die("Gagal menyimpan perubahan...");
    }

    else{ // Jika user memilih foto / mengisi input file foto pada form
        // Lakukan proses update termasuk mengganti foto sebelumnya
        // Rename nama fotonya dengan menambahkan tanggal dan jam upload
         
        $fotobaru = date('dmYHis').$foto;
         
        // Set path folder tempat menyimpan fotonya
        $path = "img/".$fotobaru;
        // buat query update
        if(move_uploaded_file($tmp, $path)){ // Cek apakah gambar berhasil diupload atau tidak
         
        $sql = "SELECT foto FROM calon_mahasiswa WHERE id=$id";
        $query = mysqli_query($db, $sql);
        $data = mysqli_fetch_array($query);
         
        if(is_file("img/".$data['foto'])) // Jika foto ada
        unlink("img/".$data['foto']); // Hapus file foto sebelumnya yang ada di folder images
        // buat query
        $sql = "UPDATE calon_mahasiswa SET foto='$path', nama='$nama', alamat='$alamat', jenis_kelamin='$jk', agama='$agama', sekolah_asal='$sekolah' WHERE id=$id";
        $query = mysqli_query($db, $sql);
         
        // apakah query simpan berhasil?
        if( $query ) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        header('Location: index.php?status=suksesedit');
        } else {
        // kalau gagal alihkan ke halaman indek.php dengan status=gagal
        header('Location: index.php?status=gagal');
        }
        }
        }


} else {
    die("Akses dilarang...");
}

?>