<?php

include 'db_connection.php';
$conn = OpenCon();



function username_Exists($username , $conn){
	$username = mysqli_escape_string($username);
	$username = htmlspecialchars($username);

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
	$email = mysqli_escape_string($email);
	$email = htmlspecialchars($email);

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

function getUserNameFromUserTable($userId, $conn){

	//$conn = OpenConLocal();

	$query = "SELECT Username From user Where UserId = ? ";

	if($stmt = $conn->prepare($query)){
		$stmt->bind_param("s" , $userId);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($userName);
		$stmt->fetch();
		if($stmt->num_rows >= 1){
			return $userName;
		}
	}
}

function getAreaFromAreaTable($areaId, $conn){
	//$conn = OpenConLocal();

	$query = "SELECT Area_Name From area Where AreaId = ? ";

	if($stmt = $conn->prepare($query)){
		$stmt->bind_param("s" , $areaId);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($areaName);
		$stmt->fetch();
		if($stmt->num_rows >= 1){
			return $areaName;
		}
	}
}


?>