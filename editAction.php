<?php
// Include the database connection file
require_once("dbConnection.php");

if (isset($_POST['update'])) {
	// Escape special characters in a string for use in an SQL statement
	$id = mysqli_real_escape_string($mysqli, $_POST['id']);
	$name = mysqli_real_escape_string($mysqli, $_POST['name']);
	$age = mysqli_real_escape_string($mysqli, $_POST['age']);
	$email = mysqli_real_escape_string($mysqli, $_POST['email']);	
	
	// Check for empty fields
	if (empty($name) || empty($age) || empty($email)) {
		if (empty($name)) {
			echo "<font color='red'>Name field is empty.</font><br/>";
		}
		
		if (empty($age)) {
			echo "<font color='red'>Age field is empty.</font><br/>";
		}
		
		if (empty($email)) {
			echo "<font color='red'>Email field is empty.</font><br/>";
		}

		// Show link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<font color='red'>The email address '$email' is considered invalid.</font><br/>";

		// Show link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else {

		try {
			// Update the database table
			$result = mysqli_query($mysqli, "UPDATE users SET `name` = '$name', `age` = '$age', `email` = '$email' WHERE `id` = $id");

			// Kalau query berhasil, tampilkan success message
			if ($result) {
				// Display success message
				echo "<p><font color='green'>Data updated successfully!</p>";
				echo "<a href='index.php'>View Result</a>";
			}

		} catch (mysqli_sql_exception $e) {
			if ($e->getCode() == 1062) { // 1062 = Duplicate entry
				echo "Email must be unique.";
				echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
			}
		}
	}
}
