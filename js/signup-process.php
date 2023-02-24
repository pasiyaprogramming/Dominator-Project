<?php

require_once "connection.php"; //database connection

$error = array(); //declare a variable to get error
$res = array(); //declare a variable to get response from the database


//get data from the form
if (isset($_POST["uname"]) && isset($_POST["email"]) && isset($_POST["psw"])) {

	//form validation

	//check name field is empty
	if (empty($_POST['uname'])) {
		$error[] = "Name field is required";
	}

	//check email field is empty
	if (empty($_POST['email'])) {
		$error[] = "Email field is required";
	}

	//check email is valid
	if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error[] = "Enter Valid Email address";
	}

	//check password field is empty
	if (empty($_POST['psw'])) {
		$error[] = "Password field is required";
	}

	//check confirm password field is empty
	if (empty($_POST['cpsw'])) {
		$error[] = "Confirm Password field is required";
	}

	//check user's input password and confirm password both are same
	if ($_POST['cpsw'] != $_POST['psw']) {
		$error[] = "Password and Confirm Password should be same!";
	}

	$username = $_POST['uname']; //get name and store in a variable

	$email = $_POST['email']; //get email and store in a variable

	$password = $_POST['psw']; //get password and store in a variable

	//check if user entered already used email
	$chk = $db->prepare("SELECT * FROM users WHERE email= ?"); //prepare sql statement for check email
	$chk->execute([$email]); //execute
	$result = $chk->rowCount(); //get row from the database

	//sql statement for insert data to database
	$stmt = $db->prepare("INSERT INTO users(uname, email, psw) VALUES(:uname, :uemail, :upassword)");
	$stmt->bindParam(':uname', $username); //pass the name from user input to sql statement
	$stmt->bindParam(':uemail', $email); //pass the email from user input to sql statement
	$stmt->bindParam(':upassword', $password); //pass the password from user input to sql statement

	//send errors to front-end from the backend
	//from validation error's sent to the front-end
	if (count($error) > 0) { //check error count
		$resp['msg'] = $error; //response message from the database to front-end
		$resp['status'] = false; //send status to the front-end
		echo json_encode($resp); //send json response to display error
		exit; //exit

		//send error if user entered already registerd email
	} else if ($result > 0) { //check user's row in the database
		$error[] = "Email already registered! please try again with different email "; //error message
		$resp['msg'] = $error; //response message from the database to front-end
		$resp['status'] = false; //send status to the front-end
		echo json_encode($resp); //send json response to display error

		//send email register success message
	} elseif ($stmt->execute()) { //execute sql statement
		$error[] = "Registration Success. Now you are redirect to Login Page!"; //message
		$resp['msg'] = $error; //response message from the database to front-end
		$resp['status'] = true; //send status to the front-end
		echo json_encode($resp); //send json response to display error
	}
}
