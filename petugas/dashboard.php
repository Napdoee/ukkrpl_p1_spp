<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0"> Selamat Datang <b><?=  $_SESSION['username'] ?></b></h1>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <?php if($_SESSION['level'] == 'admin') : ?>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-user"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Siswa</span>
                        <span class="info-box-number">
                            <?= $db->query("SELECT COUNT(nama) as TotalSiswa FROM siswa")[0]['TotalSiswa']; ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-user-tie"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Petugas</span>
                        <span class="info-box-number">
                            <?= $db->query("SELECT COUNT(nama_petugas) as TotalPetugas FROM petugas")[0]['TotalPetugas']; ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-user-tie"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Kelas</span>
                        <span class="info-box-number">
                            <?= $db->query("SELECT COUNT(nama_kelas) as Total FROM kelas")[0]['Total']; ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-book"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Pembayaran</span>
                        <span class="info-box-number">
                            <?= $db->query("SELECT COUNT(nisn) as Total FROM pembayaran;")[0]['Total']; ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-book"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Jumlah Pembayaran</span>
                        <span class="info-box-number">
                            <?php $nominal = $db->query("SELECT SUM(jumlah_bayar) as Total FROM pembayaran;")[0]['Total']; 
                            echo "Rp. ".number_format($nominal,2,',','.'); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>