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

	case 'fetchStatus':
		dofetchStatus();
		break;

	case 'fetchClientStatus':
		dofetchClientStatus();
		break;

	case 'edit':
		doEditAppointment();
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
	$pid = isset($_GET['patientId']) ? $_GET['patientId'] : 0;
	$sql = $pid !== 0 ? "SELECT * FROM `events` where patientId in ($pid,0) " : "SELECT * FROM `events` ";
	$mydb->setQuery($sql);
	$result = $mydb->loadResultList();

	// $recursiveDate = array(
	// 	'id'   => 0,
	// 	'title'   => "8 Slots",
	// 	'start'   => "00:00",
	// 	'end'   => "17:00",
	// 	'appointmentId'   => 0,
	// 	'dow'   => [1, 2, 3, 4, 5],
	// 	'ranges' => [array(
	// 		'start' => '2022/11/26',
	// 		'end' => '2022/12/31',
	// 	)]
	// );



	foreach ($result as $row) {
		$oldStart = strtotime($row->start_event);
		$newStart = date('g a', $oldStart);

		$oldEnd = strtotime($row->end_event);
		$newEnd = date('g a', $oldEnd);


		$title = $row->appointmentId === "0" ?   $row->count . '  ' . $row->title : ' ' . $row->title . ' ' . $newStart . '-' . $newEnd;


		$data[] = array(
			'id'   => $row->id,
			'title'   => $title,
			'start'   => $row->start_event,
			'end'   => $row->end_event,
			'appointmentId'   => $row->appointmentId,
		);
	}
	// array_push($data, $recursiveDate);

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
	global $mydb;

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



	// check dayoff schedules
	$mydb->setQuery("SELECT * from day_offs");
	$dayoffs = $mydb->loadResultList();
	$proceed = true;

	foreach ($dayoffs as $key => $off) {
		# code...
		if (($new_date >= $off->start) && ($new_date <= $off->end)) {
			$proceed = false;
		}
	}

	if ($proceed === false) {
		echo json_encode(['code' => 409, 'msg' => "Unable to create an appointment"]);
	} else {
		// check appointment if exists
		$checkAppointment = new Appointments();
		$appointmentExists = $checkAppointment->single_appointment_time_date($new_date, $appointment_time);

		if ($appointmentExists === null) {
			$success = false;
			$patient = new Patients();
			$patient->first_name = $first_name;
			$patient->last_name = $last_name;
			$patient->address = $address;
			$patient->age = $age;
			$patient->userId = $_SESSION['id'];
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
		} else {
			echo json_encode(['code' => 409, 'msg' => "Appointment Time and Date already booked"]);
		}
	}
}


function doEditAppointment()
{
	//todo

	//update to appointments table

	$appointmentId = $_POST['id'];
	$doctor_remarks = trim($_POST['doctor_remarks']);
	$service_charge = trim($_POST['service_charge']);
	$tooth_tags = isset($_POST['tooth_tags']) ? array($_POST['tooth_tags']) : '';

	$success = false;
	$appointment = new Appointments();
	$appointment->doctor_remarks = $doctor_remarks;
	$appointment->service_charge = $service_charge;
	$appointmentUpdate = $appointment->update($appointmentId);


	if ($appointmentUpdate !== false) {
		$success = true;
		$deleteToothTags = new Tooth();
		$del = $deleteToothTags->delete($appointmentId);
		if ($del !== false) {
			$success = true;
			foreach ($tooth_tags[0] as $teeth) {
				$services = new Tooth();
				$services->appointmentId = $appointmentId;
				$services->tooth = $teeth;
				$services->create();
			}
		} else {
			$success = false;
		}
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

		$checkAppointment = new Appointments();
		$appointmentExists = $checkAppointment->single_appointment_time_date($appointment->appointmentDate, $appointment->appointmentTime);
		if ($appointmentExists === null) {
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
			$events->patientId = $patient->userId;
			$events->title = $patient->first_name . " " . $patient->last_name;
			$events->start_event = $start;
			$events->end_event = $end;
			$events->appointmentId = $appointmentId;
			$eventCreate = $events->create();


			$old_timestamp = strtotime($appointment->appointmentDate);
			$newApDate = date('Y-m-d', $old_timestamp);

			//count events based on date
			$mydb->setQuery("SELECT * from events where appointmentId <> 0 AND start_event like '%$newApDate%'");
			$eventDatas = $mydb->loadResultList();
			$appointmentCount = count($eventDatas);

			//get current event count based on date
			$mydb->setQuery("SELECT * from events where appointmentId= 0 AND start_event like '%$newApDate%'");
			$eventCurrentCount = $mydb->loadSingleResult();
			$currentAppointmentCount = $eventCurrentCount->count;

			$newEventCount = (int) $currentAppointmentCount - (int) $appointmentCount;

			$sqlEvent = "UPDATE events set count = $newEventCount WHERE appointmentId= 0 AND start_event like '%$newApDate%'";
			$mydb->setQuery($sqlEvent);
			$mydb->executeQuery();

			$appointments->status = "approved";
			$appointments->doctorID = $userId;
			$updateAppointment = $appointments->update($appointmentId);

			echo json_encode(['code' => 200, 'msg' => "appointment accepted", 'data' => $patient->userId]);
			// echo json_encode(['code' => 200, 'msg' => $patient]);
		} else {
			echo json_encode(['code' => 409, 'msg' => "Appointment Time and Date already booked"]);
		}
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
	$patient_userid = $_POST['patient_userid'];

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
			$events->patientId = $patient_userid;
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



		echo json_encode(['code' => 200, 'msg' => "appointment rescheduled", 'data' => $patient->userId]);
		// echo json_encode(['code' => 200, 'msg' => $patient]);
	}
}


