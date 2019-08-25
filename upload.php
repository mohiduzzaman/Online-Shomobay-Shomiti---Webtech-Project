	<?php
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
	?>


<?php
	session_start();
	//echo "aschi";
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
                    $_SESSION["floc"]=1;
                    echo "success message";
                    //header("Location:userProfilePage.php");

                }
                else
                {
                    $_SESSION["floc"]=0;
                    echo "file size too big";
                    //header("Location:userProfilePage.php");
                }

            }
            else
            {
                $_SESSION["floc"]=0;
                $_SESSION["ferror"]=2;
                //header("Location:userProfilePage.php");
            }
        }
        else
        {
            $_SESSION["floc"]=0;
            $_SESSION["ferror"]=1;
           //header("Location:userProfilePage.php");
        }
	}
?>