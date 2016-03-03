<?php
session_start();

unset($_SESSION['logged_in']);
unset($_SESSION['user_id']);
unset($_SESSION['business_id']);
unset($_SESSION['type']);

session_destroy();
header("Location: http://foodbuddie.com");


?>