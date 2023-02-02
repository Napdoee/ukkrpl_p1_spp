<?php 

class Database 
{
    protected $host = 'localhost';
    protected $name = 'root';
    protected $pass = '';
    protected $db   = 'ukk_spp';

    var $connect;

    function __construct(){
        $this->connect = mysqli_connect($this->host, $this->name, $this->pass, $this->db);

        if(mysqli_connect_errno()){
            die('Database gagal terhubung');
        }
    }

    function query($sql){
        $resArr = array();
        $result = mysqli_query($this->connect, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $resArr[] = $row;
        }

    return $resArr;
    }

    /** 
    Check multiuser login
    **/
    function cekLogin($user, $pass){
        $query = mysqli_query($this->connect, "SELECT * FROM siswa 
        WHERE nisn = '$user' AND password = '$pass' ");
        if(mysqli_num_rows($query)){
            $data = 'siswa';
        } else {
            $subQuery = mysqli_query($this->connect, "SELECT * FROM petugas
            WHERE username = '$user' AND password = '$pass'");
            if(mysqli_num_rows($subQuery)){
                $data = 'petugas';
            } else {
                return false;
            }
        }

        return $data;
    }

    /** 
    Check user data
    **/
    function cekPetugas($user, $pass){
        $query = $this->query("SELECT * FROM petugas 
        WHERE username = '$user' AND password = '$pass'");

        return $query;
    }
    function cekSiswa($nisn, $pass){
        $query = $this->query("SELECT * FROM siswa 
        WHERE nisn = '$nisn' AND password = '$pass'");

        return $query;
    }

    /** 
    Show data from spesific tabel
    **/
    function showData($tabel, $order){
        $query = $this->query("SELECT * FROM $tabel ORDER BY $order DESC");

        return $query;
    }
    function detailData($tabel, $pk, $id){
        $query = $this->query("SELECT * FROM $tabel WHERE $pk='$id'")[0];

        return $query;
    }
    
    
    /**
    Function Insert Data
    **/
    function insertPetugas($nama, $username, $password, $level){
        $dataUser = mysqli_query($this->connect, "SELECT * FROM petugas");
        while($data = mysqli_fetch_array($dataUser)){
            if($data['nama_petugas'] == $nama){
               return $this->alertMsg('Nama tersebut telah digunakan', 'data-petugas.php');
            }
        }

        $query = mysqli_query($this->connect, "INSERT INTO petugas 
        VALUES('', '$nama', '$password', '$level')");

        return $query;
    }

    function insertKelas($nama_kelas, $jurusan){
        $query = mysqli_query($this->connect, "INSERT INTO kelas 
        VALUES('', '$nama_kelas', '$jurusan')");

        return $query;
    }

    function insertSiswa($nisn, $nis, $nama, $spp, $kelas, $alamat, $notelp ){
        $query = mysqli_query($this->connect, "INSERT INTO siswa 
        VALUES('$nisn', '$nis', '$nama', '$spp', '$kelas', NULL, '$alamat', '$notelp')");

        return $query;
    }

    function insertPembayaran($petugas, $siswa, $tgl_bayar, $bulan_dibayar, $tahun_dibayar, $id_spp, $jumlah_bayar){
        $query = mysqli_query($this->connect, "INSERT INTO pembayaran
        VALUES('', '$petugas', '$siswa', '$tgl_bayar', '$bulan_dibayar', '$tahun_dibayar', $id_spp, '$jumlah_bayar')");

        return $query;
    }

    /**
    Function Update Data
    * */
    function editPetugas($id, $nama, $user, $pass){
        $query = mysqli_query($this->connect, "UPDATE petugas SET 
        nama_petugas = '$nama', 
        username     = '$user',
        password     = '$pass' 
        WHERE id_petugas = $id");

        return $query;
    }

    function editKelas($id, $nama_kelas, $jurusan){
        $query = mysqli_query($this->connect, "UPDATE kelas SET 
        nama_kelas          = '$nama_kelas', 
        kompetensi_keahlian = '$jurusan'
        WHERE id_kelas = $id");

        return $query;
    }

    function editSiswa($id, $nama, $alamat, $notelp ){
        $query = mysqli_query($this->connect, "UPDATE siswa SET
        nama     = '$nama',
        alamat   = '$alamat',
        no_telp  = '$notelp'
        WHERE nisn = '$id'");

        return $query;
    }
    
    
    /**
    Function Delete Data
    **/
    function delete($table, $kol, $id){
        $query = mysqli_query($this->connect, "DELETE FROM $table WHERE $kol = $id");

        return $query;
    }


    /** 
    Memanggil fungsi Pembayaran Petugas
    **/
    function pembayaranPetugas($id){
        $query = $this->query("SELECT PembayaranPetugas($id) AS PembayaranPetugas")[0];
        $query = $query['PembayaranPetugas'];

        return $query;
    }

    /**
    Function tambahan
    **/
    function alertMsg($msg, $location){
        echo "<script>alert('$msg');
        window.location='$location';</script>";
    }

    function setSession($uname, $uid, $lvl, $status){
        $_SESSION['username']   = $uname;
        $_SESSION['userId']     = $uid;
        $_SESSION['level']      = $lvl;
        $_SESSION['status']     = $status;

        return true;
    }

}