<?php

//this is the head file
require_once 'connection.php';  //connect database

if (isset($_GET['user_id']) && isset($_GET['uname'])) {
    //get data from database

    $userid = $_GET['user_id']; //get user id from the database
    $uname = $_GET['uname']; //get user's register name from the database
    $sql = ("SELECT * FROM users WHERE user_id = :user_id"); //sql query for get user id 
    $statement = $db->prepare($sql); //sql statement prepare
    $statement->execute(array(":id" => $userid)); // sql statement
    $user = $statement->fetch(PDO::FETCH_ASSOC); //fetch data from the database
} else {
    //cannot fetch data from the database it will equal to 0
    $userid = null;
    $user = null;
}
?>