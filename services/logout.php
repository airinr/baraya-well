<?php
session_start();
session_unset();
session_destroy();

header("Location: /baraya-well/login.php"); 
exit;
?>