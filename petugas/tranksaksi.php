<?php 
    if(isset($_POST['bayar'])){
        $petugas = $_SESSION['userId'];
        $siswa = $_POST['nama'];
        $tgl_dibayar = $_POST['tgl_bayar'];
        $bulan = $_POST['bulan'];
        $id_spp = $_POST['tahun'];
        $tahun = $db->detailData('spp', 'id_spp', $id_spp)['tahun'];
        $jumlah = $_POST['jumlah'];

        $data = $db->insertPembayaran($petugas, $siswa, $tgl_dibayar, $bulan, $tahun, $id_spp, $jumlah);

        if($data){
            $db->alertMsg("Data berhasil disimpan", '?page=pembayaran');
        }
    }
?>
<div class="content-header">
    <div class="container">
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
                        <label for="nama">Siswa</label>
                        <select name="nama" id="nama" class="form-control select2" required>
                            <option value="">Pilih Siswa</option>
                            <?php foreach($db->showData("siswa", 'nama') as $val): ?>
                            <option value="<?= $val['nisn'] ?>"><?= $val['nisn']." - ".$val['nama'] ?>
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
                            <option value="Januari">Januari</option>
                            <option value="Februari">Februari</option>
                            <option value="Maret">Maret</option>
                            <option value="April">April</option>
                            <option value="Mei">Mei</option>
                            <option value="Juni">Juni</option>
                            <option value="Juli">Juli</option>
                            <option value="September">September</option>
                            <option value="Oktober">Oktober</option>
                            <option value="November">November</option>
                            <option value="Desember">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tahun">Tahun SPP</label>
                        <select name="tahun" id="tahun" class="form-control" required>
                            <option value="">Pilih Tahun</option>
                            <?php foreach($db->showData("spp", 'tahun') as $val): ?>
                            <option value="<?= $val['id_spp'] ?>"><?= $val['tahun'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Bayar</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah bayar"
                            required>
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