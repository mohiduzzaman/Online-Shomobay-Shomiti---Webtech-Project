<?php session_start();
	$_SESSION["eD"] = "";
	$_SESSION['winner_Id'] = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
		include_once("navbar.php");
	?>
	<title>Lottery</title>
		<style>
	
		select {width: 250px;}
		option {width: 250px;}
	</style>
</head>
<body>	
	<form action = "Lotttry.php" method = "post">
	
	<?php
		echo "<h2>Today's Date :</h2>"."<b>".date("d/m/Y")."</b>";
	?>
	<div align="center">
		<h2>
			Lottery<br/>
			Time Schedule<br/>
		</h2>
		<h2>Insert Group Lottery Date : </h2>
		<b>Group Name :</b>
		<table>
			<tr>
				<td>
					<select name = "shomitysNameSelector">
										<?php
											$shomitys;$count_rows;
											$userId = $_SESSION['primary_id'];
											$groupName = $_POST['shomitysNameSelector'];
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
											if($result->num_rows == 0){

												//echo "<script>alert('You have to make atleaset 1 friend to make a lottery date!')</script>";
											}

												
												
											
										?>
									</select><br/>
									<input size = "30" type = "text" name = "date_text" placeholder = "Insert a valid date.."/>
									
				</td>
			</tr>
			<tr>
				<td>
					<input  type = "submit" name = "selector_btn"/><br/>		
				</td>
			</tr>
			<tr>
				
			</tr>
		</table>
	</div>
	<div align="center">
		<h2 >Lottery Winner and Time</h2>
		<b> Select Group Name  :</b>
		<table>
			<tr>
				<td>
					<select name = "shomitysNameSelector_2">
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
				</td>
			</tr>
			<tr>
				<td>
					<input  type = "submit" value = "view" name = "selector_btn2"/><br/>		
				</td>
			</tr>
			<tr>
				
			</tr>
		</table>
	</div>
	<div align="center">
		<table>
			<tr>
				<td>
						<?php
						$groupName;
							$userId = $_SESSION['primary_id'];$eventDate;
							if(isset($_POST['shomitysNameSelector_2']) && isset($_POST['selector_btn2'])){
								$groupName = $_POST['shomitysNameSelector_2'];
								$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
								$query = "select Group_LotteryDate from groupwiseallfriends where Group_Name = '$groupName' and user_Id = '$userId'";
								$_SESSION['_selector_forLottery'] = $groupName;
								$result = $con->query($query);
								if($result->num_rows >0){
									while($row = $result->fetch_assoc()){
										$eventDate = $row["Group_LotteryDate"];
									}
									$_SESSION["eD"] = $eventDate;
								}
								if($result->num_rows == 0){
									$_SESSION["eD"] = "No Date Is Selected";
								}
							}
							 $eventDate =  $_SESSION["eD"];
							 $nowDate = date("d/m/Y");
							 if($eventDate == $nowDate){
							 	echo "<input type = 'submit' value = 'Hit The Button For Lottery' name = 'Lottery_button'/>";
							 	
							 }
							 else{
							 		echo $eventDate;
							 }
						?>
				</td>
			</tr>
		</table>
	</div>
	<div align="center">
		<table>
			<tr>
				<td>
				  <?php
				  $winnerId = "";
					if(isset($_POST['Lottery_button'])){
							$groupName =  $_SESSION['_selector_forLottery'];
							$userId = $_SESSION['primary_id'];
							// this array will parts all the winners list from the database and it will check wheater the the lucky guy is inside this array or not !!
							$parts_winnerList;
							$con_r = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
							$query_r = "select WinnersList from groupwiseallfriends where user_Id = '$userId' and Group_Name = '$groupName'";
							$result_r = $con->query($query_r);
							if($result_r->num_rows > 0){
								while($row = $result_r->fetch_assoc()){
									$holdWinnsersList = $row["WinnersList"];
								}
								$parts_winnerList = explode('/', $holdWinnsersList);
							}
						//----------------------------------------------------------
						
							$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
							$query = "select GroupFriendsList from groupwiseallfriends where user_Id = '$userId' and Group_Name = '$groupName'";
							$result = $con->query($query);
							if($result->num_rows >0){
								while($row = $result->fetch_assoc()){
									$grpList = $row["GroupFriendsList"];
								}
								$Parts_grpList = explode('/', $grpList);
								//for($i = 0;$i<count($Parts_grpList);$i++){
								//	echo $Parts_grpList[$i]."<br/>";
								//}
								// here we will check all the members from the group who are not winners and from them the new lucky man will be the new  winner !
								echo "Winners List Id : " ;print_r($parts_winnerList); echo "<br/>";
								echo "Total group members Id : ";print_r($Parts_grpList);echo "<br/>";
								$isWinner;
								$incriment = 0;
								$membersTo_lotter=array();
								for($i = 0;$i<count($Parts_grpList);$i++){
									$isWinner = false;
									for($j = 0;$j<count($parts_winnerList);$j++){
										if((int)$Parts_grpList[$i] == (int)$parts_winnerList[$j]){
											$isWinner =  true;break;
										}
									}
									if($isWinner == false){
										$membersTo_lotter[$incriment] = $Parts_grpList[$i];
										$incriment++;
									}
								}
								// here we have shuffeled the moderated array and find the first result ... !
							
								if(empty($membersTo_lotter)){
									echo "<h2>Groups Lottery Round Is Over !! / Or your Friends are not Equeals to the number of rounds</h2>";
								}
								if(!empty($membersTo_lotter))
								{
										shuffle($membersTo_lotter);
									$winnerId = $membersTo_lotter[0];
									$_SESSION['winner_Id'] = $winnerId;
									echo "<h1>Todays Lucky Guy Is :  [".$winnerId."]</h1>";
										// for finding userName form user registration table ..
									$winnerName;
									$queryl = "select userName from user_registration_table where primaryId = '$winnerId'";
									$resultl = $con->query($queryl);
									if($resultl->num_rows > 0 ){
										while($row = $resultl->fetch_assoc()){
											$winnerName = $row["userName"];
										}
										echo "<h1> Winner Name :[".$winnerName."]</h1>";
									}
									// for finding the user Email and contact ----
									$winnerEmail; 
									$querylx = "select userEmail from user_registration_table where primaryId = '$winnerId'";
									$resultlx = $con->query($querylx);
									if($resultlx->num_rows > 0 ){
										while($row = $resultlx->fetch_assoc()){
											$winnerEmail = $row["userEmail"];
										}
										echo "<h1> Winner Email :[".$winnerEmail."]</h1>";
									}
									// here we will insert the winners to the group and show the indivudial lists .....!! 
									$cont = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
									 $queryt = "update groupwiseallfriends set WinnersList = CONCAT(WinnersList,'/$winnerId') where user_id = '$userId' and Group_Name = '$groupName'";
									 $resultt = mysqli_query($cont,$queryt);
									 if($resultt){
									 	echo "Winner Id = ".$winnerId. " is saved to the database";
									 }
									if($result->num_rows == 0){
										echo "You Havent made any Friend Yet !!";
									}
								}
								
								
						}
					}
				 ?>
				</td>
			</tr>
		</table>
	</div>
