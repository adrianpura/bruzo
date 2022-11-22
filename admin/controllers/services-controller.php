<?php
require_once("../include/initialize.php");

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
switch ($action) {
    case 'delete':
        deleteService();
        break;

    case 'update':
        doUpdate();
        break;
}

function deleteService()
{
    global $mydb;

    $serviceId = $_POST['id'];
    $query = $mydb->setQuery("DELETE FROM cms_services WHERE id=$serviceId");
    $q = $mydb->executeQuery($query);
    if ($q) {
        echo json_encode(['code' => 200, 'msg' => "service deleted"]);
    } else {
        echo json_encode(['code' => 404, 'msg' => "unable to delete"]);
    }
}
