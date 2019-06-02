<?php

//include 'db_connection.php';
include 'functions.php';

$conn = OpenCon();


 // array for JSON response
$response = array();


//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

$input['Username']="soha";
$input['Email']="sohasanad@gmail.com";
$input['Password']="123456";

//Check for Mandatory parameters
if(isset($input['Username']) && isset($input['Email']) && isset($input['Password'])){
	$username = $input['Username'];
	$email = $input['Email'];
	$password = $input['Password'];

	if(!username_Exists($username , $conn) && !email_Exists($email , $conn)){
		$insertQuery = "INSERT INTO user(Username,Email,Password) VALUES (?,?,?)";
		if($stmt = $conn->prepare($insertQuery)){
			$stmt->bind_param("sss",$username,$email,$password);
			$stmt->execute();
			$response["status"] = 0;
			$response["message"] = "User created";
			$stmt->close();
		}
	}
	else{
		$response["status"] = 1;
		$response["message"] = "User exists";
	}

}
else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}

echo json_encode($response);

?>