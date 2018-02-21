<?php
$con = mysqli_connect('localhost', 'lemesios', 'ForeverGaming' , 'ForeverGaming');
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
mysqli_query ($con,"USE ForeverGaming");
$sql = "CREATE TABLE ProductsTable (
			ProductID int NOT NULL AUTO_INCREMENT,
			Name text,
			Price decimal(3,2),
			SellingPrice decimal(3,2),
			Stock int,
			StockSold int,
			Description text,
			Genre varchar(30),
			Photo longblob,
			PhotoType varchar(64),
			PRIMARY KEY (ProductID),
			UNIQUE INDEX (ProductID)
			)";
mysqli_query($con,$sql);
?>