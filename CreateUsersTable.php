<?php
$con = mysqli_connect('localhost', 'csed', 'waterting', 'waterting');
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
mysqli_query ($con,"USE WaterTing");
$sql = "CREATE TABLE UsersTable (
			CustomerID int NOT NULL AUTO_INCREMENT,
			FirstName varchar(30),
			LastName varchar(30),
			Email varchar(40),
			MobileNo int(8),
			Username varchar(20),
			Password varchar(20),
			AuthToken varchar(8),
			PRIMARY KEY (CustomerID),
			UNIQUE INDEX (CustomerID)
			)";
mysqli_query($con,$sql);
?>