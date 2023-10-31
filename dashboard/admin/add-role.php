<?php

session_start();

require_once dirname(__DIR__, 2) . '/includes/functions.php';

if ( ! isset($_SESSION['loggedin'])) {
    redirect('/login.php');
}
if ( ! isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    redirect('/login.php');
}
req("includes/classes/DB.php");

$rolesDb = new DB("roles.json");
$roles   = $rolesDb->read()->getData(true);
$errors  = [];


if (isset($_POST['add'])) {
    $role     = $_POST['role'] ?? '';
    $roleSlug = '';
    if ( ! empty($role)) {
        $roleSlug = preg_replace('/([^a-z ])/i', '', $role);
        $roleSlug = strtolower(rtrim(str_replace(' ', '-', $roleSlug), ' -'));
    }

    if (empty($role) || empty($roleSlug) || array_key_exists($roleSlug, $roles)) {
        $errors['role'] = 'Invalid Role';
    }

    if ( ! $errors) {
        $roles[$roleSlug] = $role;

        $status = $rolesDb->write($roles, true);
        if ($status !== false) {
            redirect("/dashboard/admin/add-role.php");
        }
    }
}


$pageSubHeading = 'Add New Role';
$settings       = [
    'title' => $pageSubHeading,
];


getHeader('dashboard/common/header.php', $settings);
?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php
        getTemplate('dashboard/common/navbar.php', ['page' => 'Add New', 'pageSubHeading' => $pageSubHeading]); ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row mb-4 align-items-center justify-content-center">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6><?= $pageSubHeading; ?></h6>
                        </div>
                        <div class="card-body p-3">
                            <form method="POST">
                                <div class="input-group input-group-outline is-focused focused mb-4">
                                    <label class="form-label">User Role</label>
                                    <input type="text" name="role" class="form-control" value="<?= $role ?? '' ?>">
                                    <div class="text-danger w-100"><small><?= $errors['role'] ?? ''; ?></small></div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="add"
                                            class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0">Add Role
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 align-items-center justify-content-center">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>User Roles</h6>
                        </div>
                        <div class="card-body p-3">
                            <table class="table align-items-center mb-0">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Slug
                                    </th>
                                </tr>
                                <?php
                                foreach ($roles as $key => $role): ?>
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $role ?></p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0"><?= $key ?></p>
                                    </td>

                                </tr>
                                <?php
                                endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            getTemplate('dashboard/common/copyright.php'); ?>
        </div>
    </main>
<?php
getTemplate('dashboard/common/fixed-plugin.php');
getFooter('dashboard/common/footer.php');