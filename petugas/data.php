<?php 
    if(isset($_GET['laporan']))
    {
        $laporan = $_GET['laporan'];
    } else {
        die("<br><center>Tidak ada modul yang ditemukan</center>");
    }
?>
<div class="content-header">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <button onclick="cetak()" class="btn btn-success" style="margin-left: 5px;">
                <i class="fas fa-print"></i>
                Cetak
            </button>
            <a class="btn btn-default" href="?page=<?= $laporan ?>">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3>
                    <i class="fas fa-edit"></i>
                    Laporan <?= ucwords($laporan) ?>
                </h3>
            </div>
            <div class="table-responsive">
                <?php         
                if($laporan == 'petugas') :
                ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th width="20%">Pembayaran yang dilakukan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = $db->showData('petugas', 'nama_petugas');
                        $no = 1;
                        foreach($query as $data) :
                        $JmlPembayaran = $db->pembayaranPetugas($data['id_petugas']);
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= $data['nama_petugas'] ?></td>
                            <td><?= $data['username'] ?></td>
                            <td><?= $data['level'] ?></td>
                            <td class="text-center"><?= $JmlPembayaran ?> x</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php elseif($laporan == 'kelas') : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-center">ID</th>
                            <th>Nama Kelas</th>
                            <th>Kompetensi Keahlian</th>
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
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php elseif($laporan == 'spp') : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-center">ID</th>
                            <th>Tahun</th>
                            <th>Nominal</th>
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
                            <td><?= $data['nominal'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php elseif($laporan == 'siswa') : ?>
                <table class="table table-striped">
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
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php elseif($laporan == 'pembayaran') : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">#</th>
                            <th class="text-center">ID</th>
                            <th>Petugas</th>
                            <th>Siswa</th>
                            <th>Tanggal Pembayaran</th>
                            <th>Bulan Dibayar</th>
                            <th>Tahun Dibayar</th>
                            <th>Jumlah Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = $db->showData('pembayaran', 'nisn');
                        $no = 1;
                        foreach($query as $data) :
                            $petugas = $db->detailData('petugas', 'id_petugas', $data['id_petugas']);
                            $siswa = $db->detailData('siswa', 'nisn', $data['nisn']);
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="text-center"><?= $data['id_pembayaran'] ?></td>
                            <td><?= $petugas['nama_petugas'] ?></td>
                            <td><?= $data['nisn']." - ".$siswa['nama'] ?></td>
                            <td><?= $data['tgl_bayar'] ?></td>
                            <td><?= $data['bulan_dibayar'] ?></td>
                            <td><?= $data['tahun_dibayar'] ?></td>
                            <td>Rp. <?= number_format($data['jumlah_bayar'],2,',','.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else : ?>
                <br>
                <center>Tidak ada modul yang ditemukan</center>
                <br>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
function cetak() {
    window.addEventListener("load", window.print());
}
</script>