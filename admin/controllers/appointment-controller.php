<?php
require_once("../include/initialize.php");

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
switch ($action) {
	case 'add':
		doInsert();
		break;

	case 'accept':
		doAcceptAppintment();
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

function setEventTime($date, $time)
{
	$eventDate = new DateTime($date);
	$eventDate->getTimestamp();
	$eventDate->setTime($time, 0, 0);
	return $eventDate->format('Y-m-d H:i:s');
}

function doInsert()
{
	//todo
	//insert to patients table
	//insert to appointments table

	//insert to service table
	//insert to events table


	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$email = trim($_POST['email']);
	$age = trim($_POST['age']);
	$details = trim($_POST['details']);
	$mobile = trim($_POST['mobile']);
	$gender = trim($_POST['gender']);
	$appointment_date = $_POST['appointment_date'];
	$appointment_time = $_POST['appointment_time'];
	$address = trim($_POST['address']);
	$concerns = isset($_POST['appointment_concern']) ? array($_POST['appointment_concern']) : '';

	$old_date_timestamp = strtotime($appointment_date);
	$new_date = date('Y-m-d H:i:s', $old_date_timestamp);


	switch ($appointment_time) {
		case '9-10':
			$start = setEventTime($appointment_date, 9);
			$end = setEventTime($appointment_date, 10);
			break;

		case '10-11':
			$start = setEventTime($appointment_date, 10);
			$end = setEventTime($appointment_date, 11);
			break;

		case '11-12':
			$start = setEventTime($appointment_date, 11);
			$end = setEventTime($appointment_date, 12);
			break;

		case '1-2':
			$start = setEventTime($appointment_date, 13);
			$end = setEventTime($appointment_date, 14);
			break;
		case '2-3':
			$start = setEventTime($appointment_date, 14);
			$end = setEventTime($appointment_date, 15);
			break;

		case '3-4':
			$start = setEventTime($appointment_date, 15);
			$end = setEventTime($appointment_date, 16);
			break;

		case '4-5':
			$start = setEventTime($appointment_date, 16);
			$end = setEventTime($appointment_date, 17);
			break;
	}

	$success = false;


	$patient = new Patients();
	$patient->first_name = $first_name;
	$patient->last_name = $last_name;
	$patient->address = $address;
	$patient->age = $age;
	$patient->sex = $gender;
	$patient->contact_number = $mobile;
	$patient->email = $email;
	$patientId = $patient->create();

	if ($patientId !== false) {
		$success = true;
		$appointment = new Appointments();
		$appointment->patientId = $patientId;
		$appointment->appointmentDate = $new_date;
		$appointment->appointmentTime = $appointment_time;
		$appointment->status = "pending";
		$appointment->details = $details;
		$appointmentCreate = $appointment->create();

		$events = new Events();
		$events->patientId = $patientId;
		$events->title = $first_name . " " . $last_name;
		$events->start_event = $start;
		$events->end_event = $end;
		$eventCreate = $events->create();

		if ($appointmentCreate !== false && $eventCreate !== false) {
			$success = true;
			foreach ($concerns[0] as $concern) {
				$services = new Services();
				$services->patientId = $patientId;
				$services->service = $concern;
				$services->create();
			}
		} else {
			$success = false;
		}
	} else {
		$success = false;
	}

	if ($success) {
		echo json_encode(['code' => 200, 'msg' => "successfully saved"]);
	} else {
		echo json_encode(['code' => 404, 'msg' => "unable to save"]);
	}
}

function doAcceptAppintment()
{
	global $mydb;
	var_dump($_POST['id']);
	echo ($_SESSION['id']);
	var_dump("sadasd");

	$userId = $_SESSION['id'];
	$appointmentId = $_POST['id'];

	$mydb->setQuery("SELECT * from users where id =$userId");
	$cur = $mydb->loadSingleResult();
	var_dump($cur);
	echo json_encode(['code' => 404, 'msg' => $cur]);


	// if (isset($_POST['save'])) {

	// 	$patient = new Patients();
	// 	$patient->Fname		= $_POST['Fname'];
	// 	$patient->Mname		= $_POST['Mname'];
	// 	$patient->Lname		= $_POST['Lname'];
	// 	$patient->F_Address		= $_POST['F_Address'];
	// 	$patient->Sex		= $_POST['Sex'];
	// 	$patient->Age		= $_POST['Age'];
	// 	$patient->ContactNo		= $_POST['ContactNo'];
	// 	$patient->update($_POST['PatientID']);

	// 	message("Patient has been updated!", "success");
	// 	redirect("index.php");
	// }
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
