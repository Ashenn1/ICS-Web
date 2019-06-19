<?php 
include 'functions.php';
//include 'login.php';
$conn= OpenCon();
$data= array();
$response["Incident"]= array();
$userId=1;
 $query_1 ="SELECT AreaId From  user Where  UserId = ? ";

if($stmt = $conn->prepare($query_1)){
		$stmt->bind_param("s" , $userId);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($Area_id );
		$stmt->fetch();
		if($stmt->num_rows >= 1){
          
               $query = "SELECT user.Username, Incident_name, Description, Category, Severity, Incident_datetime, Number_of_upvotes, Number_of_downvotes FROM user, incidents WHERE incidents.AreaId ='$Area_id' && user.UserId= incidents.UserId ";
         $result= mysqli_query($conn,$query) ;    

       if (mysqli_num_rows($result) > 0) {

        	 $num_rows = mysqli_num_rows($result);

        for($i=0;$i<$num_rows;$i++) 
        {
        	$row = mysqli_fetch_array($result);
        	$Incident = array();
			$Incident["userName"] =$row["Username"];
			$Incident["incidentTitle"] = $row["Incident_name"];
			$Incident["incidentDescription"]= $row["Description"];
			$Incident["incidentCategory"] = $row["Category"];
			$Incident["incidentseverity"]=$row["Severity"];
            $Incident["incidentDateTime"]=$row["Incident_datetime"];
			$Incident["UpVote"]=$row["Number_of_upvotes"];
			$Incident["DownVote"]=$row["Number_of_downvotes"];
			array_push($response["Incident"], $Incident);
			
		}
		
	}
	
}
else{
	$response["message"] = "Missing mandatory parameters";
}

		}
			
echo json_encode($response);


 ?>