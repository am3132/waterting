<?php
echo '<div align="right">';

$authToken = null;
$con = mysqli_connect("localhost","csed","waterting","waterting");
if (!$con)
{
	echo "Failed to connect to database :" . mysqli_connect_error();
	die();
}
		
if (isset($_COOKIE['auth'])) 
{
	$authToken = $_COOKIE['auth'];
	$query = "SELECT * FROM userstable WHERE AuthToken = '$authToken'";
	$result = mysqli_query($con,$query);	
	$row = mysqli_fetch_assoc($result);
	$username = $row['Username'];
	$password = $row['Password'];
	$firstname = $row['FirstName'];
	$lastname = $row['LastName'];
	$email = $row['Email'];
	$mobileno = $row['MobileNo'];
	$height = $row['Height'];
	$weight = $row['Weight'];
	if ($username === "Admin" && $password === "Admin123")
	{
		header('Location: /compproject/home/home.php');
	}
	else
	{		echo "<div class='acclinks'>
			Welcome, $username !&nbsp;&nbsp;<br>
			</div>";
	echo '<a href="/waterting/editaccountdetails.php" class = "acclinks">Edit Account Details</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/statistics.php" class = "acclinks">Statistics</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/addconsumption.php" class = "acclinks">Add Consumption</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/trackconsumption.php" class = "acclinks">Track Consumption</a>&nbsp;&nbsp;<br>';
	echo '<a href="/waterting/logout.php" class = "acclinks">Log out</a>&nbsp;&nbsp;<br>';
				
	}						
} 
else 
{	
	header('Location: /waterting/home.html');
}	
echo '</div>';
?>

<html>
<head>
	<title> WT Edit Account </title>
</head>
<script>
function validateEditAccount() {
  var valid = 1;
  var firstname = document.getElementById('FirstName');
  var firstname_validation = document.getElementById("firstname_validation");
  var lastname = document.getElementById('LastName');
  var lastname_validation = document.getElementById("lastname_validation");  
  var email = document.getElementById('Email');
  var email_validation = document.getElementById("email_validation");
  var mobileno = document.getElementById('MobileNo');
  var mobileno_validation = document.getElementById("mobileno_validation");
  var height = document.getElementById('Height');
  var height_validation = document.getElementById("height_validation");
  var weight = document.getElementById('Weight');
  var weight_validation = document.getElementById("weight_validation");
  /* var username = document.getElementById('Username'); */
  var username_validation = document.getElementById("username_validation");
  var password = document.getElementById('Password');
  var password_validation = document.getElementById("password_validation");
  var cpassword = document.getElementById('CPassword');
  var cpassword_validation = document.getElementById("cpassword_validation");

  ///Validation for the First Name
  if ((firstname.value === "")
	 || !((/^[A-Za-z]{1,30}$/).test(firstname.value)))
  {
    valid = 0;
    firstname_validation.innerHTML = "Must not be empty/too large, must contain only letters.";
    firstname_validation.style.display = "block";
    firstname_validation.style.maxHeight = "400px";
    firstname_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    firstname_validation.style.display = "none";
    firstname_validation.parentNode.style.backgroundColor = "transparent";
  }
  
  
  ///Validation for the Last Name
  if ((lastname.value === "")
	 || !((/^[A-Za-z]{1,30}$/).test(lastname.value)))
  {
    valid = 0;
    lastname_validation.innerHTML = "Must not be empty/too large, must contain only letters.";
    lastname_validation.style.display = "block";
    lastname_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    lastname_validation.style.display = "none";
    lastname_validation.parentNode.style.backgroundColor = "transparent";
  }
  
  ///Validation for the Email
  if ((email.value === "")
	 || !((/[_a-zA-Z\d\-.]+@([_a-zA-Z\d\-]+(\.[_a-zA-Z\d\-]+)+)/).test(email.value))
	 || !(email.value.length <= 40)){
    valid = 0;
    email_validation.innerHTML = "Must not be empty/too large, must be valid.";
    email_validation.style.display = "block";
    email_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    email_validation.style.display = "none";
    email_validation.parentNode.style.backgroundColor = "transparent";
  }
  
  ///Validation for the Mobile Number
  if ((mobileno.value === "")
	 || !(/^[0-9]{11,11}$/).test(mobileno.value))
  {
    valid = 0;
    mobileno_validation.innerHTML = "Must not be empty,must contain only numbers, and must be exactly 11 digits.";
    mobileno_validation.style.display = "block";
    mobileno_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    mobileno_validation.style.display = "none";
    mobileno_validation.parentNode.style.backgroundColor = "transparent";
  }
  
  ///Validation for the Height
  if ((height.value === "")
	 || !(/^[0-9]{2,3}$/).test(height.value)
	 || (height.value > 300)
	 || (height.value < 50))
  {
    valid = 0;
    height_validation.innerHTML = "Must not be empty, and must be of the correct format.";
    height_validation.style.display = "block";
    height_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    height_validation.style.display = "none";
    height_validation.parentNode.style.backgroundColor = "transparent";
  }
  
  ///Validation for the Weight
  if ((weight.value === "")
	 || !(/^[0-9]{2,3}$/).test(weight.value)
	 || (weight.value > 300)
	 || (weight.value < 30))
  {
    valid = 0;
    weight_validation.innerHTML = "Must not be empty, and must be of the correct format.";
    weight_validation.style.display = "block";
    weight_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    weight_validation.style.display = "none";
    weight_validation.parentNode.style.backgroundColor = "transparent";
  }
  
 /*  //Validation for the Username
  if ((username.value === "")
	 || !((/^[a-zA-Z0-9]{6,20}$/).test(username.value))) 
  {
    valid = 0;
    username_validation.innerHTML = "Must not be empty and must contain only letters/numbers.";
    username_validation.style.display = "block";
    username_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    username_validation.style.display = "none";
    username_validation.parentNode.style.backgroundColor = "transparent";
  } */
  
  ///Validation for the Password
  if ((password.value === "")
	 || !((/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{6,20})$/).test(password.value)))
  {
    valid = 0;
    password_validation.innerHTML = "Must not be empty/out of range, at least : one uppercase & lowercase letter, and a digit.";
    password_validation.style.display = "block";
    password_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    password_validation.style.display = "none";
    password_validation.parentNode.style.backgroundColor = "transparent";
  }
  
  ///Validation for the Confirmed Password
  if ((cpassword.value === "")
	 || !(cpassword.value === password.value))
  {
    valid = 0;
    cpassword_validation.innerHTML = "Must not be empty, and must match the password above.";
    cpassword_validation.style.display = "block";
    cpassword_validation.parentNode.style.backgroundColor = "#FFDFDF";
  }
  else
  {
    cpassword_validation.style.display = "none";
    cpassword_validation.parentNode.style.backgroundColor = "transparent";
  }
    
  if (!valid)
    return false;
}
</script>

