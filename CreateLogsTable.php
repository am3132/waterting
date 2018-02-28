<?php
//Create connection to the server
$con = mysqli_connect('localhost', 'csed', 'waterting' , 'waterting');
//Check connection
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
//Execute SQL query, using the assigned database
mysqli_query ($con,"USE waterting");
//Create SQL query that CREATES the table
$sql = "CREATE TABLE LogsTable (
			DayID int NOT NULL AUTO_INCREMENT,
			UserID int,
			Date datetime,
			CurrentCons int(11),
			TotalNeeded int (11),
			Accomplished BOOLEAN,
			PRIMARY KEY (DayID),
			FOREIGN KEY (CustomerID) REFERENCES UsersTable(CustomerID)
		)";
//Execute SQL query
mysqli_query($con,$sql);
?>