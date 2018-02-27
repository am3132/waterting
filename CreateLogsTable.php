<?php
$con = mysqli_connect('localhost', 'csed', 'waterting' , 'waterting');
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
mysqli_query ($con,"USE csed");
$sql = "CREATE TABLE LogsTable (
			DayID int NOT NULL AUTO_INCREMENT,
			CustomerID int,
			Date datetime,
			CurrentCons int(11),
			TotalNeeded int (11),
			Accomplished BOOLEAN,
			PRIMARY KEY (DayID),
			FOREIGN KEY (CustomerID) REFERENCES UsersTable(CustomerID)
		)";
mysqli_query($con,$sql);
?>