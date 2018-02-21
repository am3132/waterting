<?php

if (!isset($_POST['FirstName']) OR !isset($_POST['LastName']) OR !isset($_POST['Email'])
	OR !isset($_POST['MobileNo']) OR !isset($_POST['Username']) OR !isset($_POST['Password'])
	OR !isset($_POST['CPassword']))
{
	header('Location: /waterting/signup.html');
}
else
{	
	$con = mysqli_connect("localhost","csed","waterting","waterting");
	if (!$con) 
	{
		echo "Failed to connect to database :" . mysqli_connect_error();
		die();
	}
	$firstname = $_POST['FirstName'];
	$lastname = $_POST['LastName'];
	$email = $_POST['Email'];
	$mobileno = $_POST['MobileNo'];
	$username = $_POST['Username'];
	$password = $_POST['Password'];
	$sql = "SELECT * FROM userstable WHERE Username = '$username' OR Email='$email'";
	$result = mysqli_query($con,$sql);
	$record_count = mysqli_num_rows($result);
	if ($record_count>0)
	{
		echo "<h1>Sorry, but either your username or your email is already taken!</h1><script>window.setTimeout(function(){window.history.go(-1)}, 3000);</script>";
		echo "<img style='position: fixed; bottom: 0px; right: 0px;' src='clank.png'>";
	}
	else
	{
		//Function that generates a cookie during signup session
		function getRandAuthToken()
		{
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomToken = '';
			for ($i = 0; $i < 8; $i++)
			{
				$randomToken .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomToken;
		}
			
		$sql = "INSERT INTO UsersTable (FirstName, LastName, Email, MobileNo, Username, Password)
		VALUES ('$firstname', '$lastname', '$email', '$mobileno', '$username', '$password')";
		mysqli_query($con,$sql); 
		
		$sql = "SELECT * FROM UsersTable WHERE Username = '$username' and Password = '$password'";
		$result = mysqli_query($con,$sql);
		
		if ($result && mysqli_num_rows($result) > 0) 
		{
			echo '<h1 style="font-family: Trebuchet MS;">Signed Up Successfully</h1>';
			echo '<h1 style="font-family: Trebuchet MS;">Entering Site</h1>';
			echo "<img style='position: fixed; bottom: 0px; right: 0px;' src='R&C.png'>";
			$authToken = getRandAuthToken();
			$query = "UPDATE userstable SET AuthToken = '$authToken' WHERE Username = '$username' AND Password ='$password'";
			$result = mysqli_query($con,$query);
			#Authorization Token for 1 hour
			setcookie("auth",$authToken,time()+3600,'/');
			echo '<meta http-equiv="refresh" content="2;url=/waterting/main.php"/> ';	
		}
	}
}
?>