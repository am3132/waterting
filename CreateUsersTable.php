<?php
//Create connection to the server
$con = mysqli_connect('localhost', 'csed', 'waterting', 'waterting');
//Check connection
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
//Execute SQL query, using the assigned database
mysqli_query ($con,"USE WaterTing");
//Create SQL query that CREATES the table
$sql = "CREATE TABLE UsersTable (
			UserID int NOT NULL AUTO_INCREMENT,
			FirstName varchar(30),
			LastName varchar(30),
			Email varchar(40),
			MobileNo varchar(15),
			Height varchar(3),
			Weight varchar(3),
			TotalNeeded int(8),
			Username varchar(20),
			Password varchar(20),
			AuthToken varchar(8),
			PRIMARY KEY (CustomerID),
			UNIQUE INDEX (CustomerID)
			)";
//Execute SQL query
mysqli_query($con,$sql);
?>