<?php
require_once("../include/initialize.php");

$action = (isset($_POST['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
    case 'upload':
		doUpload();
		break;

    case 'delete':
        doDelete();
        break;
    
}

function doUpload(){
    global $mydb;
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["new_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($_FILES["new_image"]["tmp_name"]);
    if ($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["new_image"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["new_image"]["tmp_name"], $target_file)) {
            $mydb->setQuery("INSERT INTO `gallery` (`image_path`) VALUES ('$target_file')");
            $mydb->executeQuery();
            echo json_encode(['code' => 200, 'msg' => "successfully saved"]);
        } else {
            echo json_encode(['code' => 404, 'msg' => "unable to save"]);
        }
    }

}

function doDelete(){
    global $mydb;
    $id = $_POST['id'];
    $mydb->setQuery("DELETE * FROM gallery WHERE id=$id");
    if($mydb->executeQuery()){
        echo json_encode(['code' => 200, 'msg' => "successfully deleted"]);
        // redirect('../gallery.php');
    }
    else {
        echo json_encode(['code' => 404, 'msg' => "unable to delete"]);
        // redirect('../gallery.php');
    }
    
}