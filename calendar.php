<!DOCTYPE html>
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>IT 207 Office Hours Calendar</title>

        <link rel="stylesheet" href="styles.css" />
        <link rel="stylesheet" href="calendar.css" />
    </head>

    <body>
        <div class="flex">
            <div class="outer width30 brandColor">
                <?php require 'menuDivision.inc'; ?>
            </div>
            <div class="outer width70">
                <div class="inner width100 height120PX brandColor">
                    <?php require 'headerDivision.php'; ?>
                </div>
                <div class="inner flex width100 height90">
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?>">

			<div class="innerTextCenter"> <h1> Office Hours Sign Up</h1></div>
			<div class="innerTextCenter"> 
			<label for="name">Student Name</label>
			<input type="text" name="name" >
		<label for="email">Student Email</label>
		<input "email" name="email" > 



<div hidden>
<?php 

	// hidden variables
	echo('<select name="timeMonday1[]" id="timeMonday1" multiple>');
	foreach ($_POST['timeMonday'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	foreach ($_POST['timeMonday1'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	echo('</select>&nbsp;');

  	echo('<select name="timeTuesday1[]" id="timeTuesday1" multiple>');
	foreach ($_POST['timeTuesday'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	foreach ($_POST['timeTuesday1'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	echo('</select>&nbsp;');
	
	echo('<select name="timeWednesday1[]" id="timeWednesday1" multiple>');
	foreach ($_POST['timeWednesday'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	foreach ($_POST['timeWednesday1'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	echo('</select>&nbsp;');
	
	echo('<select name="timeThursday1[]" id="timeThursday1" multiple>');
	foreach ($_POST['timeThursday'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	foreach ($_POST['timeThursday1'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	echo('</select>&nbsp;');
	
	echo('<select name="timeFriday1[]" id="timeFriday1" multiple>');
	foreach ($_POST['timeFriday'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	foreach ($_POST['timeFriday1'] as $subject) 
		echo('<option selected value="' . $subject . '">' . $subject . '</option>');
	echo('</select>&nbsp;');
?>
</div>
	<input type='reset' name='clear' value='Clear' />
    <input type='submit' name='submit' value='Submit' /><BR><BR></div>
    

<?php

// Constants for mail 
define("MSG_PREFIX", "Office hours sign up \n You are signed up for");
define("MSG_SUBJECT", "Office hours sign up");
define("EMAIL_PARAM_ERROR", "<br> Cannot signup, as input Name or Email or office hour required not selected");
define("EMAIL_SUCCESS", "Email successfully sent from rsimethy@gmu.edu");
define("EMAIL_CC", "rmallamp@gmu.edu");
//define("EMAIL_CC", "rsimethy@gmu.edu");

// Send mail
if (!empty($_POST)) {
	if (isset($_POST['name']) && isset($_POST['email'])  && isset($_POST['signupTime']))
	{
		// the message
		$msg = MSG_PREFIX . $_POST['signupTime'] ;

		// use wordwrap() if lines are longer than 70 characters
		$msg = wordwrap($msg,70);

		// send email
		mail($_POST['email'] . "," . EMAIL_CC ,MSG_SUBJECT,$msg);

		echo(EMAIL_SUCCESS);
	}
	else
	{
		if (isset($_POST['timeMonday1'])) {
			echo(EMAIL_PARAM_ERROR);
		}
	}

}



?>

<?php 


// Get the current date
$date = getdate();

// Get the value of day, month, year
$mday = $date['mday'];
$mon = $date['mon'];
$wday = $date['wday'];
$month = $date['month'];
$year = $date['year'];


$dayCount = $wday;
$day = $mday;

while($day > 0) {
	$days[$day--] = $dayCount--;
	if($dayCount < 0)
		$dayCount = 6;
}

$dayCount = $wday;
$day = $mday;

if(checkdate($mon,31,$year))
	$lastDay = 31;
elseif(checkdate($mon,30,$year))
	$lastDay = 30;
elseif(checkdate($mon,29,$year))
	$lastDay = 29;
elseif(checkdate($mon,28,$year))
	$lastDay = 28;

while($day <= $lastDay) {
	$days[$day++] = $dayCount++;
	if($dayCount > 6)
		$dayCount = 0;
}	


echo("<div class='headRow'>");
echo("$month $year");
echo("</div>");


 echo("     <div id='container7'>");
 echo("        <div id='container6'>");
 echo("           <div id='container5'>");
 echo("              <div id='container4'>");
 echo("                 <div id='container3'>");
 echo("                    <div id='container2'>");
 echo("                       <div id='container1'>");
 echo("                          <div id='col1'>Sunday</div>");
 echo("                          <div id='col2'>Monday</div>");
 echo("                          <div id='col3'>Tuesday</div>");
 echo("                          <div id='col4'>Wednesday</div>");
 echo("                          <div id='col5'>Thursday</div>");
 echo("                          <div id='col6'>Friday</div>");
 echo("                          <div id='col7'>Saturday</div>");
 echo("                       </div>");
 echo("                    </div>");
 echo("                 </div>");
 echo("              </div>");
 echo("           </div>");
 echo("        </div>");
 echo("     </div>");


$startDay = 0;
$d = $days[1];

 echo("     <div id='container7'>");
 echo("        <div id='container6'>");
 echo("           <div id='container5'>");
 echo("              <div id='container4'>");
 echo("                 <div id='container3'>");
 echo("                    <div id='container2'>");
 echo("                       <div id='container1'>");

while($startDay < $d) {
	echo("<div id='col1'>&nbsp</div>");
	$startDay++;
}

$weekCnt = $d;
for ($d=1;$d<=$lastDay;$d++) {


if ($weekCnt % 7 == 0)
{
	// end of row check
	
	echo("                       </div>");
	echo("                    </div>");
	echo("                 </div>");
	echo("              </div>");
	echo("           </div>");
	echo("        </div>");
	echo("     </div>");
	echo("     <div id='container7'>");
	echo("        <div id='container6'>");
	echo("           <div id='container5'>");
	echo("              <div id='container4'>");
	echo("                 <div id='container3'>");
	echo("                    <div id='container2'>");
	echo("                       <div id='container1'>");
}
$weekCnt = $weekCnt +1;
	echo("<div id='col1'>$d");
 
 	if(isset($_POST['signupTime'])) {
		$id = $_POST['signupTime'];
		$id = trim($id);  
		$id = stripslashes($id);  
		$id = htmlspecialchars($id); 
	}
	
	if ($startDay == 1)
	{
		if (isset($_POST['timeMonday']))
		{
			foreach ($_POST['timeMonday'] as $subject) {
				echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
			}
		}
		if (isset($_POST['timeMonday1']))
			{
			foreach ($_POST['timeMonday1'] as $subject) {
				if(isset($_POST['signupTime'])) {
					if($id == $d . $subject) {
						echo('<BR>' . $subject . "--" . $_POST['name']);
					}
					else {
						echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
					}
				}
				else {
					echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
				}
			
			}
		}
	}
	
	
	if ($startDay == 2){
		if (isset($_POST['timeTuesday']))
		{
		foreach ($_POST['timeTuesday'] as $subject) 
			echo('<br> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
		}
		if (isset($_POST['timeTuesday1']))
		{
		foreach ($_POST['timeTuesday1'] as $subject) 
			if(isset($_POST['signupTime'])) {
					if($id == $d . $subject) {
						echo('<BR>' . $subject . "--" . $_POST['name']);
					}
					else {
						echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
					}
				}
				else {
					echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
				}
		}		
	}
	
	if ($startDay == 3){
		if (isset($_POST['timeWednesday']))
		{
		foreach ($_POST['timeWednesday'] as $subject) 
			echo('<br> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
		}
		if (isset($_POST['timeWednesday1']))
		{
		foreach ($_POST['timeWednesday1'] as $subject) 
			if(isset($_POST['signupTime'])) {
					if($id == $d . $subject) {
						echo('<BR>' . $subject . "--" . $_POST['name']);
					}
					else {
						echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
					}
				}
				else {
					echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
				}
		}		
	}
	
	if ($startDay == 4){
		if (isset($_POST['timeThursday']))
		{
		foreach ($_POST['timeThursday'] as $subject) 
			echo('<br> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
		}
		if (isset($_POST['timeThursday1']))
		{
		foreach ($_POST['timeThursday1'] as $subject) 
			if(isset($_POST['signupTime'])) {
					if($id == $d . $subject) {
						echo('<BR>' . $subject . "--" . $_POST['name']);
					}
					else {
						echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
					}
				}
				else {
					echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
				}
		}		
	}
	
	if ($startDay == 5){
		if (isset($_POST['timeFriday']))
		{
		foreach ($_POST['timeFriday'] as $subject) 
			echo('<br> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
		}
		if (isset($_POST['timeFriday1']))
		{
		foreach ($_POST['timeTuesday1'] as $subject) 
			if(isset($_POST['signupTime'])) {
					if($id == $d . $subject) {
						echo('<BR>' . $subject . "--" . $_POST['name']);
					}
					else {
						echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
					}
				}
				else {
					echo('<BR> <input type="radio" name="signupTime" value="' . $d . $subject . ' "> ' . $subject);
				}
		}		
	}
	echo("</div>");

	$startDay++;
	if($startDay > 6 && $d < $lastDay){
		$startDay = 0;
		echo("</div>");
		echo("<div>");
	}
}
 echo("                       </div>");
 echo("                    </div>");
 echo("                 </div>");
 echo("              </div>");
 echo("           </div>");
 echo("        </div>");
 echo("     </div>");

?>
</div>
<div><?php require 'copyrightDivision.inc'; ?></div>
                </div>

            </div>

        </div>
		  
    </body>
</html>


