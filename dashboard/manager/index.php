<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/functions.php';


if(! isset($_SESSION['loggedin'])) {
    header('Location: /login.php');
}

if(! isset($_SESSION['role']) || $_SESSION['role'] !== 'manager') {
    redirectToDashboard($_SESSION['role']);
}
inc('/includes/classes/DB.php');

$settings    = [
    'title' => 'Manager Dashboard',
];

getHeader('dashboard/common/header.php', $settings);
?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <?php
        getTemplate('dashboard/common/headerNav.php', ['pageName' => 'Index', 'subTitle' => 'Dashboard']); ?>
        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-lg-8 col-md-6 mb-md-0 mb-4 offset-2">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6>Manager Dashboard</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <p>Manager Dashboard Content Goes Here!</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <?php
            getTemplate('dashboard/common/copyright.php'); ?>
        </div>
    </main>
<?php
getTemplate('dashboard/common/fixed-plugin.php', ['userName' => 'John Doe']);
getFooter('dashboard/common/footer.php');