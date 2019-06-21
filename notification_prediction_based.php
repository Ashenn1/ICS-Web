<?php

$pyscript = 'C:\\Users\\Soha Samad\\Desktop\\College\\Year 4\\Graduation_Project\\TimeSeriesForcastingProject\\tryout.py';
$python = 'C:\\Python\\Python36\\python.exe';
//$filePath = 'C:\\wamp\\www\\testing\\uploads\\thumbs\\10-05-2012-523.jpeg'


//exec("$python $pyscript", $output);
$output = shell_exec("python C:\\Users\\Soha Samad\\Desktop\\College\\Year 4\\Graduation_Project\\TimeSeriesForcastingProject\\tryout.py");

echo $output[0];

///Users/Soha Samad/Desktop/College/Year 4/Graduation_Project/TimeSeriesForcastingProject/tryout.py

?>