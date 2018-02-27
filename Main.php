<?php

$authToken = null;
$con = mysqli_connect("localhost","csed","waterting","waterting");
		if (!$con) {
			echo "Failed to connect to database :" . mysqli_connect_error();
			die();
		}
		
if (isset($_COOKIE['auth'])) 
{
	$authToken = $_COOKIE['auth'];
	$query = "SELECT * FROM userstable WHERE AuthToken = '$authToken'";
	$result = mysqli_query($con,$query);	
	$record = mysqli_fetch_assoc($result);
	$username = $record['Username'];
	$password = $record['Password'];
	echo "<h1>Alo, $username !&nbsp;&nbsp;<br> De ting goes skrrrrrrrrra</h1>";
}						
else 
{
	header('Location: /waterting/home.html');
}	
?>
<html>
	<head>
		<title> Water Ting </title>
	</head>
<style>
h1 {font-family: Trebuchet MS;
	font-size: 100;
  color: #000000;
  text-shadow:
   -3px -3px 0 #21F,  
    3px -3px 0 #21F,
    -3px 3px 0 #21F,
     3px 3px 0 #21F;
}

.acclinks
{
text-decoration: none;
color: black;
font-family: Trebuchet MS;
}
</style>
<body>
	<a href="/waterting/editaccountdetails.php" class = "acclinks">Edit Account Details</a>&nbsp;&nbsp;<br>
	<a href="/waterting/statistics.php" class = "acclinks">Statistics</a>&nbsp;&nbsp;<br>
	<a href="/waterting/addconsumption.php" class = "acclinks">Add Consumption</a>&nbsp;&nbsp;<br>
	<a href="/waterting/trackconsumption.php" class = "acclinks">Track Consumption</a>&nbsp;&nbsp;<br>
	<a href="/waterting/logout.php" class = "acclinks">Log out</a>&nbsp;&nbsp;<br>
</body>
</html>