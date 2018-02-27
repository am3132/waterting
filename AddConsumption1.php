<style>
h1 {font-family:Trebuchet MS;}
</style>
<?php
$con = mysqli_connect('localhost', 'csed', 'waterting', 'waterting');
//if there is an error connecting to the database it must be displayed.
if (!$con) 
{
	echo "Error connecting to the database" . mysqli_connect_error(); 
	die();
}
if (!isset($_POST['Consumption']) OR !isset($_COOKIE['auth']))
{
	header("Location: /waterting/main.php");
}
else
{
	echo "<h2>Test1 Cookie Check</h2>";
	//Storing details from form in variables
	$consumption = $_POST['Consumption'];
	$authToken = $_COOKIE['auth'];
	
		//find the CustomerID of the customer that submits the form
		$sql="SELECT * FROM userstable WHERE AuthToken = '$authToken' LIMIT 1";
		$result = mysqli_query($con,$sql);
		$record = mysqli_fetch_array($result);
		$customerid = $record['CustomerID'];
		//check if the Customer already has an order with the status of ‘Basket’,if he/she has not, create a new order
		
		$sql = "SELECT * FROM logstable WHERE CustomerID = '$customerid' AND Accomplished = FALSE LIMIT 1";
		$result = mysqli_query($con,$sql);
		$record_count = mysqli_num_rows($result);
		
		if ($record_count > 0)
		{
			$record = mysqli_fetch_array($result);
			$dayid = $record['DayID'];
			$currentcons = $record['CurrentCons'];
			$consumption = $consumption + $currentcons;
			echo "<h2>Test2 Check IF Daily Consumption Has Already Started -->Yes, increment currentpos</h2>";
			$sql = "UPDATE logstable SET CurrentCons = $consumption WHERE DayID = '$dayid'";
			mysqli_query($con,$sql);
		}
		else
		{
			$totalneeded = $record['TotalNeeded'];
			//create new order for the Customer
			echo "<h1>Test3 Starts Daily Consumption </h1>";
			$sql="INSERT INTO logstable (CustomerID, Date, CurrentCons, TotalNeeded, Accomplished) VALUES ('$customerid', NOW(), $consumption, $totalneeded, FALSE)";
			mysqli_query($con,$sql);
			//fetch the OrderID of the order that has just been created
			$sql="SELECT MAX(dayid) AS newestdayid FROM logstable";
			$result=mysqli_query($con,$sql);
			$array=mysqli_fetch_array($result);
			$dayid=$array['newestdayid'];
		}
		
		//check if log total will exceed daily goal
		$sql = "SELECT * FROM logstable WHERE DayID = '$dayid'";
		$result = mysqli_query($con,$sql);
		$record = mysqli_fetch_array($result);
		$totalneeded = $record['TotalNeeded'];
		$currentcons = $record['CurrentCons'];
		
		if ($currentcons >= $totalneeded)
		{
			echo "<h1>Test4 Goal reached</h1>";
			$sql = "UPDATE logstable SET Accomplished = TRUE, CurrentCons='$currentcons' WHERE DayID = '$dayid'";
			mysqli_query($con,$sql);
		}
	echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/main.php';}, 1500); </script> ";
	}
?>