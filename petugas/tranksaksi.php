<?php
if (isset($_GET['nisn'])) {
    $data = $db->query("SELECT  *, SUM(pembayaran.jumlah_bayar) as TotalBayar, 
    (spp.nominal - SUM(pembayaran.jumlah_bayar)) as SisaBayar 
    FROM siswa JOIN pembayaran ON siswa.nisn = pembayaran.nisn 
    JOIN spp ON siswa.id_spp = spp.id_spp 
    WHERE siswa.nisn = '$_GET[nisn]'")[0];
    $statusPembayaran = $data['TotalBayar'] >= $data['nominal'] ? true : false;

    if ($statusPembayaran) return $db->alertMsg("Siswa tersebut telah melakukan pembayaran LUNAS!", "?page=pembayaran");

    $queryBulanPembayaran = $db->query("SELECT bulan_dibayar FROM pembayaran 
    WHERE nisn = '$_GET[nisn]' AND id_spp = $data[id_spp]
    GROUP BY bulan_dibayar");
    $dataBulanPembayaran = [];
    foreach ($queryBulanPembayaran as $x) {
        $dataBulanPembayaran[] = $x['bulan_dibayar'];
    }

    $sisaBayar = $data['TotalBayar'] <= 0 ? $data['nominal'] : $data['SisaBayar'];
} else {
    echo "<script>window.location='?page=pembayaran'</script>";
}

if (isset($_POST['bayar'])) {
    $petugas = $_SESSION['userId'];
    $nisn = $_GET['nisn'];
    $id_spp = $data['id_spp'];
    $tahun = $data['tahun'];
    $tgl_dibayar = $_POST['tgl_bayar'];
    $bulan = $_POST['bulan'];
    $jumlah = $_POST['jumlah'];

    if ($jumlah > $sisaBayar)
        return $db->alertMsg("Jumlah pembayaran anda melebihi dari sisa pembayaran siswa!!", "?page=tranksaksi&nisn=$data[nisn]");

    $insert = $db->insertPembayaran($petugas, $nisn, $tgl_dibayar, $bulan, $tahun, $id_spp, $jumlah);

    if ($insert) {
        $db->alertMsg("Data berhasil disimpan", '?page=pembayaran');
    }
}
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="mb-2">Pembayaran SPP</h1>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="nisn">Siswa</label>
                        <input type="text" class="form-control" id="nisn" value="<?= $data['nama'] ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="tgl_bayar">Tanggal Pembayaran</label>
                        <input type="date" class="form-control" name="tgl_bayar" id="tgl_bayar"
                            value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="bulan">Bulan Dibayar</label>
                        <select name="bulan" id="bulan" class="form-control select2" required>
                            <option value="">Pilih Bulan</option>
                            <?php
                            $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'September', 'Oktober', 'November', 'Desember'];
                            $result = array_diff($bulan, $dataBulanPembayaran);
                            foreach ($result as $row) :
                            ?>
                            <option value="<?= $row ?>"><?= $row ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                        <label for="tahun">Tahun SPP</label>
                        <select name="tahun" id="tahun" class="form-control" required>
                            <option value="">Pilih Tahun</option>
                            <?php foreach ($db->showData("spp", 'tahun') as $val) : ?>
                            <option value="<?= $val['id_spp'] ?>"><?= $val['tahun'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="jumlah">Jumlah Bayar</label>
                        <p>Sisa Pembayaran - Rp. <?= number_format($sisaBayar) ?></p>
                        <input type="number" name="jumlah" id="jumlah" class="form-control"
                            placeholder="Masukkan Jumlah Pembayaran" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="bayar" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="../assets/plugins/select2/js/select2.full.min.js"></script>
<script>
$(function() {
    $('.select2').select2()
});
</script>