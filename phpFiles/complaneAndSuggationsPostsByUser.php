<?php
		$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
		if(isset($_POST['submit_cs'])){
			$u_Text = mysql_real_escape_string($_POST['cs_textbox']);
		$mail = $_SESSION['ue'];
		$sql = "INSERT INTO complaneandsuggations (userEmail,CS)VALUES('$mail','$u_Text')";
			 $query =  mysqli_query($con,$sql);
			 if($query){ 
			 	echo "<script>alert('complane is submitted!')</script>";
			 }
			 if(!$query){
			 	 echo "<script>alert('Error Generated check database connection!')</script>";
			 }
		}
?>