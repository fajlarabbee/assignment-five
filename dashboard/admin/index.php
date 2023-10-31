<?php

session_start();
require_once dirname(__DIR__, 2) . '/includes/functions.php';


if ( ! isset($_SESSION['loggedin'])) {
    redirect('/login.php');
}

if ( ! isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    redirect('/login.php');
}
inc('/includes/classes/DB.php');

$settings    = [
    'title' => 'Admin Dashboard',
];
$tableHeader = [
    'Name',
    'Email',
    'Role',
    'Actions',
];

$usersDb = new DB('users.json');
$users   = $usersDb->read()->getData(true);

$rolesDb = new DB('roles.json');
$roles   = $rolesDb->read()->getData(true);


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
                                    <h6>User Accounts</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Username
                                        </th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Email
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Role
                                        </th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ($users): ?>
                                        <?php
                                        foreach ($users as $user): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm"><?= $user['username'] ?></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="avatar-group mt-2">
                                                        <a href="mailto:<?= $user['email'] ?? '#' ?>"
                                                           data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                           title="<?= $user['username'] ?? '' ?>">
                                                            <?= $user['email'] ?? '' ?>
                                                        </a>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="text-xs font-weight-bold"> <?= $roles[$user['role']] ?? 'User' ?> </span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="action text-center w-75 mx-auto">
                                                        <a href="/dashboard/admin/edit.php?id=<?= $user['id'] ?>"
                                                           title="Edit" class="px-2 py-2">
                                                            <i class="material-icons opacity-10">edit</i>
                                                        </a>
                                                        <?php
                                                        if ($user['email'] !== $_SESSION['email']): ?>
                                                            <a href="/dashboard/admin/delete.php?id=<?= $user['id'] ?>"
                                                               title="Delete" class="px-2 py-2 delete-user">
                                                                <i class="material-icons opacity-10">delete</i>
                                                            </a>
                                                        <?php
                                                        else: ?>
                                                            <a href="#"
                                                               title="Delete" class="px-2 py-2 opacity-5 pe-none">
                                                                <i class="material-icons">delete</i>
                                                            </a>
                                                        <?php
                                                        endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        endforeach; ?>
                                    <?php
                                    else: ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-danger">No users found!</td>
                                        </tr>
                                    <?php
                                    endif; ?>
                                    </tbody>
                                </table>
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
getTemplate('dashboard/common/fixed-plugin.php');
getFooter('dashboard/common/footer.php');