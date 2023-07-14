<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <title>CSS Tableless Layout</title>
   <link rel="stylesheet" type="text/css" href="styles_practicum1.css" />
</head>
<body>
<?php

    $coupons = $_POST['coupons'];
	define("CANDYBAR", 10);  	// Candy Bar: 10 coupons 
	define("GUMBALL", 3); 		// Gumball: 3 coupons
	echo "<H1> Coupon Distribution Results </H1> ";
	echo "<div  id='col'> For " . $coupons . " you can get:  <br>";
     
	$left_coupons = $coupons;
	
	function spendCoupon(int $left_coupons, int $no_coupon, string $type)
	{
		$no_items = 0;
		while($left_coupons >=$no_coupon )
		{
			$left_coupons = $left_coupons - $no_coupon;
			$no_items = $no_items + 1;
		}
		echo "<br>" . $no_items . " " . $type . "<br>";
		for ($i=0; $i<$no_items; $i++)
		{
			echo "o";
		}
		
		return array ($left_coupons, $no_items);
	}
	
	$res_coupons = spendCoupon($left_coupons, CANDYBAR, "CANDY BAR");
	$candy_bar = $res_coupons[1];
	$res_coupons = spendCoupon($res_coupons[0], GUMBALL, "GUMBALL");
	$gumball = $res_coupons[1];
	echo "<br/>" . $res_coupons[0] , " left over coupons ";
 
	echo "<br/> Legend  Candy Bar = " . $candy_bar , " gumballs = " . $gumball  . "<br></div>";

	
	echo "<a href='practicum1_Part2.html'>Practicum 1 Part 2</a> <br>";
	
		// outputs e.g. 'Last modified: March 04 1998 20:43:59.'
	echo "Last modified: " . date ("F d Y H:i:s T", getlastmod());
  
?>
<body>
<html>
