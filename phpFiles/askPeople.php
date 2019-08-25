<?php
	if(isset($_POST['search_SomeOne_btn']) && isset($_POST['SearchSomeOne_text'])){
		$uEmail = $_POST['SearchSomeOne_text'];
		$con = new mysqli("localhost","root","ruhulamin","online_shomobay_shomity");
		if($con->connect_error){die("Error Connection");}
			$query = "SELECT userEmail From user_registration_table WHERE userEmail like '%$uEmail%'";
			$result = $con->query($query);
				if($result->num_rows >0){
						while($row = $result->fetch_assoc()){
								echo $row["userEmail"];
								$_SESSION['mail'] = $row['userEmail'];
					}
					sleep(0.5);
					include('phpFiles/searchpeople.php');
					echo "<script>window.open('phpFiles/searchpeople.php','_self')</script>";
				}
			else echo"<script>alert('There is no registered like $uEmail!')</script>";
	}


?>
