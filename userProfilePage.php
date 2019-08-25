

<?php
session_start();
$_SESSION["sid"]="";
$_SESSION["semail"]="";
$_SESSION["picstatus"]="";
	$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
	$u_mail = $_SESSION['ue'];
	if($con->connect_error){
		die("Error Connection");
	}
	$query = "SELECT primaryId From user_registration_table WHERE userEmail ='$u_mail'";
	$result = $con->query($query);
	if($result->num_rows >0){
		while($row = $result->fetch_assoc()){
			$pid = $row['primaryId'];
			$_SESSION['primary_id'] = $pid;
		}
	}

	$query="SELECT profilePic From user_registration_table WHERE userEmail ='$u_mail'";
	$result = $con->query($query);
	if($result->num_rows >0){
		while($row = $result->fetch_assoc()){
			$_SESSION["picstatus"]= $row['profilePic'];
		}
	}

	///code for uploading picture
	$id=$_SESSION["primary_id"];

	if(isset($_POST["pic_submit"]))
	{
		$file=$_FILES['file'];
        $filename=$file['name'];
        $filetmpname=$file['tmp_name'];
        $filesize=$file['size'];
        $fileerror=$file["error"];
        $filetype=$file["type"];

        $fileExt=explode(".",$filename);
        $fileactext=strtolower(end($fileExt));

        $allowed=array('jpg','jpeg','png');

        if(in_array($fileactext,$allowed))
        {
            if($fileerror===0)
            {
                if($filesize<=1000000)
                {
                    
                    $filename="profile".$id."."."jpg";
                    $filedestination="uploads/".$filename;
                    move_uploaded_file($filetmpname,$filedestination);
                    $query="Update user_registration_table SET profilePic='1' WHERE primaryId ='$id'";
					$result = $con->query($query);

                    echo "<script>alert('Uploaded Successfully');</script>";
                    header("Location:userProfilePage.php");

                }
                else
                {
                    
                    echo "<script>alert('Photo size is big');</script>";
                    //header("Location:userProfilePage.php");
                }

            }
            else
            {
                echo "<script>alert('Error While uploading');</script>";
                //header("Location:userProfilePage.php");
            }
        }
        else
        {
           
            echo "<script>alert('Choose correct File format')</script>";

           //header("Location:userProfilePage.php");
        }
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		include_once("navbar.php");
	?>

	<meta charset="UTF-8">
	<title>User Profile Page</title>
	<style>
		select {width: 250px;}
		option {width: 250px;}
		.search{
			  width: 500px;
  			  box-sizing: border-box;
  			 	border: 2px solid #ccc;
			  border-radius: 4px;
			  font-size: 16px;
			  background-color: white;
			  background-position: 10px 10px; 
			  background-repeat: no-repeat;
			  padding: 12px 20px 12px 40px;
				}
	</style>
	<script>
		
		function $(id)
		{
			return document.getElementById(id);
		}

		function clicked()
		{
			let email=$("email").value;
			var xhttp=new XMLHttpRequest();
			if(email!=""){
			xhttp.onreadystatechange=function()
			{
				if(this.readyState==4&&this.status==200)
				{
					let res=$("res");
					$("res").innerHTML=render_data(JSON.parse(this.responseText));
					//console.log(JSON.parse(this.responseText));
					//console.log(render_data(JSON.parse(this.responseText)));
				}
			}
			xhttp.open("GET",`data.php?e=${email}`,true);
			xhttp.send();
		}
		else
		{
			$("res").innerHTML="";
		}
		}
		function render_data(data)
		{
    let htmlString = '';
    for (var i = 0; i < data.length; ++i) {
    	let src;
    	if(data[i].picstatus=="1")
    	{
    		src="uploads/profile"+data[i].id+".jpg";
    	}
    	else
    	{
    		src="uploads/default.png";
    	}
        htmlString += `<div style="padding: 10px; margin: 5px; background: #3eaad1; color: black";font-family:serif >
        	<img src=${src} width="45px" height="25px" align="left" style="border-radius:50%">
        	<a href="phpFiles/searchpeople.php?id=${data[i].id}&email=${data[i].email}"style = "text-decoration:none ;color:white"><b> ${data[i].email}</b> </a></div>`;

    }
    return htmlString;
}

	</script>
</head>
<body>
	<form action = "userProfilePage.php" method = "post" enctype="multipart/form-data">
	<div class = "searchSection" >

							<div class="search-box" align="center"><input type = "text" name = "SearchSomeOne_text" class="search" placeholder="Search By Email" id="email" onkeyup="clicked()" size="70"/>
							<br/>
							<div id="res" style="overflow:auto;height:120px;width:500px;color:black;margin-top:10px">
							</div>
							<br>
							<br><br>
						</div>
						
				
				<table  height = "700px" width="1200px" align="center">
					
					<tr>
						<td align="center" >Email :something@gmail.com <br/>
							Contact No<br/>
							FaceBook<br/>
							twitter
							<?php
								 echo "<br/>";
								echo "your Regirstered id is ".$_SESSION['primary_id'];
							?>
						</td>
						<td align="right" valign="top">
							
							
							
						</td>
						<td align="right">
							<?php

								$src;
								if($_SESSION["picstatus"]=='1')
								{
									$src="uploads/profile".$_SESSION["primary_id"]."."."jpg";
									$filetime=filemtime($src);
									$src=$src."?".$filetime;
								}
								else
								{
									$src="uploads/default.png";
								}
								//echo $src;
							?>
								
							<image src = <?php echo $src; ?> height = "250px" width = "250px" title = "profile picture name"/ alt="Profile Picture" style="border-radius: 50%">
							<br><br>
								<input type="file" name="file">
								<button type="submit" name="pic_submit">Upload</button>
							<br>
						</td>
					</tr>
					<tr>
						<td>
							<table>
					<tr>
						<td>Name :</td>
						<td>
							<?php

								
									$u_email =  $_SESSION['ue'];
									$con = new mysqli("localhost","root","ruhulamin","online_shomobay_shomity");
									if($con->connect_error){
										die("Error Connection");
									}
									$query = "SELECT userName From user_registration_table WHERE userEmail ='$u_email'";
									$result = $con->query($query);
									if($result->num_rows >0){
										while($row = $result->fetch_assoc()){
											echo $row["userName"];
											$_SESSION['uname'] = $row['userName'];
						
										}
									}
									else{
										echo "not connected";
									}

								?>

						</td>
					</tr>
					<tr>
						<td>Email:</td>
						<td>
							<?php
								
								echo  $_SESSION['ue'];
							?>
						</td>
					</tr>
					<tr>
						<td>Contact No :</td>
						<td>
							<?php
								$u_email =  $_SESSION['ue'];
									$con = new mysqli("localhost","root","ruhulamin","online_shomobay_shomity");
									if($con->connect_error){
										die("Error Connection");
									}
									$query = "SELECT Contact_No From user_registration_table WHERE userEmail ='$u_email'";
									$result = $con->query($query);
									if($result->num_rows >0){
										while($row = $result->fetch_assoc()){
											echo $row["Contact_No"];
										}
									}
									else{
										echo "not Included";
									}


							?>


						</td>
					</tr>
					<tr>
						<td>
							<b>Transactions:</b>
						</td>
						<td>----------</td>
					</tr>
					<tr>
						<td>Working Instute :</td>
						<td>------------</td>
					</tr>
					<tr>
						<td>Permanent Addiress:</td>
						<td>
							<?php
								$u_email =  $_SESSION['ue'];
									$con = new mysqli("localhost","root","ruhulamin","online_shomobay_shomity");
									if($con->connect_error){
										die("Error Connection");
									}
									$query = "SELECT Permanent_Address From user_registration_table WHERE userEmail ='$u_email'";
									$result = $con->query($query);
									if($result->num_rows >0){
										while($row = $result->fetch_assoc()){
											echo $row["Permanent_Address"];
										}
									}
									else{
										echo "not Included";
									}
							?>
						</td>
					</tr>
					<tr>
						<td>Sex :</td>
						<td>
							<?php
								$u_email =  $_SESSION['ue'];
									$con = new mysqli("localhost","root","ruhulamin","online_shomobay_shomity");
									if($con->connect_error){
										die("Error Connection");
									}
									$query = "SELECT Gender From user_registration_table WHERE userEmail ='$u_email'";
									$result = $con->query($query);
									if($result->num_rows >0){
										while($row = $result->fetch_assoc()){
											echo $row["Gender"];
										}
									}
									else{
										echo "not Included";
									}
							?>
						</td>
					</tr>
					<tr>
						<td>About You :</td>
						<td>------**------</td>
					</tr>
					<tr>
						<td>-------</td>
						<td>---------</td>
					</tr>
				</table>
				</td>
				<td>
					<table>
						<tr>
							<td align="center" colspan="3">
								Write A Post / Announcement :<br/>
								<p>

									<b>Group Name :</b>

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
								
								</p>
								<textarea name = "postContent" cols = "83" rows = "10" placeholder="whats on your mind ?">
								</textarea>
								<br/>
								<input type = "radio" name = "Admin" /> Admin
								<input type = "radio" name = "Admin" /> Member<br/>
								<?php
									include('phpFiles/postsContents.php');
								?>
								<input  type = "submit" value="Post" name = "submit_post"/>
							</td>
						</tr>
					</table>

				</td>
				<td align="center">
					<b>User Shomity Lists : </b>
					<p>
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
											$_SESSION["Group_All"]  = $parts_shomityName;
											//print_r($_SESSION["Group_All"]);
											for($i = 0;$i<count($parts_shomityName);$i++){
												echo "<b><i>".$parts_shomityName[$i]."</i></b><br/>";
											}

										}
										else echo "<h2>No Group Created</h2>";
						?>
						
					</p>

				</td>
			</tr>
			<tr>
			<td>
			<h2>
							create a Shomity:
						</h2>
								<table >
													<caption  >Create Group </caption>
													<tr>
														<td>
															Group Name :
														</td>
														<td>
															<?php
															// all the groups are concanated inside the validation  of a group
																include 'phpFiles/validationGroup.php';
															?>
															<input type = "text" name ="group_Name"/>
															
														</td>
													</tr>
													<tr>
														<td>
															Company Type :
														</td>
														<td>
															<select name ="CompanyType">
																<option></option>
																<option>School </option>
																<option>College </option>
																<option>University </option>
																<option>Any Organization </option>
																<option> Other </option>
															</select>
														</td>
													</tr>
													<tr>
														<td>
															Instute Name :
														</td>
														<td>
															<input type = "text" name = "group_InstuteName"/>
														</td>
													</tr>
													<tr>
														<td>Member Limitations :</td>
														<td>
															<input type = "text" name = "group_Limit"/>
														</td>
													</tr>
													<tr>
														<td>Creation Date</td>
														<td>
															<input type = "text" name ="creation_Date"/>
														</td>
													</tr>
													<tr>
														<td>
															Ending Date
														</td>
														<td>
															<input type = "text" name = "ending_Date" />
														</td>
													</tr>
													<tr>
														<td>First Lottery Date</td>
														<td>
															<input type = "text" name ="lottery_Date_text"/>
														</td>
													</tr>
													<tr>
														<td>President / Group Leader:</td>
														<td>
															<input type = "text" name ="PresidentName"/>
														</td>
													</tr>
													<tr>
														<td>
															Vice Precident:	
														</td>
														<td>
															<input type = "text" name ="Vice_presidentName"/>
														</td>
													</tr>
													
													<tr>
														<td>Round:</td>
														<td>
															<input type = "text" name ="num_of_Rounds"/>
														</td>
													</tr>
													
													<tr>
														<td>Money Amount</td>
														<td>
															<input type = "text" name ="Money_Amount"/>
														</td>
													</tr>
													<tr>
														<td>Fine For Late fees</td>
														<td>
															<input type = "text" name ="Fine_Amount"/>
														</td>
													</tr>
													
													<tr>
														<td>Group Rules and Regulations:</td>
														<td>
															<input type = "text" name ="Group_Details"/>
														</td>
													</tr>
													<tr>
														<td></td>
														<td align="right">
															<input  type = "submit" name = "group_InfoButton"/>
														</td>
													</tr>
													
												</table >		
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>
				<h3>Delete a Shomity</h3>
			</td>
			<td>
				<input type = "text" size = "50" name = "Delete_shomity_textBox"/>
				<br/><input title ="you cant delete a running shomity Be careful!" value = "Delete Shomity" type = "submit" name = "button_Delete_shomity"/>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>
				<h3>
				
				</h3>
			</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td valign="top">
				<h3>
					Complaine and suggation: 
				</h3>
			</td>
			<td>
				<input type = "text"  size = "50" name = "cs_textbox"/><br/>
				<input type = "radio" name = "complaine"/>Complaine
				<input type = "radio" name = "suggations"/>Suggations<br/>
				<?php
					include('phpFiles/complaneAndSuggationsPostsByUser.php');
				?>
				<input type = "submit" value = "Submit" name = "submit_cs"/>
			</td>
			<td></td>
		</tr>
		<?php include('phpFiles/postShowing.php');?>		
		</table>
		
	</form>
	
</body>
</html>