<?php
require_once("../include/initialize.php");

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
    case 'delete':
        doDelete();
        break;
}

function doDelete(){
    global $mydb;
    $id = $_POST['id'];
    $query = $mydb->setQuery("DELETE FROM gallery WHERE id=$id");
    $q = $mydb->executeQuery($query);
    if ($q) {
        echo json_encode(['code' => 200, 'msg' => "service deleted"]);
    } else {
        echo json_encode(['code' => 404, 'msg' => "unable to delete"]);
    }
}