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
    $address = trim($_POST['address']);
    $age = trim($_POST['age']);
    $sex = trim($_POST['sex']);
    $contact = trim($_POST['contact']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashPassword = sha1($password);


    $mydb->setQuery("SELECT * FROM users WHERE email = '" . $email . "'");
    $userInDb = $mydb->loadResultList();

    if (count($userInDb) === 0) {
        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->role = "patient";
        $user->password = $hashPassword;
        $userId = $user->create();
        if ($userId !== false) {
            $patient = new Patients();
            $patient->first_name = $first_name;
            $patient->last_name = $last_name;
            $patient->address = $address;
            $patient->age = $age;
            $patient->userId = $userId;
            $patient->sex = $sex;
            $patient->contact_number = $contact;
            $patient->email = $email;
            $patientId = $patient->create();
            if ($patientId !== false) {
                echo json_encode(['code' => 200, 'msg' => "user created"]);
            } else {
                echo json_encode(['code' => 500, 'msg' => "something went wrong"]);
            }
        }
    } else {
        echo json_encode(['code' => 404, 'msg' => "user email already exists"]);
    }
}
