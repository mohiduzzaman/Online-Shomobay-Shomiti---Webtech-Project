<?php
session_start();
$_SESSION["searcher_email"] = "";
	$isProcced = false;
	$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
	if(isset($_POST['cb'])){
	$cx = $_POST['cb'];
	$isProcced = true;
	foreach ($cx as $id) {
		mysqli_query($con,"delete from complaneandsuggations where id =".$id);
		}
	}
	if($isProcced == true){
		echo "<script>alert('Selected Comments are deleted !')</script>";
	}
	mysqli_close($con);
?>
<?php
	if(isset($_POST['mail_text'])){
		$_SESSION['searcher_email'] = $_POST['mail_text'];
	}
?>
<?php
	if(isset($_POST['update_btn']) && isset($_POST['UserName']) && isset($_POST['cnt_txt']) && isset($_POST['brtDay_txt']) && isset($_POST['prof_text'])){
		$name = $_POST['UserName'];
		$contact = $_POST['cnt_txt'];
		$birthday  = $_POST['brtDay_txt'];
		$pro = $_POST['prof_text'];
		$email = $_SESSION['searcher_email'];
		echo "user email is : ".$_SESSION['searcher_email'];
		$prof = $_POST['prof_text'];
		$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
		$query = "update user_registration_table set Contact_No = '$contact' ,userName = '$name',DateOfBirth = '$birthday', Profession = '$pro' where userEmail = '$email'";
		$result = mysqli_query($con,$query);
		if($result){
			echo "<script>alert('value is updated !')</script>";
		}
		else{echo "<script>alert('Database is not connected ..  !')</script>"; }
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SystemManager</title>
	<style>
		table, td{
			padding:5px;
		}

	</style>
	<script>

		function clicked()
		{
		   
		    let name=document.getElementById("mail_text").value;
		    let xhttp=new XMLHttpRequest();
		    console.log(name);
		    let result=document.getElementById("result");
		    if(name!=""){
		    xhttp.onreadystatechange = function() {
		        if (this.readyState == 4 && this.status == 200) {
		            
		            //console.log(this.responseText);
		            result.style.height="60px";
		            result.style.margin="10px";
		        	result.style.padding="10px";
		            result.innerHTML=render_data(JSON.parse(this.responseText));
		        }
		    };
		    xhttp.open("GET", `getuser.php?e=${name}`, true);
		    xhttp.send();
		    }

		    else
		    {
		        result.style.height="0%";
		        result.style.margin="0px";
		        result.style.padding="0px";
		        result.innerHTML="";

				let un=document.getElementById("uname");
				let e=document.getElementById("cnumber");
				let d=document.getElementById("dob");
				let p=document.getElementById("profession");

				un.value="";
				e.value="";
				p.value="";
				d.value="";

		    }
		}

		function render_data(data)
		{
			/*"userName"=> $row["userName"],"userEmail"=>$row["userEmail"],
                        "Contact_No"=>$row["Contact_No"],"Profession"=>$row["Profession"]*/
			 let html="";
			    for(let i=0;i<data.length;i++)
			    {
			        html+=`<div class="res" align="left" onclick='data_get("${data[i].userName}","${data[i].Contact_No}","${data[i].Profession}","${data[i].dob}")'>`;
			        html+=`Name: ${data[i].userName} ------ Email:${data[i].userEmail}<br>`;
			        html+="</div>";
			    }
			    return html;
		}

		function data_get(name,num,pro,dob)
		{
			let un=document.getElementById("uname");
			let e=document.getElementById("cnumber");
			let d=document.getElementById("dob");
			let p=document.getElementById("profession");

			un.value=name;
			e.value=num;
			p.value=pro;
			d.value=dob;

		}

	</script>
	<?php
		include_once("navbar.php");
	?>
</head>
<body>
	<form action = "SystemManager.php" method = "post">
		
	<table  height = "700px" widht = "1200px">
		<tr>
			<td colspan="3">
				<h2>
					User Registration Information
				</h2>
			</td>
			
		</tr>
		<tr>
			<td align="center" colspan="3">
				<table cellspacing="0" border = "1px">
				<?php
				
					$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
					$query = "SELECT * FROM user_registration_table";
					$result = mysqli_query($con,$query);
					while($row = mysqli_fetch_array($result)){
						echo '<tr>';
						 echo '<td>'.$row['primaryId'].'</td>'.'<td>'.$row['userName'].'</td>'.'<td>'.$row['userEmail'].'</td>'.'<td>'.$row['Password'].'</td>'.'<td>'.$row['Profession'].'</td>'.'<td>'.$row['Gender'].'</td>'.'<td>'.$row['Permanent_Address'].'</td>'.'<td>'.$row['Contact_No'].'</td>'.'<td>'.$row['Voter_ID'].'</td>'.'<td>'.$row['DateOfBirth'].'</td>'.'<td>'.$row['FriendList'].'</td>'.'<td>'.$row['ConfirmPassword'].'</td>';
						echo '</tr>';
					}
				?>
			</table>
			</td>
		
		</tr>
		<tr>
			<td colspan="3" align="center">
				<h2>
					 Update client  Information
				</h2>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<div align="center">
					<b>Search By Email:</b><br/>
					<input type="text" id="mail_text" size="30" name = "mail_text" placeholder="Email@gmail.com" onkeyup="clicked()">
					<br/>
					<div id="result" style="overflow: auto;width:450px">
					</div>
				</div>
				
				<table align="center" cellspacing="0px" border = "1px">
					<tr>
						<td>
							

							<input type = "text" size = 30 id = "uname" name = "UserName" placeholder="user Name "/>
						</td>
					</tr>
					<tr>
						<td>
							
							<input type = "text" size = 30 id = "cnumber" name = "cnt_txt" placeholder="Contact No ... "/>
						</td>
					</tr>
					<tr>
						<td>
							
							<input type = "text" size = 30 id= "dob" name = "brtDay_txt" placeholder="Birth Date "/>
						</td>
					</tr>
					<tr>
						<td>
							
							<input type = "text" size = 30 id = "profession" name = "prof_text" placeholder="Profession  ... "/>
						</td>
					</tr>
					<tr>
						<td align="right">
							<input type = "submit" value = "Update" name = "update_btn"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<h2> Client Request For updating Information :</h2>
						<?php
						$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
							$query = "SELECT * FROM complaneandsuggations";
							$result = mysqli_query($con,$query);
							if($result->num_rows == 0){
								echo "<h1>No Request For update From Client </h1>";
							}
							if($result->num_rows > 0){
								echo "<table border = '1px'>";
								echo '<tr>';
											echo '<td>';
													echo "Id";
											 echo '</td>';
											 echo '<td>';
													echo "UserEmail";
											 echo '</td>';
											 echo '<td>';
													echo "Request For update info : ";
											 echo '</td>';
											 echo '<td>';
													echo "Select Option";
											 echo '</td>';
										echo '</tr>';
										
									while($row = mysqli_fetch_array($result)){
										echo '<tr>';
											echo '<td>'.$row['id'].'</td>'.'<td>'.$row['userEmail'].'</td>'.'<td>'.$row['CS'].'</td>';
											echo "<td><input type = 'checkbox' name = 'cb[]' value = '".$row['id']."'>";
											echo "</td>";
										echo '</tr>';
								}
								echo "<tr>";
											echo "<td>";
											echo "</td>";
											echo "<td>";
											echo "</td>";
											echo "<td>";
											echo "</td>";
											echo "<td>";
												echo "<input type = 'submit' value = 'Delete' name = 'Delete'/>";
											echo "</td>";
										echo "</tr>";
								echo "</table>";
							}
							
						?>		
			</td>
		</tr>
	</table>
	</form>
</body>
</html>
