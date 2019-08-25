<?php 
	session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		include_once("navbar.php");
	?>
	<meta charset="UTF-8">
	<title>My Friends</title>
	
</head>
<body>
	<form action = "Friends.php" method="post">
		<table cellspacing="0px" border = "1px" height = "700px" width="1000px" align="center" border = "1px">
			<tr>
				<td >
					<h2>My Friends List :</h2>
				</td>
				<td align="center">
					<?php
					$hst;
					$parts_Friends;
						$userId = $_SESSION['primary_id'];
							$con  = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
							$query = "select friend_list from friends_table where user_id= '$userId'";
							$result = $con->query($query);
							if($result->num_rows >0){
								while($row = $result->fetch_assoc()){
									$hst =  $row["friend_list"];
								}
								//print_r($hst);

								for($i = 0;$i<count($hst);$i++){
									$parts_Friends = explode('/', $hst);
								}
							}
							if($result->num_rows == 0){
									echo "<h2>You Havent made any friend Yet</h2>";
								}

							// showing all friends information from user_registration_table
							else{
									for($i = 0;$i<count($parts_Friends);$i++){
										$ids = $parts_Friends[$i];
									$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
									$query = "select userName from user_registration_table where primaryId = '$ids'";
									$result = $con->query($query);
									while($row = $result->fetch_assoc()){
										echo "<b>".$row['userName']."</b>"."<br/>";
									}
								}
							}
					?>
				</td>
			</tr>
		</table>
		<h2 align="center">Group Wise All friends and Members List :</h2>
		<table cellspacing="0px" border = "1px" height = "700px" width="1000px" align="center" >
			<?php
			$groupList;$groupNames;
				$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
				 $shomitys;$count_rows;
				$userId = $_SESSION['primary_id'];
				$queryD = "select Group_Names from group_table where group_CreatorId ='$userId'";
				$resultD = $con->query($queryD);
				if($resultD->num_rows >0){
					while($row = $resultD->fetch_assoc()){
						$shomitys = $row["Group_Names"];
					}
					$groupNames = explode('/', $shomitys);
					$user_id = $_SESSION['primary_id'];
				 for($i = 0;$i<count($groupNames);$i++){
				 	$perGroup = $groupNames[$i];
				 	echo "<tr>";
				 		echo "<td>";
				 			echo "<b>".$perGroup."</b>";
				 		echo "</td>";
				 		echo "<td>";
				 			$query = "select GroupFriendsList from groupwiseallfriends where user_Id = '$user_id' and Group_Name = '$perGroup'";
				 			$result = $con->query($query);
				 			if($result->num_rows >0){
				 				while($row = $result->fetch_assoc()){
				 					$groupList = $row['GroupFriendsList'];
				 				}
				 				$parts_groupList = explode('/', $groupList);
				 				for($j = 0;$j<count($parts_groupList);$j++){
				 					$groupMember = $parts_groupList[$j];
				 					$query2 = "select userName from user_registration_table where primaryId = '$groupMember'";
				 					$result2 = $con->query($query2);
				 					if($result2->num_rows >0){
				 						while($row = $result2->fetch_assoc()){
				 							echo "<b>".$row['userName']."</b>"."<br/>";
				 						}
				 					}
				 				}
				 			}
				 		echo "</td>";		
				 	echo "</tr>";
				 }
				}
				else echo "<h2>No Friends Yet</h2>";
				//--------------
				 
			?>
		</table>
	</form>
</body>
</html>