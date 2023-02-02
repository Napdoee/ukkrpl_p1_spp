<?php 
    session_start();
    include "../database.php";
    $db = new Database();

    if(!isset($_SESSION['status'])){
        return header("location: ../index.php");
    }

    if($_SESSION['level'] != 'siswa'){
       return $db->alertMsg("Anda harus masuk sebagai siswa untuk mengakses halaman!", '../logout.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Siswa</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="" class="navbar-brand">
                    <span class="brand-text font-weight-light">SPP Digital</span>
                </a>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <!-- <li class="nav-item">
                            <a href="" class="nav-link">Dashboard</a>
                        </li> -->
                    </ul>
                </div>
                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                    <li class="nav-item">
                        <a href="../logout.php" class="nav-link">
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"> Selamat Datang kembali <?= $_SESSION['username'] ?></h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="container">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Data Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered align-middle text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">#</th>
                                        <th>Petugas</th>
                                        <th>Tanggal Pembayaran</th>
                                        <th>Bulan Dibayar</th>
                                        <th>Tahun Dibayar</th>
                                        <th>Jumlah Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $query = $db->query("SELECT * FROM pembayaran WHERE nisn = {$_SESSION['userId']}");
                                    $no = 1;
                                    if(!empty($query) > 0) :
                                    foreach($query as $data) :
                                        $petugas = $db->detailData('petugas', 'id_petugas', $data['id_petugas']);
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $petugas['nama_petugas'] ?></td>
                                        <td><?= $data['tgl_bayar'] ?></td>
                                        <td><?= $data['bulan_dibayar'] ?></td>
                                        <td><?= $data['tahun_dibayar'] ?></td>
                                        <td>Rp. <?= number_format($data['jumlah_bayar'],2,',','.') ?></td>
                                    </tr>
                                    <?php  endforeach; else : ?>
                                    <tr>
                                        <td colspan='5' align="center">Belum ada history pembayaran</td>
                                    </tr>
                                    <?php endif;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Napdoee
            </div>
            <strong>Latihan UKK | SPP APP Paket 1</strong>
        </footer>
    </div>
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>