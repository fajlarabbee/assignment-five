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

if ( ! isset($_GET['id'])) {
    redirect('/dashboard/admin');
}

$usersDb = new DB('users.json');
$users   = $usersDb->read()->getData('json');



foreach ($users as $key => $user) {
    if ($user['id'] === $_GET['id'] && $user['email'] !== $_SESSION['email']) {
        unset($users[$key]);
    }
}
$status = $usersDb->write($users, true);
if ($status !== false) {
    redirect("/dashboard/admin/");
}