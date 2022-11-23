<?php
require_once("../include/initialize.php");

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
switch ($action) {
    case 'add':
        add();
        break;

    case 'delete':
        doDelete();
        break;
}

function add()
{
    global $mydb;

    $off_details = trim($_POST['off_details']);
    $start = $_POST['start'];
    $end = $_POST['end'];

    $oldStart = strtotime($start);
    $newStart = date('Y-m-d H:i:s', $oldStart);

    $oldEnd = strtotime($end);
    $newEnd = date('Y-m-d H:i:s', $oldEnd);

    $off = new Dayoff();
    $off->start = $newStart;
    $off->end = $newEnd;
    $off->details = $off_details;
    $insert = $off->create();
    if ($insert !== false) {
        echo json_encode(['code' => 200, 'msg' => "day off  added"]);
    } else {
        //success false
        echo json_encode(['code' => 404, 'msg' => "unable to add"]);
    }
}

function doDelete()
{
    global $mydb;

    $offId = $_POST['id'];
    $off = new Dayoff();
    $del = $off->delete($offId);
    if ($del !== false) {
        echo json_encode(['code' => 200, 'msg' => "deleted"]);
    } else {
        echo json_encode(['code' => 404, 'msg' => "unable to delete"]);
    }
}
