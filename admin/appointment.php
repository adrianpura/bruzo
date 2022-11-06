 <?php
    require_once("../admin/include/initialize.php");
    if (!isset($_SESSION['id'])) {
        redirect(web_root . "/admin/login.php");
    }
    $mydb->setQuery("SELECT status, count(*) as count FROM appointments WHERE status= 'pending'");
    $pending = $mydb->loadSingleResult();

    $mydb->setQuery("SELECT status, count(*) as count FROM appointments WHERE status= 'approved'");
    $approved = $mydb->loadSingleResult();

    $mydb->setQuery("SELECT status, count(*) as count FROM appointments WHERE status= 'cancelled'");
    $cancelled = $mydb->loadSingleResult();

    $pendingCount = isset($pending->count) ? $pending->count : 0;
    $approvedCount =  isset($approved->count) ? $approved->count : 0;
    $cancelledCount = isset($cancelled->count) ? $cancelled->count : 0;

    include("layouts/header.php");
    ?>

 <body>
     <!-- modal -->
     <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content animated bounceInRight">
                 <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                     <i class="fa fa-laptop modal-icon"></i>
                     <h4 class="modal-title">Modal title</h4>
                     <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small>
                 </div>
                 <div class="modal-body">
                     <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                         printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                         remaining essentially unchanged.</p>
                     <div class="form-group"><label>Sample Input</label> <input type="email" placeholder="Enter your email" class="form-control"></div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                     <button type="button" class="btn btn-primary">Save changes</button>
                 </div>
             </div>
         </div>
     </div>
     <!-- end modal -->
     <div id="wrapper">
         <?php include('layouts/navigations.php'); ?>
         <div class="row wrapper border-bottom white-bg page-heading">
             <div class="col-lg-10">
                 <h2>Monitor Appointment</h2>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item">
                         <a href="index.php">Home</a>
                     </li>
                     <li class="breadcrumb-item active">
                         <strong>Monitor Appointment</strong>
                     </li>
                 </ol>
             </div>
             <div class="col-lg-2">
             </div>
         </div>
         <div class="wrapper wrapper-content animated fadeInRight">
             <div class="row">
                 <div class="col-lg-3">
                     <div class="ibox ">
                         <div class="ibox-title">
                             <h5>Approved</h5>
                         </div>
                         <div class="ibox-content">
                             <h1 class="no-margins"><?php echo $approvedCount ?></h1>
                             <!-- <div class="stat-percent font-bold text-success">
                                     0% <i class="fa fa-bolt"></i>
                                 </div> -->
                             <small>Total Approved</small>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-3">
                     <div class="ibox ">
                         <div class="ibox-title">
                             <h5>Pending</h5>
                         </div>
                         <div class="ibox-content">
                             <h1 class="no-margins"><?php echo $pendingCount ?></h1>
                             <!-- <div class="stat-percent font-bold text-info">
                                     1% <i class="fa fa-level-up"></i>
                                 </div> -->
                             <small>Total Pending</small>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-3">
                     <div class="ibox ">
                         <div class="ibox-title">
                             <h5>Cancelled</h5>
                         </div>
                         <div class="ibox-content">
                             <h1 class="no-margins"><?php echo $cancelledCount ?></h1>
                             <!-- <div class="stat-percent font-bold text-warning">
                                     0% <i class="fa fa-level-up"></i>
                                 </div> -->
                             <small>Total Cancelled</small>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-lg-12">
                     <div class="row">
                         <div class="col-lg-12">
                             <a href="appointment_add.php" class="btn btn-primary add-appointment" id="add-appointment">
                                 <i class="fa fa-plus"></i>
                                 Add Apointment
                             </a>
                         </div>
                         <div class="col-lg-2">
                         </div>
                     </div>
                 </div>
             </div>
             <br>
             <div class="row">
                 <div class="col-lg-12">
                     <div class="ibox ">
                         <div class="ibox-title">
                             <h5>Appointment Schedule</h5>
                             <div class="ibox-tools">
                                 <a class="collapse-link">
                                     <i class="fa fa-chevron-up"></i>
                                 </a>
                             </div>
                         </div>
                         <div class="ibox-content">
                             <div class="table-responsive">
                                 <table class="table table-striped table-bordered table-hover dataTables-example">
                                     <thead>
                                         <tr>
                                             <th style="width: 20px;">Id</th>
                                             <th>Patient Name</th>
                                             <th>Service</th>
                                             <th>Date</th>
                                             <th>Time</th>
                                             <th>Status</th>
                                             <th>Action</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                            $mydb->setQuery("SELECT a.id,
                                                                    a.patientId,
                                                                    p.first_name,
                                                                    p.last_name,
                                                                    a.appointmentDate,
                                                                    a.appointmentTime,
                                                                    a.status 
                                                                    FROM appointments as a LEFT JOIN patients as p on a.patientId = p.id");
                                            $cur = $mydb->loadResultList();
                                            foreach ($cur as $result) {
                                                if ($result->status === "approved") {
                                                    $labelClass = 'primary';
                                                } else if ($result->status === "cancelled") {
                                                    $labelClass = 'danger';
                                                } else {
                                                    $labelClass = 'warning';
                                                }


                                                $mydb->setQuery("select c.service_name from services s 
                                                    LEFT JOIN cms_services c
                                                    on s.service = c.id
                                                    where s.patientId = $result->patientId");
                                                $services = $mydb->loadResultList();

                                                $ser = "";
                                                foreach ($services as $service) {

                                                    $ser .= '<span class="label label-info b-r-xl">' . ucfirst($service->service_name) . '</span> ';
                                                }
                                                echo '<tr>';
                                                // `Fullname`, `CompanyName`, `F_Address`, `S_Address`, `ContactNo`
                                                echo '<td>' . $result->id . '</td>';
                                                echo '<td>' . $result->first_name . ' ' . $result->last_name . '</td>';
                                                echo '<td>' . $ser . '</td>';
                                                echo '<td>' .  date("M d, Y", strtotime($result->appointmentDate)) . '</td>';
                                                echo '<td>' . $result->appointmentTime . '</td>';
                                                echo '<td><span class="label label-' . $labelClass . '">' . ucfirst($result->status) . '</span></td>';


                                                echo '<td style="float: right"> 
				  		<a title="View" href="appointment_view.php?action=view&id=' . $result->id . '" class="btn btn-info"> <i class="fa fa-eye"></i></a>
				  		<a title="Edit" href="appointment_view.php?action=edit&id=' . $result->id . '" class="btn btn-primary"> <i class="fa fa-edit"></i></a>
				  		<a title="Approve" id="' . $result->id . '" href="" title="Approved" class="btn btn-success approve_appointment"> <i class="fa fa-check"></i></a>
				  		<a title="Reschedule" href="appointment_view.php?action=reschedule&id=' . $result->id . '" class="btn btn-warning"> <i class="fa fa-repeat"></i></a>
				  		<a title="Cancel" href="appointment_view.php?action=cancel&id=' . $result->id . '" class="btn btn-danger"> <i class="fa fa-times"></i></a>
                                                    </td>';

                                                echo '</tr>';
                                            }
                                            ?>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
         <div class="footer">
             <div>
                 <strong>Copyright</strong> Bruzo Denta Care Clinic &copy; 2022
             </div>
         </div>
     </div>
     </div>

     <!-- Mainly scripts -->
     <script src="js/jquery-3.1.1.min.js"></script>
     <script src="js/popper.min.js"></script>
     <script src="js/bootstrap.js"></script>
     <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
     <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
     <!-- FooTable -->
     <!-- <script src="js/plugins/footable/footable.all.min.js"></script> -->
     <script src="js/plugins/dataTables/datatables.min.js"></script>
     <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
     <!-- Custom and plugin javascript -->
     <script src="js/inspinia.js"></script>
     <script src="js/plugins/pace/pace.min.js"></script>
     <!-- Page-Level Scripts -->
     <!-- Sweet alert -->
     <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
     <script>
         $(document).ready(function() {
            document.title = "Bruzo | Appointment";
             $('.dataTables-example').DataTable({
                 pageLength: 25,
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: [{
                         extend: 'copy'
                     },
                     {
                         extend: 'csv'
                     },
                     {
                         extend: 'excel',
                         title: 'Appointment History'
                     },
                     {
                         extend: 'pdf',
                         title: 'Appointment History'
                     },

                     {
                         extend: 'print',
                         customize: function(win) {
                             $(win.document.body).addClass('white-bg');
                             $(win.document.body).css('font-size', '10px');
                             $(win.document.body).find('table')
                                 .addClass('compact')
                                 .css('font-size', 'inherit');
                         }
                     }
                 ]
             });
             $('#appointment').addClass('active').siblings().removeClass('active');


             $('.approve_appointment').click(function(e) {
                 e.preventDefault();
                 var id = $(this).attr('id');
                 console.log('id: ', id);
                 swal({
                         title: "Approved this appointment?",
                         text: "",
                         type: "success",
                         showCancelButton: true,
                         confirmButtonColor: "#1ab394",
                         confirmButtonText: "Yes, approved it!",
                         cancelButtonText: "No, cancel plx!",
                         closeOnConfirm: false,
                         closeOnCancel: false
                     },
                     function(isConfirm) {
                         if (isConfirm) {
                             $.ajax({
                                 type: "POST",
                                 url: "controllers/appointment-controller.php?action=accept",
                                 dataType: "json",
                                 data: {
                                     id: id,
                                 },
                                 success: function(data) {
                                     console.log('data: ', data);
                                     if (data.code == "200") {
                                         swal("Accepted!", "Appointment accepted", "success");
                                         setTimeout(function() {
                                             window.location = "appointment.php";
                                         }, 1000);

                                     } else {
                                         swal("Unable to accept this appointment", data.msg, "error");
                                     }
                                 }
                             });

                         } else {
                             swal("Cancelled", "", "error");
                         }
                     });
             });
         });
     </script>
 </body>

 </html>