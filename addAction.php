<html>
<head>
	<title>Add Data</title>
</head>

<body>
<?php
// Include the database connection file
require_once("dbConnection.php");

if (isset($_POST['submit'])) {
	// Escape special characters in string for use in SQL statement	
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
		// If all the fields are filled (not empty) 

		try {
			// Insert data into database
			$result = mysqli_query($mysqli, "INSERT INTO users (`name`, `age`, `email`) VALUES ('$name', '$age', '$email')");

			// Kalau query berhasil, tampilkan success message
			if ($result) {
				echo "<p><font color='green'>Data added successfully!</font></p>";
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
?>
</body>
</html>
