<?php
require_once("../admin/include/initialize.php");
if (!isset($_SESSION['email'])) {
    redirect(web_root . "/admin/login.php");
}
include("layouts/header.php");
?>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <?php check_message(); ?>
            <div class="ibox" style="box-shadow: 0.3em 0.3em 1em rgba(0, 0, 0, 0.3);">
                <div class="ibox-title text-left">
                    <h5>Add Schedule</h5>
                </div>
                <div class="ibox-content text-left">
                    <form role="form">
                        <div class="form-group">
                            <label for="patient">Patient Name</label>
                            <input type="text" placeholder="Patient Name" class="form-control" name="patient">
                        </div>
                        <div class="form-group">
                            <label for="service">Service</label>
                            <select name="service" id="service">
                               <!-- options ning services -->
                                <option value=""></option>
                            </select>
                        </select>
                        </div>
                        <div class="form-group" id="date">
                            <label for="date">Date</label>
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                            </div>
                        </div>
                        <div class="form-group" id="time">
                            <label for="time">Time</label>
                            <div class="input-group clockpicker" data-autoclose="true">
                                <input type="text" class="form-control" value="09:30">
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit"><strong>Add Schedule</strong></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>