</body>
</form>
</html>
<?php
// updating all the groups date for the lottery !!!!!!
	if(isset($_POST['date_text'])  && isset($_POST['selector_btn']) && isset($_POST['shomitysNameSelector'])){
		$userId = $_SESSION['primary_id'];
		$eventDate =$_POST['date_text'];
		$groupName = $_POST['shomitysNameSelector'];
		$con =  mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
		$query = "update groupwiseallfriends set Group_LotteryDate = '$eventDate' where user_Id = '$userId' and Group_Name = '$groupName'";
		$result = mysqli_query($con,$query);
		if($result){
			echo "<script>alert('Date is saved for $groupName')</script>";
		}
		
	}	
?>
<?php
	 // here we insert  all the winners  form individual groups .....and show the lists chart !
	 /*if(isset($_POST['Lottery_button'])){
	 	
			 $winnerId =  $_SESSION['winner_Id'];
			 if($winnerId != ""){
					 	$groupName = $_SESSION['_selector_forLottery'];
					 $con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
					 $query = $query2 = "update friends_table set WinnersList = CONCAT(WinnersList,'/$winnerId') where user_id = '$userId' and Group_Name = '$groupName'";
					 $result = mysqli_query($con,$query);
					 if($result){
					 	echo "Winner Id = ".$winnerId. " is saved to the database see the whole transaction list group wise !! ";
					 }
			 }
			 
		
	 }*/

?>