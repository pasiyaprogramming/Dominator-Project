<?php
require_once 'connection.php'; //database connection

$error = array(); //declare a variable to get error
$res = array(); //declare a variable to get response from the database


//form validation

//check email field is empty
if (empty($_POST['email'])) {
    $error[] = "Email field is required";
}

//check password field is empty
if (empty($_POST['psw'])) {
    $error[] = "Password field is required";
}

//check email is valid
if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $error[] = "Enter Valid Email address";
}

//send errors to front-end from the backend

//from validation error's sent to the front-end
if (count($error) > 0) { //check error count
    $resp['msg'] = $error; //response message from the database to front-end
    $resp['status'] = false; //send status to the front-end
    echo json_encode($resp); //send json response to display error
    exit; //exit
}

//sql statement for login 
$statement = $db->prepare("SELECT * FROM pharmacy WHERE email = :email"); //prepare sql statement for check email
$statement->execute(array(':email' => $_POST['email'])); //pass the email from user input to sql statement
$row = $statement->fetchAll(PDO::FETCH_ASSOC); //execute and fetch data from the database

//send errors to front-end from the backend

//check password and email
if (count($row) > 0) { //user's password 
    if ($_POST['psw'] != $row[0]['psw']) { //check user entered password same as saved password in the database
        $error[] = "Password is not valid"; //error message
        $resp['msg'] = $error; //response message from the database to front-end
        $resp['status'] = false; //send status to the front-end
        echo json_encode($resp); //send json response to display error
        exit; //exit
    }

    //login success
    session_start(); //if login success session started
    $_SESSION['id'] = $row[0]['id']; //get user id from database
    $resp['status'] = true; //send status to the front-end
    echo json_encode($resp); //send json response to display error
    exit; //exit

    //email check from the database
} else {
    $error[] = "Email not found!"; //error message
    $resp['msg'] = $error; //response message from the database to front-end
    $resp['status'] = false; //send status to the front-end
    echo json_encode($resp); //send json response to display error
    exit; //exit
}
