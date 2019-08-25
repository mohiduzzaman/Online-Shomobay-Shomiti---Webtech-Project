
<?php
	if(isset($_POST['txt']) && isset($_POST['btn'])){
		echo "i am hit";

	}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>text inserting</title>
</head>
<body>
	<form action = "demoPractise.php" method="post">
		<input type = 'text' value = <?php $_POST['text'] ?> name = 'txt'/>;
		<?php
			
			echo "<input type = 'submit' value = 'HIT' name = 'btn'>";
		?>

	</form>
</body>
</html>