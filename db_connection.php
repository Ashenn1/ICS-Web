<?php

function OpenCon()
 {
	 $dbhost = "mysql://b2fc8d6cca888a:0c0acf39@us-cdbr-iron-east-02.cleardb.net/heroku_bf623a5b75d34c9?reconnect=true";
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