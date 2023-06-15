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
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>Siswa</th>
                            <th>Tahun SPP</th>
                            <th>Total Bayar</th>
                            <th>Sisa Bayar</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = $db->query("SELECT siswa.nisn, siswa.nis, siswa.nama, spp.tahun, spp.nominal,
                        SUM(pembayaran.jumlah_bayar) as TotalBayar, 
                        (spp.nominal - SUM(pembayaran.jumlah_bayar)) as SisaBayar FROM 
                        siswa LEFT JOIN pembayaran ON siswa.nisn = pembayaran.nisn 
                        LEFT JOIN spp ON siswa.id_spp = spp.id_spp GROUP BY siswa.nisn");
                        $no = 1;
                        foreach ($query as $data) :
                            $statusPembayaran = $data['TotalBayar'] >= $data['nominal'] ? true : false;
                            $sisaBayar = $data['TotalBayar'] <= 0 ? $data['nominal'] : $data['SisaBayar'];
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $data['nisn'] ?></td>
                            <td><?= $data['nis'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['tahun'] ?></td>
                            <td>Rp. <?= number_format($data['TotalBayar']) ?></td>
                            <td>Rp. <?= number_format($sisaBayar) ?></td>
                            <td class="text-center" width="15%">
                                <div class="d-flex justify-content-center">
                                    <a class="btn <?= $statusPembayaran ? 'btn-success disabled' : 'btn-warning ' ?> mr-2"
                                        href="?page=tranksaksi&nisn=<?= $data['nisn'] ?>">
                                        <?= $statusPembayaran ? 'LUNAS' : 'BAYAR' ?>
                                    </a>
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