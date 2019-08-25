<?php
 	session_start();
 	$friendList;
 	if($_SESSION["sid"]==""&&$_SESSION["semail"]=="")
 	{
 		$searcher_id=$_GET['id'];
 		$searcher_email=$_GET["email"];
 		$_SESSION["sid"]=$searcher_id;
 		$_SESSION["semail"]=$searcher_email;
 	}
 	else
 	{
 		$searcher_id=$_SESSION["sid"];
 		$searcher_email=$_SESSION["semail"];
 	}
 	if(!empty($_SESSION["semail"])){
 			$semail=$_SESSION["semail"];
 			$userId = $_SESSION['primary_id'];
	 		$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
		 	$query1 = "select primaryId,profilePic from user_registration_table where userEmail = '$semail'";
		 	$picstatus;
			$result1 = $con->query($query1);
			if($result1->num_rows >0){
				while($row = $result1->fetch_assoc()){
					$searcher_id = $row["primaryId"];
					$picstatus=$row["profilePic"];
				}
			}
			$query2 = "select * from friends_table where user_id = '$userId'";
			$result2 = $con->query($query2);
			if($result2->num_rows == 0){
				$query3 = "insert into friends_table(user_id)values('$userId')";
				$result3 = mysqli_query($con,$query3);
			}
			if($result2->num_rows>0){
 					$friendList;
				$query4 = "select * from friends_table where user_id = '$userId'";
				$result4 = $con->query($query4);
				if($result4->num_rows>0){
					while($row = $result4->fetch_assoc()){
						$friendList = $row['friend_list'];
					}
				}
				$parts_friendList = explode('/', $friendList);
				//print_r($parts_friendList);
				$isFriend = false;
				for($i = 0;$i<count($parts_friendList);$i++){
					if((int)$parts_friendList[$i] == (int)$_SESSION['sid']){
						$isFriend = true;
						break;
					}
				}
				$_SESSION['frndSts'] = $isFriend;
			}
	}
 //	echo $searcher_id;
 //	echo $searcher_email;
?>
<?php
		$userId = $_SESSION['primary_id'];
		if(isset($_POST['request_btn'])){
				$query2 = "update friends_table set friend_list = CONCAT(friend_list,'/$searcher_id') where user_id = '$userId'";
				$result2 = mysqli_query($con,$query2);
				if($result2){
					echo "<script>alert('Friends Done!')</script>";
				}
	}
?>
<?php 
// here we will add the group members 
$userId = $_SESSION['primary_id'];
$groupMembers;
$searcher_id = $_SESSION["sid"];
if(isset($_POST['add_toAGroupBtn']) && isset($_POST['shomitysNameSelector'])){
	$searcher_id = $_SESSION['sid'];
	$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
	$groupName = $_POST['shomitysNameSelector'];
	$query1 = "select  user_Id,Group_Name from groupwiseallfriends where user_Id = '$userId' and Group_Name = '$groupName'";
	$result1 = $con->query($query1);
	if($result1->num_rows == 0){
		$insert2 = "insert into groupwiseallfriends(user_Id,Group_Name)values('$userId','$groupName')";
		$run2 = mysqli_query($con,$insert2);
		$query3 = "update groupwiseallfriends  set GroupFriendsList = CONCAT(GroupFriendsList
				,'/$searcher_id') where user_Id = '$userId' and Group_Name = '$groupName'";
		$run3 = mysqli_query($con,$query3);
		if($run3){
			echo "<script>alert(' added to $groupName')</script>";
		}
	}
	if($result1->num_rows > 0){
		$searcher_id = $_SESSION['sid'];
		$query4 = "select GroupFriendsList from groupwiseallfriends where user_Id = '$userId' and Group_Name = '$groupName'";
		$run4 = $con->query($query4);
		if($run4->num_rows >0){
			while($row = $run4->fetch_assoc()){
				$groupMembers = $row['GroupFriendsList'];
			}
			$parts_groupMembers = explode('/', $groupMembers);
			$check = true;
			for($i = 0;$i<count($parts_groupMembers);$i++){
				if((int)$parts_groupMembers[$i] == (int)$_SESSION['sid']){
					$check = false;break;
				}
			}
			if($check == false){
				echo "<script>alert('This person is already added to $groupName group')</script>";
			}
			if($check == true){
				$queryE = "update groupwiseallfriends  set GroupFriendsList = CONCAT(GroupFriendsList
				,'/$searcher_id') where user_Id = '$userId' and Group_Name = '$groupName'";
				$runE = mysqli_query($con,$queryE);
				if($runE){
					echo "<script>alert('Added To your group , $groupName ')</script>";
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Search SomeOne</title>
	<style >
		select {
				  width: 250px;
				}
				option {
				  width: 250px;
				}
		}
		ul li{
			display: inline;
			padding :30px;
		}
	</style>
	<?php
		include_once("navbar1.php");
	?>
</head>
<body>
	<form action="searchpeople.php" method="POST">
			
		<table  align="center"   height = "700px" width="1200px">
			<tr>
				<td>
					<table>
						<tr>
							<td>
								Name :
							</td>
							<td>
								<?php
									$Name;
									$searcher_email = $_SESSION["semail"];
									$userId = $_SESSION['primary_id'];
									$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
									$query = "select userName from user_registration_table where userEmail = '$searcher_email'";
									$result = $con->query($query);
									if($result->num_rows >0){
										while($row = $result->fetch_assoc()){
											$Name = $row["userName"];
										
										}
									}
									echo $Name;
								?>
							</td>
						</tr>
						<tr>
							<td>Email :</td>
							<td>
								<?php
									$Email;
									echo $_SESSION["semail"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Friend Status :
							</td>
							<td>
								<?php
									$fsts = $_SESSION['frndSts'];
									if(!$fsts){
										echo "Not Friends<br/>";
										echo "<input type ='submit' value='Send Him A friend Request' name = 'request_btn'/>";
									}
									else echo "Friends to Friends Eachother";
								?>
							</td>
						</tr>
						<tr>
							<td>
								user Reg Id :
							</td>
							<td>
								<?php
									echo  $_SESSION["sid"];
								?>
							</td>
						</tr>
						<tr>
							<td>
								Group Lists :
							</td>
							<td> under construction</td>
						</tr>
						<tr>
							<td>
								Total Balance :
							</td>
							<td>updated Later</td>
						</tr>
						<tr>
							<td colspan="2">
								<b><i>Select A Group To Add :</i></b><br/>
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
									</select><br/>
									<input type = "submit" name = "add_toAGroupBtn" value="Add To Group"/>
							</td>
						</tr>
					</table>
				</td>
				<td valign="top">
					<?php
					$src;
						if($picstatus=="1")
						{
							$src="../uploads/profile".$searcher_id.".jpg";
							$filetime=filemtime($src);
							$src=$src."?".$filetime;
						}
						else
						{
							$src="../uploads/default.png";
						}
					?>

					<img align="right" height ="300px" width="350px" src = "<?php echo $src;?>" alt="Profile Picture" style="border-radius: 50%"/>
				</td>
			</tr>
						
		</table>

	</form>
</body>
</html>