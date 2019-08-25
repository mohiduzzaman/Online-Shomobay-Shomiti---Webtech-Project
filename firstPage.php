<?php
	session_start();
	$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
	if(isset($_POST['userLogIn'])){
		$u_email = mysqli_real_escape_string($con,$_POST['userEmail']);
		$u_password = mysqli_real_escape_string($con,$_POST['userPassword']);
		$select_user = "select * From user_registration_table where userEmail = '$u_email' and Password='$u_password'";
			$query = mysqli_query($con,$select_user);
			$check_user = mysqli_num_rows($query);
			if($check_user == 1){
				$_SESSION['ue'] = $u_email;
				echo "<script>window.open('userProfilePage.php','_self')</script>";
			}
			else echo"<script>alert('Incorrect Email and PassWord or go to signup!')</script>";
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>

	<title>Online Shomobay Shomiti</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<form action = "firstPage.php" method ="post">
		<div class="mainpage">
			<a href ="aboutShomobayShomiti.php"> 
				Online Shomobay Shomiti
			</a>
		</div>
		<div class="login">
		<table  align="center">
			<tr>
				<td colspan="2">
					<h3 align="center"> User logIn</h3>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>User Email</td>
				<td>
					<input type = "text" name = "userEmail" placeholder="Email" />
				</td>
				<td></td>	
			</tr>
			<tr>
				<td>PassWord</td>
				<td>
					<input type = "password" name = "userPassword" placeholder="Password" />
				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td align="right">
					<input type = "submit" value = "Log In" name = "userLogIn">
				</td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td>
					<a href ="Registration.php">Go to Registration</a>
				</td>
				<td></td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>