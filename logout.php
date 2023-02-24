<?php
require_once 'auth.php'; //check user sign in

session_start(); //user sign in
session_destroy(); //user sign out from the database
header('location: login_form.php'); //redirect to login page
?>