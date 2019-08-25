<?php
$databaseConnection = true;
	$userName = $_SESSION['uname'];
	$con  = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
	if(isset($_POST['shomitysNameSelector']) && isset($_POST['submit_post']) && isset($_POST['postContent'])){
		$grpName = $_POST['shomitysNameSelector'];
		$content = trim($_POST['postContent']);
		if(empty($grpName)){
			$databaseConnection = false;
			echo "<script>alert('You Must Select a Group First')</script>";
		}
		if(strlen($content)<=3){
			$databaseConnection = false;
			//echo $content;
			echo "<script>alert('atleast 4 charecters need to be written ..')</script>";
		}
	}
	//echo $databaseConnection;
	if($databaseConnection == true){
		if(isset($_POST['submit_post'])){
			$uid = $_SESSION['primary_id'];
			$insert = "INSERT INTO posts_table(user_id,post_Content,groupName,whoPost)VALUES('$uid','$content','$grpName','$userName')";
			$run = mysqli_query($con,$insert);
			if($run){
					echo "<script>alert('Your Posts is updated successfully!!')</script>";
			}
			if(!$run)echo "database is not connected";	
		}
	}
		
?>
