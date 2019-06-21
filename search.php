<?php

include 'functions.php';

$conn = OpenCon();

$response = array();

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

if(isset($input['keyword'])){
	$keyword= mysqli_escape_string($conn, $input['keyword']);
	$keyword =htmlspecialchars($keyword);

	$query = "SELECT UserId, Incident_name , Description , Category, Severity, Incident_datetime, ";
	$query .= "AreaId, Incident_photo, Number_of_upvotes, Number_of_downvotes FROM incidents ";
	$query .= "WHERE Incident_name LIKE CONCAT('%',?,'%') OR AreaId = (SELECT AreaId from Area WHERE Area_Name = ?)";

	if($stmt = $conn->prepare($query)){
		$stmt->bind_param("ss" , $keyword, $keyword);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($userId, $title, $description, $category, $severity, $datetime, $areaId, $image, $UpVote, $DownVote);	
		if($stmt->fetch()){

			$response["Incident"]= array();
			$Incident = array();
			
			while($stmt->fetch()){
				
				$Incident["userName"] = getUserNameFromUserTable($userId, $conn);
				$Incident["incidentTitle"] = $title;
				$Incident["incidentDescription"] = $description;
				$Incident["incidentCategory"] = $category;
				$Incident["incidentseverity"] = $severity;
				$Incident["incidentDateTime"] = $datetime;
				$Incident["area"] = getAreaFromAreaTable($areaId, $conn);
				$Incident["image"] = $image;
				$Incident["UpVote"] = $UpVote;
				$Incident["DownVote"] = $DownVote;
				array_push($response["Incident"], $Incident);
			}
		}else{
			$response['status'] = 0;
			$response['message'] = "No result, please try another word!";
		}
	}
} else{
	$response['status'] = 1;
	$response['message'] = "Please enter a keyword!";
}

echo json_encode($response);

?>