<?php 
    if(isset($_GET['act']) && isset($_GET['id']))
    {
        $act = $_GET['act'];
        $id = $_GET['id'];

        if($act == 'kelas'){
            $data = $db->detailData('kelas', 'id_kelas', $id);
        } else if($act == 'petugas') {
            $data = $db->detailData('petugas', 'id_petugas', $id);
        } else if($act == 'siswa'){
            $data = $db->detailData('siswa', 'nisn', $id);
        } else {
            die("<br><center>Tidak ada modul yang ditemukan</center>");
        }
    } else {
        die("<br><center>Tidak ada modul yang ditemukan</center>");
    }
?>
<div class="content-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-2">Edit Data <?= ucwords($_GET['act']) ?></h1>
            <a class="btn btn-default" href="?page=<?= $_GET['act'] ?>">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="proses.php?act=<?= $_GET['act'] ?>&id=<?= $_GET['id'] ?>" method="POST">
                    <?php if($_GET['act'] == 'kelas') : ?>
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" class="form-control" name="nama_kelas" id="nama_kelas"
                            placeholder="Masukkan nama kelas" value="<?= $data['nama_kelas'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kompetensi_keahlian">Kompetensi Keahlian</label>
                        <input type="text" class="form-control" name="kompetensi_keahlian" id="kompetensi_keahlian"
                            placeholder="Masukkan kompetensi keahlian" value="<?= $data['kompetensi_keahlian'] ?>"
                            required>
                    </div>
                    <?php elseif($_GET['act'] == 'petugas') : ?>
                    <input type="hidden" name="oldPassword" value="<?= $data['password'] ?>">
                    <div class="form-group">
                        <label for="nama_petugas">Nama Petugas</label>
                        <input type="text" class="form-control" name="nama_petugas" id="nama_petugas"
                            placeholder="Masukkan nama" value="<?= $data['nama_petugas'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="level">Level Petugas</label>
                        <select name="level" class="form-control" required>
                            <option value="">Pilih level</option>
                            <option <?= $data['level'] == 'petugas' ? 'selected' : '' ?> value="petugas">
                                Petugas</option>
                            <option <?= $data['level'] == 'admin' ? 'selected' : '' ?> value="admin">Admin
                            </option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username"
                            placeholder="Masukkan username" value="<?= $data['username'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Masukkan password">
                    </div>
                    <?php elseif($_GET['act'] == 'siswa') : ?>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama siswa"
                            value="<?= $data['nama'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukkan Alamat"
                            value="<?= $data['alamat'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="notelp">No. Telp</label>
                        <input type="text" class="form-control" name="notelp" id="notelp"
                            placeholder="Masukkan No. Telp" value="<?= $data['no_telp'] ?>" required>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" name="ubah" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>