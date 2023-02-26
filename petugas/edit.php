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
        } else if($act == 'spp'){
            $data = $db->detailData('spp', 'id_spp', $id);
        } else if($act == 'pembayaran'){
            $data = $db->detailData('pembayaran', 'id_pembayaran', $id);
        } else {
            die("<br><center>Tidak ada modul yang ditemukan</center>");
        }

        if(isset($_POST['changePass'])){
            $pass = $_POST['password'];
            $pass = MD5($pass);
    
            $query = $db->changePass($id, $pass);
            
            if($query){
                $db->alertMsg('Password berhasil diubah', 'index.php?page=siswa');
            }
        }

    } else {
        die("<br><center>Tidak ada modul yang ditemukan</center>");
    }
?>
<div class="content-header">
    <div class="container-fluid">
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
    <div class="container-fluid">
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
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="number" class="form-control" name="nisn" id="nisn"
                                    value="<?= $data['nisn'] ?>" placeholder="Masukkan NISN" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="number" class="form-control" name="nis" id="nis"
                                    value="<?= $data['nis'] ?>" placeholder="Masukkan NIS" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <select name="kelas" id="kelas" class="form-control">
                                    <option value="">Pilih Kelas</option>
                                    <?php foreach($db->showData('kelas', 'nama_kelas') as $val) : ?>
                                    <option <?= ($data['id_kelas'] == $val['id_kelas']) ? 'selected' : '' ?>
                                        value="<?= $val['id_kelas'] ?>"> <?= $val['nama_kelas'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="spp">Tahun SPP</label>
                                <select name="spp" id="spp" class="form-control">
                                    <option value="">Pilih SPP</option>
                                    <?php foreach($db->showData('spp', 'tahun') as $val) : ?>
                                    <option <?= ($data['id_spp'] == $val['id_spp']) ? 'selected' : '' ?>
                                        value="<?= $val['id_spp'] ?>"> <?= $val['tahun'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
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
                    <?php elseif($_GET['act'] == 'spp') : ?>
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" class="form-control" name="tahun" id="tahun"
                            placeholder="Masukkan nama spp" value="<?= $data['tahun'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" class="form-control" name="nominal" id="nominal"
                            placeholder="Masukkan Nominal" value="<?= $data['nominal'] ?>" required>
                    </div>
                    <?php elseif($_GET['act'] == 'pembayaran') : ?>
                    <div class="form-group">
                        <label for="nama">Siswa</label>
                        <select name="nama" id="nama" class="form-control select2" required>
                            <option value="">Pilih Siswa</option>
                            <?php foreach($db->showData("siswa", 'nama') as $val): ?>
                            <option <?= ($val['nisn'] == $data['nisn']) ? 'selected' : '' ?>
                                value="<?= $val['nisn'] ?>"><?= $val['nisn']." - ".$val['nama'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tgl_bayar">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" name="tgl_bayar" id="tgl_bayar"
                            value="<?= $data['tgl_bayar'] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="bulan">Bulan Dibayar</label>
                        <select name="bulan" id="bulan" class="custom-select" required>
                            <option value="">Pilih Bulan</option>
                            <option <?= ($data['bulan_dibayar'] == 'Januari') ? 'selected' : '' ?> value="Januari">
                                Januari
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'Februari') ? 'selected' : '' ?> value="Februari">
                                Februari
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'Maret') ? 'selected' : '' ?> value="Maret">Maret
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'April') ? 'selected' : '' ?> value="April">April
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'Mei') ? 'selected' : '' ?> value="Mei">Mei</option>
                            <option <?= ($data['bulan_dibayar'] == 'Juni') ? 'selected' : '' ?> value="Juni">Juni
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'Juli') ? 'selected' : '' ?> value="Juli">Juli
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'September') ? 'selected' : '' ?> value="September">
                                September
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'Oktober') ? 'selected' : '' ?> value="Oktober">
                                Oktober
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'November') ? 'selected' : '' ?> value="November">
                                November
                            </option>
                            <option <?= ($data['bulan_dibayar'] == 'Desember') ? 'selected' : '' ?> value="Desember">
                                Desember
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun SPP</label>
                        <select name="tahun" id="tahun" class="form-control" required>
                            <option value="">Pilih Tahun</option>
                            <?php foreach($db->showData("spp", 'tahun') as $val): ?>
                            <option <?= ($data['tahun_dibayar'] == $val['tahun']) ? 'selected' : '' ?>
                                value="<?= $val['id_spp'] ?>"><?= $val['tahun'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Bayar</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah bayar"
                            value="<?= $data['jumlah_bayar'] ?>" required>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <button type="submit" name="ubah" class="btn btn-primary">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
                <?php if($_GET['act'] == 'siswa') : ?>
                <hr>
                <h3 class="m-0">Ganti Password</h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="password"></label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password Baru" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="changePass" class="btn btn-primary">Ganti Password</button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>