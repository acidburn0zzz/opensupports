<?php
require "controller.php";
staff_logs($TEXT['Staff offline']);
session_unset(); 
session_destroy();
header('Location: ../index.php');
?>