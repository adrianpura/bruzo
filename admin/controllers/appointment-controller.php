<?php
require_once("../include/initialize.php");


$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
	case 'add':
		doInsert();
		break;

	case 'edit':
		doEdit();
		break;

	case 'delete':
		doDelete();
		break;

	case 'insertevent':
		doInsertvents();
		break;
	case 'updateevent':
		doUpdateEvents();
		break;

	case 'deleteevent':
		doDeleteEvents();
		break;

	case 'loadevent':
		doLoadEvents();
		break;
}

function doLoadEvents()
{
	global $mydb;

	$sql = "SELECT * FROM `events` ";
	$mydb->setQuery($sql);
	$result = $mydb->loadResultList();

	foreach ($result as $row) {
		$data[] = array(
			'id'   => $row->id,
			'title'   => ' - ' . $row->title,
			'start'   => $row->start_event,
			'end'   => $row->end_event
		);
	}

	echo json_encode($data);
}

function doInsert()
{
	global $mydb;
	// if(isset($_REQUEST['save'])){

	// // // `Fullname`, `CompanyName`, `F_Address`, `S_Address`, `ContactNo`

	$sql = "SELECT * FROM tblpatients WHERE Fname='" . trim($_POST['Fname']) . "' AND Lname='" . trim($_POST['Lname']) . "'  AND Mname='" . trim($_POST['Mname']) . "'";
	$mydb->setQuery($sql);
	$cur = $mydb->executeQuery();
	$maxrow = $mydb->num_rows($cur);

	if ($maxrow > 0) {

		if (isset($_GET['modal'])) {
			# code... 
			echo '<script>alert("Name already exist.");</script>';
		} else {
			message("Name already exist!", "error");
			redirect("index.php?view=add");
		}
	} else {

		$patient = new Patients();
		$patient->Fname		= trim($_POST['Fname']);
		$patient->Mname		= trim($_POST['Mname']);
		$patient->Lname		= trim($_POST['Lname']);
		$patient->F_Address		= $_POST['F_Address'];
		$patient->Sex		= $_POST['Sex'];
		$patient->Age		= $_POST['Age'];
		$patient->ContactNo		= $_POST['ContactNo'];
		$patient->create();


		if (isset($_GET['modal'])) {
			# code... 
			echo "New Patient created successfully!";
		} else {
			message("New Patient created successfully!", "success");
			redirect("index.php");
		}
	}




	// echo "get";
	// }  

}

function doEdit()
{
	if (isset($_POST['save'])) {

		$patient = new Patients();
		$patient->Fname		= $_POST['Fname'];
		$patient->Mname		= $_POST['Mname'];
		$patient->Lname		= $_POST['Lname'];
		$patient->F_Address		= $_POST['F_Address'];
		$patient->Sex		= $_POST['Sex'];
		$patient->Age		= $_POST['Age'];
		$patient->ContactNo		= $_POST['ContactNo'];
		$patient->update($_POST['PatientID']);

		message("Patient has been updated!", "success");
		redirect("index.php");
	}
}


function doDelete()
{
	global $mydb;
	// if (isset($_POST['selector'])==''){
	// message("Select a records first before you delete!","error");
	// redirect('index.php');
	// }else{

	$id = $_GET['id'];

	$patient = new Patients();
	$patient->delete($id);

	$user = new User();
	$user->delete($id);

	$sql = "DELETE FROM `tblinvoice` WHERE `PatientID`=" . $id;
	$mydb->setQuery($sql);
	$mydb->executeQuery();



	$sql = "DELETE FROM `tblpayments`  WHERE PatientID=" . $id;
	$mydb->setQuery($sql);
	$mydb->executeQuery();


	message("Patient has been Deleted!", "info");
	redirect('index.php');

	// $id = $_POST['selector'];
	// $key = count($id);

	// for($i=0;$i<$key;$i++){

	// 	$category = New Category();
	// 	$category->delete($id[$i]);

	// 	message("Category already Deleted!","info");
	// 	redirect('index.php');
	// }
	// }

}
function doInsertvents()
{
	global $mydb;

	$sql = "SELECT * FROM events WHERE title = '" . $_POST['title'] . "' AND start_event = '" . $_POST['start'] . "'";
	$mydb->setQuery($sql);
	$cur = $mydb->executeQuery();

	$maxrow = $mydb->num_rows($cur);
	if ($maxrow > 0) {
		# code...
	} else {

		$sql = "INSERT INTO `events`(`title`,start_event,end_event) VALUES ('" . $_POST['title'] . "','" . $_POST['start'] . "','" . $_POST['end'] . "')";
		$mydb->setQuery($sql);
		$mydb->executeQuery();
	}
}
function doUpdateEvents()
{
	global $mydb;
	echo $_POST['start'];
	$sql = "UPDATE `events` SET `title`='" . $_POST['title'] . "', `start_event`='" . $_POST['start'] . "', `end_event`='" . $_POST['end'] . "' WHERE id=" . $_POST['id'];
	$mydb->setQuery($sql);
	$mydb->executeQuery();
}

function doDeleteEvents()
{
	global $mydb;

	$sql = "DELETE FROM `events` WHERE id=" . $_POST['id'];
	$mydb->setQuery($sql);
	$mydb->executeQuery();
}
