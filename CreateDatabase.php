<?php
// Create connection
$con = mysqli_connect('localhost', 'csed', 'waterting');
// Check connection
if (!$con)
{
    die("Connection failed: " . mysqli_connect_error());
}
// Create database
$sql = "CREATE DATABASE waterting";
if (mysqli_query($con, $sql)) {
    echo "Database created successfully";
} 
else
{
    echo "Error creating database: " . mysqli_error($con);
}
mysqli_close($con);
?>