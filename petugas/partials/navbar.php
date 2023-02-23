<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="?page=dashboard">
            <span class="brand-text font-weight-light">
                SPP <b class="text-capitalize"><?= $_SESSION['level'] ?></b>
            </span>
        </a>

        <?php if($_SESSION['level'] == 'admin') : ?>
        <!-- Left Items -->
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        class="nav-link dropdown-toggle"><i class="fas fa-book"></i> Master </a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="?page=petugas" class="dropdown-item">Data Petugas </a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="?page=siswa" class="dropdown-item">Data Siswa </a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="?page=kelas" class="dropdown-item">Data Kelas </a></li>
                        <li class="dropdown-divider"></li>
                        <li><a href="?page=spp" class="dropdown-item">Data SPP </a></li>
                    </ul>
                </li>
        </div>
        <?php endif; ?>

        <!-- Right Items -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <li class="nav-item">
                <a href="?page=tranksaksi" class="nav-link">Pembayaran SPP</a>
            </li>
            <li class="nav-item">
                <a href="?page=pembayaran" class="nav-link">History SPP</a>
            </li>
            <li class="nav-item">
                <a href="../logout.php" class="nav-link">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<!-- /.navbar -->