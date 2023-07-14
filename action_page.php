<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>CSS Tableless Layout</title>
   <link rel="stylesheet" type="text/css" href="styles_practicum1.css" />
</head>
<body>

<?php

    
 
     $weight = $_POST['weight'];
     echo "<div  id='col'><br/>weight = " . $weight;
	 $duration_running = $_POST['duration_running'];
     echo "<br/>duration_running = " . $duration_running;
	 $duration_basketball = $_POST['duration_basketball'];
     echo "<br/>duration_basketball = " . $duration_basketball;
	 $duration_sleep = $_POST['duration_sleep'];
     echo "<br/>duration_sleep = " . $duration_sleep;

	function caloriesExpended(float $weight, float $duration_running, float $duration_basketball, float $duration_sleep): int
	{
		define("RUNNING", 10);  	// Running (at 6mph): 10 METS 
		define("BASKETBALL", 8); 	// Basketball: 8 METS 
		define("SLEEPING", 1);		// Sleeping: 1 MET
		$weight =  $weight / 2.2 ; // 1 kilogram (kg) is equal to 2.2 pounds.
		echo "<br/>weight = " . $weight;
		$met = 0;
		
		$met = $met + $duration_running * RUNNING;
		$met = $met + $duration_basketball * BASKETBALL;
		$met = $met + $duration_sleep * SLEEPING;
		
		$cal = 0.0175 * $met * $weight;	//Calories/Minute = 0.0175 x MET x Weight(kg)
		return (int)$cal;
	}
	
	$final_cal = caloriesExpended($weight, $duration_running, $duration_basketball, $duration_basketball);
	echo "<br/>cal = " . $final_cal . "<br/>";
	
	// outputs e.g. 'Last modified: March 04 1998 20:43:59.'
	echo "<br> <p> Last modified: " . date ("F d Y H:i:s T", getlastmod()) . "</p> </div>";
	
	echo "<a href='practicum1_Part2.html'>Practicum 1 Part 2</a> <br />";
                  
?>

<body>
<html>
