<?php

	include 'db_connection.php';
	$conn = OpenCon();
	echo "Connected Successfully";
	echo "<br>";
	


	function randomGeo($lat, $long, $radius){

	$y0 = $lat;
    $x0 = $long;
    $rd = $radius / 111300;

    $u = mt_rand() / mt_getrandmax();
    $v = mt_rand() / mt_getrandmax();

    $w = $rd * sqrt($u);
    $t = 2 * pi() * $v;
    $x = $w * cos($t);
    $y = $w * sin($t);


    $newLat = $y + $y0;
    $newLong = $x + $x0;

    $coord = array($newLat,$newLong);
   
   	return $coord;
	}

	/*
	for($i=0;$i<100;$i++){
		$arr = randomGeo(30.06666667,31.21666667,1000);
		echo $arr[0]." ".$arr[1]."\n";
		echo " ";


	$geolocation = $arr[0].','.$arr[1];
	$request = 'https://eu1.locationiq.com/v1/reverse.php?key=5a2c9efdcaf700&lat='.$arr[0].'&lon='.$arr[1].'&format=json'; 


	$file_contents = file_get_contents($request);
	$json_decode = json_decode($file_contents);
	
	echo $json_decode->display_name;
	echo "<br>";
	sleep (0.2);

    }


*/
//"Road Accident", "Road Block" , "Pothole" ,

    for($i=0;$i<100;$i++){
    		$userId = mt_rand(1,70);
   
   $headline = array( "Stray Dogs" , "Assault" ,"Harrasement","theft" ,"Robbery, be alert!" , "Power Outage" ,"Water Outage" ,"Missing Person" ,"Missing Pet" ,"Too much Grabage Here" ,"Sewer Leakage" ,"Dangerous Fogs in Highway" ,"Building is on Fire! , Beware" ,"Too many unauthorized means of transportation");


   $category = array( "Stray Dogs" , "Assault" ,"Harrasement","theft" ,"Robbery" , "Power Outage" ,"Water Outage" ,"Missing Person" ,"Missing Pet" ,"Grabage" ,"Sewer Leakage" ,"Dangerous Weather", "Fire" ,"unauthorized means of transportation");

   $index = mt_rand(0,13);

   $incident_category = $category[$index];
   $incident_name = $headline[$index];

   $index = mt_rand(0,3);
   $severity = array("Urgent" , "High" ,"Normal" ,"Low");
   $incident_severity = $severity[$index];

   $start = date_create("2019-01-01 00:00:00");
   $end = date_create("2019-05-01 00:00:00");

   $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
   $incident_datetime = new DateTime();
   $incident_datetime->setTimestamp($randomTimestamp);


   //depends on the area id.
  


   		$areaId = mt_rand(1,3);
  
   switch ($areaId){

   	case 1:
   		 $coord = randomGeo(30.0564937,31.2191028,30);
   		//echo $coord[0]." ".$coord[1]."\n";
		//echo " ";
	$geolocation = $coord[0].','.$coord[1];
	$request = 'https://eu1.locationiq.com/v1/reverse.php?key=5a2c9efdcaf700&lat='.$coord[0].'&lon='.$coord[1].'&format=json'; 

	$file_contents = file_get_contents($request);
	$json_decode = json_decode($file_contents);
	
	//echo $json_decode->display_name;
	//echo "<br>";
	//echo $areaId;
   		break;
   	case 2:
   		$coord = randomGeo(30.0113719,31.1216802,1000);
   		//echo $coord[0]." ".$coord[1]."\n";
		//echo " ";
	$geolocation = $coord[0].','.$coord[1];
	$request = 'https://eu1.locationiq.com/v1/reverse.php?key=5a2c9efdcaf700&lat='.$coord[0].'&lon='.$coord[1].'&format=json'; 

	$file_contents = file_get_contents($request);
	$json_decode = json_decode($file_contents);
	
	//echo $json_decode->display_name;
	//echo "<br>";
	//echo $areaId;
   		break;
   	case 3:
   		$coord = randomGeo(29.9939118,31.1668893,1000);
   		//echo $coord[0]." ".$coord[1]."\n";
		//echo " ";
	$geolocation = $coord[0].','.$coord[1];
	$request = 'https://eu1.locationiq.com/v1/reverse.php?key=5a2c9efdcaf700&lat='.$coord[0].'&lon='.$coord[1].'&format=json'; 

	$file_contents = file_get_contents($request);
	$json_decode = json_decode($file_contents);
	
	//echo $json_decode->display_name;
	//echo "<br>";
	//echo $areaId;
   		break;
   	default:
   		echo $areaId;

   }

 
   $upvotes = mt_rand(1,10);
   $downvotes = mt_rand(1,10);

   $datetime = $incident_datetime->format('Y-m-d H:i:s');

   echo "User Id = $userId";
   echo "<br>";
   echo "incident name = $incident_name";
   echo "<br>";
   echo "incident caterogry = $incident_category ";
   echo "<br>";
   echo "incident severity = $incident_severity";
   echo "<br>";
   echo "incident date and time = ".$datetime;
   echo "<br>";
   echo $geolocation;
   echo "<br>";
   if(stristr($json_decode->display_name , "Zamalek") || stristr($json_decode->display_name , "Gezira" ) || stristr($json_decode->display_name , "El Agouza" )){
   		$query1 = "INSERT INTO incidents (UserId, Incident_name, Category , Severity ,Incident_datetime,Longitude,Latitude , AreaId , Number_of_upvotes , Number_of_downvotes)
		VALUES ($userId, '".$incident_name."','". $incident_category."','".$incident_severity."','".$datetime."',$coord[1],$coord[0],$areaId, $upvotes, $downvotes);";

		if ($conn->query($query1) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

   }
   else if(stristr($json_decode->display_name , "Haram")){
   		echo $json_decode->display_name;

   		$query1 = "INSERT INTO incidents (UserId, Incident_name, Category , Severity ,Incident_datetime,Longitude,Latitude , AreaId , Number_of_upvotes , Number_of_downvotes)
		VALUES ($userId, '".$incident_name."','". $incident_category."','".$incident_severity."','".$datetime."',$coord[1],$coord[0],$areaId, $upvotes, $downvotes);";

		if ($conn->query($query1) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
   }
   else if(stristr($json_decode->display_name , "Kom al Akhdar")){
   		echo $json_decode->display_name;

   		$query1 = "INSERT INTO incidents (UserId, Incident_name, Category , Severity ,Incident_datetime,Longitude,Latitude , AreaId , Number_of_upvotes , Number_of_downvotes)
		VALUES ($userId, '".$incident_name."','". $incident_category."','".$incident_severity."','".$datetime."',$coord[1],$coord[0],$areaId, $upvotes, $downvotes);";

		if ($conn->query($query1) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
   }
   else{
   	echo "nothing came through";
   	echo $json_decode->display_name;
   }
   
   echo "<br>";
   echo "area id = $areaId";
   echo "<br>";
   echo "upvotes = $upvotes";
   echo "<br>";
   echo "downvotes = $downvotes";
   echo "<br>";
	echo $query1;


    }
   


	//29.9939118,31.1668893
   //$incident_long = ;
   //$incident_lat = ;

	CloseCon($conn);


?>
