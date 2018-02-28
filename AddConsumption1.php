<?php
//Create connection to the server
$con = mysqli_connect('localhost', 'csed', 'waterting', 'waterting');
//Check connection
if (!$con) 
{
	echo "Error connecting to the database" . mysqli_connect_error(); 
	die();
}
//Check if there isn't any cookie or a value send as a Consumption.
//if !isset() means 'IF there IS NOT'
if (!isset($_POST['Consumption']) OR !isset($_COOKIE['auth']))
{
	//Redirect to the homepage
	header("Location: /waterting/main.php");
}
else
{
	echo "<h2>Test1 Cookie Check</h2>";
	//Storing details from form in variables
	$consumption = $_POST['Consumption'];
	$authToken = $_COOKIE['auth'];
	
	//Create SQL query to find the UserID of the user that submits the form
	$sql="SELECT * FROM userstable WHERE AuthToken = '$authToken' LIMIT 1";
	//Execute SQL query
	$result=mysqli_query($con,$sql);
	//Store the fields associated with the record in the userstable in a variable
	$record=mysqli_fetch_array($result);
	//Store 'UserID' in a variable
	$userid = $record['UserID'];
	
	//Check if the User already has started their daily consumption.
	//This is checked through counting how many records(i.e. rows of data) are already in the logstable
	//With the Accomplished field set to FALSE, and with the UserID that corresponds to the logged in User
	$sql="SELECT * FROM logstable WHERE UserID = '$userid' AND Accomplished = FALSE LIMIT 1";
	$result=mysqli_query($con,$sql);
	//Store number of acquired rows in a variable
	$record_count=mysqli_num_rows($result);
	
	//If the row count is larger than 0 (i.e. the user has already started their daily consumption)
	//Then add their new consumption on top of what they have consumed to the specific day
	if ($record_count > 0)
	{
		$record=mysqli_fetch_array($result);
		$dayid=$record['DayID'];
		$currentcons=$record['CurrentCons'];
		$consumption = $consumption + $currentcons;
		echo "<h2>Test2 Add new consumption to their already started one</h2>";
		//Create SQL query to UPDATE the required fields in the logstable
		$sql="UPDATE logstable SET CurrentCons = $consumption WHERE DayID = '$dayid'";
		//Execute SQL query
		mysqli_query($con,$sql);
	}
	else //If the user hasn't yet started their daily consumption, create a new one. (i.e. create a new record/row in the logs table)
	{
		$totalneeded = $record['TotalNeeded'];

		echo "<h1>Test3 Starts Daily Consumption </h1>";
		//Create SQL query to INSERT new values to the logstable
		$sql="INSERT INTO logstable (UserID, Date, CurrentCons, TotalNeeded, Accomplished)
		VALUES ('$userid', NOW(), $consumption, $totalneeded, FALSE)";
		//Execute SQL query
		mysqli_query($con,$sql);
		//Create SQL query to fetch the DayID of the order that has just been created
		$sql="SELECT MAX(dayid) AS newestdayid FROM logstable";
		$result=mysqli_query($con,$sql);
		$array=mysqli_fetch_array($result);
		$dayid=$array['newestdayid'];
	}
	
	//Check if log total exceeds exceed daily goal
	//Create SQL query to find the corresponding Daily Consumption (i.e. DayID)
	$sql="SELECT * FROM logstable WHERE DayID = '$dayid'";
	//Execute SQL query
	$result=mysqli_query($con,$sql);
	//Store the fields associated with the record in the logstable in a variable
	$record=mysqli_fetch_array($result);
	$totalneeded=$record['TotalNeeded'];
	$currentcons=$record['CurrentCons'];
	
	if ($currentcons >= $totalneeded)
	{
		echo "<h1>Test4 Goal reached</h1>";
		//Create SQL query to UPDATE the Accomplished field to TRUE of the specific Daily Consumption(i.e. DayID)
		$sql = "UPDATE logstable SET Accomplished = TRUE, CurrentCons='$currentcons' WHERE DayID = '$dayid'";
		mysqli_query($con,$sql);
	}
	echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/main.php';}, 1500); </script> ";
}
?>