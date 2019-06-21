<?php

//include 'db_connection.php';
include 'functions.php';

$conn = OpenCon();


 // array for JSON response
$response = array();


//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

//Check for Mandatory parameters
if(isset($input['Username']) && isset($input['Email']) && isset($input['Password']) && isset($input["AreaName"])){
	$username = mysqli_escape_string($conn, $input['Username']);
	$username =htmlspecialchars($username);

	$email = mysqli_escape_string($conn, $input['Email']);
	$email =htmlspecialchars($email);

	$password = mysqli_escape_string($conn, $input['Password']);
	$password = htmlspecialchars($password);

	$areaName = mysqli_escape_string($conn, $input['AreaName']);
	$areaName = htmlspecialchars($areaName);
	
	if(!username_Exists($username , $conn) && !email_Exists($email , $conn)){
		$insertQuery = "INSERT INTO user(Username,Email,Password,AreaId) VALUES 
		(?,?,?,(SELECT AreaId from Area WHERE Area_name = ?))";

		if($stmt = $conn->prepare($insertQuery)){
			$stmt->bind_param("ssss",$username,$email,$password,$areaName);
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