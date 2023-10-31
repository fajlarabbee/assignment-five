<?php
session_start();

require_once dirname(__DIR__, 2) . '/includes/functions.php';

if(! isset($_SESSION['loggedin'])) {
    redirect('/login.php');
}
if(! isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    redirect('/login.php');
}
req("includes/classes/DB.php");
req('includes/classes/Validator.php');

$rolesDb = new DB("roles.json");
$roles = $rolesDb->read()->getData(true);

$usersDb = new DB('users.json');
$users = $usersDb->read()->getData('json');

$errors = [];


if(isset($_POST['add'])) {
    $username = Validator::username($_POST['username'] ?? '');
    $email = Validator::email($_POST['email'] ?? '');
    $password = Validator::password($_POST['password']??'');
    $role  = $_POST['role'] ?? '';

    if(! $username) {
        $errors['username'] = 'Username Not Valid';
    }
    if(! $email || array_key_exists($email, $users)) {
        $errors['email'] = 'Email Not Valid';
    }
    if(! $password) {
        $errors['password'] = 'Password must be at least 8 characters long and have at least one lowercase, uppercase, number and symbol in it.';
    }
    if(! $role || ! array_key_exists($role, $roles)) {
        $errors['role'] = 'Invalid Role';
    }

    if(! $errors) {
        $users[$email] = [
            'id' => uniqid(),
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => $role,
        ];

        $status = $usersDb->write($users, true);
        if($status !== false) {
            redirect("/dashboard/admin/");
        }

    }

}



$settings = [
    'title' => 'Add New User',
];
$pageSubHeading = 'Add New User';

getHeader('dashboard/common/header.php', $settings);
?>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <?php getTemplate('dashboard/common/navbar.php', ['page' => 'Add New', 'pageSubHeading' => $pageSubHeading]); ?>
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
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?= $username ?? '' ?>">
                                    <div class="text-danger w-100"><small><?= $errors['username'] ?? ''; ?></small></div>
                                </div>
                                <div class="input-group input-group-outline focused is-focused mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $email ?? '' ?>">
                                    <div class="text-danger w-100"><small><?= $errors['email'] ?? ''; ?></small></div>
                                </div>
                                <div class="input-group input-group-outline focused is-focused mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="input-group input-group-outline is-focused focused mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0 form-label">Choose User Role</label>
                                    <select class="form-control" name="role" id="exampleFormControlSelect1">
                                        <option value="">User Role</option>
                                        <?php foreach($roles as $key => $val): ?>
                                            <option value="<?= $key ?>" <?= isset($errors['role']) && isRole($errors['role'], $key) ? 'selected' : ''; ?>><?= $val ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="text-danger w-100"><small><?= $errors['role'] ?? ''; ?></small></div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" name="add" class="btn btn-lg bg-gradient-primary btn-lg mt-4 mb-0">Add User</button>
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