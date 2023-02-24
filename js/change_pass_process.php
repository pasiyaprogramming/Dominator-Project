<?php

require_once 'auth.php'; //check user sign in
require_once 'head.php'; //head file
require_once 'connection.php'; //database connection

$error = array(); //declare a variable to get error
$res = array(); //declare a variable to get response from the database

$pass = $_POST['psw']; //declare a variable to get password from the form


//form validation

//check password field is empty 
if (empty($_POST['psw'])) {
    $error[] = "Password cannot be empty!";
}

//check confirm password field is empty
if (empty($_POST['cpsw'])) {
    $error[] = "Confirm Password cannot be empty!";
}

//check user's input password and confirm password both are same
if ($_POST['psw'] != $_POST['cpsw']) {
    $error[] = "Password and Confirm Password should be same!";
}

//password changing process
$sql = ("UPDATE users SET psw = :pass WHERE user_id = :user_id"); //sql statement for update password
$stmt = $db->prepare($sql);     //preparing sql statement for execute
$stmt->bindParam(':pass', $pass);   //pass the password from user input to sql statement
$stmt->bindParam(':user_id', $_SESSION['user_id']); //pass the user id to sql statement get from head.php file

//check if user entered old password
$chk = $db->prepare("SELECT user_id = :user_id FROM users WHERE psw= :pass"); //preparing sql statement for user entered old password for changing to new password
$chk->bindParam(':user_id', $_SESSION['user_id']); // pass the user id to sql statement from head.php
$chk->bindParam(':pass', $pass);  //pass the password from user input to sql statement
$chk->execute(); //execute sql statement
$result = $chk->rowCount(); //get users row from the database

//send errors to front-end from the backend

//from validation error's sent to the front-end
if (count($error) > 0) {  //check error count
    $resp['msg'] = $error; //response message from the database to front-end
    $resp['status'] = false; //send status to the front-end
    echo json_encode($resp); //send json response to display error
    exit; //exit

    //send error if user entered old password
} else if ($result > 0) { //check user's row in the database
    $error[] = "You Entered Old Password! "; //error message
    $resp['msg'] = $error; //response message from the database to front-end
    $resp['status'] = false; //send status to the front-end
    echo json_encode($resp); //send json response to display error
    exit; //exit

    //send password change success message
} else if ($stmt->execute()) { //execute sql statement
    $error[] = "Password Changed!"; //message
    $resp['msg'] = $error; //response message from the database to front-end
    $resp['status'] = true; //send status to the front-end
    echo json_encode($resp); //send json response to display error
    exit; //exit
}

?>