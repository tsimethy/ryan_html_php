<!DOCTYPE html>
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<!--
	IT 207 Lab 4
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
	define("FILE_PATH", 'postcomments.csv');
	define("STORAGE", "DB");
	define("HOST", "127.0.0.1");
	define("USER", "root");
	define("PWD", "Iflexsol55*");
	define("DATABASE", "students");
	
// Global Variables
	$form_name = $form_comments = $form_email = $hidden_fname = $hidden_lname = $message = "";
	$is_error = false;

// Process on submit
if (!empty($_POST)) {
	if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['comments']))
	{
		// Set form values to variables
		$form_name = $_POST['name'];
		$form_email = $_POST['email'];
		$form_comments = $_POST['comments'];
		$message = "";

		if (empty($form_name) || empty($form_email)|| empty($form_comments)){
			$message = "<hr><div class='is_error'> You must enter a value in each field  </div><hr>";
			$is_error = true;
		}
		else {
			if (checkIfUserPreviouslyCommentedPost() == 1){
				$message = "<hr><div class='is_error'> One per person! You have already left comments for this posting </div><hr>";
				$is_error = true;
			}
		}
		
		if (!file_exists(FILE_PATH)){
			$message = "<hr><div class='is_error'> Post Comments file does not exist  </div><hr>";
			$is_error = true;
		}
		
		if (!$is_error){
			$rows = updArrayWithFormValues();
			$updRows = $rows;
			updateRepository($updRows);
		}
		
	}
}

	// Check if user has previously commented on the post
	function checkIfUserPreviouslyCommentedPost(){
			global $form_name, $form_comments, $form_email;
				
			if (STORAGE == "DB") {	
				// nothing to do
			}
			else {
				$path = FILE_PATH;
				$rows = [];

				$handle = fopen($path, "r");
				while (($row = fgetcsv($handle)) !== false) {
					// if email already exisits do not add
					if (strtolower($row[1]) == strtolower($form_name)) {
					//if ($row[3] == $form_email) {
						fclose($handle);
						return 1;
					}
				}
				fclose($handle);
			}
			
				
			return 0;
	}

	
	// Update array with form values
	function updArrayWithFormValues(){
			global $form_name, $form_comments, $form_email;
			$rows = [];
			
			if (STORAGE == "DB") {	
				// nothing to do
			}
			else {
				$path = FILE_PATH;
				$handle = fopen($path, "r");
				while (($row = fgetcsv($handle)) !== false) {
					$rows[] = $row;
				}
				fclose($handle);
							
				$nextRow = count($rows) + 1;
				$rows[$nextRow][0] = $nextRow;
				$rows[$nextRow][1] = $form_name;
				$rows[$nextRow][2] = $form_comments;
				$rows[$nextRow][3] = $form_email;
			}
				
			return $rows;
	}

	// Add record 
	function updateRepository($rows)
    {
		global  $message;
		global $form_name, $form_comments, $form_email;
		
		if (STORAGE == "DB") {	
			// connection 
			$connection = mysqli_connect(HOST, USER, PWD, DATABASE);
			
			//insert into post_comments table
			$insert_stmt = "INSERT INTO post_comments (post_id, full_name, email, post_comment) VALUES(1,'$form_name','$form_email', '$form_comments');";
			echo $insert_stmt;
			try {
				$result = mysqli_query($connection,$insert_stmt );
				$message = "<hr><div class='is_success'>  Updated the data sucessfully </div><hr>";
			} catch (Exception $e) {
				$message = "<hr><div class='is_error'> One per person! You have already left comments for this posting </div><hr>";
			}

			//echo '<pre>'; print_r ($rows); echo '</pre>';	
			//echo "num rows " . mysqli_num_rows($result);

			mysqli_close($connection);		
		}
		else {
			$path = FILE_PATH;
			// open file for write
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
				$message = "<hr><div class='is_error'>  Could not get lock on file, pls retry </div><hr>";
			}
		
        fclose($fp);
		}
		
        return 1;

    }
				
?>
		
		
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	
<?php
		// Form for Add Entry
		echo "<h1>Comments Added </h1>";
		echo "<div> ";
		if (!$is_error){
			echo "<hr>";
			echo "<p><b>Name: </b> <a href='mailto:$form_email'>$form_name</a></p>";
			echo "<p><b>Comments: </b>" . $form_comments . "</p>";
			echo "<hr>";
		}
		echo  $message ;

?>

	
	<a href="index_lab4.shtml">Someone else want to comment</a> <br>
	<a href="comments_view.php?sort=1">View posting comments</a>
</div>
	                </div>			
					<div><?php require 'copyrightDivision.inc'; ?></div>
                </div>
        </div>
</body>
</html>
