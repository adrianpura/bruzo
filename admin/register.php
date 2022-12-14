 <?php
    require_once("../admin/include/initialize.php");

    if (isset($_SESSION['id'])) {
        redirect(web_root . "/admin/index.php");
    }
    include("layouts/header.php");
    ?>

 <body class="gray-bg">
     <div class="bg">
         <img src="../assets/img/background2.jpg" alt="">
     </div>
     <div class="middle-box text-center animated fadeInDown">
         <img src="../assets/img/bruzo.png" alt="" width="100" height="100">
         <h3>Welcome to Bruzo Dental Care Clinic</h3>
         <div class="ibox m-b-lg" style="box-shadow: 0.3em 0.3em 1em rgba(0, 0, 0, 0.3);">
             <div class="ibox-title text-left">
                 <h5>Register</h5>
             </div>
             <div class="ibox-content m-b-lg">
                 <form role="form" action="login.php">
                     <div class="form-group">
                         <input type="text" class="form-control" placeholder="First Name" id="first_name" required="">
                     </div>
                     <div class="form-group">
                         <input type="text" class="form-control" placeholder="Last Name" id="last_name" required="">
                     </div>
                     <div class="form-group">
                         <input type="address" class="form-control" placeholder="Address" id="address" required="">
                     </div>
                     <div class="form-group">
                         <input type="text" class="form-control" placeholder="Age" id="age" required="">
                     </div>
                     <div class="form-group row text-left">
                         <div class="col-sm-1"><label for="sex">Sex</label></div>
                         <div class="col-lg">
                             <select class="select2_demo_1 form-control gender" id="sex" name="sex">
                                 <option value=""></option>
                                 <option value="Male">Male</option>
                                 <option value="Female">Female</option>
                             </select>
                         </div>

                     </div>
                     <div class="form-group">
                         <input type="tel" class="form-control" placeholder="Contact Number" id="contact" required="">
                     </div>
                     <div class="form-group">
                         <input type="email" class="form-control" placeholder="Email" id="email" required="">
                     </div>
                     <div class="form-group">
                         <input type="password" class="form-control" placeholder="Password" id="password" required="">
                     </div>

                     <button type="submit" id="register" class="btn btn-primary block full-width m-b">Register</button>

                     <p class="text-muted text-center"><small>Already have an account?</small></p>
                     <a class="btn btn-sm btn-white btn-block" href="login.php">Login</a>
                 </form>
             </div>
         </div>
     </div>

     <!-- Mainly scripts -->
     <script src="js/jquery-3.1.1.min.js"></script>
     <script src="js/popper.min.js"></script>
     <script src="js/bootstrap.js"></script>
     <!-- iCheck -->
     <script src="js/plugins/iCheck/icheck.min.js"></script> <!-- Sweet alert -->
     <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
     <script>
         $(document).ready(function() {
             $('.i-checks').iCheck({
                 checkboxClass: 'icheckbox_square-green',
                 radioClass: 'iradio_square-green',
             });

             $('#register').click(function(e) {
                 e.preventDefault();
                 var first_name = $("#first_name").val();
                 var last_name = $("#last_name").val();
                 var address = $("#address").val();
                 var age = $("#age").val();
                 var sex = $("#sex").val();
                 var contact = $("#contact").val();
                 var email = $("#email").val();
                 var password = $("#password").val();
                 //  var role = $("#role").val();

                 $.ajax({
                     type: "POST",
                     url: "controllers/user-controller.php?action=register",
                     dataType: "json",
                     data: {
                         first_name: first_name,
                         last_name: last_name,
                         address: address,
                         age: age,
                         sex: sex,
                         contact: contact,
                         email: email,
                         password: password,
                     },
                     success: function(data) {
                         console.log('data: ', data);
                         if (data.code == "200") {
                             swal("User created please login to continue", data.msg, "success");
                             setTimeout(function() {
                                 window.location = "login.php";
                             }, 1000);
                         } else {
                             swal("Unable to register", data.msg, "error");
                         }
                     },
                     error: function(xhr, ajaxOptions, thrownError) {
                         console.log('thrownError: ', thrownError);
                     }
                 });
             });
         });
     </script>
 </body>

 </html>