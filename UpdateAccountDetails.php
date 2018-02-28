<?php
//Create connection to the server
$con = mysqli_connect("localhost","csed","waterting","waterting");
//Check connection
if (!$con) 
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
//Check if there isn't any cookie or a value send through the post method.
//if !isset() means 'IF there IS NOT'
if (!isset($_COOKIE['auth']) OR !isset($_POST['FirstName']) OR !isset($_POST['LastName'])
	OR !isset($_POST['Email']) OR !isset($_POST['MobileNo']) OR !isset($_POST['Height']) OR !isset($_POST['Weight'])
	OR !isset($_POST['Password']) OR !isset($_POST['CPassword'])
	OR !isset($_POST['OldEmail'])) // OR !isset($_POST['Username']) OR !isset($_POST['OldUsername'])  
{
	//Redirect to homepage
	header('Location: /waterting/editaccountdetails.php');
}
else
{
	//Storing details from form in variables
	$authToken = $_COOKIE['auth'];
	$firstname = $_POST['FirstName'];
	$lastname = $_POST['LastName'];
	$email = $_POST['Email'];
	$oldemail = $_POST['OldEmail'];
	$mobileno =$_POST['MobileNo'];
	$height = $_POST['Height'];
	$weight = $_POST['Weight'];
	//The following 2 variables might not be left in the end. I'll explain later on.
	// $username =$_POST['Username'];
	// $oldusername = $_POST['OldUsername'];
	$password = $_POST['Password'];
	echo '<h1>Test1</h1>';
	//Check if email already exists in the database
	//IF the new email is NOT the same as the old email
	if (($email !== $oldemail)) //OR ($username !== $oldusername))
	{
		echo '<h1>Test2</h1>';
		//Create SQL query that finds any emails from the userstable that already exist
		$sql = "SELECT * FROM userstable WHERE Email='$email'"; //OR Username = '$username'";
		//Execute SQL query
		$result = mysqli_query($con,$sql);
		//Store number of acquired rows in a variable
		$row_count = mysqli_num_rows($result);
		//If the row count is larger than 0 i.e. the email already exists
		//Then display a message and redirect to the previous page.
		if ($row_count>0)
		{
			echo "<h1>Sorry, but your email is already taken!</h1><script>window.setTimeout(function(){window.history.go(-1)}, 3000);</script>";
		}
		else
		{
			echo '<h1>Test3</h1>';
			//Create SQL query that UPDATES the new details to the logged in user
			$sql="UPDATE userstable SET FirstName = '$firstname', LastName = '$lastname', Email = '$email', MobileNo = '$mobileno', Height = '$height', Weight = '$weight', Password = '$password' WHERE AuthToken = '$authToken'";
			//If execution of the SQL query is successful, then display message and redirect to main page.
			if (mysqli_query($con,$sql))
			{
				echo '<h1>Account details updated successfully</h1>';
				echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/main.php';}, 3000); </script> ";		
			}
		}
	}
	else //Else, if the new email IS the same as the old email i.e. it hasn't changed
	{
		echo '<h1>Test4</h1>';
		//Create SQL query that UPDATES the new details to the logged in user
		$sql="UPDATE userstable SET FirstName = '$firstname', LastName = '$lastname', Email = '$email', MobileNo = '$mobileno', Height = '$height', Weight = '$weight', Password = '$password' WHERE AuthToken = '$authToken'";
		//If execution of the SQL query is successful, then display message and redirect to main page.
		if (mysqli_query($con,$sql))
		{
			echo '<h1>Account details updated successfully</h1>';
			echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/main.php';}, 3000); </script> ";		
		}
	}
}
?>	