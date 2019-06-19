<?php

include 'db_connection.php';

$conn = OpenConnLocal();

$response = array();

//Get the input request parameters
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

echo $input;

		

?>