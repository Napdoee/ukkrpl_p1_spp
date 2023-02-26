<?php 
    if(isset($_POST['simpan'])) {
        $nisn = $_POST['nisn'];
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $spp = $_POST['spp'];
        $kelas = $_POST['kelas'];
        $alamat = $_POST['alamat'];
        $notelp = $_POST['notelp'];

        $data = $db->insertSiswa($nisn, $nis, $nama, $spp, $kelas, MD5($nis), $alamat, $notelp);

        if($data){
            $db->alertMsg("Data berhasil disimpan", 'index.php?page=siswa');
        }
    }

    if(isset($_POST['delete'])){
        $data = $db->delete('siswa', 'nisn', $_POST['nisn']);

        if($data){
            echo "<script>window.location='?page=pembayaran'</script>";
        }
    }
?>
<div class="content-header">
    <div class="container-fluid">
        <h1 class="mb-2">Data Siswa</h1>
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
                <a href="?page=data&laporan=siswa" class="btn btn-success">
                    <i class="fas fa-folder"></i> Laporan
                </a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table id="example2" class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Alamat</th>
                            <th>No. Telp</th>
                            <th>Tahun SPP</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = $db->query("SELECT * FROM siswa s, kelas k, spp p WHERE s.id_kelas = k.id_kelas AND s.id_spp = p.id_spp");
                        $no = 1;
                        foreach($query as $data) :
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $data['nisn'] ?></td>
                            <td><?= $data['nis'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['nama_kelas'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td><?= $data['no_telp'] ?></td>
                            <td><?= $data['tahun'] ?></td>
                            <td class="text-center" width="15%">
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-warning mr-2" href="?page=edit&act=siswa&id=<?= $data['nisn'] ?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="" method="POST">
                                        <input type="hidden" name="nisn" value="<?= $data['nisn'] ?>">
                                        <button name="delete" type="submit" class="btn btn-danger"
                                            onclick="confirm('Apakah anda yakin ingin menghapus data ini? <?= $data['nama'] ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Siswa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nisn">NISN</label>
                                <input type="number" class="form-control" name="nisn" id="nisn"
                                    placeholder="Masukkan NISN" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nis">NIS</label>
                                <input type="number" class="form-control" name="nis" id="nis" placeholder="Masukkan NIS"
                                    required>
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
                                    <option value="<?= $val['id_kelas'] ?>"> <?= $val['nama_kelas'] ?></option>
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
                                    <option value="<?= $val['id_spp'] ?>"> <?= $val['tahun'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Masukkan Nama siswa"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Masukkan Alamat"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="notelp">No. Telp</label>
                        <input type="number" class="form-control" name="notelp" id="notelp"
                            placeholder="Masukkan No. Telp" required>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="simpan" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>