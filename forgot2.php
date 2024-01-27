<?php
include('dbConn.php');

if(isset($_POST["email"]) && (!empty($_POST["email"]))){
$email = $_POST["email"];
$pwd = mysqli_query($dbConn, "SELECT 'password' FROM `users` WHERE email='".$email);


    if(isset($_POST['Reset'])){
        echo'<form action="forgot2.php" method="post"><input type="text"></input><input type="submit" value="ResetPass"></input></form>';
    }

    if(isset($_POST['Request'])) { 
        $alert = "your password is $pwd";
        echo '<script type ="text/javascript">alert("$alert");</script>';
        sleep(1);
        header('Location: main.php');
        die();
        // something like this is way more secure but this isn't an actual product
        // if(mysqli_num_rows($checkExistance) != null && $checkExistance){
        //     echo "Sending instructions to " + $email;
        //     mail($email,"Your password is", $pwd);
        //     }
    }

    if(isset($_POST['resetPass'])){
        mysqli_query($dbConn, "UPDATE `users` SET `pwd` = $pwd WHERE `email` = $email");
        echo '<script type ="text/javascript">alert("Password succesfully updated!");</script>';
        sleep(1);
        header('Location: main.php');
        die();
    }
}
