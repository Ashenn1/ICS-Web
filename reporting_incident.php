<?php

include 'functions.php';

$conn = OpenConLocal();

$response = array();

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

//Check for Mandatory parameters
if( isset($input['title']) && isset($input['category']) && isset($input['severity']) && isset($input['area']) ){
	$title = mysqli_escape_string($conn, $input['title']);
	$title =htmlspecialchars($title);

	$category = mysqli_escape_string($conn, $input['category']);
	$category =htmlspecialchars($category);

	$severity = mysqli_escape_string($conn, $input['severity']);
	$severity = htmlspecialchars($severity);

	$area = mysqli_escape_string($conn, $input['area']);
	$area = htmlspecialchars($area);

	$UserId = 1;
	$Longitude = 31.126242183351;
	$Latitude = 30.017965481496;

	$insertQuery = "insert into incidents(UserId, Incident_name, Category, Severity, Incident_datetime, Longitude, Latitude, AreaId, Number_of_upvotes, Number_of_downvotes) VALUES (?, ?, ?, ?, SYSDATE(), ?, ?, (SELECT AreaId from Area WHERE Area_Name = ?), 0, 0)";
	if($stmt = $conn->prepare($insertQuery)){
		$stmt->bind_param("issiiis", $UserId, $title, $category, $severity, $Longitude, $Latitude, $area);
		$bool = $stmt->execute();
		if($bool){
			echo "true";
		}else{
			echo "false";
		}
		$response["status"] = 0;
		$response["message"] = "Incident Reported";
		$stmt->close();

	}
	else{
		$response["status"] = 1;
		$response["message"] = "reporting was not successful";
	}
echo json_encode($response);
}
?>
