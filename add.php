<html>
<head>
	<title>Add Data</title>
</head>

<body>
<?php
//including the database connection file
include_once("config.php");

if(isset($_POST['Submit'])) {	

	unset($_POST['Submit']);
	//escape string function
	$_POST = escapeStringArr($_POST);
			
	// checking empty fields
	$validateStatus = validatePost($_POST);
	if($validateStatus['isValid']) { //if having empty fields	
		//print error text			
		echo $validateStatus['err'];
		//link to the previous page
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	} else { 
		// if all the fields are filled (not empty) 
			
		//insert data to database	
		$sql = "INSERT INTO users (`".implode("`, `" , array_keys($_POST))."`) VALUES ('".implode("', '" , $_POST)."')";
		$result = mysqli_query($mysqli, $sql);
		
		//display success message
		echo "<font color='green'>Data added successfully.";
		echo "<br/><a href='index.php'>View Result</a>";
	}
}

function escapeStringArr($postArr){
	foreach ($postArr as $key => $value) {
		$postArr[$key] = mysqli_real_escape_string($mysqli, $value);
	}
	return $postArr;
}

function validatePost($postArr){
	$err = "";
	$isValid = true;
	foreach ($postArr as $key => $value) {
		if(empty($value)){
			$err = $err."<font color='red'>".$key." field is empty.</font><br/>";
			$isValid = false;
		}		
	}
	return array('err' => $err , 'isValid' => $isValid);
}

?>
</body>
</html>
