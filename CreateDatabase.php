<?php
//Create connection to the server
$con = mysqli_connect('localhost', 'csed', 'waterting');
//Check connection
if (!$con)
{
    echo "Error connecting to the database" . mysqli_connect_error(); 
	die();
}

//Create SQL query that CREATES the database. This is executed only ONCE.
$sql = "CREATE DATABASE waterting";
//If execution of the query is successfull, then display message.
if (mysqli_query($con, $sql))
{
    echo "Database created successfully";
} 
else //Else display error
{
    echo "Error creating database: " . mysqli_error($con);
}
//Close connection
mysqli_close($con);
?>