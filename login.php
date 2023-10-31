<?php

require_once __DIR__ . '/includes/functions.php';
inc('/includes/classes/DB.php');
inc('/includes/classes/Validator.php');
$settings = [
    'title'      => 'Login',
    'rememberMe' => false
];

$errors = [];

if(isset($_POST['signin'])) {
    $db = new DB("users.json", 'ab+');
    $db->read();
    $users = $db->getData(true);

    $email = Validator::email($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if( empty($email) || ! array_key_exists($email, $users) ) {
        $errors['validation'] = 'Email or Password didn\'t match';
    }
    if(! $errors && (empty($password) || $users[$email]['password'] !== $password)) {
        $errors['validation'] = 'Password didn\'t match';
    }

    if(! $errors) {
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $users[$email]['username'];
        $_SESSION['role'] = $users[$email]['role'];
        redirectToDashboard($users[$email]['role']);
    }

}

getHeader('', $settings);
getTemplate('/public/sign-in.php', ['errors' => $errors]);
getFooter();
