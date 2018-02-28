<?php
$authToken = null;
//Create connection to the server
$con = mysqli_connect("localhost","csed","waterting","waterting");
//Check connection
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}

////Check if there is a cookie. if isset() means 'IF there IS'
if (isset($_COOKIE['auth'])) 
{
	//Store cookie in a variable
	$authToken = $_COOKIE['auth'];
	//Create SQL query that identifies the logged in user.
	$query = "SELECT * FROM userstable WHERE AuthToken = '$authToken'";
	//Execute SQL query	
	$result = mysqli_query($con,$query);	
	//Store the fields associated with the record in the userstable in a variable
	$record = mysqli_fetch_assoc($result);
	//The following is a variable that stores the field of data Username that was fetched from the record in the userstable
	//i.e. Username and Password, that we got from the record in the userstable
	$username = $record['Username'];
	echo "<h1>Hello, $username !&nbsp;&nbsp;<br> De ting goes skrrrrrrrrra</h1>";
}						
else //If there is no cookie,then head to the home page
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
	<!--Different hyperlinks. These are the options for the user.-->
	<a href="/waterting/editaccountdetails.php" class = "acclinks">Edit Account Details</a><br>
	<a href="/waterting/statistics.php" class = "acclinks">Statistics</a><br>
	<a href="/waterting/addconsumption.php" class = "acclinks">Add Consumption</a><br>
	<a href="/waterting/trackconsumption.php" class = "acclinks">Track Consumption</a><br>
	<a href="/waterting/logout.php" class = "acclinks">Log out</a><br>
</body>
</html>