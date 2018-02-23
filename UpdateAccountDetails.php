<?php
$con = mysqli_connect("localhost","csed","waterting","waterting");
if (!$con) 
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
if (!isset($_COOKIE['auth']) OR !isset($_POST['FirstName']) OR !isset($_POST['LastName'])
	OR !isset($_POST['Email']) OR !isset($_POST['MobileNo']) OR !isset($_POST['Height']) OR !isset($_POST['Weight'])
	OR !isset($_POST['Password']) OR !isset($_POST['CPassword'])
	OR !isset($_POST['OldEmail'])) // OR !isset($_POST['Username']) OR !isset($_POST['OldUsername'])  
{
	header('Location: /waterting/editaccountdetails.php');
}
else
{	
	$authToken = $_COOKIE['auth'];
	$firstname = $_POST['FirstName'];
	$lastname = $_POST['LastName'];
	$email =$_POST['Email'];
	$oldemail = $_POST['OldEmail'];
	$mobileno =$_POST['MobileNo'];
	$height = $_POST['Height'];
	$weight = $_POST['Weight'];
	// $username =$_POST['Username'];
	// $oldusername = $_POST['OldUsername'];
	$password =$_POST['Password'];
	echo '<h1>Test1</h1>';
	if (($email !== $oldemail)) //OR ($username !== $oldusername))
	{
		echo '<h1>Test2</h1>';
		$sql = "SELECT * FROM userstable WHERE Email='$email'"; //OR Username = '$username'";
		$result = mysqli_query($con,$sql);
		$row_count = mysqli_num_rows($result);
		if ($row_count>0)
		{
			echo "<h1>Sorry, but your email is already taken!</h1><script>window.setTimeout(function(){window.history.go(-1)}, 3000);</script>";
		}
		else
		{
			echo '<h1>Test3</h1>';
			$sql="UPDATE userstable SET FirstName = '$firstname', LastName = '$lastname', Email = '$email', MobileNo = '$mobileno', Height = '$height', Weight = '$weight', Password = '$password' WHERE AuthToken = '$authToken'";
			if (mysqli_query($con,$sql))
			{
				echo '<h1>Account details updated successfully</h1>';
				echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/main.php';}, 3000); </script> ";		
			}
		}
	}
	else
	{
		echo '<h1>Test4</h1>';
		$sql="UPDATE userstable SET FirstName = '$firstname', LastName = '$lastname', Email = '$email', MobileNo = '$mobileno', Height = '$height', Weight = '$weight', Password = '$password' WHERE AuthToken = '$authToken'";
		if (mysqli_query($con,$sql))
		{
			echo '<h1>Account details updated successfully</h1>';
			echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/main.php';}, 3000); </script> ";		
		}
	}
}
?>	