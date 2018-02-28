<?php
echo '<div align="right">';
$authToken = null;	
//Create connection to the server
$con = mysqli_connect('localhost', 'csed', 'waterting', 'waterting');
//Check connection
if (!$con) 
{
	echo "Error connecting to the database" . mysqli_connect_error(); 
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
	$record = mysqli_fetch_assoc($result);
	$username = $record['Username'];
	$userid = $record['UserID'];
	echo "<div class='acclinks'>
			Welcome, $username !&nbsp;&nbsp;<br>
			</div>";
	echo '<a href="/waterting/editaccountdetails.php" class = "acclinks">Edit Account Details</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/statistics.php" class = "acclinks">Statistics</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/addconsumption.php" class = "acclinks">Add Consumption</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/trackconsumption.php" class = "acclinks">Track Consumption</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/logout.php" class = "acclinks">Log out</a>&nbsp;&nbsp;<br>';
		// if ($_GET["datefrom"] == "" OR $_GET["dateto"] == "")
		// {
			// header('Location: /waterting/main.php');
		// }
		// else
		// {
			// $datefrom = $_GET["datefrom"];
			// $dateto = $_GET["dateto"];
		// }
}
else //If there is no cookie,then head to the home page
{	
	header('Location: /waterting/home.html');
}		
echo '</div>';
?>
<html>
<head>
	<title> WT Track ting </title>
<style>

table#leftside td {font-family: Trebuchet MS;
	font-size: 20;
  color: #e8e8e8;
  text-shadow:
   -1px -1px 0 #000,  
    1px -1px 0 #000,
    -1px 1px 0 #000,
     1px 1px 0 #000;
}
.links:hover { background-color:grey;}

.links {text-decoration: none;
	color: #e8e8e8;}
	
.middle 
{
position: absolute;
left:10%;
top:20%;
background-color: white;
border-width: 3px;
border-color: #7E7E7E;
border-style: solid;
}

th,td {font-family: Trebuchet MS;}

.border_vsidestd { border-right : 2px solid #000;}

.border_vsidesth
{
background-color : #fff;
border-right : 2px solid #000;
border-bottom : 2px solid #000;
}

table#orders tr:nth-child(even) {background-color: #fff;}

table#orders tr:nth-child(odd) {background-color: #eee;}

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

th,td {font-family: Trebuchet MS;}

tr { border-bottom : 2px solid black;}

.border_vsides
{
border-left:2px solid #000;
}
</style>	
</head>
<body>
<!--Image is a hyperlink. Redirects when it is clicked.-->
<a href='/waterting/main.php' class='logo'><img src='/waterting/droplet.jpg' width='150' height='120'></a>
<?php
//Create SQL query to fetch all the days from the logstable where the user has registered their consumptions.
$sql = "SELECT * FROM logstable WHERE ( UserID = '$userid' ) ORDER BY DayID DESC";
//Execute SQL query
$result = mysqli_query($con,$sql);
?>
<table class='middle'>
	<tr><!--<th> tag used to display the headings-->
		<th class="border_vsidesth" align="center">Day ID</th>
		<th class="border_vsidesth" align="center">Customer ID</th>
		<th class="border_vsidesth" align="center">Date</th>
		<th class="border_vsidesth" align="center">Current Consumption</th>
		<th class="border_vsidesth" align="center">TotalNeeded</th>
		<th class="border_vsidesth" align="center">Accomplished</th>
		<!--<th class="border_vsidesth"></th>-->
	</tr>
	<?php
	$cnt = 0;
	//WHILE there exist records in the logstable of the specific user, then display them.
	while ($record=mysqli_fetch_array($result))
	{
		//Store the fields associated with the record in the logs in a variable
		$dayid = $record["DayID"];
		$userid = $record["UserID"];
		$date = $record["Date"];
		$currentcons = $record["CurrentCons"];
		$totalneeded = $record["TotalNeeded"];
		$accomplished = $record["Accomplished"];

		echo "<tr>
				<td class='border_vsidestd' align='center'>$dayid</td>
				<td class='border_vsidestd' align='center'>$customerid</td>
				<td class='border_vsidestd' align='center'>$date</td>
				<td class='border_vsidestd' align='center'>$currentcons</td>
				<td class='border_vsidestd' align='center'>$totalneeded</td>
				<td class='border_vsidestd' align='center'>$accomplished</td>
			  </tr>";
		$cnt = $cnt + 1;
	}
	?>
</table>
</body>
</html>	