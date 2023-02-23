<?php 
    if(isset($_POST['simpan'])) {
        $nama = $_POST['nama_petugas'];
        $level = $_POST['level'];
        $username = $_POST['username'];
        $password = MD5($_POST['password']);

        $data = $db->insertPetugas($nama, $username, $password, $level);

        if($data){
            $db->alertMsg("Data berhasil disimpan", 'index.php?page=petugas');
        }
    }

    if(isset($_POST['delete'])){
        $data = $db->delete('petugas', 'id_petugas', $_POST['id_petugas']);

        if($data){
            header("location: index.php?page=petugas");
        }
    }
?>
<div class="content-header">
    <div class="container">
        <h1 class="mb-2">Data Petugas</h1>
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
                <a href="?page=data&laporan=petugas" class="btn btn-success">
                    <i class="fas fa-folder"></i> Laporan
                </a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <table id="example2" class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-center">ID</th>
                            <th>Nama</th>
                            <th>Level</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = $db->showData('petugas', 'id_petugas');
                        $no = 1;
                        foreach($query as $data) :
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $data['id_petugas'] ?></td>
                            <td><?= $data['nama_petugas'] ?></td>
                            <td><?= $data['level'] ?></td>
                            <td width="20%">
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-warning mr-2"
                                        href="?page=edit&act=petugas&id=<?= $data['id_petugas'] ?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="" method="POST">
                                        <input type="hidden" name="id_petugas" value="<?= $data['id_petugas'] ?>">
                                        <button name="delete" type="submit" class="btn btn-danger"
                                            onclick="confirm('Apakah anda yakin ingin menghapus data ini? <?= $data['nama_petugas'] ?>')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form </div>
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
                <h4 class="modal-title">Tambah Petugas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nama_petugas">Nama Petugas</label>
                        <input type="text" class="form-control" name="nama_petugas" id="nama_petugas"
                            placeholder="Masukkan nama" required>
                    </div>
                    <div class="form-group">
                        <label for="level">Level Petugas</label>
                        <select name="level" class="form-control" required>
                            <option value="">Pilih level</option>
                            <option value="petugas">Petugas</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username"
                            placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password"
                            placeholder="Masukkan password" required>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>