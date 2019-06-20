<?php

include 'functions.php';

$conn= OpenCon();
$response= array();


$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON,TRUE);

$query = "SELECT incident_name,Category,Severity,Incident_datetime,Longitude,Latitude,AreaId  FROM incidents ";

$result = mysqli_query($conn , $query ) or die(mysql_error());

// check for empty result
 if (mysqli_num_rows($result) > 0) {

        $response["incidents"] = array();

        $num_rows = mysqli_num_rows($result);

        for($i=0;$i<$num_rows;$i++) 
        {
        	$row = mysqli_fetch_array($result);
 			
            $incidentsArr = array();
            $incidentsArr["IncidentName"] = $row["incident_name"];
            $incidentsArr["Category"] = $row["Category"];
            $incidentsArr["Severity"] = $row["Severity"];
            $incidentsArr["IncidentDatetime"] = $row["Incident_datetime"];
            $incidentsArr["Longitude"] = $row["Longitude"];
            $incidentsArr["Latitude"] = $row["Latitude"];
            $incidentsArr["AreaId"] = $row["AreaId"];
 
            array_push($response["incidents"], $incidentsArr);

        }

        // success
        $response["success"] = 1;

        // echoing JSON response
        echo json_encode($response);

   }
   else{
   		// no users found
         $response["success"] = 0;
         $response["message"] = "No incidents found";
 
         // echo no users JSON
         echo json_encode($response);
   }


?>