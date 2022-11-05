<?php
require_once 'include/initialize.php';
unset($_SESSION['id']);
unset($_SESSION['first_name']);
unset($_SESSION['last_name']);
unset($_SESSION['email']);
redirect("login.php?logout=1");
