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
	//Execute SQL query
	$result = mysqli_query($con,$query);
	//Store the fields associated with the record in the userstable in a variable
	$row = mysqli_fetch_assoc($result);
	$username = $row['Username'];
	
	$heightcm = $row['Height'];
	//Calculates height in feet and inches separately
	$heightft = ($heightcm/100) * 3.28084;
	$wholeft = floor($heightft); //Gets only the integer part of the number
	$fractionft = $heightft - $wholeft; //Gets only the decimal part of the number
	$heightin = $fractionft * 12;
	
	$weightkg = $row['Weight'];
	//Calculates weight in lbs(libres/pounds)
	$weightlbs = $weightkg / 0.45359237;
	//Calculates water consumption needed per day. This will change in the future as we add new stuff to the website.
	$waterperday = ($weightkg / 30) * 1000;
	
	echo "<div class='acclinks'>
				Welcome, $username !<br>
				</div>";
	echo '<a href="/waterting/editaccountdetails.php" class = "acclinks">Edit Account Details</a><br>';
	echo '<a href="/waterting/statistics.php" class = "acclinks">Statistics</a><br>';
	echo '<a href="/waterting/addconsumption.php" class = "acclinks">Add Consumption</a><br>';
	echo '<a href="/waterting/trackconsumption.php" class = "acclinks">Track Consumption</a><br>';
	echo '<a href="/waterting/logout.php" class = "acclinks">Log out</a>&nbsp;&nbsp;<br>';					
} 
else //If there is no cookie,then head to the home page
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
	<!--Image is a hyperlink. Redirects when it is clicked.-->
	<a href='/waterting/main.php' class='logo'><img src='/waterting/droplet.jpg' width='150' height='120'></a>	
	<table style="position: absolute; left:25%;">
	<!--Textboxes are used to display data to the user and prevent the amendment of it. i.e. DISABLED inside the <input> tag
	to the next php file when the submit button is clicked.-->
		<tr>
			<td colspan='2'><h1>Your metrics are:</h1> </td>
		</tr>
		<tr>
			<td style="font-size:30px;">
				Height:
			</td>	
			<td>
				<input type='text' style="width:130px; height:50px; font-size:28px; border:none;" DISABLED value="<?php echo "$heightcm cm";?>">
				<input type='text' style="width:29px; height:50px; font-size:28px; border:none;" DISABLED value="<?php echo intval($heightft) , '\'';?>">
				<input type='text' style="width:107px; height:50px; font-size:28px; margin-left:-10px; border:none;" DISABLED value="<?php echo number_format((float)$heightin, 2, '.', ''), '\'\'';;?>">
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