<?php
echo '<div align="right">';
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
	echo "<div class='acclinks'>
			Welcome, $username !&nbsp;&nbsp;<br>
			</div>";
	echo '<a href="/waterting/editaccountdetails.php" class = "acclinks">Edit Account Details</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/statistics.php" class = "acclinks">Statistics</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/addconsumption.php" class = "acclinks">Add Consumption</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/trackconsumption.php" class = "acclinks">Track Consumption</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/logout.php" class = "acclinks">Log out</a>&nbsp;&nbsp;<br>';
}						
else 
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
<a href='/waterting/main.php' class='logo'><img src='/waterting/droplet.jpg' width='150' height='120'></a>	
<form action="addconsumption1.php" method="POST" enctype="multipart/form-data">
	<input type="number" id="Consumption" name="Consumption" value=""/>
	<input type='submit' value='Add Water Consumption'>
</form>
</body>
</html>