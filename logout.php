<?php
	session_start();
	if(isset($_SESSION['ue']))
	{
		session_unset();
		session_destroy();
	}
	header("Location:firstPage.php");
?>