<?php
echo '<div align="right">';
$authToken = null;
//Create connection to the server
$con = mysqli_connect("localhost","csed","waterting","waterting");
//Check connection
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
//Check if there is a cookie. if isset() means 'IF there IS'
if (isset($_COOKIE['auth'])) 
{
	//Store cookie in a variable
	$authToken = $_COOKIE['auth'];
	//Create SQL query to identify user from userstable by that cookie
	$query = "SELECT * FROM userstable WHERE AuthToken = '$authToken'";
	//Execute query
	$result = mysqli_query($con,$query);
	//Store the fields associated with the record in the userstable in a variable
	$record = mysqli_fetch_assoc($result);
	//The following are two variables that store the two fields of data
	//i.e. Username and Password, that we got from the record in the userstable
	$username = $record['Username'];
	$password = $record['Password'];
	echo "<div class='acclinks'>
			Welcome, $username !<br>
			</div>";
	echo '<a href="/waterting/editaccountdetails.php" class = "acclinks">Edit Account Details</a><br>';
	echo '<a href="/waterting/statistics.php" class = "acclinks">Statistics</a><br>';
	echo '<a href="/waterting/addconsumption.php" class = "acclinks">Add Consumption</a><br>';
	echo '<a href="/waterting/trackconsumption.php" class = "acclinks">Track Consumption</a><br>';
	echo '<a href="/waterting/logout.php" class = "acclinks">Log out</a><br>';
}						
else //If there is no cookie,then head to the home page
{
	header('Location: /waterting/home.html');
}	
echo '</div>';
?>
<html>
	<head>
		<title> Water Ting </title>
	</head>
<style>

.logo 
{
position: fixed;
top: 10%;
left: 5%;
display: inline-block;
transform: translate(-50%, -50%);
}

.acclinks
{
text-decoration: none;
color: black;
font-family: Trebuchet MS;
}
</style>
<body>
<!--Image is a hyperlink. Redirects when it is clicked.-->
<a href='/waterting/main.php' class='logo'><img src='/waterting/droplet.jpg' width='150' height='120'></a>
<!--Code enclosed in form tag holds is how data is allowed to be input. i.e. textbox, button-->
<form action="addconsumption1.php" method="POST" enctype="multipart/form-data">
	<!--Textbox is identified by a name, so it can be passed using the POST method
	to the next php file when the submit button is clicked.-->
	<input type="number" name="Consumption" value="" MIN="0"/>
	<input type='submit' value='Add Water Consumption'>
</form>
</body>
</html>