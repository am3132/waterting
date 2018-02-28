<?php
$authToken = null;
//Create connection to the server
$con = mysqli_connect("localhost","csed","waterting","waterting");
//Check the connection
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
//If the textboxes were left empty, then redirect to the home page.
if (empty($_POST['Username']) OR empty($_POST['Password']))
{
	header('Location: /waterting/home.html');
}
else
{
	echo '<center>';
	echo '<h1>Test1 Credentials Taken</h1>';
	//Storing details from form in variables
	$checkUN = $_POST['Username'];
	$checkPW = $_POST['Password'];
	//Create SQL query to check if the username exists in the userstable
	$query = "SELECT * FROM UsersTable WHERE Username = '$checkUN'";
	//Execute SQL query
	$result = mysqli_query($con,$query);
	//Store the fields associated with the record in the userstable in a variable
	$record = mysqli_fetch_array($result);
	//The following are two variables that store the two fields of data
	//i.e. Username and Password, that we got from the record in the userstable
	$username = $record['Username'];
	$password = $record['Password'];

	//Function that generates a cookie during login session
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
	
	//Checks if the username & password provided indeed exist in the userstable
	if ($username == $checkUN && $password == $checkPW)
		{ 
			echo '<h1>Test2 Login Successful</h1>';
			//Call function getRandAuthToken() that generates a random string of characters and store the result to the variable
			$authToken = getRandAuthToken();
			//Create SQL query to UPDATE the cookie of the logged in user
			$query = "UPDATE userstable SET AuthToken='$authToken' WHERE Username = '$checkUN' AND Password ='$checkPW'";
			//Execute SQL query
			$result = mysqli_query($con,$query);
			//Authorization Token for 1 hour
			setcookie("auth",$authToken,time()+3600,'/');
			//Redirect to main page
			echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/main.php';}, 1500); </script> ";
		}

	else //Else, if the username OR password are wrong, then the user is not a valid user
	{
		echo "Not a valid user.";
		//Redirect to home page
		echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/home.html';}, 1500); </script> ";
	}
	echo '</center>';
}
?>