<?php 
    session_start();
    include "../database.php";
    $db = new Database();

    if(!isset($_SESSION['status'])){
        return header("location: ../index.php");
    }

    if($_SESSION['level'] != 'petugas' && $_SESSION['level'] != 'admin'){
        return $db->alertMsg("Anda harus masuk sebagai petugas untuk mengakses halaman!", '../logout.php');
    }

     if(!isset($_GET['page'])){
        echo "<script>window.location='?page=dashboard'</script>";
     }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Petugas SPP</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="../assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css" />
    <link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="?page=dashboard" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="../logout.php" class="nav-link">Logout</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="" class="brand-link">
                <span class="brand-text font-weight-light">SPP <b><?= ucwords($_SESSION['level']) ?></b></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info">
                        <a href="?page=changePass" class="d-block"><?= $_SESSION['username'] ?> -
                            <?= $_SESSION['level'] ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?php $activePages = ['petugas', 'siswa', 'kelas', 'spp'] ?>
                        <li class="nav-item">
                            <a href="?page=dashboard"
                                class="nav-link <?= ($_GET['page'] == 'dashboard' ? 'active' : '') ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <?php if($_SESSION['level'] == 'admin') : ?>
                        <li class="nav-item <?= (in_array($_GET['page'], $activePages) ? 'menu-open' : '') ?>">
                            <a href="#" class="nav-link <?= (in_array($_GET['page'], $activePages) ? 'active' : '') ?>">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Master
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="?page=petugas"
                                        class="nav-link <?= ($_GET['page'] == 'petugas' ? 'active' : '') ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Petugas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="?page=siswa"
                                        class="nav-link <?= ($_GET['page'] == 'siswa' ? 'active' : '') ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Siswa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="?page=kelas"
                                        class="nav-link <?= ($_GET['page'] == 'kelas' ? 'active' : '') ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Kelas</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="?page=spp"
                                        class="nav-link <?= ($_GET['page'] == 'spp' ? 'active' : '') ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data SPP</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="?page=tranksaksi"
                                class="nav-link <?= ($_GET['page'] == 'tranksaksi' ? 'active' : '') ?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Pembayaran SPP
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="?page=pembayaran"
                                class="nav-link <?= ($_GET['page'] == 'pembayaran' ? 'active' : '') ?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Riwayat Pembayaran
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <?php 
                $page = isset($_GET['page']) ? $_GET['page'] : '';
                $notAllowed = ['data', 'edit', 'kelas', 'petugas', 'proses', 'siswa', 'spp'];

                if($_SESSION['level'] == 'petugas' && in_array($page, $notAllowed)){
                    $db->alertMsg('Anda tidak memiliki akses', '?page=dashboard');
                }

                switch($page){
                    case 'dashboard' :
                        include 'dashboard.php';
                        break;
                    case 'kelas' :
                        include "kelas.php";
                        break;
                    case 'siswa' :
                        include "siswa.php";
                        break;
                    case 'petugas' :
                        include "petugas.php";
                        break;
                    case 'tranksaksi' :
                        include "tranksaksi.php";
                        break;
                    case 'pembayaran' :
                        include "pembayaran.php";
                        break;
                    case 'edit' :
                        include "edit.php";
                        break;
                    case 'data' :
                        include "data.php";
                        break;
                    case 'spp' :
                        include "spp.php";
                        break;
                    case 'changePass' :
                        include "password.php";
                        break;
                    default : 
                        include "dashboard.php";
                }
            ?>
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/adminlte.min.js"></script>
    <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../assets/plugins/jszip/jszip.min.js"></script>
    <script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="../assets/plugins/select2/js/select2.full.min.js"></script>
    <script>
    $(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            // placeholder: "Pilih siswa"
        })

        $("#example2").DataTable({
            responsive: true,
            lengthChange: true,
            ordering: true,
            paging: false,
            info: false,
            autoWidth: false,
        });
    })
    </script>
</body>

</html>