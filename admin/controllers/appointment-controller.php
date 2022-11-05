<?php
require_once("../include/initialize.php");

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';
switch ($action) {
	case 'add':
		doInsert();
		break;

	case 'accept':
		doAcceptAppointment();
		break;

	case 'reschedule':
		doRescheduleAppointment();
		break;

	case 'cancel':
		doCancelAppointment();
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



		if ($appointmentCreate !== false) {
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

function doAcceptAppointment()
{
	global $mydb;

	$userId = $_SESSION['id'];
	$appointmentId = $_POST['id'];

	$mydb->setQuery("SELECT * from users where id =$userId");
	$user = $mydb->loadSingleResult();
	if ($user->role === "admin") {
		echo json_encode(['code' => 404, 'msg' => "user admin unable to accept appointment/s"]);
	} else {
		$appointments = new Appointments();
		$appointment = $appointments->single_appointment($appointmentId);


		switch ($appointment->appointmentTime) {
			case '9-10':
				$start = setEventTime($appointment->appointmentDate, 9);
				$end = setEventTime($appointment->appointmentDate, 10);
				break;

			case '10-11':
				$start = setEventTime($appointment->appointmentDate, 10);
				$end = setEventTime($appointment->appointmentDate, 11);
				break;

			case '11-12':
				$start = setEventTime($appointment->appointmentDate, 11);
				$end = setEventTime($appointment->appointmentDate, 12);
				break;

			case '1-2':
				$start = setEventTime($appointment->appointmentDate, 13);
				$end = setEventTime($appointment->appointmentDate, 14);
				break;
			case '2-3':
				$start = setEventTime($appointment->appointmentDate, 14);
				$end = setEventTime($appointment->appointmentDate, 15);
				break;

			case '3-4':
				$start = setEventTime($appointment->appointmentDate, 15);
				$end = setEventTime($appointment->appointmentDate, 16);
				break;

			case '4-5':
				$start = setEventTime($appointment->appointmentDate, 16);
				$end = setEventTime($appointment->appointmentDate, 17);
				break;
		}

		$patients = new Patients();
		$patient = $patients->single_patient($appointment->patientId);


		$events = new Events();
		$events->patientId = $appointment->patientId;
		$events->title = $patient->first_name . " " . $patient->last_name;
		$events->start_event = $start;
		$events->end_event = $end;
		$events->appointmentId = $appointmentId;
		$eventCreate = $events->create();

		$appointments->status = "approved";
		$appointments->doctorID = $userId;
		$updateAppointment = $appointments->update($appointmentId);

		echo json_encode(['code' => 200, 'msg' => "appointment accepted"]);
		// echo json_encode(['code' => 200, 'msg' => $patient]);
	}
}

function doRescheduleAppointment()
{
	global $mydb;

	$userId = $_SESSION['id'];
	$appointmentId = $_POST['id'];
	$appointmentDate = $_POST['appointment_date'];
	$appointmentTime = $_POST['appointment_time'];
	$resched_details = $_POST['resched_details'];

	$old_date_timestamp = strtotime($appointmentDate);
	$new_date = date('Y-m-d H:i:s', $old_date_timestamp);

	$mydb->setQuery("SELECT * from users where id =$userId");
	$user = $mydb->loadSingleResult();
	if ($user->role === "admin") {
		echo json_encode(['code' => 404, 'msg' => "user admin unable to reschedule appointment/s"]);
	} else {
		//todo
		//update appointments table
		//update events table

		$appointments = new Appointments();
		$appointment = $appointments->single_appointment($appointmentId);

		switch ($appointmentTime) {
			case '9-10':
				$start = setEventTime($appointmentDate, 9);
				$end = setEventTime($appointmentDate, 10);
				break;

			case '10-11':
				$start = setEventTime($appointmentDate, 10);
				$end = setEventTime($appointmentDate, 11);
				break;

			case '11-12':
				$start = setEventTime($appointmentDate, 11);
				$end = setEventTime($appointmentDate, 12);
				break;

			case '1-2':
				$start = setEventTime($appointmentDate, 13);
				$end = setEventTime($appointmentDate, 14);
				break;
			case '2-3':
				$start = setEventTime($appointmentDate, 14);
				$end = setEventTime($appointmentDate, 15);
				break;

			case '3-4':
				$start = setEventTime($appointmentDate, 15);
				$end = setEventTime($appointmentDate, 16);
				break;

			case '4-5':
				$start = setEventTime($appointmentDate, 16);
				$end = setEventTime($appointmentDate, 17);
				break;
		}
		$patients = new Patients();
		$patient = $patients->single_patient($appointment->patientId);

		if ($appointment->status !== "approved") {
			$events = new Events();
			$events->patientId = $appointment->patientId;
			$events->title = $patient->first_name . " " . $patient->last_name;
			$events->start_event = $start;
			$events->end_event = $end;
			$events->appointmentId = $appointmentId;
			$events->create();
		} else {
			$events = new Events();
			$events->start_event = $start;
			$events->end_event = $end;
			$events->update($appointmentId);
		}



		$appointments->appointmentDate = $new_date;
		$appointments->appointmentTime = $appointmentTime;
		$appointments->doctorID = $userId;
		$appointments->resched_details = $resched_details;
		$appointments->status = "approved";
		$appointments->update($appointmentId);



		echo json_encode(['code' => 200, 'msg' => "appointment rescheduled"]);
		// echo json_encode(['code' => 200, 'msg' => $patient]);
	}
}


function doCancelAppointment()
{
	global $mydb;

	$userId = $_SESSION['id'];
	$appointmentId = $_POST['id'];
	$cancel_details = $_POST['cancel_details'];

	$mydb->setQuery("SELECT * from users where id =$userId");
	$user = $mydb->loadSingleResult();
	if ($user->role === "admin") {
		echo json_encode(['code' => 404, 'msg' => "user admin unable to cancel appointment/s"]);
	} else {
		//todo
		//update appointments table
		//update status
		//remove from events table

		$appointments = new Appointments();
		$appointments->doctorID = $userId;
		$appointments->cancel_details = $cancel_details;
		$appointments->status = "cancelled";
		$appointments->update($appointmentId);

		$events = new Events();
		$events->delete($appointmentId);



		echo json_encode(['code' => 200, 'msg' => "appointment canceled"]);
		// echo json_encode(['code' => 200, 'msg' => $patient]);
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
