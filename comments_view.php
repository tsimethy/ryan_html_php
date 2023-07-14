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
	define("REV_SORT", 2);
	define("HOST", "127.0.0.1");
	define("USER", "root");
	define("PWD", "Iflexsol55*");
	define("DATABASE", "students");

	// Global Variables
	$form_deleterow = $message = "";
	$allComments[] = "";
	$sort_order = 1;

	if (!file_exists(FILE_PATH)){
		$message = "<hr><div class='is_error'> Post Comments file does not exist  </div><hr>";
	}

	if (empty($message)){
		// Get list of post comments
		$allComments = getAllRowsIntoArray();
	}


	// Process on submit
	if (!empty($_POST)) {
		if (isset($_POST['deleterow']))
		{
			// Set form values to variables
			$form_deleterow = $_POST['deleterow'];
			$sort_order = $_POST['currSort'];
			$allComments = getAllRowsIntoArray();
			$message = "";
			
			//echo 'sort_order' . $sort_order;

			if (empty($form_deleterow)){
				$message = "<hr><div class='is_error'> You must enter a value in each field  </div><hr>";
			}
		
			if (empty($message)){
				// delete comment
				$updrows = updArrayWithFormValuesDeleteRow();
				if (empty($message)){
					updateRepository($updrows);
				}				
				$allComments = getAllRowsIntoArray();
			}
		}
	}

	// Get all comments
	function getAllRowsIntoArray(){
		global $sort_order;
		$rows = [];

		if (STORAGE == "DB") {
			$connection = mysqli_connect(HOST, USER, PWD, DATABASE);
			
			$stmt = "select comment_id, full_name, post_comment, email from `students`.`post_comments` where post_id = 1 order by full_name ;";
			
			// reverse sort order if query param is REV_SORT
			$parts = parse_url($_SERVER['REQUEST_URI']);
			if (array_key_exists("query", $parts)) {
				parse_str($parts['query'], $query);
				$sort_order = $query['sort'];
				
				if ($sort_order == REV_SORT) {
					$stmt = "select comment_id, full_name, post_comment, email from `students`.`post_comments` where post_id = 1 order by full_name desc;";
					
				}
			}
			//echo $stmt;
			$result = mysqli_query($connection, $stmt);
	
			$row = mysqli_fetch_row($result);

			$displaycount = 0;
			while ($row) {	
				$displaycount = $displaycount +1;
				$row[4] = $displaycount;
				$rows[] = $row;
				$row = mysqli_fetch_row($result);
			};
			
			// Add display counter
			if ($sort_order == REV_SORT) {
				$cnt = 0;
				for ($displaycount = count($rows); $displaycount > 0; $displaycount--) {
					//echo "The displaycount is: $displaycount <br>";
					$rows[$cnt][4] =  $displaycount;
					$cnt = $cnt+1;
				}
			}
		

			mysqli_free_result($result);
			mysqli_close($connection);
			
		}
		else {
			$path = FILE_PATH;
			$handle = fopen($path, "r");
			$displaycount = 0;
			while (($row = fgetcsv($handle)) !== false) {
				$displaycount = $displaycount + 1;
				$row[4] = $displaycount;
				$rows[] = $row;
			}
			fclose($handle);

		
			// reverse the array if query param is REV_SORT
			$parts = parse_url($_SERVER['REQUEST_URI']);
			if (array_key_exists("query", $parts)) {
				parse_str($parts['query'], $query);

				if ($query['sort'] == REV_SORT) {
					$rows = array_reverse($rows);
				}
			}
		}
		//echo '<pre>'; print_r ($rows); echo '</pre>';	
		return $rows;
		
	}

	
	// Delete row from array with form values
	function updArrayWithFormValuesDeleteRow(){
			global $form_deleterow, $message;
			$path = FILE_PATH;
			$rows = [];
			
			if (STORAGE == "DB") {	
				// nothing to do
			}
			else {
				$ctr = 1;
				$found = 0;
				$handle = fopen($path, "r");
				while (($row = fgetcsv($handle)) !== false) {
					if ($row[0] != $form_deleterow) {
						$row[0] = $ctr;
						$ctr = $ctr + 1;
						$rows[] = $row;
					}		
					else{
						$found = 1;
					}
				}
				if ($found == 0) {
					$message = "<hr><div class='is_error'> Delete unsuccessful as comment $form_deleterow does not exisit </div><hr>";
				}
		
				fclose($handle);
			}
							
			return $rows;
	}

	// Update CSV with Array
	function updateRepository($rows)
    {
		global  $message, $form_deleterow, $allComments, $sort_order;
		
		if (STORAGE == "DB") {	
			// connection
			$connection = mysqli_connect(HOST, USER, PWD, DATABASE);
			
			try {
				$deletecommentid = 0;
				if (isset($allComments[$form_deleterow-1])){
					if ($sort_order = 1) {
						$deletecommentid = $allComments[$form_deleterow-1][0];
					}
					else {
						//echo "allComments" . count($allComments) . "new row" .count($allComments)-$form_deleterow ;
						$deletecommentid = $allComments[$form_deleterow-1][0];
					}
					//echo "deletecommentid" . $deletecommentid;
					//echo '<pre>'; print_r ($allComments[$form_deleterow-1]); echo '</pre>';	
					// delete statement
					$stmt = "DELETE FROM post_comments WHERE comment_id=$deletecommentid ;";
					//echo $stmt;
					$result = mysqli_query($connection,$stmt );
					$message = "<hr><div class='is_success'>  Updated the data sucessfully </div><hr>";
				}
				else {
					$message = "<hr><div class='is_error'> Delete unsuccessful as comment $form_deleterow does not exisit </div><hr>";
				}

			} catch (Exception $e) {
				$message = "<hr><div class='is_error'> Delete unsuccessful as comment $form_deleterow does not exisit </div><hr>";
			}

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
			$message = "<hr><div class='is_success'>  Could not get lock on file, pls retry </div><hr>";
		}
			
        fclose($fp);
		}
		

        return 1;

    }
				
?>
		
		
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div><?php require 'posting.inc'; ?></div>
	
<?php
		// Form for Add Entry
		echo "<h1>Comments</h1>";
		echo "<hr>";
		echo "<div> ";
		if (count ($allComments)>0) {
		foreach ($allComments as $comment) {
			echo "<p><b>$comment[4].&nbsp&nbsp&nbsp Name: </b> <a href='mailto: $comment[3]'>$comment[1]</a></p>";
			echo "<p><b>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comments: </b>" . $comment[2] . "</p>";
		echo "<hr>";
		}
		}
		echo  $message ;



	echo "<div hidden>";
		echo "<input type='text' name='currSort' value=$sort_order>";
	echo "</div>";
?>
	<br><a href="index_lab4.shtml">Add new comment</a> <br>
	<a href="comments_view.php?sort=1">Sort Comments (A-Z) by name</a><br>
	<a href="comments_view.php?sort=2">Sort Comments (Z-A) by name</a><br><br>
	
	<label for="delete">Delete Comment Number:</label> <input type="number" name="deleterow"  id="deleterow"  > <input type='submit' id='submit' name='submit' value='Delete' class='primaryButton'><br>
</div>
	                </div>			
					<div><?php require 'copyrightDivision.inc'; ?></div>
                </div>
        </div>
</body>
</html>
