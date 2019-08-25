<?php
	session_start();
	$userId = $_SESSION['primary_id'];
	$databaseConnection = true;
	if( isset($_POST['shomitysNameSelector']) && isset($_POST['Payment_password']) && isset($_POST['Payment_textBox'])){
		$groupName = $_POST['shomitysNameSelector'];
		if(empty($groupName)){
			$databaseConnection = false;
			echo "<script>alert('Group Name Must be Selected')</script>";
		}
		$payment = $_POST['Payment_textBox'];
		if(empty($payment)){
			$databaseConnection = false;
			echo "<script>alert('Payment cannot be empty put a Money Amount')</script>";
		}
		$password = $_POST['Payment_password'];
		if(empty($password)){
			$databaseConnection = false;
			echo "<script>alert('Must Input Password for varification...!')</script>";
		}
	}
	if($databaseConnection == true){
		if(isset($_POST['submit_payment_btn'])){
			$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
			$query  = "update groupwiseallfriends set whoPaid = CONCAT(whoPaid,'/$userId'), moneyAmount = CONCAT(moneyAmount,'/$payment') where user_id = '$userId' and Group_Name = '$groupName'";
			$result = mysqli_query($con,$query);
			if($result){
				echo "<script>alert('Payment is submitted successfully to $groupName')</script>";
			}
			else echo "<script>alert('Database is not connected !')</script>";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<style>
		select {width: 250px;}
		option {width: 250px;}
	</style>
	<meta charset="UTF-8">
	<?php
		include_once("navbar.php");
	?>
	<title>Online Payment</title>
</head>
<body>
	<form action = "onlinePayment.php" method ="post">
		<table align="center" >
			<tr>
				<td>
					<h2>Select Group :</h2>
					<select name = "shomitysNameSelector">
										<?php
											$shomitys;$count_rows;
											$userId = $_SESSION['primary_id'];
											$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
											$query = "select Group_Names from group_table where group_CreatorId ='$userId'";
											$result = $con->query($query);
											if($result->num_rows >0){
												while($row = $result->fetch_assoc()){
													$shomitys = $row["Group_Names"];
												}
												$parts_shomityName = explode('/', $shomitys);
												for($i = 0;$i<count($parts_shomityName);$i++){
													echo "<option>".$parts_shomityName[$i]."</option>";
												}
											}
										?>
									</select>
				</td>
			</tr>
			<tr>
				<td align="center">
					<b>Online Payment</b>
				</td>
			
			</tr>
			
			<tr>
				<td>
					<input type = "text" size = '35px' name = "Payment_textBox" placeholder="Pay here amount Bangladeshi (taka)*"/>
				</td>
			</tr>
			<tr>
				<td>
					<input type = "password" size = '35px' name = "Payment_password" placeholder="Input your password"/>
				</td>
			</tr>
			<tr>
				<td align="right">
					<input type = "submit" name = "submit_payment_btn" value = "Send"/>
				</td>
			</tr>
		</table>

	</form>
</body>
</html>