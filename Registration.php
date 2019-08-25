
<?php
	$databaseConnection = 1;
	if(isset($_POST["userName"]) && isset($_POST["user_Registration_btn"])){
		$sn = $_POST["userName"];
		if(empty($sn)){
			$databaseConnection = 0;
		echo "Name cant be empty<br/>";
		}		
	}
	if(isset($_POST["userEmail"])){
		$email = $_POST["userEmail"];
		echo $email;
		if((filter_var($email,FILTER_VALIDATE_EMAIL) == false)){
			$databaseConnection = 0;
			if(empty($email))echo "Email can not be empty<br/>";
				else echo "Email is not valid<br/>";	
		}
		$db = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
		$sql_e ="SELECT userEmail FROM user_registration_table WHERE userEmail = '$email'";
		$res_e = mysqli_query($db,$sql_e) or die(mysqli_error($db));
		if(mysqli_num_rows($res_e)>0){
			echo "<script>alert('This Email has already Taken')</script>";
		}
	}
	if(isset($_POST["prof"]) && isset($_POST["user_Registration_btn"])){
		$sn = $_POST["prof"];
		if(empty($sn)){
			$databaseConnection = 0;
		echo "*(Must fill up your profession)<br/>";
		}	
	}
	if(isset($_POST["user_Contact"])){
			$count = strlen($_POST["user_Contact"]);
			if($count == 0)echo "Must fillup the contact<br/>";
			if($count >0 && $count <11)
				{
					$databaseConnection = 0;
					echo "Wrong contact number<br/>";
				}
	}
	if (!isset($_POST['gender']) && isset($_POST['user_Registration_btn'])){
		if($_POST['gender']!='checked')
			echo "gender is not selected<br/>";
	}
	if(isset($_POST["day"]) && isset($_POST["month"]) && isset($_POST["year"])){
		$d =(int) $_POST["day"];
		$m =(int) $_POST["month"];
		$y =(int)$_POST["year"];
		if(($d>=1 && $d<=31) && ($m>=1 && $m<=12) && ($y>=1)){
			echo "BirthDay is".$d."-".$m."-".$y."<br/>";
		}
		else {
			$databaseConnection = 0;
			echo "Invalid Birth Day<br/>";
		}
	}
	if(isset($_POST["day"]) && isset($_POST["month"]) && isset($_POST["year"])){
		$birthday =$_POST["day"].'/'.$_POST["month"].'/'.$_POST["year"];
		echo $birthday;	
	}
	if($databaseConnection == 1){
		session_start();
		$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
		if(isset($_POST['user_Registration_btn'])){
			$u_name = mysql_real_escape_string($_POST['userName']);
			$u_Email = mysql_real_escape_string($_POST['userEmail']);
			$u_Password = mysql_real_escape_string($_POST['userPassword_textBox']);
			$u_ConfirmPassword = mysql_real_escape_string($_POST['user_ConfirmPassword']);
			$u_Profession = mysql_real_escape_string($_POST['prof']);
			$u_Gender = mysql_real_escape_string($_POST['gender']);
			$u_Address = mysql_real_escape_string($_POST['user_Address']);
			$u_Contact = mysql_real_escape_string($_POST['user_Contact']);
			$u_VoterId = mysql_real_escape_string($_POST['user_VoterId']);
			$u_Birthday = $birthday;
		$sql = "INSERT INTO user_registration_table(userName,userEmail,Password,Profession,Gender,Permanent_Address,Contact_No,Voter_ID,DateOfBirth,FriendList,ConfirmPassword)VALUES('$u_name','$u_Email','$u_Password','$u_Profession','$u_Gender','$u_Address','$u_Contact','$u_VoterId','$u_Birthday','1','$u_ConfirmPassword')";
			 $query =  mysqli_query($con,$sql);
			 if($query){
			 	echo "<script>alert('$u_name ,you have registered successfully ')</script>";
			 }
			echo "done";
		}
		if($databaseConnection == 0){
			echo "<script>alert('Error Generated!')</script>";
		}
	}				
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Registration Page</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<h2 align="center">Free Online Registration</h2>
	<form action = "Registration.php" method="post">
		<table align="center">
			<tr>
				<td>Name</td>
				<td>
					<input type = "text" name = "userName"/>
				</td>
				<td>
					<?php
						
					?>
				</td>
			</tr>
			<tr>
				<td>Email:</td>
				<td>
					<input type = "text" name = "userEmail"/>
				</td>
				<td>
					<?php
					
					
					?>
				</td>
			</tr>
			<tr>
				<td>Input Password:</td>
				<td>
					<input type = "Password" name = "userPassword_textBox"/>
				</td>
				<td>
				</td>
			</tr>
			<tr>
				<td>Confirm PassWord:</td>
				<td>
					<input type = "Password" name = "user_ConfirmPassword"/>
				</td>
				<td></td>
			</tr>
			
			<tr>
				<td>Profession:</td>
				<td >
					<select name = "prof">
						<option >Student</option>
						<option >Doctor</option>
						<option >Engineer</option>
						<option >Faculty</option>
						<option >Business Person</option>
						<option >Other</option>	
					</select>
				</td>
				<td>
					<?php
							
					?>
				</td>
			</tr>
			<tr> 
				<td>Gender</td>
				<td>
					Male <input type="radio" name="gender" value = "male" checked="checked" /> 
					Female <input type="radio" name="gender" value = "female"/> 
				</td>
				<td>
					
				</td>
			</tr>
			<tr>
				<td>Permanent Addrss:</td>
				<td>
					<input type = "text" name = "user_Address"/>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Contact No :</td>
				<td>
					<input type = "text" name = "user_Contact"/>
				</td>
				<td>
					<?php
					


					?>

				</td>
			</tr>
			<tr>
				<td>Voter Id No:</td>
				<td>
					<input type = "text" name = "user_VoterId"/>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>Date of Birth</td>
				<td>
					  <table>
					  	<tr>
					  		<td>
					  			<input size = "3" type = "text" name = "day" placeholder="day" style="width:100px">
					  		</td>
					  		<td>
					  			<input size = "3" type = "text" name = "month" placeholder="month" style="width:100px">
					  		</td>
					  		<td>
					  			<input size = "3" type = "text" name = "year" placeholder="year" style='width:100px'>
					  		</td>
					  	</tr>
					  </table>       
				</td>
				<td>
					<?php
					
					?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="center">
					<input type = "submit" style="width:140px" value = "Register" name = "user_Registration_btn"/>
					
				</td>
				<td></td>
			</tr>			
		</table>
	</form>
</body>
</html>