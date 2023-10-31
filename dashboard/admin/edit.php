<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/functions.php';

if(! isset($_SESSION['loggedin'])) {
    redirect('/login.php');
}
if(! isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    redirect('/login.php');
}
if(! isset($_GET['id'])) {
    redirect($_SERVER['HTTP_REFERER']);
}

req("includes/classes/DB.php");
req('includes/classes/Validator.php');

$rolesDb = new DB("roles.json");
$roles = $rolesDb->read()->getData(true);

$usersDb = new DB('users.json');
$users = $usersDb->read()->getData('json');

$errors = [];

if(isset($_POST['update'])) {
    $username = Validator::username($_POST['username'] ?? '');
    $role = $_POST['role'] ?? '';

    if(! $username) {
        $errors['username'] = 'Username Not Valid';
    }

    if(empty($role) || ! array_key_exists($_POST['role'], $roles)) {
        $errors['role'] = 'Role not valid';
    }


    if(! $errors) {
        foreach($users as $key => $user) {
            if($user['id'] === $_GET['id']) {
                $users[$key]['username'] = $username;
                $users[$key]['role'] = $role;
            }
        }
        $status = $usersDb->write($users, true);
        if($status !== false) {
            redirect("/dashboard/admin/");
        }

    }

}

$editUser = [];
foreach($users as $user) {
    if($user['id'] === $_GET['id']) {
        $editUser = $user;
        break;
    }
}

$settings = [
    'title' => 'Edit User',
];
$pageSubHeading = 'Edit User';

if($editUser) {
    extract($editUser);
}




getHeader('dashboard/common/header.php', $settings);
?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php getTemplate('dashboard/common/navbar.php', ['page' => 'Edit', 'pageSubHeading' => $pageSubHeading]); ?>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row mb-4 align-items-center justify-content-center">
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6><?= $pageSubHeading; ?></h6>
                        </div>
                        <div class="card-body p-3">
                            <form method="POST">
                                <div class="input-group input-group-outline is-focused focused mb-4">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?= $username ?? '' ?>">
                                </div>
                                <div class="input-group input-group-outline focused is-focused mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" disabled value="<?= $email ?? '' ?>">
                                </div>
                                <div class="input-group input-group-outline is-focused focused mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0 form-label">Choose User Role</label>
                                    <select class="form-control" name="role" id="exampleFormControlSelect1">
                                        <option value="">User Role</option>
                                        <?php foreach($roles as $key => $val): ?>
                                            <option value="<?= $key ?>" <?= isRole($key, $role) ? 'selected' : '' ?>><?= $val ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="update" class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0">Update User</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php getTemplate('dashboard/common/copyright.php'); ?>
        </div>
    </main>
<?php
getTemplate('dashboard/common/fixed-plugin.php', ['userName' => 'John Doe']);
getFooter('dashboard/common/footer.php');