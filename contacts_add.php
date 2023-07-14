<!DOCTYPE html>
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<!--
	IT 207 Lab 3 
	Ryan Simethy	
-->
    <head>
        <title>IT 207 Online Contacts Directory</title>

        <link rel="stylesheet" href="styles.css">
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
				
<?php
				
				
// Constants
define("FILE_PATH", 'directory.csv');

// Global Variables
$form_fname = $form_lname = $hidden_fname = $hidden_lname = $form_email = $form_phone = $form_address = $form_city = $form_state = $form_zip = $message = "";
$states = array('Alabama','Alaska','Arizona','Arkansas','California','Colorado','Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana','Iowa','Kansas','Kentucky[B]','Louisiana','Maine','Maryland','Massachusetts[B]',
'Michigan','Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey','New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania[B]','Rhode Island','South Carolina','South Dakota',
'Tennessee','Texas','Utah','Vermont','Virginia','Washington','West Virginia','Wisconsin','Wyoming');


// Process on submit
if (!empty($_POST)) {
	if (isset($_POST['fname']) && isset($_POST['lname'])  && isset($_POST['email']))
	{
		$firstname = $_POST['fname'];
		$lastname =  $_POST['lname'];
		$message = "";
		setFormValuesToVariables();
		if (empty($form_fname) || empty($form_lname) || empty($form_email) || empty($form_phone) || empty($form_address) || empty($form_city) || empty($form_state) || empty($form_zip)){
			$message = "<hr><div class='is_error'> You must enter a value in each field  </div><hr>";
		}
		else {
		if (file_exists(FILE_PATH)){
			$rows = updArrayWithFormValues();
			$updRows = $rows;
			updateCSVFileWithArray($updRows, FILE_PATH);
		}
		else {
			$message = "<hr><div class='is_error'> Directory file does not exist  </div><hr>";
		}
		}
	}
}

	// Set form values to variables
	function setFormValuesToVariables(){
				global $firstname, $lastname, $hidden_fname, $hidden_lname, $form_fname, $form_lname, $form_email, $form_phone, $form_address, $form_city, $form_state, $form_zip;
				
				$form_fname = $_POST['fname'];
				$form_lname = $_POST['lname'];
				$hidden_fname = $_POST['hidden_fname'];
				$hidden_lname = $_POST['hidden_lname'];
				$form_email = $_POST['email'];
				$form_phone = $_POST['phone'];
				$form_address = $_POST['address'];
				$form_city = $_POST['city'];
				$form_state = $_POST['state'];
				$form_zip = $_POST['zipcode'];
	}
	
	// Update array with form values
	function updArrayWithFormValues(){
				global $firstname, $lastname, $hidden_fname, $hidden_lname, $form_fname, $form_lname, $form_email, $form_phone, $form_address, $form_city, $form_state, $form_zip;
				$path = FILE_PATH;
				$rows = [];
				$handle = fopen($path, "r");
				while (($row = fgetcsv($handle)) !== false) {
					$rows[] = $row;
				}
				fclose($handle);
							
				$nextRow = count($rows) + 1;
				$rows[$nextRow][0] = $form_fname;
				$rows[$nextRow][1] = $form_lname;
				$rows[$nextRow][2] = $form_email;
				$rows[$nextRow][3] = $form_phone;
				$rows[$nextRow][4] = $form_address;
				$rows[$nextRow][5] = $form_city;
				$rows[$nextRow][6] = $form_state;
				$rows[$nextRow][7] = $form_zip;
				
				
				 return $rows;
	}

	// Add record to CSV
	function updateCSVFileWithArray($rows)
    {
		global  $message;
        $path = FILE_PATH;
        $fp = fopen($path, 'w');
		
		// lock file for update
		if (flock($fp, LOCK_EX)) {
			flock($fp, LOCK_EX);
			foreach ($rows as $row) {
				fputcsv($fp, $row);
			}
			flock($fp, LOCK_UN);
			$message = "<hr><div class='is_success'>  Updated the data sucessfully </div><hr>";
		}
		else{
			$message = "<hr><div class='is_success'>  Could not get lock on file, pls retry </div><hr>";
		}
			
        fclose($fp);
		

        return 1;

    }

				
?>
		
		
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	
<?php
		// Form for Add Entry
		echo "<h1> New Contact Entry </h1>";
		echo "<div> ";
		echo "<label for='fname'>First Name</label>";
		echo "<input type='hidden' id='hidden_fname' name='hidden_fname' value=" . $form_fname . " >";
		echo "<input type='text' id='fname' name='fname' value=" . $form_fname ." ><br><br>";
		echo "	<label for='lname'>Last Name</label>";
		echo "	<input type='hidden' id='hidden_lname' name='hidden_lname' value=" . $form_lname . " >";
		echo "	<input type='text' id='lname' name='lname' value=" . $form_lname . " ><br><br>";
		echo "	<label for='email'>Email Address</label>";
		echo "	<input type='email' id='email' name='email' value=" . $form_email . "> <br><br>";
		echo "	<label for='phone'>Phone Number</label>";
		echo "	<input type='tel' id='phone' name='phone' value=" . $form_phone . "> <br><br>";
		echo "	<label for='address'>Address</label>";
		echo "	<input type='text' id='address' name='address' value=" . $form_address ." >";
		echo "	<label for='city'>City</label>";
		echo "	<input type='text' id='city' name='city'  value=" . $form_city . " ><br><br>";
		echo "	<label for='state'>State</label>";
		echo "	<select id='state' name='state' >";
				
		foreach ($states as $state) {
			echo '<option value="'.$state.'">'.$state;
		}
				
		echo "	</select>";
		echo "	<label for='zipcode'>Zip</label>";
		echo "	<input type='number' id='zipcode' name='zipcode' value=" . $form_zip . " ><br><br>";
		echo "  <input type='submit' name='submit' value='Add Entry' class='primaryButton' ><br><br> </div>";
		echo  $message ;

?>

	
	<a href="index_lab3.shtml">Return to Directory</a>
</div>
				
					<div><?php require 'copyrightDivision.inc'; ?></div>
                </div>
        </div>
</body>
</html>
