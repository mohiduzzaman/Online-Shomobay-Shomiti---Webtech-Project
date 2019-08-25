<?php
	$userId = $_SESSION['primary_id'];
	$grpName;
	$holdStr;
	$databaseConnection = 1;
	if(isset($_POST['group_InfoButton']) && isset($_POST['group_Name'])){
		$gName = $_POST['group_Name'];
		if(empty($gName)){
			$databaseConnection = 0;
			echo "<script>alert('Group Name Cant be Empty')</script>";
		}
	}
	if(isset($_POST['CompanyType']) && isset($_POST['group_InfoButton'])){
		$cm = $_POST['CompanyType'];
		if(empty($cm)){
				$databaseConnection = 0;
			echo "<script>alert('CompanyType Cant be Empty')</script>";
		}
	}
	if(isset($_POST['group_InstuteName']) &&isset($_POST['group_InfoButton'])){
		$ins = $_POST['group_InstuteName'];
		if(empty($ins)){
				$databaseConnection = 0;
			echo "<script>alert('Instute Name Cant be Empty')</script>";
		}
	}
	if(isset($_POST['group_Limit']) &&isset($_POST['group_InfoButton'])){
		$ins = $_POST['group_Limit'];
		if(empty($ins)){
				$databaseConnection = 0;
			echo "<script>alert('Input your members limits')</script>";
		}
	}
	if(isset($_POST['creation_Date']) &&isset($_POST['group_InfoButton'])){
		$c_d = $_POST['creation_Date'];
		if(empty($c_d)){
				$databaseConnection = 0;
			echo "<script>alert('Must Use the Group Creation Date')</script>";
		}
	}
	if(isset($_POST['lottery_Date_text']) &&isset($_POST['group_InfoButton'])){
		$c_d = $_POST['lottery_Date_text'];
		if(empty($c_d)){
				$databaseConnection = 0;
			echo "<script>alert('insert Your Groups Frist Lottery Date!')</script>";
		}
	}
	if(isset($_POST['Fine_Amount']) &&isset($_POST['group_InfoButton'])){
		$e_d = $_POST['Fine_Amount'];
		if(empty($e_d)){
				$databaseConnection = 0;
			echo "<script>alert('Put a fine amount please')</script>";
		}
	}
	
	if(isset($_POST['ending_Date']) &&isset($_POST['group_InfoButton'])){
		$e_d = $_POST['ending_Date'];
		if(empty($e_d)){
				$databaseConnection = 0;
			echo "<script>alert('Must Use the Group Ending Date')</script>";
		}
	}
	if(isset($_POST['PresidentName']) &&isset($_POST['group_InfoButton'])){
		$Pres_Name = $_POST['PresidentName'];
		if(empty($Pres_Name)){
				$databaseConnection = 0;
			echo "<script>alert('Every Group has a President')</script>";
		}
	}
	if(isset($_POST['Vice_presidentName']) &&isset($_POST['group_InfoButton'])){
		$VPres_Name = $_POST['Vice_presidentName'];
		if(empty($VPres_Name)){
				$databaseConnection = 0;
			echo "<script>alert('Every Group has a Vice President')</script>";
		}
	}
	if(isset($_POST['num_of_Rounds']) &&isset($_POST['group_InfoButton'])){
		$n_o_r= $_POST['num_of_Rounds'];
		if(empty($n_o_r)){
			$databaseConnection = 0;
			echo "<script>alert('Basically the lottary round Depends on the members of a group / shomity')</script>";
		}
	}
	if(isset($_POST['Money_Amount']) &&isset($_POST['group_InfoButton'])){
		$chada= $_POST['Money_Amount'];
		if(empty($chada)){
			$databaseConnection = 0;
			echo "<script>alert('Chada cant be 0 balance ')</script>";
		}
	}
	if(isset($_POST['Group_Details']) &&isset($_POST['group_InfoButton'])){
		$rules= $_POST['Group_Details'];
		if(empty($rules)){
			$databaseConnection = 0;
			echo "<script>alert('Say some basic Rules to rule your group members !')</script>";
		}
	}
	if($databaseConnection == 1){
		if(isset($_POST['group_InfoButton'])){
			$grpName = $_POST['group_Name'];
				$cmpType = $_POST['CompanyType'];
				$inst = $_POST['group_InstuteName'];
				$lim  = $_POST['group_Limit'];
				$crD  = $_POST['creation_Date'];
				$endD = $_POST['ending_Date'];
				$pName = $_POST['PresidentName'];
				$vName = $_POST['Vice_presidentName'];
				$rounds =  $_POST['num_of_Rounds'];
				$moneyAmount = $_POST['Money_Amount'];
				$grpDetails = $_POST['Group_Details'];
				$famount = $_POST['Fine_Amount'];
				$fLt = $_POST['lottery_Date_text'];
				$hst;
				$con =mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
				// inserting elements of a members//
					$insert2r  = "insert into group_creation(user_Id,CompanyName,MemberLimits,CreationDate,EndingDate,AdminName,ViceAdmin,MoneyAmount,FineForLatefees,RulesAndRegulations,firstLotteryDate,GroupName)values('$userId','$inst','$lim','$crD','$endD','$pName','$vName','$moneyAmount','$famount','$grpDetails','$fLt','$grpName')";
					$result3r= mysqli_query($con,$insert2r);
					if($result3r)echo "<script>alert('all the values are inserted to group_creation')</script>";
					if(!$result3r)echo "<script>alert('dataBase is not connected!')</script>";
						// ------------------------

				
				$query1 = "select group_CreatorId from group_table where group_CreatorId = '$userId'";
				$result1 = $con->query($query1);
				if($result1->num_rows == 0){
					$con2 =mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
					$query2 = "insert into group_table(group_CreatorId)values('$userId')";
					$run2 = mysqli_query($con2,$query2);
					// now updating the value of the group
					$query3 = "update group_table set Group_Names = CONCAT(Group_Names,'/$grpName') where group_CreatorId = '$userId'";
					$res3= mysqli_query($con2,$query3);
					if($res3){
						echo "<script>alert('New Group Created')</script>";
					}
				}
				if($result1->num_rows == 1){
					 $check = true;$allGroup;
					  $conx =mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
					  $queryx  = "select Group_Names from group_table where group_CreatorId = '$userId'";
					  $runx = $conx->query($queryx);
					  if($runx->num_rows >0){
					  	while($row = $runx->fetch_assoc()){
					  		$allGroup = $row['Group_Names'];
					  	}
					  	$parts_group = explode('/', $allGroup);
					  	for($i = 0;$i<count($parts_group);$i++){
					  		if($parts_group[$i] == $grpName){
					  			$check = false;break;
					  		}
					  	}
					  	if($check == true){
					  		$conUpdate = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
					  		$updateQry = "update group_table set Group_Names = CONCAT(Group_Names,'/$grpName') where group_CreatorId = '$userId'";
					  		$resQ = mysqli_query($conUpdate,$updateQry);
					  		if($resQ){
					  			echo "<script>alert('New Group Created ')</script>";
					  		}
					  	}
					  	if($check == false){
					  		echo "<script>alert('already used this name for group ')</script>";
					  	}
					  }					
				}
		}
	}
?>