<style>
#firstname_validation, #lastname_validation, #email_validation, #mobileno_validation,
#height_validation, #weight_validation, #password_validation, #cpassword_validation { <!--#username_validation, -->
    display:none;
}

span.error {
  color:red;
}

.acclinks
{
text-decoration: none;
color: black;
font-family: Trebuchet MS;
position: relative;
	top: 300px;
}

td {font-family: Trebuchet MS;
font-size : 16px;}

table {position: absolute;
	left:14%;
	top:1.2%;
	border-style: solid;
    border-color: #C1C1C1;}
	
.logo 
{
position: fixed;
top: 10%;
left: 5%;
display: inline-block;
transform: translate(-50%, -50%);
}
</style>

<body>
<a href='/waterting/main.php' class='logo'><img src='/waterting/droplet.jpg' width='150' height='120'></a>	
<form action="updateaccountdetails.php" method="POST" onsubmit="return validateEditAccount();" enctype="multipart/form-data">
	<table>
		<input type='hidden' name='OldEmail' value="<?php echo $email ?>">
		<!--<input type='hidden' name='OldUsername' value="<?php echo $email ?>">-->
		<tr>
			<td>Firstname:</td>
				<td height='80' width='200'><input id="FirstName" name="FirstName" type="text" value="<?php echo $firstname ?>"/><br>
				<span id="firstname_validation" class="error" style="font-size:15px" style="font-size:15px"></span>
			</td>
			<td>Lastname:</td>
				<td height='80' width='200'><input id="LastName" name="LastName" type="text" value="<?php echo $lastname ?>"/><br />
				<span id="lastname_validation" class="error" style="font-size:15px"></span>
			</td>
			<td>Email:</td>
				<td height='80' width='200'><input id="Email" name="Email" type="text" value="<?php echo $email ?>"/><br>
				<span id="email_validation" class="error" style="font-size:15px"></span>
			</td>
		</tr>
		<tr>
			<td>Mobile Number</td>
				<td height='80' width='200'><input id="MobileNo" name="MobileNo" type="text" value="<?php echo $mobileno ?>"/><br>
				<span id="mobileno_validation" class="error" style="font-size:15px"></span>
			</td>
			<td>Height (cm):</td>
				<td height='80' width='200'><input id="Height" name="Height" type="text" value="<?php echo $height ?>"/><br />
				<span id="height_validation" class="error" style="font-size:15px"></span>
			</td>
			<td>Weight (kg):</td>
				<td height='80' width='200'><input id="Weight" name="Weight" type="text" value="<?php echo $weight ?>"/><br />
				<span id="weight_validation" class="error" style="font-size:15px"></span>
			</td>
		</tr>
		<tr>
			<td>Username:</td>
				<td height='80' width='200'><input type="text" DISABLED value="<?php echo $username ?>"/><br> <!--id="Username" name="Username"--> 
				<span style="font-size:15px"></span> <!--id="username_validation" class="error"-->
			</td>
			<td>Password:</td>
				<td height='80' width='200'><input id="Password" name="Password" type="password" value=""/><br>
				<span id="password_validation" class="error" style="font-size:15px"></span>
			</td>
			<td>Confirm Password:</td>
				<td height='80' width='200'><input id="CPassword" name="CPassword" type="password" value=""/><br>
				<span id="cpassword_validation" class="error" style="font-size:15px"></span>
			</td>
		</tr>
		<tr>
			<td align='center' colspan='7'><input type="submit" value="Update Account Details"/></td>
		</tr>
	</table>
</form>
</body>
</html>