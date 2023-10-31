<?php

require_once __DIR__ . '/includes/functions.php';
inc("/includes/classes/DB.php");
inc('/includes/classes/Validator.php');
$settings = [
    'title' => 'Register',
    'bodyClasses' => '',
];
$errors = [];

if(isset($_POST['register'])) {
    $db = new DB("users.json", 'ab+');
    $db->read();
    $users = $db->getData(true);

    $username = Validator::username($_POST['username'] ?? '');
    $email = Validator::email($_POST['email'] ?? '');
    $password = Validator::password($_POST['password']??'');

    if(! $username) {
        $errors['username'] = 'Username Not Valid';
    }
    if(! $email || array_key_exists($email, $users)) {
        $errors['email'] = 'Email Not Valid';
    }
    if(! $password) {
        $errors['password'] = 'Password must be at least 8 characters long and have at least one lowercase, uppercase, number and symbol in it.';
    }



    if(! $errors) {
        $users[$email] = [
            'id' => uniqid(),
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'role' => 'user',
        ];

        $status = $db->write($users, true);
        if($status !== false) {
            redirect("/login.php");
        }

    }

}

getHeader('', $settings);
getTemplate('/public/register.php', ['errors' => $errors]);
getFooter();