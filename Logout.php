<?php
if (isset($_COOKIE['auth']))
{
	$authToken = $_COOKIE['auth'];
	setcookie("auth", '' , time() - 3600 ,'/');
	header("Location: /waterting/home.html");
}
else
	header("Location: /waterting/home.html");
?>