<?php 
//include 'db_connection.php';
//include 'login.php';

include'functions.php';

//$conn= OpenCon();

$conn= OpenCon();
$response= array();


$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON,TRUE);


if(isset($input['userId'])){
  
	$userId= mysqli_escape_string($conn, $input['userId']);
	$userId =htmlspecialchars($userId);
 	$query_1 = "SELECT AreaId From user Where UserId = ? ";

	if($stmt = $conn->prepare($query_1)){
		$stmt->bind_param("s" , $userId);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Area_id);
		$stmt->fetch();
		if($stmt->num_rows >= 1){
          

        	$query = "SELECT user.Username, Incident_name, Description, Category, Severity, Incident_datetime, Number_of_upvotes, Number_of_downvotes,IncidentId FROM user, incidents WHERE incidents.AreaId = $Area_id and user.UserId= incidents.UserId ";
        	$result= mysqli_query($conn, $query) ;    

       		if (mysqli_num_rows($result) > 0) {

       	    $response["Incident"]= array();

        	 $num_rows = mysqli_num_rows($result);

	        for($i = 0; $i < $num_rows; $i++) 
	        {
	        	$row = mysqli_fetch_array($result);
	        	$Incident = array();
				$Incident["userName"] = $row["Username"];
				$Incident["incidentTitle"] = $row["Incident_name"];
				$Incident["incidentDescription"] = $row["Description"];
				$Incident["incidentCategory"] = $row["Category"];
				$Incident["incidentSeverity"]= $row["Severity"];
	            $Incident["incidentDateTime"]= $row["Incident_datetime"];
				$Incident["UpVote"] = $row["Number_of_upvotes"];
				$Incident["DownVote"] = $row["Number_of_downvotes"];
				$Incident["IncidentId"] = $row["IncidentId"];
				array_push($response["Incident"], $Incident);
				
			}
			echo json_encode($response);

		  }
		  else{
			 $response["message"] = "Missing mandatory parameters";
			 echo json_encode($response);
		    }

   		}
	}
}

else{
	echo "Input doesnt exist ";
 }
					
 ?>
