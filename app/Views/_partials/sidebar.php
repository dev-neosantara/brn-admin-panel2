<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">
            <?= Config('Brn')->settings['app_name']['value'] ?>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo $_SESSION['currentpath'] == 'dashboard' ? 'active' : '' ?>">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pengguna & Sponsor
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pendaftar" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-user-edit"></i>
            <span>Pendaftar</span>
        </a>
        <div id="pendaftar" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="<?= base_url('users/pendaftar') ?>">Pendaftar Baru</a>
                <a class="collapse-item" href="<?= base_url('users/perpanjangan') ?>">Perpanjangan</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#users" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-users"></i>
            <span>User</span>
        </a>
        <div id="users" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="<?= base_url('users/member') ?>">Member</a>
                <a class="collapse-item" href="<?= base_url('users/korwil') ?>">Korwil</a>
                <a class="collapse-item" href="<?= base_url('users/korda') ?>">Korda</a>
                <a class="collapse-item" href="<?= base_url('users/tim22') ?>">Tim 22</a>
            </div>
        </div>
    </li>
     <li class="nav-item">
        <a class="nav-link" href="<?= base_url('admins') ?>">
        <i class="fas fa-fw fa-user-cog"></i>
            <span>Admin</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('blacklist') ?>">
            <i class="fas fa-fw fa-users-slash"></i>
            <span>Data Blacklist</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('sponsors') ?>">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Sponsor</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        BRN Publishing
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#articles" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-newspaper"></i>
            <span>Artikel</span>
        </a>
        <div id="articles" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="<?= base_url('blog') ?>">Artikel</a>
                <a class="collapse-item" href="<?= base_url('blog/articles/add') ?>">Artikel Baru</a>
                <a class="collapse-item" href="<?= base_url('blog/category/add') ?>">Kategori</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#event" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-calendar-day"></i>
            <span>Event BRN</span>
        </a>
        <div id="event" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="<?= base_url('events') ?>">List Event</a>
                <a class="collapse-item" href="<?= base_url('events/add') ?>">Event baru</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Diklat BRN
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#diklat" aria-expanded="true"
            aria-controls="diklat">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Diklat</span>
        </a>
        <div id="diklat" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="buttons.html">Artikel</a>
                <a class="collapse-item" href="cards.html">Artikel Baru</a>
                <a class="collapse-item" href="cards.html">Kategori</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Toko BRN
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#product" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Produk</span>
        </a>
        <div id="product" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="buttons.html">List Produk</a>
                <a class="collapse-item" href="cards.html">Tambah Produk</a>
                <a class="collapse-item" href="cards.html">Kategori Produk</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cash-register"></i>
            <span>Transaksi</span>
        </a>
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-book-open"></i>
            <span>Laporan Penjualan</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Umum BRN
    </div>

     <!-- Nav Item - Pages Collapse Menu -->
     <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#about" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-info-circle"></i>
            <span>Tentang BRN</span>
        </a>
        <div id="about" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <!-- <h6 class="collapse-header">Custom Components:</h6> -->
                <a class="collapse-item" href="buttons.html">AD-ART</a>
                <a class="collapse-item" href="cards.html">Sejarah</a>
                <a class="collapse-item" href="cards.html">UU Organisasi BRN</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Mobil
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo $_SESSION['currentpath'] == 'cars' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('cars') ?>">
            <i class="fas fa-car"></i>
            <span>Daftar Mobil Member</span>
        </a>
    </li>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php echo $_SESSION['currentpath'] == 'car/models' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('cars/models') ?>">
            <i class="fas fa-car"></i>
            <span>Daftar Pabrikan Member</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Heading -->
    <div class="sidebar-heading">
        BRN Social
    </div>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>