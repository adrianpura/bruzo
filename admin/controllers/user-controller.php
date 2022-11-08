<?php
require_once("../include/initialize.php");

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
switch ($action) {
    case 'register':
        doRegister();
        break;
}

function doRegister()
{
    global $mydb;

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    $hashPassword = sha1($password);
    $mydb->setQuery("SELECT * FROM users WHERE email = '" . $email . "'");
    $userInDb = $mydb->loadResultList();

    if (count($userInDb) === 0) {
        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->password = $hashPassword;
        $user->role = $role;
        $user->create();
        echo json_encode(['code' => 200, 'msg' => "user created"]);
    } else {
        echo json_encode(['code' => 404, 'msg' => "user email already exists"]);
    }
}
