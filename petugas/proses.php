<?php 
session_start();
include "../database.php";
$db = new Database();

if(isset($_GET['act']))
{
    if($_GET['act'] == 'kelas'){
        $nama_kelas = $_POST['nama_kelas'];
        $jurusan = $_POST['kompetensi_keahlian'];

        $query = $db->editKelas($_GET['id'], $nama_kelas, $jurusan);
        
    } else if($_GET['act'] == 'spp'){
        $tahun = $_POST['tahun'];
        $nominal = $_POST['nominal'];

        $query = $db->editSPP($_GET['id'], $tahun, $nominal);
        
    } else if($_GET['act'] == 'pembayaran'){
        $petugas = $_SESSION['userId'];
        $siswa = $_POST['nama'];
        $tgl_dibayar = $_POST['tgl_bayar'];
        $bulan = $_POST['bulan'];
        $id_spp = $_POST['tahun'];
        $tahun = $db->detailData('spp', 'id_spp', $id_spp)['tahun'];
        $jumlah = $_POST['jumlah'];

        $query = $db->editPembayaran($_GET['id'], $petugas, $siswa, $tgl_dibayar, $bulan, $tahun, $id_spp, $jumlah);
        
    } else if($_GET['act'] == 'petugas'){
        $nama = $_POST['nama_petugas'];
        $level = $_POST['level'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $oldPassword = $_POST['oldPassword'];
        
        if($password != ''){
            $password = md5($password);
        } else {
            $password = $oldPassword;
        }

        $query = $db->editPetugas($_GET['id'], $nama, $username, $password, $level);

    } else if($_GET['act'] == 'siswa'){
        $nisn = $_POST['nisn'];
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $spp = $_POST['spp'];
        $kelas = $_POST['kelas'];
        $alamat = $_POST['alamat'];
        $notelp = $_POST['notelp'];

        $query = $db->editSiswa($_GET['id'], $nisn, $nis, $nama, $spp, $kelas, $alamat, $notelp);

    } else {
        header("location: index.php?page=dashboard");
    }

    
    if($query){
        $loc = "index.php?page=$_GET[act]";
        $db->alertMsg('Data berhasil diubah', $loc);
    }
}