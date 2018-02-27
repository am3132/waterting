<?php

$authToken = null;
$con = mysqli_connect("localhost","csed","waterting","waterting");
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}

if (empty($_POST['Username']) OR empty($_POST['Password']))
{
	header('Location: /waterting/home.html');
}
else
{
echo '<h1>Test1 Credentials Taken</h1>';
echo '<center>';
$checkUN = $_POST['Username'];
$checkPW = $_POST['Password'];
$query = "SELECT * FROM UsersTable WHERE Username = '$checkUN'";
$result = mysqli_query($con,$query);
$record = mysqli_fetch_array($result);
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

if ($username == $checkUN && $password == $checkPW)
    { 
		echo '<h1>Test2 Login Successful</h1>';
		$authToken = getRandAuthToken();
		$query = "UPDATE userstable SET AuthToken='$authToken' WHERE Username = '$checkUN' AND Password ='$checkPW'";
		$result = mysqli_query($con,$query);
		#Authorization Token for 1 hour
		setcookie("auth",$authToken,time()+3600,'/');
		echo "<script type='text/javascript'> window.setTimeout(function(){window.location.href = '/waterting/main.php';}, 1500); </script> ";
	}

else
{
	echo "<h1>Not a valid user!</h1><script>window.setTimeout(function(){window.history.go(-1)}, 3000);</script>";
	echo "<img style='position: fixed; bottom: 0px; right: 0px;' src='clank.png'>";
}
echo '</center>';
}
?>