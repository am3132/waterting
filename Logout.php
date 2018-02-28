<?php
//Check if there is a cookie. if isset() means 'IF there IS'
if (isset($_COOKIE['auth']))
{
	//Store cookie in a variable
	$authToken = $_COOKIE['auth'];
	//SET the cookie back to 1 hour. This basically deletes the cookie.
	setcookie("auth", '' , time() - 3600 ,'/');
	//Redirect to the home page
	header("Location: /waterting/home.html");
}
else //If there is no cookie,then head to the home page
	header("Location: /waterting/home.html");
?>