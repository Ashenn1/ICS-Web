<?php

function OpenCon()
 {
	 $dbhost = "us-cdbr-iron-east-02.cleardb.net";
	 $dbuser = "b2fc8d6cca888a";
	 $dbpass = "0c0acf39";
	 $db = "incidentsdb";
	 $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
	 
	 return $conn;
 }
 
function CloseCon($conn)
 {
 	$conn -> close();
 }


?>