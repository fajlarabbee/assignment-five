<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#" target="_blank">
            <img src="<?= asset('/assets/img/logo-ct.png') ?>" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">Ostad Assignment</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?= (urlIs('/dashboard/admin/index.php') || urlIs('/dashboard/admin/')) ? ' active bg-gradient-primary ' : '' ?>" href="<?= (urlIs('/dashboard/admin/index.php') || urlIs('/dashboard/admin/')) ? '#' : '/dashboard/admin' ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= urlIs('/dashboard/admin/add.php') ? ' active bg-gradient-primary ' : '' ?> " href="<?= urlIs('/dashboard/admin/add.php') ? '#' : '/dashboard/admin/add.php' ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">add</i>
                        </div>
                        <span class="nav-link-text ms-1">Add User</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= urlIs('/dashboard/admin/add-role.php') ? ' active bg-gradient-primary ' : '' ?> " href="<?= urlIs('/dashboard/admin/add-role.php') ? '#' : '/dashboard/admin/add-role.php' ?>">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">add</i>
                        </div>
                        <span class="nav-link-text ms-1">Add Role</span>
                    </a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link text-white active bg-gradient-primary" href="#">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>
                        <span class="nav-link-text ms-1">Dashboard</span>
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3 mb-4">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white " href="/logout.php">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">logout</i>
                        </div>
                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                </li>
            </ul>

        </div>
    </div>
</aside>
