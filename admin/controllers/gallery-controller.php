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
    
    $mydb->setQuery("SELECT image_path FROM gallery WHERE id=$id");
    $result = $mydb->loadSingleResult();
    $filename =$result->image_path;
    if (file_exists($filename)) {
        unlink($filename);
    } 

    $query = $mydb->setQuery("DELETE FROM gallery WHERE id=$id");
    $q = $mydb->executeQuery($query);
    if ($q) {
        echo json_encode(['code' => 200, 'msg' => "service deleted"]);
    } else {
        echo json_encode(['code' => 404, 'msg' => "unable to delete"]);
    }
}