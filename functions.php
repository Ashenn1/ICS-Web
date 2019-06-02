<?php

include 'db_connection.php';
$conn = OpenCon();



function username_Exists($username , $conn){

	$query = "SELECT Username FROM user WHERE Username = ?";

	if($stmt = $conn->prepare($query)){

		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		if($stmt->num_rows == 1){
			$stmt->close();
			return true;
		}
		$stmt->close();

	}

	return false;

}

function email_Exists($email , $conn){

	$query = "SELECT Email FROM user WHERE Email = ?";

	if($stmt = $conn->prepare($query)){

		$stmt->bind_param("s",$email);
		$stmt->execute();
		$stmt->store_result();
		$stmt->fetch();
		if($stmt->num_rows == 1){
			$stmt->close();
			return true;
		}
		$stmt->close();

	}

	return false;

}



?>