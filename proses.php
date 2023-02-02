<?php 
session_start();

include "database.php";
$db = new Database();

if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = MD5($password);

    $check = $db->cekLogin($username, $password);

    if($check == 'petugas'){
        $petugas = $db->cekPetugas($username, $password)[0];

        $db->setSession($petugas['nama_petugas'], $petugas['id_petugas'], $petugas['level'], true);
        header("location: petugas/?page=dashboard");
    } else if($check == 'siswa'){
        $siswa = $db->cekSiswa($username, $password)[0];

        $db->setSession($siswa['nama'], $siswa['nisn'], 'siswa', true);
        header("location: siswa/");
    } else {
        $db->alertMsg("Username atau Password anda Salah!", 'index.php');
    }
}