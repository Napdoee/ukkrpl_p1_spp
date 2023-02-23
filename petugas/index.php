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
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <?php include "partials/navbar.php"; ?>
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
                    default : 
                        include "dashboard.php";
                }
            ?>
        </div>
    </div>
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
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