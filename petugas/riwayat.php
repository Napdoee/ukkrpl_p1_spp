<?php
if (isset($_POST['delete'])) {
    $data = $db->delete('pembayaran', 'id_pembayaran', $_POST['id_pembayaran']);

    if ($data) {
        echo "<script>window.location='?page=pembayaran'</script>";
    }
}
?>
<div class="content-header">
    <div class="container-fluid">
        <h1 class="mb-2">Data Pembayaran</h1>
        <?php if ($_SESSION['level'] == 'admin') : ?>
        <div class="row">
            <div class="col-12">
                <a href="?page=data&laporan=pembayaran" class="btn btn-success">
                    <i class="fas fa-folder"></i> Laporan
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table id="example2" class="table table-bordered align-middle text-nowrap">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th>Petugas</th>
                            <th>Siswa</th>
                            <th>Tanggal</th>
                            <th>Bulan</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <?php if ($_SESSION['level'] == 'admin') : ?>
                            <th class="text-center">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $db->showData('pembayaran', 'nisn');
                        $no = 1;
                        foreach ($query as $data) :
                            $petugas = $db->detailData('petugas', 'id_petugas', $data['id_petugas']);
                            $siswa = $db->detailData('siswa', 'nisn', $data['nisn']);
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $petugas['nama_petugas'] ?></td>
                            <td><?= $data['nisn'] . " - " . $siswa['nama'] ?></td>
                            <td><?= $data['tgl_bayar'] ?></td>
                            <td><?= $data['bulan_dibayar'] ?></td>
                            <td><?= $data['tahun_dibayar'] ?></td>
                            <td>Rp. <?= number_format($data['jumlah_bayar'], 2, ',', '.') ?></td>
                            <?php if ($_SESSION['level'] == 'admin') : ?>
                            <td class="text-center" width="15%">
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-warning mr-2"
                                        href="?page=edit&act=pembayaran&id=<?= $data['id_pembayaran'] ?>">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form action="" method="POST">
                                        <input type="hidden" name="id_pembayaran" value="<?= $data['id_pembayaran'] ?>">
                                        <button name="delete" type="submit" class="btn btn-danger"
                                            onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>