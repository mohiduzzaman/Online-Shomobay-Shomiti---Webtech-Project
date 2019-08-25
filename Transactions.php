<?php
	session_start();
	$_SESSION['gml'] = "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Transaction</title>
	<?php
		include_once("navbar.php");
	?>
	<style type="text/css">
		td{
			text-align: center;
		}
	</style>
</head>
<body>
	<form action="Transactions.php" method="post">
		<table height = "700px" width="1200px" border = "1px">
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
					// getting data from group_creation for the details information of a group
							echo "<tr>";
								echo "<td>";
								$gN = $parts_shomityName[$i];
								$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
								$query = "select * from group_creation where GroupName = '$gN'";
								$result = mysqli_query($con,$query);
								while($row = mysqli_fetch_array($result)){
									$companyName = $row['CompanyName'];
									$round  = $row['MemberLimits'];
									$openDate = $row['CreationDate'];
									$closeDate = $row['EndingDate'];
									$memberLimit = $row['MemberLimits'];
									$chada = $row['MoneyAmount'];
									$fine = $row['FineForLatefees'];
									$admin = $row['AdminName'];
									$co_admin = $row['ViceAdmin'];
								}
									echo "<b><i> Shomity Name : ".$parts_shomityName[$i]."</i></b><br/>";
									echo "Company Name :".$companyName."<br/>";
									echo "Admin Name : ".$admin."<br/>";
									echo "Co-admin Name : ".$co_admin."<br/>";
									echo "Shomity Opening Date :".$openDate."<br/>";
									echo "Shomity Closing Date :".$closeDate."<br/>";
									echo "Maximum Members  : ".$memberLimit."<br/>";
									//echo "Total Rounds  : ".."<br/>";
									echo "Chada Amount :".$chada."<br/>";
									echo "Late Fees Panalty : ".$fine."<br/>";
								echo "</td>";
								// getting group members activity ...
								// user Primary Id:
								echo "<td>";
									$friendsList;
									$query2 = "select GroupFriendsList from groupwiseallfriends where user_Id = '$userId'";
									$result2 = $con->query($query2);
									if($result2->num_rows >0){
										while($row = $result2->fetch_assoc()){
											$friendsList = $row['GroupFriendsList'];
										}
										$parts_friendsList = explode('/', $friendsList);
										$_SESSION['gml'] = $parts_friendsList;
										for($n = 0;$n<count($parts_friendsList);$n++){
											echo "<div>".$parts_friendsList[$n]."<div/>";
										}
									}

								echo "</td>";

								// user Name :
								echo "<td>";
								$parts_friendsList = $_SESSION['gml'];
									for($n = 0;$n<count($parts_friendsList);$n++){
										$pid = $parts_friendsList[$n];
										$query4 = "select userName from user_registration_table where primaryId = '$pid'";
										$result4 = $con->query($query4);
										if($result4->num_rows > 0){
											while($row = $result4->fetch_assoc()){
												echo "<div>".$row['userName']."</div>";
											}
										}
									}

								echo"</td>";
								//getting user Email form user_registration_table


								echo "<td>";
									$parts_friendsList = $_SESSION['gml'];
									for($n = 0;$n<count($parts_friendsList);$n++){
										$pid = $parts_friendsList[$n];
										$query4 = "select userEmail from user_registration_table where primaryId = '$pid'";
										$result4 = $con->query($query4);
										if($result4->num_rows > 0){
											while($row = $result4->fetch_assoc()){
												echo "<div>".$row['userEmail']."</div>";
											}
										}
									}
								echo"</td>";
								// getting usre contact no form user_registration_table
								echo "<td>";
										$parts_friendsList = $_SESSION['gml'];
										for($n = 0;$n<count($parts_friendsList);$n++){
										$pid = $parts_friendsList[$n];
										$query4 = "select Contact_No from user_registration_table where primaryId = '$pid'";
										$result4 = $con->query($query4);
										if($result4->num_rows > 0){
											while($row = $result4->fetch_assoc()){
												echo "<div>".$row['Contact_No']."</div>";
											}
										}
									}
								echo"</td>";
								// user address
								echo "<td>";
									$parts_friendsList = $_SESSION['gml'];
									for($n = 0;$n<count($parts_friendsList);$n++){
										$pid = $parts_friendsList[$n];
										$query4 = "select 	Permanent_Address from user_registration_table where primaryId = '$pid'";
										$result4 = $con->query($query4);
										if($result4->num_rows > 0){
											while($row = $result4->fetch_assoc()){
												echo "<div>".$row['Permanent_Address']."</div>";
											}
										}
									}
								echo"</td>";
								// a user is winner or not !  from groupwiseallfriends .......... table
								echo "<td>";
								$winnersList = array();
									// query for the winners 
								$query5 = "select WinnersList from groupwiseallfriends where user_Id  = '$userId' and Group_Name = '$gN'";
								$result5 = $con->query($query5);
								$isWinner = false;
								if($result5->num_rows > 0 ){
									while($row = $result5->fetch_assoc()){
										$winnersList = $row['WinnersList'];
									}
										$parts_winners = explode('/', $winnersList);
										print_r($parts_winners);
										for($x = 0;$x<count($parts_friendsList)-1;$x++){
											$pid = $parts_friendsList[$x];
											$isWinner = false;
											for($u = 0;$u<count($parts_winners);$u++){
												if((int)$parts_winners[$u] ==(int)$pid){
													$isWinner = true;break;
												}
											}
											if($isWinner == true)echo "<div>Winner</div>";
											else echo "<div> Not Winner</div>";
										}
										

								}
								else {echo "<div>No Friends Yet</div>";}
								echo"</td>";
								// money Payment status ..and balance 
								echo "<td>";
									$moneySenderList;$amountList;
									$query = "select * from groupwiseallfriends where user_Id = '$userId' and Group_Name = '$gN'";
									$result = mysqli_query($con,$query);
									if($result->num_rows >0){
										while($row = mysqli_fetch_array($result)){
											$moneySenderList = $row['whoPaid'];
											$amountList      = $row['moneyAmount'];
										}
										//print_r($moneySenderList);echo "<br/>";
										//print_r($amountList);
										$parts_sender = explode('/',$moneySenderList);
										$parts_amount = explode('/', $amountList);
										for($x = 0;$x<count($parts_sender);$x++){
											$pd = $parts_sender[$x];
											$query = "select userName from user_registration_table where primaryId = '$pd'";
											$result = $con->query($query);
											while($row = $result->fetch_assoc()){
												echo "<div>".$row['userName']."  amount = ".$parts_amount[$x]." Taka/="."</div>";
											}
										}
										
									}
									else{
										echo "<div>Payment Process is not activated</div>";
									}
								echo"</td>";
								echo "<td>Fine Status</td>";
							echo "</tr>";
						}
				
		

			}
		
		?>
	</table>
	</form>
</body>
</html>
