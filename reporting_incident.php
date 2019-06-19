<?php

include 'db_connection.php';

$conn = OpenCon();

$response = array();

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

//Check for Mandatory parameters
if(isset($input['title']) && isset($input['area']) && isset($input['category']) ){
	/*$username = mysqli_escape_string($input['Username']);
	//$username =htmlspecialchars($username);

	$email = mysqli_escape_string($input['Email']);
	$email =htmlspecialchars($email);

	$password = mysqli_escape_string($input['Password']);
	$password = htmlspecialchars($password);*/
	/*
	if(!username_Exists($username , $conn) && !email_Exists($email , $conn)){
		$insertQuery = "INSERT INTO user(Username,Email,Password) VALUES (?,?,?)";
		if($stmt = $conn->prepare($insertQuery)){
			$stmt->bind_param("sss",$username,$email,$password);
			$stmt->execute();
			$response["status"] = 0;
			$response["message"] = "User created";
			$stmt->close();
		}
		*/

		echo $input['title'] ;
		echo $input['area'];
		//echo $input['severity'];
		echo $input['category'];

		$response["status"] = 0;
		$response["message"] = "Successful";

	}
	else{
		$response["status"] = 1;
		$response["message"] = "reporting was not successful";
	}


echo json_encode($response);

?>