<?php 
include "../database.php";
$db = new Database();

if(isset($_GET['act']))
{
    if($_GET['act'] == 'kelas'){
        $nama_kelas = $_POST['nama_kelas'];
        $jurusan = $_POST['kompetensi_keahlian'];

        $query = $db->editKelas($_GET['id'], $nama_kelas, $jurusan);
        
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
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $notelp = $_POST['notelp'];

        $query = $db->editSiswa($_GET['id'], $nama, $alamat, $notelp);
    } else {
        header("location: index.php?page=dashboard");
    }

    
    if($query){
        $loc = "index.php?page=$_GET[act]";
        $db->alertMsg('Data berhasil diubah', $loc);
    } else {
        echo mysqli_error();
    }
}

?>