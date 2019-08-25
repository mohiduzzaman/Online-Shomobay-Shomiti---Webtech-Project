
<?php
if(isset($_GET['e'])){
            $q = $_GET['e'];

        $con = mysqli_connect('localhost','root','ruhulamin','online_shomobay_shomity');
        if (!$con) {
            die('Could not connect: ' . mysqli_error($con));
        }

        $sql="SELECT * FROM user_registration_table where userEmail like '%{$q}%'";
        //$query="SELECT * FROM CHAT WHERE user LIKE '%{$name}%'";
        $result = mysqli_query($con,$sql);
        $arr=array();
        while($row = mysqli_fetch_array($result)) {
            /*
            echo "<tr>";
            echo "<td>" . $row['userName'] . "</td>";
            echo "<td>" . $row['userEmail'] . "</td>";
            echo "<td>" . $row['Contact_No'] . "</td>";
            echo "<td>" . $row['Profession'] . "</td>";
            echo "</tr>";*/
            $arr[]=array("userName"=> $row["userName"],"userEmail"=>$row["userEmail"],
                        "Contact_No"=>$row["Contact_No"],"Profession"=>$row["Profession"],"dob"=>$row["DateOfBirth"]
                    );
        }
        echo json_encode($arr);
        mysqli_close($con);
    
}

?>
