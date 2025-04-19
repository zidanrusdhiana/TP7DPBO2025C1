<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo (strpos($_SERVER['REQUEST_URI'], 'index.php') !== false || $_SERVER['REQUEST_URI'] == '/') ? 'active' : ''; ?>" href="index.php">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'kamar.php') !== false ? 'active' : ''; ?>" href="kamar.php">
                    <i class="bi bi-door-closed"></i> Kamar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'penyewa.php') !== false ? 'active' : ''; ?>" href="penyewa.php">
                    <i class="bi bi-people"></i> Penyewa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'pembayaran.php') !== false ? 'active' : ''; ?>" href="pembayaran.php">
                    <i class="bi bi-cash-coin"></i> Pembayaran
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo strpos($_SERVER['REQUEST_URI'], 'fasilitas.php') !== false ? 'active' : ''; ?>" href="fasilitas.php">
                    <i class="bi bi-box-seam"></i> Fasilitas
                </a>
            </li>
        </ul>
    </div>
</nav>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
