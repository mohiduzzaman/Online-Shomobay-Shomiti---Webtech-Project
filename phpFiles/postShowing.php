<?php
$parts;
	$con = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity") or die("<script>alert('database is not connected')</script>");
	$con1  = mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
	$query1 = "select Group_Names from group_table where group_CreatorId = '$userId'";
	$result1 = $con->query($query1);
		
		if($result1->num_rows == 0){
		echo "<h3>No Group Created</h3>";
	}
	if($result1->num_rows >0){
		$hst;
		while($row = $result1->fetch_assoc()){
			$hst = $row["Group_Names"];
		}
		$parts = explode('/',$hst);
		if(count($parts)>0){
			$userid = $_SESSION['primary_id'];
			echo "<table border = '1px' align = 'center'>";
			for($i = 0;$i<count($parts);$i++){
				$group = $parts[$i];
				echo "<tr>";
				echo "<td><h2>".$group."</h2></td>";
					echo "<td>";
					$query1="SELECT * FROM posts_table where user_id = '$userid' and groupName = '$group'";
					$result1 = mysqli_query($con,$query1);
					while($row = mysqli_fetch_array($result1)){
						$post_content = $row['post_Content'];
						$poster = $row['whoPost'];
						echo "<b>"."From : ".$poster."</b>";
						echo "<h3>".$post_content."</h3>"."<br/>";
						
					}
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		}
	}
	
?>
