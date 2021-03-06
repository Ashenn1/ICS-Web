<?php

include 'functions.php';

$conn = OpenCon();

$response = array();

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

//Check for Mandatory parameters
if(isset($input['title']) && isset($input['category']) && isset($input['severity']) && isset($input['area']) && isset($input['user_id'])){
	$title = mysqli_escape_string($conn, $input['title']);
	$title =htmlspecialchars($title);

	$category = mysqli_escape_string($conn, $input['category']);
	$category =htmlspecialchars($category);

	$severity = mysqli_escape_string($conn, $input['severity']);
	$severity = htmlspecialchars($severity);

	$area = mysqli_escape_string($conn, $input['area']);
	$area = htmlspecialchars($area);

	if(isset($input['image'])) {
		$image = $input['image'];
	} else {
		$image = "";
	}
	
	if(isset($input['description'])) {
		$description = $input['description'];
	} else {
		$description = "No Description";
	}
	
	$UserId = mysqli_escape_string($conn, $input['user_id']);
	$UserId = htmlspecialchars($UserId);;
	
	$Longitude = 31.126242183351;
	$Latitude = 30.017965481496;

	$insertQuery = "insert into incidents(UserId, Incident_name, Description, Category, Severity, ";
	$insertQuery .= "Incident_datetime, Longitude, Latitude, AreaId, Incident_photo, Number_of_upvotes, Number_of_downvotes) ";
	$insertQuery .= "VALUES (?, ?, ?, ?, ?, SYSDATE(), ?, ?, (SELECT AreaId from Area WHERE Area_Name = ?), ?, 0, 0)";
	if($stmt = $conn->prepare($insertQuery)){
		$stmt->bind_param("isssiiiss", $UserId, $title, $description, $category, $severity, $Longitude, $Latitude, $area, $image);
		$bool = $stmt->execute();
		$response["status"] = 0;
		$response["message"] = "Incident Reported";
		$stmt->close();

	}
	else{
		$response["status"] = 1;
		$response["message"] = "reporting was not successful";
	}


//Send notification to other users in the same area.
// Set POST variables

	$area = str_replace(' ', '', $area);	//stripping of all spaces
	$url = 'https://fcm.googleapis.com/fcm/send';

	//Get api from : firebase console->Project Options -> cloud Messaging -> server key
	$firebase_api = "AAAAXfqub3w:APA91bGn8dzeUx-Z0kSI03emL14bANuk81CHpm6oGrqplg2hKi7aukeGZZvqK4Tq4_2yhSdfK5-s7M9KAwRPVevhH1cFC0w5TquSXvogQgos4xwPqcSIF7qiB9rCXoOd0xIOsvj3PVhJ";

	$topic_url = "/topics/";
 
	$headers = array(
			'Authorization: key=' . $firebase_api,
			'Content-Type: application/json'
			);

	$requestData = array(
		"body" => $description,
        "title" => $title
	);

	$fields = array(
					'to' => $topic_url.$area,
					'data' => $requestData,
					'notification' => array (
                	"body" => $description,
                	"title" => $title,
                	'click_action' =>'.NotificationHistoryActivity'
                		)
				);

	// Open connection
	$ch = curl_init();
 
	// Set the url, number of POST vars, POST data
	curl_setopt($ch, CURLOPT_URL, $url);
 
	//curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
	// Disabling SSL Certificate support temporarily
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
 					
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 						

	// Execute post

	$result = curl_exec($ch);
			//if($result === FALSE){
			//	die('Curl failed: ' . curl_error($ch));
			//}
 
	// Close connection
	curl_close($ch);


echo json_encode($response);
}


?>
