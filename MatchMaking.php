<?php		
	function mean($arr)
	{
		$sum=0;
		for($j=0;$j<sizeof($arr);$j++)
		{
			$sum+=$arr[$j];
		}
		return $sum/sizeof($arr);
	}
	function Stand_Deviation($arr) 
    { 
        $num_of_elements = count($arr);   
        $variance = 0.0;       
        // calculating mean using array_sum() method 
        $average = array_sum($arr)/$num_of_elements; 
          
        foreach($arr as $i) 
        { 
        	// sum of squares of differences between  
            // all numbers and means. 
            $variance += pow(($i - $average), 2); 
        } 
        return (float)sqrt($variance/$num_of_elements); 
    } 

    function inRange($value,$first,$second){
    	if($first>$second)
		{
			if($arr[$i]>=$second && $arr[$i]<=$first )
				return true;

		}
		else{
			if($arr[$i]>=$first && $arr[$i]<=$second )
				return true;
		}

		return false;
    }
         
	include 'db_connection.php';
	$con = OpenCon();
//	echo "Connected Successfully";
//	echo "<br>";

	$category = array( "Stray Dogs" , "Assault" ,"Harrasement","theft" ,"Robbery" , "Power Outage" 
  		,"Water Outage" ,"Missing Person" ,"Missing Pet" ,"Grabage" ,"Sewer Leakage" ,"Dangerous Weather"
  		,"Fire" ,"unauthorized means of transportation");

	$arr=[];
	$sq1="SELECT COUNT(IncidentId) as count FROM incidents"; 
  	$result = $con->query($sq1);
  	if ($result->num_rows > 0){
   		while($row = $result->fetch_assoc()) {
    	$all_Incidents=$row["count"];

    	}
	}
  	
	if($all_Incidents<1000)
	{

		$sum_of_incidents=0; //incidents in an area

		
		$sq1="SELECT COUNT(IncidentId) as count FROM incidents WHERE AreaId=1"; //AreaId is the AreaId of the incident  report done 
  		$result = $con->query($sq1);
  		
  		if ($result->num_rows > 0){
   			while($row = $result->fetch_assoc()) {
    		$sum_of_incidents=$row["count"];
    		}
		}

	
		for($i=0;$i< sizeof($category);$i++){

  		
    	$sq2="SELECT COUNT(Category) as count FROM incidents WHERE Category='".$category[$i]."' and AreaId=1"; //AreaId is taken from the 
  		$result = $con->query($sq2);

  		if ($result->num_rows > 0){
   			while($row = $result->fetch_assoc()) {
   				$incident_num=$row["count"];
    			//echo $incident_num;  // is the number of incidents in one of the areas of one category
    			//echo "<br>";
	   		}
	   	}

  		if($category[$i]=="Assault"|| $category[$i]=="Harrasement"|| $category[$i]=="theft" 
  			|| $category[$i]=="Robbery"||$category[$i]=="Missing Person"){

  			$type="Police Station";
  		}
  		elseif ($category[$i]=="Sewer Leakage"||$category[$i]=="Water Outage") {

  			$type="Water and Sewer";
  		}
  		elseif ($category[$i]=="Power Outage") {
  			$type="Power";
  		}
  		elseif ($category[$i]=="Missing Pet") {
  			$type="Stray Dogs";
  		}
  		elseif ($category[$i]=="unauthorized means of transportation"||$category[$i]=="Dangerous Weather") {
  			$type="Traffic";
  		}
  		else{
  			$type=$category[$i];
  		}
  		
  		if($incident_num >6/*((1/7)* $sum_of_incidents)*/){
  			

  			$sq3="SELECT DepartmentId FROM department WHERE Department_type='".$type."' and AreaId=1";
  			$result = $con->query($sq3);

  			if ($result->num_rows > 0){
   				while($row = $result->fetch_assoc()) {
   					$DepartmentId=$row["DepartmentId"];
   					//echo $DepartmentId;
	   			}
  			}

  			$sq4="SELECT Incident_datetime  FROM incidents ORDER BY IncidentId DESC";
 	 		$result = $con->query($sq4);

  		 	if ($result->num_rows > 0){
   				$row = $result->fetch_assoc();
   				$dateTime=$row["Incident_datetime"];
   				//echo $dateTime;
	   		}
  	

  			$sq5="INSERT INTO notifications (DepartmentId, Type, Notifcation_message, Notification_datetime)
			VALUES ('".$DepartmentId."', '".$type."', '".$type."','".$dateTime."')"; 
  			$result = $con->query($sq5);

  		}

	}
}
else {

	for($i=0;$i< sizeof($category);$i++){

  		$sq2="SELECT COUNT(Category) as count FROM incidents WHERE Category='".$category[$i]."' and AreaId=1"; //AreaId is taken from the 
  		$result = $con->query($sq2);

  		if ($result->num_rows > 0){
   			while($row = $result->fetch_assoc()) {
   				$arr[$i]=$row["count"];
    			//echo "<br>";
	   		}
	   	}
	}


	$diff=sqrt(mean($arr)-Stand_Deviation($arr))*sqrt(mean($arr)-Stand_Deviation($arr));
	$sum=mean($arr)+Stand_Deviation($arr);


	for ($i=0; $i <sizeof($arr) ; $i++) { 
		if(!inRange($arr[$i],$diff,$sum))
		{
		//add indicdent
		}
	}
}
	CloseCon($con);
?>