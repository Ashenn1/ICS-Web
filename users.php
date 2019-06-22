
<?php

include 'db_connection.php';
$conn = OpenCon();


 // array for JSON response
$response = array();
 

$result = mysqli_query($conn , "SELECT * FROM user") or die(mysql_error());

    // check for empty result
    if (mysqli_num_rows($result) > 0) {

        	$response["users"] = array();

        	$num_rows = mysqli_num_rows($result);

        for($i=0;$i<$num_rows;$i++) 
        {

        	$row = mysqli_fetch_array($result);
 			
            $users = array();
            $users["userid"] = $row["UserId"];
            $users["username"] = $row["Username"];
            $users["email"] = $row["Email"];
            $users["password"] = $row["Password"];
            $users["user_photo"] = $row["User_photo"];
            $users["home_address"] = $row["Home_address"];
            $users["longitude"] = $row["Longitude"];
            $users["latitude"] = $row["Latitude"];
            $users["rating"] = $row["Rating"];
            $users["AreaId"] = $row["AreaId"];
 
            array_push($response["users"], $users);
 
        	}

        	// success
            $response["success"] = 1;

        	// echoing JSON response
            echo json_encode($response);
 
            
    } else {
         // no users found
         $response["success"] = 0;
         $response["message"] = "No users found";
 
         // echo no users JSON
         echo json_encode($response);
        }


?>