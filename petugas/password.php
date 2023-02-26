<?php 
    if(isset($_POST['changePass'])){
        $oldPass = $_POST['oldPassword'];
        $pass = $_POST['pass'];
        $pass2 = $_POST['pass2'];

        $confirmPass = $db->detailData('petugas', 'password', MD5($oldPass));
        if($confirmPass){
            if($pass == $pass2){
                $query = $db->changePass('petugas', $_SESSION['userId'], MD5($pass));
        
                if($query){
                    $db->alertMsg('Password berhasil diubah', '?page=changePass');
                }
            } else {
                $db->alertMsg('Terjadi kesalahan konfirmasi password', '?page=changePass');
            }
        } else {
            $db->alertMsg('Password lama tidak sama!', '?page=changePass');
        }
    }
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-2">Pengaturan Akun</h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="oldPassword">Password Lama</label>
                        <input type="password" class="form-control" name="oldPassword" id="oldPassword"
                            placeholder="Masukkan Password Lama" required>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="pass">Password Baru</label>
                        <input type="password" class="form-control" name="pass" id="pass"
                            placeholder="Masukkan Password Baru" required>
                    </div>
                    <div class="form-group">
                        <label for="pass2">Ulangi Password</label>
                        <input type="password" class="form-control" name="pass2" id="pass2"
                            placeholder="Ulangi Password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="changePass" class="btn btn-primary">
                            Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>