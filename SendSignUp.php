<style>
h1 {font-family: Trebuchet MS;}
</style>
<?php
//Check if there isn't any cookie or a value send through the post method.
//if !isset() means 'IF there IS NOT'
if (!isset($_POST['FirstName']) OR !isset($_POST['LastName']) OR !isset($_POST['Email'])
	OR !isset($_POST['MobileNo']) OR !isset($_POST['Height']) OR !isset($_POST['Weight'])
	OR !isset($_POST['Username']) OR !isset($_POST['Password'])	OR !isset($_POST['CPassword']))
{
	//Redirect to homepage
	header('Location: /waterting/signup.html');
}
else
{	//Create connection to the server
	$con = mysqli_connect("localhost","csed","waterting","waterting");
	//Check connection
	if (!$con) 
	{
		echo "Failed to connect to database :" . mysqli_connect_error();
		die();
	}
	//Storing details from form in variables
	$firstname = $_POST['FirstName'];
	$lastname = $_POST['LastName'];
	$email = $_POST['Email'];
	$mobileno = $_POST['MobileNo'];
	$height = $_POST['Height'];
	$weight = $_POST['Weight'];
	$totalneeded = ($weight / 30) * 1000;
	$username = $_POST['Username'];
	$password = $_POST['Password'];
	//Create SQL query to check if the username or email already exists.
	$sql = "SELECT * FROM userstable WHERE Username = '$username' OR Email='$email'";
	//Execute SQL query
	$result = mysqli_query($con,$sql);
	//Store number of acquired rows in a variable
	$record_count = mysqli_num_rows($result);
	//If the row count is larger than 0 (i.e. there already exists a username and an email the same as the one submitted)
	//Then display a message, and redirect to the previous site
	if ($record_count>0)
	{
		echo "<h1>Sorry, but either your username or your email is already taken!</h1><script>window.setTimeout(function(){window.history.go(-1)}, 3000);</script>";
	}
	else //Else, create the user
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
		//Create SQL query that INSERTS the submitted values as a new record in the userstable
		$sql = "INSERT INTO UsersTable (FirstName, LastName, Email, MobileNo, Height, Weight, TotalNeeded, Username, Password)
		VALUES ('$firstname', '$lastname', '$email', '$mobileno', '$height', '$weight', '$totalneeded','$username', '$password')";
		//Execute SQL query
		mysqli_query($con,$sql); 
		//Create SQL query that identifies the newly created user, so it assigns a cookie to him/her
		$sql = "SELECT * FROM UsersTable WHERE Username = '$username' and Password = '$password'";
		//Execute SQL query
		$result = mysqli_query($con,$sql);
		
		if ($result && mysqli_num_rows($result) > 0) 
		{
			echo '<h1>Signed Up Successfully</h1>';
			echo '<h1>Entering Site</h1>';
			//Call function getRandAuthToken() that generates a random string of characters and store the result to the variable
			$authToken = getRandAuthToken();
			//Create SQL query to UPDATE the cookie of the logged in user
			$query = "UPDATE userstable SET AuthToken = '$authToken' WHERE Username = '$username' AND Password ='$password'";
			//Execute SQL query
			$result = mysqli_query($con,$query);
			//Authorization Token for 1 hour
			setcookie("auth",$authToken,time()+3600,'/');
			//Redirect to main page
			echo '<meta http-equiv="refresh" content="2;url=/waterting/main.php"/> ';	
		}
	}
}
?>