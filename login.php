<?php

include 'functions.php';

$conn = OpenCon();

$response = array();

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON,TRUE);

//check mandatory parameters are set
if(isset($input['Email']) && isset($input['Password'])){

	$email = $input['Email'];
	$password = $input['Password'];
	$query = "SELECT UserId, Username , Email , Password FROM user WHERE Email=? && Password=?";

	if($stmt = $conn->prepare($query)){
		$stmt->bind_param("ss" , $email , $password);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_results($userId , $username , $email , $password);
		$stmt->fetch();
		if($stmt->num_rows == 1){
			$response["status"] = 0;
			$response["message"] = "Login successful";
			$response["UserId"]= $userId;
			$response["Username"] = $username;
		}
		else{
				$response["status"] = 1;
				$response["message"] = "Invalid username and password combination";
			}
	}
	else{
				$response["status"] = 1;
				$response["message"] = "Invalid username and password combination";
		}
}
else{
	$response["status"] = 2;
	$response["message"] = "Missing mandatory parameters";
}

//Display JSON response.
echo json_encode($response);

?>