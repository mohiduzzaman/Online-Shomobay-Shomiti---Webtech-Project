<?php
	if(isset($_GET['e']))
	{
		$Email=$_GET['e'];
		$conn=mysqli_connect("localhost","root","ruhulamin","online_shomobay_shomity");
		$query = "SELECT *From user_registration_table WHERE userEmail like '%{$Email}%'";

		$result=mysqli_query($conn,$query);
		$crow=$result->num_rows;
		$testjson=array();
		if($crow>0)
		{
			while($row=mysqli_fetch_array($result))
			{
				$testjson[]=array(
					"id"=>$row["primaryId"],
					"email"=>$row["userEmail"],
					"picstatus"=>$row["profilePic"]
				);
			}
			echo json_encode($testjson);
		}
	}