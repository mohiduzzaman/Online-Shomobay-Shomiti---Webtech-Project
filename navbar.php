<?php
	if(isset($_SESSION['ue']))
	{

	}
	else
	{
		header("Location:logout.php");
	}
?>
<html>
	<head>
		<style>
			body{
				background: black;
				color:white;
				}
			.navbar ul {
			  list-style-type: none;
			  margin: 0;
			  padding: 0;
			  overflow: hidden;
			  background-color: #333;
			}

			.navbar li {
			  float: left;
			}

			.navbar li a {
			  display: block;
			  color: white;
			  text-align: center;
			  padding: 14px 16px;
			  text-decoration: none;
			}

			.navbar li a:hover {
			  background-color: green;
			};
			.navbar li a:.active {
			 background-color: green;
			}
		</style>
	</head>
	<body>
		<div class="navbar" style="margin-bottom: 10px">
			<ul>
			<li>
				<a href =  "userProfilePage.php" title = "view all the hit posts">Home</a>
			</li>
			<li>
				<a href = "Friends.php">Friends</a>
			</li>
			<li> 
				<a href = "Transactions.php">Transactions</a>
			</li>
			<li>
				<?php
				 if($_SESSION['ue'] == "alfaBinomialbeta23@gmail.com"){
				 
				 	echo "<a href = 'SystemManager.php'>System Manager</a>";
				 }
				?>
				
			</li>
			<li>
				<a href = "onlinePayment.php">Online Payment</a>
			</li>
			<li>
				<a href ="Lotttry.php"> Lottery</a>
			</li>
			<li title="logout"><a href="logout.php">Logout</a></li>

		</ul>
	</div>
	</body>
</html>