function doCancelAppointment()
{
	global $mydb;

	$userId = $_SESSION['id'];
	$appointmentId = $_POST['id'];
	$cancel_details = $_POST['cancel_details'];
	$patient_userid = $_POST['patient_userid'];

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

		// $patients = new Patients();
		// $patient = $patients->single_patient_userId($patient_userid);


		$events = new Events();
		$events->delete($appointmentId);


		echo json_encode(['code' => 200, 'msg' => "appointment canceled", 'data' => $patient_userid]);
		// echo json_encode(['code' => 200, 'msg' => $patient]);
	}
}

function secondsToTime($seconds)
{
	$dtF = new \DateTime('@0');
	$dtT = new \DateTime("@$seconds");
	return $dtF->diff($dtT)->format('%h hours');
}

function dofetchStatus()
{
	include('connect.php');
	global $mydb;

	if (isset($_POST['view'])) {

		if ($_POST["view"] != '') {
			$update_query = "UPDATE appointments SET notif_status = 1 WHERE notif_status=0";
			mysqli_query($con, $update_query);
		}

		$query = "SELECT p.first_name,p.last_name,a.id , TIMESTAMPDIFF(MINUTE, a.created_at, NOW()) as minute
					FROM appointments a
					LEFT JOIN patients p on a.patientId=p.id
					ORDER BY a.id DESC LIMIT 5";
		$result = mysqli_query($con, $query);
		$output = '';

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result)) {
				$seconds = $row["minute"] * 60;
				$time = secondsToTime($seconds);
				$output .= '
						<li>
							<a href="appointment_view.php?action=view&id=' . $row["id"] . '" class="dropdown-item">
								<div>
									<i class="fa fa-envelope fa-fw"></i> You have new appointment from ' . $row["first_name"] . ' ' . $row["last_name"] . '
									<span class="float-right text-muted small">' . $time . ' ago</span>
								</div>
							</a>
						</li>
		  				';
			}
		} else {
			$output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
		}

		$status_query = "SELECT * FROM appointments WHERE notif_status=0";
		$result_query = mysqli_query($con, $status_query);
		$count = mysqli_num_rows($result_query);

		$data = array(
			'notification' => $output,
			'unseen_notification'  => $count
		);
		echo json_encode($data);
	}
}

function dofetchClientStatus()
{
	include('connect.php');
	global $mydb;



	if (isset($_POST['view'])) {

		$clientUserId = $_GET['clientUserId'];
		if ($_POST["view"] != '') {
			$update_query = "UPDATE appointments
										JOIN patients
										ON appointments.patientId = patients.id
								SET    appointments.notif_status_client = 1
								WHERE appointments.notif_status_client=0 AND appointments.status in  ('approved','cancelled') AND
								patients.userId=$clientUserId";
			mysqli_query($con, $update_query);
		}
		$query = "SELECT p.first_name,p.last_name,a.id,a.appointmentDate,a.appointmentTime,a.resched_details,a.cancel_details,a.doctor_remarks,a.status,
							TIMESTAMPDIFF(MINUTE, a.created_at, NOW()) as minute
							FROM appointments a
							LEFT JOIN patients p on a.patientId=p.id
							WHERE p.userId=$clientUserId and a.status in ('approved','cancelled')
							ORDER BY a.id DESC LIMIT 5";
		$result = mysqli_query($con, $query);
		$output = '';

		if (mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result)) {
				$seconds = $row["minute"] * 60;
				$time = secondsToTime($seconds);
				$notifDescription = "";
				if (isset($row["resched_details"])) {
					$notifDescription = 'Your ' .  date("M d, Y", strtotime($row["appointmentDate"])) . ' appointment  is rescheduled and ' . $row["status"] . '';
				} else {
					$notifDescription = 'Your ' .  date("M d, Y", strtotime($row["appointmentDate"])) . ' appointment  is ' . $row["status"] . '';
				}
				$output .= '
						<li>
							<a href="appointment_view.php?action=view&id=' . $row["id"] . '" class="dropdown-item">
								<div>
									<i class="fa fa-envelope fa-fw"></i>' . $notifDescription . '
									<span class="float-right text-muted small">' . $time . ' ago</span>
								</div>
							</a>
						</li>
		  				';
			}
		} else {
			$output .= '<li><a href="#" class="text-bold text-italic">No notification found!</a></li>';
		}

		$status_query = "SELECT * FROM appointments a LEFT JOIN patients p  on a.patientId=p.id WHERE a.notif_status_client=0 and p.userId = $clientUserId and a.status in ('approved','cancelled')";
		$result_query = mysqli_query($con, $status_query);
		$count = mysqli_num_rows($result_query);

		$data = array(
			'notification' => $output,
			'unseen_notification'  => $count
		);
		echo json_encode($data);
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
