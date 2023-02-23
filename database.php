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
        $query = $this->query("SELECT * FROM $tabel WHERE $pk='$id'");
        if(!$query){
            return false;
        } else {
            return $query[0];
        }
    }
    
    
    /**
    Function Insert Data
    **/
    function insertPetugas($nama, $username, $password, $level){
        $query = mysqli_query($this->connect, "INSERT INTO petugas 
        VALUES('', '$nama', '$password', '$username', '$level')");

        return $query;
    }

    function insertKelas($nama_kelas, $jurusan){
        $query = mysqli_query($this->connect, "INSERT INTO kelas 
        VALUES('', '$nama_kelas', '$jurusan')");

        return $query;
    }
    
    function insertSPP($tahun, $nominal){
        $query = mysqli_query($this->connect, "INSERT INTO spp 
        VALUES('', '$tahun', '$nominal')");

        return $query;
    }

    function insertSiswa($nisn, $nis, $nama, $spp, $kelas, $password, $alamat, $notelp ){
        $query = mysqli_query($this->connect, "INSERT INTO siswa 
        VALUES('$nisn', '$nis', '$nama', '$spp', '$kelas', '$password', '$alamat', '$notelp')");

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

    function editSPP($id, $tahun, $nominal){
        $query = mysqli_query($this->connect, "UPDATE spp SET 
        tahun   = '$tahun', 
        nominal = '$nominal'
        WHERE id_spp = $id");

        return $query;
    }

    function editSiswa($id, $nisn, $nis, $nama, $id_spp, $id_kelas, $alamat, $notelp ){
        $query = mysqli_query($this->connect, "UPDATE siswa SET
        nisn     = '$nisn',
        nis      = '$nis',
        id_spp   = '$id_spp',
        id_kelas = '$id_kelas',
        nama     = '$nama',
        alamat   = '$alamat',
        no_telp  = '$notelp'
        WHERE nisn = '$id'");

        return $query;
    }
    
    function editPembayaran($id, $petugas, $siswa, $tgl_bayar, $bulan_dibayar, $tahun_dibayar, $id_spp, $jumlah_bayar){
        $query = mysqli_query($this->connect, "UPDATE pembayaran SET
        id_petugas      = '$petugas', 
        nisn            = '$siswa', 
        tgl_bayar       = '$tgl_bayar', 
        bulan_dibayar   = '$bulan_dibayar', 
        tahun_dibayar   = '$tahun_dibayar', 
        id_spp          = $id_spp, 
        jumlah_bayar    = '$jumlah_bayar'
        WHERE id_pembayaran = $id");

        return $query;
    }
    
    function changePass($id, $password){
        $query = mysqli_query($this->connect, "UPDATE siswa SET
        password = '$password'
        WHERE nisn = '$id'") or die(mysqli_error());

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