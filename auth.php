<?php
//check authentication if the user sign in or sign out to access.
session_start();
if (empty($_SESSION['id'])) {
    header("Location: login_form.php");
}
