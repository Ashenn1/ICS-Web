<?php

include 'functions.php';

$conn = OpenCon();

$response = array();



$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON,TRUE);

//check mandatory parameters are set
if(isset($input['Vote']) && isset($input['IncidentId'])&& isset($input['VoteType'])){

	$VoteNum = mysqli_escape_string($conn, $input['Vote']);
	$VoteNum =htmlspecialchars($VoteNum);

	$Incident_Id = mysqli_escape_string($conn, $input['IncidentId']);
	$Incident_Id = htmlspecialchars($Incident_Id);

	$Type = mysqli_escape_string($conn, $input['VoteType']);
	$Type = htmlspecialchars($Incident_Id);

   if($Type=='UpVote')
   {
       $query = "UPDATE incidents SET Number_of_upvotes = ? WHERE IncidentId = ?";

   }
   else{
     	$query = "UPDATE incidents SET Number_of_downvotes = ? WHERE IncidentId = ?";

       }
	

	if($stmt = $conn->prepare($query)){
		$stmt->bind_param("ss", $VoteNum, $Incident_Id);
		$bool=$stmt->execute();
		$response["status"] = 0;
		$response["message"] = "Votes Updated";
		
		
		}
		else{
				$response["status"] = 1;
				$response["message"] = "There's issue in updating vote";
			}
	
	
}

//Display JSON response.
echo json_encode($response);

?>