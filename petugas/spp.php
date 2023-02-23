<?php 
    if(isset($_POST['simpan'])) {
        $nama = $_POST['tahun'];
        $kompetensi = $_POST['nominal'];

        $data = $db->insertSPP($nama, $kompetensi);

        if($data){
            $db->alertMsg("Data berhasil disimpan", 'index.php?page=spp');
        } else {
            echo mysqli_error();
        }
    }

    if(isset($_POST['delete'])){
        $data = $db->delete('spp', 'id_spp', $_POST['id_spp']);

        if($data){
            header("location: index.php?page=spp");
        } else {
            echo mysqli_error();
        }
    }
?>
<div class="content-header">
    <div class="container">
        <h1 class="mb-2">Data SPP</h1>
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
                <a href="?page=data&laporan=spp" class="btn btn-success">
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
                            <th class="text-center" width="5%">ID</th>
                            <th>Tahun</th>
                            <th>Nominal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = $db->showData('spp', 'tahun');
                        $no = 1;
                        foreach($query as $data) :
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $data['id_spp'] ?></td>
                            <td><?= $data['tahun'] ?></td>
                            <td>Rp. <?= number_format($data['nominal']) ?></td>
                            <td width="20%">
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-warning mr-2" href="?page=edit&act=spp&id=<?= $data['id_spp'] ?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="" method="POST">
                                        <input type="hidden" name="id_spp" value="<?= $data['id_spp'] ?>">
                                        <button name="delete" type="submit" class="btn btn-danger"
                                            onclick="confirm('Apakah anda yakin ingin menghapus data ini? <?= $data['tahun'] ?>')">
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
                <h4 class="modal-title">Tambah SPP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="number" class="form-control" name="tahun" id="tahun"
                            placeholder="Masukkan nama spp" required>
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="number" class="form-control" name="nominal" id="nominal"
                            placeholder="Masukkan Nominal" required>
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