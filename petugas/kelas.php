<?php 
    if(isset($_POST['simpan'])) {
        $nama = $_POST['nama_kelas'];
        $kompetensi = $_POST['kompetensi_keahlian'];

        $data = $db->insertKelas($nama, $kompetensi);

        if($data){
            $db->alertMsg("Data berhasil disimpan", 'index.php?page=kelas');
        } else {
            echo mysqli_error();
        }
    }

    if(isset($_POST['delete'])){
        $data = $db->delete('kelas', 'id_kelas', $_POST['id_kelas']);

        if($data){
            header("location: index.php?page=kelas");
        } else {
            echo mysqli_error();
        }
    }
?>
<div class="content-header">
    <div class="container">
        <h1 class="mb-2">Data Kelas</h1>
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
                <a href="?page=data&laporan=kelas" class="btn btn-success">
                    <i class="fas fa-folder"></i>
                    Laporan
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
                            <th>Nama Kelas</th>
                            <th>Kompetensi Keahlian</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = $db->showData('kelas', 'kompetensi_keahlian');
                        $no = 1;
                        foreach($query as $data) :
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $data['id_kelas'] ?></td>
                            <td><?= $data['nama_kelas'] ?></td>
                            <td><?= $data['kompetensi_keahlian'] ?></td>
                            <td width="20%">
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-warning mr-2"
                                        href="?page=edit&act=kelas&id=<?= $data['id_kelas'] ?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="" method="POST">
                                        <input type="hidden" name="id_kelas" value="<?= $data['id_kelas'] ?>">
                                        <button name="delete" type="submit" class="btn btn-danger"
                                            onclick="confirm('Apakah anda yakin ingin menghapus data ini? <?= $data['nama_kelas'] ?>')">
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
                <h4 class="modal-title">Tambah Kelas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nama_kelas">Nama Kelas</label>
                        <input type="text" class="form-control" name="nama_kelas" id="nama_kelas"
                            placeholder="Masukkan nama kelas" required>
                    </div>
                    <div class="form-group">
                        <label for="kompetensi_keahlian">Kompetensi Keahlian</label>
                        <input type="text" class="form-control" name="kompetensi_keahlian" id="kompetensi_keahlian"
                            placeholder="Masukkan kompetensi keahlian" required>
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