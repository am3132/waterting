<?php
echo '<div align="right">';

$authToken = null;
$con = mysqli_connect("localhost","csed","waterting","waterting");
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
		
if (isset($_COOKIE['auth'])) 
{
	$authToken = $_COOKIE['auth'];
	$query = "SELECT * FROM userstable WHERE AuthToken = '$authToken'";
	$result = mysqli_query($con,$query);	
	$row = mysqli_fetch_assoc($result);
	$username = $row['Username'];
	$password = $row['Password'];
	
	$heightcm = $row['Height'];
	$heightft = ($heightcm/100) * 3.28084;
	$wholeft = floor($heightft); //int Part
	$fractionft = $heightft - $wholeft;
	$heightin = $fractionft * 12;
	
	$weightkg = $row['Weight'];
	$weightlbs = $weightkg / 0.45359237;
	
	$waterperday = ($weightkg / 30) * 1000;
	
	if ($username === "Admin" && $password === "Admin123")
	{
		header('Location: /waterting/home.html');
	}
	else
	{	
	echo "<div class='acclinks'>
				Welcome, $username !&nbsp;&nbsp;<br>
				</div>";
	echo '<a href="/waterting/editaccountdetails.php" class = "acclinks">Edit Account Details</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/statistics.php" class = "acclinks">Statistics</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/addconsumption.php" class = "acclinks">Add Consumption</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/trackconsumption.php" class = "acclinks">Track Consumption</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/logout.php" class = "acclinks">Log out</a>&nbsp;&nbsp;<br>';
				
	}						
} 
else 
{	
	header('Location: /waterting/home.html');
}	
echo '</div>';
?>

<html>
<head>
	<title> WT Statistics </title>
</head>
<style>
.logo 
{
position: absolute;
top: 10%;
left: 5.7%;
display: inline-block;
transform: translate(-50%, -50%);
}

table {border-style: solid;
    border-color: #C1C1C1;}

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
	<table style="position: absolute; left:25%;">
		<tr>
			<td colspan='2'><h1>Your metrics are:</h1> </td>
		</tr>
		<tr>
			<td style="font-size:30px;">
				Height:
			</td>	
			<td>
				<input type='text' style="width:130px; height:50px; font-size:28px; border:none;" name='1' id='1' DISABLED value="<?php echo "$heightcm cm";?>">
				<input type='text' style="width:29px; height:50px; font-size:28px; border:none;" name='2' id='2' DISABLED value="<?php echo intval($heightft) , '\'';?>">
				<input type='text' style="width:107px; height:50px; font-size:28px; margin-left:-10px; border:none;" name='2' id='2' DISABLED value="<?php echo number_format((float)$heightin, 2, '.', ''), '\'\'';;?>">
			</td>
		</tr>
		<tr>
			<td style="font-size:30px;">
				Weight:
			</td>
			<td>
				<input type='text' style="width:130px; height:50px; font-size:28px; border:none;" name='1' id='1' DISABLED value="<?php echo "$weightkg kg"?>">
				<input type='text' style="width:130px; height:50px; font-size:28px; border:none;" name='2' id='2' DISABLED value="<?php echo number_format((float)$weightlbs, 2, '.', ''), ' lbs'?>">
			</td>
		</tr>
	</table>
	<table style="position: absolute; left:25%; top:50%">
		<tr>
			<td>
			You need to drink <?php echo "$waterperday" ?> ml of water everyday.
			</td>
		</tr>
	</table>
	</body>
</html>