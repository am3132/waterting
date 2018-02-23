<html>
	<head>
		<title> Water Ting </title>
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
</style>
	</head>
</html>	
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
	echo "<form action='/waterting/Logout.php'> <input style=width:500px;height:250px;font-size:100px; type='submit' value='Log out'> </form>";
}						

else 
{
	header('Location: /waterting/home.html');
}	
?>