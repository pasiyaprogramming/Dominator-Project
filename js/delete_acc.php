<?php

require_once 'auth.php'; //check user sign in
require_once 'connection.php'; //database connection

$userid = $_SESSION['user_id']; //get user id when login

//delete account process
$sql = "DELETE FROM users WHERE user_id = :user_id"; //sql statement for account delete
$statement = $db->prepare($sql); //prepare sql statement to execute
$statement->bindParam(':user_id', $userid); //pass the user id sql statement

//if account is deleted it will redirect to login page
if ($statement->execute()) { //execute sql statement
    header('Location: login_form.php'); //redirect to login page
    die(); //exit
}
?>